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
        $firstName  = trim($this->request->getPost('first_name'));
        $middleName = trim($this->request->getPost('middle_name'));
        $lastName   = trim($this->request->getPost('last_name'));
        $extensions = trim($this->request->getPost('extensions'));

        // 🔹 Check if the employee already exists
        $existing = $recordsModel->where([
            'first_name'  => $firstName,
            'middle_name' => $middleName,
            'last_name'   => $lastName,
            'extensions'  => $extensions
        ])->first();

        if ($existing) {
            // Employee already exists
            return redirect()->back()->withInput()->with('error', 'Employee is already registered.');
        }

        $employeeData = [
            'first_name'  => $firstName,
            'middle_name' => $middleName,
            'last_name'   => $lastName,
            'extensions'  => $extensions,
            'birthdate'   => $this->request->getPost('birthdate'),
            'gender'      => $this->request->getPost('gender'),
            'rate'        => trim($this->request->getPost('rate')),
            'educational_attainment' => trim($this->request->getPost('educational_attainment')),
            'eligibility' => trim($this->request->getPost('eligibility')),
            'remarks'     => trim($this->request->getPost('remarks')),
        ];

        // 🔹 Insert employee
        $recordsModel->insert($employeeData);
        $employeeId = $recordsModel->getInsertID(); // This ID will link to service records

        // ================= SERVICE RECORDS =================
        $departments  = $this->request->getPost('department');        
        $designations = $this->request->getPost('designation');       
        $dates        = $this->request->getPost('date_of_appointment'); 
        $statuses     = $this->request->getPost('status');            

        $serviceData = [];

        foreach ($departments as $i => $dept) {
            if (!empty($dept)) {
                $serviceData[] = [
                    'employee_id'         => $employeeId,  
                    'first_name'          => $firstName,
                    'middle_name'         => $middleName,
                    'last_name'           => $lastName,
                    'extensions'          => $extensions,
                    'department'          => $dept,
                    'designation'         => $designations[$i] ?? '',
                    'date_of_appointment' => $dates[$i] ?? null,
                    'status'              => $statuses[$i] ?? ''
                ];
            }
        }

        if (!empty($serviceData)) {
            $serviceModel->insertBatch($serviceData); // Insert multiple service records
        }

        return redirect()->to('/create')
            ->with('success', 'Employee and service records saved successfully.');
    }
}
