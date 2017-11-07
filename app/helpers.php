<?php
use Illuminate\Http\Request;

use App\Model\AdminMenuModel;
use App\Model\PlateModel;

use App\Model\SuppUsersModel;
use App\Model\SuppVsAttrModel;
use App\Model\PlateAttrModel;
use App\Model\PlateAttrValueModel;
use App\Model\UserLevelModel;
use App\Model\AdUsersModel;
use App\Model\NoticeModel;
use App\Model\OrderModel;
use App\Model\OrderNetworkModel;
use App\Model\UserAccountLogModel;
use App\Model\SuppUsersSelfModel;
use App\User;

if (!function_exists('getMenuList')) {
    /**
     * 获取菜单列表
     * @param   $role_id 权限id
     * @param  [type] $user_id 用户id
     * @return [type]          [description]
     */
    function getMenuList($role_id,$user_id) {
        if ($role_id == 1) { //高级权限
            $menu_list = AdminMenuModel::with(['admin_menu' => function($query){
                                $query->where('is_show',1);
                            }])
                            ->where('is_show',1)
                            ->where('pid',0)
                            ->get()
                            ->toArray();
        } else {
            $menu_list = AdminMenuModel::whereIn('id',function($query) use($user_id) { //获取所拥有的二级菜单id
                            $query->from('admin_menu')
                                       ->whereIn('id', function($query) use($user_id) { //获取拥有的菜单id
                                            $query->select('menu_id')->from('admin_vs_role')->where('uid',$user_id);
                                           })
                                       ->where('type',2)
                                       ->where('is_show',1)
                                       ->select('pid');
                                })
                                ->with('admin_menu')
                                ->where('pid',0)
                                ->where('is_show',1)
                                ->get()
                                ->toArray();
        }
        Cache::forever('adminMenu_'.$user_id, $menu_list);
        return $menu_list;
    }
}

/**
 * 获取当前控制器名
 *
 * @return string
 */
 function getCurrentControllerName()
{
    return getCurrentAction()['controller'];
}

/**
 * 获取当前方法名
 *
 * @return string
 */
 function getCurrentMethodName()
{
    return getCurrentAction()['method'];
}

/**
 * 获取当前控制器与方法
 *
 * @return array
 */
 function getCurrentAction()
{
    $action = \Route::current()->getActionName();
    list($class, $method) = explode('@', $action);

    return ['controller' => $class, 'method' => $method];
}



/**
*发送短信
* @param string $phone 必填参数。合法的手机号码，号码间用英文逗号分隔
* @return string $msg 短信内容长度不能超过536个字符。使用URL方式编码为UTF-8格式。短信内容超过70个字符（企信通是60个字符）时，会被拆分成多条，然后以长短信的格式发送。
* @return int $ex  可选参数，扩展码，用户定义扩展码,扩展码的长度将直接影响短信上行接收的接收。固需要传扩展码参数时，请提前咨询客服相关设置问题。
* @return string 
*/
function sendSms($phone,$msg,$ex='')
{
	// $url = 'http://192.168.0.108:8073/api/sendSms';
    $url = 'http://bee.heifeng.xin/api/sendSms';
	if(empty($phone)) return ['status'=>0,'msg'=>'手机号码不能为空'];
	if(empty($msg)) return ['status'=>0,'msg'=>'短信内容不能为空'];
	// 读取用户短信密码配置

	$postData = [];
	$postData['phone'] = $phone;
	$postData['msg'] = $msg;
	$postData['ex'] = $ex;
	$postData['username'] = env('SMS_USERNAME');
	$postData['password'] = env('SMS_PASSWORD');

	$result = curlPost($url,$postData);

	$result = json_decode($result,true);
    if (!$result['status']) {
        return ['status'=>2,'msg'=>$result['msg']];
    }

    return ['status'=>1,'msg'=>$result['msg']];
}

/**
 * 邮件发送
 * @param $to    接收人
 * @param string $subject   邮件标题
 * @param string $content   邮件内容(html模板渲染后的内容)
 * @throws Exception
 * @throws phpmailerException
 */
