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
    $employeeData = [
        'first_name'  => trim($this->request->getPost('first_name')),
        'middle_name' => trim($this->request->getPost('middle_name')),
        'last_name'   => trim($this->request->getPost('last_name')),
        'extensions'  => trim($this->request->getPost('extensions')),
        'birthdate'   => $this->request->getPost('birthdate'),
        'gender'      => $this->request->getPost('gender'),
        'rate'        => trim($this->request->getPost('rate')),
        'educational_attainment' => trim($this->request->getPost('educational_attainment')),
        'eligibility' => trim($this->request->getPost('eligibility')),
        'remarks'     => trim($this->request->getPost('remarks')),
    ];

    // 🔹 Insert employee
    $recordsModel->insert($employeeData);
    $employeeId = $recordsModel->getInsertID(); // This is the ID all service records should reference

    // ================= SERVICE RECORDS =================
    $departments  = $this->request->getPost('department');        // array
    $designations = $this->request->getPost('designation');       // array
    $dates        = $this->request->getPost('date_of_appointment'); // array
    $statuses     = $this->request->getPost('status');            // array

    $serviceData = [];

    foreach ($departments as $i => $dept) {
        if (!empty($dept)) {
            $serviceData[] = [
                'employee_id'        => $employeeId,  // ✅ assign the same employee ID for all rows
                'first_name'         => $employeeData['first_name'],
                'middle_name'        => $employeeData['middle_name'],
                'last_name'          => $employeeData['last_name'],
                'extensions'         => $employeeData['extensions'],
                'department'         => $dept,
                'designation'        => $designations[$i] ?? '',
                'date_of_appointment'=> $dates[$i] ?? null,
                'status'             => $statuses[$i] ?? ''
            ];
        }
    }

    if (!empty($serviceData)) {
        $serviceModel->insertBatch($serviceData); // ✅ multiple records inserted with same employee_id
    }

    return redirect()->to('/create')
        ->with('success', 'Employee and service records saved successfully.');
}

}
