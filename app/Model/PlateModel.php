<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PlateModel extends Model
{
    protected $table = 'plate';
    public $timestamps = true;

    public function childPlate()
    {
        return $this->hasMany('App\Model\PlateModel','pid','id');
    }

    /**
     * 关联属性表
     * @return [type] [description]
     */
    public function plateVsAttr()
    {
        return $this->hasMany('App\Model\PlateAttrModel','plate_id','id');
    }

    /**
     * 关联到属性值
     * @return [type] [description]
     */
    public function attr_val()
    {
        return $this->hasManyThrough('App\Model\PlateAttrValueModel',
                    'App\Model\PlateAttrModel',
                    'plate_id','attr_id','id');
    }

    public function selfSuppUser()
    {
        return $this->hasMany('App\Model\SuppUsersSelfModel','plate_tid','id');
    }

    /**
     * 关联到用户列表
     * @return [type] [description]
     */
    public function user_list()
    {
        return $this->hasMany('App\Model\SuppUsersModel','plate_tid','id');
    }

}
