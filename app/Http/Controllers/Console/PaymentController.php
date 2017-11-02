<?php

namespace App\Http\Controllers\Console;

use Illuminate\Http\Request;
use App\Http\Controllers\Console\CommonController;
use App\Model\UserAccountLogModel;
use App\Model\AdUsersModel;
use App\Model\UsersModel;
use EasyWeChat\Payment\Order;
use EasyWeChat\Foundation\Application;


use Auth;
use Cache;
use DB;
use Session;
use Input;
use Log;


class PaymentController extends Controller
{
    public function __construct(Request $request)
    {
        // parent::__construct();
        $this->request = $request;
    }

    /**
     *
     * ios支付宝签名
     */


    /**
     * @return mixed
     * 手机支付
     */
    public function mobile_pay(){
        // 创建支付单。
        $alipay = app('alipay.mobile');
        $order_id=date('YmdHis') . mt_rand(1000,9999);
        $order_price=0.01;
        $goods_name="情人节狗粮";
        $goods_description="";//产品描述暂无
        $alipay->setOutTradeNo($order_id);//订单号
        $alipay->setTotalFee($order_price);//价格
        $alipay->setSubject($goods_name);//商品名称
        $alipay->setBody($goods_description);//描述

        // 返回签名后的支付参数给支付宝移动端的SDK。
        return $alipay->getPayPara();
    }
    /**
     * @return mixed
     * 网页支付,支付宝
     */
    public function balance_pay_ali(Request $request){
        $data = $request->all();
        $alipay = app('alipay.web');
        $order_sn = makePaySn(Auth::id());
        $order_price=$data['money'];
        $goods_name="充值账户";
        $goods_description="";//产品描述暂无
        $alipay->setOutTradeNo($order_sn);
        $alipay->setTotalFee($order_price);
        $alipay->setSubject($goods_name);
        $alipay->setBody($goods_description);
        if ($order_price<10){
            // return json_encode(['msg'=>'每次充值不能低于10元！','status'=>'2']);
        }
        $user = Auth::user();
        $accountlog = new UserAccountLogModel();
        $accountlog->account_type =1;
        $accountlog->pay_type ='alipay';
        $accountlog->user_id=$user->id;
        $accountlog->user_money = $order_price;
        $accountlog->desc = '账户充值';
        $accountlog->order_sn = $order_sn;
        $accountlog->pay_user = '';
        $accountlog->save();
        return json_encode(['msg'=>'','status'=>'1','data'=>$alipay->getPayLink(),'order_sn'=>$order_sn]);
        
    }

    /**
     * @return mixed
     * 网页支付,微信
     */
    public function balance_pay_wx(Request $request){
        $data = $request->all();

        $order_sn = makePaySn(Auth::id());
        $order_price=$data['money'];

        if ($order_price<10){
            // return json_encode(['msg'=>'每次充值不能低于10元！','status'=>'2']);
        }

        $attributes = [
            'trade_type'       => 'NATIVE', // JSAPI，NATIVE，APP...
            'body'             => '充值账户',
            'detail'           => '账户充值',
            'out_trade_no'     => $order_sn,
            'total_fee'        => $order_price*100, // 单位：分
            'notify_url'       => 'http://'.$_SERVER['HTTP_HOST'].'/payment/wx_webnotify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'openid'           => '', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            // ...
        ];

        $order = new Order($attributes);

        $user = Auth::user();
        $accountlog = new UserAccountLogModel();
        $accountlog->account_type =1;
        $accountlog->pay_type ='wechat';
        $accountlog->user_id=$user->id;
        $accountlog->user_money = $order_price;
        $accountlog->desc = '账户充值';
        $accountlog->order_sn = $order_sn;
        $accountlog->pay_user = '';
        $accountlog->save();

        $payment = \EasyWeChat::payment();
        $result = $payment->prepare($order);
        // print_r($result);die();
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            $prepayId = $result->prepay_id;
            $code_url = $result->code_url;
        }

