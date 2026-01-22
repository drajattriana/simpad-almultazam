<?php

namespace App\Models;

use CodeIgniter\Model;

class ScanModel extends Model
{
    protected $table = 'user_scan';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id_employee', 'id_student', 'status', 'date', 'note'];
    protected $returnType       = 'array';

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';

    protected $skipValidation = true;
    
    
      public function getAllScan()
    {
        return $this->select('user_scan.*, ue.name AS employee, us.name AS student')
            ->join('user_employee ue', 'ue.id = user_scan.id_employee', 'left')
            ->join('user_student us', 'us.id = user_scan.id_student', 'left')
            ->orderBy('user_scan.created_at', 'DESC')
            ->findAll();
    }

    public function getScanHistory(array $filters = [])
    {
        $builder = $this->select('user_scan.*, ue.name AS employee, us.name AS student, usc.class_name')
            ->join('user_employee ue', 'ue.id = user_scan.id_employee', 'left')
            ->join('user_student us', 'us.id = user_scan.id_student', 'left')
            ->join('user_student_class usc', 'usc.id = us.id_class', 'left');

        // Apply class filter
        if (!empty($filters['class_id'])) {
            $builder->where('us.id_class', $filters['class_id']);
        }

        // Apply start_date filter
        if (!empty($filters['start_date'])) {
            $builder->where('user_scan.created_at >=', $filters['start_date']);
        }

        // Apply end_date filter
        if (!empty($filters['end_date'])) {
            $nextDay = date('Y-m-d', strtotime($filters['end_date'] . ' +1 day'));
            $builder->where('user_scan.created_at <', $nextDay);
        }

        // Apply status filter
        if (!empty($filters['status'])) {
            $builder->where('user_scan.status', $filters['status']);
        }

        return $builder->orderBy('user_scan.created_at', 'DESC')->findAll();
    }
}
