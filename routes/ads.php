<?php
/*
|--------------------------------------------------------------------------
| Ads Routes 广告主
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/
//用户管理->广告主
Route::group(['namespace' => 'Console' , 'prefix' => 'userpersonal', 'middleware' => ['web', 'console', 'check.is.ads']],
    function () {
        Route::any('/onlnetop_up','UserpersonalController@onlnetop_up');//用户充值
        Route::any('/account_query','UserpersonalController@account_query');//账户查询
        Route::get('/account_query/type/{id}','UserpersonalController@accountQuery');// 账户查询 ajax
        Route::any('/account_enchashment','UserpersonalController@account_enchashment');//账户提现
        Route::any('/account_enchashment_post','UserpersonalController@account_enchashment_post');//账户提现post
        Route::any('/person_safe_certificate','UserpersonalController@person_safe_certificate');//填写证件信息()
        Route::any('/user_add','UserpersonalController@user_add');//高级会员增加下级会员
        Route::any('/user_manage','UserpersonalController@user_manage');//高级会员管理
        Route::any('/user_subordinate/{id}','UserpersonalController@user_subordinate');//查看下级用户
        Route::get('/apply_vip','UserpersonalController@applyVip');//申请成为高级会员
        Route::any('/ajax_child_order_list','UserpersonalController@ajaxChildOrderList');
});

// 广告主订单路由
Route::group(['namespace' => 'Console' , 'prefix' => 'order', 'middleware' => ['web', 'console','check.is.ads']],
    function () {
        Route::any('/order_detail/{id}','OrderController@order_detail');//订单详情
        Route::any('/order_appeal_detail/{id}','OrderController@order_appeal_detail');//申诉订单详情
        Route::any('/order_list/{id}','OrderController@order_list');//订单列表
        Route::any('/order_list','OrderController@order_list');//订单列表
        Route::any('/order_appeal','OrderController@order_appeal');//申诉订单详情
        Route::any('/select_appeal_order','OrderController@select_appeal_order');//申诉订单详情
        Route::any('/apply_invoice','OrderController@apply_invoice');//申请发票
});

// 各种媒体，相当于商品路由
Route::group(['namespace' => 'Console' , 'prefix' => 'media', 'middleware' => ['web','console','check.is.ads']],
    function () {
        Route::get('/sale_encyclopedia','MediaController@sale_encyclopedia');//百科营销
        Route::any('/getUser','MediaController@getUser');//获取用户信息
        Route::any('/sale_media/{id}','MediaController@sale_media');//网络媒体营销
        Route::any('/sale_media','MediaController@sale_media');//网络媒体营销
        Route::post('/get_resource','MediaController@get_resource');//获取选中资源的信息
        Route::post('/upload','MediaController@upload');//上传稿件
});

Route::group(['namespace' => 'Console' , 'prefix' => 'cart', 'middleware' => ['web', 'console','check.is.ads']],
    function () {
        Route::post('/post_cart','CartController@post_cart');//加入购物车
        Route::any('/cart_list','CartController@cart_list');//购物车列表
        Route::post('/delete_order','CartController@delete_order');//删除订单
        Route::post('/check_order','CartController@check_order');//查看未失效订单
        Route::post('/cart_Settlement','CartController@cart_Settlement');//结算订单
});