<?php
namespace App\Service\Jobs;

use App\Model\OrderNetworkModel;
use App\Model\OrderModel;
use App\Model\AdUsersModel;
use App\Model\UserAccountLogModel;
use App\Model\OrderChangeLogModel;
use Carbon\Carbon;
use DB;


class OrderService
{
    public static function checkInvalidOrder()
    {
        $invalid_time = Carbon::now()->toDateTimeString();
        OrderModel::leftJoin('order_network', 'order.order_sn','=','order_network.order_sn')
                    ->where('order.over_at', '<', $invalid_time)
                    ->whereIn('order_network.order_type', [1,11])
                    ->orderBy('order.id','asc')
                    ->select('order_network.*')
                    ->chunk(10,function($lists){
                        // 发通知
                        foreach ($lists as $key => $order) {
                            try {
                                DB::beginTransaction();
                                $tmp = AdUsersModel::where('user_id', $order->ads_user_id)
                                        ->increment('user_money', $order->user_money);
                                $tmp2 = UserAccountLogModel::insert([
                                    'user_id' => $order->ads_user_id,
                                    'user_money' => $order->user_money,
                                    'account_type' => 5,
                                    'desc' => '对方未按时接受任务，已过期',
                                    'order_sn' => $order->order_sn,
                                    'order_id' => $order->id,
                                    'created_at' => Carbon::now()->toDateTimeString(),
                                ]);
                                $tmp3 = OrderNetworkModel::where('id', $order->id)->update(['order_type' => 3]);
                                OrderModel::where('order_sn', $order->order_sn)->update(['order_type' => 3]);
                                $tmp4 = OrderChangeLogModel::insert([
                                    'order_id' => $order->id,
                                    'content' => $order->order_type == 1 ? '未接受，任务过期' : '未指派，任务过期',
                                    'created_at' => Carbon::now()->toDateTimeString(),
                                ]);
                                if ($tmp && $tmp2 && $tmp3 && $tmp4) {
                                    SendOrderNotic($order->id, $order->ads_user_id, "对方未接受任务，订单任务已过期，款项退回给您",'用户接单');

                                    DB::commit();
                                } else {
                                    DB::rollback();
                                    \Log::log('order_invalid', 'order dealwith is fail'.$order->id);
                                }
                            } catch (Exception $e) {
                                \Log::log('order_invalid', 'order dealwith is throw'.$order->id);
                                DB::rollback();
                            }
                        }
                    });
    }
}