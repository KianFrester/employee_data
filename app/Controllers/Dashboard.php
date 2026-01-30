<?php

namespace App\Controllers;

use App\Models\RecordsModel;

class Dashboard extends BaseController
{
    public function dashboard()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/')->with('error', 'You must log in first.');
        }

        $username = $session->get('username');
        $recordsModel = new RecordsModel();

        // ================= GENDER COUNTS =================
        $maleCount = $recordsModel->where('gender', 'Male')->countAllResults();
        $femaleCount = $recordsModel->where('gender', 'Female')->countAllResults();

        // ================= GENDER RECORDS (WITH SERVICE DATA) =================
        $gender_records = $recordsModel
            ->select("
                records.*,
                GROUP_CONCAT(
                    CONCAT(
                        '<div>', service_records.department, '</div>'
                    ) SEPARATOR ''
                ) AS department,
                GROUP_CONCAT(
                    CONCAT(
                        '<div>', service_records.designation, '</div>'
                    ) SEPARATOR ''
                ) AS designation
            ")
            ->join('service_records', 'service_records.employee_id = records.id', 'left')
            ->groupBy('records.id')
            ->orderBy('records.last_name', 'ASC')
            ->findAll();


        // ================= ELIGIBILITY RECORDS (WITH SERVICE DATA) =================
        $eligibility_records = $recordsModel
            ->select("
        records.*,
        GROUP_CONCAT(
            CONCAT('<div>', service_records.department, '</div>')
            SEPARATOR ''
        ) AS department,
        GROUP_CONCAT(
            CONCAT('<div>', service_records.designation, '</div>')
            SEPARATOR ''
        ) AS designation
    ")
            ->join('service_records', 'service_records.employee_id = records.id', 'left')
            ->groupBy('records.id')
            ->orderBy('records.last_name', 'ASC')
            ->findAll();

        // ================= AGE RECORDS (WITH SERVICE DATA) =================
        $age_records = $recordsModel
            ->select("
        records.*,
        TIMESTAMPDIFF(YEAR, records.birthdate, CURDATE()) AS age,
        GROUP_CONCAT(
            CONCAT('<div>', service_records.department, '</div>')
            SEPARATOR ''
        ) AS department,
        GROUP_CONCAT(
            CONCAT('<div>', service_records.designation, '</div>')
            SEPARATOR ''
        ) AS designation
    ")
            ->join('service_records', 'service_records.employee_id = records.id', 'left')
            ->where('records.birthdate IS NOT NULL')
            ->groupBy('records.id')
            ->orderBy('records.last_name', 'ASC')
            ->findAll();

        // ================= AGE GROUP COUNTS =================
        $ageGroups = [
            '18-30' => 0,
            '31-40' => 0,
            '41-50' => 0,
            '51-60' => 0,
            '60+'   => 0,
        ];

        
        foreach ($age_records as $rec) {
            $age = (int) $rec['age'];

            if ($age >= 18 && $age <= 30) {
                $ageGroups['18-30']++;
            } elseif ($age >= 31 && $age <= 40) {
                $ageGroups['31-40']++;
            } elseif ($age >= 41 && $age <= 50) {
                $ageGroups['41-50']++;
            } elseif ($age >= 51 && $age <= 60) {
                $ageGroups['51-60']++;
            } elseif ($age > 60) {
                $ageGroups['60+']++;
            }
        }

        // ================= EDUCATION COUNTS =================
        $raw_education_counts = $recordsModel
            ->select('educational_attainment, COUNT(*) as value')
            ->where('educational_attainment IS NOT NULL')
            ->groupBy('educational_attainment')
            ->findAll();

        // default values (so always shows 0 if none)
        $education_counts = [
            'ELEM'   => 0,
            'HS'     => 0,
            'COLLEGE' => 0,
            'VOC'    => 0,
            'GRAD'   => 0,
        ];

        foreach ($raw_education_counts as $row) {
            $key = strtoupper(trim($row['educational_attainment']));
            if (isset($education_counts[$key])) {
                $education_counts[$key] = (int) $row['value'];
            }
        }




        // ================= ELIGIBILITY COUNTS =================
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
            if (isset($eligibility_counts[$row['eligibility']])) {
                $eligibility_counts[$row['eligibility']] = (int) $row['value'];
            }
        }

        return view('pages/dashboard', [
            'username'            => $username,
            'gender_records'      => $gender_records,
            'maleCount'           => $maleCount,
            'femaleCount'         => $femaleCount,
            'eligibility_records' => $eligibility_records,
            'eligibility_counts'  => $eligibility_counts,
            'age_records'         => $age_records,
            'education_counts'   => $education_counts,
            'ageGroups'           => $ageGroups,
        ]);
    }
}
