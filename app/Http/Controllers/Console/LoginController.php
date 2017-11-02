<?php
namespace App\Http\Controllers\Console;

use App\Http\Controllers\Console\CommonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\UsersModel;
use App\Model\AdUsersModel;
use App\Model\SuppUsersModel;
use App\Model\UserAccountLogModel;
use Validator;
use session;
use DB;
use Mail;
use App\User;

class LoginController extends CommonController
{
    /**
     * 依赖注入
     * @author forapply
     * @param Request $request [description]
     */
    public function __construct(Request $request) 
    {
        $this->_request = $request;
    }

    public function list_1()
    {
        if ($this->_request->input('blade_name')) {
            return view('console.supp.'.$this->_request->input('blade_name'));
        }
    }

    /**
     * 渲染登录模板
     * @return
     */
    public function register()
    {
        return view('console.register.register');
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
        session(['SMS_CODE' => $SMS_CODE]);
      
        $msg = '您的注册码为'.$code.',感谢您的支持!';
        $result = sendSms($phone,$msg);
        return $result;
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
    public function postRegister(Request $request)
    {
        $data = $request->all();

        $is_user = UsersModel::where('name',$data['name'])
                            ->count();
        if ($is_user) {
            return json_encode(['status' => "2", 'msg' => '该用户名已被注册', 'data' => ""], JSON_UNESCAPED_UNICODE);
        }

        $user_SMS = session('SMS_CODE');
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

                if ($data['name'] != $user_SMS['phone']) {
                    return json_encode(['msg' => "验证用户不一致！", 'status' => "2", 'data' => ''], JSON_UNESCAPED_UNICODE);
                }

                $user = new UsersModel();

                $validate = Validator::make($request->all(), $user->rules()['create']);
                $messages = $validate->messages();

                if ($validate->fails()) {
                    $msg = $messages->toArray();
                    foreach ($msg as $k => $v) {
                        return json_encode(['status' => "2", 'msg' => $v[0], 'data' => ''], JSON_UNESCAPED_UNICODE);
                    }
                }
                $mobile = $data['name'];
                $user->name = $data['name'];
                $user->password = bcrypt($data['password']);
                $user->user_type = 2;
                $user->role_id = 1;
                $user->save();
                $data = $user->id;

                $sms_detail_object = new AdUsersModel();

                $sms_detail_object->nickname = $data['name'];
                $sms_detail_object->contact = '';
                $sms_detail_object->company = '';
                $sms_detail_object->qq = '';
                $sms_detail_object->mobile = $mobile;
                $sms_detail_object->user_id = $data;
                $sms_detail_object->email = '';
                $sms_detail_object->mobile_status = 1;//如果是手机号注册，默认绑定
                $sms_detail_object->save();


                Auth::attempt(['name' => $this->_request->input('name'), 'password' => $this->_request->input('password')]);

                if ($data) {
                    
                    $session_user = getUserInfo($data);
                    session(['user'=>$session_user]);
                    session(['SMS_CODE'=>'']);
                    return json_encode(['status' => "1", 'msg' => '注册成功', 'data' => $data], JSON_UNESCAPED_UNICODE);
                }
            } else {
                return json_encode(['msg' => "验证码错误", 'status' => "2", 'data' => '']);
            }
        }
        return json_encode(['status' => "2", 'msg' => '请求错误，请刷新页面重试', 'data' => ''], JSON_UNESCAPED_UNICODE);

    }


    public function register_perfect(Request $request)
    {
        $data = $request->all();
        if ($data['user_id']) {

            $sms_detail_object = AdUsersModel::where('user_id',$data['user_id'])->first();


            // $aduser = new AdUsersModel();
            if (!$sms_detail_object) {
                $sms_detail_object = new AdUsersModel();
            }
            $sms_detail_object->nickname = $data['nickname'];
            $sms_detail_object->contact = $data['Contact_person'];
            $sms_detail_object->company = '';
            $sms_detail_object->qq = $data['user_QQ'];
            $sms_detail_object->user_id = $data['user_id'];
            $sms_detail_object->email = $data['user_Eail'];
            $sms_detail_object->save();
            $ad_users_id = $sms_detail_object->id;
              
            if ($ad_users_id) {
                return json_encode(['status' => "1", 'msg' => '操作成功', 'data' => $ad_users_id], JSON_UNESCAPED_UNICODE);
            }else {
                return json_encode(['msg' => "请求错误，请刷新页面重试", 'status' => "2", 'data' => '']);
            }
        }
        return json_encode(['status' => "2", 'msg' => '请求错误，请刷新页面重试', 'data' => ''], JSON_UNESCAPED_UNICODE);

    }


    /**
     * 渲染注册模板
     * @return
     */
    public function index()
    {
        return view('console.login.login');
    }

    /**
     * 用户登录
     * @author forapply
     * @return [type] [description]
     */
    public function postInfo()
    {
        $messages = [
            'required'   => '用户名或密码或验证码不能为空',
            'min'        => '用户名或密码字符长度不够',
            'captcha'    => '验证码错误'
        ];
        // $validator = Validator::make(Input::all(), $rules);
        $validator = Validator::make($this->_request->all(), [
            'name'     => 'required|min:2',
            'password' => 'required|min:1',
            'captcha' => 'required|captcha',
        ],$messages);

        if ($validator->fails()) {
            return redirect('/console/login')
                        ->withErrors($validator)
                        ->withInput();
        }
        if (!Auth::attempt(['name' => $this->_request->input('name'), 'password' => $this->_request->input('password')])) {
            return redirect('/console/login')->with('status', '用户名密码不正确')->withInput();
        }
        if (Auth::user()->is_login == 2) {
            Auth::logout();
            $msg = '禁止登陆此账号，请联系客服';
            return redirect('/console/login')->with('status', $msg)->withInput();
        }
        //区分用户类型
        $user_info = getUserInfo(Auth::user()->id);//记录用户信息
        // 检测用户类型
        if (Auth::user()->user_type == 3) { // 供应商
            if ($user_info['is_state'] != 1) {
                Auth::logout();
                $msg = [2 => '登录失败,该用户处于下架的状态，请联系客服', 3 => '登录失败,该用户处于审核状态'];
                return redirect('/console/login')->with('status', $msg[$user_info['is_state']])->withInput();
            }
        }
        session(['admin_id' => Auth::user()->id, 
                 'name' => Auth::user()->name, 
                 'role_id' => Auth::user()->role_id,
                 'user'=>$user_info]);
        getMenuList(Auth::user()->role_id,Auth::user()->id);
        return redirect()->intended('/console/index');
    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/console/login')->withInput()->with('success', '退出登录');
    }

    public function test($user_id)
    {
        // $info = AdUsersModel::where('user_id',$user_id)->where('level_id','1')->first();
        // if (!$info) {
        //     return;
        // }
        // $charge_money = UserAccountLogModel::where('account_type',1)->sum('user_money');
        
        // if (env('VIP_CHARGE_MONEY') <= $charge_money) {
        //     // 提醒他
        //     // $info->mobile = '18102686865';
        //     sendSms($info->mobile,"您好，可以升级为VIP咯",$ex='');
        // }

        // dd($charge_money);
        $info = User::where('name',$user_id)->first();
        if ($info->user_type == 3) {
            $parent_u = SuppUsersModel::where('user_id',$info->id)->first();
            if ($parent_u['parent_id'] > 0) {
                $user = SuppUsersModel::where('user_id',$parent_u['parent_id'])->first();
                $user->user_money = $user->user_money + 10000;
                $user->save();
                $user_id = $user->user_id;
            } else {
                $parent_u->user_money = $parent_u->user_money + 10000;
                $parent_u->save();
                $user_id = $parent_u->user_id;
            }
        } elseif ($info->user_type == 2) {
            $user = AdUsersModel::where('user_id',$info->id)->first();
            $user->user_money = $user->user_money + 10000;
            $user->save();
            $user_id = $user->user_id;
        }
        $accountlog_data = [
                        'user_id' => $user_id,
                        'user_money' => 10000, 
                        'desc' => '测试',
                        'account_type' => 1,
                        'order_sn' => time().rand(0,100),
                        'order_id' => time().rand(0,100),
                        'created_at' => date("Y-m-d H:i:s",time()),
                        'pay_type' => 'debug',
                        'pay_user' => 'debug',
                        'status'=>1
                        ];
        UserAccountLogModel::insert($accountlog_data);
        echo 'ok 充值10000到账号【'.$info->name."】";
    }

    /**
     * 忘记密码
     * @return [type] [description]
     */
    public function forget()
    {
        return view('console.login.forget');
    }

    /**
     * 检查用户名是否存在
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function checkUserCode(Request $request)
    {
        $messages = [
            'required'   => '用户名或密码或验证码不能为空',
            'captcha'    => '验证码错误'
        ];
        $validator = Validator::make($this->_request->all(), [
            'username'  => 'required|min:2',
            'user_code' => 'required|captcha',
        ],$messages);

        if ($validator->fails()) {
            return redirect('/console/login')
                        ->withErrors($validator)
                        ->withInput();
        }
        //检查用户名是否存在
        $user = UsersModel::where('user_type','<>',1)->where('name',$request->input('username'))->first();
        if ($user) {
            session(['forget_user' => $user->id]);
            return redirect()->action('Console\LoginController@forgetPwdSecond');
        } else {
            return back()->with('status','用户不存在');
        }
    }

    public function forgetPwdSecond()
    {
        $user_id = session('forget_user');
        if (!$user_id) {
            return redirect()->action('Console\LoginController@forget');
        }
        $user_type = UsersModel::where('id',$user_id)->value('user_type');
        if ($user_type == 2) { // 广告主
            $info = AdUsersModel::where('user_id',$user_id)->select('email','mobile')->first();
        } elseif($user_type == 3) { // 供应商
            $info = SuppUsersModel::where('user_id',$user_id)->select('email','mobile')->first();
        }
        if (empty($info)) {
            return back()->with('status','没有绑定手机号或邮箱，请联系客服');
        }

        return view('console.login.forget_pwd_second',['info' => $info]);
    }

    /**
     * 忘记密码 发送邮箱验证码
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function sendForgetEmail(Request $request)
    {
        $to_email = $request->input('user_email');
        if (!$to_email) {
            return ['status_code' => 201, 'msg' => '邮箱不能为空'];
        }
        //检查此邮箱是否一致
        $forget_email = AdUsersModel::where('user_id',session('forget_user'))->value('email');
        if (!$forget_email) {
            $forget_email = SuppUsersModel::where('user_id',session('forget_user'))->value('email');
        }

        if ($forget_email != $to_email) {
            return ['status_code' => 201, 'msg' => '绑定邮箱与提交邮箱不一致'];
        }

        $code = rand(1000, 9999);
        $email_title = env('FORGET_EMAIL_TITLE');
        Mail::send('mails.forget_email',['msg' => $code], function($msg) use($to_email,$email_title) {
              $msg->to($to_email)->subject($email_title);
        });

        $SMS_CODE['forget_mes'] = [
            'forget_code' => $code,
            'forget_mes' => $to_email,
            'this_time'=>time(),
        ];
        session($SMS_CODE);
        return ['status_code' => 200, 'msg' => '发送成功'];
    }

    public function sendForgetMobile(Request $request)
    {
        $mobile = $request->input('moblie_number');
        if (!$mobile) {
            return ['status_code' => 201, 'msg' => '手机号不能为空'];
        }
        //检查此邮箱是否一致
        $forget_mobile = AdUsersModel::where('user_id',session('forget_user'))->value('mobile');
        if (!$forget_mobile) {
            $forget_mobile = SuppUsersModel::where('user_id',session('forget_user'))->value('mobile');
        }
        if ($forget_mobile != $mobile) {
            return ['status_code' => 201, 'msg' => '绑定手机号与提交手机号不一致'];
        }
        $code = rand(1000, 9999);
        $SMS_CODE['forget_mes'] = [
            'forget_code' => $code,
            'forget_mes' => $mobile,
            'this_time'=>time(),
        ];
        session($SMS_CODE);
        $msg = sprintf(env('FORGET_MOBILE_MSG'),$code);
        $res = sendSms($forget_mobile,$msg,$ex='');

        if ($res['status'] == 1) {
            return ['status_code' => 200, 'msg' => '发送成功'];
        }
        \Log::error(['短信发送失败' => $res['msg']]);
        return ['status_code' => 201, 'msg' => '发送失败'];
    }

    public function resetPwd(Request $request)
    {
        $code = $request->input('user_code');
        if ($code != session('forget_mes')['forget_code']) {
            return back()->with('status','验证码错误');
        }
        return view('console.login.reset_pwd');
    }

    public function updateResetPwd(Request $request)
    {
        $password = $request->input('password');
        if (!$password) {
            return ['status_code' => 201, 'msg' => '密码不能为空', 'redirect' => 1];
        }
        $user = UsersModel::where('id',session('forget_user'))->first();
        $user->password = bcrypt($password);
        if ($user->save()) {
            session()->forget('forget_user');
            session()->forget('forget_mes');
            return ['status_code' => 200, 'msg' => '重置密码成功'];
        }
        return ['status_code' => 201, 'msg' => '重置密码失败'];
    }

}
