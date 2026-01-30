<?php

namespace App\Controllers;

use App\Models\RecordsModel;
use App\Models\ServiceModel;

class CreateRecords extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/')->with('error', 'You must log in first.');
        }

        return view('pages/register');
    }

    public function create_records()
    {
        $recordsModel = new RecordsModel();
        $serviceModel = new ServiceModel();

        // ================= EMPLOYEE DATA =================
        $firstName  = trim((string)$this->request->getPost('first_name'));
        $middleName = trim((string)$this->request->getPost('middle_name'));
        $lastName   = trim((string)$this->request->getPost('last_name'));
        $extensions = trim((string)$this->request->getPost('extensions'));

        // 🔹 Check if employee already exists (exact match)
        $existing = $recordsModel->where([
            'first_name'  => $firstName,
            'middle_name' => $middleName,
            'last_name'   => $lastName,
            'extensions'  => $extensions
        ])->first();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Employee is already registered.');
        }

        // ✅ rate removed here (rate belongs to service_records)
        $employeeData = [
            'first_name'             => $firstName,
            'middle_name'            => $middleName,
            'last_name'              => $lastName,
            'extensions'             => $extensions,
            'birthdate'              => $this->request->getPost('birthdate'),
            'gender'                 => $this->request->getPost('gender'),
            'educational_attainment' => trim((string)$this->request->getPost('educational_attainment')),
            'eligibility'            => trim((string)$this->request->getPost('eligibility')),
            'remarks'                => trim((string)$this->request->getPost('remarks')),
        ];

        // Insert employee
        $recordsModel->insert($employeeData);
        $employeeId = $recordsModel->getInsertID();

        // ================= SERVICE RECORDS =================
        $departments  = $this->request->getPost('department') ?? [];
        $designations = $this->request->getPost('designation') ?? [];
        $rates        = $this->request->getPost('rate') ?? [];
        $dates        = $this->request->getPost('date_of_appointment') ?? [];
        $statuses     = $this->request->getPost('status') ?? [];
        $endedDates   = $this->request->getPost('date_ended') ?? [];
        $durations    = $this->request->getPost('service_duration') ?? [];

        // Normalize in case one item is submitted not as array
        if (!is_array($departments))  $departments  = [$departments];
        if (!is_array($designations)) $designations = [$designations];
        if (!is_array($rates))        $rates        = [$rates];
        if (!is_array($dates))        $dates        = [$dates];
        if (!is_array($statuses))     $statuses     = [$statuses];
        if (!is_array($endedDates))   $endedDates   = [$endedDates];
        if (!is_array($durations))    $durations    = [$durations];

        $serviceData = [];

        foreach ($departments as $i => $dept) {
            $dept   = trim((string)$dept);
            $desig  = trim((string)($designations[$i] ?? ''));
            $rate   = trim((string)($rates[$i] ?? ''));
            $appoint = trim((string)($dates[$i] ?? ''));
            $status = trim((string)($statuses[$i] ?? ''));
            $ended  = trim((string)($endedDates[$i] ?? ''));
            $dur    = $durations[$i] ?? null;

            // Skip fully empty row (in case of extra clone)
            if ($dept === '' && $desig === '' && $rate === '' && $appoint === '' && $status === '') {
                continue;
            }

            // ✅ Required service fields
            if ($dept === '' || $desig === '' || $rate === '' || $appoint === '' || $status === '') {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Please complete Department, Designation, Rate, Date of Appointment, and Status for every service record.');
            }

            // ✅ Apply your Date Ended rules
            if ($status === 'Employed') {
                // store as zero-date (as you requested)
                $dateEndedToSave = '0000-00-00';

                // Employed => duration saved NULL (UI can show "Currently Working")
                $durToSave = null;
            } elseif ($status === 'Terminated' || $status === 'Resigned/Retired') {

                // must have ended date and cannot be zero-date
                if ($ended === '' || $ended === '0000-00-00') {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Date Ended is required for Terminated or Resigned/Retired employees.');
                }

                // accept date OR datetime-local
                // datetime-local: 2026-01-01T13:30 -> 2026-01-01 13:30:00
                if (strpos($ended, 'T') !== false) {
                    $dateEndedToSave = str_replace('T', ' ', $ended) . ':00';
                } else {
                    // date only: 2026-01-01
                    $dateEndedToSave = $ended;
                }

                $durToSave = $dur ?: null;
            } else {
                // unknown status
                $dateEndedToSave = null;
                $durToSave = null;
            }

            $serviceData[] = [
                'employee_id'         => $employeeId,
                'department'          => $dept,
                'designation'         => $desig,
                'rate'                => $rate,
                'date_of_appointment' => $appoint,
                'status'              => $status,
                'date_ended'          => $dateEndedToSave,
                'service_duration'    => $durToSave,
            ];
        }

        if (!empty($serviceData)) {
            $serviceModel->insertBatch($serviceData);
        } else {
            // no service rows at all
            return redirect()->back()
                ->withInput()
                ->with('error', 'Please add at least one service record.');
        }

        return redirect()->to('/create')
            ->with('success', 'Employee and service records saved successfully.');
    }
}
