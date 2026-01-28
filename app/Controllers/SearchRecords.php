<?php

namespace App\Controllers;

class SearchRecords extends BaseController
{
    public function search_records()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/')->with('error', 'You must log in first.');
        }
        $recordsModel = new \App\Models\RecordsModel();

        // 🔹 Fetch all records
        $data['records'] = $recordsModel
            ->orderBy('last_name', 'ASC')
            ->findAll();

        return view('pages/search_records', $data);
    }
}
