<?php

namespace App\Http\Controllers\Console;

use Illuminate\Http\Request;
use App\Http\Controllers\Console\CommonController;

use App\Model\AdUsersModel;
use App\Model\UsersModel;
use App\Model\CustomerModel;
use App\Model\SuppUsersModel;
use App\Model\SuppVsAttrModel;
use App\Model\PlateAttrValueModel;
use App\Model\PlateModel;
use App\Model\UserLevelModel;
use App\Model\CartModel;
use App\Model\CartNetworkModel;
use App\Model\OrderModel;
use App\Model\OrderNetworkModel;
use App\Model\UserAccountLogModel;

use App\Model\ActivityModel;
use App\Model\ActivityVsUserModel;
use App\Model\SuppUsersSelfModel;

use Auth;
use Cache;
use DB;
use Session;

class CartController extends CommonController
{
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->request = $request;
    }

    public function post_cart(Request $request)
    {
        $data = $request->all();
        if ($data['user_ids']=='') {
            return ['status'=>2,'data'=>[],'msg'=>'请选择媒体'];
        }

        $user = $this->getUser();
        $rebate_percent = UserLevelModel::where('id',$user['level_id'])->value('rebate_percent');
        $rebate_percent = $rebate_percent?$rebate_percent:1;

        $buf_attr_value_id = [];
        $screen_attr_value_ids = [];
        $data = $request->all();
        $media_id = $data['media_id'];
        if (!isset($media_id)) {
            return ['status'=>2,'data'=>[],'msg'=>'操作失败'];
        }

        $attr_val = explode(",",$data['category_id']);

        $user_ids = $data['user_ids'];
        $user_ids = explode(",",$data['user_ids']);
        foreach ($attr_val as $key => $value) {
            $tmp = explode("-", $value);
            $attr_id = $tmp['0'];
            $attr_value_id = $tmp['1'];
            if ($attr_value_id>0) {
                // if ($attr_id!=21) {//21是价钱
                    $buf_attr_value_id[] = $attr_value_id;
                // }
            }
        }
        foreach ($user_ids as $key => $value) {
            $screen_attr_value_ids[$value] = '';
        }
        $SuppVsAttr_arr = SuppVsAttrModel::whereIn('user_id',$user_ids)->get()->toArray();
        // dd($screen_attr_value_ids);
        // 循环看哪些是当前选中的属性
        foreach ($SuppVsAttr_arr as $key => $value) {
            if (in_array($value['attr_value_id'], $buf_attr_value_id)) {
                $buf = $value['user_id'];
                $screen_attr_value_ids[$buf].=','.$value['attr_value_id'];
            }
        }
        
        \DB::beginTransaction();
        try {
            if ($user['level_id'] >= 2) {
                $lists = SuppUsersSelfModel::where('plate_id',$media_id)
                        ->where('is_state',1)
                        ->distinct()
                        ->with(['attr_value_id','attr_value_id.value'])
                        ->whereIn('supp_users_self.user_id',$user_ids)
                        ->select("*","vip_price as proxy_price")
                        ->get()
                        ->toArray();
            } else {
                $lists = SuppUsersSelfModel::where('plate_id',$media_id)
                        ->where('is_state',1)
                        ->distinct()
                        ->with(['attr_value_id','attr_value_id.value'])
                        ->whereIn('supp_users_self.user_id',$user_ids)
                        ->select("*","plate_price as proxy_price")
                        ->get()
                        ->toArray();
            }
            // 查看活动
            $activity = ActivityModel::where('start','<=',date("Y-m-d H:i:s",time()))
                            ->where('over','>=',date("Y-m-d H:i:s",time()))
                            ->select('vip_rate','plate_rate','id')
                            ->first();
            if (!$lists) {
                return ['status'=>2,'data'=>[],'msg'=>'操作失败'];
            }

            if (!empty($activity)) {
                $user_ids = ActivityVsUserModel::where('activity_id',$activity->id)->pluck('user_id')->toArray();
                if ($user['level_id'] >= 2) {
                    $rate = bcdiv($activity->vip_rate, 100,2);
                } else {
                    $rate = bcdiv($activity->plate_rate, 100,2);
                }
                foreach ($lists as $key => $value) {
                    if (in_array($value['user_id'], $user_ids)) {
                        $lists[$key]['proxy_price'] = bcmul($value['proxy_price'], $rate,2);
                    }
                }
            }
            


            
            $order_sn = makePaySn(Auth::id());
            $plate_id = $lists[0]['plate_id'];
            $type_name = PlateModel::where('id',$plate_id)->value('plate_name');;
            $user_money = 0;
            // dd($screen_attr_value_ids);
            foreach ($lists as $key => $value) {
                $user_money += $value['proxy_price'];

                $cart_network_data[] = [
                        'order_sn' => $order_sn, 
                        'supp_user_id' => $value['user_id'],
                        'type_id' => $plate_id,
                        'type_name' => $type_name,
                        'screen_attr_value_ids' => $screen_attr_value_ids[$value['user_id']]?$screen_attr_value_ids[$value['user_id']]:'',
                        'user_money' => $value['proxy_price'],
                        'created_at' => date("Y-m-d H:i:s",time())
                        ];
            }

            $cart = new CartModel;
            $cart->order_sn = $order_sn;
            $cart->ads_user_id = Auth::user()->id;
            $cart->title = $data['title'];
            $cart->type_id = $plate_id;
            $cart->type_name = $type_name;
            $cart->user_money = $user_money;
            $cart->doc_type = $data['doc_type'];
            $cart->content = $data['content'];
            $cart->cooperation_mode = isset($data['cooperation_mode'])?$data['cooperation_mode']:'';
            $cart->cooperation_place = isset($data['cooperation_place'])?$data['cooperation_place']:'';
            $cart->sale_file = isset($data['sale_file'])?$data['sale_file']:'';
            $cart->keywords = isset($data['keywords'])?$data['keywords']:'';
            $cart->remark = $data['remark'];
            $cart->start_at = $data['start_at'];
            $cart->over_at = $data['over_at'];
            $cart->save();
            $cart_network = new CartNetworkModel;

            $cart_network::insert($cart_network_data);
            \DB::commit();

        } catch (Exception $e) {
            \DB::rollBack();
            return ['status'=>2,'data'=>[],'msg'=>'操作失败'];
        }
        return ['status'=>1,'data'=>[],'msg'=>'操作成功'];

    }

    /*
    *购物车列表
    */
    public function cart_list(Request $request)
    {
        $user = $this->getUser();
        $order_sns = [];
        if ($_POST) {
            $data = $request->all();
            $order_sns = $data['order_tcar'];
            $order_sns = explode(',',$order_sns);
        }
        $cart_list = CartModel::where('status',0)
                                    ->where('is_delete',1)
                                    ->where('ads_user_id',$user['user_id'])
                                    ->get()
                                    ->toArray();
        return view('console.cart.cart_list',['user'=>$user,'cart_list'=>$cart_list,'order_sns'=>$order_sns]);
    }

    /*
    *删除订单
    */
    public function delete_order(Request $request)
    {
        $user = $this->getUser();
        $data = $request->all();
        $new_time = date("Y-m-d H:i:s",time());
        \DB::enableQueryLog();
        $order_sn_arr = explode(",",$data['id_arr']);

        $delete_order_sn_arr = CartModel::where('ads_user_id',$user['user_id'])
                            ->where('status',0)
                            ->where('is_delete',1)
                            ->where('over_at','<',$new_time)
                            ->whereIn('order_sn',$order_sn_arr)
                            ->pluck('order_sn')
                            ->toArray();

        $status = CartModel::where('ads_user_id',$user['user_id'])
                            ->where('status',0)
                            ->where('is_delete',1)
                            ->where('over_at','<',$new_time)
                            ->whereIn('order_sn',$delete_order_sn_arr)
                            ->update(['is_delete'=>2]);


        if (!$delete_order_sn_arr) {
            return ['status'=>3,'data'=>[],'msg'=>'未找到失效订单'];
        }

        if ($delete_order_sn_arr && !$status) {
            return ['status'=>2,'data'=>[],'msg'=>'操作失败'];
        }

        return ['status'=>1,'data'=>$delete_order_sn_arr,'msg'=>'操作成功'];

    }

    /*
    *查看未失效订单
    */
    public function check_order(Request $request)
    {
        $user = $this->getUser();
        $data = $request->all();
        $new_time = date("Y-m-d H:i:s",time());
        $order_sn_arr = explode(",",$data['id_arr']);

        $order_sn_arr_buf = CartModel::where('ads_user_id',$user['user_id'])
                            ->where('status',0)
                            ->where('is_delete',1)
                            ->where('over_at','>',$new_time)
                            ->whereIn('order_sn',$order_sn_arr)
                            ->pluck('order_sn')
                            ->toArray();

        if (!$order_sn_arr_buf) {
            return ['status'=>2,'data'=>[],'msg'=>'选中订单已失效'];
        }

        return ['status'=>1,'data'=>$order_sn_arr_buf,'msg'=>'操作成功'];

    }

    /*
    *结算订单
    */
    public function cart_Settlement(Request $request)
    {
        $data = $request->all();
        $user = $this->getUser();
        $new_time = date("Y-m-d H:i:s",time());
        $order_sn_arr = explode(",",$data['id_arr']);

        $user_chief = UsersModel::where('id',$user['user_id'])->first()->toArray();

        if (!\Hash::check($data['password'], $user_chief['password'])) {
            return ['status' => 2,'data'=>[],'msg'=>'密码不正确'];
        }


        $delete_order_sn_arr = CartModel::where('ads_user_id',$user['user_id'])
                            ->where('status',0)
                            ->where('is_delete',1)
                            ->where('over_at','<',$new_time)
                            ->whereIn('order_sn',$order_sn_arr)
                            ->pluck('order_sn')
                            ->toArray();

        if ($delete_order_sn_arr) {
            return ['status'=>2,'data'=>[],'msg'=>'支付失败，含有失效订单'];
        }


        $money_all = CartModel::where('ads_user_id',$user['user_id'])
                            ->whereIn('order_sn',$order_sn_arr)
                            ->select(DB::raw('SUM(user_money) as money_all'))
                            ->first()
                            ->money_all;

        if ($user['user_money']<$money_all) {
            return ['status' => 3,'data'=>[],'msg'=>'账户余额不足,请前往充值'];
        }

        $order_sn_arr_buf = CartModel::with('cart_network_value')
                            ->where('ads_user_id',$user['user_id'])
                            ->where('status',0)
                            ->where('is_delete',1)
                            ->where('over_at','>',$new_time)
                            ->whereIn('order_sn',$order_sn_arr)
                            ->get()
                            ->toArray();
        // 是否存在上级
        $commission = 0;
        $supp_money = 0;
        $platform = 0;
        $parent_id = AdUsersModel::where('user_id',$user['user_id'])->first()->parent_id;

        \DB::beginTransaction();
        try {
            $aduser = AdUsersModel::where('user_id',$user['user_id'])->first();
            $aduser->user_money = $user['user_money'] - $money_all;
            $aduser->save();
            $price_type = 1;
            if ($aduser['level_id'] > 1) { // 会员
                $price_type = 2; // 会员价
            }
            $activity = ActivityModel::where('start','<=',date("Y-m-d H:i:s",time()))
                            ->where('over','>=',date("Y-m-d H:i:s",time()))
                            ->select('vip_rate','plate_rate','id')
                            ->first();
            $user_ids = [];
            if (!empty($activity)) {
                $user_ids = ActivityVsUserModel::where('activity_id',$activity->id)
                                ->pluck('user_id')
                                ->toArray();  
            }
             
            $CartModel = new CartModel();

            foreach ($order_sn_arr_buf as $key => $value) {
                $CartModel->where('order_sn',$value['order_sn'])
                            ->update(['status'=>1,'is_delete'=>2]);
                // 流水表
                $accountlog_data[] = [
                        'user_id' => $user['user_id'],
                        'user_money' => $value['user_money'], 
                        'desc' => '订单支付',
                        'account_type' => 2,
                        'order_sn' => $value['order_sn'],
                        'order_id' => $value['id'], // TODO:购物车id
                        'created_at' => date("Y-m-d H:i:s",time()),
                        'pay_type' => 'laba',
                        'pay_user' =>$user['name']
                        ];

                // 订单主表
                $order_data[] = [
                    'order_sn' => $value['order_sn'], 
                    'ads_user_id' => $user['user_id'],
                    'title' => $value['title'],
                    'order_type' => 11,
                    'type_id' => $value['type_id'],
                    'type_name' => $value['type_name'],
                    'user_money' => $value['user_money'],
                    'start_at' => $value['start_at'],
                    'over_at' => $value['over_at'],
                    'created_at' => date("Y-m-d H:i:s",time()),
                    'doc_type' => $value['doc_type'],
                    'content' => $value['content'],
                    'keywords' => $value['keywords'],
                    'cooperation_mode' => $value['cooperation_mode'],
                    'cooperation_place' => $value['cooperation_place'],
                    'sale_file' => $value['sale_file'],
                    'remark' => $value['remark']
                ];

                foreach ($value['cart_network_value'] as $k => $v) {
                    // 订单子表
                    if ($parent_id > 0 && $price_type == 1) {
                        $commission = getCommission($v['supp_user_id']);
                    } else {
                        $commission = 0;
                    }
                    $self_user_info = SuppUsersSelfModel::where('user_id',$v['supp_user_id'])->first();
                    $plate_price = $self_user_info['plate_price']; // 平台媒体平台价
                    $vip_price = $self_user_info['vip_price'];
                    // $platform = $v['user_money'] - $proxy_price - $commission; // 平台所赚价格
                    // 查找同类的UID
                    $uids = getSameSpecUid($v['supp_user_id'], 'success_order', $request, 'uid');
                    $supp_user_id = 0;
                    $proxy_price = 0;
                    $platform = 0;
                    if ($uids['status_code'] == 200) {
                        $supp_user_id = $uids['data']['0'];
                        $proxy_price = SuppUsersModel::where('user_id', $supp_user_id)
                                            ->first()
                                            ->proxy_price;
                        $platform = $v['user_money'] - $proxy_price - $commission;
                        
                    }
                    $OrderNetworkModel = new OrderNetworkModel;
                    $OrderNetworkModel->order_sn = $v['order_sn'];
                    $OrderNetworkModel->supp_user_id = $supp_user_id;
                    $OrderNetworkModel->order_type = $supp_user_id > 0 ? 1 : 11;
                    $OrderNetworkModel->media_type = $supp_user_id > 0 ? 13 : 11;
                    $OrderNetworkModel->self_uid = $v['supp_user_id'];
                    $OrderNetworkModel->ads_user_id = $user['user_id'];
                    $OrderNetworkModel->type_id = $v['type_id'];
                    $OrderNetworkModel->type_name = $v['type_name'];
                    $OrderNetworkModel->user_money = $v['user_money']; //支付价格
                    $OrderNetworkModel->screen_attr_value_ids = $v['screen_attr_value_ids'];
                    $OrderNetworkModel->created_at = date("Y-m-d H:i:s",time());
                    $OrderNetworkModel->supp_money = $proxy_price; //$proxy_price,
                    $OrderNetworkModel->platform = $platform; //平台赚的差价
                    $OrderNetworkModel->plateform_price = $plate_price;
                    $OrderNetworkModel->vip_price = $vip_price;
                    $OrderNetworkModel->commission = $commission; //分成
                    if (empty($user_ids) && in_array($v['supp_user_id'], $user_ids)) {
                        $OrderNetworkModel->activity_id = $activity->id;
                    }
                    $OrderNetworkModel->save();
                    if ($supp_user_id > 0) {
                        SendOrderNotic($OrderNetworkModel->id, $supp_user_id, '您有新的订单,【'.$value['title'].'】','用户下单');
                    }
                    
                }
            }
            $accountlog = new UserAccountLogModel();
            $accountlog::insert($accountlog_data);

            $ordermodel = new OrderModel;
            $ordermodel::insert($order_data);
         

            // $order_sn_arr_buf = OrderNetworkModel::whereIn('order_sn',$order_sn_arr)
            //                     ->get()
            //                     ->toArray();

            // foreach ($order_sn_arr_buf as $key => $value) {
                
            // }
            \DB::commit();
        } catch (Exception $e) {
            \DB::rollBack();
            return ['status'=>2,'data'=>[],'msg'=>'支付失败'];
        }
        return ['status'=>1,'data'=>[],'msg'=>'支付成功',];

    }


    /*
    *获取用户信息
    */
    public function getUser()
    {
        $user_id = Auth::user()->id;
        $user = AdUsersModel::where('ad_users.user_id',$user_id)
                            ->join('users','ad_users.user_id','=','users.id')
                            ->first();
        $user = $user->toArray();
        return $user;
    }
}
