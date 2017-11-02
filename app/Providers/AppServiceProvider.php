<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth;
use MyGuard;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Auth::extend('myguard', function(){
        //     return new MyGuard();   //返回自定义 guard 实例
        // });

        // Auth::provider('myuserprovider', function(){
        //     return new MyUserProvider();    // 返回自定义的 user provider
        // });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