function send_email($to,$subject='',$content=''){    ;
    require (app_path() . '/Libs/phpmailer/PHPMailerAutoload.php');
    $mail = new \PHPMailer;
    $config = [];
    $config['smtp_server'] = env('MAIL_SMTP_SERVER');
    $config['smtp_port'] = env('MAIL_POST');
    $config['smtp_user'] = env('MAIL_SMTP_USER');
    $config['smtp_pwd'] = env('MAIL_SMTP_PWD');
    $mail->CharSet  = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->isSMTP();
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 2;
    //调试输出格式
    //$mail->Debugoutput = 'html';
    //smtp服务器
    $mail->Host = $config['smtp_server'];
    //端口 - likely to be 25, 465 or 587
    $mail->Port = $config['smtp_port'];
    
    if($mail->Port === 465) $mail->SMTPSecure = 'ssl';// 使用安全协议
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    //用户名
    $mail->Username = $config['smtp_user'];
    //密码
    $mail->Password = $config['smtp_pwd'];
    //Set who the message is to be sent from
    $mail->setFrom($config['smtp_user']);
    //回复地址
    //$mail->addReplyTo('replyto@example.com', 'First Last');
    //接收邮件方
    if(is_array($to)){
        foreach ($to as $v){
            $mail->addAddress($v);
        }
    }else{
        $mail->addAddress($to);
    }

    $mail->isHTML(true);// send as HTML
    //标题
    $mail->Subject = $subject;
    //HTML内容转换
    $mail->msgHTML($content);
    //Replace the plain text body with one created manually
    //$mail->AltBody = 'This is a plain-text message body';
    //添加附件
    //$mail->addAttachment('images/phpmailer_mini.png');
    //send the message, check for errors
    return $mail->send();
} 

    // 二维码
     function qr_code($url){        
        require (app_path() . '/Libs/phpqrcode/phpqrcode.php');   

        error_reporting(E_ERROR);            
        $url = $url;
        \QRcode::png($url);  
        $imageString = base64_encode(ob_get_contents()); 
        ob_end_clean();
        return $imageString;            
    }

/**
* 通过CURL发送HTTP请求
* @param string $url  //请求URL
* @param array $postFields //请求参数 
* @return mixed
*/
function curlPost($url,$postFields){
	$postFields = http_build_query($postFields);
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_POST, 1 );
	curl_setopt ( $ch, CURLOPT_HEADER, 0 );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt ( $ch, CURLOPT_URL, $url );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $postFields );
	$result = curl_exec ( $ch );
	curl_close ( $ch );
	return $result;
}

/**
 * 获取用户信息
 * @param  [type] $user_id 用户id
 * @return [type]          [description]
 */
function getUserInfo($user_id)
{
    $user_type = DB::table('users')->where('id',$user_id)->value('user_type');
    if ($user_type == 1) {
        $info = DB::table('users')->where('id',$user_id)
                    ->select('name','id','id as admin_id','role_id','user_type','created_at')
                    ->first();
    } elseif ($user_type == 2) {
        $info = DB::table('ad_users')->where('ad_users.user_id',$user_id)
                    ->join('users','ad_users.user_id','=','users.id')
                    ->first();
    } elseif ($user_type == 3) {
        $info = DB::table('supp_users')->where('supp_users.user_id',$user_id)
                    ->join('users','supp_users.user_id','=','users.id')
                    ->first();
    }

    return get_object_vars($info);
}

/**
 * 获取分类
 * @param  [type]  $attr_id     二级栏目id
 * @param  boolean $to_html     是否输出html
 * @param  array   $in_arr_data 选中的id
 * @return
 */
function getAttrValue($attr_id,$to_html=false,$in_arr_data=[],$all_id=[])
{
    $lists = PlateModel::with(['plateVsAttr','plateVsAttr.attrVsVal'])
                        ->where('id',$attr_id)
                        ->first();
    if (!$lists) {
        return ;
    }
    $lists = $lists->toArray();
    if ($to_html) {
        $html = "";
        foreach ($lists['plate_vs_attr'] as $key => $value) {
                if ($value['attr_name'] == '参考报价') {
                    continue;
                }

                $html .= '
                        <div class="sbox_1_item clearfix">
                            <span class="l" data="option_4" style="">
                                <strong>'.$value['attr_name'].'：</strong>
                            </span>
                            <div class="m">
                                <ul class="sortable" category_id="'.$value['id'].'" set_name="network">
                                    <li data_id="0">';
                //判断是否不限
                if (in_array($value['id'],$all_id)) {
                    // $html .= '<a class="cur" data_id="'.$value['id'].'-0" href="javascript:;">不限</a></li>';
                } else {
                    // $html .= '<a data_id="'.$value['id'].'-0" href="javascript:;">不限</a></li>';
                }
                
                foreach ($value['attr_vs_val'] as $kk => $vv) {
                    //检查是否选中了
                    // dd($in_arr_data);
                    if (in_array($vv['id'],$in_arr_data)) {
                        $html .= "<li data_id=\"$vv[id]\"><a data_id=\"$value[id]-$vv[id]\" class=\"cur\" category_id=\"$value[id]\" class=\"\" href=\"javascript:;\">".$vv['attr_value']."</a></li>";
                    } else {
                        $html .= "<li data_id=\"$vv[id]\"><a data_id=\"$value[id]-$vv[id]\" category_id=\"$value[id]\" class=\"\" href=\"javascript:;\">".$vv['attr_value']."</a></li>";
                    }
                    
                }
                $html .= '</ul></div></div>';
            }
        return $html;
    }
}

/**
 * 获取分类
 * @param  [type]  $attr_id     二级栏目id
 * @param  boolean $to_html     是否输出html
 * @param  array   $orLimit     1默认不限 2禁止不限
 * @return
 */
