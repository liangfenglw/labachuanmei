<?php
/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/
//用户登录、注册模块
Route::group(['namespace' => 'Console' , 'prefix' => 'console', 'middleware' => ['web']], function () {
    Route::get('/login', 'LoginController@index');
    Route::get('/register', 'LoginController@register');
    Route::post('/register', 'LoginController@postRegister');
    Route::post('/register_perfect', 'LoginController@register_perfect');
    Route::any('/sendSms', 'LoginController@sendSms');
    Route::post('/post', 'LoginController@postInfo');
    Route::get('/logout','LoginController@logout');
    Route::get('/forget','LoginController@forget');

    Route::get('/add_view','LoginController@list_1');
});
Route::group(['namespace' => 'Console' , 'prefix' => '', 'middleware' => ['web']], function () {
    Route::get('/forget','LoginController@forget');
    Route::post('/check_user_code','LoginController@checkUserCode');
    Route::get('/forget_pwd_second','LoginController@forgetPwdSecond'); // 忘记密码第二步
    Route::post('/send_forget_email','LoginController@sendForgetEmail'); // 发送邮箱
    Route::post('/send_forget_mobile','LoginController@sendForgetMobile'); // 发送手机号
    Route::post('/reset_pwd','LoginController@resetPwd'); // 重置密码
    Route::post('/update/forget_pwd','LoginController@updateResetPwd'); // 更新新密码
});


Route::group(['namespace' => 'Console' , 'prefix' => 'manager', 'middleware' => ['web','console','check.role']],
    function () {
        Route::post('updateCategory','ManagerController@updateCategory');//更新、添加栏目、方法
        Route::get('/categoryList','ManagerController@categoryList');//菜单列表
        Route::get('/editCategory/{id}','ManagerController@editCategory');//编辑栏目
        Route::get('/addMenu','ManagerController@addMenu');//添加菜单

        Route::get('/index', 'UserController@index');
        Route::get('/manager/index','UserController@managerIndex');
        Route::get('/user/list','UserController@userList');
        Route::get('/user/searchList','UserController@searchList');
});

Route::group(['namespace' => 'Console' , 'prefix' => 'console', 'middleware' => ['web','console','check.role']],
    function () {
        Route::get('/manager/media','ManagerController@media');//资源筛选管理
        Route::post('/manager/del_attr/{id}','ManagerController@delAttr'); // 删除资源分类
        Route::post('/manager/media','ManagerController@updateMedia');//更新
        Route::get('/manager/order/{id}','ManagerController@order');//订单列表
        Route::get('/manager/order/info/{id}','ManagerController@orderInfo');//订单信息
        Route::post('/manager/order/info/{id}','ManagerController@qaDeal');//完成申诉扣款操作
        Route::get('managerOrder/selectMedia','ManagerController@selectMedia'); // 选择媒体
        Route::get('managerOrder/setOrderMedia','ManagerController@setOrderMedia'); // 指派订单
        // 提现
        Route::get('/withdraw/list','ManagerController@withdraw');//提现列表
        Route::get('/withdraw/{id}','ManagerController@withdrawInfo');
        Route::post('/withdraw/{id}','ManagerController@updateWithdraw');
        // 发票
        Route::get('/invo/lists','ManagerController@invo');//发票列表
        Route::get('/invo/{id}','ManagerController@invoInfo');//详情
        Route::post('/invo/{id}','ManagerController@updateInvo');//审核操作
        // 回拨列表
        Route::any('/phone_order','ManagerController@phoneOrderList');//添加栏目渲染
        Route::any('/phone_order/id/{id}','ManagerController@updatePhoneOrder');//添加栏目渲染
        Route::get('/new_order_list','SuppController@orderList');
		
		//活动管理
		Route::get('/activity/list','ManagerController@actList'); //活动列表
    	Route::get('/activity/add','ManagerController@actAdd');	//添加活动
        Route::post('/activity/info/update','ManagerController@updateActInfo'); //更新、添加活动详情
        Route::post('/activity/del','ManagerController@delActivity');//删除活动
        Route::get('/activity/info/{id}','ManagerController@actUser'); //查看参与活动的用户
        Route::post('/activity/user/add','ManagerController@addActivityUser');//添加、更新参与活动用户
});

//充值模块
Route::group(['namespace' => 'Console' , 'prefix' => 'payment', 'middleware' => ['web','console']],
    function () {
       Route::any('/balance_pay_wx','PaymentController@balance_pay_wx');//用户充值,微信
       Route::any('/wx_webnotify','PaymentController@wx_webnotify');//用户充值异步回调，微信
       Route::any('/ajax_check_balance','PaymentController@ajax_check_balance');//用户充值同步回调，微信
       Route::any('/balance_pay_ali','PaymentController@balance_pay_ali');//用户充值,支付宝
       Route::any('/webnotify','PaymentController@webnotify');//用户充值异步回调,支付宝
       Route::any('/webreturn','PaymentController@webreturn');//用户充值同步回调,支付宝
       Route::any('/pay_success','PaymentController@pay_success');//支付成功页面
       Route::any('/pay_fail','PaymentController@pay_fail');//支付失败页面
});

//充值模块
Route::group(['namespace' => 'Console' , 'prefix' => 'payment', 'middleware' => ['web']],
    function () {
       Route::any('/wx_webnotify','PaymentController@wx_webnotify');//用户充值异步回调，微信
       Route::any('/webnotify','PaymentController@webnotify');//用户充值异步回调,支付宝
});
//用户管理 排除检测权限的一些ajax请求
Route::group(['namespace' => 'Console' , 'prefix' => 'public', 'middleware' => ['web', 'console']],
    function () {
        Route::post('/getCategory','ManagerController@getCategory'); //获取栏目
});

Route::group(['namespace' => 'Console' , 'prefix' => 'user', 'middleware' => ['web', 'console']],
    function () {
        Route::get('/index', 'UserController@index');
        Route::get('/manager/index','UserController@managerIndex');
        Route::get('/user/list','UserController@userList');
        Route::get('/user/searchList','UserController@searchList');
});

// API 接口检测
Route::group(['namespace' => 'Console' , 'prefix' => 'api', 'middleware' => ['web', 'console']],
    function () {
        Route::post('/check_notice','CommonController@checkNotice');
});



/*
//活动管理
Route::group(['namespace' => 'Console' , 'prefix' => '', 'middleware' => ['web','console']],
    function () {

        Route::get('/activity/list','ActivityController@actList');		//活动列表
        Route::get('/activity/{id}','ActivityController@info');			//查看活动
        Route::get('/activity/add','ActivityController@add');			//添加活动

});
*/