<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
class ViewServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            ['console.user.*',
             'console.media.*',
             'console.order.*',
             'console.cart.*',
             'console.payment.*',
             'console.share.admin_menu',
             'console.share.admin_foot',
             'console.share.admin_head',
             'console.share.user_menu',
             'console.share.cssjs',
             'console.userpersonal.*'
             ], 
             'App\Http\Console\ViewComposers\ViewComposer'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
