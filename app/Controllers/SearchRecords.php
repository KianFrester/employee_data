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
                'department' => $emp['departments'] ?? '',
                'designation' => $emp['designations'] ?? '',

                // ✅ RATE NOW COMES FROM SERVICE TABLE GROUP_CONCAT
                'rate' => $emp['rates'] ?? '',

                'educational_attainment' => $emp['educational_attainment'],
                'eligibility' => $emp['eligibility'],
                'date_of_appointment' => $emp['dates'] ?? '',
                'status' => $emp['statuses'] ?? '',
                'date_ended' => $emp['date_ended'] ?? '',
                'remarks' => $emp['remarks']
            ];
        }


        return view('pages/search_records', $data);
    }
}
