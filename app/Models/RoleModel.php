<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table            = 'auth_user_roles';
    protected $primaryKey       = 'id'; 
    protected $allowedFields    = ['id_unique', 'name', 'url'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $returnType       = 'array'; 

    // Get Role by ID
    public function getRoleById(int $roleId)
    {
        return $this->select('auth_user_roles.*')
                    ->where('auth_user_roles.id', $roleId)
                    ->first();
    }
}
