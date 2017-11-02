<?php
/*
|--------------------------------------------------------------------------
| role Routes
| 权限路由
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/
//帮助中心
Route::group(['namespace' => 'Console' , 'prefix' => 'usermanager', 'middleware' => ['web', 'console', 'check.role']],
    function () {
       Route::get('/role','UsermanagerController@roleList');//角色管理列表
       Route::post('/addRole','UsermanagerController@addRole');//添加角色
       Route::get('/editRole/{id}','UsermanagerController@editRole');//添加角色
       Route::post('/updateRole','UsermanagerController@updateRole');//更新、保存角色权限
       Route::get('/delRole/{id}','UsermanagerController@delRole');//更新、保存角色权限

       // 管理员路由
       Route::get('/adminuser/list','UsermanagerController@adminUserList');//管理员用户列表
       Route::get('/adminuser/edit/{id}','UsermanagerController@editAdminUser');//管理员权限编辑
       Route::post('/adminuser/edit','UsermanagerController@updateAdminUser');//更新权限
       Route::get('/adminuser/user/{id}','UsermanagerController@adminUserMes');//用户信息查看
       Route::post('/adminuser/user','UsermanagerController@updateUser');//用户信息更新
       Route::get('/adminuser/add','UsermanagerController@add'); //添加管理员
       Route::post('/adminuser/add','UsermanagerController@addUser'); // 管理员信息保存
       Route::get('/adminuser/delete/{id}','UsermanagerController@deleteAdminUser');//删除管理员
});