<?php
// App/Controllers/UpdateRecords.php
namespace App\Controllers;

use App\Models\RecordsModel;
use App\Models\ServiceModel;

class UpdateRecords extends BaseController
{
    protected RecordsModel $recordsModel;
    protected ServiceModel $serviceModel;

    public function __construct()
    {
        $this->recordsModel = new RecordsModel();
        $this->serviceModel = new ServiceModel();
    }

    public function update_records()
    {
        $id = $this->request->getPost('id');

        if (!$id) {
            return redirect()->back()->with('error', 'Invalid record ID.');
        }

        // ==============================
        // ✅ 1) DUPLICATE EMPLOYEE CHECK
        // ==============================
        $firstName  = strtolower(trim((string) $this->request->getPost('first_name')));
        $middleName = strtolower(trim((string) $this->request->getPost('middle_name')));
        $lastName   = strtolower(trim((string) $this->request->getPost('last_name')));
        $extensions = strtolower(trim((string) $this->request->getPost('extensions')));

        $middleName = $middleName ?: '';
        $extensions = $extensions ?: '';

        $existing = $this->recordsModel
            ->where('LOWER(first_name)', $firstName)
            ->where('LOWER(middle_name)', $middleName)
            ->where('LOWER(last_name)', $lastName)
            ->where('LOWER(extensions)', $extensions)
            ->where('id !=', $id)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Employee is already registered.');
        }

        // ==============================
        // ✅ 2) EMPLOYEE UPDATE DATA
        // ==============================
        $employeeData = [
            'last_name'              => trim((string) $this->request->getPost('last_name')),
            'first_name'             => trim((string) $this->request->getPost('first_name')),
            'middle_name'            => trim((string) $this->request->getPost('middle_name')),
            'extensions'             => trim((string) $this->request->getPost('extensions')),
            'birthdate'              => $this->request->getPost('birthdate'),
            'gender'                 => $this->request->getPost('gender'),
            'educational_attainment' => trim((string) $this->request->getPost('educational_attainment')),
            'eligibility'            => trim((string) $this->request->getPost('eligibility')),
            'remarks'                => trim((string) $this->request->getPost('remarks')),
        ];

        // ==============================
        // ✅ 3) SERVICE ARRAYS (dynamic rows)
        // ==============================
        $departments  = (array) $this->request->getPost('department');
        $designations = (array) $this->request->getPost('designation');
        $rates        = (array) $this->request->getPost('rate');
        $appoints     = (array) $this->request->getPost('date_of_appointment');
        $statuses     = (array) $this->request->getPost('status');
        $endeds       = (array) $this->request->getPost('date_ended');        // hidden date_ended[]
        $durations    = (array) $this->request->getPost('service_duration');

        // helper to trim arrays safely
        $cleanArr = function (array $arr): array {
            return array_map(function ($v) {
                if (is_array($v)) return '';
                return trim((string) $v);
            }, $arr);
        };

        $departments  = $cleanArr($departments);
        $designations = $cleanArr($designations);
        $rates        = $cleanArr($rates);
        $appoints     = $cleanArr($appoints);
        $statuses     = $cleanArr($statuses);
        $endeds       = $cleanArr($endeds);
        $durations    = $cleanArr($durations);

        // include ALL arrays in max so row alignment is correct
        $max = max(
            count($departments),
            count($designations),
            count($rates),
            count($appoints),
            count($statuses),
            count($endeds),
            count($durations),
            1
        );

        $db = \Config\Database::connect();

        try {
            // ✅ update employee basic info first
            $this->recordsModel->update($id, $employeeData);

            // ✅ update services (replace all rows) inside transaction
            $db->transStart();

            // delete old service rows
            $this->serviceModel->where('employee_id', $id)->delete();

            for ($i = 0; $i < $max; $i++) {
                $dept    = $departments[$i]  ?? '';
                $desig   = $designations[$i] ?? '';
                $rate    = $rates[$i]        ?? '';
                $appoint = $appoints[$i]     ?? '';
                $status  = $statuses[$i]     ?? 'Employed';
                $ended   = $endeds[$i]       ?? '';
                $dur     = $durations[$i]    ?? '';

                // Skip totally empty rows
                if ($dept === '' && $desig === '' && $appoint === '' && $rate === '') {
                    continue;
                }

                // Default status
                if ($status === '') $status = 'Employed';

                // ✅ rules
                if ($status === 'Employed') {
                    $ended = '0000-00-00';
                    $durToSave = null;
                } else {
                    // Terminated / Resigned must have ended date
                    if ($ended === '' || $ended === '0000-00-00') {
                        $db->transRollback();
                        return redirect()->back()
                            ->withInput()
                            ->with('error', 'Date Ended is required for Terminated/Resigned rows.');
                    }

                    // save duration only if meaningful
                    $durLower = strtolower($dur);
                    $durToSave = ($dur !== '' && $durLower !== 'currently working' && $durLower !== 'waiting for end date')
                        ? $dur
                        : null;
                }

                $this->serviceModel->insert([
                    'employee_id'         => $id,
                    'department'          => $dept,
                    'designation'         => $desig,
                    'rate'                => $rate,   // ✅ ADDED (fix)
                    'date_of_appointment' => $appoint,
                    'status'              => $status,
                    'date_ended'          => $ended,
                    'service_duration'    => $durToSave,
                ]);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->back()->with('error', 'Failed to update service records.');
            }

            return redirect()->back()->with('success', 'Record updated successfully.');
        } catch (\Throwable $e) {
            // If something throws while transaction is open, rollback safely
            if ($db->transStatus() !== false) {
                try {
                    $db->transRollback();
                } catch (\Throwable $ignored) {
                }
            }

            return redirect()->back()->with('error', 'Failed to update record: ' . $e->getMessage());
        }
    }
}


