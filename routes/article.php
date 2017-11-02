<?php
/*
|--------------------------------------------------------------------------
| Article Routes 内容管理
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/
//内容管理
Route::group(['namespace' => 'Console' , 'prefix' => 'console', 'middleware' => ['web','console','check.role']],
    function () {
        Route::any('/article/category/add','ManagerController@categoryAdd');//添加栏目
        Route::get('/article/category/manager','ManagerController@categoryManager');//栏目管理
        Route::get('/article/category/{id}','ManagerController@artcileCategory');//栏目文章
        Route::post('/article/category/del','ManagerController@delCategory');//删除栏目
        Route::get('/article/category/{id}','ManagerController@category');//chakn栏目
        
        Route::any('/article/add','ManagerController@addArticle'); // 添加文章
        Route::any('/article/update','ManagerController@updateArticle'); //更新文章
        Route::any('/article/manager','ManagerController@articleList');//文章列表
        Route::any('/article/{id}','ManagerController@article');//查看文章
        Route::post('/delArticle','ManagerController@articleDel');//删除文章
});
