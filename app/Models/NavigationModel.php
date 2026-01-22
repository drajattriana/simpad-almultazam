<?php

namespace App\Models;

use CodeIgniter\Model;

class NavigationModel extends Model
{
    protected $table = 'auth_menu_navigation';
    protected $primaryKey       = 'id';
    protected $allowedFields  = ['id_menu', 'id_role'];
    protected $returnType       = 'array';

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    public function getNavigationWithDetails(int $roleId)
    {        
         return $this->select('
                    auth_menu_navigation.id, 
                    auth_menu_navigation.id_role, 
                    auth_menu_navigation.id_menu, 
                    auth_user_roles.name as role_name, 
                    auth_menu.name as menu_name
                ')
                ->join('auth_user_roles', 'auth_user_roles.id = auth_menu_navigation.id_role')
                ->join('auth_menu', 'auth_menu.id = auth_menu_navigation.id_menu')
                ->where('auth_menu_navigation.id_role', $roleId)
                ->findAll();
    }
}
