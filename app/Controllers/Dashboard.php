<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function dashboard()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/')->with('error', 'You must log in first.');
        }
        $username = $session->get('username');

        $recordsModel = new \App\Models\RecordsModel();

        // Gender counts
        $maleCount = $recordsModel->where('gender', 'Male')->countAllResults();
        $femaleCount = $recordsModel->where('gender', 'Female')->countAllResults();
        $gender_records = $recordsModel->orderBy('last_name', 'ASC')->findAll();

        // eligibility counts
        $eligibility_records = $recordsModel->orderBy('last_name', 'ASC')->findAll();
        $raw_counts = $recordsModel
            ->select('eligibility, COUNT(*) as value')
            ->groupBy('eligibility')
            ->findAll();

        $eligibility_counts = [
            'PRO' => 0,
            'NON PRO' => 0,
            'PRC' => 0,
            'NON' => 0
        ];
        foreach ($raw_counts as $row) {
            $eligibility_counts[$row['eligibility']] = (int) $row['value'];
        }


        return view('pages/dashboard', [
            'username' => $username,
            'gender_records' => $gender_records,
            'maleCount' => $maleCount,
            'femaleCount' => $femaleCount,
            'eligibility_records' => $eligibility_records,
            'eligibility_counts' => $eligibility_counts
        ]);
    }
}
