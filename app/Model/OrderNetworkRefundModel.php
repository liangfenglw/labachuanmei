<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderNetworkRefundModel extends Model
{
    protected $table = 'order_network_refund';
    public $timestamps = true;

    public function parent_order()
    {
        return $this->belongsTo('App\Model\OrderModel','order_sn','order_sn');
    }

}
