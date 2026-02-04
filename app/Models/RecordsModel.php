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
        $sql = "
            r.*,

            GROUP_CONCAT(s.id ORDER BY s.id DESC SEPARATOR '||') AS service_ids,
            GROUP_CONCAT(s.department ORDER BY s.id DESC SEPARATOR '||') AS departments,
            GROUP_CONCAT(s.designation ORDER BY s.id DESC SEPARATOR '||') AS designations,
            GROUP_CONCAT(s.rate ORDER BY s.id DESC SEPARATOR '||') AS rates,
            GROUP_CONCAT(s.date_of_appointment ORDER BY s.id DESC SEPARATOR '||') AS dates,
            GROUP_CONCAT(s.status ORDER BY s.id DESC SEPARATOR '||') AS statuses,

            /* ✅ RAW date_ended for EDITING:
               - Employed => ''
               - Terminated/Resigned => actual date or '' if missing
            */
            GROUP_CONCAT(
                CASE
                    WHEN s.status = 'Employed' THEN ''
                    ELSE COALESCE(NULLIF(NULLIF(s.date_ended,''),'0000-00-00'),'')
                END
                ORDER BY s.id DESC SEPARATOR '||'
            ) AS date_ended,

            /* ✅ HUMAN-READABLE SERVICE DURATION */
            GROUP_CONCAT(
                CASE
                    WHEN s.date_of_appointment IS NULL
                         OR s.date_of_appointment = ''
                         OR s.date_of_appointment = '0000-00-00'
                        THEN '—'
                    ELSE
                        CONCAT(
                            /* YEARS */
                            IF(
                                TIMESTAMPDIFF(
                                    YEAR,
                                    s.date_of_appointment,
                                    IF(
                                        s.status = 'Employed'
                                        OR s.date_ended IS NULL
                                        OR s.date_ended = ''
                                        OR s.date_ended = '0000-00-00',
                                        CURDATE(),
                                        s.date_ended
                                    )
                                ) > 0,
                                CONCAT(
                                    TIMESTAMPDIFF(
                                        YEAR,
                                        s.date_of_appointment,
                                        IF(
                                            s.status = 'Employed'
                                            OR s.date_ended IS NULL
                                            OR s.date_ended = ''
                                            OR s.date_ended = '0000-00-00',
                                            CURDATE(),
                                            s.date_ended
                                        )
                                    ),
                                    ' year',
                                    IF(
                                        TIMESTAMPDIFF(
                                            YEAR,
                                            s.date_of_appointment,
                                            IF(
                                                s.status = 'Employed'
                                                OR s.date_ended IS NULL
                                                OR s.date_ended = ''
                                                OR s.date_ended = '0000-00-00',
                                                CURDATE(),
                                                s.date_ended
                                            )
                                        ) > 1,
                                        's, ',
                                        ', '
                                    )
                                ),
                                ''
                            ),

                            /* MONTHS */
                            IF(
                                MOD(
                                    TIMESTAMPDIFF(
                                        MONTH,
                                        s.date_of_appointment,
                                        IF(
                                            s.status = 'Employed'
                                            OR s.date_ended IS NULL
                                            OR s.date_ended = ''
                                            OR s.date_ended = '0000-00-00',
                                            CURDATE(),
                                            s.date_ended
                                        )
                                    ),
                                    12
                                ) > 0,
                                CONCAT(
                                    MOD(
                                        TIMESTAMPDIFF(
                                            MONTH,
                                            s.date_of_appointment,
                                            IF(
                                                s.status = 'Employed'
                                                OR s.date_ended IS NULL
                                                OR s.date_ended = ''
                                                OR s.date_ended = '0000-00-00',
                                                CURDATE(),
                                                s.date_ended
                                            )
                                        ),
                                        12
                                    ),
                                    ' month',
                                    IF(
                                        MOD(
                                            TIMESTAMPDIFF(
                                                MONTH,
                                                s.date_of_appointment,
                                                IF(
                                                    s.status = 'Employed'
                                                    OR s.date_ended IS NULL
                                                    OR s.date_ended = ''
                                                    OR s.date_ended = '0000-00-00',
                                                    CURDATE(),
                                                    s.date_ended
                                                )
                                            ),
                                            12
                                        ) > 1,
                                        's, ',
                                        ', '
                                    )
                                ),
                                ''
                            ),

                            /* DAYS */
                            CONCAT(
                                DATEDIFF(
                                    IF(
                                        s.status = 'Employed'
                                        OR s.date_ended IS NULL
                                        OR s.date_ended = ''
                                        OR s.date_ended = '0000-00-00',
                                        CURDATE(),
                                        s.date_ended
                                    ),
                                    DATE_ADD(
                                        s.date_of_appointment,
                                        INTERVAL TIMESTAMPDIFF(
                                            MONTH,
                                            s.date_of_appointment,
                                            IF(
                                                s.status = 'Employed'
                                                OR s.date_ended IS NULL
                                                OR s.date_ended = ''
                                                OR s.date_ended = '0000-00-00',
                                                CURDATE(),
                                                s.date_ended
                                            )
                                        ) MONTH
                                    )
                                ),
                                ' day',
                                IF(
                                    DATEDIFF(
                                        IF(
                                            s.status = 'Employed'
                                            OR s.date_ended IS NULL
                                            OR s.date_ended = ''
                                            OR s.date_ended = '0000-00-00',
                                            CURDATE(),
                                            s.date_ended
                                        ),
                                        DATE_ADD(
                                            s.date_of_appointment,
                                            INTERVAL TIMESTAMPDIFF(
                                                MONTH,
                                                s.date_of_appointment,
                                                IF(
                                                    s.status = 'Employed'
                                                    OR s.date_ended IS NULL
                                                    OR s.date_ended = ''
                                                    OR s.date_ended = '0000-00-00',
                                                    CURDATE(),
                                                    s.date_ended
                                                )
                                            ) MONTH
                                        )
                                    ) != 1,
                                    's',
                                    ''
                                )
                            )
                        )
                END
                ORDER BY s.id DESC SEPARATOR '||'
            ) AS service_duration
        ";

        return $this->db->table('records r')
            ->select($sql, false) // ✅ IMPORTANT: prevents SQL escaping that causes #1064
            ->join('service_records s', 's.employee_id = r.id', 'left')
            ->groupBy('r.id')
            ->orderBy('r.last_name', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getServiceRankings(int $limit = 10): array
    {
        return $this->db->table('records r')
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
            ", false)
            ->join('service_records s', 's.employee_id = r.id', 'left')
            ->groupBy('r.id')
            ->orderBy('total_days', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }
}
