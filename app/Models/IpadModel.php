<?php

namespace App\Models;

use CodeIgniter\Model;

class IpadModel extends Model
{
    protected $table = 'user_ipad';
    protected $primaryKey       = 'id';
    protected $allowedFields  = ['model', 'color', 'grade', 'note', 'status', 'id_student', 'nis'];
    protected $returnType       = 'array';

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';


    public function getAllIpad()
    {
        $subQuery = '(SELECT MAX(id) FROM user_scan WHERE user_scan.id_student = user_ipad.id_student)';
        return $this->select('user_ipad.*, user_student.name as student, user_scan.date as pengembalian ,user_scan.created_at as peminjaman,  user_scan.note as ket, user_student_class.class_name, user_student.mother_name, user_student.whatsapp, user_student.dormitory_name, user_student.dormitory_wa, ')
            ->join('user_student', 'user_student.id = user_ipad.id_student')
            ->join('user_student_class', 'user_student_class.id = user_student.id_class', 'left')
            ->join('user_scan', "user_scan.id = $subQuery", 'left')
            ->findAll();
    }


    public function getIpadFiltered($classId = null, $status = null)
    {
        $subQuery = '(SELECT MAX(id) FROM user_scan WHERE user_scan.id_student = user_ipad.id_student)';
        $this->select('user_ipad.*, user_student.name as student, user_scan.date as pengembalian, user_scan.created_at as peminjaman, user_scan.note as ket, user_student_class.class_name, user_student.mother_name, user_student.whatsapp, user_student.dormitory_name, user_student.dormitory_wa, ')
            ->join('user_student', 'user_student.id = user_ipad.id_student')
            ->join('user_student_class', 'user_student_class.id = user_student.id_class', 'left')
            ->join('user_scan', "user_scan.id = $subQuery", 'left');

        // Add filter for class if provided
        if (!empty($classId)) {
            $this->where('user_student.id_class', $classId);
        }

        // Add filter for status if provided
        if (!empty($status)) {
            $this->where('user_ipad.status', $status);
        }

        return $this->findAll();
    }


    public function getStoreIpad()
    {
        $subQuery = '(SELECT MAX(id) FROM user_scan WHERE user_scan.id_student = user_ipad.id_student)';
        return $this->select('user_ipad.*, user_student.name as student, user_scan.date as pengembalian, user_scan.note as ket,user_student_class.class_name, user_student.mother_name, user_student.whatsapp, user_student.dormitory_name, user_student.dormitory_wa, ')
            ->join('user_student', 'user_student.id = user_ipad.id_student')
            ->join('user_student_class', 'user_student_class.id = user_student.id_class', 'left')
            ->join('user_scan', "user_scan.id = $subQuery", 'left')
            ->where('user_ipad.status', 'Disimpan')
            ->findAll();
    }

    public function getClassIpad()
    {
        $subQuery = '(SELECT MAX(id) FROM user_scan WHERE user_scan.id_student = user_ipad.id_student)';
        return $this->select('user_ipad.*, user_student.name as student, user_scan.date as pengembalian, user_scan.note as ket, user_student_class.class_name, user_student.mother_name, user_student.whatsapp, user_student.dormitory_name, user_student.dormitory_wa, ')
            ->join('user_student', 'user_student.id = user_ipad.id_student')
            ->join('user_student_class', 'user_student_class.id = user_student.id_class', 'left')
            ->join('user_scan', "user_scan.id = $subQuery", 'left')
            ->where('user_ipad.status', 'Pembelajaran')
            ->findAll();
    }

    public function getRentIpad()
    {
        $subQuery = '(SELECT MAX(id) FROM user_scan WHERE user_scan.id_student = user_ipad.id_student)';
        return $this->select('user_ipad.*, user_student.name as student, user_scan.date as pengembalian, user_scan.note as ket, user_student_class.class_name, user_student.mother_name, user_student.whatsapp, user_student.dormitory_name, user_student.dormitory_wa, ')
            ->join('user_student', 'user_student.id = user_ipad.id_student')
            ->join('user_student_class', 'user_student_class.id = user_student.id_class', 'left')
            ->join('user_scan', "user_scan.id = $subQuery", 'left')
            ->where('user_ipad.status', 'Pinjam')
            ->findAll();
    }

    public function getStudentClass($classId)
    {
        if (empty($classId)) {
            return [];
        }

        // Subquery untuk mendapatkan scan terakhir per siswa
        $subQuery = '(SELECT MAX(id) FROM user_scan WHERE user_scan.id_student = user_student.id)';

        // Builder untuk memulai query dari tabel siswa
        $builder = $this->db->table('user_student');

        $builder->select(
            'user_student.nis, 
             user_student.name, 
             user_student.gender, 
             user_student_class.class_name,
             user_ipad.status AS status_ipad,
             user_scan.date AS pengembalian,
             user_scan.note AS ket,
             user_student.mother_name, user_student.whatsapp,
             user_student.dormitory_name, 
             user_student.dormitory_wa'

        );

        $builder->join('user_student_class', 'user_student_class.id = user_student.id_class');
        // LEFT JOIN agar semua siswa muncul, meskipun tidak punya data iPad
        $builder->join('user_ipad', 'user_ipad.id_student = user_student.id', 'left');
        $builder->join('user_scan', "user_scan.id = $subQuery", 'left');

        // Filter berdasarkan ID Kelas yang dipilih
        $builder->where('user_student.id_class', $classId);

        $builder->orderBy('user_student.name', 'ASC');

        return $builder->get()->getResultArray();
    }

    public function getStudentStatusClass($classId, $statusId)
    {
        if (empty($classId)) {
            return [];
        } elseif (empty($statusId)) {
            # code...
        }

        // Subquery untuk mendapatkan scan terakhir per siswa
        $subQuery = '(SELECT MAX(id) FROM user_scan WHERE user_scan.id_student = user_student.id)';

        // Builder untuk memulai query dari tabel siswa
        $builder = $this->db->table('user_student');

        $builder->select(
            'user_student.nis, 
             user_student.name, 
             user_student.gender, 
             user_student_class.class_name,
             user_ipad.status AS status_ipad,
             user_scan.date AS pengembalian,
             user_scan.note AS ket,
             user_student.mother_name, user_student.whatsapp,
             user_student.dormitory_name, 
             user_student.dormitory_wa'
        );

        $builder->join('user_student_class', 'user_student_class.id = user_student.id_class');
        // LEFT JOIN agar semua siswa muncul, meskipun tidak punya data iPad
        $builder->join('user_ipad', 'user_ipad.id_student = user_student.id', 'left');
        $builder->join('user_scan', "user_scan.id = $subQuery", 'left');

        // Filter berdasarkan ID Kelas yang dipilih
        $builder->where('user_student.id_class', $classId);
        $builder->where('user_ipad.status', $statusId);

        $builder->orderBy('user_student.name', 'ASC');

        return $builder->get()->getResultArray();
    }
}
