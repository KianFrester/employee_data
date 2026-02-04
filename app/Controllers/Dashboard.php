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

        /**
         * ✅ LATEST SERVICE RECORD JOIN (per employee)
         * joins ONLY the latest service_records row by:
         * date_of_appointment DESC, id DESC
         */
        $latestServiceSub = "(SELECT s2.id
            FROM service_records s2
            WHERE s2.employee_id = records.id
            ORDER BY s2.date_of_appointment DESC, s2.id DESC
            LIMIT 1)";

        // ================= GENDER COUNTS =================
        $maleCount   = $recordsModel->where('gender', 'Male')->countAllResults();
        $femaleCount = $recordsModel->where('gender', 'Female')->countAllResults();

        // ================= GENDER RECORDS (LATEST SERVICE) =================
        $gender_records = $recordsModel
            ->select("
                records.*,
                sr.department AS department,
                sr.designation AS designation
            ")
            ->join("service_records sr", "sr.id = $latestServiceSub", "left", false)
            ->orderBy('records.last_name', 'ASC')
            ->findAll();

        // ================= ELIGIBILITY RECORDS (LATEST SERVICE) =================
        $eligibility_records = $recordsModel
            ->select("
                records.*,
                sr.department AS department,
                sr.designation AS designation
            ")
            ->join("service_records sr", "sr.id = $latestServiceSub", "left", false)
            ->orderBy('records.last_name', 'ASC')
            ->findAll();

        // ================= AGE RECORDS (LATEST SERVICE) =================
        $age_records = $recordsModel
            ->select("
                records.*,
                TIMESTAMPDIFF(YEAR, records.birthdate, CURDATE()) AS age,
                sr.department AS department,
                sr.designation AS designation
            ")
            ->join("service_records sr", "sr.id = $latestServiceSub", "left", false)
            ->where('records.birthdate IS NOT NULL')
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
            $age = (int)($rec['age'] ?? 0);

            if ($age >= 18 && $age <= 30) $ageGroups['18-30']++;
            elseif ($age >= 31 && $age <= 40) $ageGroups['31-40']++;
            elseif ($age >= 41 && $age <= 50) $ageGroups['41-50']++;
            elseif ($age >= 51 && $age <= 60) $ageGroups['51-60']++;
            elseif ($age > 60) $ageGroups['60+']++;
        }

        // ================= EDUCATION COUNTS =================
        $raw_education_counts = $recordsModel
            ->select('educational_attainment, COUNT(*) as value')
            ->where('educational_attainment IS NOT NULL')
            ->groupBy('educational_attainment')
            ->findAll();

        $education_counts = [
            'ELEM'       => 0,
            'HS'         => 0,
            'COLLEGE'    => 0,
            'VOC'        => 0,
            'GRAD'       => 0,
            'N/A'        => 0,
            'UNDER-GRAD' => 0,
        ];

        foreach ($raw_education_counts as $row) {
            $key = strtoupper(trim($row['educational_attainment'] ?? ''));
            if (isset($education_counts[$key])) {
                $education_counts[$key] = (int)$row['value'];
            }
        }

        // ================= EDUCATION RECORDS (LATEST SERVICE) =================
        $education_records = $recordsModel
            ->select("
                records.last_name,
                records.first_name,
                records.middle_name,
                records.extensions,
                records.educational_attainment,
                sr.department AS department,
                sr.designation AS designation
            ")
            ->join("service_records sr", "sr.id = $latestServiceSub", "left", false)
            ->where('records.educational_attainment IS NOT NULL')
            ->orderBy('records.last_name', 'ASC')
            ->findAll();

        // ================= ELIGIBILITY COUNTS =================
        $raw_counts = $recordsModel
            ->select('eligibility, COUNT(*) as value')
            ->groupBy('eligibility')
            ->findAll();

        $eligibility_counts = [
            'PRO'     => 0,
            'NON PRO' => 0,
            'PRC'     => 0,
            'NON'     => 0
        ];

        foreach ($raw_counts as $row) {
            $k = $row['eligibility'] ?? '';
            if (isset($eligibility_counts[$k])) {
                $eligibility_counts[$k] = (int)$row['value'];
            }
        }

        // ================= EMPLOYMENT COUNTS (LATEST STATUS) =================
        $employment_raw = $recordsModel
            ->select("IFNULL(sr.status, 'Employed') AS status, COUNT(*) AS value")
            ->join("service_records sr", "sr.id = $latestServiceSub", "left", false)
            ->groupBy("IFNULL(sr.status, 'Employed')")
            ->findAll();

        $employment_counts = [
            'Employed'         => 0,
            'Terminated'       => 0,
            'Resigned/Retired' => 0,
        ];

        foreach ($employment_raw as $row) {
            $status = $row['status'] ?? '';
            if (isset($employment_counts[$status])) {
                $employment_counts[$status] = (int)$row['value'];
            }
        }

        // ================= EMPLOYMENT RECORDS (LATEST STATUS + LATEST SERVICE) =================
        $employment_records = $recordsModel
            ->select("
                records.last_name,
                records.first_name,
                records.middle_name,
                records.extensions,
                sr.department AS department,
                sr.designation AS designation,
                IFNULL(sr.status, 'Employed') AS employment_status
            ")
            ->join("service_records sr", "sr.id = $latestServiceSub", "left", false)
            ->orderBy('records.last_name', 'ASC')
            ->findAll();

        // ==========================================================
        // ✅ SERVICE RANKING CHART DATA (TOTAL SERVICE YEARS, TOP 10)
        // SUM all service_records durations per employee
        // date_ended null/empty/0000-00-00 => today
        // ==========================================================
        $service_rankings = $recordsModel->db->table('records r')
            ->select("
                r.id,
                r.last_name,
                r.first_name,
                r.middle_name,
                r.extensions,
                SUM(
                    DATEDIFF(
                        COALESCE(NULLIF(NULLIF(s.date_ended,''),'0000-00-00'), CURDATE()),
                        s.date_of_appointment
                    )
                ) AS total_days
            ")
            ->join('service_records s', 's.employee_id = r.id', 'left')
            ->groupBy('r.id')
            ->orderBy('total_days', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();

        $service_labels = [];
        $service_years  = [];

        foreach ($service_rankings as $r) {
            $name = trim(($r['last_name'] ?? '') . ', ' . ($r['first_name'] ?? '') . ' ' . ($r['middle_name'] ?? '') . ' ' . ($r['extensions'] ?? ''));
            $days = (int)($r['total_days'] ?? 0);
            $years = $days > 0 ? round($days / 365.25, 2) : 0;

            $service_labels[] = $name;
            $service_years[]  = $years;
        }

        // ==========================================================
        // ✅ SERVICE RANKING MODAL TABLE (LATEST SERVICE ONLY)
        // Fullname, dept, designation, date_of_appointment, duration
        // ==========================================================
        $service_ranking_records = $recordsModel
            ->select("
                records.id,
                records.last_name,
                records.first_name,
                records.middle_name,
                records.extensions,
                sr.department AS department,
                sr.designation AS designation,
                sr.date_of_appointment AS date_of_appointment,
                sr.date_ended AS date_ended,
                DATEDIFF(
                    COALESCE(NULLIF(NULLIF(sr.date_ended,''),'0000-00-00'), CURDATE()),
                    sr.date_of_appointment
                ) AS service_days
            ")
            ->join("service_records sr", "sr.id = $latestServiceSub", "left", false)
            ->orderBy('service_days', 'DESC')
            ->findAll();

        return view('pages/dashboard', [
            'username'                 => $username,

            'maleCount'                => $maleCount,
            'femaleCount'              => $femaleCount,
            'gender_records'           => $gender_records,

            'eligibility_counts'       => $eligibility_counts,
            'eligibility_records'      => $eligibility_records,

            'ageGroups'                => $ageGroups,
            'age_records'              => $age_records,

            'education_counts'         => $education_counts,
            'education_records'        => $education_records,

            'employment_counts'        => $employment_counts,
            'employment_records'       => $employment_records,

            // ✅ NEW: bar chart data + modal records
            'service_labels'           => $service_labels,
            'service_years'            => $service_years,
            'service_ranking_records'  => $service_ranking_records,
        ]);
    }
}