function getAttrValueSale($attr_id,$to_html=false,$or_limit=1,$in_arr_data=[])
{
    $lists = PlateModel::with(['plateVsAttr','plateVsAttr.attrVsVal'])
                        ->where('id',$attr_id)
                        ->first()
                        ->toArray();
    if (!$lists) {
        return ['status'=>2,'data'=>[],'msg'=>'未找到此媒体'];
    }

    if ($to_html) {
        $select_html = ""; // 已选择的
        $html = "";
        foreach ($lists['plate_vs_attr'] as $key => $value) {
                if ($key == 5 && $value['attr_name'] != '参考报价') {
                    $key++;
                }
                if($value['attr_name'] == '参考报价'){
                    $key = 5;
                }
                $html .= '
                        <div class="sbox_1_item clearfix">
                            <span class="l" data="option_'.$key.'" style="">
                                <strong>'.$value['attr_name'].'：</strong>
                            </span>
                            <div class="m">
                                <ul class="sortable" category_id="'.$key.'" set_name="network">
                                    <li>';
                //判断是否不限
                if ($or_limit == 1) {
                    $html .= '<a class="cur" data_id="'.$value['id'].'-0" href="javascript:;">不限</a></li>';
                } else { //传入指定了的供应商 不能默认选中不限
                    if ($value['attr_name'] == '参考报价') {
                        $html .= '<a class="cur" data_id="'.$value['id'].'-0" href="javascript:;">不限</a></li>';
                    } else { 
                        $html .= '<a data_id="'.$value['id'].'-0" href="javascript:;">不限</a></li>';
                    }
                }
                // dd($in_arr_data,$value['attr_vs_val']);
                foreach ($value['attr_vs_val'] as $kk => $vv) {
                    //检查是否选中了
                    if (in_array($vv['id'],$in_arr_data)) {
                        $html .= "<li data_id=\"$vv[id]\"><a data_id=\"$value[id]-$vv[id]\" class=\"cur\" category_id=\"$vv[id]\" class=\"\" href=\"javascript:;\">".$vv['attr_value']."</a></li>";

                        $select_html .= '<li data=\"option_'.$key.'\" data_id="'.$vv['id'].'"><a href="javascript:;">'.$vv['attr_value'].'</a></li>';
                    } else {
                        $html .= "<li data_id=\"$vv[id]\"><a data_id=\"$value[id]-$vv[id]\" category_id=\"$vv[id]\" class=\"\" href=\"javascript:;\">".$vv['attr_value']."</a></li>";
                    }
                    
                }
                $html .= '</ul></div></div>';
            }
        return ['status'=>1,'data'=>['html' => $html, 'media' => $lists, 'select_html' => $select_html],'msg'=>''];
    }
}

function generateStroagePath()
{
    $dir_name = date('Y-m-d', time());
    $path = public_path().'/uploads/'.$dir_name.'/';
    if (!is_dir($path)) {
        mkdir($path, 777);
    }
    return $path;
}

function fileExtension($file)
{
    $file_info = pathinfo($file);
    return strtolower($file_info['extension']);
}

/**
 * @param $member_id
 * @return string
 * 生成订单号
 */
function makePaySn($member_id) {
    return mt_rand(10,99)
        . sprintf('%010d',time() - 946656000)
        . sprintf('%03d', (float) microtime() * 1000)
        . sprintf('%03d', (int) $member_id % 1000);
}

/**
 * 获取订单的状态
 * @param  [type] $orderType [description]
 * @return [type]            [description]
 */
function getOrderType($orderType) {
    if (Auth::user()->user_type == 2) {
        $status = [ 0 => '全部',
           1 => '预约', 
           2 => '拒绝', 
           3 => '流单', 
           4 => '正执行', 
           5 => '供应商完成', 
           6 => '供应商反馈', 
           7 => '广告主反馈', 
           8 => '广告主质量反馈', 
           9 => '申诉', 
           10 => '确认完成',
           // 100 => '未匹配',
           1000 => '退款',
           11 => '未匹配',
           12 => '申请退款',
           13 => '完成',
           14 => '申请退款',
           15 => '申请退款',
        ];
    } else {
        $status = [ 0 => '全部',
           1 => '预约', 
           2 => '拒绝', 
           3 => '流单', 
           4 => '正执行', 
           5 => '供应商完成', 
           6 => '供应商反馈', 
           7 => '广告主反馈', 
           8 => '广告主质量反馈', 
           9 => '申诉', 
           10 => '确认完成',
           // 100 => '未匹配',
           1000 => '退款',
           11 => '未匹配',
           12 => '申请退款',
           13 => '确认完成',
           14 => '供应商不同意退款',
           15 => '供应商同意退款',
        ];
    }
    
    return $status[$orderType];
}

/**
 * 获取会员审核状态
 * @param  [type] $type [description]
 * @return [type]       [description]
 */
function getVipCheckType($type)
{
    $status = [
        1 => '默认',
        2 => '待审核',
        3 => '审核不通过',
        4 => '完成',
    ];
    return $status[$type];
}


