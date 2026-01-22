<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table            = 'auth_menu';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id_unique','name'];
    protected $returnType       = 'array';

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    // --------------------

    public function getSubMenusByMenuId(int $menuId): array
    {
        return $this->builder('auth_menu_sub')
                    ->where('id_menu', $menuId)
                    ->orderBy('no_urut', 'ASC')
                    ->get()->getResult();
    }

    public function getSubMenusByRoleId(string $roleId): array
    {
        return $this->select('auth_menu_sub.*')
                    ->join('auth_menu_navigation', 'auth_menu.id = auth_menu_navigation.id_menu')
                    ->join('auth_menu_sub', 'auth_menu.id = auth_menu_sub.id_menu')
                    ->where('auth_menu_navigation.id_role', $roleId)
                    ->orderBy('auth_menu_sub.no', 'ASC')
                    ->findAll();
    }

    public function countSubMenusByMenuId(int $menuId): int
    {
        return $this->builder('auth_menu_sub')
                    ->where('id_menu', $menuId)
                    ->countAllResults();
    }

    public function getAllSubMenusWithParent(): array
    {
        return $this->select('auth_menu_sub.*, auth_menu.name as navigasi')
                    ->join('auth_menu_sub', 'auth_menu.id = auth_menu_sub.id_menu')
                    ->where('auth_menu_sub.id_menu !=', 0)
                    ->orderBy('auth_menu_sub.no_urut', 'ASC')
                    ->findAll();
    }

    public function getUnassignedMenusForRole(int $roleId): array
    {
        // 1. Get all menu IDs that are ALREADY used by this role.
        $subQuery = $this->db->table('auth_menu_navigation')
                             ->select('id_menu')
                             ->where('id_role', $roleId);

        // 2. Get all menus where the ID is NOT IN the subquery result.
        return $this->whereNotIn('id', $subQuery)
                    ->orderBy('name', 'ASC')
                    ->findAll();
    }
}
