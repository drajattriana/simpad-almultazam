<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuSubModel extends Model
{
    protected $table = 'auth_menu_sub';
    protected $primaryKey       = 'id';
    protected $allowedFields  = ['id_menu', 'id_unique', 'no', 'name', 'icon', 'url', 'is_hidden', 'menu'];
    protected $returnType       = 'array';

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
}
