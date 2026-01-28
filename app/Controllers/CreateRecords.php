<?php

namespace App\Controllers;

class CreateRecords extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/')->with('error', 'You must log in first.');
        }

        return view('/pages/register');
    }

    public function create_records()
    {

        $recordsModel = new \App\Models\RecordsModel();

        $data = [
            'first_name'             => trim($this->request->getPost('first_name')),
            'middle_name'            => trim($this->request->getPost('middle_name')),
            'last_name'              => trim($this->request->getPost('last_name')),
            'extensions'             => trim($this->request->getPost('extensions')),
            'birthdate'              => $this->request->getPost('birthdate'),
            'gender'                 => $this->request->getPost('gender'),
            'department'             => trim($this->request->getPost('department')),
            'designation'            => trim($this->request->getPost('designation')),
            'rate'                   => trim($this->request->getPost('rate')),
            'educational_attainment' => trim($this->request->getPost('educational_attainment')),
            'eligibility'            => trim($this->request->getPost('eligibility')),
            'date_of_appointment'    => $this->request->getPost('date_of_appointment'),
            'service_duration'       => trim($this->request->getPost('service_duration')),
            'status'                 => trim($this->request->getPost('status')),
            'remarks'                => trim($this->request->getPost('remarks')),
        ];

        // 🔍 CHECK IF RECORD ALREADY EXISTS
        $existing = $recordsModel
            ->where('first_name', $data['first_name'])
            ->where('last_name', $data['last_name'])
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'This employee record already exists.');
        }

        // INSERT
        if ($recordsModel->insert($data)) {
            return redirect()->to('/create')
                ->with('success', 'Record successfully created.');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to create record.');
    }
}