/*
*获取所筛选分类的供应商id
 * @param  [type]  $attr_id     二级栏目id
 * @param  string $attr_val     选择的筛选分类id
* @return array
*/
function get_supp_users_id($attr_id_one,$attr_val,$level_id) {
    // 获取一级id
    $screen_array = [];
    $offer = [];
    $user_ids = [];
    $all_0 = 0;
    $is_null = 0;
    $attr_val = explode(",",$attr_val);
    $rebate_percent = UserLevelModel::where('id',$level_id)->value('rebate_percent');
    $rebate_percent = $rebate_percent?$rebate_percent:1;

    $plate_attr = PlateAttrModel::where("plate_id",$attr_id_one)
                                    ->get()
                                    ->toArray();

    foreach ($plate_attr as $key => $value) {
        $screen_array[$value['id']] = $value;
        $screen_array[$value['id']]['screen'] = [];
        if ($key == count($plate_attr)-1) {
            $price_id = $value['id'];
        }
    }
    foreach ($attr_val as $key => $value) {
        $tmp = explode("-", $value);
        $attr_id = $tmp['0'];
        $attr_value_id = $tmp['1'];
        if ($attr_value_id>0) {
            if ($attr_id!=$price_id) {
                $screen_array[$attr_id]['screen'][] = $attr_value_id;
            }else{
                $offer = $attr_value_id;
            }
            
          
        }
    }
    $i =0;
    foreach ($screen_array as $key => $value) {
        if ($value['screen']) {
            $user_ids = getUserOfAttrValueId($attr_id_one,$value['screen'],$user_ids);
            $all_0++;
            if($all_0>0 && !$user_ids){
                $is_null++;
                }
        }
       
    }

    if ($all_0 == 0) { 
        $user_ids = SuppUsersSelfModel::where('plate_id',$attr_id_one)
                           ->where('is_state',1)
                           ->pluck('user_id')
                           ->toArray();
    }

    if ($offer) {
            $user_ids = select_price($attr_id_one,$user_ids,$offer,$rebate_percent);
    }

    if ($is_null>0) {
        $user_ids = [];
    }
    return $user_ids;
}

/*
*匹配所筛选分类的对应类名
 * @param  [type]  $attr_id_one     二级栏目id
 * @param  string $attr_val     选择的筛选分类id
 * @param  array $list     list
* @return array
*/
function matched_list($attr_id_one,$attr_val,$lists) {
    // 获取一级id
    $screen_array = [];
    $offer = [];
    $user_ids = [];
    $all_0 = 0;
    $is_null = 0;
    $sale_show_attribute_status = getSaleShowAttributeStatus($attr_id_one);

    $attr_val = $attr_val?explode(",",$attr_val):[];

    $plate_attr = PlateAttrModel::where("plate_id",$attr_id_one)
                                    ->get()
                                    ->toArray();

    foreach ($plate_attr as $key => $value) {
        $screen_array[$value['id']] = $value;
        $screen_array[$value['id']]['screen'] = [];
        if ($key == count($plate_attr)-1) {
            $price_id = $value['id'];
        }
    }
    foreach ($attr_val as $key => $value) {
        $tmp = explode("-", $value);
        $attr_id = $tmp['0'];
        $attr_value_id = $tmp['1'];
        if ($attr_value_id>0) {
            if ($attr_id!=$price_id) {
                $screen_array[$attr_id]['screen'][] = $attr_value_id;
            }else{
                $offer = $attr_value_id;
            }
            
          
        }
    }

    // dd($lists);
    foreach ($lists as $key => $value) {
            foreach ($value['attr_value_id'] as $k => $v) {
                foreach ($sale_show_attribute_status as $ks => $vs) {
                    if ($v['attr_id'] == $ks) {
                        $lists[$key][$vs] = isset($lists[$key][$vs])?$lists[$key][$vs]:$v['value']['attr_value'];
                        if (in_array($v['attr_value_id'],$screen_array[$ks]['screen'])) {
                            $lists[$key][$vs] = $v['value']['attr_value'];
                        }
                    }
                }
            }
        }
    return $lists;
}

 /*
    *获得类别所属类
    */
function getUserOfAttrValueId($plate_id,$attr_value_id,$user_ids = [],$is_state=1)
{
    // \DB::enableQueryLog();
    $SuppVsAttrModel = new SuppVsAttrModel();
    $SuppVsAttrModel = $SuppVsAttrModel->where('supp_users_self.plate_id',$plate_id);
    $SuppVsAttrModel = $SuppVsAttrModel->where('supp_users_self.is_state',$is_state);
    $SuppVsAttrModel = $SuppVsAttrModel->leftjoin('supp_users_self','supp_users_self.user_id','supp_vs_attr.user_id');

    if ($user_ids) {
        $SuppVsAttrModel = $SuppVsAttrModel->whereIn('supp_users_self.user_id',$user_ids);
    }
    $SuppVsAttrModel->whereIn('supp_vs_attr.attr_value_id',$attr_value_id);

    $user_ids = $SuppVsAttrModel->distinct()
                                 ->pluck('supp_users_self.user_id')
                                 ->toArray();
     // dd(\DB::getQueryLog());
    return $user_ids;

}

