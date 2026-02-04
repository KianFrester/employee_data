<?php

namespace App\Controllers;

use App\Models\RecordsModel;

class SearchRecords extends BaseController
{
    public function search_records()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/')->with('error', 'You must log in first.');
        }

        $recordsModel = new RecordsModel();
        $employees = $recordsModel->getEmployeesWithServices();

        $data['records'] = [];

        foreach ($employees as $emp) {
            $data['records'][] = [
                'id' => $emp['id'],
                'last_name' => $emp['last_name'],
                'first_name' => $emp['first_name'],
                'middle_name' => $emp['middle_name'],
                'extensions' => $emp['extensions'],
                'birthdate' => $emp['birthdate'],
                'gender' => $emp['gender'],

                // ✅ MUST match VIEW + JS keys
                'departments'  => $emp['departments'] ?? '',
                'designations' => $emp['designations'] ?? '',
                'rates'        => $emp['rates'] ?? '',
                'dates'        => $emp['dates'] ?? '',
                'statuses'     => $emp['statuses'] ?? '',
                'date_ended'   => $emp['date_ended'] ?? '',
                'service_duration' => $emp['service_duration'] ?? '',

                // ✅ REQUIRED for correct update per service row
                'service_ids'  => $emp['service_ids'] ?? '',

                'educational_attainment' => $emp['educational_attainment'],
                'eligibility' => $emp['eligibility'],
                'remarks' => $emp['remarks'],
            ];
        }

        return view('pages/search_records', $data);
    }
}
