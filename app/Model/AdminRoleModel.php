<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminRoleModel extends Model
{
    protected $table = 'admin_role';
    public $timestamps = true;

    public function roleVsMenu()
    {
        return $this->hasMany('App\Model\RoleVsMenuModel','role_id','id');
    }
}
