<?php
/*
|--------------------------------------------------------------------------
| Supp Routes 供应商
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/
//用户管理->供应商
Route::group(['namespace' => 'Console', 'prefix' => 'supp', 'middleware' => ['web', 'console', 'check.role']],
    function () {
        Route::get('/supp_edit','SuppController@suppEdit');//编辑供应商信息
        Route::post('/updateInfo','SuppController@updateInfo');//更新供应商信息
        Route::get('/accout_query','SuppController@accountQuery');
        Route::get('/user_check','SuppController@userCheck');//查看证件信息
        Route::get('/order','SuppController@order');//查看证件信息
        Route::get('/order/{id}','SuppController@order');//订单管理
        Route::get('/new_order_list','SuppController@orderList');//最新受理订单
        Route::get('/order/info/{id}','SuppController@orderInfo');//订单详情
        Route::any('/order/opera','SuppController@orderOpera');//订单操作
        Route::get('/withdraw','SuppController@withdraw');//提现列表
        Route::post('/withdraw','SuppController@withdrawOpera');//提现列表
        Route::get('/resource','SuppController@resource');// resource资源管理
        Route::get('/resource/{id}','SuppController@addResource');//添加资源模板渲染
        Route::post('/resource/save','SuppController@saveResource');//添加资源模板渲染
        Route::get('/resource/info/{id}','SuppController@resourceInfo');//查看审核中的资源(下级)
        Route::post('uploadMedia', 'SuppController@uploadMedia'); // 上传媒体资源
    });