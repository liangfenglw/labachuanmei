<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CartModel extends Model
{
    protected $table = 'cart';
    public $timestamps = true;


    public function cart_network_value()
    {
        return $this->hasMany('App\Model\CartNetworkModel','order_sn','order_sn');
    }

    

    
}
