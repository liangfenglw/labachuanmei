<?php
/*
|--------------------------------------------------------------------------
| AdminUser Routes
| 后台用户管理路由
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/
//广告主
Route::group(['namespace' => 'Console' , 'prefix' => 'user', 'middleware' => ['web', 'console']], function () {
    Route::get('/ad_user_list', 'AdminUserController@AdUserList'); // 广告主普通会员列表
    Route::get('/supper_ad_user_list','AdminUserController@SupperAdsUserList'); // 广告主高级会员列表
    Route::any('/ajax/ad_user_list','AdminUserController@adsUserList'); //广告主用户列表数据
    Route::get('/ad_user/{id}','AdminUserController@AdUserInfo'); //广告主信息查看
    Route::post('/ad_user/update','AdminUserController@AdUserUpdate'); //广告主信息更新
    Route::get('/get_ads_orderlist','AdminUserController@getAdsOrderList');
    Route::get('/apply','AdminUserController@apply'); //会员申请列表
	
    Route::get('/daili_user_list','AdminUserController@DailiUserList'); // 所属代理会员列表
    Route::get('/daili_user/{id}','AdminUserController@DailiUserInfo'); // 所属代理会员详情
});
//供应商管理
Route::group(['namespace' => 'Console' , 'prefix' => 'usermanager', 'middleware' => ['web', 'console', 'check.role']],
    function () {
        // 供应商
        Route::get('/ads_list','UsermanagerController@adsList');//供应商列表
        Route::get('/add_ads','UsermanagerController@addAds'); //添加供应商模板渲染
        Route::post('/add_ads','UsermanagerController@createAds'); //新建供应商
        Route::get('/supps/{id}','UsermanagerController@suppsInfo'); //查看供应商信息
        Route::post('/supps/{id}','UsermanagerController@updateInfo'); //更新供应商
        Route::get('/resources_list','UsermanagerController@resourcesList');//某个供应商的媒体列表

    // 供应商媒体
        Route::get('suppResourceInfo', 'UsermanagerController@resourceInfo'); // 资源详情
        Route::post('/supps/resource/updateInfo','UsermanagerController@updateResourceInfo'); // 更新供应商媒体
        Route::get('sameTypeMedia', 'UsermanagerController@sameTypeMedia'); // 同类媒体
        Route::get('/addSuppMedia','UsermanagerController@addSuppMedia'); // 添加供应商下的媒体
        Route::post('/updateSet', 'UsermanagerController@updateSet'); // 设置允许接单
        Route::get('ajaxCheckSupp','UsermanagerController@ajaxCheckSupp'); // 供应商检测
        Route::post('saveSuppMedia','UsermanagerController@saveSuppMedia'); // 写入供应商媒体
        Route::get('suppMediaList','UsermanagerController@suppMediaList'); // 供应商媒体列表
        
        // 平台自营媒体
        Route::get('selfMediaList','UsermanagerController@selfMediaList'); //自营媒体列表
        Route::post('selfMedia', 'UsermanagerController@selfMediaInfo'); // 更新平台自营媒体
        Route::get('addSelfMedia', 'UsermanagerController@addSelfMedia');// 添加自营媒体
        Route::post('saveSelfMedia','UsermanagerController@saveSelfMedia');
        Route::get('selfMedia', 'UsermanagerController@selfMedia');
        // Route::get('/resources/{id}','UsermanagerController@resourcesInfo'); //查看资源管理信息
        // 已接单媒体资源
        Route::get('selectOrderMedia', 'UsermanagerController@selectOrderMedia'); // 已接单媒体资源
        Route::get('mediaExcel', 'UsermanagerController@mediaExcel'); // 模板渲染
        Route::post('uploadSelfExcel','UsermanagerController@uploadSelfExcel'); //上传excel自营媒体
});

//资源管理

