<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
$api = app('Dingo\Api\Routing\Router');

// 未登录
$api->version('v1', function ($api) {
    $api->group(['namespace' => 'App\Api\V1\Controllers','middleware' => ['api','web']], function ($api) {
        $api->get('lessons','PostController@index');
        $api->post('user/login','AuthController@authenticate'); //登录
        $api->post('user/register','AuthController@register'); // 注册
        $api->post('reg/sms','AuthController@regSms'); //注册时短信验证码
        $api->post('register','AuthController@register');// 广告主注册
        
    });
});
$api->version('v1', function ($api) {
    $api->group(['namespace' => 'App\Api\V1\Controllers','middleware' => ['api','web','jwt.auth']], function ($api) {
            $api->post('/refresh-token', 'AuthController@refresh');
    });
});
/*********************************公共区****************************************/
$api->version('v1', function ($api) {
    $api->group(['namespace' => 'App\Api\V1\Controllers','prefix' => '','middleware' => ['api','web','jwt.auth']], function ($api) {
        $api->get('user/safe_question','CommonController@getSafeQuestion'); // 获取自己设置的密保
        $api->get('question','CommonController@question'); //获取密保问题
        $api->post('set_question','CommonController@setQuestion'); // 设置密保
        $api->post('check_question','CommonController@checkQuestion'); // 校验密保
        $api->post('edit_password','CommonController@editPassword'); //修改密码
        $api->post('edit_mobile','CommonController@editMobile'); // 修改手机号
        $api->post('edit_email','CommonController@editEmail');// 绑定邮箱
        $api->post('send_email','CommonController@sendEmail'); //发送邮箱
        $api->post('withdraw','CommonController@withdraw'); // 提现操作
        $api->post('send_sms','CommonController@sendSms'); // 发送验证码
        $api->post('user/profile','CommonController@updateProfile'); //更新个人资料
        $api->post('charge','CommonController@charge'); //充值
    });
});
/*********************************公共区END****************************************/

/*********************************广告主****************************************/
$api->version('v1', function ($api) {
    $api->group(['namespace' => 'App\Api\V1\Controllers','prefix' => 'ads','middleware' => ['api','web','jwt.auth']], function ($api) {
        $api->get('user','AdsController@userInfo'); //用户信息
        $api->get('profile','AdsController@profile'); //个人资料
    });
});
/*********************************广告主****************************************/

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