function select_price($plate_id,$user_ids=[],$offer,$rebate_percent,$last_user = false,$is_state=1)
{
    // \DB::enableQueryLog();
    $SuppVsAttrModel = new SuppVsAttrModel();
    $SuppVsAttrModel = $SuppVsAttrModel->where('supp_users_self.plate_id',$plate_id);
    $SuppVsAttrModel = $SuppVsAttrModel->where('supp_users_self.is_state',$is_state);
    $SuppVsAttrModel = $SuppVsAttrModel->leftjoin('supp_users_self','supp_users_self.user_id','supp_vs_attr.user_id');
    if (!$last_user) {
        $SuppVsAttrModel = $SuppVsAttrModel->whereIn('supp_users_self.user_id',$user_ids);
    }
     $offer = PlateAttrValueModel::where('id',$offer)
                                    ->value('attr_value');

    if (strpos($offer, '以上')) {
        $SuppVsAttrModel = $SuppVsAttrModel->where(DB::raw("supp_users_self.proxy_price * $rebate_percent"),'>',preg_replace('/\D/s', '', $offer));
        
    }else if (strpos($offer, '以下')) {
        $SuppVsAttrModel = $SuppVsAttrModel->where(DB::raw("supp_users_self.proxy_price * $rebate_percent"),'<',preg_replace('/\D/s', '', $offer));
    }else{
        $offer = rtrim($offer, "元");
        $offer = explode("-", $offer);

        $SuppVsAttrModel = $SuppVsAttrModel->whereBetween(DB::raw("supp_users_self.proxy_price * $rebate_percent"),[$offer[0],$offer[1]]);
    }

    $user_ids = $SuppVsAttrModel->distinct()->pluck('supp_users_self.user_id')
                                 ->toArray();
                                 // echo 88;
                                 // echo 888;
     // dd(\DB::getQueryLog());
    return $user_ids;
}

/**
 * 获取营销列表要展示的属性数组
 * @param  [type]  $attr_id_one     二级栏目id
 * @return [type]            [description]
 */
function getSaleShowAttributeStatus($attr_id_one) {
    // 新闻约稿
    $status[1] = [1=>'web_type',2=>'channel_type',3=>'channel_level',7=>'included_reference',6=>'text_link'];
    // 视频营销
    $status[10] = [9=>'platform_type',10=>'video_type',12=>'fans',13=>'sex_type'];
    // 论坛营销
    $status[17] = [15=>'publish_type',18=>'channel_type',16=>'appoint_type'];
    // 微博营销
    $status[25] = [23=>'publish_type',27=>'fans'];
    // 问答营销
    // $status[33] = [15,18,16];
    // 微信营销
    $status[36] = [30=>'platform_type',31=>'publish_type',35=>'fans',34=>'appoint_type'];

    return $status[$attr_id_one];
}

/**
 * 检查主订单下子订单的状态 进行更新
 * @param  [type] $orderSn [description]
 * @return [type]          [description]
 */
function updateOrderStatus($orderSn) {
    $OrderModel = new OrderModel();
    $OrderNetworkModel = new OrderNetworkModel();
    $order_type_complete = [0,2,3,10,13];//已完成
    $order_type_refuse = [2];//拒单
    $order_type_loss = [3];//流单
    $order_type_appeal = [9];//申诉
    $order_type_cancel = [0];//取消
    $order_type_reserve = [1];//预约

    $order = $OrderModel::where('order_sn',$orderSn)->first();

    $order_count_all = $OrderNetworkModel->where('order_sn',$orderSn)->count();
    $order_count_refuse = $OrderNetworkModel->where('order_sn',$orderSn)->whereIn('order_type',$order_type_refuse)->count();
    if ($order_count_all == $order_count_refuse) {
            $order->order_type = 2;
            return $order->save();
    }
    $order_count_loss = $OrderNetworkModel->where('order_sn',$orderSn)->whereIn('order_type',$order_type_loss)->count();
    if ($order_count_all == $order_count_loss) {
            $order->order_type = 3;
            return $order->save();
    }
    $order_count_appeal = $OrderNetworkModel->where('order_sn',$orderSn)->whereIn('order_type',$order_type_appeal)->count();
    if ($order_count_all == $order_count_appeal) {
            $order->order_type = 6;
            return $order->save();
    }
    $order_count_cancel = $OrderNetworkModel->where('order_sn',$orderSn)->whereIn('order_type',$order_type_cancel)->count();
    if ($order_count_all == $order_count_cancel) {
            $order->order_type = 0;
            return $order->save();
    }
    $order_count_reserve = $OrderNetworkModel->where('order_sn',$orderSn)->whereIn('order_type',$order_type_reserve)->count();
    if ($order_count_all == $order_count_reserve) {
            $order->order_type = 1;
            return $order->save();
    }

    $order_count_complete = $OrderNetworkModel->where('order_sn',$orderSn)->whereIn('order_type',$order_type_complete)->count();

    if ($order_count_all == $order_count_complete) {
            $order->order_type = 5;
            return $order->save();
    }
    // DB::enableQueryLog();
    $order->order_type = 4;
    $order->save();
        // dd(DB::getQueryLog());
}

