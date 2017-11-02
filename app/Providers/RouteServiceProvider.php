<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::group([
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/web.php');
        });
        // echo $this->namespace;die;
        //console模块
        Route::group([
            'middleware' => ['web'], //系统自带的 比如表单验证错误
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/console.php');
        });
        // 权限模块
        Route::group([
            'middleware' => ['web'], //系统自带的 比如表单验证错误
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/role.php');
        });
        // 文章管理
        Route::group([
            'middleware' => ['web'], //系统自带的 比如表单验证错误
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/article.php');
        });
        
        //public模块
        Route::group([
            'middleware' => ['web'], //系统自带的 比如表单验证错误
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/public.php');
        });
        // 后台用户
        Route::group([
            'middleware' => ['web'], //系统自带的 比如表单验证错误
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/admin_user.php');
        });
        // 广告主模块
        Route::group([
            'middleware' => ['web'], //系统自带的 比如表单验证错误
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/ads.php');
        });
        // 供应商模块
        Route::group([
            'middleware' => ['web'], //系统自带的 比如表单验证错误
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/supp.php');
        });
        
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::group([
            'middleware' => 'api',
            'namespace' => $this->namespace,
            'prefix' => 'api',
        ], function ($router) {
            require base_path('routes/api.php');
        });
    }
}
