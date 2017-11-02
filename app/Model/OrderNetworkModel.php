<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderNetworkModel extends Model
{
    protected $table = 'order_network';
    public $timestamps = true;

    public function parent_order()
    {
        return $this->belongsTo('App\Model\OrderModel','order_sn','order_sn');
    }

    /**
     * 平台媒体
     * @return [type] [description]
     */
    public function selfUser()
    {
        return $this->belongsTo('App\Model\SuppUsersSelfModel', 'self_uid', 'user_id');
    }

    public function suppUser()
    {
        return $this->belongsTo('App\Model\SuppUsersModel', 'supp_user_id', 'user_id');
    }

    public function media_name()
    {
        return $this->hasone('App\Model\SuppUsersSelfModel','user_id','self_uid');
    }


    public function ad_user()
    {
        return $this->hasone('App\Model\AdUsersModel','user_id','ads_user_id');
    }

    public function appeal_order()
    {
        return $this->hasone('App\Model\OrderAppealModel','order_id','id');
    }

}
