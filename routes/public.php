<?php
/*
|--------------------------------------------------------------------------
| Public Routes
| 供应商、会员公共路由
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/
//用户管理->广告主、供应商
Route::group(['namespace' => 'Console' , 'prefix' => 'userpersonal', 'middleware' => ['web', 'console']],
    function () {
        Route::any('/person_edit','UserpersonalController@person_edit');//修改资料(共用)
        Route::any('/person_safe','UserpersonalController@person_safe');//安全中心(共用)
        Route::any('/person_safe_changepass','UserpersonalController@person_safe_changepass');//修改密码(共用)
        Route::post('/person_safe_editpass', 'UserpersonalController@person_safe_editpass');//(共用)
        Route::get('/person_safe_phone','UserpersonalController@person_safe_phone');//修改绑定手机//(共用)
        Route::any('/sendSms', 'UserpersonalController@sendSms');//发送手机短信//(共用)
        Route::any('/post_safe_phone','UserpersonalController@post_safe_phone');//ajax修改绑定手机//(共用)
        Route::get('/person_safe_email','UserpersonalController@person_safe_email');//修改绑定邮箱//(共用)
        Route::post('/sendSmtp','UserpersonalController@sendSmtp');//发送电子邮件//(共用)
        Route::post('/post_safe_email','UserpersonalController@post_safe_email');//ajax修改绑定邮箱//(共用)
        Route::get('/person_safe_question','UserpersonalController@person_safe_question');//修改密保//(共用)
        Route::post('/post_safe_question','UserpersonalController@post_safe_question');//ajax修改密保//(共用)
        Route::post('/post_safe_question_select','UserpersonalController@post_safe_question_select');//ajax修改密保//(共用)
});
Route::group(['namespace' => 'Console' , 'middleware' => ['web', 'console']],
    function () {
        Route::get('/search_media','PublicController@searchMedia');//ajax修改密保//(共用)
});
// 最新受理订单
Route::group(['namespace' => 'Console' , 'prefix' => 'order', 'middleware' => ['web', 'console']],
    function () {
        Route::any('/order_feedback','OrderController@order_feedback');//最新受理订单
        Route::any('/setnotice','OrderController@setnotice');//最新受理订单
});

//帮助中心
Route::group(['namespace' => 'Console' , 'prefix' => 'help', 'middleware' => ['web', 'console']], function () {
    Route::get('/', 'HelpController@index');
    Route::get('/{id}','HelpController@article');
});
// 电话工单
Route::group(['namespace' => 'Console' , 'prefix' => 'phone', 'middleware' => ['web', 'console']], function () {
    Route::post('/add', 'PublicController@addPhoneOrder');
});
// 新闻中心
Route::group(['namespace' => 'Console' , 'prefix' => 'news', 'middleware' => ['web', 'console']], function () {
    Route::get('/', 'NewsController@index');
    Route::get('/{id}','NewsController@readNews');
});
Route::group(['namespace' => 'Console' , 'prefix' => 'search', 'middleware' => ['web', 'console', 'check.is.ads']], function () {
    Route::get('/', 'SearchController@index');
});
