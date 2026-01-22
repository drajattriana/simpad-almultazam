<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table = 'user_employee';
    protected $primaryKey       = 'id';
    protected $allowedFields  = ['name', 'position', 'id_user'];
    protected $returnType       = 'array';

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    

    public function getAllUserEmployee()
    {
        return $this->select('auth_user.username, user_employee.*')
                    ->join('auth_user', 'auth_user.id = user_employee.id_user')
                    ->findAll();
    }
    
}
