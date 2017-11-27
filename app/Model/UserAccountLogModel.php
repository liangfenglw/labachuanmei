<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserAccountLogModel extends Model
{
    protected $table = 'user_account_log';
    public $timestamps = true;

    public function order_list_recharge()
    {
        return $this->hasOne('App\Model\OrderNetworkModel','order_sn','order_sn');
    }

    public function users()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function suppUser()
    {
        return $this->belongsTo('App\Model\SuppUsersModel','user_id','user_id');
    }

    public function ads_user()
    {
        return $this->belongsTo('App\Model\AdUsersModel','user_id','user_id');
    }

    public function order()
    {
        return $this->belongsTo('App\Model\OrderNetworkModel','order_sn','order_sn');
    }

    public static function searchList($user_id, $request, $type) {
        $paylist = \Config::get('paylist');
        $recharge_consume = [
            0=>'未完成',
            1=>'完成',
            2=>'失败'
        ];
        \DB::enableQueryLog();
        $select = ['user_account_log.*',
                     'order_network.id as order_id',
                     'order_network.order_sn as order_order_sn',
                     'order_network.supp_user_id',
                     'order_network.order_type',
                     'order_network.type_id',
                     'order_network.type_name',
                     'order_network.success_url',
                     'order_network.success_pic'];
        $mediatype = explode(",",$request->input('mediatype'));
        $order_list = UserAccountLogModel::with(['order_list_recharge'])
                    ->leftJoin('order_network','order_network.order_sn','=','user_account_log.order_sn');

        if ($type == 0 || $type == 2) {
            $order_list = $order_list->leftJoin('order','order_network.order_sn','=','order.order_sn');
            array_push($select,'order.title');
        }
        if (!empty(array_filter($mediatype))) {
            $order_list = $order_list->whereIn('order_network.type_id',$mediatype);
        }
        if (!empty($type)) {
            $order_list = $order_list->where('user_account_log.account_type',$type);
        }
        if ($request->input('orderid')) {
            $order_list = $order_list->where('user_account_log.order_id',$request->input('orderid'));
        }
        if ($request->input('keyword')) {
            $order_list = $order_list->where('order_network.id',$request->input('keyword'));
        }
        if ($request->input('start')) {
            $order_list = $order_list->where('user_account_log.created_at','>=',$request->input('start'));
        }
        if ($request->input('end')) {
            $order_list = $order_list->where('user_account_log.created_at','<=',$request->input('end'));
        }
        $order_list = $order_list->where('user_account_log.user_id',$user_id)
                    ->where('user_account_log.account_type','!=',4)//退款订单不计入内
                    ->select($select)
                    ->get()
                    ->toArray();
        // dd(\DB::getQueryLog());
        // dd($order_list);
        // 遍历处理数据格式
        foreach ($order_list as $key => $value) {
            $order_list[$key]['order_type'] = $value['desc'];
            $order_list[$key]['order_title'] = $value['desc'];
            if (!empty($paylist[$value['pay_type']])) {
                $order_list[$key]['pay_type'] = $value['pay_type'];
            }
            // var_dump($value['pay_type']);
            $order_list[$key]['order_status'] = $recharge_consume[$value['status']];
        }
        return $order_list;
    }
    

    
}