        $img = qr_code($code_url);
        $img = "data:image/png;base64,$img";
        return json_encode(['msg'=>'','status'=>'1','data'=>'<img alt="模式二扫码支付" src="'.$img.'" style="width:110px;height:110px;"/>','order_sn'=>$order_sn]);   
        
    }

    /*
    *ajax查询订单状态
    */
    public function ajax_check_balance(Request $request)
    {
        $data = $request->all();
        if (!$data['order_sn']) {
            return ['status'=>2,'data'=>[],'msg'=>'系统繁忙'];
        }

        $accountlog = UserAccountLogModel::where('order_sn', '=', $data['order_sn'])->first()->toArray();

        if (!$accountlog) {
            return ['status'=>2,'data'=>[],'msg'=>'系统繁忙'];
        }

        return ['status'=>1,'data'=>$accountlog,'msg'=>''];

    }


    /**
     * @return string
     *
     * 微信网页异步提示
     *
     */
    public function wx_webnotify(Application $app){

        $response = $app->payment->handleNotify(
            function($notify, $successful){
                // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
                $accountlog = UserAccountLogModel::where('order_sn', '=', $notify->out_trade_no)
                                ->where('account_type','=',1)
                                ->first();
                if (!$accountlog) { // 如果订单不存在
                    return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
                }
                // 检查订单是否已经更新过支付状态
                if ($accountlog->status) { // 假设订单字段“支付时间”不为空代表已经支付
                    return true; // 已经支付成功了就不再更新了
                }
                $this->vipTipMsg($accountlog->user_id);
                // 用户是否支付成功
                if ($successful) {
                    // 不是已经支付状态则修改为已经支付状态
                    $accountlog->status = 1;
                    $accountlog->pay_user = $notify->openid;
                    $accountlog->save();

                    $user = AdUsersModel::where('user_id',$accountlog->user_id)->first();
                    $user->user_money = $user->user_money + $accountlog->user_money;
                    $user->save();

                } else { // 用户支付失败
                }
            return true; // 返回处理完成
        });
        return $response;
    }

    public function vipTipMsg($user_id)
    {
        $info = AdUsersModel::where('user_id',$user_id)->where('level_id','1')->first();
        if (!$info) {
            return;
        }
        $charge_money = UserAccountLogModel::where('account_type',1)->sum('user_money');
        
        if (env('VIP_CHARGE_MONEY') <= $charge_money) {
            // 提醒他
            // $info->mobile = '18102686865';
            sendSms($info->mobile,env('VIP_TIP'),$ex='');
        }
    }

    /**
     * @return string
     *
     * 支付宝网页异步提示
     *
     */
    public function webnotify(Request $request){
        // 验证请求。
        if (! app('alipay.web')->verify()) {
            Log::notice('Alipay notify post data verification fail.', [
                // 'data' => Request::instance()->getContent()
            ]);
            return 'fail';
        }
        /**
         *
         * 判断通知类型。
         */
        switch ($request->input('trade_status')) {
            case 'TRADE_SUCCESS':
            case 'TRADE_FINISHED':
                $accountlog = UserAccountLogModel::where('order_sn', '=', $request->input('out_trade_no'))
                                                  ->where('account_type', '=', 1)
                                                  ->first();
                $accountlog->state =1;
                $accountlog->pay_user = $request->input('buyer_email');

                // $user = User::find($accountlog->user_id);
                $user = AdUsersModel::where('user_id',$accountlog->user_id)->first();
                // Log::notice("------".$accountlog->user_money."-------");
                $user->user_money = $user->user_money + $accountlog->user_money;
                // $message = new Message();
                // $message->title = '充值完成';
                // $message->receive = $wealthlog->user_id;
                // $message->message = '你于'.$wealthlog->created_at.'发起的充值已到账！';
                // $message->save();
                $user->save();
                $accountlog->save();
                $this->vipTipMsg($accountlog->user_id);
                break;
            case 'TRADE_CLOSED':

                // $message = new Message();
                // $message->title = '充值失败';
                // $message->receive = $wealthlog->user_id;
                // $message->message = '你于'.$wealthlog->created_at.'发起的充值放弃付款！';
                // $message->save();
                // $wealthlog->remark = '用户放弃付款！';
                // $wealthlog->save();
        }
        return 'success';
    }

    /**
     * @return mixed
     *
     */
    public function webreturn(Request $request){
     // 验证请求。
        $order_type = 'recharge';
        $order_id = '';

        if (!app('alipay.web')->verify()) {
            Log::notice('Alipay return query data verification fail.', [
                'data' => Request::getQueryString()
            ]);
            return view('Admin.pay.pay_fail',['order_type'=>$order_type]);
        }

        // $data = $request->all();
        // 判断通知类型。
        switch ($request->input('trade_status')) {
            case 'TRADE_SUCCESS':
            case 'TRADE_FINISHED':
                // TODO: 支付成功，取得订单号进行其它相关操作。
                Log::debug('Alipay notify get data verification success.', [
                    'out_trade_no' => $request->input('out_trade_no'),
                    'trade_no' => $request->input('trade_no')
                ]);

                break;
        }

        return view('console.pay.pay_success',['order_type'=>$order_type,'order_id'=>$request->input('out_trade_no')]);

    }


    /*
    支付成功页面
    */
    function pay_success(Request $request)
    {
        $order_type = 'order';
        return view('console.pay.pay_success',['order_type'=>$order_type]);
    }


    /*
    支付失败页面
    */
    function pay_fail()
    {
        $order_type = 'recharge';
        return view('console.pay.pay_fail',['order_type'=>$order_type]);
    }

    /**
     * 手机端
     * 支付宝异步通知
     */
    public function alipayNotify(Request $request)
    {
        // 验证请求。
        if (! app('alipay.mobile')->verify()) {
            Log::notice('Alipay notify post data verification fail.', [
                'data' => Request::instance()->getContent()
            ]);
            return 'fail';
        }

        // 判断通知类型。
        switch ($request->input('trade_status')) {
            case 'TRADE_SUCCESS':
            case 'TRADE_FINISHED':
                // TODO: 支付成功，取得订单号进行其它相关操作。
                Log::debug('Alipay notify get data verification success.', [
                    'out_trade_no' => $request->input('out_trade_no'),
                    'trade_no' => $request->input('trade_no')
                ]);
                break;
        }

        return 'success';
    }
}
