<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/Console/Index', function () {
//     return view('welcome');
// });

// Route::get('/', 'ManagerController@menuList');
Route::group(['namespace' => 'Console' , 'middleware' => ['web', 'console']],
    function () {
        Route::get('/','UserController@index');//菜单列表
        Route::get('/console/index','UserController@index');//菜单列表
        Route::get('/supp/index','UserController@suppIndex'); //供应商列表
        Route::get('/ads/index','UserController@adsIndex');//广告主列表
});
Route::get('/tests','\App\Http\Controllers\Console\LoginController@tests');
Route::get('/test/{id}','\App\Http\Controllers\Console\LoginController@test');
