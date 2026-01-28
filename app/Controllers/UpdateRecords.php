<?php

namespace App\Controllers;

use App\Models\RecordsModel;

class UpdateRecords extends BaseController
{
    protected $recordsModel;

    public function __construct()
    {
        $this->recordsModel = new RecordsModel();
    }

    public function update_records()
    {
        $id = $this->request->getPost('id');

        if (!$id) {
            return redirect()->back()->with('error', 'Invalid record ID.');
        }

        $data = [
            'last_name' => $this->request->getPost('last_name'),
            'first_name' => $this->request->getPost('first_name'),
            'middle_name' => $this->request->getPost('middle_name'),
            'extensions' => $this->request->getPost('extensions'),
            'birthdate' => $this->request->getPost('birthdate'),
            'gender' => $this->request->getPost('gender'),
            'department' => $this->request->getPost('department'),
            'educational_attainment' => $this->request->getPost('educational_attainment'),
            'designation' => $this->request->getPost('designation'),
            'rate' => $this->request->getPost('rate'),
            'eligibility' => $this->request->getPost('eligibility'),
            'date_of_appointment' => $this->request->getPost('date_of_appointment'),
            'service_duration' => $this->request->getPost('service_duration'),
            'remarks' => $this->request->getPost('remarks')
        ];

        try {
            $this->recordsModel->update($id, $data);
            return redirect()->back()->with('success', 'Record updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update record: ' . $e->getMessage());
        }
    }
}
