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
use App\Model\OrderModel;
use App\Model\OrderNetworkModel;
use App\Model\PlateModel;
use App\Model\NoticeModel;
use App\User;
use App\Model\ArticleModel;
use Auth;
use Cache;
use DB;
use Session;
use Mail;

class UserpersonalController extends CommonController
{
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->request = $request;
    }

    public function vipNotice(Request $request){
        $info = NoticeModel::where('user_id', Auth::user()->id)->where('type', 2)->first();
        if (!$info) {
            return back()->with('status', '错误请求');
        }
        $info->is_read = 1;
        $info->save();
        $notice_date = $info['created_at'];
        $info = ArticleModel::where('id', 26)->first();
        
        return view('console.supp.vip_notice', ['info' => $info, 'notice_date' => $notice_date]);
    }

    /*
    *用户修改资料
    */
    public function person_edit(Request $request)
    {
        $adminUid = Auth::user()->id;
        $user = AdUsersModel::where('ad_users.user_id',$adminUid)
                            ->join('users','ad_users.user_id','=','users.id')
                            ->first();
        $user_array = $user->toArray();
        // print_r(session('user'));die();
        $user_array['name'] = session('user')['name'];
        if ($_POST) {
            $data = $request->all();
            $mobile = isset($data['mobile'])?$data['mobile']:'';
            $email = isset($data['email'])?$data['email']:'';
            $head_pic = $data['head_pic_old'];
            if (isset($data['head_pic'])) {
                // $input = Input::except('_token','head_pic');
                $path = 'uploads/images/head_pic/'.$adminUid;
                $res = $this->uploadpic('head_pic',$path);
                switch ($res){
                    case 1: return redirect('/userpersonal/person_edit')->withInput()->with('status', '图片上传失败');
                    case 2: return redirect('/userpersonal/person_edit')->withInput()->with('status', '图片不合法');
                    case 3: return redirect('/userpersonal/person_edit')->withInput()->with('status', '图片后缀不对');
                    case 4: return redirect('/userpersonal/person_edit')->withInput()->with('status', '图片储存失败');
                    default :
                    $head_pic = '/'.$res;
                }
            }
            $user =  AdUsersModel::where('user_id',$adminUid)->first();
            // $user->head_pic = $head_pic;
            $user->nickname = $data['nickname'];
            $user->company = $data['company'];
            $user->breif = $data['breif'];//;
            $user->contact = $data['contact'];
            $user->qq = $data['qq'];
            if ($mobile) {
                $user->mobile = $data['mobile'];
            }
            if ($email) {
                $user->email = $data['email'];
            }
            $user->address = $data['address'];
            $user->save();
            $users_id = $user->id;

            $user_d = UsersModel::where('id',$adminUid)->first();
            $user_d->head_pic = $head_pic;
            $user_d->save();
            $session_user = getUserInfo($adminUid);
            session(['user'=>$session_user]);
              
            if ($users_id) {
                return redirect('/userpersonal/person_edit')->withInput()->with('status', '操作成功');
                // return json_encode(['status' => "1", 'msg' => '操作成功', 'data' => $ad_users_id], JSON_UNESCAPED_UNICODE);
            }else {
                return redirect('/userpersonal/person_edit')->withInput()->with('status', '操作失败');
                // return json_encode(['msg' => "请求错误，请刷新页面重试", 'status' => "2", 'data' => '']);
            }

        }

        return view('console.userpersonal.person_edit',['user'=>$user_array,'active'=>'person_edit']);
    }

    /**
     * 用户安全中心
     * @return [type] [description]
     */
    public function person_safe()
    {
        $user_id = Auth::user()->id;
        $user_type = Auth::user()->user_type;
        $danger_percent = 0;
        $safe_percent = 100;
        $safe_type = '';
        if ($user_type == 2) {
            $user = AdUsersModel::where('ad_users.user_id',$user_id)
                            ->join('users','ad_users.user_id','=','users.id')
                            ->join('user_level','ad_users.level_id','=','user_level.id')
                            ->first();
        } else if ($user_type == 3) {
            $user = SuppUsersModel::where('supp_users.user_id',$user_id)
                        ->join("users",'supp_users.user_id','=','users.id')
                        ->first();
        }
        $user = $user->toArray();

        if (!$user['mobile']) {
            $danger_percent+=20;
        }

        if (!$user['email']) {
            $danger_percent+=20;
        }

        if (!$user['security_status']) {
            $danger_percent+=20;
        }

        if (!$user['certificate_status']) {
            $danger_percent+=20;
        }

        if (!$user['pw_status']) {
            $danger_percent+=20;
        }

        $safe_percent-=$danger_percent;

        if ($safe_percent>60) {
            $safe_type = '高';
        }else if($safe_percent<61 && $safe_percent>30){
            $safe_type = '中';
        }else{
            $safe_type = '低';
        }

        return view('console.userpersonal.person_safe',
                ['user' => $user,
                 'safe_type' => $safe_type,
                 'danger_percent' => $danger_percent,
                 'active' => 'person_edit']);
    }

    /*
    *用户修改密码
    */
    public function person_safe_changepass()
    {
        $user = $this->getUser();
        if (Auth::user()->user_type == 2) {
            $active = 'person_edit';
        } else {
            $active = 'person_safe';
        }
        return view('console.userpersonal.person_safe_changepass',['user'=>$user,'active'=> $active]);
    }


    /*
    *用户修改密码
    */
    public function person_safe_editpass(Request $request)
    {
        $user_id = Auth::user()->id;

        $data = $request->all();

        $sms_detail_object = UsersModel::where('id',$user_id)->first();

        $sms_detail_object_array = $sms_detail_object->toArray();

        if (!\Hash::check($data['user_password_old'], $sms_detail_object_array['password'])) {

            return json_encode(['msg' => "原密码不正确", 'status' => "2", 'data' => '']);
        }



        if ($data['user_password_new']!=$data['user_password_new_confirmation']) {
            
            return json_encode(['msg' => "两次密码不一致", 'status' => "2", 'data' => '']);
        }


        $sms_detail_object->password = bcrypt($data['user_password_new']);
       
        $sms_detail_object->save();
        $users_id = $sms_detail_object->id;

        if ($users_id) {
                return json_encode(['status' => "1", 'msg' => '操作成功', 'data' => ''], JSON_UNESCAPED_UNICODE);
            }

    }

    /*
    *用户绑定手机号
    */
    public function person_safe_phone()
    {
        $user = $this->getUser();
        if (Auth::user()->user_type == 2) {
            $active = 'person_edit';
        } else {
            $active = 'person_safe';
        }
        return view('console.userpersonal.person_safe_phone',['user'=>$user,'active'=> $active]);
    }


    /**
     * @param Request $request
     * @return mixed
     * user_SMS
     * 获取手机号码。手机验证码，判断时间，判断验证码,密码
     * data['mobile_number']=$('#mobile_number').val();
     * data['password']=$('#user_password').val();
     * data['user_code']=$('#user_code').val();
     * data['confirm']=$('#confirm').val();
     */
    public function post_safe_phone(Request $request)
    {
        $data = $request->all();
        $user_SMS = session('SMS_CODE_SAFE');

        if ($user_SMS && $data) {
            $this_time = $user_SMS['this_time'];
            if ($data['user_code'] == $user_SMS['code']) {
                //验证码5分钟内有效
                $endtime = $this_time + 60000;
                $this_time = time();
                $second = $endtime - $this_time;
                //当前时间是否大于发送时间+时间限制 在限制时间内，当前时间小于发送时间+限制
                if ($second<0) {
                    return json_encode(['status' => "2", 'msg' => '验证码已失效，请重新申请', 'data' => ""], JSON_UNESCAPED_UNICODE);
                }

                if ($data['phone'] != $user_SMS['phone']) {
                    return json_encode(['msg' => "验证手机号不一致！", 'status' => "2", 'data' => ''], JSON_UNESCAPED_UNICODE);
                }



                $user_id = Auth::user()->id;
                if (Auth::user()->user_type == 2) {
                    $user = AdUsersModel::where('user_id',$user_id)->first();
                } elseif (Auth::user()->user_type == 3) {
                    $user = SuppUsersModel::where('user_id', $user_id)->first();
                }
                

                $user->mobile = $data['phone'];
                $user->save();
                $data = $user->id;

                if ($data) {
                    session(['SMS_CODE_SAFE'=>'']);
                    return json_encode(['status' => "1", 'msg' => '操作成功', 'data' => $data], JSON_UNESCAPED_UNICODE);
                }
            } else {
                return json_encode(['msg' => "验证码错误", 'status' => "2", 'data' => '']);
            }
        }
        return json_encode(['status' => "2", 'msg' => '请求错误，请刷新页面重试', 'data' => ''], JSON_UNESCAPED_UNICODE);

    }

    /*
    *用户绑定电子邮箱
    */
    public function person_safe_email()
    {
        $user = $this->getUser();
        if (Auth::user()->user_type == 2) {
            $active = 'person_edit';
        } else {
            $active = 'person_safe';
        }
        return view('console.userpersonal.person_safe_email',['user'=>$user,'active'=> $active]);
    }

    /*
    *用户绑定电子邮箱ajax
    */
    public function post_safe_email(Request $request)
    {
        $data = $request->all();
        $user_SMS = session('SMS_CODE_SAFE_EMAIL');

        if ($user_SMS && $data) {
            $this_time = $user_SMS['this_time'];
            if ($data['user_code'] == $user_SMS['code']) {
                //验证码5分钟内有效
                $endtime = $this_time + 60000;
                $this_time = time();
                $second = $endtime - $this_time;
                //当前时间是否大于发送时间+时间限制 在限制时间内，当前时间小于发送时间+限制
                if ($second<0) {
                    return json_encode(['status' => "2", 'msg' => '验证码已失效，请重新申请', 'data' => ""], JSON_UNESCAPED_UNICODE);
                }

                if ($data['email'] != $user_SMS['email']) {
                    return json_encode(['msg' => "验证邮箱不一致！", 'status' => "2", 'data' => ''], JSON_UNESCAPED_UNICODE);
                }

                $user_id = Auth::user()->id;

                if (Auth::user()->user_type == 2) { //检查用户类型
                    $user = AdUsersModel::where('user_id',$user_id)->first();
                } else {
                    $user = SuppUsersModel::where('user_id',$user_id)->first();
                }
                $user->email = $data['email'];
                if ($data['n_email'] && $data['email']) { //属于重新绑定邮箱
                    $user->email = $data['n_email'];
                }
                $user->save();
                $data = $user->id;
                if ($data) {
                    session(['SMS_CODE_SAFE'=>'']);
                    return json_encode(['status' => "1", 'msg' => '操作成功', 'data' => $data], JSON_UNESCAPED_UNICODE);
                }
            } else {
                return json_encode(['msg' => "验证码错误", 'status' => "2", 'data' => '']);
            }
        }
        return json_encode(['status' => "2", 'msg' => '请求错误，请刷新页面重试', 'data' => ''], JSON_UNESCAPED_UNICODE);

    }

    /**
     * 用户修改密保
     * @return [type] [description]
     */
    public function person_safe_question()
    {
        $user = $this->getUser();
        if (Auth::user()->user_type == 2) {
            $active = 'person_edit';
        } else {
            $active = 'person_safe';
        }

        $security_status = 0;
        $security_answer = [];
        $security_question_cat = SecurityQuestionCatModel::where('is_show',1)
                                    ->orderBy('id','desc')
                                    ->orderBy('sort','desc')
                                    ->get()
                                    ->toArray();

        $security_question = SecurityQuestionModel::where('is_show',1)
                                    ->orderBy('id','desc')
                                    ->orderBy('sort','desc')
                                    ->get()
                                    ->toArray();

        if ($user['security_status']) {
            $security_status = 1;
            $security_answer = SecurityAnswerModel::where('user_id',$user['user_id'])
                                            ->orderBy('id','desc')
                                            ->orderBy('sort','desc')
                                            ->get()
                                            ->toArray();
        }

        foreach ($security_question_cat as $k => $v) {
            foreach ($security_question as $key => $value) {
                if ($value['cat_id'] == $v['id']) {
                    $security_question_cat[$k]['question'][] = $value;

                    if ($security_status) {
                        foreach ($security_answer as $ka => $va) {
                            if ($va['question_id'] == $value['id']) {
                                $security_question_cat[$k]['answer'] = $value['id'];
                            }
                        }
                    }

                }
            }

        }
        return view('console.userpersonal.person_safe_question',
            ['security_question_cat' => $security_question_cat,
             'user' => $user,
             'security_status' => $security_status,
             'security_answer' => $security_answer,
             'active' => $active]);
    }

    /*
    *用户修改密保post
    */
    public function post_safe_question(Request $request)
    {
        $user = $this->getUser();
        $data = $request->all();
        $answer = [];
        $question_array = $data['question'];
        $answer_array = $data['answer'];

        foreach ($question_array as $key => $value) {
            $answer[$key]['user_id'] =  $user['user_id'];
            $answer[$key]['question_id'] =  $value[0];
            $answer[$key]['name'] =  '';
        }
        foreach ($answer_array as $key => $value) {
            if (trim($value[0],' ') == '') {
                return ['status'=>2,'msg'=>'密保回答不能为空'];
            }
            $answer[$key]['name'] = trim($value[0],' ');
            $answer[$key]['created_at'] = date("Y-m-d H:i:s",time());
            $answer[$key]['updated_at'] = date("Y-m-d H:i:s",time());
        }


        SecurityAnswerModel::where('user_id',$user['user_id'])->delete();

        $status = SecurityAnswerModel::insert($answer);
        if ($status) {
            if (Auth::user()->user_type == 2) {
                AdUsersModel::where('user_id', $user['user_id'])->update(['security_status'=>1]);
            } elseif (Auth::user()->user_type == 3) {
                SuppUsersModel::where('user_id',$user['user_id'])->update(['security_status'=>1]);
            }
            
            return ['status'=>1,'msg'=>'操作成功'];
        }

    }



    /*
    *用户修改密保post
    */
    public function post_safe_question_select(Request $request)
    {
        $user = $this->getUser();
        $data = $request->all();
       
        $answer = [];
        // print_r($data);die();
        $question_array = $data['question'];
        $answer_array = $data['answer'];
        $status = 1;

        foreach ($question_array as $key => $value) {
            $answer[$key]['user_id'] =  $user['user_id'];
            $answer[$key]['question_id'] =  $value[0];
            $answer[$key]['name'] =  '';
        }
        foreach ($answer_array as $key => $value) {
            if (trim($value[0],' ') == '') {
                return ['status'=>2,'msg'=>'密保回答不能为空'];
            }
            $answer[$key]['name'] = trim($value[0],' ');
        }

        foreach ($answer as $key => $value) {
            $count = DB::table('security_answer')->where('user_id',$user['user_id'])->where('question_id',$value['question_id'])->where('name',$value['name'])->count();
            if (!$count) {
                return ['status'=>2,'msg'=>'密保回答错误'];
            }
        }

        // SecurityAnswerModel::where('user_id',$user['user_id'])->delete();
        AdUsersModel::where('user_id', $user['user_id'])->update(['security_status'=>0]);
        return ['status'=>1,'msg'=>'操作成功'];
        

    }

    /*
    *用户绑定证件信息
    */
    public function person_safe_certificate(Request $request)
    {
        $user = $this->getUser();
        $certificate = [];
        $certificate_list = CertificateCatModel::where('is_show',1)
                                ->orderBy('id','desc')
                                ->orderBy('sort','desc')
                                ->get();
        if ($user['certificate_status']) {
            $certificate = UserCertificatePicModel::where('user_id',$user['user_id'])->first()->toArray();
        }
        if ($_POST) {
            $data = $request->all();
            $certificate_pic = $data['input_file'];
            $certificate_id = $data['certificate_id'];
            if (!$certificate_pic) {
                return redirect('/userpersonal/person_safe_certificate')->withInput()->with('status', '请上传图片');
            }

            if (!$certificate_id) {
                return redirect('/userpersonal/person_safe_certificate')->withInput()->with('status', '请选择证件类型');
            }

            if ($data['input_file']) {
                // $input = Input::except('_token','head_pic');
                $path = 'uploads/images/certificate_pic/'.$user['user_id'];
                $res = $this->uploadpic('input_file',$path);
                switch ($res){
                    case 1: return redirect('/userpersonal/person_safe_certificate')->withInput()->with('status', '图片上传失败');
                    case 2: return redirect('/userpersonal/person_safe_certificate')->withInput()->with('status', '图片不合法');
                    case 3: return redirect('/userpersonal/person_safe_certificate')->withInput()->with('status', '图片后缀不对');
                    case 4: return redirect('/userpersonal/person_safe_certificate')->withInput()->with('status', '图片储存失败');
                    default :
                    $certificate_pic = '/'.$res;
                }
            }

            $UserCertificatePic = new UserCertificatePicModel();

            $UserCertificatePic::where('user_id',$user['user_id'])->delete();

            $UserCertificatePic->user_id = $user['user_id'];
            $UserCertificatePic->certificate_id = $data['certificate_id'];
            $UserCertificatePic->certificate_pic = $certificate_pic;
            $UserCertificatePic->save();
            $UserCertificatePic_id = $UserCertificatePic->id;
              
            if ($UserCertificatePic_id) {
                if (Auth::user()->user_type == 2) {
                    AdUsersModel::where('user_id', $user['user_id'])->update(['certificate_status'=>1]);
                } else {
                    SuppUsersModel::where('user_id', $user['user_id'])->update(['certificate_status'=>1]);
                }
                session('user')['certificate_status'] = 1;
                return redirect('/userpersonal/person_safe')->withInput()->with('status', '操作成功');
            }else {
                return redirect('/userpersonal/person_safe_certificate')->withInput()->with('status', '操作失败');
            }

        }

        return view('console.userpersonal.person_safe_certificate',['user'=>$user,'certificate_list'=>$certificate_list,'certificate'=>$certificate,'active'=> Auth::user()->user_type == 2 ? 'person_edit' : 'person_safe']);
    }

    /**
     * 点击发送邮件
     * @return
     */
    public function sendSmtp(Request $request)
    {
        $email =$request->input('email');
        // $phone = '13415217573';
        if ( !$email ) {
            return ['status'=>2,'msg'=>'电子邮箱不能为空'];
        }

        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            return ['status'=>2,'msg'=>'请输入正确的电子邮箱'];
        }

        $code = rand(1000, 9999);
        $msg = '您的验证码为'.$code.',感谢您的支持!';
        // $result = send_email($email,'验证码',$msg);
         $email_title = env('EMAIL_TITLE');
         Mail::send('mails.code_mail',['msg' => $msg], function($msg) use($email,$email_title) {
                  $msg->to($email)->subject($email_title);
        });
	   $SMS_CODE = [
              'code'=>$code,
             'email'=>$email,
             'this_time'=>time()
        ];
        session(['SMS_CODE_SAFE_EMAIL' => $SMS_CODE]);
        return ['status'=>1,'msg'=>'验证码已发送，请注意查收'];
    }




    /*
    *充值余额
    */
    public function onlnetop_up()
    { 
        $lists = \Config::get('recharge');

        return view('console.userpersonal.onlnetop_up',['active'=>'Onlnetop_up','lists'=>$lists]);
    }

    /*
    *账户查询
    */
    public function account_query(Request $request)
    {
        $user = $this->getUser();
        $order_res = OrderNetworkModel::where('order_network.ads_user_id','=',Auth::user()->id)
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
        $media = getSearchMediaSelect();
        $order_used_money = OrderNetworkModel::where('ads_user_id', $user['user_id'])
                                ->whereIn('order_type',[4,5,1,9,11,12,14,15])
                                ->sum('user_money');
        $ads_user_money = AdUsersModel::where('user_id', $user['user_id'])->value('user_money');
        $user_all_money = $order_used_money + $ads_user_money;
        // 支出的订单 未完成的
        $order_list = UserAccountLogModel::searchList($user['user_id'], $request,$type=0);
        // $order_list = $this->accountQuery($type=0); // 全部
        $get_money = $this->accountQuery(3); //提现
        $charge = $this->accountQuery(1); // 充值
        $used = $this->accountQuery(2); // 消费

        // dd($charge);
        //百分比
        $money_percent['user_money'] = $user['user_money'];
        // 已发布订单数
        $order_count_all = $order_count_all ? $order_count_all : 0;
        $level_id = AdUsersModel::where('user_id', $user['user_id'])->first()->level_id;
        $view = $level_id == 1 ? 'account_query' : 'vip_account_query';

        return view("console.userpersonal.$view",[
            'active'=>'account_query',
            'money_percent'=>$money_percent,
            'order_count_all' => $order_count_all,
            'media' => $media,
            'order_list' => $order_list,
            'get_money' => $get_money,
            'charge' => $charge,
            'used' => $used,
            'user_all_money' => $user_all_money,
            'ads_user_money' => $ads_user_money,
            ]);
    }

    /**
     * 账户查询 针对ajax
     * @param  [type] $type 0全部 1充值 2消费 3提现
     * @return [type]       [description]
     */
    public function accountQuery($type=0)
    {
        // 初始化
        $user_id = Auth::user()->id;
        $paylist = \Config::get('paylist');
        $recharge_consume = [
            0=>'未完成',
            1=>'完成',
            2=>'失败'
        ];

        $select = ['user_account_log.*',
                     'order_network.id as order_id',
                     'order_network.order_sn as order_order_sn',
                     'order_network.supp_user_id',
                     'order_network.order_type',
                     'order_network.type_id',
                     'order_network.type_name',
                     'order_network.success_url',
                     'order_network.success_pic'];

        $mediatype = explode(",",$this->request->input('mediatype'));
        $order_list = UserAccountLogModel::with(['order_list_recharge'])
                                ->leftJoin('order_network','order_network.order_sn','=','user_account_log.order_sn');

        if ($type == 0 || $type == 2) {
            $order_list = $order_list->leftJoin('order','order_network.order_sn','=','order.order_sn');
            array_push($select,'order.title');
        }

        if (!empty(array_filter($mediatype))) {
            $order_list = $order_list->whereIn('order_network.type_id',$mediatype);
        }

        if (!empty($type)) {
            $order_list = $order_list->where('user_account_log.account_type',$type);
        }

        if ($this->request->input('orderid')) {
            $order_list = $order_list->where('user_account_log.order_id',$this->request->input('orderid'));
        }
        if ($this->request->input('keyword')) {
            $order_list = $order_list->where('order_network.id',$this->request->input('keyword'));
        }

        if ($this->request->input('start')) {
            $order_list = $order_list->where('user_account_log.created_at','>=',$this->request->input('start'));
        }

        if ($this->request->input('end')) {
            $order_list = $order_list->where('user_account_log.created_at','<=',$this->request->input('end'));
        }
        $order_list = $order_list->where('user_account_log.user_id',$user_id)
                    ->where('user_account_log.account_type','!=',4)//退款订单不计入内
                    ->select($select)
                    ->get()
                    ->toArray();
        // 遍历处理数据格式
        foreach ($order_list as $key => $value) {
            $order_list[$key]['order_type'] = getOrderType($value['order_type']);
            $order_list[$key]['order_title'] = $value['desc'];
            $order_list[$key]['pay_type'] = $paylist[$value['pay_type']];
            $order_list[$key]['order_status'] = $recharge_consume[$value['status']];
        }
        if ($this->request->input('get_excel') == 1) {
            $this->getAccountLogExcel($type,$order_list);
        }
        return $order_list;
        return ['status_code' => 200, 'data' => $order_list, 'msg' => '成功'];
    }

    public function getAccountLogExcel($type,$data)
    {
        $title = [1 => '充值', 2 => '订单', 3 => '提现', 0 => '全部'];
        $tab = [
            0 => ['日期', '订单号', '稿件类型', '活动名称', '状态', '完成链接 / 截图', '金额'],
            1 => ['日期', '订单号', '消费方式', '消费账号', '状态', '金额'],
            2 => ['日期', '订单号', '稿件类型', '订单名称', '订单状态', '完成链接 / 截图', '金额'],
            3 => ['日期', '订单号', '消费方式', '消费账号', '状态', '金额'],
        ];
        $cell_data = [];
        foreach ($data as $key => $value) {
            if ($type == 0) {
                
            } elseif ($type == 3) {
                $cell_data[] = [
                    $value['created_at'],
                    $value['order_sn'],
                    $value['pay_type'],
                    $value['pay_user'],
                    $value['order_status'],
                    $value['user_money']
                ];
            } elseif ($type == 1) {
                $tmp = $value['status'] == 1 ? '充值成功' : '充值失败';
                $cell_data[] = [
                    $value['created_at'],
                    $value['order_sn'],
                    $value['pay_type'],
                    $value['pay_user'],
                    $tmp,
                    $value['user_money'],
                ];
            } elseif ($type == 2) {
                $cell_data[] = [
                    $value['created_at'],
                    $value['order_id'],
                    $value['type_name'],
                    $value['title'],
                    $value['order_type'],
                    $value['success_url'],
                    $value['user_money'],
                ];
            }
        }
        array_unshift($cell_data,$tab[$type]);
        getExcel($title[$type].date('Y-m-d',time()), date('Y-m-d',time()), $cell_data);
        exit();
    }

    /*
    *账户提现
    */
    public function account_enchashment()
    {
        $pay_list = \Config::get('paylist');
        unset($pay_list['laba']);
        unset($pay_list['debug']);
        $user = $this->getUser();
        return view('console.userpersonal.account_enchashment',[
            'active'=>'account_query',
            'pay_list'=>$pay_list,
            'balance'=>$user['user_money']
            ]);
    }

    public function account_enchashment_post(Request $request)
    {
        $user = $this->getUser();
        $data = $request->all();
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

        if ($balance>$user['user_money']) {
            return ['status'=>2,'msg'=>'提现金额不能大于余额','data'=>''];
        }

        if (!$pay_type) {
            return ['status'=>2,'msg'=>'请选择提现方式','data'=>''];
        }

        if (!$pay_user) {
            return ['status'=>2,'msg'=>'请填写提现账号','data'=>''];
        }

        $user_object = UsersModel::where('id',$user['user_id'])->first();

        if (!\Hash::check($password, $user_object['password'])) {

            return json_encode(['msg' => "原密码不正确", 'status' => "2", 'data' => '']);
        }

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

            $user = AdUsersModel::where('user_id',$user['user_id'])->first();
            $user->user_money = $user->user_money - $balance;
            $user->save();
            return json_encode(['msg' => "操作成功,请等待管理员审核", 'status' => "1", 'data' => '']);
        }
    }


    /**
     * 点击发送短信
     * @return
     */
    public function sendSms(Request $request)
    {
        $phone =$request->input('phone');
        // $phone = '13415217573';
        if ( !$phone ) {
            return ['status'=>2,'msg'=>'手机号不能为空'];
        }

        if(!preg_match('/1[34578]\d{9}$/',$phone)){
            return ['status'=>2,'msg'=>'请输入正确的手机号码'];
        }

        $code = rand(1000, 9999);
        $SMS_CODE = [
            'code'=>$code,
            'phone'=>$phone,
            'this_time'=>time()
                    ];
        session(['SMS_CODE_SAFE' => $SMS_CODE]);
      
        $msg = '您的验证码为'.$code.',感谢您的支持!';
        $result = sendSms($phone,$msg);
        return $result;
    }

    /*
    *高级会员增加下级会员
    */

    public function user_add(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = AdUsersModel::where('ad_users.user_id',$user_id)
                            ->join('users','ad_users.user_id','=','users.id')
                            ->first();
        $user_array = $user->toArray();
        if ($user_array['level_id'] == 1) {
            return redirect('/')->withInput()->with('status', '非法操作');
        }
        if ($_POST) {
            $data = $request->all();
            $name = isset($data['name'])?$data['name']:'';
            $password = isset($data['password'])?$data['password']:'';
            $head_pic = isset($data['head_pic_old'])?$data['head_pic_old']:'';
            $nickname = isset($data['name'])?$data['name']:'';
            $company = isset($data['company'])?$data['company']:'';
            $breif = isset($data['breif'])?$data['breif']:'';
            $contact = isset($data['contact'])?$data['contact']:'';
            $qq = isset($data['qq'])?$data['qq']:'';
            $mobile = isset($data['mobile'])?$data['mobile']:'';
            $email = isset($data['email'])?$data['email']:'';
            $address = isset($data['address'])?$data['address']:'';

            if (!$name) {
                return redirect('/userpersonal/user_add')->withInput()->with('status', '请填写用户名');
            }

            $is_user = UsersModel::where('name',$name)->count();

            if ($is_user) {
                return redirect('/userpersonal/user_add')->withInput()->with('status', '该用户名已被注册');
            }
            if ($mobile) {
                if (!preg_match("/^1[34578]{1}\d{9}$/",$mobile)) {
                    return redirect('/userpersonal/user_add')->withInput()->with('status', '手机号错误');
                }
            }

            if ($email) {
                if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                    return redirect('/userpersonal/user_add')->withInput()->with('status', '电子邮箱错误');
                }
            }
            

            if (!$password) { 
                return redirect('/userpersonal/user_add')->withInput()->with('status', '密码不能为空');
            }
            if (strlen($password)<5) {
                return redirect('/userpersonal/user_add')->withInput()->with('status', '密码必须大于6位数');
            }
            // 事务
            DB::beginTransaction();

            $UsersModel = new UsersModel(); 
            $UsersModel->name = $name;
            $UsersModel->password = bcrypt($password);
            $UsersModel->user_type = 2;
            $UsersModel->role_id = 1;
            $UsersModel->is_login = 1;
            $UsersModel->save();
            $add_user_id = $UsersModel->id;
            if (!$add_user_id) {
                return redirect('/userpersonal/user_add')->withInput()->with('status', '操作失败');
            }

            if (isset($data['head_pic'])) {
                // $input = Input::except('_token','head_pic');
                $path = 'uploads/images/head_pic/'.$add_user_id;
                $res = $this->uploadpic('head_pic',$path);
                switch ($res){
                    case 1: return redirect('/userpersonal/user_add')->withInput()->with('status', '图片上传失败');
                    case 2: return redirect('/userpersonal/user_add')->withInput()->with('status', '图片不合法');
                    case 3: return redirect('/userpersonal/user_add')->withInput()->with('status', '图片后缀不对');
                    case 4: return redirect('/userpersonal/user_add')->withInput()->with('status', '图片储存失败');
                    default :
                    $head_pic = '/'.$res;
                }
            }

            UsersModel::where('id', $add_user_id)->update(['head_pic'=>$head_pic]);

            $AdUsersModel = new AdUsersModel();

            $AdUsersModel->nickname = $nickname;
            $AdUsersModel->contact = $contact;
            $AdUsersModel->company = $company;
            $AdUsersModel->qq = $qq;
            $AdUsersModel->mobile = $mobile;
            $AdUsersModel->user_id = $add_user_id;
            $AdUsersModel->parent_id = $user_id;
            $AdUsersModel->email = $email;
            $AdUsersModel->address = $address;
            $add_adduser_id = $AdUsersModel->save();
              
            if ($add_adduser_id) {
                AdUsersModel::where('user_id',Auth::user()->id)->increment('child_user_num'); //旗下会员数
                DB::commit();
                return redirect('/userpersonal/user_manage')->withInput()->with('status', '操作成功');
                // return json_encode(['status' => "1", 'msg' => '操作成功', 'data' => $ad_users_id], JSON_UNESCAPED_UNICODE);
            }else {
                DB::rollBack();
                return redirect('/userpersonal/user_add')->withInput()->with('status', '操作失败');
                // return json_encode(['msg' => "请求错误，请刷新页面重试", 'status' => "2", 'data' => '']);
            }
        }
        return view('console.userpersonal.add_user',['user'=>$user_array,'active'=>'user_add']);
    }

    public function userManageExcel($order_list)
    {
        $cell_data[] = [
            '序号',
            '用户名',
            '订单数',
            '订单金额',
            '订单提成',
            '创建时间',
            '状态',
        ];
        foreach ($order_list as $key => $value) {
            $cell_data[] = [
                $value['user_id'],
                $value['nickname'],
                $value['parent_order_num'],
                $value['user_money_all'],
                $value['parent_order_commision'],
                $value['user_created_at'],
                $value['is_login']
            ];
        }
        getExcel('会员管理'.date('Y-m-d',time()), date('Y-m-d',time()), $cell_data);
    }

    /*
    *会员管理
    */
    public function user_manage(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = AdUsersModel::where('ad_users.user_id',$user_id)
                            ->join('users','ad_users.user_id','=','users.id')
                            ->first();
        $user_array = $user->toArray();
        if ($user_array['level_id'] == 1) {
            return redirect('/')->withInput()->with('status', '非法操作');
        }
        $order_list = AdUsersModel::childUserVsOrder($user_id,$order_type='success',$request);
        if ($request->get_excel == 1) {
            return $this->userManageExcel($order_list);
        }
        return view('console.userpersonal.user_manage',
            ['user' => $user_array, 'active'=>'user_manage', 'order_list' => $order_list]);
    }

    public function getChildUserOrdersExcel($user_name,$data)
    {
        $cell_data[] = [
            '订单号',
            '稿件名称',
            '稿件类型',
            '开始时间',
            '结束时间',
            '平台价格',
            '返利',
            '订单状态',
            '完成链接'
        ];
        foreach ($data as $key => $val) {
            $cell_data[] = [
                $val['order_id'],
                $val['title'],
                $val['type_name'],
                $val['start_at'],
                $val['over_at'],
                $val['user_money'],
                $val['commission'],
                $val['order_type'],
                $val['success_url'],
            ];
        }
        getExcel($user_name.'_订单列表'.date('Y-m-d',time()), date('Y-m-d',time()), $cell_data);
    }

    /**
     * 代理会员信息中心
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function user_subordinate($user_id,Request $request)
    {
        $user = $this->getUser();
        if ($user['level_id'] == 1) {
            return redirect('/')->withInput()->with('status', '非法操作');
        }
        $user_subordinate = AdUsersModel::with('user')
                                        ->leftJoin('users','users.id','=','ad_users.user_id')
                                        ->where('ad_users.parent_id',$user['user_id'])
                                        ->where('ad_users.user_id',$user_id)
                                        ->select('ad_users.*','users.head_pic','users.name')
                                        ->first();
        if (!$user_subordinate) {
            return redirect("/userpersonal/user_manage")->withInput()->with('status', '非法操作');
        }
        // 订单明细
        $data_lists = getAdsUserOrderList($user_id,$request->all());
        if ($request->get_excel == 1) {
            return $this->getChildUserOrdersExcel($user_subordinate['nickname'], $data_lists);
        }

        $user_subordinate = $user_subordinate->toArray();
        // 柱状图 订单统计 
        $plate_data = getOrderCount($user_id,2,getTimeInterval('now_week'));
        // 会员总金额
        $user_money = AdUsersModel::where('user_id',$user_id)->value('user_money');
        $media = PlateModel::where('pid',0)->get()->toArray();
        return view('console.userpersonal.user_subordinate',
            ['active' => 'user_manage',
             'info' => $user_subordinate,
             'plate_data' => $plate_data,
             'user_money' => $user_money,
             'data_lists' => $data_lists,
             'media' => $media,
             ]);
    }

    /**
     * ajax订单列表 TODO可能被废弃
     * @return [type] [description]
     */
    public function ajaxChildOrderList(Request $request)
    {
        $user_id = $request->input('user_id');
        $data_lists = getAdsUserOrderList($user_id,$request->all());
        return $data_lists;
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

    /**
     * 申请成为会员
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function applyVip(Request $request)
    {
        //检测当前是否为vip
        $user_info = AdUsersModel::where('user_id',Auth::user()->id)->first();
        if ($user_info->level_id == 2) {
            return ['status_code' => 201, 'msg' => '您已经是会员了奥'];
        }
        if ($user_info->check_status == 2) {
            return ['status_code' => 201, 'msg' => '尊敬的用户，您已成功提交升级高级会员的申请，我们会尽快与你联系！'];
        }
        //检测曾经充值的金额
        // $info = UserAccountLogModel::where('user_id',Auth::user()->id)
        //                     ->where('account_type',1)
        //                     ->where('user_money','>=',env('VIP_CHARGE_MONEY'))
        //                     ->first();
        // if ($info) {
        $user_info->check_status = 2;
        $user_info->save();
        return ['status_code' => 201, 'msg' => '尊敬的用户，您已成功提交升级高级会员的申请，我们会尽快与你联系！'];
        // }
    }


}





