<?php

namespace App\Models;

use CodeIgniter\Model;

class RecordsModel extends Model
{
    protected $table            = 'records';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'first_name',
        'middle_name',
        'last_name',
        'extensions',
        'birthdate',
        'gender',
        'educational_attainment',
        'eligibility',
        'remarks'
    ];

    public function getEmployeesWithServices()
    {
        return $this->db->table('records r')
            ->select("
            r.*,

            GROUP_CONCAT(s.id ORDER BY s.id DESC SEPARATOR '||') AS service_ids,
            GROUP_CONCAT(s.department ORDER BY s.id DESC SEPARATOR '||') AS departments,
            GROUP_CONCAT(s.designation ORDER BY s.id DESC SEPARATOR '||') AS designations,
            GROUP_CONCAT(s.rate ORDER BY s.id DESC SEPARATOR '||') AS rates,
            GROUP_CONCAT(s.date_of_appointment ORDER BY s.id DESC SEPARATOR '||') AS dates,
            GROUP_CONCAT(s.status ORDER BY s.id DESC SEPARATOR '||') AS statuses,

            GROUP_CONCAT(
                CASE
                    WHEN s.status = 'Employed'
                         OR s.date_ended IS NULL
                         OR s.date_ended = ''
                         OR s.date_ended = '0000-00-00'
                        THEN 'Currently Working'
                    ELSE s.date_ended
                END
                ORDER BY s.id DESC SEPARATOR '||'
            ) AS date_ended
        ")
            ->join('service_records s', 's.employee_id = r.id', 'left')
            ->groupBy('r.id')
            ->orderBy('r.last_name', 'ASC')
            ->get()
            ->getResultArray();
    }
}