/*
订单通知
*/
function SendOrderNotic($order_id,$user_id,$content,$remark)
{
    $NoticeModel = new NoticeModel();
    $NoticeModel->order_id = $order_id;
    $NoticeModel->user_id = $user_id;
    $NoticeModel->content = $content;
    $NoticeModel->remark = $remark;
    $id = $NoticeModel->save();
    if ($id) {
        return ['status'=>1,'msg'=>'成功','data'=>[]];
    }else{
        return ['status'=>2,'msg'=>'失败','data'=>[]];
    }
}

/**
 * 正则校验手机号
 * @param  [type] $phone [description]
 * @return [type]        [description]
 */
function preg_phone_reg($phone)
{
    // 支持虚拟号码
    $reg_res = preg_match_all('/^((13[0-9])|(15[^4])|(14[57])|(17[0678])|(18[0,0-9]))\\d{8}$/',$phone);
    return $reg_res;
    // /\d{7,8}|\d{3}-\d{8}|\d{4}-\d{7,8}/
}

/**
 * 获取我的下级会员数
 * @return [type] [description]
 */
function getMychildUserCount()
{
    return AdUsersModel::where("parent_id",Auth::user()->id)->count();
}

/**
 * 获取我的用户金额
 * @return [type] [description]
 */
function getMyUserMoney()
{
    if (Auth::user()->user_type == 2) {
        return AdUsersModel::where('user_id',Auth::user()->id)->value('user_money');
    } elseif (Auth::user()->user_type == 3) {
        return SuppUsersModel::where('user_id',Auth::user()->id)->value('user_money');
    }
    return 0;
}

function getTimeInterval($type = 'now_week')
{
    if ($type == 'now_week') {
        //获取这周的起始时间
        $date = date('Y-m-d');
        $first = 1;
        $w = date('w',strtotime($date));
        $now_start = date('Y-m-d',strtotime("$date -".($w ? $w - $first : 6).' days'));
        $now_end = date('Y-m-d',strtotime("$now_start +6 days"));  //本周结束日期
    }
    return [$now_start." 00:00:00", $now_end.' 23:59:59'];
}

/**
 * 获取订单统计 顶级分类
 * @return [type] [description]
 */
function getOrderCount($user_id, $user_type, $timeInterval = null)
{
    $lists = OrderNetworkModel::leftJoin('order','order.order_sn','=','order_network.order_sn')
                                ->leftJoin("plate",'plate.id','=','order.type_id');
    if ($user_type == 2) { //广告主
        $lists = $lists->where('order.ads_user_id',$user_id);
    } elseif ($user_type == 3) {
        $lists = $lists->where('order_network.supp_user_id',$user_id);
    }
    if (!empty($timeInterval)) {
        $lists = $lists->whereBetween('order.created_at',$timeInterval);
    }

    $lists = $lists->groupBy('plate.pid')
                ->select(DB::raw("count(order_network.id) as order_count"),'plate.plate_name','plate.pid')
                ->get() 
                ->toArray();

    $plate = PlateModel::where("pid",0)->get()->toArray();

    $plate_data = [];
    foreach ($plate as $key => $value) {
    $plate_data[$value['id']] = ['order_count' => 0, 'plate_name' => $value['plate_name']];
    }

    foreach ($lists as $key => $value) {
        $plate_data[$value['pid']]['order_count'] += $value['order_count'];
    }

    return $plate_data;
}

/**
 * 所消费的金额
 * @param  [type] $user_id [description]
 * @return [type]          [description]
 */
function getUsedMoney($user_id)
{
    $used_money = OrderNetworkModel::leftJoin("order",'order.order_sn','=','order_network.order_sn')
                                            ->where('order.ads_user_id',$user_id)
                                            ->select(DB::raw("sum(order_network.user_money) as user_money"),
                                                     DB::raw("sum(order_network.qa_change) as qa_change"))
                                            ->first()
                                            ->toArray();

    return $used_money['user_money'] - $used_money['qa_change'];
}

/**
 * 获取财务日志表的统计
 * @param  [type] $user_id  [description]
 * @param  [type] $pay_type 1充值2消费3提现4收入
 * @return [type]           [description]
 */
function getAccountCount($user_id, $pay_type)
{
    return UserAccountLogModel::where('user_id',$user_id)->where('account_type',$pay_type)->sum('user_money');
}

/**
 * 广告主的订单列表
 * @return [type] [description]
 */
