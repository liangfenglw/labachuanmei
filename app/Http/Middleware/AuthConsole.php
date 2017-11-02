<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Model\AdminMenuModel;
use App\Model\AdminVsRoleModel;
use Cache;
use DB;

class AuthConsole
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('console/login')->with('info','请先登录');
            }
        }
        //获取菜单栏
        $admin_id = session('admin_id');
        $role_id  = session('role_id');
        if (!Cache::has('adminMenu_'.$admin_id)) {
            getMenuList($role_id,$admin_id); //获取菜单
        }
        return $next($request);
    }
}
