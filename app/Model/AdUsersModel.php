<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class AdUsersModel extends Model
{
    protected $table = 'ad_users';
    public $timestamps = true;

    public function level()
    {
        return $this->hasOne('App\Model\UserLevelModel','id','level_id');
    }

    public function parentUser()
    {
        return $this->hasOne('App\Model\AdUsersModel','user_id','parent_id');
    }

    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }

    // 旗下会员及订单
    public static function childUserVsOrder($user_id,$order_type='success',$request)
    {
        $order_list = AdUsersModel::where('ad_users.parent_id',$user_id)
                        ->leftJoin('users','users.id','=','ad_users.user_id')
                        ->leftJoin('order','order.ads_user_id','=','ad_users.user_id')
                        ->leftJoin('order_network','order.order_sn','=','order_network.order_sn');
        if ($order_type == 'success') { // 完单
            $order_list = $order_list->select("*",DB::raw("count(order_network.id) as order_num"),
                            'ad_users.parent_order_money as user_money_all',
                            "users.created_at as user_created_at",'users.is_login'
                            );
        }
        $order_list = $order_list->groupBy('ad_users.id');
        if ($request->start) {
            $order_list = $order_list->where("order.start_at",'>=',$request->input('start')." 00:00:00");
        }
        if ($request->end) {
            $order_list = $order_list->where("order.over_at",'<=',$request->input('end')." 23:59:59");
        }
        //订单id
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
            $order_list = $order_list->where('ad_users.nickname','like',"%$keyword%");
        }
        $order_list = $order_list->orderBy('users.id','desc')
                                    ->get()
                                    ->toArray();
        $login_status = [1 => '上线', 2 => '下架'];
        foreach ($order_list as $key => $value) {
            if (!$value['user_money_all']) {
                $order_list[$key]['user_money_all'] = 0;
            }
            $order_list[$key]['is_login'] = $login_status[$value['is_login']];
        }
        return $order_list;
    }
    

}
