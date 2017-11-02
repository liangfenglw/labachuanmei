<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderAppealModel extends Model
{
    protected $table = 'order_appeal';
    public $timestamps = true;

    public function parent_order()
    {
        return $this->belongsTo('App\Model\OrderModel','order_sn','order_sn');
    }

    public function order_network()
    {
        return $this->hasone('App\Model\OrderNetworkModel','id','order_id');
    }
}
