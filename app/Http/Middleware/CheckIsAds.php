<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Request;
use DB;

use App\Model\RoleVsMenuModel;
use App\Model\AdminVsRoleModel;
use App\Model\AdminMenuModel;

class CheckIsAds
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (empty(session('user')['level_id'])) {
            return redirect('/console/index')->with('status', '非法请求');
            // return back()->withInput()->with('status','非法请求');
        }
        return $next($request);
    }
}
