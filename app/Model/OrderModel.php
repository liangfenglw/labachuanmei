<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table = 'order';
    public $timestamps = true;

    public function son_order()
    {
        return $this->hasMany('App\Model\OrderNetworkModel','order_sn','order_sn');
    }


    public function user()
    {
        return $this->hasone('App\Model\UsersModel','id','ads_user_id');
    }


}
