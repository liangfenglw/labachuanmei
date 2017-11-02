<?php

namespace App\Http\Controllers\Console;

use Illuminate\Http\Request;
use App\Http\Controllers\Console\CommonController;
// use Request;
use App\Model\CustomerModel;
use App\Model\AdminMenuModel;
use App\Model\AdminRoleModel;
use App\Model\AdminVsRoleModel;
use App\Model\RoleVsMenuModel;
use App\Model\AdUsersModel;
use App\Model\SuppUsersModel;
use App\Model\UsersModel;
use App\Model\SecurityQuestionCatModel;
use App\Model\SecurityQuestionModel;
use App\Model\SecurityAnswerModel;
use App\Model\CertificateCatModel;
use App\Model\UserCertificatePicModel;
use App\Model\UsersEnchashmentModel;
use App\Model\UserAccountLogModel;
use App\User;
use App\Model\PlateModel;
use App\Model\SuppVsAttrModel;
use App\Model\OrderModel;
use App\Model\OrderNetworkModel;
use App\Model\OrderAppealModel;
use App\Model\InvoModel;
use App\Model\NoticeModel;
use App\Model\SuppUsersSelfModel;

use Auth;
use Cache;
use DB;
use Session;

class OrderController extends CommonController
{
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->request = $request;
    }

    /*
    * 订单列表
    */
    public function order_list(Request $request,$order_type=0)
    {
        $user_array = $this->getUser();
        //订单状态
        $order_status = [
             0 => [0], //取消订单
             1 => [1,11], //预约状态
             5 => [10], //已完成
             4 => [5,4,6,7,8], //正执行
             3 => [3], //流单
             2 => [2], //拒单
             9 => [9], //申诉订单
             100 => [12,13,14,15]
        ];
        $user_id = Auth::user()->id;
            // 这里
        $order_list = OrderNetworkModel::with(['appeal_order','selfUser'])
                    ->leftJoin('order','order_network.order_sn','=','order.order_sn')
                    ->leftJoin('users','order.ads_user_id','=','users.id');
        $order_list = $order_list->where('order_network.ads_user_id',Auth::user()->id);
        //订单状态
        if (!empty($order_type)) {
            if ($order_type == 5) {
                $order_list = $order_list->where(function($query){
                    $query->where('order_network.order_type',10)
                          ->orWhere(function($query){
                                $query->where('order_network.order_type',13)
                                    ->where('deal_with_status',3);
                            });
                });
            } else {
                $order_list = $order_list->whereIn('order_network.order_type',$order_status[$order_type]);
            }
            
        }

        if ($request->input('start')) {
            $order_list = $order_list->where("order.start_at",'>=',$request->input('start')." 00:00:00");
        }
        if ($request->input('end')) {
            $order_list = $order_list->where("order.over_at",'<=',$request->input('end')." 23:59:59");
        }

            //筛选分类
        if ($request->input('mediatype')) {
            $order_list = $order_list->whereIn('order.type_id',
                function($query) use($request) {
                    $query->select('id')->from('plate')->where('pid', $request->input('mediatype'));
            });
        }
        //订单id
        if ($request->input('orderid')) {
            $order_list = $order_list->where('order_network.id',$request->input('orderid'));
        }
            // DB::enableQueryLog();
            $order_lists = $order_list->orderBy('order_network.id','desc')
                                     ->select('order.ads_user_id','order.order_type',
                                         'order.title','order.type_id',
                                         'order.type_name','order.start_at',
                                         'order.over_at','order_network.*','users.name as name')
                                    ->get()
                                    ->toArray();
            // dd(DB::getQueryLog());
            $html = "";
            $status = [
                       0=>'取消',
                       1 => '预约', 
                       2 => '拒绝', 
                       3 => '流单', 
                       4 => '正执行', 
                       5 => '供应商完成', 
                       6 => '供应商反馈', 
                       7 => '广告主反馈', 
                       8 => '广告主质量反馈', 
                       9 => '申诉', 
                       10 => '广告主确认完成',
                       11 => '预约',
                       12 => '申请退款',
                       13 => '退款完成',
                       14 => '申请退款',//'对方不同意退款',
                       15 => '申请退款',//'对方同意退款'];
                       ];
            $appeal_status = [
                       0=>'未处理',
                       1 => '已处理'
                            ];
            // dd($order_list);
            $qa_feedback = [1 => '好', 2 => '中', 3 => '差'];
        //本月订单统计
        $start = date("Y-m-d H:i:s",mktime(0,0,0,date('m'),1,date('Y')));
        $end = date("Y-m-d H:i:s",mktime(23,59,59,date('m'),date('t'),date('Y')));

        $order_list = OrderNetworkModel::leftJoin('order','order_network.order_sn','=','order.order_sn')
                            ->where('order.ads_user_id',Auth::user()->id);

        $order_statistics = OrderNetworkModel::where("order_network.ads_user_id",Auth::user()->id)
                                ->select(
            DB::raw("sum(order_network.user_money) as all_money"),
            DB::raw("count(*) as all_count"),
            DB::raw("count(case when 
                    (order_network.order_type = 10) or 
                    (order_network.order_type = 13 and order_network.deal_with_status = 3) then 1 end
                ) as success_count"),//完成订单数
            DB::raw("sum(case when (order_network.order_type  = 10) or (order_network.order_type=13 and order_network.deal_with_status = 3) then order_network.user_money end) as success_money"),//完成订单金额
            DB::raw("count(case when order_network.order_type = 3 then 1 end) as flow_order_count"),//流单数
            DB::raw("sum(case when order_network.order_type = 3 then order_network.user_money end ) as flow_order_money"),//流单金额
            DB::raw("count(case when order_network.order_type = 0 then 1 end) as give_up_count"),//取消数
            DB::raw("sum(case when order_network.order_type = 0 then order_network.user_money end) as give_up_money"),//取消金额
            DB::raw("count(case when order_network.order_type = 2 then 1 end) as refuse_order"),//拒单数
            DB::raw("sum(case when order_network.order_type = 2 then order_network.user_money end) as refuse_money")//拒单金额
                                )
                                // ->whereBetween('order_network.created_at',[$start,$end])
                                ->first()
                                ->toArray();
        return view('console.order.order_list',[
                'active' => 'order_list', 
                'order_type' => $order_type, 
                'order_statistics' => $order_statistics,
                'active'=>'order_manage',
                'user_array'=>$user_array,
                'order_list' => $order_lists,
                'status' => $status]);
    }

    /*
    *订单查询
    */
    public function order_detail(Request $request,$order_id)
    {
        $user = $this->getUser();
        $is_parent = 0;
        $OrderNetworkModel = new OrderNetworkModel();
        //获取订单信息
        $info = $OrderNetworkModel::with(['parent_order','parent_order.user','parent_order.user.ad_user','parent_order.son_order','parent_order.son_order.media_name'])
                            ->where('id',$order_id)
                            ->first();
        // dd($info->toArray());
        if (!$info) {
            return redirect("/order/order_list")->withInput()->with('status', '非法操作');
        }
        $info = $info->toArray();
        $notice = NoticeModel::where('order_id', $order_id)
                    ->where('user_id', $user['user_id'])
                    ->where('is_read',2)
                    ->first();
        if ($notice) {
            $notice->is_read = 1;
            $notice->save();
        }
        // 判断是否高级会员查看下级会员
        if ( $user['user_id'] != $info['parent_order']['ads_user_id'] && $user['user_id'] != $info['parent_order']['user']['ad_user']['parent_id']) {

                return redirect("/order/order_list")->withInput()->with('status', '非法操作');
        }

        if ($user['user_id'] == $info['parent_order']['user']['ad_user']['parent_id']) {
            $is_parent = 1;
        }
        $parent_id = AdUsersModel::where('user_id',Auth::user()->id)->value('parent_id');
        
        $order_count_all = $OrderNetworkModel->where('order_sn',$info['order_sn'])->count();
        // 如果是订单提交操作
        if ($request->isMethod('post')) {
            if (!$request->input('order_id') || $request->input('order_id') != $info['id']) {
                return redirect("/order/order_list")->withInput()->with('status', '操作失败');
            }
            $order_id = $request->input('order_id');
            if ($user['user_id'] != $info['parent_order']['ads_user_id']) {
                return redirect("/order/order_detail/{$order_id}")->withInput()->with('status', '操作失败');
            }
            $data = $request->all();
            $order_status = isset($data['order_status']) ? $data['order_status'] : '';   //订单状态
            $qa_feedback = isset($data['qa_feedback'])?$data['qa_feedback']:'';       //质量反馈
            $order_feedback = isset($data['order_feedback'])?$data['order_feedback']:'';  //订单反馈
            $updata_data = [];
            $OrderNetworkModel = $OrderNetworkModel->where('id',$order_id);
            switch ($order_status) {
                case '1': 
                    $OrderNetworkModel = $OrderNetworkModel->where('order_type',$order_status);
                    $updata_data['order_type'] = 0;
                    break;
                case '9':  //订单申诉
                    if(!$data['order_feedback']) 
                        return redirect("/order/order_detail/{$order_id}")
                                    ->withInput()
                                    ->with('status', '申诉原因必须填写');
                    $updata_data['order_feedback'] = $order_feedback;
                    $updata_data['order_type'] = 9;
                    $notice_desc = '【'.$info['parent_order']['title'].'】对方对订单的完成存在异议,进行申诉处理，订单号：'.$info['id'];
                    break;
                case '12': // 对方未接受 想取消订单
                    if (!$data['refund_reason'])
                        return redirect("/order/order_detail/{$order_id}")
                                    ->withInput()
                                    ->with('status', '退款原因必须填写');

                    $updata_data['refund_reason'] = $request->refund_reason;
                    $updata_data['order_type'] = 12;
                    $updata_data['deal_with_status'] = 0;
                    if ($info['supp_status'] == 1) { // 供应商未接单
                        $notice_desc = '【'.$info['parent_order']['title'].'】订单正在申请取消，请勿接单，订单号：'.$info['id'];
                    } else {
                        $notice_desc = '【'.$info['parent_order']['title'].'】订单正在申请取消，请暂停任务，订单号：'.$info['id'];
                    }
                    
                    break;
                case '5': 
                    $OrderNetworkModel = $OrderNetworkModel->where('order_type',$order_status);
                    $updata_data['qa_feedback'] = $qa_feedback;
                    $updata_data['order_feedback'] = $order_feedback;
                    $updata_data['order_type'] = 10;
                    if ($qa_feedback == 3) {
                        $updata_data['order_type'] = 8;
                        $notice_desc = '您正在进行的任务有新的质量反馈,订单号为'.$info['id'];
                    }
                    break;
                case '10': 
                    $OrderNetworkModel = $OrderNetworkModel->where('order_type',5);
                    $updata_data['qa_feedback'] = $qa_feedback;
                    $updata_data['order_feedback'] = $order_feedback;
                    $updata_data['order_type'] = 10;
                    $notice_desc = '【'.$info['parent_order']['title'].'】对方已验收,订单号为'.$info['id'];
                    break;
                default:
                    return redirect("/order/order_detail/{$order_id}")->withInput()->with('status', '操作失败');
                    break;
            }
            DB::beginTransaction();
            $tmp = $updata_status = $OrderNetworkModel->update($updata_data); //更新子订单
            $tmp2 = $tmp3 = $tmp4 = true;
            if (!$updata_status) {
                DB::rollBack();
                return redirect("/order/order_detail/{$order_id}")->withInput()->with('status', '操作失败');
            }

            if ($order_status == 1) { // 取消订单
                // $aduser = AdUsersModel::where('user_id',$info['parent_order']['ads_user_id'])->first();
                // $aduser->user_money = $aduser->user_money + $info['user_money'];
                // $tmp2 = $aduser->save();
                // $accountlog_data[] = [
                //         'user_id' => $info['parent_order']['ads_user_id'],
                //         'user_money' => $info['user_money'], 
                //         'desc' => '取消订单,退还金额',
                //         'account_type' => 4,
                //         'order_sn' => $info['order_sn'],
                //         'order_id' => $info['id'],
                //         'created_at' => date("Y-m-d H:i:s",time()),
                //         'pay_type' => 'laba',
                //         'pay_user' => 'laba',
                //         'status'=>1
                //         ];
                // $tmp3 = UserAccountLogModel::insert($accountlog_data);
                // $notice_desc = '您的订单已被取消,订单号为'.$info['id'];

            } elseif (($order_status == 10 && $qa_feedback != 3) || $order_status ==4) {
                $suppuser = SuppUsersModel::where('user_id',$info['supp_user_id'])->first();
                $suppuser->order_count = $suppuser->order_count + 1;
                $suppuser->save();
                
                $suppuser = SuppUsersModel::where('user_id', $suppuser['parent_id'])->first();
                $suppuser->user_money = $suppuser->user_money + $info['supp_money'];
                $suppuser->order_count = $suppuser->order_count + 1;
                $tmp2 = $suppuser->save();
                $accountlog_data[] = [
                        'user_id' => $suppuser['user_id'],
                        'user_money' => $info['supp_money'], 
                        'desc' => '订单交易成功',
                        'account_type' => 4,
                        'order_sn' => $info['order_sn'],
                        'order_id' => $info['id'],
                        'created_at' => date("Y-m-d H:i:s",time()),
                        'pay_type' => 'laba',
                        'pay_user' =>$user['name'],
                        'status'=>1
                        ];

                $tmp3 = UserAccountLogModel::insert($accountlog_data);
                $notice_desc = '您的订单交易成功,订单号为'.$info['id'];
                $commission = $info['commission'];
                if ($parent_id > 0 && $commission > 0) {
                    $accountlog_data = [
                        'user_id' => $parent_id,
                        'user_money' => $commission, 
                        'desc' => '订单返利',
                        'account_type' => 4,
                        'order_sn' => $info['order_sn'],
                        'order_id' => $info['id'],
                        'created_at' => date("Y-m-d H:i:s",time()),
                        'pay_type' => 'laba',
                        'pay_user' =>$user['name'],
                        'status' => 1,
                        'son_charge' => 2,
                    ];
                    $tmp4 = AdUsersModel::where('user_id',$parent_id)->increment('user_money',$commission);
                    UserAccountLogModel::insert($accountlog_data);
                }
            }
            if ($tmp && $tmp2 && $tmp3 && $tmp4) {
                // 检查主订单，并改变状态
                updateOrderStatus($info['order_sn']);
                SendOrderNotic($info['id'],$info['supp_user_id'],$notice_desc,'用户确认完成');
                DB::commit();
            } else {
                DB::rollBack();
                return redirect("/order/order_detail/{$order_id}")->withInput()->with('status', '操作失败');
            }
            return redirect("/order/order_detail/{$order_id}")->withInput()->with('status', '操作成功');
        }
        return view('console.order.order_info',
            ['info'=>$info,'active'=>'person_edit','user'=>$user,'order_count_all'=>$order_count_all,'is_parent'=>$is_parent]);
    }


    /*
    *订单申诉
    */
    public function order_appeal(Request $request)
    {
        // 如果是订单提交操作
        if ($request->isMethod('post')) {
            $user = $this->getUser();
            $data = $request->all();
            if (!$data['order_id']) {
                return ['status'=>2,'data'=>[],'msg'=>''];
            }
            $order_id = $data['order_id'];
            
            if (OrderAppealModel::where('order_id',$order_id)->first()) {
                return ['status' => 2,'data'=>[],'msg'=>'该订单已经申诉过了奥'];
            }
            $OrderNetworkModel = new OrderNetworkModel();
            //获取订单信息
            $info = $OrderNetworkModel::with(['parent_order','parent_order.user','parent_order.user.ad_user'])
                                ->where('id',$order_id)
                                ->first();
            if (!$info) {
                return redirect("/order/order_appeal")->withInput()->with('status', '未找到相关订单');
            }
            $info = $info->toArray();
            // dd($info);

            // 判断是否高级会员查看下级会员
            if ( $user['user_id'] != $info['parent_order']['ads_user_id']) {
                return redirect("/order/order_appeal")->withInput()->with('status', '未找到相关订单');
            }

            // 判断是否处于相对状态
            if (  $info['order_type'] != 8) {
                return redirect("/order/order_appeal")->withInput()->with('status', '该订单不可执行该操作');
            }

            if (!$data) {
                return redirect("/order/order_appeal")->withInput()->with('status', '操作失败');
            }
            if (!$data['type_name']) {
                return redirect("/order/order_appeal")->withInput()->with('status', '活动类型不能为空');
            }
            if (!$data['title']) {
                return redirect("/order/order_appeal")->withInput()->with('status', '活动名称不能为空');
            }
            if (!$data['success_url']) {
                return redirect("/order/order_appeal")->withInput()->with('status', '完成链接不能为空');
            }
            if (!$data['appeal_title']) {
                return redirect("/order/order_appeal")->withInput()->with('status', '申诉标题不能为空');
            }
            // if (!$data['success_pic']) {
            //     return redirect("/order/order_appeal")->withInput()->with('status', '请上传完成截图');
            // }
            if (!$data['content']) {
                return redirect("/order/order_appeal")->withInput()->with('status', '请填写申诉内容');
            }

            $success_pic = $data['success_pic'];
            // if ($data['success_pic']) {
            //     // $input = Input::except('_token','head_pic');
            //     $path = 'uploads/images/appea_pic/'.$user['user_id'];
            //     $res = $this->uploadpic('success_pic',$path);
            //     switch ($res){
            //         case 1: return redirect('/order/order_appeal')->withInput()->with('status', '图片上传失败');
            //         case 2: return redirect('/order/order_appeal')->withInput()->with('status', '图片不合法');
            //         case 3: return redirect('/order/order_appeal')->withInput()->with('status', '图片后缀不对');
            //         case 4: return redirect('/order/order_appeal')->withInput()->with('status', '图片储存失败');
            //         default :
            //         $success_pic = $res;
            //     }
            // }

            $OrderAppealModel = new OrderAppealModel();

            $OrderAppealModel->order_id = $order_id;
            $OrderAppealModel->order_sn = $info['order_sn'];
            $OrderAppealModel->supp_user_id = $info['supp_user_id'];
            $OrderAppealModel->ads_user_id = $user['user_id'];
            $OrderAppealModel->type_id = $data['type_id'];
            $OrderAppealModel->type_name = $data['type_name'];
            $OrderAppealModel->title = $data['title'];
            $OrderAppealModel->success_url = $data['success_url'];
            $OrderAppealModel->success_pic = $success_pic;
            $OrderAppealModel->appeal_title = $data['appeal_title'];
            $OrderAppealModel->content = $data['content'];
            $order_appeal_id = $OrderAppealModel->save();
            // $order_appeal_id = $OrderAppealModel->id;

            $OrderNetworkModel = $OrderNetworkModel->where('id',$order_id);
            $OrderNetworkModel = $OrderNetworkModel->where('order_type',8);
            $updata_status = $OrderNetworkModel->update(['order_type'=>9]);

            if ($updata_status) {
                SendOrderNotic($order_id,$info['supp_user_id'],'您的订单被冻结,订单号为'.$info['id'],'用户申诉');
                updateOrderStatus($info['order_sn']);
                return redirect('/order/order_list/9')->withInput()->with('status', '操作成功');
            }else {
                return redirect('/order/order_appeal')->withInput()->with('status', '操作失败');
            }

        }

        // return view('console.order.order_appeal',['info'=>$info,'user'=>$user,'is_parent'=>$is_parent]);
        return view('console.order.order_appeal');
    }

    public function select_appeal_order(Request $request)
    {
        $user = $this->getUser();
        $data = $request->all();
        if (!$data['order_id']) {
            return ['status'=>2,'data'=>[],'msg'=>''];
        }
        $order_id = $data['order_id'];
        $OrderNetworkModel = new OrderNetworkModel();
        //获取订单信息
        $info = $OrderNetworkModel::with(['parent_order','parent_order.user','parent_order.user.ad_user'])
                            ->where('id',$order_id)
                            ->first();
        if (!$info) {
            return ['status'=>2,'data'=>[],'msg'=>'未找到相关订单'];
        }
        $info = $info->toArray();
        // dd($info);

        // 判断是否高级会员查看下级会员
        if ( $user['user_id'] != $info['parent_order']['ads_user_id']) {
            return ['status'=>2,'data'=>[],'msg'=>'未找到相关订单'];
        }
        // 判断是否处于相对状态
        if (!in_array($info['order_type'], [8,10])) {
            return ['status'=>2,'data'=>[],'msg'=>'该订单不可执行该操作'];
        }
        // 检查是否申诉过
        if (OrderAppealModel::where('order_id',$order_id)->first()) {
            return ['status' => 2,'data'=>[],'msg'=>'该订单已经申诉过了奥'];
        }

        return ['status'=>1,'data'=>$info,'msg'=>'操作成功'];
    }

    /*
    *申诉订单详情
    */
    public function order_appeal_detail(Request $request,$order_id)
    {
        $user = $this->getUser();
        $is_parent = 0;

        $OrderAppealModel = new OrderAppealModel();
        //获取订单信息
        // DB::enableQueryLog();
        $info = $OrderAppealModel::with(['parent_order','order_network','parent_order.user','parent_order.user.ad_user'])
                            ->where('order_id',$order_id)
                            ->first();
        // dd(DB::getQueryLog());
        if (!$info) {
            return redirect("/order/order_list/9")->withInput()->with('status', '非法操作');
        }
        $info = $info->toArray();

        // 判断是否高级会员查看下级会员
        if ( $user['user_id'] != $info['parent_order']['ads_user_id'] && $user['user_id'] != $info['parent_order']['user']['ad_user']['parent_id']) {

                return redirect("/order/order_list/9")->withInput()->with('status', '非法操作');
        }
        // dd($info);

        // 判断是否处于相对状态
        if (  $info['order_network']['order_type'] != 9) {

                return redirect("/order/order_list/9")->withInput()->with('status', '非法操作');
        }

        if ($user['user_id'] == $info['parent_order']['user']['ad_user']['parent_id']) {
            $is_parent = 1;
        }

        return view('console.order.order_appeal_detail',['info'=>$info,'user'=>$user,'is_parent'=>$is_parent]);
    }

    /*
    *用户申请发票
    */
    public function apply_invoice(Request $request)
    {
        $user_id = Auth::user()->id;

        $invo_detail = \Config::get('invodetail');
        if ($_POST) {
            $data = $request->all();
            // dd($data);
            $invo_type = $data['invo_type'];
            $detail_type = $data['detail_type'];
            $money_type = $data['money_type'];
            $money = $data['money'];
            $send_type = $data['send_type'];
            $invoice_title = $data['invoice_title'];
            $address = isset($data['address'])?$data['address']:'';
            $email = isset($data['email'])?$data['email']:'';
            $remark = isset($data['remark'])?$data['remark']:'';
            $user_id = $user_id;
            $order_id = isset($data['order_id']) ? $data['order_id'] : '';

            if (!$order_id) {
                return redirect('/order/apply_invoice')->withInput()->with('status', '请输入订单号');
            }

            $order_res = OrderNetworkModel::where('ads_user_id',$user_id)->where('id',$order_id)->first();
            if (!$order_res) {
                return redirect('/order/apply_invoice')->withInput()->with('status', '此订单号不存在');
            }
            if ($order_res->user_money - $order_res->qa_change < $money) {
                return redirect('/order/apply_invoice')->withInput()->with('status', '发票金额错误');
            }
            // 是否申请过
            $invo_res = InvoModel::where('order_id',$order_id)->first();
            if ($invo_res) {
                return redirect('/order/apply_invoice')->withInput()->with('status', '此订单已经申请过了');
            }
            if (!$invo_type) {
                return redirect('/order/apply_invoice')->withInput()->with('status', '请选择票据类型');
            }
            // if (!$detail_type) {
            //     return redirect('/order/apply_invoice')->withInput()->with('status', '请选择发票明细');
            // }
            if (!$money_type) {
                return redirect('/order/apply_invoice')->withInput()->with('status', '请选择金额类型');
            }
            if (!$money) {
                return redirect('/order/apply_invoice')->withInput()->with('status', '请填写金额');
            }
            if (!$send_type) {
                return redirect('/order/apply_invoice')->withInput()->with('status', '请选择发送方式');
            }
            if (!$invoice_title) {
                return redirect('/order/apply_invoice')->withInput()->with('status', '请选择票据类型');
            }

            $invo =  new InvoModel();
            $invo->invo_type = $invo_type;
            $invo->detail_type = $detail_type;
            $invo->money_type = $money_type;//$data['breif'];
            $invo->money = $money;
            $invo->send_type = $send_type;
            $invo->invoice_title = $invoice_title;
            $invo->address = $address;
            $invo->email = $email;
            $invo->remark = $remark;
            $invo->user_id = $user_id;
            $invo->order_id = $order_id;
            $status = $invo->save();
              
            if ($status) {
                return redirect('/order/apply_invoice')->withInput()->with('status', '操作成功');
               
            }else {
                return redirect('/order/apply_invoice')->withInput()->with('status', '操作失败');
            }

        }

        return view('console.order.apply_invoice',['invo_detail'=>$invo_detail]);
    }


    /*
    *订单最新受理列表
    */
    public function order_feedback(Request $request)
    {
        $order_status = [
             0 => [0], //取消订单
             1 => [1], //预约状态
             5 => [10], //已完成
             4 => [5,4,6,7,8], //正执行
             3 => [3], //流单
             2 => [2], //拒单
             9 => [9], //申诉订单
        ];

            $status = [
                       0=>'取消',
                       1 => '预约', 
                       2 => '拒绝', 
                       3 => '流单', 
                       4 => '正执行', 
                       5 => '供应商完成', 
                       6 => '供应商反馈', 
                       7 => '广告主反馈', 
                       8 => '广告主质量反馈', 
                       9 => '申诉', 
                       10 => '广告主确认完成'];

        $user_id = Auth::user()->id;
        // 这里
        $order_list = NoticeModel::leftJoin('order_network','order_network.id','=','notice.order_id')
                        ->leftJoin('order','order_network.order_sn','=','order.order_sn');
                        // ->leftJoin('order_appeal','notice.order_id','=','order_appeal.order_id');

        // $order_list = OrderNetworkModel::with(['appeal_order'])
                        // ->leftJoin('order','order_network.order_sn','=','order.order_sn')
                        // ->leftJoin('notice','order_network.id','=','notice.order_id');

                        // ->whereIn('order.ads_user_id',function($query) use($user_id){
                        //             $query->from('ad_users')
                        //                 ->select('user_id')
                        //                 ->where('parent_id',$user_id)->orWhere('user_id',$user_id);
                        //     });
        if (Auth::user()->user_type == 2) {
            $order_list = $order_list->Where('notice.user_id',Auth::user()->id);
        } else if(Auth::user()->user_type == 3) {
            $order_list = $order_list->Where('notice.user_id',Auth::user()->id);
        }

        $order_list = $order_list->orderBy('notice.id','desc')
                                 ->select(
                                    'order_network.ads_user_id',
                                    'order_network.order_type',
                                     'order.title',
                                     'order_network.type_id',
                                     'order_network.type_name',
                                     'order.start_at',
                                     'order.over_at',
                                     'order_network.user_money',
                                     'order_network.id',
                                     'notice.content',
                                     'notice.created_at',
                                     'notice.id as notice_id')
                                 // ->groupBy('')
                                ->get()
                                ->toArray();
                                    // dd($order_list);

        return view('console.order.order_feedback',['order_list'=>$order_list,'status'=>$status]);
    }

    // 通知设为已读
    public function setnotice(Request $request)
    {
        $id = $request->input('id');
        $id = $updata_status = NoticeModel::where('id',$id)
                                    ->update(['is_read'=>1]);
        if ($id) {
            return ['status'=>1,'msg'=>'','data'=>''];
        }
            return ['status'=>2,'msg'=>'','data'=>''];
    }

    /*
    *获取用户信息
    */
    public function getUser()
    {
        $user_id = Auth::user()->id;
        $user_type = Auth::user()->user_type;
        if ($user_type == 2) {
            $user = AdUsersModel::where('ad_users.user_id',$user_id)
                            ->join('users','ad_users.user_id','=','users.id')
                            ->first();
        } elseif ($user_type == 3) {
            $user = SuppUsersModel::where('supp_users.user_id',$user_id)
                            ->join('users','supp_users.user_id','=','users.id')
                            ->first();
        }
        
        $user = $user->toArray();
        return $user;
    }

    //    上传图片
    public function uploadpic($filename, $filepath)
    {
        //        1.首先检查文件是否存在
        if ($this->request->hasFile($filename)){
            //          2.获取文件
            $file = $this->request->file($filename);
            //          3.其次检查图片手否合法
            if ($file->isValid()){
    //                先得到文件后缀,然后将后缀转换成小写,然后看是否在否和图片的数组内
                if(in_array( strtolower($file->extension()),['jpeg','jpg','gif','gpeg','png'])){
                    //          4.将文件取一个新的名字
                    $newName = 'img'.time().rand(100000, 999999).$file->getClientOriginalName();
                    //           5.移动文件,并修改名字
                    if($file->move($filepath,$newName)){
                        return $filepath.'/'.$newName;   //返回一个地址
                    }else{
                        return 4;
                    }
                }else{
                    return 3;
                }

            }else{
                return 2;
            }
        }else{
            return 1;
        }
    }


}





