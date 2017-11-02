<?php

namespace App\Http\Console\ViewComposers;

use Illuminate\Contracts\View\View;
use Auth;
use Cache;
use App\Model\AdminRoleModel;
use App\Model\CartModel;
use App\Model\PhoneOrderModel;

class ViewComposer
{

    /**
     * 绑定数据到视图.
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $adminUid = Auth::user()->id;
        //等级
        if (!Cache::has('adminRoleName')) {
            $levelName = AdminRoleModel::where('id',Auth::user()->role_id)->value('level_name');
            Cache::forever('levelName',$levelName);
        }
        $menuList = [];
        $phone_order_count = $cart_list = 0;
        if (session('user')['user_type'] == 3) { //供应商
            $head_pic = session('user')['media_logo'];
        } elseif (session('user')['user_type'] == 2) { //广告主
            $cart_list = CartModel::where('status',0)
                                    ->where('is_delete',1)
                                    ->where('ads_user_id',$adminUid)
                                    ->get()
                                    ->toArray();
            $head_pic = isset(session('user')['head_pic']) ? session('user')['head_pic']:'';
        } else {
            if (Cache::has('adminMenu_'.$adminUid)) { // 菜单栏
                getMenuList(Auth::user()->role_id,$adminUid); //获取菜单
            }
            // 回拨
            $phone_order_count = PhoneOrderModel::where('status',2)->count();

            $menuList = Cache::get('adminMenu_'.$adminUid);
            $head_pic = isset(session('user')['head_pic']) ? session('user')['head_pic']:'';
        }
        $cart_count = $cart_list ? count($cart_list) : 0;
        $view->with([
                'menuList'  => $menuList,
                'uid'       => $adminUid,
                'user_type' => session('user')['user_type'],
                'level_id' =>  isset(session('user')['level_id'])?session('user')['level_id']:1,
                'head_pic'  => $head_pic,
                'adminName' => Auth::user()->name,
                'leveName'  => Cache::get('levelName'),
                'user_info' => getUserInfo(Auth::user()->id),
                'cart_list' => $cart_list,
                'cart_count' => $cart_count,
                'phone_order_count' => $phone_order_count,
            ]);
    }
}