function getAdsUserOrderList($user_id, $where = [])
{
    $lists = OrderNetworkModel::leftJoin('order','order.order_sn','order_network.order_sn');
    if (!empty($where['start'])) {
        $lists = $lists->where('order.start_at','>=',$where['start']);
    }
    if (!empty($where['end'])) {
        $lists = $lists->where('order.over_at','<=',$where['end']);
    }
    if (!empty($where['mediatype'])) {
        $pid = $where['mediatype'];
        $lists = $lists->whereIn('order.type_id',function($query)use($pid){
                                    $query->from('plate')->where('pid',$pid)->select('id');
                                  });
    }
    if (!empty($where['orderid'])) {
        $lists = $lists->where('order_network.id','=',$where['orderid']);
    }

    $lists = $lists->where('order_network.ads_user_id',$user_id)
                ->select('order_network.id',
                         'order_network.type_name',
                         'order.title',
                         'order.start_at',
                         'order.over_at',
                         'order_network.user_money',
                         'order_network.commission',
                         'order_network.order_type',
                         'order_network.success_url',
                         'order_network.success_pic',
                         'order_network.supp_status',
                         'deal_with_status')
                ->get()
                ->toArray();
    $data = [];
    foreach ($lists as $key => $value) {
        $tip = "";
        if ($value['order_type'] == 13) {
            if ($value['deal_with_status'] == 3) {
                $tip = ',不同意退款';
            } elseif ($value['deal_with_status'] == 1) {
                $tip = ',退款成功';
            }
        }
        $data[] = [
            'order_id' => $value['id'],
            'title' => $value['title'],
            'type_name' => $value['type_name'],
            'start_at' => $value['start_at'],
            'over_at' => $value['over_at'],
            'user_money' => $value['user_money'],
            'commission' => $value['commission'],
            'order_type' => getOrderType($value['order_type']).$tip,
            'success_pic' => $value['success_pic'],
            'success_url' => $value['success_url'],
        ];
    }
    return $data;
}

function getExcel($title, $tab_title, $cell_data) {
    \Excel::create($title,function($excel) use ($cell_data, $tab_title){
        $excel->sheet($tab_title, function($sheet) use ($cell_data){
            $sheet->rows($cell_data);
        });
    })->export('xls');
}

/**
 * 支付方式
 * @param  [type] $type [description]
 * @return [type]       [description]
 */
function getPayType($type) {
    $pay_list = \Config::get('paylist');
    return $pay_list[$type];
}

function getSuppUserType($type) {
    $state_type = [1 => '在线', 2 => '下架', 3 => '审核'];
    return $state_type[$type];
}

function getCashStatus($type) {
    $withdraw_status = [1 => '已到账', 0 => '未到账', 2 => '失败'];
    return $withdraw_status[$type];
}

function suppWithdrawStatus($type) {
    $withdraw_status = [1 => '成功', 0 => '提现中', 2 => '失败'];
    return $withdraw_status[$type];
}

function getAppealStatus($type) {
    $status = [1 => '完成', 0 => '申诉中'];
    return $status[$type];
}

function getQaStatus($type) {
    $qa_status = \Config::get('qa-desc');
    if (empty($qa_status[$type]))
        return '/';//还未评定质量反馈
    return $qa_status[$type];
}

/**
 * 获取小数
 */
if ( ! function_exists('get_demical') )
{
    function get_demical($num)
    {
        $num_arr = explode('.',$num);
        if (array_key_exists('1',$num_arr)) {
           $decimal = substr($num_arr['1'],0,2);
        }else{
            $decimal = '0';
        }
        return sprintf('%.2f',$num_arr['0'].'.'.$decimal);
    }
}

function getCommission($supp_user_id)
{
    $info = SuppUsersSelfModel::where('user_id',$supp_user_id)
                     ->select('plate_price','vip_price')
                     ->first();
    return $info->plate_price - $info->vip_price;
}
function getSearchMediaSelect()
{
    return PlateModel::leftJoin('plate as child','child.pid','=','plate.id')
                ->where('plate.pid',0)
                ->select('plate.id','plate.pid','plate.plate_name',DB::raw("group_concat(child.id) as value"))
                ->get()
                ->toArray();
}

function getSearchMedia()
{
    // dd(PlateModel::with('')->leftJoin('plate as child','child.pid','=','plate.id')
    //             ->where('plate.pid',0)
    //             ->select('plate.id','plate.pid','plate.plate_name',DB::raw("group_concat(child.id) as value"))
    //             ->get()
    //             ->toArray());
}

