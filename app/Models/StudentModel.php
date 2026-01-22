<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table = 'user_student';
    protected $primaryKey       = 'id';
    protected $allowedFields  = ['nis', 'name', 'gender','mother_name', 'whatsapp', 'dormitory_name', 'dormitory_wa', 'id_class'];
    protected $returnType       = 'array';

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    
    
    public function getAllStudent()
    {
        return $this->select('user_student.*, user_student_class.class_name AS class')
            ->join('user_student_class', 'user_student_class.id = user_student.id_class', 'left')
            ->findAll();
    }

    public function getStudentsByClass($classId)
    {
        // Jika tidak ada classId yang diberikan, kembalikan array kosong
        if (empty($classId)) {
            return [];
        }

        return $this->select('user_student.nis, user_student.name, user_student.gender, user_student_class.class_name')
            ->join('user_student_class', 'user_student_class.id = user_student.id_class')
            ->where('user_student.id_class', $classId)
            ->orderBy('user_student.name', 'ASC')
            ->findAll();
    }
}
