<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminMenuModel extends Model
{
    protected $table = 'admin_menu';
    public $timestamps = true;

    public function admin_menu() {
        return $this->hasMany('App\Model\AdminMenuModel','pid','id');
    }

    /**
     * 上级菜单
     * @return [type] [description]
     */
    public function parent_menu() {
        return $this->belongsTo('App\Model\AdminMenuModel','pid','id');
    }

    public function child_menu() {
        return $this->hasMany('App\Model\AdminMenuModel','id','pid');
    }
}
