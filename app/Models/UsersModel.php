<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table            = 'auth_user';
    protected $primaryKey       = 'id'; 
    protected $allowedFields    = ['id_unique', 'username', 'password', 'is_active', 'id_role'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $returnType       = 'array'; 

    // Get Role by ID
    public function getUserRoleById(int $userId)
    {
        return $this->select('auth_user_roles.name, auth_user_roles.url')
                    ->join('auth_user_roles', 'auth_user_roles.id = auth_user.id_role')
                    ->where('auth_user.id', $userId)
                    ->first();
    }

    
}
