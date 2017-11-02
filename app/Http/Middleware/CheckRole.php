<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Request;
use DB;

use App\Model\RoleVsMenuModel;
use App\Model\AdminVsRoleModel;
use App\Model\AdminMenuModel;

class CheckRole
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
        if (session('role_id') == 1) { //高级权限
            return $next($request);
        }
        $url = explode("/", $_SERVER['REQUEST_URI']);
        $url_length = count($url);
        if (is_numeric($url[$url_length - 1])) {
            $url_route = '/'.trim($request->path(),'/'.$url[$url_length - 1]);
        } else {
            $url_route = '/'.Request::path();
        }
        $menu_id = AdminMenuModel::where('route',$url_route)->value('id');
        $res     = AdminVsRoleModel::where('menu_id',$menu_id)
                                        ->where('uid',Auth::user()->id)
                                        ->first();
        if (!$res) { //没有权限
            if (\Request::ajax()) { //ajax
                die(json_encode(['status_code' => '502', 'error' => '没有操作权限']));
            }
            return back()->withInput()->with('status','没有权限！');
        }
        return $next($request);
    }
}
