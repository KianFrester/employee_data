<?php

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

        // ✅ duplicate employee check
        $firstName  = strtolower(trim((string)$this->request->getPost('first_name')));
        $middleName = strtolower(trim((string)$this->request->getPost('middle_name'))) ?: '';
        $lastName   = strtolower(trim((string)$this->request->getPost('last_name')));
        $extensions = strtolower(trim((string)$this->request->getPost('extensions'))) ?: '';

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

        // ✅ employee update payload
        $employeeData = [
            'last_name'              => trim((string)$this->request->getPost('last_name')),
            'first_name'             => trim((string)$this->request->getPost('first_name')),
            'middle_name'            => trim((string)$this->request->getPost('middle_name')),
            'extensions'             => trim((string)$this->request->getPost('extensions')),
            'birthdate'              => $this->request->getPost('birthdate'),
            'gender'                 => $this->request->getPost('gender'),
            'educational_attainment' => trim((string)$this->request->getPost('educational_attainment')),
            'eligibility'            => trim((string)$this->request->getPost('eligibility')),
            'remarks'                => trim((string)$this->request->getPost('remarks')),
        ];

        // ✅ service arrays
        $serviceIds   = (array)$this->request->getPost('service_id');
        $departments  = (array)$this->request->getPost('department');
        $designations = (array)$this->request->getPost('designation');
        $rates        = (array)$this->request->getPost('rate');
        $appoints     = (array)$this->request->getPost('date_of_appointment');
        $statuses     = (array)$this->request->getPost('status');
        $endeds       = (array)$this->request->getPost('date_ended');
        $durations    = (array)$this->request->getPost('service_duration');

        $cleanArr = function (array $arr): array {
            return array_map(fn($v) => is_array($v) ? '' : trim((string)$v), $arr);
        };

        $serviceIds   = $cleanArr($serviceIds);
        $departments  = $cleanArr($departments);
        $designations = $cleanArr($designations);
        $rates        = $cleanArr($rates);
        $appoints     = $cleanArr($appoints);
        $statuses     = $cleanArr($statuses);
        $endeds       = $cleanArr($endeds);
        $durations    = $cleanArr($durations);

        $max = max(
            count($serviceIds),
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
            $db->transStart();

            // ✅ update employee
            $this->recordsModel->update($id, $employeeData);

            $keptIds = [];

            for ($i = 0; $i < $max; $i++) {
                $sid     = $serviceIds[$i]   ?? '';
                $dept    = $departments[$i]  ?? '';
                $desig   = $designations[$i] ?? '';
                $rate    = $rates[$i]        ?? '';
                $appoint = $appoints[$i]     ?? '';
                $status  = $statuses[$i]     ?? 'Employed';
                $ended   = $endeds[$i]       ?? '';
                $dur     = $durations[$i]    ?? '';

                // ✅ skip empty row
                if ($dept === '' && $desig === '' && $appoint === '' && $rate === '') {
                    continue;
                }

                // ✅ business rules
                if ($status === 'Employed') {
                    $ended = null;
                    $durToSave = null;
                } else {
                    if ($ended === '' || $ended === '0000-00-00') {
                        $db->transRollback();
                        return redirect()->back()
                            ->withInput()
                            ->with('error', 'Date Ended is required for Terminated/Resigned rows.');
                    }

                    $durLower = strtolower($dur);
                    $durToSave = ($dur !== '' && $durLower !== 'currently working' && $durLower !== 'waiting for end date')
                        ? $dur
                        : null;
                }

                $payload = [
                    'employee_id'         => $id,
                    'department'          => $dept,
                    'designation'         => $desig,
                    'rate'                => $rate,
                    'date_of_appointment' => $appoint,
                    'status'              => $status,
                    'date_ended'          => $ended,
                    'service_duration'    => $durToSave,
                ];

                if ($sid !== '') {
                    $this->serviceModel->update((int)$sid, $payload);
                    $keptIds[] = (int)$sid;
                } else {
                    $newId = $this->serviceModel->insert($payload, true);
                    $keptIds[] = (int)$newId;
                }
            }

            // ✅ delete removed services
            if (!empty($keptIds)) {
                $this->serviceModel
                    ->where('employee_id', $id)
                    ->whereNotIn('id', $keptIds)
                    ->delete();
            } else {
                $this->serviceModel->where('employee_id', $id)->delete();
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->back()->with('error', 'Failed to update record.');
            }

            return redirect()->back()->with('success', 'Record updated successfully.');
        } catch (\Throwable $e) {
            try {
                $db->transRollback();
            } catch (\Throwable $ignored) {
            }
            return redirect()->back()->with('error', 'Failed to update record: ' . $e->getMessage());
        }
    }
}
