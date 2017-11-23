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

use Auth;
use Cache;
use DB;
use Session;

class AdminUserController extends CommonController
{
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->request = $request;
    }

    /**
     * 普通会员模板渲染
     */
    public function AdUserList(Request $request)
    {
        $lists = UsersModel::leftJoin('ad_users','ad_users.user_id','=','users.id')
                    ->leftJoin('order_network','ad_users.user_id','=','order_network.ads_user_id')
                    ->where('users.user_type',2)
                    ->where('ad_users.level_id',1);
        if (!empty($request->start)) {
            $lists = $lists->where('users.created_at', '>=', $request->start);
        }
        if (!empty($request->end)) {
            $lists = $lists->where('users.created_at', '<=', $request->end);
        }
        if (!empty($request->keyword)) {
            $lists = $lists->where('users.name', 'like', '%'.$request->keyword.'%');
        }
        $lists = $lists->select(
                        'ad_users.id',
                        'ad_users.nickname',
                        'ad_users.created_at',
                        'ad_users.user_money',
                        'ad_users.user_id',
                        'ad_users.child_user_num',
                        'ad_users.check_status',
                        'ad_users.parent_id',
                        'users.is_login',
                        'users.name',
                        DB::raw("count(order_network.id) as order_count")
                    )
                    ->groupBy('ad_users.id')
                    ->get()
                    ->toArray();
        if ($request->get_excel == 1) {
            $this->getUserExcel($lists, 1);
        }
        return view('console.admin_user.ad_user_list',['lists' => $lists]);
    }
    /**
     * 所属代理会员模板渲染
     */
    public function DailiUserList(Request $request)
    {
        $ad_user_list = AdUsersModel::with('parentUser')
                            ->leftJoin('users','users.id','=','ad_users.user_id')
                            ->leftJoin("order_network",'ad_users.user_id','=','order_network.ads_user_id')
                            ->where("ad_users.parent_id",$request->input('pid'));
        
        if (!empty($request->input('start'))) {
            $ad_user_list = $ad_user_list->where('ad_users.created_at','>=',$request->input('start'));
        }
        if (!empty($request->input('end'))) {
            $ad_user_list = $ad_user_list->where('ad_users.created_at','<=',$request->input('end'));
        }
        if (!empty($request->input('keyword'))) {
            $ad_user_list = $ad_user_list->where('ad_users.nickname','like','%'.$request->input('keyword').'%');
        }

        $ad_user_list = $ad_user_list->select(
                            'ad_users.id',
                            'ad_users.nickname',
                            'ad_users.created_at',
                            'ad_users.user_money',
                            'ad_users.user_id',
                            'ad_users.child_user_num',
                            'ad_users.check_status',
                            'ad_users.parent_id',
                            DB::raw("count(order_network.id) as order_count"),
                            'users.is_login'
                        )
                    ->groupBy('ad_users.id')
                    ->get()
                    ->toArray();
        if ($request->input('get_excel') == 1) {
            $this->getUserExcel($ad_user_list,2);
        }
        return view('console.admin_user.daili_user_list', ['user_list' => $ad_user_list]);
    }

	/**
     * 所属代理会员信息
     * @param [type] $user_id [description]
     */
    public function DailiUserInfo($user_id)
    {
        $info = AdUsersModel::with(['user','parentUser'])->where('user_id',$user_id)->first()->toArray();
        //一周的订单数统计
        $plate_data = getOrderCount($user_id,2,getTimeInterval('now_week'));
        $rechange = getAccountCount($user_id, 1); //充值
        $getCash = getAccountCount($user_id,3); //提现
        $media = PlateModel::where('pid',0)->get()->toArray();
        
        return view('console.admin_user.dailiuser_info',
            ['info' => $info,
             'plate_data' => $plate_data,
             'used_money' => getUsedMoney($user_id),
             'rechange' => $rechange,
             'get_cash' => $getCash,
             'media' => $media]);
    }
	
    /**
     * 高级会员列表模板渲染
     */
    public function SupperAdsUserList(Request $request)
    {
        $ad_user_list = AdUsersModel::with('parentUser')
                ->leftJoin('users','users.id','=','ad_users.user_id')
                ->leftJoin("order_network",'ad_users.user_id','=','order_network.ads_user_id');

        if (!empty($request->input('check_status'))) {
            $ad_user_list = $ad_user_list->where('ad_users.check_status','=',$request->input('check_status'));
        }
        if (!empty($request->input('start'))) {
            $ad_user_list = $ad_user_list->where('ad_users.created_at','>=',$request->input('start'));
        }
        if (!empty($request->input('end'))) {
            $ad_user_list = $ad_user_list->where('ad_users.created_at','<=',$request->input('end'));
        }
        if (!empty($request->input('keyword'))) {
            $ad_user_list = $ad_user_list->where('ad_users.nickname','like','%'.$request->input('keyword').'%');
        }

        if (!empty($request->input('pid'))) {
            $ad_user_list = $ad_user_list->where("ad_users.parent_id",$request->input('pid'));
        }
        $ad_user_list = $ad_user_list->where("ad_users.level_id",2);
        $lists = $ad_user_list->select(
                                        'ad_users.id',
                                        'ad_users.nickname',
                                        'ad_users.created_at',
                                        'ad_users.user_money',
                                        'ad_users.user_id',
                                        'ad_users.child_user_num',
                                        'ad_users.check_status',
                                        'ad_users.parent_id',
                                        'users.is_login',
                                        'users.name',
                                        DB::raw("count(order_network.id) as order_count")
                                    )
                                ->groupBy('ad_users.id')
                                ->get()
                                ->toArray();
        return view('console.admin_user.supper_ad_user_list', ['lists' => $lists]);
    }

    /**
     * ajax请求广告主列表
     * @return [type] [description]
     */
    public function adsUserList($type='ajax')
    {
        $ad_user_list = AdUsersModel::with('parentUser')
                            ->leftJoin('users','users.id','=','ad_users.user_id')
                            ->leftJoin("order_network",'ad_users.user_id','=','order_network.ads_user_id');

        if (!empty($this->request->input('check_status'))) {
            $ad_user_list = $ad_user_list->where('ad_users.check_status','=',2);
        }
        if (!empty($this->request->input('start'))) {
            $ad_user_list = $ad_user_list->where('ad_users.created_at','>=',$this->request->input('start'));
        }
        if (!empty($this->request->input('end'))) {
            $ad_user_list = $ad_user_list->where('ad_users.created_at','<=',$this->request->input('end'));
        }
        if (!empty($this->request->input('orderid'))) {
            $ad_user_list = $ad_user_list->where('ad_users.nickname','like','%'.$this->request->input('orderid').'%');
        }

        if (!empty($this->request->input('pid'))) {
            $ad_user_list = $ad_user_list->where("ad_users.parent_id",$this->request->input('pid'));
        }

        if ($this->request->input('level_id') == 2) {
            if (empty($this->request->input('pid'))) { //代理会员列表传来 不需要加这个条件
                $ad_user_list = $ad_user_list->where("ad_users.level_id",2);
            }
            $user_type = 2;
        } elseif ($this->request->input('level_id') == 1) {
            $ad_user_list = $ad_user_list->where("ad_users.level_id",1);
            $user_type = 1;
        } else {
            $user_type = 3;
        }
        $ad_user_list = $ad_user_list->select(
                                        'ad_users.id',
                                        'ad_users.nickname',
                                        'ad_users.created_at',
                                        'ad_users.user_money',
                                        'ad_users.user_id',
                                        'ad_users.child_user_num',
                                        'ad_users.check_status',
                                        'ad_users.parent_id',
                                        DB::raw("count(order_network.id) as order_count"),
                                        'users.is_login'
                                    )
                                ->groupBy('ad_users.id')
                                ->get()
                                ->toArray();
        if ($type == 'n_ajax') { // 渲染模板func调用此处
            return $ad_user_list;
        }
        if ($this->request->input('get_excel') == 1) {
            $this->getUserExcel($ad_user_list,$user_type);
        }
        $htmls = "";
        foreach ($ad_user_list as $key => $value) {
            if (is_null($value['user_id'])) continue;
            $parent_name = !empty($value['parent_user']) ? $value['parent_user']['nickname'] : '';
            $htmls .= "<tr>";
            $htmls .= "<td>".$value['user_id']."</td>";
            $htmls .= "<td>".$value['nickname']."</td>";
            $htmls .= "<td>".$value['created_at']."</td>";
            $htmls .= "<td>".$value['order_count']."</td>";
            $htmls .= "<td class=\"color1\">".$value['user_money']."</td>";
            // pid 针对 查看下级的时候
            if ($this->request->input('level_id') == 2 && empty($this->request->input('pid'))) {
                $htmls .= "<td>".$value['child_user_num']."</td>";
            }
            if (!empty($this->request->input('check_status'))) {
                $htmls .= "<td>".getVipCheckType($value['check_status'])."</td>";
            }
            if ($user_type != 3) {
                $login = $value['is_login'] == 1 ? '在线' : '下架';
                $htmls .= "<td>".$login."</td>";
            }
            $htmls .= "<td><a class=\"color2\" href=\"/user/ad_user/".$value['user_id']."\">查看</td>";
        }
        return $htmls;
    }

    public function getUserExcel($data, $user_type)
    {
        $tab = [
            1 => ['序号', '用户名', '创建时间', '订单数(发布)', '账户余额', '状态'], // 普通会员
            2 => ['序号', '用户名', '所属会员', '创建时间', '订单数', '账户余额', '会员资源'], // 广告主
            3 => ['序号', '用户名', '所属会员', '创建时间', '订单数', '账户余额', '申请状态'], // 申请高级会员
        ];
        $title = [
            1 => '普通会员列表',
            2 => '高级广告主',
            3 => '申请高级会员',
        ];
        $cell_data[] = $tab[$user_type];
        foreach ($data as $key => $value) {
            if (is_null($value['user_id'])) continue;
            $parent_name = !empty($value['parent_user']) ? $value['parent_user']['nickname'] : '';
            if ($user_type == 1) {
                $cell_data[] = [
                    $value['user_id'],
                    $value['name'],
                    $value['created_at'],
                    $value['order_count'],
                    $value['user_money'],
                    $value['is_login'] == 1 ? '在线' : '下架',
                ];
            } elseif ($user_type == 2) {
                dd($value);
                $cell_data[] = [
                    $value['user_id'],
                    $value['name'],
                    $parent_name,
                    $value['created_at'],
                    $value['order_count'],
                    $value['user_money'],
                    $value['child_user_num'],
                ];
            } else {
                $cell_data[] = [
                    $value['user_id'],
                    $value['nickname'],
                    $parent_name,
                    $value['created_at'],
                    $value['order_count'],
                    $value['user_money'],
                    getVipCheckType($value['check_status']),
                ];
            }
            
        }
        getExcel($title[$user_type], $title[$user_type], $cell_data);
    }

	/**
     * 广告主用户信息
     * @param [type] $user_id [description]
     */
    public function AdUserInfo($user_id)
    {
        $info = AdUsersModel::with(['user','parentUser'])->where('user_id',$user_id)->first()->toArray();
        //一周的订单数统计
        $plate_data = getOrderCount($user_id,2,getTimeInterval('now_week'));
        // DB::enableQueryLog();
        $rechange = getAccountCount($user_id, 1); //充值
        // dd(DB::getQueryLog());
        $getCash = getAccountCount($user_id,3); //提现
        $media = PlateModel::where('pid',0)->get()->toArray();
        return view('console.admin_user.user_info',
            ['info' => $info,
             'plate_data' => $plate_data,
             'used_money' => getUsedMoney($user_id),
             'rechange' => $rechange,
             'get_cash' => $getCash,
             'media' => $media]);
    }

    /**
     * 获取广告主订单列表
     * @return [type] [description]
     */
    public function getAdsOrderList()
    {
        if (\Request::ajax()) {
            $pid = $this->request->input('mediatype');
            $user_id = $this->request->input('user_id');

            $lists = OrderNetworkModel::leftJoin('order','order.order_sn','=','order_network.order_sn')
                                ->where('order.ads_user_id','=',$user_id)
                                ->whereIn('order.type_id',function($query)use($pid){
                                    $query->from('plate')->where('pid',$pid)->select('id');
                                  });
            if (!empty($this->request->input('orderid'))) {
                $lists = $lists->where('order_network.id',$this->request->input('orderid'));
            }
            if (!empty($this->request->input('start'))) {
                $lists = $lists->where('order.created_at','>=',$this->request->input('start'));
            }
            if (!empty($this->request->input('end'))) {
                $lists = $lists->where('order.created_at','<=',$this->request->input('end'));
            }
            $lists = $lists->select('order_network.id','order_network.type_name','order_network.user_money',
                                         'order_network.type_id','order.start_at',
                                         'order.over_at','order_network.order_type',
                                         'order_network.success_url','order_network.success_pic',
                                         'order.title','order_network.deal_with_status','order_network.media_type')
                            ->get()
                            ->toArray();
            //处理html
            $htmls = "";
            foreach ($lists as $key => $value) {
                $htmls .= "<tr>";
                $htmls .= "<td>".$value['id']."</td>";
                $htmls .= "<td>".$value['title']."</td>";
                $htmls .= "<td>".$value['type_name']."</td>";
                $htmls .= "<td>".$value['start_at']."</td>";
                $htmls .= "<td>".$value['over_at']."</td>";
                $htmls .= "<td class=\"color1\">￥".$value['user_money']."</td>";
                $htmls .= "<td>".getOrderType($value['order_type']);
                if ($value['deal_with_status'] == 2) {
                    $htmls .= '，重做';
                } elseif ($value['deal_with_status'] == 1) {
                    $htmls .= '，此订单退款处理';
                } elseif ($value['deal_with_status'] == 3) {
                    $htmls .= '，不同意申诉，结款';
                }
                if ($value['media_type'] == 12) {
                    $htmls .= ',重指派';
                }
                $htmls .= "</td>";
                $htmls .= "<td>";
                if ($value['success_url']) {
                    $htmls .= "<a target=\"_blank\" href='".$value['success_url']."'>查看链接</a> | ";
                }
                if ($value['success_pic']) {
                    $htmls .= "<img src='".$value['success_pic']."' onclick=\"window.location.href='".$value['success_pic']."'\">";
                }
                $htmls .= "</td></tr>";
            }
            echo $htmls;
        }
    }

    /**
     * 更新广告主资料
     * @param Request $request [description]
     */
    public function AdUserUpdate(Request $request)
    {
        $info = AdUsersModel::where('user_id',$this->request->input('user_id'))->first();
        $user_model = UsersModel::where('id',$this->request->input('user_id'))->first();
        if ($info) {
            $info->nickname = !empty($request->input('nickname')) ? $request->input('nickname') : $info->nickname;
            $info->qq = !empty($request->input('qq')) ? $request->input('qq') : $info->qq;
            $info->email = !empty($request->input('email')) ? $request->input('email') : $info->email;
            $info->address = !empty($request->input('address')) ? $request->input('address') : $info->address;
            $info->company = !empty($request->input('company')) ? $request->input('company') : $info->company;
            $info->breif = !empty($request->input('breif')) ? $request->input('breif') : $info->breif;
        }
        if (!empty($request->is_login)) {
            $user_model->is_login = $request->input('is_login');
        }
        $user_model->save();
        //检查是否审核
        if ($request->input('check_status') == 3) { //不通过
            $info->check_status = 3;
        } elseif ($request->input('check_status') == 4) {
            $info->level_id = 2; // 高级会员
            $info->check_status = 4;
            // 清掉上级
            // $info->parent_id = 0;
        }
        if ($info->save()) {
            return redirect('/user/ad_user/'.$request->input('user_id'))->with('status', '更新成功');
        } else {
            return redirect('/user/ad_user/'.$request->input('user_id'))->with('status', '无变动');
        }
    }

    /**
     * 会员申请列表
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function apply(Request $request)
    {
        if (\Request::ajax() || $request->input('get_excel') == 1) {
            return $this->adsUserList();
        }
        $ad_user_list = AdUsersModel::with('parentUser')
                            ->leftJoin("order_network",'ad_users.user_id','=','order_network.ads_user_id');

        $ad_user_list = $ad_user_list->where('ad_users.check_status','=',2);
        if (!empty($this->request->input('start'))) {
            $ad_user_list = $ad_user_list->where('ad_users.created_at','>=',$this->request->input('start'));
        }
        if (!empty($this->request->input('end'))) {
            $ad_user_list = $ad_user_list->where('ad_users.created_at','<=',$this->request->input('end'));
        }
        if (!empty($this->request->input('orderid'))) {
            $ad_user_list = $ad_user_list->where('ad_users.nickname','like','%'.$this->request->input('orderid').'%');
        }

        if (!empty($this->request->input('pid'))) {
            $ad_user_list = $ad_user_list->where("ad_users.parent_id",$this->request->input('pid'));
        }
        $lists = $ad_user_list->select(
                                        'ad_users.id',
                                        'ad_users.nickname',
                                        'ad_users.created_at',
                                        'ad_users.user_money',
                                        'ad_users.user_id',
                                        'ad_users.child_user_num',
                                        'ad_users.check_status',
                                        'ad_users.parent_id',
                                        DB::raw("count(order_network.id) as order_count")
                                    )
                                ->groupBy('ad_users.id')
                                ->get()
                                ->toArray();
        return view('console.admin_user.vip_apply_list', ['lists' => $lists]);
    }

    

}