// 查询账户列表
function accountQuery($request,$type=0,$user_id)
{
    \DB::enableQueryLog();
    // 初始化
    $paylist = \Config::get('paylist');
    $recharge_consume = [
        0=>'未完成',
        1=>'完成',
        2=>'失败'
    ];

    $select = ['user_account_log.*',
                 'order.title',
                 'order_network.supp_money',
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

    if ($type == 0 || $type == 2 || $type == 3 || $type == 4) {
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
        $order_list = $order_list->where('user_account_log.order_id',$request->input('keyword'));
    }
    if ($request->input('start')) {
        $order_list = $order_list->where('user_account_log.created_at','>=',$request->input('start'));
    }

    if ($request->input('end')) {
        $order_list = $order_list->where('user_account_log.created_at','<=',$request->input('end'));
    }
    $order_list = $order_list->where('user_account_log.user_id',$user_id)
                ->select($select)
                ->get()
                ->toArray();
    // 遍历处理数据格式
    foreach ($order_list as $key => $value) {
        $order_list[$key]['order_type'] = $value['desc'];
        $order_list[$key]['order_title'] = $value['desc'];
        $order_list[$key]['pay_type'] = $paylist[$value['pay_type']];
        $order_list[$key]['order_status'] = $recharge_consume[$value['status']];
    }
    return $order_list;
    return ['status_code' => 200, 'data' => $order_list, 'msg' => '成功'];
}


/**
 * 获取规格相同的用户id或媒体列表
 * @param  $init_uid     
 * @param  $exclude_type all是自营+第三方，supp第三方，self是自营
 * @param  $search       查找
 * @param  $getMes       all是列表、uid是用户id组，success_order
 * @param  $exclude_uid  排除的UID
 * @return [type]                [description]
 */
function getSameSpecUid($init_uid, $exclude_type='all', $search, $getMes='all', $exclude_uid=0)
{
    $users = User::where('id', $init_uid)->first();
    // 获取当前用户的媒体分类、媒体类型
    if ($users->user_type == 4) {
        $supp_info = SuppUsersSelfModel::where('user_id', $init_uid)->first();
    } else {
        $supp_info = SuppUsersModel::where('user_id', $init_uid)->first();
    }
    $plate_tid = $supp_info->plate_tid;
    $plate_id = $supp_info->plate_id;
    $keyword = $search->keyword; // 搜索关键词

    $attr_value_id = SuppVsAttrModel::where('user_id', $init_uid)
                                 ->pluck('attr_value_id')
                                 ->toArray();

    $attr_count = count($attr_value_id);
    $users_ids_supp = $users_ids_self = [];
    if ($exclude_type == 'all' || $exclude_type == 'supp') {
        $users_ids_supp = SuppUsersModel::where('plate_tid', $plate_tid);
        if (!empty($keyword)) 
            $users_ids_supp = $users_ids_supp->where('media_name', 'like', '%'.$keyword.'%');
            $users_ids_supp = $users_ids_supp->where('plate_id', $plate_id)
                ->where('parent_id', '<>', 0)
                ->select('user_id')
                ->get()
                ->toArray();
    }
    if ($exclude_type == 'all' || $exclude_type == 'self') {
        $users_ids_self = SuppUsersSelfModel::where('plate_tid', $plate_tid);
        if (!empty($keyword))
            $users_ids_self = $users_ids_self->where('media_name', 'like', '%'.$keyword.'%');
            $users_ids_self = $users_ids_self->where('plate_id', $plate_id)
                    ->select('user_id')
                    ->get()
                    ->toArray();
    }
    if ($exclude_type == 'success_order') {
        $users_ids_self = SuppUsersModel::where('plate_tid', $plate_tid)
                    ->where('plate_id', $plate_id)
                    ->where('success_order',1)
                    ->select('user_id')
                    ->get()
                    ->toArray();

    }
    $user_ids = array_merge($users_ids_supp, $users_ids_self);
    // 获取规格完全相同的uid
    $user_ids = SuppVsAttrModel::whereIn('user_id', $user_ids)
                     ->whereIn('attr_value_id', $attr_value_id);

    if ($supp_info->success_order != 1 && $exclude_uid) {
        $user_ids = $user_ids->where('user_id','<>',$supp_info->user_id);
    }
    if (!empty($search->start)) {
        $user_ids = $user_ids->where('created_at', '>=', $search->start." 00:00:00");
    }
    if (!empty($search->end)) {
        $user_ids = $user_ids->where('created_at', '<=', $search->end." 23:59:59");
    }
    $user_ids = $user_ids
                    ->groupBy('user_id')
                    ->havingRaw("count(user_id) = $attr_count")
                    ->pluck('user_id')
                    ->toArray();
    if (!$user_ids) {
        return ['status_code' => 201, 'msg' => '没有同类'];
    }
    if ($getMes == 'uid') {
        return ['status_code' => 200, 'data' => $user_ids];
    }
    $lists_supp = SuppUsersModel::with(['plate','childPlate','parentUser'])
                    ->whereIn('user_id', $user_ids)
                    ->get()
                    ->toArray();
    $lists_self = SuppUsersSelfModel::with(['plate','childPlate','parentUser'])
                ->whereIn('user_id', $user_ids)
                ->get()
                ->toArray();
    return ['status_code' => 200, 'data' => array_merge($lists_self, $lists_supp)];
}

/**
 * 对比规格是否一致
 * @param   $supp_uid 
 * @param   $plate_tid
 * @param   $plate_id 
 * @param   $self_uid 
 * @return            
 */
function checkSpecSame($supp_uid, $plate_tid, $plate_id, $self_uid)
{
    $supp = SuppUsersModel::where('user_id', $supp_uid)
                            ->where('plate_tid', $plate_tid)
                            ->where('plate_id', $plate_id)
                            ->first();
    if (!$supp) {
        return false;
    }

    $attr_value_id = SuppVsAttrModel::where('user_id', $self_uid)
                             ->pluck('attr_value_id')
                             ->toArray();

    $attr_count = count($attr_value_id);
    $user_ids = SuppVsAttrModel::where('user_id', $supp_uid)
                 ->whereIn('attr_value_id', $attr_value_id)
                 ->groupBy('user_id')
                 ->havingRaw("count(user_id) = $attr_count")
                 ->pluck('user_id')
                 ->toArray();
    if (!empty($user_ids))
        return true;
    else 
        return false;
}
