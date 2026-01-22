<?php

namespace App\Models;

use CodeIgniter\Model;

class ClassModel extends Model
{
    protected $table            = 'user_student_class';
    protected $primaryKey       = 'id'; 
    protected $allowedFields    = ['class_name', 'grade', 'major'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $returnType       = 'array'; 
}
