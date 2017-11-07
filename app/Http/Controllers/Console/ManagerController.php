<?php

namespace App\Http\Controllers\Console;

use Illuminate\Http\Request;
use App\Http\Controllers\Console\CommonController;

use App\Model\CustomerModel;
use App\Model\AdminMenuModel;
use App\Model\PlateModel;
use App\Model\PlateAttrModel;
use App\Model\PlateAttrValueModel;
use App\Model\OrderNetworkModel;
use App\Model\OrderAppealModel;
use App\Model\UserAccountLogModel;
use App\Model\SuppUsersModel;
use App\Model\AdUsersModel;
use App\Model\InvoModel;
use App\Model\CategoryModel;
use App\Model\ArticleModel;
use App\Model\PhoneOrderModel;
use App\Model\OrderModel;
use App\Model\ActivityModel;
use App\Model\ActivityVsUserModel;
use App\Model\SuppUsersSelfModel;
use App\Model\SuppVsAttrModel;
use App\Model\OrderMediaLogModel;
use App\Model\OrderLogModel;
use App\Model\OrderNetworkRefundModel;

use App\User;
use Auth;
use Cache;
use DB;
use Session;

class ManagerController extends CommonController
{
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->request = $request;
    }
    
    /**
     * 添加菜单
     */
    public function addMenu()
    {
        //获取顶级栏目
        $category_list = AdminMenuModel::where('pid',0)
                                            ->orderBy('id','ASC')
                                            ->get()
                                            ->toArray();
        return view('console.manager.add_menu',[
                'category_list' => $category_list,
            ]);
    }

    /**
     * 编辑菜单
     * @return [type] [description]
     */
    public function editCategory($id)
    {
        $res_data = AdminMenuModel::with(['admin_menu'])->where('id',$id)->first()->toArray();
        //获取顶级
        $category_list = AdminMenuModel::where('pid',0)
                                            ->orderBy('id','ASC')
                                            ->get()
                                            ->toArray();
        //获取同级所有菜单
        $child_list = AdminMenuModel::where('pid',$res_data['pid'])->get()->toArray();
        return view('console.manager.edit_menu',
                ['res_data' => $res_data, 'category_list' => $category_list, 'child_list' => $child_list]);
    }

    /**
     * 获取二级菜单
     * @return [type] [description]
     */
    public function getCategory(Request $request)
    {
        $catid = $request->input('catid');
        $menu_list = AdminMenuModel::where('pid',$catid)
                        ->whereIn('type',[1,2])
                        ->orderBy('id','asc')
                        ->get()
                        ->toArray();
        return ['status_code' => 200, 'data' => $menu_list, 'msg' => ''];
    }

    /**
     * 更新、添加菜单
     * @return [type] [description]
     */
    public function updateCategory()
    {
        if (empty($this->request->input('id'))) {
            $admin_menu = new AdminMenuModel;
        } else {
            $admin_menu = AdminMenuModel::where('id',$this->request->input('id'))->find();
        }

        if ($this->request->input('cate_id') == '-1') { //顶级
            $admin_menu->pid = 0;
        } else {
            $admin_menu->pid = $this->request->has('child_id') ? $this->request->input('child_id') : $this->request->input('cate_id');
            $admin_menu->level_id = 2;
        }
        
        $admin_menu->type    = $this->request->input('type');
        $admin_menu->is_show = $this->request->input('is_show');
        $admin_menu->menu    = $this->request->input('menu');
        $admin_menu->ico     = $this->request->input('ico');
        $admin_menu->route   = $this->request->input('route');

        $adminUid = session('admin_id');
        if ($adminUid == 1) { //高级权限
            $menuList = AdminMenuModel::with(['admin_menu'])
                        ->where('is_show',1)
                        ->where('pid',0)
                        ->get()
                        ->toArray();
            Cache::forever('adminMenu_'.$adminUid, $menuList);
        }

        if ($admin_menu->save()) {
            return ['status_code' => 200, 'msg' => ''];
        } else {
            return ['status_code' => 201, 'error' => '失败'];
        }
    }

    public function categoryList()
    {
        $category_list = AdminMenuModel::with(['admin_menu'])
                            ->where('pid',0)
                            ->get()
                            ->toArray();
        return view('console.manager.category_list', ['category_list' => $category_list]);
    }

    /**
     * [media description]
     * @return [type] [description]
     */
    public function media()
    {

        $plate_id = $this->request->input('plate_id',35);
        $plate_list = PlateModel::where('pid',0)
                                ->where('is_show',1)
                                ->orderBy('id','asc')
                                ->get()
                                ->toArray();
        // \DB::enableQueryLog();
        $lists = PlateModel::with(['plateVsAttr','plateVsAttr.attrVsVal'])
                        ->where('pid',$plate_id)
                        ->get()
                        ->toArray();
        return view('console.manager.media',['plate_list' => $plate_list,'lists' => $lists]);
    }

    /**
     * 更新媒体资源
     * @return [type] [description]
     */
    public function updateMedia()
    {
        $plate_attr = PlateAttrModel::where("id",$this->request->input('attr_id'))->first();
        
        if ($this->request->input('attr_val_id')) {
            
        } else {
            $plate_attr_value = new PlateAttrValueModel;
        }
        $plate_id = !empty($plate_attr_value->id) ? $plate_attr_value->id : 0;
        $plate_attr_value->attr_value = $this->request->input('val');
        $plate_attr_value->attr_name = $plate_attr->attr_name;
        $plate_attr_value->attr_id = $plate_attr->id;
        $plate_attr_value->path = $plate_attr->path.'_'.$plate_id;
        $flag = $plate_attr_value->save();
        if (!$plate_id) {
            $plate_attr_value->path = $plate_attr->path.'_'.$plate_attr_value->id;
            $plate_attr_value->save();
        }
        if ($flag) {
            return ['status_code' => 200];
            // redirect('/console/index')->withInput()->with('status', '创建');
        } else {
            return ['status_code' => 202, 'msg' => '添加失败'];
        }
    }

    /**
     * 订单列表
     * @param  [type] $media_id 媒体id
     * @return [type]           [description]
     */
    public function order(Request $request,$media_id)
    {
        \DB::enableQueryLog();
        $type = $request->type;
        if (!$type || $type == 11) { // 全部订单、未匹配
            $child_lists = OrderNetworkModel::with(['suppUser.parentUser','selfUser'])
                    ->leftJoin('order','order_network.order_sn','=','order.order_sn')
                    ->leftJoin('users','users.id','=','order.ads_user_id')
                    ->leftJoin('supp_users_self as media','media.user_id','=','order_network.self_uid');
        } else {
            $child_lists = OrderNetworkModel::with(['suppUser.parentUser','selfUser'])->leftJoin('order','order_network.order_sn','=','order.order_sn')
                    ->leftJoin('users','users.id','=','order.ads_user_id')
                    ->leftJoin('supp_users_self as media','media.user_id','=','order_network.self_uid');
        }
        // 筛选
        if (!empty($request->input('start'))) {
            $child_lists = $child_lists->where('order_network.created_at','>=',$request->input('start'));
        }
        if (!empty($request->input('end'))) {
            $child_lists = $child_lists->where('order_network.created_at','<=',$request->input('end'));
        }
        if (!empty($request->input('orderid'))) {
            $child_lists = $child_lists->where('order_network.id','=',$request->input('orderid'));
        }
        if (!empty($request->input('type'))) {
            if ($type == 4) {
                $child_lists = $child_lists->whereIn('order_network.order_type',[4,5]);
            } elseif($type == 12) {
                $child_lists = $child_lists->where(function($query){
                    $query
                    ->Where(function($query){
                        $query->whereIn('order_network.order_type',[9,12,14,15])
                                ->orWhere(function($query){
                                     $query->where('order_network.order_type',13)
                                        ->Where('order_network.deal_with_status',1);
                                });
                    });
                });
            }else{
                $child_lists = 
                    $child_lists->where('order_network.order_type','=',$request->type);
            }
        } else {
            $child_lists = $child_lists->whereNotIn('order_network.order_type',[9,12,14,15])// 退款
                        ->Where(function($query){
                            $query->where('order_network.order_type','<>',13)
                                    ->Where('order_network.deal_with_status','<>',1);
                        });
        }
        if (!empty($request->input('mediatype'))) {
            $child_lists = $child_lists->where('order_network.type_id','=',$request->input('mediatype'));
        }
        if (!empty($request->keyword)) {
            $child_lists = $child_lists->where('order_network.id','=',$request->input('keyword'));
        }
        // if ($request->input('type') == 9) { //申诉订单
            // $child_lists = $child_lists->select(
            //     'order.title','order.type_name','order.start_at','order.over_at','order.ads_user_id',
            //     'order_network.*','media.name as media_name','users.name as username',
            //     'order_appeal.appeal_title','order_appeal.created_at as appeal_created_at',
            //     'order_appeal.order_type as appeal_type');
        // } else {
            $child_lists = $child_lists->select(
                'order.title','order.type_name','order.start_at','order.over_at','order.ads_user_id',
                'order_network.*','media.media_name','users.name as username');
        // }
            

        $child_lists = $child_lists->get()->toArray();
        // dd(\DB::getQueryLog());
        // dd($child_lists);
        if ($request->input('get_excel') == 1) {
            $this->getOrderListExcel($request->input('type'),$child_lists);
        }
        $html = "";
        
        // foreach ($child_lists as $key => $value) {
            // if ($request->input('type') == 9) { //申诉
            //     $html .= "<tr>";
            //     $html .= "<td>".$value['id']."</td>";
            //     $html .= "<td>".$value['type_name']."</td>";
            //     $html .= "<td>".$value['username']."</td>";
            //     $html .= "<td>".$value['success_url']."</td>";
            //     $html .= "<td>".$value['appeal_title']."</td>";
            //     $html .= "<td>".$value['appeal_created_at']."</td>";
            //     $html .= "<td>";
            //     $html .= getAppealStatus($value['appeal_type']);
            //     $html .= '</td>';
            //     $html .= "<td><a class=\"color2\" href=\"/console/manager/order/info/".$value['id'].'">查看</a></td></tr>';
            // }
        // }
        // dd($child_lists);
        //获取当前媒体下分类
        $child_plate = PlateModel::where('pid',$media_id)->get()->toArray();
        return view('console.manager.order_list',
            ['child_plate' => $child_plate,
            'media_id' => $media_id,
            'child_lists' => $child_lists
            ]);
    }

    /**
     * [getOrderListExcel description]
     * @return [type] [description]
     */
    function getOrderListExcel($type, $data)
    {
        $cell_data = [];
        $cell = [
            0 => [
                '订单号','稿件标题','稿件类型','开始时间','结束时间','价格','所属用户',
                '供应商','媒体名称','完成链接/截图','订单状态'
            ],
            11 => [
                '订单号','稿件标题','稿件类型','开始时间','结束时间','价格','所属用户','媒体名称','订单状态'
            ],
            1 => [
                '订单号','稿件标题','稿件类型','开始时间','结束时间','价格','所属用户','供应商','媒体名称','订单状态'
            ],
            10 => [
                '订单号','稿件标题','稿件类型','价格','所属用户','供应商','媒体名称','完成链接/截图','订单状态'
            ],
            4 => [
                '订单号','稿件标题','稿件类型','价格','所属用户','供应商','媒体名称','完成链接/截图','订单状态'
            ],
            3 => [
                '订单号','稿件标题','稿件类型','开始时间','结束时间','价格','所属用户','供应商','媒体名称','订单状态'
            ],
            2 => [
                '订单号','稿件标题','稿件类型','开始时间','结束时间','价格','所属用户','供应商','媒体名称','订单状态'
            ],
            12 => [
                '订单号','稿件标题','稿件类型','开始时间','结束时间','价格','所属用户','供应商','媒体名称','完成链接/截图','订单状态'
            ]
        ];
        $cell_data = [];
        $cell_data[] = $cell[$type];
        foreach ($data as $key => $value) {
            switch ($type) {
                case '0':
                    $cell_data[] = [
                        $value['id'],
                        $value['title'],
                        $value['type_name'],
                        $value['start_at'],
                        $value['over_at'],$value['user_money'],$value['username'],$value['supp_user']['parent_user']['name'],$value['media_name'],$value['success_url'],
                        getOrderType($value['order_type'])
                    ];
                    break;
                case '11':
                    $tmp = '';
                    if ($value['media_type'] == 12)
                        $tmp = ',重指派';
                    $cell_data[] = [
                        $value['id'],
                        $value['title'],
                        $value['type_name'],
                        $value['start_at'],
                        $value['over_at'],
                        $value['user_money'],
                        $value['username'],
                        $value['media_name'],
                        getOrderType($value['order_type']).$tmp,
                    ];
                    break;
                case '1':
                    $cell_data[] = [
                        $value['id'],$value['title'],$value['type_name'],
                        $value['start_at'],$value['over_at'],$value['user_money'],
                        $value['username'],$value['supp_user']['parent_user']['name'],
                        $value['media_name'],getOrderType($value['order_type'])
                    ];
                break;
                case '10':
                    $tmp = '';
                    if ($value['media_type'] == 12) {
                        $tmp = ',重指派';
                    }
                    $cell_data[] = [
                        $value['id'],
                        $value['title'],
                        $value['type_name'],
                        $value['user_money'],
                        $value['username'],
                        $value['supp_user']['parent_user']['name'],
                        $value['media_name'],
                        $value['success_url'],
                        getOrderType($value['order_type']).$tmp,
                    ];
                break;
                case '4':
                    $tmp = '';
                    if ($value['deal_with_status'] == 2) {
                        $tmp = '，重做';
                    } elseif ($value['deal_with_status'] == 1) {
                        $tmp = '，此订单退款处理';
                    } elseif($value['deal_with_status'] == 3) {
                        $tmp = '，不同意申诉，结款';
                    }
                    $cell_data[] = [
                        $value['id'],
                        $value['title'],
                        $value['type_name'],
                        $value['start_at'],
                        $value['over_at'],
                        $value['user_money'],
                        $value['username'],
                        $value['supp_user']['parent_user']['name'],
                        getOrderType($value['order_type']).$tmp,
                    ];
                    break;
                default:
                    $cell_data[] = [
                        $value['id'],
                        $value['title'],
                        $value['type_name'],
                        $value['start_at'],
                        $value['over_at'],
                        $value['user_money'],
                        $value['username'],
                        $value['supp_user']['parent_user']['name'],
                        $value['media_name'],
                        $value['success_url'],
                        getOrderType($value['order_type'])
                        ];
                    break;
            }
        }
        getExcel(getOrderType($type).'订单_'.date('Y-m-d',time()),getOrderType($type).'订单_'.date('Y-m-d',time()),$cell_data);
    }

    /**
     * 订单详情
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function orderInfo($id,Request $request)
    {
        //检查此订单是否是申诉订单
        $qa_desc = \Config::get('qa-desc');
        $is_appeal = OrderAppealModel::where('order_id',$id)->first();
        if ($is_appeal && empty($request->input('type'))) { //申诉订单
            //显示申诉
            $res = OrderAppealModel::where('order_id',$id)
                                    ->leftJoin('order_network','order_appeal.order_id','=','order_network.id')
                                    ->leftJoin("supp_users",'order_appeal.supp_user_id','=','supp_users.user_id')
                                    ->leftJoin("ad_users",'ad_users.user_id','=','order_appeal.ads_user_id')
                                    ->select(
                                        "ad_users.nickname as nickname",
                                        'order_network.user_money','order_network.qa_change',
                                        "supp_users.name as media_name",
                                        'order_appeal.*')
                                    ->first()
                                    ->toArray();
            return view('console.manager.order_qa',
                ['info' => $res,]);
        } else {
            $info = OrderNetworkModel::with(['parent_order','selfUser','ad_user','suppUser.parentUser.user'])
                        ->where('id', $id)
                        ->first();
            if (empty($info)) {
                return back()->with('status', '订单不存在');
            }
            $info = $info->toArray();
        }
        return view('console.manager.order_info',[
            'info' => $info,
            'qa_desc' => $qa_desc]);
    }

    /**
     * 指派订单列表
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function selectMedia(Request $request)
    {
        $order_id = $request->order_id;
        $order_info = OrderNetworkModel::where('id', $order_id)->first();
        if (empty($order_info)) {
            return back()->with('status', '不存在此订单');
        }
        $list = getSameSpecUid($order_info->self_uid, $exclude_type='supp', $request, $getMes='all');
        // 获取同类的uid
        if ($list['status_code'] == 201) {
            return back()->with('status', $list['msg']);
        }
        return view('console.manager.order_select_media', [
                'lists' => $list['data'],
                'order_info' => $order_info
            ]);
    }

    /**
     * 指派订单操作
     * @param Request $request [description]
     */
    public function setOrderMedia(Request $request)
    {
        $order_id = $request->order_id;
        $supp_uid = $request->user_id;
        // 检查媒体是否在线
        $info = SuppUsersModel::where('user_id', $supp_uid)->first();
        if (empty($info)) {
            return back()->with('status', '不存在此媒体');
        }
        if ($info->is_state != 1) {
            return back()->with('status', '该媒体不在线或未审核，不能指派');
        }
        $order_info = OrderNetworkModel::with('selfUser', 'ad_user')->where('id', $order_id)->first();
        if ($order_info['order_type'] == 3) {
            return back()->with('status', '这个订单已流单');
        }
        if (in_array($order_info['media_type'], [13])) { // 13是已指派标记
            return back()->with('status', '这个订单已指派过了');
        }
        // 检查指派记录是否重复
        $count = OrderMediaLogModel::where('order_id', $order_id)
                                ->where('supp_uid', $supp_uid)
                                ->where('onstate', 2)
                                ->count();
        if ($count >= 1) {
            return back()->with('status', '此订单已经拒绝过一次啦');
        }

        $plate_tid = $order_info['selfUser']['plate_tid'];
        $plate_id = $order_info['selfUser']['plate_id'];
        // 检测用户是否存在相同规格
        $self_uid = $order_info->self_uid;
        if (checkSpecSame($supp_uid, $plate_tid, $plate_id, $self_uid) === false) {
            return back()->with('status', '用户分类不一致');
        }
        $ads_uid = $order_info->ads_user_id;
        $supp_info = SuppUsersModel::where('user_id', $supp_uid)->first();

        $platform_money = $order_info->user_money - $supp_info->proxy_price - $order_info->commission;
        if ($platform_money < 0) {
            return back()->with('status', '指派给此媒体,这次交易会亏钱,禁止交易');
        }
        // 计算提成
        // 检测当前用户是否存在分成
        $orderMedia = new OrderMediaLogModel;
        $orderMedia->order_id = $order_id;
        $orderMedia->supp_uid = $supp_uid;
        $orderMedia->ads_uid = $order_info->ads_user_id;
        $orderMedia->onstate = 1;
        $orderMedia->save();
        if ($order_info->media_type == 13) {
            $order_info->media_type = 12;
        } else {
            $order_info->media_type = 13;
        }
        $order_info->order_type = 1;
        $order_info->supp_user_id = $supp_uid;
        $order_info->supp_money = $supp_info->proxy_price; // 供应商所得
        $order_info->platform = $platform_money; // 平台所得
        $order_info->save();
        $parent_id = SuppUsersModel::where('user_id', $supp_uid)->value('parent_id');
        if ($parent_id) {
            SendOrderNotic($order_id, $parent_id, '您有新的预约单,订单号为'.$order_id,'用户下单');
        }
        return redirect('/console/manager/order/info/'.$order_id)->with('status', '指派成功');
    }

    /**
     * 申诉反馈处理
     * @param  [type]  $id      order_id
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function qaDeal($id,Request $request)
    {
        $order_info = OrderNetworkModel::with('parent_order')->where('id',$id)->first();
        $return_url = '/console/manager/order/info/'.$id;
        if (!$order_info) {
            return redirect('/console/index')->with('status', '该订单不存在');
        }
        if (!in_array($order_info['order_type'], [9,12,14,15])) {
            return back()->with('订单暂不可操作');
        }
        $deal_with_type = $request->deal_with;
        if ($order_info['order_type'] == 12 && $order_info['supp_status'] == 1 && $deal_with_type == '100') {
            if ($order_info['supp_user_id'] > 0) { // 是否指派
                $order_info->order_type = 1;
            } else {
                $order_info->order_type = 11;
            }
            $order_info->save();
            $order_log = new OrderLogModel;
            $order_log->order_id = $order_info->id;
            $order_log->status = 1;
            $order_log->content = '广告主申请退款，供应商尚未接单，管理人员拒绝退款';
            $order_info->save();
            SendOrderNotic($order_info->id,$order_info->ads_user_id,'【'.$order_info['parent_order']['title'].'】拒绝取消订单，订单号：'.$order_info->id,'申诉订单处理完成');
            return redirect('/console/manager/order/info/'.$order_info->id)->with('status', '操作成功');

        }
        if ($order_info['order_type'] == 9) { // 申诉状态
            if ($deal_with_type == 3) { // 不同意，并结款  修改订单状态，完结此订单
                $tmp = $tmp2 = $tmp3 = $tmp4 = $tmp5 = true;
                DB::beginTransaction();
                $order_info->deal_with_status = 3;
                $order_info->order_type = 13;
                $tmp = $order_info->save();
                $supp_user = SuppUsersModel::where('user_id', $order_info->supp_user_id)->first();
                $supp_user->order_count = $supp_user->order_count + 1;
                $supp_user->save();
                
                $supp_user = SuppUsersModel::where('user_id', $supp_user['parent_id'])->first();
                $supp_user->user_money = $supp_user->user_money + $order_info->supp_money;
                $supp_user->order_count = $supp_user->order_count + 1;
                $tmp2 = $supp_user->save(); // 供应商获得金额

                if ($order_info->commission > 0) {
                    $ads_user = AdUsersModel::where('user_id', $order_info->ads_user_id)->first();
                    $parent_user = AdUsersModel::where('user_id', $ads_user->user_id)->first();
                    $parent_user->user_money = $parent_user->user_money + $order_info->commission;
                    $tmp3 = $parent_user->save();
                    $tmp4 = UserAccountLogModel::insert(
                        ['user_id' => $parent_user->user_id, 
                         'user_money' => $order_info->commission,
                         'account_type' => 4,
                         'desc' => '旗下会员【'. $ads_user->nickname .'】给您带来提成',
                         'order_sn' => $order_info->order_sn,
                         'order_id' => $order_info->id,
                         'status' => 1,
                         'son_charge' => 2,
                         'created_at' => date("Y-m-d H:i:s",time()),
                     ]);
                }
                $tmp5 = UserAccountLogModel::insert(
                    ['user_id' => $supp_user->user_id, 
                     'user_money' => $order_info->supp_money,
                     'account_type' => 4,
                     'desc' => '订单完成',
                     'order_sn' => $order_info->order_sn,
                     'order_id' => $order_info->id,
                     'status' => 1,
                     'created_at' => date("Y-m-d H:i:s",time()),
                 ]);
                if ($tmp && $tmp2 && $tmp3 && $tmp4 && $tmp5) {
                    updateOrderStatus($order_info['order_sn']);//检测所有订单的状态
                    SendOrderNotic($order_info->id,$order_info->supp_user_id,'【'.$order_info['parent_order']['title'].'】订单申诉结果：申诉不通过，结款到你账户，订单号：'.$order_info->id,'申诉订单处理完成');
                    SendOrderNotic($order_info->id,$order_info->ads_user_id,'【'.$order_info['parent_order']['title'].'】订单申诉结果：申诉不通过，结款给对方，订单号：'.$order_info->id,'申诉订单处理完成');
                    DB::commit();
                    return redirect('/console/manager/order/info/'.$id)->with('status', '操作成功');
                } else {
                    DB::rollBack();
                    return back()->with('status', '网络繁忙，操作错误');
                }
            } elseif($deal_with_type == 2) { // 重做
                // 更改订单状态为正执行
                $order_info->order_type = 4;
                $order_info->deal_with_status = 2;
                $order_info->save();
                updateOrderStatus($order_info['order_sn']);//检测所有订单的状态
                SendOrderNotic($order_info->id,$order_info->supp_user_id,'【'.$order_info['parent_order']['title'].'】订单申诉结果：要求重做，订单号：'.$order_info->id,'申诉订单处理完成');
                SendOrderNotic($order_info->id,$order_info->ads_user_id,'【'.$order_info['parent_order']['title'].'】订单申诉结果：要求对方重做，订单号：'.$order_info->id,'申诉订单处理完成');
                return redirect('console/manager/order/35?type=9')->with('status', '更新成功');
            } elseif($deal_with_type == 1) { // 退款 关闭订单
                DB::beginTransaction();
                $order_info->deal_with_status = 1;
                $order_info->order_type = 13;
                $tmp = $order_info->save();
                $ads_user = AdUsersModel::where('user_id', $order_info->ads_user_id)->first();
                $ads_user->user_money = $order_info->user_money + $ads_user->user_money;
                $tmp2 = $ads_user->save();
                $user_account = new UserAccountLogModel;
                $user_account->user_id = $order_info->ads_user_id;
                $user_account->user_money = $order_info->user_money;
                $user_account->account_type = 5;
                $user_account->desc = '订单退款';
                $user_account->order_sn = $order_info->order_sn;
                $user_account->order_id = $order_info->id;
                $user_account->pay_user = $ads_user->nickname;
                $user_account->status = 1;
                $tmp3 = $user_account->save();
                if ($tmp && $tmp2 && $tmp3) {
                    updateOrderStatus($order_info['order_sn']);//检测所有订单的状态
                    SendOrderNotic($order_info->id,$order_info->supp_user_id,'【'.$order_info['parent_order']['title'].'】订单申诉结果：申诉通过，订单关闭，订单号：'.$order_info->id,'申诉订单处理完成');
                    SendOrderNotic($order_info->id,$order_info->ads_user_id,'【'.$order_info['parent_order']['title'].'】订单申诉结果：申诉通过，已退款至你的账户，订单号：'.$order_info->id,'申诉订单处理完成');
                    DB::commit();
                    return redirect('/console/manager/order/info/'.$id)->with('status', '操作成功');
                } else {
                    DB::rollBack();
                    return back()->with('status', '网络繁忙，操作错误');
                }
            }
        }
        if (in_array($order_info['order_type'], [14,15])) {
            if ($deal_with_type == 3) { // 不同意，并结款  // 退还钱款给广告主  修改订单状态，完结此订单
                $tmp = $tmp2 = $tmp3 = $tmp4 = $tmp5 = true;
                DB::beginTransaction();
                $order_info->deal_with_status = 3;
                $order_info->order_type = 13;
                $tmp = $order_info->save();
                $supp_user = SuppUsersModel::where('user_id', $order_info->supp_user_id)->first();
                $supp_user->order_count = $supp_user->order_count + 1;
                $supp_user->save();

                $supp_user = SuppUsersModel::where('user_id', $supp_user['parent_id'])->first();
                $supp_user->user_money = $supp_user->user_money + $order_info->supp_money;
                $supp_user->order_count = $supp_user->order_count + 1;
                $tmp2 = $supp_user->save(); // 供应商获得金额

                if ($order_info->commission > 0) {
                    $ads_user = AdUsersModel::where('user_id', $order_info->ads_user_id)->first();
                    $parent_user = AdUsersModel::where('user_id', $ads_user->user_id)->first();
                    $parent_user->user_money = $parent_user->user_money + $order_info->commission;
                    $tmp3 = $parent_user->save();
                    $tmp4 = UserAccountLogModel::insert(
                        ['user_id' => $parent_user->user_id, 
                         'user_money' => $order_info->commission,
                         'account_type' => 4,
                         'desc' => '旗下会员【'. $ads_user->nickname .'】给您带来提成',
                         'order_sn' => $order_info->order_sn,
                         'order_id' => $order_info->id,
                         'status' => 1,
                         'son_charge' => 2,
                         'created_at' => date("Y-m-d H:i:s",time()),
                     ]);
                }
                $tmp5 = UserAccountLogModel::insert(
                    ['user_id' => $order_info->supp_user_id, 
                     'user_money' => $order_info->supp_money,
                     'account_type' => 4,
                     'desc' => '订单完成',
                     'order_sn' => $order_info->order_sn,
                     'order_id' => $order_info->id,
                     'status' => 1,
                     'created_at' => date("Y-m-d H:i:s",time()),
                 ]);
                if ($tmp && $tmp2 && $tmp3 && $tmp4 && $tmp5) {
                    updateOrderStatus($order_info['order_sn']);//检测所有订单的状态
                    SendOrderNotic($order_info->id,$order_info->supp_user_id,'【'.$order_info['parent_order']['title'].'】订单申诉结果：对方申请退款失败，结款到你账户，订单号：'.$order_info->id,'申诉订单处理完成');
                    SendOrderNotic($order_info->id,$order_info->ads_user_id,'【'.$order_info['parent_order']['title'].'】订单申诉结果：申请退款不通过，结款给对方，订单号：'.$order_info->id,'申诉订单处理完成');
                    DB::commit();
                    return redirect('/console/manager/order/info/'.$id)->with('status', '操作成功');
                } else {
                    DB::rollBack();
                    return back()->with('status', '网络繁忙，操作错误');
                }
            } elseif($deal_with_type == 1) { // 退款 关闭订单
                DB::beginTransaction();
                $order_info->deal_with_status = 1;
                $order_info->order_type = 13;
                $tmp = $order_info->save();
                $ads_user = AdUsersModel::where('user_id', $order_info->ads_user_id)->first();
                $ads_user->user_money = $order_info->user_money + $ads_user->user_money;
                $tmp2 = $ads_user->save();
                $user_account = new UserAccountLogModel;
                $user_account->user_id = $order_info->ads_user_id;
                $user_account->user_money = $order_info->user_money;
                $user_account->account_type = 5;
                $user_account->desc = '订单退款';
                $user_account->order_sn = $order_info->order_sn;
                $user_account->order_id = $order_info->id;
                $user_account->pay_user = $ads_user->nickname;
                $user_account->status = 1;
                $tmp3 = $user_account->save();
                if ($tmp && $tmp2 && $tmp3) {
                    updateOrderStatus($order_info['order_sn']);//检测所有订单的状态
                    SendOrderNotic($order_info->id,$order_info->supp_user_id,'【'.$order_info['parent_order']['title'].'】订单申诉结果：对方申请退款成功，订单关闭，订单号：'.$order_info->id,'申诉订单处理完成');
                    SendOrderNotic($order_info->id,$order_info->ads_user_id,'【'.$order_info['parent_order']['title'].'】订单申诉结果：申请退款成功，已退款到账户，订单号：'.$order_info->id,'申诉订单处理完成');
                    DB::commit();
                    return redirect('/console/manager/order/info/'.$id)->with('status', '操作成功');
                } else {
                    DB::rollBack();
                    return back()->with('status', '网络繁忙，操作错误');
                }
            }
        }
        if ($order_info['order_type'] == 12 && $order_info['supp_status'] == 1) {
            if ($deal_with_type == 1) { // 退款 关闭订单
                DB::beginTransaction();
                $order_info->deal_with_status = 1;
                $order_info->order_type = 13;
                $tmp = $order_info->save();
                $ads_user = AdUsersModel::where('user_id', $order_info->ads_user_id)->first();
                $ads_user->user_money = $order_info->user_money + $ads_user->user_money;
                $tmp2 = $ads_user->save();
                $user_account = new UserAccountLogModel;
                $user_account->user_id = $order_info->ads_user_id;
                $user_account->user_money = $order_info->user_money;
                $user_account->account_type = 5;
                $user_account->desc = '订单退款';
                $user_account->order_sn = $order_info->order_sn;
                $user_account->order_id = $order_info->id;
                $user_account->pay_user = $ads_user->nickname;
                $user_account->status = 1;
                $tmp3 = $user_account->save();
                if ($tmp && $tmp2 && $tmp3) {
                    updateOrderStatus($order_info['order_sn']);//检测所有订单的状态
                    SendOrderNotic($order_info->id,$order_info->supp_user_id,'【'.$order_info['parent_order']['title'].'】对方取消订单，订单号：'.$order_info->id,'申诉订单处理完成');
                    SendOrderNotic($order_info->id,$order_info->ads_user_id,'【'.$order_info['parent_order']['title'].'】订单取消成功，已退款到你账户，订单号：'.$order_info->id,'申诉订单处理完成');
                    DB::commit();
                    return redirect('/console/manager/order/info/'.$id)->with('status', '操作成功');
                } else {
                    DB::rollBack();
                    return back()->with('status', '网络繁忙，操作错误');
                }
            }
        }
        
    }

    /**
     * 提现列表
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function withdraw(Request $request)
    {
        $lists = new UserAccountLogModel;
        $log_status = [1 => '到账', 0 => '等待', 2 => '拒绝'];
        if (\Request::ajax()) {
            if ($request->input('mediatype') == 2 && !empty($request->input('orderid'))) { //用户名
                $name = $request->input('orderid');
                $lists = $lists::with(['ads_user.level' => function($query){
                                $query->select('id','level_name');
                            }, 'users' => function($query) use($name){
                                $query->select('id','name')->where('name',$name);
                            }]);
            } else {
                $lists = $lists::with(['ads_user.level' => function($query){
                        $query->select('id','level_name');
                    }, 'users' => function($query){
                        $query->select('id','name');
                    }]);
            }
            if ($request->input('mediatype') == 1 && !empty($request->input('orderid'))) {
                $lists = $lists->where('user_account_log.order_id',$request->input('orderid'));
            }
            if ($request->input('start')) {
                $lists = $lists->where('user_account_log.start','>=',$request->input('start'));
            }
            if ($request->input('end')) {
                $lists = $lists->where('user_account_log.end','<=',$request->input('end'));
            }
            // DB::enableQueryLog();

            $lists = $lists->where('account_type',3)
                            ->orderBy('id','desc')
                            ->get()
                            ->toArray();
            $html = "";
            foreach ($lists as $key => $value) {
                $html .= "<tr>";
                $html .= "<td>".$value['order_id']."</td>";
                $html .= "<td>".$value['users']['name']."</td><td>";
                $html .= !empty($value['ads_user']) ? $value['ads_user']['level']['level_name'] : '供应商';
                $html .=  "<td class=\"color1\">￥".$value['user_money']."</td>";
                $html .= "<td>".$value['created_at']."</td>";
                $html .= "<td>".$log_status[$value['status']]."</td>";
                $html .= "<td><a class=\"color2\" href=\"/console/withdraw/".$value['id']."\">查看</a></td></tr>";
            }

            return $html;
        }
        $lists = $lists::with(['ads_user.level' => function($query){
                        $query->select('id','level_name');
                    }, 'users' => function($query){
                        $query->select('id','name');
                    }])->where('account_type',3)
                    ->orderBy('id','desc')
                    ->get()
                    ->toArray();
        return view('console.manager.withdraw', ['lists' => $lists, 'log_status' => $log_status]);
    }

    public function withdrawInfo($id)
    {
        $info = UserAccountLogModel::where('id',$id)
                        ->with(['ads_user.level' => function($query){
                                $query->select('id','level_name');
                            }, 'users.user_mes' => function($query){
                                $query->select('id','user_id','user_money');
                            }])->first()->toArray();
                        // dd();
        $paylist = \Config::get('paylist');

        return view('console.manager.withdraw_info',['info' => $info, 'paylist' => $paylist]);
    }

    public function updateWithdraw($id,Request $request)
    {
        $info = UserAccountLogModel::where('id',$id)->first();
        if (!$info) {
            return redirect("/console/withdraw/".$id)->with('status', '操作失败');
        }
        DB::beginTransaction();
        $tmp2 = false;
        $tmp  = true;
        if ($request->input('status') == 1) { //完成
            $info->status = $request->input('status');
            $tmp2 = $info->save();
        }
        if ($request->input('status') == 3) { //拒绝
            $info->status = 2;
            $tmp2 = $info->save();
            $user_type = User::where("id",$info->user_id)->first()->user_type;
            if ($user_type == 2) {
                $tmp = AdUsersModel::where('user_id',$info->user_id)->increment('user_money',$info->user_money);
            } else if ($user_type == 3) {
                $tmp = SuppUsersModel::where('user_id',$info->user_id)->increment('user_money',$info->user_money);
            }
        }
        if ($tmp && $tmp2) {
            DB::commit();
            return redirect('/console/withdraw/list')->with('status', '操作成功');
        } else {
            DB::rollBack();
            return redirect("/console/withdraw/".$id)->with('status', '无变动');
        }
    }

    /** 
     * 
     * @return [type] [description]
     */
    public function invo(Request $request)
    {
        // 初始化状态
        $invo_status = [1 => '收据', 2 => '普通发票', 3 => '专用发票'];
        $service_status = \Config::get('invodetail');
        $use_status = [1 => '充值金额', 2 => '消费金额'];
        $send_type = [1 => '电子档', 2 => '纸质快递1000起'];
        $status = [1 => '未完成', 2 => '完成'];
        DB::enableQueryLog();
        $lists = InvoModel::leftJoin('users','invo.user_id','users.id')
                                ->leftJoin('ad_users','ad_users.user_id','=','users.id')
                                ->leftJoin('supp_users','supp_users.user_id','=','invo.user_id')
                                ->select('users.name',
                                         'ad_users.level_id',
                                         'users.user_type',
                                         'invo.*',
                                         'supp_users.name as supp_name');
        if (\Request::ajax()) {
            $html = "";
            if ($request->input('start')) {
                $lists = $lists->where('invo.created_at','>=',$request->input('start'));
            }
            if ($request->input('end')) {
                $lists = $lists->where('invo.created_at','<=',$request->input('end'));
            }
            if ($request->input('mediatype') == 1 && !empty($request->input('orderid'))) {
                $lists = $lists->where('invo.id',$request->input('orderid'));
            }
            if ($request->input('mediatype') == 2 && !empty($request->input('orderid'))) {
                $lists = $lists->where('users.name',$request->input('orderid'));
            }
            $lists = $lists->get()->toArray();
            foreach ($lists as $key => $value) {
                $html .= "<tr>";
                $html .= "<td>".$value['order_id']."</td>";
                $html .= "<td>";
                $html .= !empty($value['name']) ? $value['name'] : $value['name'];
                $html .= "</td>";
                $html .= "<td>";
                $html .= !empty($value['level_id']) ? $value['level_id'] == 2 ? "高级会员" : "普通会员" : "供应商";
                $html .= "</td>";
                $html .= "<td>".$invo_status[$value['invo_type']]."</td>";
                $html .= "<td>".$service_status[$value['detail_type']]."</td>";
                $html .= "<td>".$use_status[$value['money_type']]."</td>";
                $html .= "<td class=\"color1\">￥".$value['money']."</td>";
                $html .= "<td>".$send_type[$value['send_type']]."</td>";
                $html .= "<td>".$status[$value['status']]."</td>";
                $html .= "<td><a class=\"color2\" href=\"/console/invo/".$value['order_id']."\">查看</a></td>";
                $html .= "</tr>";
            }
            return $html;
        }
        $lists = $lists->get()->toArray();

        return view('console.manager.invo_list', 
            ['lists' => $lists,
             'invo_status' => $invo_status,
             'service_status' => $service_status,
             'use_status' => $use_status,
             'send_type' => $send_type,
             'status' => $status]);
    }

    public function invoInfo($id) {
        $info = InvoModel::leftJoin('users','invo.user_id','users.id')
                                ->leftJoin('ad_users','ad_users.user_id','=','users.id')
                                ->leftJoin('supp_users','users.id','=','supp_users.user_id')
                                ->select('users.name',
                                         'ad_users.user_money as ad_money',
                                         'supp_users.user_money as supp_money',
                                         'ad_users.level_id',
                                         'users.user_type',
                                         'invo.*')
                                ->where('invo.order_id',$id)
                                ->first()
                                ->toArray();
        $invo_status = [1 => '收据', 2 => '普通发票', 3 => '专用发票'];
        $service_status = \Config::get('invodetail');
        $use_status = [1 => '充值金额', 2 => '消费金额'];
        $send_type = [1 => '电子档', 2 => '纸质快递1000起'];
        $status = [1 => '未完成', 2 => '完成'];

        return view('console.manager.invo_info',
            ['invo_status' => $invo_status,
             'service_status' => $service_status,
             'use_status' => $use_status,
             'send_type' => $send_type,
             'status' => $status,
             'info' => $info,
            ]);
    }

    public function updateInvo($order_id,Request $request)
    {
        $info = InvoModel::where('order_id',$order_id)->first();
        if (!$info) {
            return redirect('/console/invo/lists')->with('status', '没有找到相关信息');
        }
        if ($request->input('status') == 2) {
            $info->status = 2;//更新为完成
            $info->admin_id = Auth::user()->id;
            $info->save();
            return redirect('console/invo/lists')->with('status', '操作成功');
        }
        return redirect('/console/invo/'.$order_id)->with('status', '无变动');
    }

    /**
     * 栏目创建以及写入
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function categoryAdd(Request $request)
    {
        if($request->isMethod('post')){
            if ($request->input('id')) {
                $category = CategoryModel::where('id',$request->input('id'))->first();
            }
            if (empty($category)) {
                $category = new CategoryModel;
            }
            $category->type_id = $request->input('pid');
            $category->sortorder = !empty($request->input('sortorder')) ? $request->input('sortorder') : 99;
            $category->status = $request->input('status');
            $category->category_name = $request->input('category_name');
            $category->pid = 0;//保留字段
            if ($category->save()) {
                return redirect('/console/article/category/manager')->with('status','创建成功');
            }
            return redirect()->back();
        }
        $category_type = \Config::get('category');
        return view('console.article.category_add',
            ['category_type' => $category_type]);
    }

    /**
     * 栏目列表
     * @return [type] [description]
     */
    public function categoryManager()
    {
        $category_type = \Config::get('category');
        $category_list = CategoryModel::orderBy('sortorder','desc')->get()->toArray();//pagis()->toArray();
        return view('console.article.category_list',['category_list' => $category_list,
            'category_type' => $category_type]);
    }

    public function delCategory(Request $request)
    {
        $catid = $request->input('id');
        if (ArticleModel::where('category_id',$catid)->first()) {
            return ['status_code' => 202, 'msg' => '该分类下存在文章，不能删除'];
        }
        CategoryModel::where('id',$catid)->delete();
        return ['status_code' => 200];
    }

    public function category($id)
    {
        $category_type = \Config::get('category');
        $info = CategoryModel::where('id',$id)->first()->toArray();
        return view('console.article.category_edit',
            ['category_type' => $category_type, 'info' => $info]);
    }

    public function addArticle(Request $request)
    {
        $category_type = \Config::get('category');
        if (\Request::ajax()) {
            $type = $request->input('type');
            $category_list = CategoryModel::where('type_id',$type)->get()->toArray();
            return ['status_code' => 200, 'data' => $category_list];
        }
        return view('console.article.article_add',[
            'category_type' => $category_type,
            ]);
    }

    /**
     * 更新文章
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateArticle(Request $request)
    {
        $article_id = $request->input('article_id');
        $article = ArticleModel::where('id',$article_id)->first();
        if (!$article) {
            $article = new ArticleModel;
        }

        $article->article_name = !empty($request->input('title')) ? $request->input('title') : $article->category_name;
        $article->origin = !empty($request->input('origin')) ? $request->input('origin') : $article->origin;
        $article->category_id = !empty($request->input('category_id')) ? $request->input('category_id') : $article->category_id;
        $article->content = !empty($request->input('content')) ? $request->input('content') : $article->content;
        $article->type_id = $request->input('type_id');
        $article->save();
        return redirect('/console/article/manager')->with('status','发布文章成功');
    }

    public function articleList()
    {
        $article_list = ArticleModel::with('category')->orderBy('id','desc')->get()->toArray();
        $category_type = \Config::get('category');
        return view('console.article.article_list',
            ['article_list' => $article_list, 'category_type' => $category_type]);
    }

    public function articleDel(Request $request)
    {
        $id = $request->input('id');
        $res = ArticleModel::where('id',$id)->delete();
        if ($res)
            return ['status_code' => 200, 'msg' => '删除成功'];
        return ['status_code' => 201, 'msg' => '删除失败'];
    }

    public function article($id)
    {
        $article = ArticleModel::with('category')->where('id',$id)->first()->toArray();
        $category = CategoryModel::where('type_id',$article['category']['type_id'])->get()->toArray();

        $category_type = \Config::get('category');
        return view('console.article.article_edit',
            ['article' => $article, 'category_type' => $category_type, 'category' => $category]);
    }

    /**
     * 回拨列表
     * @return [type] [description]
     */
    public function phoneOrderList()
    {
        $phone_order_list = PhoneOrderModel::orderBy('id','desc')
                                            ->leftJoin('ad_users','phone_order.user_id','=','ad_users.user_id')
                                            ->leftJoin('supp_users','phone_order.user_id','=','supp_users.user_id')
                                            ->select('ad_users.level_id',
                                                     'ad_users.nickname',
                                                     'supp_users.name',
                                                     'phone_order.contact_phone',
                                                     'phone_order.status',
                                                     'phone_order.id',
                                                     'phone_order.created_at')
                                            ->get()
                                            ->toArray();
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
                    'status' => $value['status'] == 1 ? '完成' : '等待回拨',
                    'created_at' => $value['created_at'],
                    'id' => $value['id']
                ];
            }
        return view('console.phone_order.phone_order_list',
            ['phone_order_list' => $phone_orders]);
    }

    public function updatePhoneOrder($id)
    {
        $info = PhoneOrderModel::where('id',$id)->where('status',2)->first();
        if ($info) {
            $info->status = 1;
            $info->save();
            return ['status_code' => 200, 'msg' => '已更改为 完成 状态'];  
        } else {
            return ['status_code' => 200, 'msg' => '错误，非法请求，请联系技术'];  
        }
    }

	
	

    /**
     * 添加活动模板渲染
     * @return [type] [description]
     */
    public function actAdd(Request $request)
    {
        $start = $over = $info = [];
        if (!empty($request->input('id'))) {
            $info = ActivityModel::where('id',$request->input('id'))->first()->toArray();
            $start = explode(':',explode(' ', $info['start'])['1']);
            $over = explode(':',explode(' ', $info['over'])['1']);
        }
        
        return view('console.activity.activity_info', ['info' => $info, 'start' => $start, 'over' => $over]);
    }

    /**
     * 更新、添加活动详情
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateActInfo(Request $request)
    {
        if (!empty($request->input('activity_id'))) {
            $activity_model = ActivityModel::where('id',$request->input('activity_id'))->first();
        } else {
            $activity_model = new ActivityModel;
        }
        $activity_model->activity_name = $request->input('activity_name');
        $activity_model->start = $request->input('start')." ".$request->input('name4_1').'-'.$request->input('name4_2').'00';
        $activity_model->over = $request->input('over')." ".$request->input('name5_1').'-'.$request->input('name5_2').'00';
        $activity_model->plate_rate = $request->input('plate_rate');
        $activity_model->vip_rate = $request->input('vip_rate');
        $activity_model->save();
        return redirect('/console/activity/list')->with('status', '更新成功');
    }


	/*	活动管理 活动详情	*/
    public function actInfo() {
        return view('console.activity.activity_user');
    }

	/*	活动管理 活动列表	*/
    public function actList(Request $request){

        if (\Request::ajax()) {
            $activity_model = new ActivityModel;
            if (!empty($request->input('start'))) {
                $activity_model = $activity_model->where('created_at','>=',$request->input('start'));
            }
            if (!empty($request->input('over'))) {
                $activity_model = $activity_model->where('created_at','<=',$request->input('over'));
            }
            if (!empty($request->input('orderid'))) {
                $activity_model = $activity_model->where('activity_name','like','%'.$request->input('orderid').'%');
            }
            $activity_model = $activity_model->get()->toArray();
            $html = "";
            foreach ($activity_model as $key => $val) {
                $html .= "<tr id=\"activity_".$val['id']."\">";
                $html .= "<td>{$val['id']}</td>";
                $html .= "<td>{$val['activity_name']}</td>";
                $html .= "<td>{$val['start']}</td>";
                $html .= "<td>{$val['over']}</td>";
                $html .= "<td>{$val['plate_rate']}%</td>";
                $html .= "<td>{$val['vip_rate']}%</td>";
                $html .= "<td><a class=\"color2\"  href=\"/console/activity/info/{$val['id']}\" >活动媒体</a><a class=\"color2\" href=\"/console/activity/add?id={$val['id']}\">查看</a><a class=\"color1\" href=\"javascript:;\" onclick=\"del_activity({$val['id']})\">删除</a></td></tr>";
            }
            return $html;
            
        }
        $lists = ActivityModel::get();

        return view('console.activity.activity_list', ['lists' => $lists]);
    }

    /**
     * 参与活动用户模板渲染
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function actUser($id) {
        // 所有媒体
        $media = PlateModel::with(
                ['selfSuppUser'])->where('pid',0)->get()->toArray();
        $child_media_res = PlateModel::where('pid','<>',0)
                        ->select('plate_name','id')
                        ->get()
                        ->toArray();
        $child_media = [];
        foreach ($child_media_res as $key => $value) {
            $child_media[$value['id']] = $value['plate_name'];
        }
        $lists = SuppUsersSelfModel::leftJoin('plate','plate.id','=','supp_users_self.plate_tid')
                        ->get()
                        ->toArray();

        $users = ActivityVsUserModel::where('activity_id',$id)->pluck('user_id')->toArray();
        if(empty($users)) {
		$users = [0];
	}
	return view('console.activity.activity_user', [
                'media' => $media, 
                'child_media' => $child_media,
                'id' => $id,
                'users_data' => $users]);
    }

    /**
     * 添加、更新参与活动的用户
     * @param Request $request [description]
     */
    public function addActivityUser(Request $request)
    {
        $activity_id = $request->input('activity_id');
        $users = $request->input('user_id');
        ActivityVsUserModel::where('activity_id',$activity_id)->delete();
        $activity_model = new ActivityVsUserModel;
        $data = [];
        foreach ($users as $key => $user) {
            $data[] = ['user_id' => $user, 
                     'activity_id' => $activity_id, 
                     'created_at' => date('Y-m-d H:i:s', time())];
        }
        $activity_model->insert($data);
        return redirect('/console/activity/info/'.$activity_id)->with('status', '更新成功');
    }

    /**
     * 删除活动
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function delActivity(Request $request)
    {
        $activity_id = $request->input('activity_id');
        $res = ActivityModel::where('id',$activity_id)->delete();
        ActivityVsUserModel::where('activity_id',$activity_id)->delete();
        if ($res) {
            return ['status_code' => 200, 'msg' => '删除成功'];
        }
        return ['status_code' => 201, 'msg' => '删除失败'];
    }

    /**
     * 删除分类资源
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delAttr($id)
    {
        if (PlateAttrValueModel::where('id',$id)->delete()) {
            return ['status_code' => 200, 'msg' => '删除成功'];
        }
        return ['status_code' => 201, 'msg' => '删除失败'];
    }
	
}





