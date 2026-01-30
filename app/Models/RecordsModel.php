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
    protected $allowedFields    = [
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
                r.id,
                r.first_name,
                r.middle_name,
                r.last_name,
                r.extensions,
                r.birthdate,
                r.gender,
                r.educational_attainment,
                r.eligibility,
                r.remarks,

                GROUP_CONCAT(s.department ORDER BY s.date_of_appointment DESC SEPARATOR '||') AS departments,
                GROUP_CONCAT(s.designation ORDER BY s.date_of_appointment DESC SEPARATOR '||') AS designations,
                GROUP_CONCAT(s.rate ORDER BY s.date_of_appointment DESC SEPARATOR '||') AS rates,
                GROUP_CONCAT(s.date_of_appointment ORDER BY s.date_of_appointment DESC SEPARATOR '||') AS dates,
                GROUP_CONCAT(s.status ORDER BY s.date_of_appointment DESC SEPARATOR '||') AS statuses,
                GROUP_CONCAT(s.date_ended ORDER BY s.date_of_appointment DESC SEPARATOR '||') AS date_ended
            ")
            ->join('service_records s', 's.employee_id = r.id', 'left')
            ->groupBy('r.id')
            ->orderBy('r.last_name', 'ASC')
            ->get()
            ->getResultArray();
    }

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
