<?php

namespace App\Http\Controllers\Console;

use Illuminate\Http\Request;
use App\Http\Controllers\Console\CommonController;

use App\Model\CustomerModel;
use App\Model\SuppUsersModel;
use App\Model\OrderNetworkModel;
use App\Model\OrderNetworkRefundModel;
use App\Model\AdUsersModel;
use App\Model\CartModel;
use App\Model\OrderModel;
use App\Model\NoticeModel;
use App\Model\PlateModel;
use App\Model\ArticleModel;
use App\Model\PhoneOrderModel;
use App\Model\UserAccountLogModel;
use App\Model\SuppUsersSelfModel;
use Excel;
use App\User;
use Auth;
use DB;

class UserController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * 渲染首页
     * @return [type] [description]
     */
    public function index()
    {
        //检测用户类型
        $user_type = session('user')['user_type'];
        $user_id = Auth::user()->id;
        if ($user_type == 3) { //供应商
            return redirect()->action('Console\UserController@suppIndex');
        } elseif ($user_type == 2) { // 广告主
            return redirect()->action('Console\UserController@adsIndex');
        } else {
            //已完成订单的总额
            $all_money = OrderNetworkModel::where('order_type',10)->sum('user_money');
            if ($all_money > 0) {
                $qa_money = OrderNetworkModel::where('order_type',10)->sum('user_money');
            }
            //可用部分：账户余额
            // $adsmoney = AdUsersModel::sum('user_money');
            // $suppmoney = SuppUsersModel::sum('user_money');
            // $all_user_money = get_demical($adsmoney + $suppmoney);
            $all_used_money = UserAccountLogModel::where('account_type',3)->sum('user_money');

            //平台订单
            $order_count = OrderNetworkModel::count();
            // 平台用户
            $ads_user_count = AdUsersModel::where('level_id','=','1')->count();
            // 平台资源
            $supp_user_count = SuppUsersModel::where('parent_id', '<>', 0)->count();
            // 平台资源
            $user_count = User::whereIn('user_type',[2,3])->count();
            //获取我的最新订单
            $order_list = OrderNetworkModel::leftJoin('order','order_network.order_sn','=','order.order_sn')
                            ->orderBy('order_network.updated_at','desc')
                            ->select('order.ads_user_id','order.order_type',
                                     'order.title','order.type_id',
                                     'order.type_name','order.start_at',
                                     'order.over_at','order_network.*')
                            ->take(6)
                            ->get()
                            ->toArray();
            // 盈利状况
            $ads_user_money = AdUsersModel::sum('user_money'); // 会员总金额
            $platform_money = OrderNetworkModel::where(function($query){
                $query->where('order_type', 10)
                        ->orWhere(function($query){
                            $query->where('order_type', 13)
                                    ->where('deal_with_status', 3);
                        });
                })->sum('platform');

            $supp_user_money = SuppUsersModel::sum('user_money');
            $pingtai_user_money = OrderNetworkModel::sum('platform');
            $ads_users_list = AdUsersModel::where("level_id",1)
                                ->orderBy('ad_users.id','desc')
                                ->leftJoin('users','users.id','=','ad_users.user_id')
                                ->select('ad_users.user_id',
                                         'users.name',
                                         'users.head_pic',
                                         'ad_users.nickname')
                                ->orderBy('ad_users.id','desc')
                                ->take(8)
                                ->get()
                                ->toArray();
            // 供应商
            $supp_users_list = SuppUsersModel::orderBy('supp_users.id','desc')
                                ->leftJoin('users','users.id','=','supp_users.user_id')
                                ->select("supp_users.user_id",'supp_users.media_logo','users.name')
                                ->where('belong',0)
                                ->orderBy('supp_users.id','desc')
                                ->take(8)
                                ->get()
                                ->toArray();
            // 回拨电话列表
            $phone_order_list = PhoneOrderModel::orderBy('phone_order.id','desc')
                                ->leftJoin('ad_users','phone_order.user_id','=','ad_users.user_id')
                                ->leftJoin('supp_users','phone_order.user_id','=','supp_users.user_id')
                                ->take(4)
                                ->select('ad_users.level_id',
                                         'ad_users.nickname',
                                         'supp_users.name',
                                         'phone_order.contact_phone',
                                         'phone_order.status',
                                         'phone_order.id')
                                ->get()
                                ->toArray();
            $phone_order_count = PhoneOrderModel::orderBy('phone_order.id','desc')
                                ->where('status',2)
                                ->count();
            $phone_orders = [];
            foreach ($phone_order_list as $key => $value) {
                $name = $value['nickname'];
                if ($value['level_id'] && $value['level_id'] == 2) {
                    $level_name = '高级会员';
                }
                if ($value['level_id'] == 1) {
                    $level_name = '普通会员';
                }
                if (!$value['level_id']) {
                    $level_name = '供应商';
                    $name  = $value['name'];
                }
                $phone_orders[] = [
                    'href' => 'javascript:;',//'/console/phone_order?id='.$value['id'],
                    'level_name' => $level_name,
                    'name' => $name,
                    'contact_phone' => $value['contact_phone'],
                    'status' => $value['status'] == 1 ? '完成' : '等待回拨'
                ];
            }
        }
        $toufang = $this->touFang(3);
        return view('console.index',
                ['data_all' => $toufang['0'],
                 'data_sum' => $toufang['1'],
                 'order_count' => $order_count,
                 'ads_user_count' => $ads_user_count,
                 'supp_user_count' => $supp_user_count,
                 'order_list' => $order_list,
                 'article_new_list' => $this->getNewsLists(),
                 'ads_user_money' => $ads_user_money,
                 'supp_user_money' => $supp_user_money,
                 'pingtai_user_money' => $pingtai_user_money,
                 'ads_users_list' => $ads_users_list,
                 'supp_users_list' => $supp_users_list,
                 'phone_orders' => $phone_orders,
                 // 'all_user_money' => $all_user_money,
                 'all_used_money' => $all_used_money,
                 'phone_order_count' => $phone_order_count,
                 'platform_money' => $platform_money
                 ]);
    }

    /**
     * 管理页首页
     * @return [type] [description]
     */
    public function managerIndex()
    {
        return view('console.user.manager_index');
    }

    /**
     * 用户列表
     * @return [type] [description]
     */
    public function userList()
    {
        $customerList = CustomerModel::paginate(20);
        return view('console.user.user_list',compact('customerList'));
    }

    /**
     * 获取用户列表
     * @return [type] [description]
     */
    public function searchList()
    {
        $customerList = CustomerModel::paginate(20);
        return $listData;
    }

    public function adsIndex()
    {
        $user_id = Auth::user()->id;
        $order_count = OrderModel::where('ads_user_id',Auth::user()->id)->count();
        $cart_count = CartModel::where('ads_user_id',Auth::user()->id)
                        ->where('is_delete',1) //未删除
                        ->where('status',0) //未支付
                        ->count();
        $child_order_num = AdUsersModel::where('parent_id',$user_id)
                            ->sum('parent_order_num');
        // 分销会员收益
        $child_order_money = OrderNetworkModel::whereIn('ads_user_id', function($query) 
            use($user_id) {
                $query->from('ad_users')
                    ->where('parent_id', $user_id)
                    ->select('user_id')
                    ->get();
            })->where(function($query){
                $query->where('order_type', 10)
                    ->orWhere(function($query){
                        $query->where('order_type', 13)
                            ->where('deal_with_status', 3);
                    });
            });
        $commission_money = clone($child_order_money);
        $commission_money = $commission_money->sum('commission'); // 提成
        $child_order_money = $child_order_money->sum('user_money');

        // $success_money = OrderNetworkModel::whereIn('order_sn',function($query) use($user_id) {
        //                         $query->from('order')
        //                             ->where('ads_user_id',$user_id)
        //                             ->select('order_sn');
        //                  })
        //                 ->where('order_type',10)
        //                 ->sum('user_money');

        // $qa_change = OrderNetworkModel::whereIn('order_sn',function($query) use($user_id) {
        //                     $query->from('order')->where('ads_user_id',$user_id)->select('order_sn');
        //             })
        //             ->where('order_type',10)
        //             ->sum('qa_change');

        // $vip_all = $success_money - $qa_change;

        //纯分销收益
        $parent_commision = OrderNetworkModel::whereIn('ads_user_id',
                                    function($query) use($user_id) {
                                        $query->from('ad_users')
                                                ->where('parent_id',$user_id)
                                                ->select('user_id');
                            })->sum('commission');

        $uid = Auth::user()->id;
        $order_list = OrderNetworkModel::with(['parent_order'])
                                ->where('ads_user_id',$uid)
                                ->take(20)
                                ->orderBy('updated_at','desc')
                                ->orderBy('id','desc')
                                ->get()
                                ->toArray();
        $now_month = [date('Y-m-',time()).'1 00:00:00', date('Y-m-',time()).'31 23:59:59'];
        $last_month = [date("Y-m-",strtotime("last month")).'01 00:00:00', date("Y-m-",strtotime("last month"))."31 23:59:59"];

        $order_status_count = OrderNetworkModel::where('ads_user_id',$uid)
                    ->select(
                        // 全年
                        DB::raw("count(case when order_type = 10 then 1 end) as success_count"), //完成
                        DB::raw("count(case when order_type in (4,5,6,7,8,9) then 1 end) as fail_count"), //非完成
                        DB::raw("count(case when order_type = 3 then 1 end ) as give_up_count"), //流放
                        DB::raw("count(case when order_type = 1 then 1 end ) as ing_count"), //预约状态
                        DB::raw("count(case when order_type = 0 then 1 end ) as return_count"), //退还
                        // 当月
                        DB::raw("count(case when order_type = 10 and created_at between '".$now_month['0']."' and '".$now_month['1']."'  then 1 end) as now_success_count"), //完成
                        DB::raw("count(case when order_type in (4,5,6,7,8,9) and created_at between '".$now_month['0']."' and '".$now_month['1']."' then 1 end) as now_fail_count"), //非完成
                        DB::raw("count(case when order_type = 3 and created_at between '".$now_month['0']."' and '".$now_month['1']."' then 1 end ) as now_give_up_count"), //流放
                        DB::raw("count(case when order_type = 1 and created_at between '".$now_month['0']."' and '".$now_month['1']."' then 1 end ) as now_ing_count"), //预约状态
                        DB::raw("count(case when order_type = 0 and created_at between '".$now_month['0']."' and '".$now_month['1']."' then 1 end ) as now_return_count"), //退还
                        // 上个月
                        DB::raw("count(case when order_type = 10 and created_at between '".$last_month['0']."' and '".$last_month['1']."'  then 1 end) as last_success_count"), //完成
                        DB::raw("count(case when order_type in (4,5,6,7,8,9) and created_at between '".$last_month['0']."' and '".$last_month['1']."' then 1 end) as last_fail_count"), //非完成
                        DB::raw("count(case when order_type = 3 and created_at between '".$last_month['0']."' and '".$last_month['1']."' then 1 end ) as last_give_up_count"), //流放
                        DB::raw("count(case when order_type = 1 and created_at between '".$last_month['0']."' and '".$last_month['1']."' then 1 end ) as last_ing_count"), //预约状态
                        DB::raw("count(case when order_type = 0 and created_at between '".$last_month['0']."' and '".$last_month['1']."' then 1 end ) as last_return_count") //退还
                    )
                    ->whereBetWeen("created_at",[date("Y",time()).'-01-01'." 00:00:00",  
                                                 date("Y",time()).'-12-31'." 23:59:59"])
                    ->first()
                    ->toArray();
        $view = session('user')['level_id'] == 1 ? 'console.userpersonal.index' : 'console.userpersonal.vip_index';
        $toufang = $this->touFang(2);
        // dd($order_status_count['now_success_count'],$view);
        return view($view,
                ['user_money' => get_demical(getMyUserMoney()),
                 'used_money' => get_demical(getUsedMoney(Auth::user()->id)),
                 'order_count' => $order_count,
                 'child_user_count' => getMychildUserCount(),//代理会员数
                 'order_list' => $order_list,
                 // 'vip_all' => $vip_all,
                 'parent_commision' => get_demical($parent_commision),
                 'order_status_count' => $order_status_count,
                 'month' => date("m",time()),
                 'data_all' => $toufang['0'],
                 'data_sum' => $toufang['1'],
                 'article_new_list' => $this->getNewsLists(),
                 'child_order_num' => $child_order_num,
                 'commission_money' => $commission_money,
                 'child_order_money' => $child_order_money]);

    }

    /**
     * 供应商首页
     * @return [type] [description]
     */
    public function suppIndex()
    {
        //订单数
        $order_count = OrderNetworkModel::whereIn('supp_user_id',function($query){
                            $query->from('supp_users')->where('parent_id', Auth::user()->id)->select('user_id')->get();
                        })->count();
        //月份
        $month = date("m",time());
        //获取我的最新订单
        $order_list = OrderNetworkModel::leftJoin('order','order_network.order_sn','=','order.order_sn')
                        ->whereIn('order_network.supp_user_id',function($query){
                            $query->from('supp_users')->where('parent_id', Auth::user()->id)->select('user_id')->get();
                        })
                        ->orderBy('order_network.updated_at','desc')
                        ->select('order.ads_user_id','order.order_type',
                                 'order.title','order.type_id',
                                 'order.type_name','order.start_at',
                                 'order.over_at','order_network.*')
                        ->take(10)
                        ->get()
                        ->toArray();
        $now_month = [date('Y-m-',time()).'1 00:00:00', date('Y-m-',time()).'31 23:59:59'];
        $last_month = [date("Y-m-",strtotime("last month")).'01 00:00:00', date("Y-m-",strtotime("last month"))."31 23:59:59"];
        // 拒绝单
        $order_refund = OrderNetworkRefundModel::whereIn('supp_user_id', function($query){
                            $query->from('supp_users')->where('parent_id', Auth::user()->id)->select('user_id')->get();
                        })
            ->select(
                DB::raw("count(1) as return_count"),
                DB::raw("count(case when created_at between '".$last_month['0']."' and '".$last_month['1']."' then 1 end) as last_return_count"),
                DB::raw("count(case when created_at between '".$now_month['0']."' and '".$now_month['1']."' then 1 end ) as now_return_count")
                )
            ->whereBetWeen("created_at",[date("Y-m-01",time())." 00:00:00",  date("Y-m-31",time())." 23:59:59"])
            ->first()
            ->toArray();
        
        $order_status_count = OrderNetworkModel::whereIn('supp_user_id',function($query){
                            $query->from('supp_users')->where('parent_id', Auth::user()->id)->select('user_id')->get();
                        })
                ->select(
                    DB::raw("count(case when order_type = 10 then 1 end) as success_count"), //完成
                    DB::raw("count(case when order_type in (4,5,6,7,8,9) then 1 end) as fail_count"), //非完成
                    DB::raw("count(case when order_type = 3 then 1 end ) as give_up_count"), //流放
                    DB::raw("count(case when order_type = 1 then 1 end ) as ing_count"), //预约状态
                    DB::raw("count(case when order_type in (13) and deal_with_status = 1 then 1 end ) as return_count"), //退还
                    // 当月
                    DB::raw("count(case when order_type = 10 and created_at between '".$now_month['0']."' and '".$now_month['1']."'  then 1 end) as now_success_count"), //完成
                    DB::raw("count(case when order_type in (4,5,6,7,8,9) and created_at between '".$now_month['0']."' and '".$now_month['1']."' then 1 end) as now_fail_count"), //非完成
                    DB::raw("count(case when order_type = 3 and created_at between '".$now_month['0']."' and '".$now_month['1']."' then 1 end ) as now_give_up_count"), //流放
                    DB::raw("count(case when order_type = 1 and created_at between '".$now_month['0']."' and '".$now_month['1']."' then 1 end ) as now_ing_count"), //预约状态
                    DB::raw("count(case when order_type in (13) and deal_with_status = 1 and created_at between '".$now_month['0']."' and '".$now_month['1']."' then 1 end ) as now_return_count"), //退还
                    // 上个月
                    DB::raw("count(case when order_type = 10 and created_at between '".$last_month['0']."' and '".$last_month['1']."'  then 1 end) as last_success_count"), //完成
                    DB::raw("count(case when order_type in (4,5,6,7,8,9) and created_at between '".$last_month['0']."' and '".$last_month['1']."' then 1 end) as last_fail_count"), //非完成
                    DB::raw("count(case when order_type = 3 and created_at between '".$last_month['0']."' and '".$last_month['1']."' then 1 end ) as last_give_up_count"), //流放
                    DB::raw("count(case when order_type = 1 and created_at between '".$last_month['0']."' and '".$last_month['1']."' then 1 end ) as last_ing_count"), //预约状态
                    DB::raw("count(case when order_type in (13) and deal_with_status = 1 and created_at between '".$last_month['0']."' and '".$last_month['1']."' then 1 end ) as last_return_count") //退还
                )
                ->whereBetWeen("created_at",[date("Y-m-01",time())." 00:00:00",  date("Y-m-31",time())." 23:59:59"])
                ->first()
                ->toArray();
        $order_status_count['return_count'] = $order_refund['return_count'] 
                                            + $order_status_count['return_count'];

        $order_status_count['now_return_count'] = $order_refund['now_return_count']
                                            + $order_status_count['now_return_count'];
        $order_status_count['last_return_count'] = $order_refund['last_return_count']
                                                + $order_status_count['last_return_count'];

        $my_resource = SuppUsersModel::where('belong',Auth::user()->id)->count();

        $toufang = $this->touFang(3);

        return view('console.supp.supp_index',[
            'user_money' => get_demical(getMyUserMoney()),//获取金额
            'used_money' => get_demical(getUsedMoney(Auth::user()->id)),
            'order_count' => $order_count,
            'month' => $month,
            'order_list' => $order_list,
            'my_resource' => $my_resource,
            'data_all' => $toufang['0'],
            'data_sum' => $toufang['1'],
            'order_status_count' => $order_status_count,
            'article_new_list' => $this->getNewsLists()]);
    }

    /**
     * 首页新闻列表
     * @return [type] [description]
     */
    private function getNewsLists()
    {
        $user_id = Auth::user()->id;
        // 获取新闻中心
        return ArticleModel::where('category_id',22)
                    ->whereNotIn('id',function($query)use($user_id){
                        $query->from('news_read_log')->where('user_id',$user_id)->select('article_id');
                    })
                    ->orderBy('id','desc')
                    ->take(4)
                    ->get()
                    ->toArray();

    }

    /**
     * 投放分布
     * @return [type] [description]
     */
    private function touFang($user_type)
    {
        // 初始化
        $one['1'] = date("Y",time())."-01-01 00:00:00";
        $one['1_'] = date("Y",time())."-01-31 23:59:59";

        $one['2'] = date("Y",time())."-02-01 00:00:00";
        $one['2_'] = date("Y",time())."-02-01 23:59:59";

        $one['3'] = date("Y",time())."-03-01 00:00:00";
        $one['3_'] = date("Y",time())."-03-31 23:59:59";

        $one['4'] = date("Y",time())."-04-01 00:00:00";
        $one['4_'] = date("Y",time())."-04-30 23:59:59";

        $one['5'] = date("Y",time())."-05-01 00:00:00";
        $one['5_'] = date("Y",time())."-05-31 23:59:59";
        
        $one['6'] = date("Y",time())."-06-01 00:00:00";
        $one['6_'] = date("Y",time())."-06-30 23:59:59";
        $one['7'] = date("Y",time())."-07-01 00:00:00";
        $one['7_'] = date("Y",time())."-07-31 23:59:59";
        $one['8'] = date("Y",time())."-08-01 00:00:00";
        $one['8_'] = date("Y",time())."-08-31 23:59:59";

        $one['9'] = date("Y",time())."-09-01 00:00:00";
        $one['9_'] = date("Y",time())."-09-30 23:59:59";

        $one['10'] = date("Y",time())."-10-01 00:00:00";
        $one['10_'] = date("Y",time())."-10-31 23:59:59";

        $one['11'] = date("Y",time())."-11-01 00:00:00";
        $one['11_'] = date("Y",time())."-11-30 23:59:59";

        $one['12'] = date("Y",time())."-12-01 00:00:00";
        $one['12_'] = date("Y",time())."-12-31 23:59:59";
        //初始化 35网络媒体 37户外媒体 38平面媒体 39电视媒体 40广播媒体 41记者预约 42内容代写 43宣传定制
        $data_all = [
            35 => '0,0,0,0,0,0,0,0,0,0,0,0',
            37 => '0,0,0,0,0,0,0,0,0,0,0,0',
            38 => '0,0,0,0,0,0,0,0,0,0,0,0',
            39 => '0,0,0,0,0,0,0,0,0,0,0,0',
            40 => '0,0,0,0,0,0,0,0,0,0,0,0',
            41 => '0,0,0,0,0,0,0,0,0,0,0,0',
            42 => '0,0,0,0,0,0,0,0,0,0,0,0',
            43 => '0,0,0,0,0,0,0,0,0,0,0,0',
        ];
        if ($user_type == 3) {
            // 统计几大媒体的订单总数
            // 后台统计
            $all = OrderNetworkModel::leftJoin("plate",'plate.id','=','order_network.type_id');

            if (Auth::user()->user_type != 1) {
                $all = OrderNetworkModel::leftJoin("plate",'plate.id','=','order_network.type_id')
                        ->whereIn('supp_user_id',function($query){
                            $query->from('supp_users')->where('parent_id', Auth::user()->id)->select('user_id')->get();
                        });
            }
            //供应商统计
            $all = $all
                    ->select(
                        DB::raw("count(case when order_network.created_at between '".$one[1]."' and '".$one['1_']."' then 1 end) as one"),
                        DB::raw("count(case when order_network.created_at between '".$one[2]."' and '".$one['2_']."' then 1 end) as two"),
                        DB::raw("count(case when order_network.created_at between '".$one[3]."' and '".$one['3_']."' then 1 end) as three"),
                        DB::raw("count(case when order_network.created_at between '".$one[4]."' and '".$one['4_']."' then 1 end) as four"),
                        DB::raw("count(case when order_network.created_at between '".$one[5]."' and '".$one['5_']."' then 1 end) as fives"),
                        DB::raw("count(case when order_network.created_at between '".$one[6]."' and '".$one['6_']."' then 1 end) as six"),
                        DB::raw("count(case when order_network.created_at between '".$one[7]."' and '".$one['7_']."' then 1 end) as seven"),
                        DB::raw("count(case when order_network.created_at between '".$one[8]."' and '".$one['8_']."' then 1 end) as eight"),
                        DB::raw("count(case when order_network.created_at between '".$one[9]."' and '".$one['9_']."' then 1 end) as nine"),
                        DB::raw("count(case when order_network.created_at between '".$one[10]."' and '".$one['10_']."' then 1 end) as ten"),
                        DB::raw("count(case when order_network.created_at between '".$one[11]."' and '".$one['11_']."' then 1 end) as eleven"),
                        DB::raw("count(case when order_network.created_at between '".$one[12]."' and '".$one['12_']."' then 1 end) as twelve")
                        ,'plate.pid'
                        )
                    ->groupBy('plate.pid')
                    ->get()
                    ->toArray();
        } elseif ($user_type == 2) {
            $all = OrderNetworkModel::rightJoin("order",'order_network.order_sn','=','order.order_sn')
                    ->leftJoin("plate",'plate.id','=','order.type_id')
                    ->where('order.ads_user_id',Auth::user()->id)
                    ->select(
                        DB::raw("count(case when order.created_at between '".$one[1]."' and '".$one['1_']."' then 1 end) as one"),
                        DB::raw("count(case when order.created_at between '".$one[2]."' and '".$one['2_']."' then 1 end) as two"),
                        DB::raw("count(case when order.created_at between '".$one[3]."' and '".$one['3_']."' then 1 end) as three"),
                        DB::raw("count(case when order.created_at between '".$one[4]."' and '".$one['4_']."' then 1 end) as four"),
                        DB::raw("count(case when order.created_at between '".$one[5]."' and '".$one['5_']."' then 1 end) as fives"),
                        DB::raw("count(case when order.created_at between '".$one[6]."' and '".$one['6_']."' then 1 end) as six"),
                        DB::raw("count(case when order.created_at between '".$one[7]."' and '".$one['7_']."' then 1 end) as seven"),
                        DB::raw("count(case when order.created_at between '".$one[8]."' and '".$one['8_']."' then 1 end) as eight"),
                        DB::raw("count(case when order.created_at between '".$one[9]."' and '".$one['9_']."' then 1 end) as nine"),
                        DB::raw("count(case when order.created_at between '".$one[10]."' and '".$one['10_']."' then 1 end) as ten"),
                        DB::raw("count(case when order.created_at between '".$one[11]."' and '".$one['11_']."' then 1 end) as eleven"),
                        DB::raw("count(case when order.created_at between '".$one[12]."' and '".$one['12_']."' then 1 end) as twelve")
                        ,'plate.pid'
                        )
                    ->groupBy('plate.pid')
                    ->get()
                    ->toArray();
        }
        $all_sum = [0,0,0,0,0,0,0,0,0,0,0,0];
        foreach ($all as $key => $value) {
            $all_sum[0] += $value['one'];
            $all_sum[1] += $value['two'];
            $all_sum[2] += $value['three'];
            $all_sum[3] += $value['four'];
            $all_sum[4] += $value['fives'];
            $all_sum[5] += $value['six'];
            $all_sum[6] += $value['seven'];
            $all_sum[7] += $value['eight'];
            $all_sum[8] += $value['nine'];
            $all_sum[9] += $value['ten'];
            $all_sum[10] += $value['eleven'];
            $all_sum[11] += $value['twelve'];
            $data_all[$value['pid']] = $value['one'].",".
                                       $value['two'].",".
                                       $value['three'].",".
                                       $value['four'].",".
                                       $value['fives'].",".
                                       $value['six'].",".
                                       $value['seven'].",".
                                       $value['eight'].",".
                                       $value['nine'].",".
                                       $value['ten'].",".
                                       $value['eleven'].",".
                                       $value['twelve'];
        }
        return [$data_all, implode(',', $all_sum)];
    }

    public function excelAccountExcel()
    {
        $supp_cellData = [];
        $supp_cellData[] = [
            '序号','供应商','时间','消费类型','金额','流水订单号','订单名称','所属会员','会员佣金','平台获利','状态'
        ];
        $supp_lists = UserAccountLogModel::with(['suppUser','order.parent_order.user'])
                ->leftJoin('users','users.id','=','user_account_log.user_id')
                ->where('user_type', 3)
                ->select('user_account_log.*')
                ->get();
        $account_type = [ 1 => '充值', 2 => '消费', 3 => '提现', 4 => '收入', 5 => '退款'];
        foreach ($supp_lists as $key => $value) {
            $order_id = $platform = 0;
            if (in_array($value['account_type'], [1,3])) {
                $order_id = $value['order_id'];
            } else {
                $order_id = $value['order']['id'];
            }
            if ($value['account_type'] == 1) {
                $platform = $value['user_money'];
            } else {
                $platform = $value['order']['platform'];
            }
            $supp_cellData[] = [
                $value['id'],
                $value['suppUser']['name'],
                $value['created_at'],
                $account_type[$value['account_type']],
                $value['user_money'],
                $order_id,
                $value['order']['parent_order']['title'],
                $value['order']['parent_order']['user']['name'],
                $value['order']['commission'],
                $platform,
                $value['status'] == 1 ? '到账' : '未到账',
            ];
        }
        $ads_cellData = [];
        $ads_cellData[] = [
            '序号','会员','用户角色','时间','消费类型','描述','金额','流水订单号','订单名称','供应商','会员佣金','平台获利','状态'
        ];

        $supp_lists = UserAccountLogModel::with(['ads_user',
            'suppUser.order',
            'order.parent_order',
            'order.suppUser'])
            ->leftJoin('users','users.id','=','user_account_log.user_id')
                ->where('users.user_type', 2)
                ->orderBy('user_account_log.id','desc')
                ->select('user_account_log.*','users.user_type')
                ->get()
                ->toArray();
        $account_type = [ 1 => '充值', 2 => '消费', 3 => '提现', 4 => '收入', 5 => '退款'];
        foreach ($supp_lists as $key => $value) {
            $order_id = $platform = 0;
            if ($value['user_type'] == 3) {
                $user_class = '供应商';
                $username = $value['suppUser']['name'];
            } elseif ($value['user_type'] == 2) {
                if ($value['ads_user']['level_id'] > 2) {
                    $user_class = '高级会员';
                } else {
                    if ($value['ads_user']['parent_id'] == 0) {
                        $user_class = '注册会员';
                    } else {
                        $user_class = '代理会员';
                    }
                }
                $username = $value['ads_user']['nickname'];
            }
            if (in_array($value['account_type'], [1,3])) {
                $order_id = $value['order_id'];
            } else {
                $order_id = $value['order']['id'];
            }
            if ($value['account_type'] == 1) {
                $platform = $value['user_money'];
            } else {
                $platform = $value['order']['platform'];
            }

            $ads_cellData[] = [
                $value['id'],
                $value['ads_user']['nickname'],
                $user_class,
                $value['created_at'],
                $account_type[$value['account_type']],
                $value['desc'],
                $value['user_money'],
                $order_id,
                $value['order']['parent_order']['title'],
                $value['order']['supp_user']['name'],
                $value['order']['commission'],
                $platform,
                $value['status'] == 1 ? '到账' : '未到账',
            ];
        }
        $account_type = [ 1 => '充值', 2 => '消费', 3 => '提现', 4 => '收入', 5 => '退款'];

        // 平台收益
        $form_cellData = [];
        $form_cellData[] = [
            '序号',
            '用户名',
            '用户角色',
            '消费类型',
            '交易金额',
            '平台获利',
            '供应商所得',
            '会员佣金',
            '描述',
            '时间',
            '流水订单号',
            '订单名称',
            '状态'
        ];
        $form_lists = UserAccountLogModel::
                    leftJoin('users','users.id','=','user_account_log.user_id')
                    ->whereIn('user_account_log.account_type', [1,3,2])
                    ->with(['suppUser','ads_user','order'])
                    ->select('user_account_log.*','users.user_type')
                    ->where('users.user_type', '<>', 1)
                    ->get();
        foreach ($form_lists as $key => $value) {
            if ($value['user_type'] == 3) {
                $user_class = '供应商';
                $username = $value['suppUser']['name'];
            } elseif ($value['user_type'] == 2) {
                if ($value['ads_user']['level_id'] > 2) {
                    $user_class = '高级会员';
                } else {
                    if ($value['ads_user']['parent_id'] == 0) {
                        $user_class = '注册会员';
                    } else {
                        $user_class = '代理会员';
                    }
                }
                $username = $value['ads_user']['nickname'];
            }
            $order_id = $platform = 0;
            if (in_array($value['account_type'], [1,3])) {
                $order_id = $value['order_id'];
            } else {
                $order_id = $value['order']['id'];
            }
            $supp_money = "";
            $commission = "";
            if ($value['account_type'] == 1) {
                $platform = $value['user_money'];
            } elseif($value['account_type'] == 3) {
                $platform = '-'.$value['user_money'];
            } else {
                $supp_money = "-".$value['order']['supp_money'];
                $commission = "-".$value['order']['commission'];
                $platform = $value['order']['platform'];
            }
            $form_cellData[] = [
                $value['id'],
                $username,
                $user_class,
                $account_type[$value['account_type']],
                $value['order']['user_money'],
                $platform,
                $supp_money,
                $commission,
                $value['desc'],
                $value['created_at'],
                $order_id,
                $value['order']['parent_order']['title'],
                $value['status'] == 1 ? '到账' : '未到账',
            ];
        }

        Excel::create('财务流水'.date('Y/m/d H:i',time()),function($excel) use ($supp_cellData,$ads_cellData,$form_cellData){
            $excel->sheet('供应商金额流水', function($sheet) use ($supp_cellData){
                $sheet->rows($supp_cellData);
                $sheet->row(1,function($row){
                    // 单元格处理方法
                    $row ->setBackground('#3376b3'); // 设置单元格背景
                    $row ->setFontColor('#ffffff'); // 改变字体颜色
                    // 分开设置字体
                    $row ->setFontSize(11);  
                    //要改变当前表的字体用：->setFont($array)
                    $row ->setFont([
                        'family' => '宋体', // 设置字体
                        'size' => '11', // 改变字体大小
                        'bold' => true // 字体设置为粗体
                    ]);
                    // 设置边框
                    // $row -> setBorder('solid','none','none','solid');
                    //设置水平对齐
                    $row ->setAlignment('center');
                    //设置垂直对齐
                    $row ->setValignment('middle');
                });
            });
            $excel->sheet('会员流水', function($sheet)use($ads_cellData){
                $sheet->rows($ads_cellData);
                $sheet->row(1,function($row){
                    // 单元格处理方法
                    $row ->setBackground('#3376b3'); // 设置单元格背景
                    $row ->setFontColor('#ffffff'); // 改变字体颜色
                    // 分开设置字体
                    $row ->setFontSize(11);  
                    //要改变当前表的字体用：->setFont($array)
                    $row ->setFont([
                        'family' => '宋体', // 设置字体
                        'size' => '11', // 改变字体大小
                        'bold' => true // 字体设置为粗体
                    ]);
                    // 设置边框
                    // $row -> setBorder('solid','none','none','solid');
                    //设置水平对齐
                    $row ->setAlignment('center');
                    //设置垂直对齐
                    $row ->setValignment('middle');
                });
            });
            $excel->sheet('平台收益流水', function($sheet)use($form_cellData){
                $sheet->rows($form_cellData);
                 $sheet->row(1,function($row){
                    // 单元格处理方法
                    $row ->setBackground('#3376b3'); // 设置单元格背景
                    $row ->setFontColor('#ffffff'); // 改变字体颜色
                    // 分开设置字体
                    $row ->setFontSize(11);  
                    //要改变当前表的字体用：->setFont($array)
                    $row ->setFont([
                        'family' => '宋体', // 设置字体
                        'size' => '11', // 改变字体大小
                        'bold' => true // 字体设置为粗体
                    ]);
                    // 设置边框
                    // $row -> setBorder('solid','none','none','solid');
                    //设置水平对齐
                    $row ->setAlignment('center');
                    //设置垂直对齐
                    $row ->setValignment('middle');
                });
            });
        })->export('xls');
    }


}
