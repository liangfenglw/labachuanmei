<?php

namespace App\Http\Controllers\Console;

use Illuminate\Http\Request;
use App\Http\Controllers\Console\CommonController;

use App\Model\PlateModel;
use App\Model\SuppVsAttrModel;
use App\Model\SuppUsersModel;
use App\Model\UserAccountLogModel;
use App\Model\OrderModel;
use App\Model\NoticeModel;
use App\Model\OrderNetworkModel;
use App\Model\UsersModel;
use App\Model\UsersEnchashmentModel;
use App\Model\ApplySuppsModel;
use App\Model\AdUsersModel;
use App\Model\OrderNetworkRefundModel;
use App\Model\OrderMediaLogModel;
use App\User;
use Auth;
use DB;

class SuppController extends CommonController
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function suppEdit()
    {
        $id = Auth::user()->id;
        $info = User::where('id',$id)->with('supp_user')->first()->toArray();
        $plate_list = PlateModel::where('pid',0)->with('childPlate')->get();
        //获取供应商的属性
        $all_id = SuppVsAttrModel::where('user_id',$id)
                            ->where('attr_value_id',0)
                            ->pluck('attr_id')
                            ->toArray();
        $attr_id_arr = SuppVsAttrModel::where('user_id',$id)
                            ->where('attr_value_id','>',0)
                            ->pluck('attr_value_id')
                            ->toArray();
        //获取他的分类并且选中
        $class_html = getAttrValue($info['supp_user']['plate_id'],true,$attr_id_arr,$all_id);
        return view('console.supp.edit_info',['info' => $info, 
                                                      'plate_list' => $plate_list, 
                                                      'class_html' => $class_html,
                                                      'active' => 'supp_edit']);
    }

    /**
     * 更新用户信息
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateInfo(Request $request)
    {
        $info = SuppUsersModel::where("user_id",Auth::user()->id)->first();
        $info->media_contact = $request->input('media_contact');
        $info->breif = $request->input('breif');
        $info->media_contact = $request->input('media_contact');
        $info->contact_phone = $request->input('contact_phone');
        $info->email = $request->input('email');
        $info->qq = $request->input('qq');
        $info->address = $request->input('address');
        $info->zip_code = $request->input('zip_code');

        $media_logo = $request->file('media_logo');
        $index_logo = $request->file('index_logo');
        if ($request->hasFile('media_logo')) {
            if (!$request->file('media_logo')->isValid()) {
                return redirect('/supp/supp_edit')->with('status', '文件上传出错！');
            }
            $info->media_logo = $request->media_logo->store('supp_user');
        }
        if ($request->hasFile('index_logo')) {
            if (!$request->file('index_logo')->isValid()) {
                return redirect('/supp/supp_edit')->with('status', '文件上传出错！');
            }
            $info->index_logo = $request->index_logo->store('supp_user');
        }
        //保存图
        $info->save();
        return redirect('/supp/supp_edit')->with('status', '修改成功');
    }

    /**
     * 账户查询
     * @return [type] [description]
     */
    public function accountQuery(Request $request)
    {
        $user_id = Auth::user()->id;
        $withdraw = accountQuery($request,3,$user_id);
        $get_money = accountQuery($request,4,$user_id);
        if ($request->input('get_excel') == 1) {
            if ($request->input('search_type') == 1) {
                $this->getAccountExcel(1, $get_money);
            } else {
                $this->getAccountExcel(2, $withdraw);
            }
        }
        //提现
        $all_withdraw = UserAccountLogModel::where('user_id',$user_id)
                                                ->where('account_type',3)
                                                ->sum('user_money');
        //账户余额
        $user_money = SuppUsersModel::where('user_id',$user_id)->value('user_money');
        //获取总余额
        $all_get_money = OrderNetworkModel::whereIn('supp_user_id', function($query){
            $query->from('supp_users')->where('parent_id', Auth::user()->id)
                    ->select('user_id')
                    ->get();
        })->whereIn('order_type',[4,5]) 
          ->sum('supp_money') + $user_money;

        //拥有媒体资源数
        $media_count = SuppUsersModel::where("parent_id",$user_id)->count();
        //已完成订单数
        $success_order_count = OrderNetworkModel::whereIn('supp_user_id',function($query){
            $query->from('supp_users')->where('parent_id', Auth::user()->id)
                ->select('user_id')
                ->get();
        })
                                    // ->whereIn('order_type',[10])
                                    ->where(function($query){
                                        $query->where('order_type',10)
                                        ->orWhere(function($query){
                                            $query->where('order_type',13)
                                                ->where('deal_with_status','<>',3);
                                        });
                                    })
                                    ->count();
        //媒体分类
        // $plate_lists = PlateModel::where('pid',0)->select('id','plate_name')->get()->toArray();

        //订单统计
        $order_res = OrderNetworkModel::whereIn('order_network.supp_user_id',function($query){
            $query->from('supp_users')->where('parent_id', Auth::user()->id)->select('user_id')->get();
        })
                            ->leftJoin('plate','plate.id','=','order_network.type_id')
                            ->select('pid',DB::raw('count(*) as order_num'))
                            ->groupBy('plate.pid')
                            ->get()
                            ->toArray();
        $order_count_all = [
            '35' => 0,
            '37' => 0,//户外媒体 
            '38' => 0,//平面媒体 
            '39' => 0,//电视媒体 
            '40' => 0, //广播媒体 
            '41' => 0, //记者预约 
            '42' => 0, // 内容代写 
            '43' => 0, //宣传定制
        ];
        
        foreach ($order_res as $key => $value) {
            $order_count_all[$value['pid']] = $value['order_num'];
        }
        return view('console.supp.account_query',
            ['active' => 'account_query', 
             'user_money' => $user_money,
             'all_get_money' => $all_get_money,
             'media_count' => $media_count,
             'success_order_count' => $success_order_count,
             'plate_lists' => getSearchMediaSelect(),
             'order_count_all' => $order_count_all,
             'all_withdraw' => $all_withdraw,
             'withdraw' => $withdraw,
             'get_money' => $get_money]);
    }

    public function getAccountExcel($type, $data) {
        $cell_data = [];
        if ($type == '1') { // 提现
            $cell_data[] = ['日期','订单号','消费方式','消费账号','状态','金额'];
        } elseif ($type == '2') {
            $cell_data[] = ['日期','订单号','订单类型','订单名称','订单状态','截图 / 链接','金额'];
        }
        foreach ($data as $key => $value) {
            if ($this->request->input('query_type') == 1) {
                $cell_data[] = [$value['created_at'],
                                    $value['order_sn'],
                                    getPayType([$value['pay_type']]),
                                    $value['pay_user'],
                                    getCashStatus([$value['status']]),
                                    $value['user_money']
                                ];
            } else {
                 $cell_data[] = [$value['created_at'],
                                 $value['order_id'],
                                 $value['type_name'],
                                 $value['title'],
                                 $value['order_type'],
                                 "<img class=\"link\" src=\"".$value['success_pic']."\" alt=\"|\" />".$value['success_url'],
                                $value['supp_money']];
            }
        }
        $title = [1 => '收入', 2 => '提现'];
        getExcel($title[$type].date('Y-m-d',time()), date('Y-m-d',time()), $cell_data);
        exit();
    }

    public function userCheck()
    {
        $user_id = Auth::user()->id;
        $user = getUserInfo($user_id);
        // dd($user);
        return view('console.supp.user_check',['active' => 'person_safe', 'user' => $user]);
    }

    /**
     * 订单管理
     * @return [type] [description]
     */
    public function order(Request $request,$order_type=0)
    {   
        //订单状态
        \DB::enableQueryLog();
        $order_status = [
             0 => [0], 
	         1 => [1], //预约状态
             5 => [10], //已完成
             4 => [4,5,6,7,8], //正执行
             3 => [3], //流单
             2 => [2], //拒单
             100 => [12,13,14], //退款
             9 => [9], //申诉订单,
        ];
        $supp_uid = Auth::user()->id;
        if ($order_type == 2) {
            $order_list = OrderNetworkRefundModel::leftJoin('order','order_network_refund.order_sn','=','order.order_sn')
                    ->whereIn('order_network_refund.order_type',$order_status[$order_type])
                    ->whereIn('order_network_refund.supp_user_id',function($query) use($supp_uid) {
                            $query->from('supp_users')
                                    ->where('parent_id', $supp_uid)
                                    ->select('user_id')
                                    ->get();
                        });
        } else {
            $order_list = OrderNetworkModel::leftJoin('order','order_network.order_sn','=','order.order_sn')
                        ->whereIn('order_network.supp_user_id',function($query) use($supp_uid) {
                            $query->from('supp_users')
                                    ->where('parent_id', $supp_uid)
                                    ->select('user_id')
                                    ->get();
                        });
        }
        //订单状态
        if (!empty($order_type)) {
            if ($order_type != 2) {
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
            if ($order_type == 2) {
                $order_list = $order_list->where('order_network_refund.id',$request->input('orderid'));
            } else {
                $order_list = $order_list->where('order_network.id',$request->input('orderid'));
            }
            
        }
        if ($order_type == 2) {
            $order_list = $order_list->orderBy('order_network_refund.id','desc')
                                 ->select('order.ads_user_id','order.order_type',
                                     'order.title','order.type_id',
                                     'order.type_name','order.start_at',
                                     'order.over_at','order_network_refund.*')
                                ->get()
                                ->toArray();

        } else {
            $order_list = $order_list->orderBy('order_network.id','desc')
                                 ->select('order.ads_user_id','order.order_type',
                                     'order.title','order.type_id',
                                     'order.type_name','order.start_at',
                                     'order.over_at','order_network.*')
                                ->get()
                                ->toArray();
        }
        // dd($order_list);

            $status = [
        	   0 => '取消',
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
               12 => '申请退款',
               13 => '完成',
               14 => '不同意退款',
               15 => '同意退款'];

            $qa_feedback = [1 => '好', 2 => '中', 3 => '差'];

        //本月订单统计
        $start = date("Y-m-d H:i:s",mktime(0,0,0,date('m'),1,date('Y')));
        $end = date("Y-m-d H:i:s",mktime(23,59,59,date('m'),date('t'),date('Y')));
        \DB::enableQueryLog();
        $order_statistics = OrderNetworkModel::whereIn("supp_user_id",function($query)use($supp_uid){
            $query->from('supp_users')->where('parent_id', $supp_uid)->select('user_id')->get();
        })
            ->select(
        DB::raw("sum(supp_money) as all_money"),
        DB::raw("count(*) as all_count"),
        DB::raw("count(case when order_type in(5,10) then 1 end) as success_count"),//完成订单数
        DB::raw("sum(case when order_type in (5,10) then supp_money end) as success_money"),//完成订单金额
        DB::raw("count(case when order_type = 3 then 1 end) as flow_order_count"),//流单数
        DB::raw("sum(case when order_type = 3 then supp_money end ) as flow_order_money"),//流单金额
        DB::raw("count(case when order_type = 0 then 1 end) as give_up_count"),//取消数
        DB::raw("sum(case when order_type = 0 then supp_money end) as give_up_money")//取消金额
        // DB::raw("count(case when order_type = 2 then 1 end) as refuse_order"),//拒单数
        // DB::raw("sum(case when order_type = 2 then supp_money end) as refuse_money")//拒单金额
            )
            // ->whereBetween('created_at',[$start,$end])
            ->first()
            ->toArray();
        $order_refund = OrderNetworkRefundModel::whereIn('supp_user_id', function($query){
                            $query->from('supp_users')
                                  ->where('parent_id', Auth::user()->id)
                                  ->select('user_id')
                                  ->get();
                        })
            ->select(
                DB::raw("count(case when order_type = 2 then 1 end) as refuse_order"),
                DB::raw("sum(case when order_type =2 then supp_money end) as refuse_money")//完成订单金额
                )
            ->first()
            ->toArray();
        $order_statistics['refuse_order'] = $order_refund['refuse_order'];
        $order_statistics['refuse_money'] = $order_refund['refuse_money'];
        return view('console.supp.order', [
            'active' => 'order_list', 
            'order_type' => $order_type, 
            'order_statistics' => $order_statistics,
            'order_list' => $order_list,
            'status' => $status]);
    }

    /**
     * 订单详情
     * @param  [type] $order_id [description]
     * @return [type]           [description]
     */
    public function orderInfo($order_id)
    {
        //获取订单信息
        $info = OrderNetworkRefundModel::with('parent_order')->where('order_id', $order_id)->first();
        if (empty($info)) {
            $info = OrderNetworkModel::with('parent_order')
                            ->where('id',$order_id)
                            ->first();
        }
        if (empty($info)) {
            return back()->with('status', '订单数据不存在');
        }
        $info = $info->toArray();
        $user_id = Auth::user()->id;
        $notice = NoticeModel::whereIn('user_id', function($query)use($user_id){
                $query->from('supp_users')->where('parent_id', $user_id)->select('user_id')->get();
            })
                    ->where('order_id', $order_id)
                    ->where('is_read',2)
                    ->first();
        if ($notice) {
            $notice->is_read = 1;
            $notice->save();
        }

        $order_status = [
            5 => '等待广告主确认完成',
            10 => '广告主确认完成',
            8 => '广告主质量反馈',
            9 => '订单处于申诉阶段',
            2 => '订单已拒绝'
        ];
        //获取优中差
        $qa_desc = \Config::get('qa-desc');
        return view('console.supp.order_info',[
            'info' => $info, 
            'order_status' => $order_status,
            'qa_desc' => $qa_desc]);
    }

    /**
     * 订单操作
     * @return [type] [description]
     */
    public function orderOpera(Request $request)
    {
        $tmp1 = $tmp2 = true;
        $res = false;
        
        $user_id = Auth::user()->id;
        DB::beginTransaction();

        $info = OrderNetworkModel::with('parent_order')
                            ->where('id',$request->input('order_id'))
                            ->whereIn('supp_user_id',function($query) use($user_id){
                                $query->from('supp_users')
                                        ->where('parent_id', $user_id)
                                        ->select('user_id')
                                        ->get();
                            })
                            ->first();
        if (!$info) {
            return back()->with('status', '订单错误，不可操作');
        }
        $notice_tip = [
            4 => '对方接受了此任务【'.$info['parent_order']['title'].'】'.'，订单号：'.$info->id, 
            2 => '对方拒绝了此任务【'.$info['parent_order']['title'].'】'.'，订单号：'.$info->id, 
            6 => '对方对此任务进行了反馈【'.$info['parent_order']['title'].'】'.'，订单号：'.$info->id, 
            5 => '对方完成了此订单【'.$info['parent_order']['title'].'】'.'，订单号：'.$info->id, 
            100 => '对方重新完成了此订单【'.$info['parent_order']['title'].'】'.'，订单号：'.$info->id, 
            14 => '对方不同意退款【'.$info['parent_order']['title'].'】,等待平台审核'.'，订单号：'.$info->id, 
            15 => '对方同意退款【'.$info['parent_order']['title'].'】,等待平台审核'.'，订单号：'.$info->id];
        $order_type = $request->input('order_type');

        if ($info['order_type'] == 4) { //这个状态只能选择完成
            $order_type = 5;
        }
        $return_url = '/supp/order/info/'.$request->input('order_id');
        //接受、拒绝
        if (in_array($order_type, [4])) { //接受
            $info->order_type = $order_type;
            $info->supp_status = 2; // 已接单
            $message = "操作成功";
        }
        if (in_array($order_type, [2])) { //拒绝
            $info->order_type = 11;
            $message = "操作成功";
            OrderMediaLogModel::insert(
                ['order_id' => $request->order_id,
                 'supp_uid' => $info['supp_user_id'],
                 'ads_uid' => $info['ads_user_id'],
                 'onstate' => 2]);

            OrderNetworkRefundModel::insert([
                'order_id' => $request->input('order_id'),
                'order_sn' => $info['order_sn'],
                'supp_user_id' => $info['supp_user_id'],
                'order_type' => 2,
                'type_id' => $info['type_id'],
                'type_name' => $info['type_name'],
                'user_money' => $info['user_money'],
                'success_url' => $info['success_url'],
                'success_pic' => $info['success_pic'],
                'order_feedback' => $info['order_feedback'],
                'ads_user_id' => $info['ads_user_id'],
                'commission' => $info['commission'],
                'platform' => $info['platform'],
                'supp_money' => $info['supp_money'],
                'self_uid' => $info['self_uid'],
                'media_type' => $info['media_type'],
                'price_type' => $info['price_type'],
                'plateform_price' => $info['plateform_price'],
                'vip_price' => $info['vip_price'],
                'deal_with_status' => $info['deal_with_status'],
                'refund_reason' => $info['refund_reason'],
                'created_at' => date('Y-m-d H:i:s', time()),
                ]);
            //退款操作
            $info->supp_user_id = 0;
            $info->order_type = 11;
            $info->media_type = 12;

            // $ads_user_id = OrderModel::where('order_sn',$info['order_sn'])->value('ads_user_id');
            
            // $tmp1 = AdUsersModel::where('user_id',$ads_user_id)->increment('user_money',$info['user_money']);
            // $accountlog_data[] = [
            //     'user_id' => $ads_user_id,
            //     'user_money' => $info['user_money'], 
            //     'desc' => '拒绝订单',
            //     'account_type' => 4,
            //     'order_sn' => $info['order_sn'],
            //     'order_id' => $info['id'],
            //     'created_at' => date("Y-m-d H:i:s",time()),
            //     'pay_type' => 'laba',
            //     'pay_user' => 'laba',
            //     'status' => 1
            // ];
            // $tmp2 = UserAccountLogModel::insert($accountlog_data);
            updateOrderStatus($info['order_sn']); //更新主订单状态
        }
        //反馈
        if (in_array($order_type, [6])) { //供应商反馈
            $success_url = $request->input('success_url');
            $success_pic = $request->file('success_pic');
            if ($success_pic && $success_pic->isValid()) {
                $success_pic = '/uploads/'.$request->file('success_pic')->store('supp_user');
            }
            $info->success_url = !empty($success_url) ? $success_url : $info->success_url;
            $info->success_pic = !empty($success_pic) ? $success_pic : $info->success_pic;
            $info->supp_feedback = $request->input('supp_feedback');
            $info->order_type = 6;
            $message = "反馈成功";
        }
        // 完成、同意退款
        if ($order_type == 15) {
            $info->order_type = $order_type;
            $info->supp_refund_status = 1;
            $message = "订单更新成功";
        }
        //完成、不同意退款
        if (in_array($order_type, [5,14])) {
            $success_url = $request->input('success_url');
            $success_pic = $request->file('success_pic');
            if ($success_pic && $success_pic->isValid()) {
                $success_pic = '/uploads/'.$request->file('success_pic')->store('supp_user');
                // return redirect($return_url)->with('status', '文件上传出错！');
            }

            if (!$success_pic && !$success_url) {
                return redirect($return_url)->with('status', '完成连接或完成截图 至少填写一个');
            }
            $info->success_url = $success_url;
            $info->supp_refund_status = 2;
            $info->success_pic = $success_pic;
            $info->supp_feedback = !empty($request->input('supp_feedback')) ? $request->input('supp_feedback') : $info->supp_feedback;

            $info->order_type = $order_type;
            $message = "订单更新成功";
        }
        $res = $info->save();

        if ($tmp1 && $tmp2 && $res) {
            $ads_user_id = OrderModel::where('order_sn',$info->order_sn)->value('ads_user_id');
            if (in_array($order_type, [4,5])) { // 接受、完成
                if ($info->deal_with_status == 2) { // 重做
                    SendOrderNotic($info->id, $ads_user_id, $notice_tip['100'],'用户接单');
                } else {
                    SendOrderNotic($info->id, $ads_user_id, $notice_tip[$order_type],'用户接单');
                }
            }
            DB::commit();
        } else {
            DB::rollBack();
        }

        if ($res) {
            if (in_array($order_type, [2,4])) {
                return redirect('/supp/order/1')->with('status', $message);
            }
            return redirect($return_url)->with('status', $message);
        } else {
            $message = '操作失败';
            return redirect($return_url)->with('status', $message);
        }
    }

    /**
     * 提现列表
     * @return [type] [description]
     */
    public function withdraw()
    {
        $user_money = SuppUsersModel::where('user_id',Auth::user()->id)->value('user_money');
        $pay_list = \Config::get('paylist');
        return view('console.supp.withdraw',
            ['active' => 'account_query',
             'balance' => $user_money,
             'pay_list'=>$pay_list]);
    }

    /**
     * 写入提现
     * @return [type] [description]
     */
    public function withdrawOpera(Request $request)
    {
        $data = $request->all();
        $user = UsersModel::leftJoin("supp_users",'supp_users.user_id','=','users.id')
                                ->where('supp_users.user_id',Auth::user()->id)
                                ->select('users.password','supp_users.*')
                                ->first()
                                ->toArray();
        if (!\Hash::check($data['password'], $user['password'])) {
            return ['msg' => "原密码不正确", 'status' => "2", 'data' => ''];
        }

        $balance = trim($data['balance']);
        $pay_type = trim($data['pay_type']);
        $pay_user = trim($data['pay_user']);
        $password = trim($data['password']);

        if (!$balance) {
            return ['status'=>2,'msg'=>'提现金额不能为空','data'=>''];
        }

        if (!is_numeric($balance)) {
            return ['status'=>2,'msg'=>'请输入正确提现金额','data'=>''];
        }
        if ($balance > $user['user_money']) {
            return ['status'=>2,'msg'=>'提现金额不能大于余额','data'=>''];
        }

        if (!$pay_type) {
            return ['status'=>2,'msg'=>'请选择提现方式','data'=>''];
        }

        if (!$pay_user) {
            return ['status'=>2,'msg'=>'请填写提现账号','data'=>''];
        }

        $user_object = UsersModel::where('id',$user['user_id'])->first();

        $order_sn = makePaySn(Auth::id());

        $UsersEnchashment = new UsersEnchashmentModel();
        $UsersEnchashment->user_id = $user['user_id'];
        $UsersEnchashment->user_money = $balance;
        $UsersEnchashment->pay_type = $pay_type;
        $UsersEnchashment->pay_user = $pay_user;
        $UsersEnchashment->order_sn = $order_sn;
        $UsersEnchashment->desc = '用户申请提现';
        $UsersEnchashment->save();
        $UsersEnchashment_id = $UsersEnchashment->id;
        if ($UsersEnchashment_id) {

            $UserAccountLog = new UserAccountLogModel();
            $UserAccountLog->user_id = $user['user_id'];
            $UserAccountLog->user_money = $balance;
            $UserAccountLog->pay_type = $pay_type;
            $UserAccountLog->pay_user = $pay_user;
            $UserAccountLog->order_sn = $order_sn;
            $UserAccountLog->order_id = $UsersEnchashment_id;
            $UserAccountLog->desc = '用户申请提现';
            $UserAccountLog->account_type = 3;
            $UserAccountLog->save();

            $user = SuppUsersModel::where('user_id',$user['user_id'])->first();
            $user->user_money = $user->user_money - $balance;
            $user->save();
            return json_encode(['msg' => "操作成功,请等待管理员审核", 'status' => "1", 'data' => '']);
        }
    }

    /**
     * 资源管理
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function resource(Request $request)
    {
        //获取媒体分类
        $plate_lists = PlateModel::where('pid',0)->where('is_show',1)->get()->toArray();
        // dd($plate_lists);
        // $child_plate = PlateModel::leftJoin("supp_users",'supp_users.plate_id','=','plate.id')
        //                             ->select(DB::raw("count(supp_users.id) as plate_count"),'supp_users.plate_id')
        //                             // ->where()
        //                             ->where('plate.pid',35)
        //                             ->get()
        //                             ->toArray();
        $child_plate = PlateModel::where('pid',35)->get()->toArray();
        foreach ($child_plate as $key => $value) {
            $child_plate[$key]['res_count'] = SuppUsersModel::where('belong',Auth::user()->id)
                                                ->where('plate_id',$value['id'])
                                                ->count();
            $child_plate[$key]['lists'] = SuppUsersModel::where('supp_users.belong',Auth::user()->id)
                                                ->where('supp_users.plate_id',$value['id'])
                                                ->get()
                                                ->toArray();
            // $child_plate[$key]['order_count'] = OrderNetworkModel::whereIn('supp_user_id',function($query){
            //     $query->select('id')->from('plate')->where('pid', $request->input('mediatype'));
            // });
        }
        $all = [];
        $all['res_count'] = SuppUsersModel::where('belong',Auth::user()->id)->count();
        $all['res_success'] = SuppUsersModel::where('belong',Auth::user()->id)->where('is_state',1)->count();
        $all['res_del'] = SuppUsersModel::where('belong',Auth::user()->id)->where('is_state',2)->count();
        $all['res_check'] = SuppUsersModel::where('belong',Auth::user()->id)->where('is_state',3)->count();

        $state_status = [1 => '在线', 2 => '下架', 3 => '审核'];
        $media_status = [1 => '是', 2 => '否', 3 => '否'];
        return view('console.supp.resource',
            ['active' => 'resource',
             'plate_lists' => $plate_lists,
             'child_plate' => $child_plate,
             'state_status' => $state_status,
             'media_status' => $media_status,
             'all' => $all]);
    }

    /**
     * 查看资源信息
     * @return [type] [description]
     */
    public function resourceInfo($id)
    {
        $info = SuppUsersModel::where("id",$id)->with('plate')->first()->toArray();
        // dd($info);
        $child_plate_name = PlateModel::where('id', $info['plate_id'])->first()->plate_name;
        $supp_name = SuppUsersModel::where('user_id', Auth::user()->id)->first()->name;
        $state_status = [1 => '在线', 2 => '下架', 3 => '审核'];

        $spec = SuppVsAttrModel::with('value')->where('user_id', $info['user_id'])->get()->toArray();
        // $child_plate = PlateModel::with(['plateVsAttr','plateVsAttr.attrVsVal'])
        //                         ->where('pid',$info['plate_tid'])
        //                         ->get()
        //                         ->toArray();
        // dd($child_plate);

        return view('console.supp.resource_info',
            ['active' => 'resource',
             'info' => $info,
             'spec' => $spec,
             'child_plate_name' => $child_plate_name,
             'supp_name' => $supp_name,
             'state_status' => $state_status]);
    }

    /**
     * 添加资源
     * @param [type] $id [description]
     */
    public function addResource($id)
    {
        $plate_name = PlateModel::where('id',$id)->first()->plate_name;
        $child_plate = PlateModel::with(['plateVsAttr','plateVsAttr.attrVsVal'])
                                ->where('pid',$id)
                                ->get()
                                ->toArray();
        $supp_name = SuppUsersModel::where('user_id', Auth::user()->id)->first()->name;
        return view('console.supp.add_resource',
            ['plate_name' => $plate_name,
             'plate_tid' => $id,
             'child_plate' => $child_plate,
             'active' => 'resource',
             'supp_name' => $supp_name]);
    }

    /**
     * 保存资源
     * @return [type] [description]
     */
    public function saveResource(Request $request)
    {
        $media_logo = $request->file('ziyuan_logo');
        $index_logo = $request->file('index_logo');
        if (!$request->file('ziyuan_logo')->isValid() || !$request->file('index_logo')->isValid()) {
            return back()->with('status', '文件上传出错！');
        }
        $media_logo = '/uploads/'.$request->ziyuan_logo->store('supp_user');
        $index_logo = '/uploads/'.$request->index_logo->store('supp_user');
        if ($request->input('agree') != 1) {
            return back()->with('status', '请选择是否同意');
        }
        $spec = explode(',', $request->spec);
        if (empty($spec)) {
            return back()->with('status','错误');
        }
        $media_name = $request->media_name;
        if (User::where('name', $media_name)->first()) {
            $media_name = $media_name.'_'.rand(1,10000);
        }
    
        DB::beginTransaction();
        try {
            $user = new User;
            $user->name = $media_name;
            $user->password = bcrypt(env('pwd'));
            $user->role_id = 1;
            $user->head_pic = '';
            $user->user_type = 3;
            $user->is_login = 2; //不可登录
            $user->save();
            $supp_vs_attr_data = [];
            foreach ($spec as $key => $value) {
                $tmp = explode('_', $value);
                $supp_vs_attr_data[] = [
                        'user_id' => $user->id, 
                        'attr_value_id' => $tmp['1'],
                        'attr_id' => $tmp['0'],
                        'created_at' => date("Y-m-d H:i:s",time())];
            }
            SuppVsAttrModel::insert($supp_vs_attr_data);

            $supp_model = new SuppUsersModel;
            $supp_model->user_id = $user->id;
            $supp_model->name = $request->media_name;
            $supp_model->belong = Auth::user()->id;//所属推荐人
            $supp_model->parent_id = Auth::user()->id;
            $supp_model->plate_tid = $request->plate_tid;
            $supp_model->plate_id = $request->plate_id;
            $supp_model->media_name = $request->media_name;
            $supp_model->media_logo = $media_logo;
            $supp_model->index_logo = $index_logo;
            $supp_model->proxy_price = $request->input('proxy_price');
            $supp_model->platform_price = 0;
            $supp_model->media_contact = $request->input('media_contact');
            $supp_model->contact_phone = $request->input('contact_phone');
            // $supp_model->company_name = $request->input('company_name');
            $supp_model->email = $request->email;
            $supp_model->qq = $request->qq;
            $supp_model->address = $request->address;
            $supp_model->zip_code = $request->zip_code;
            $supp_model->media_check = 1;
            $supp_model->media_check_file = '';//认证图
            $supp_model->breif = '';
            $supp_model->remark = $request->remark;
            $supp_model->is_state = 3;
            $supp_model->web_contact = $request->web_contact;
            $supp_model->save();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect($return_url)->with('status', '网络错误');
        }
        DB::commit();
        return redirect('/supp/resource')->with('status','提交申请成功');
    }

    public function orderList()
    {
        //订单状态
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
                   10 => '广告主确认完成',
                   14 => '申请退款，不同意'];

        $user_id = Auth::user()->id;
        $order_list = OrderNetworkModel::leftJoin('order','order_network.order_sn','=','order.order_sn');
        if (Auth::user()->user_type == 2) {
            $order_list = $order_list->Where('order_network.ads_user_id',Auth::user()->id);
        } else if(Auth::user()->user_type == 3) {
            $order_list = $order_list->Where('order_network.supp_user_id',Auth::user()->id);
        }

        $order_list = $order_list->orderBy('order_network.updated_at','desc')
                                ->select(
                                    'order_network.ads_user_id',
                                    'order_network.order_type',
                                    'order.title',
                                    'order_network.type_id',
                                    'order_network.type_name',
                                    'order_network.created_at',
                                    'order.start_at',
                                    'order.over_at',
                                    'order_network.supp_status',
                                    'order_network.deal_with_status',

                                    'order_network.user_money',
                                    'order_network.id')
                                ->whereBetween('order_network.updated_at',getTimeInterval('now_week'))
                                ->get()
                                ->toArray();
        return view('console.supp.news_order_list',['order_list'=>$order_list,'status'=>$status]);
    }
}
