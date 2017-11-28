<?php

namespace App\Http\Controllers\Console;

use Illuminate\Http\Request;
use App\Http\Controllers\Console\CommonController;

use App\Model\PlateModel;
use App\Model\SuppVsAttrModel;
use App\Model\SuppUsersSelfModel;
use App\Model\UserAccountLogModel;
use App\Model\OrderModel;
use App\Model\OrderNetworkModel;
use App\Model\UsersModel;
use App\Model\UsersEnchashmentModel;
use App\Model\ApplySuppsModel;
use App\Model\AdUsersModel;
use App\Model\UserLevelModel;
use App\Model\ActivityModel;
use App\Model\ActivityVsUserModel;
use App\User;
use Auth;
use DB;

class SearchController extends CommonController
{
    public function index(Request $request)
    {
        $user = $this->getUser();
        $activity = ActivityModel::where('start','<=',date("Y-m-d H:i:s",time()))
                        ->where('over','>=',date("Y-m-d H:i:s",time()))
                        ->select('vip_rate','plate_rate','id')
                        ->first();
        $user_ids = [];
        if (!empty($activity)) {
            $user_ids = ActivityVsUserModel::where('activity_id',$activity->id)
                            ->pluck('user_id')
                            ->toArray();
        }
        if ($user['level_id'] >= 2) {
            $lists = SuppUsersSelfModel::leftJoin('plate','supp_users_self.plate_id','=','plate.id')
                            ->where('supp_users_self.is_state',1)
                            ->where('supp_users_self.media_name','like','%'.$request->input('keyword').'%')
                            ->select("plate.plate_name",'supp_users_self.*',"supp_users_self.vip_price as proxy_price")
                            ->get()
                            ->toArray();
        } else {
            $lists = SuppUsersSelfModel::leftJoin('plate','supp_users_self.plate_id','=','plate.id')
                            ->where('supp_users_self.is_state',1)
                            ->where('supp_users_self.media_name','like','%'.$request->input('keyword').'%')
                            ->select("plate.plate_name",'supp_users_self.*',"supp_users_self.plate_price as proxy_price")
                            ->get()
                            ->toArray();
        }
        $rate = 1;
        if (!empty($activity)) {
            if ($user['level_id'] >= 2) {
                $rate = number_format($activity->vip_rate / 100, 2);
            } else {
                $rate = number_format($activity->plate_rate / 100, 2);
            }
        }
        
        foreach ($lists as $key => $value) {
            if (in_array($value['user_id'], $user_ids)) {
                $lists[$key]['member_price'] = number_format($value['proxy_price'] * $rate, 2);
            } else {
                $lists[$key]['member_price'] = '';//$value['proxy_price'];
            }
        }

        
        // dd($supp_list);

        // $supp_list = SuppUsersSelfModel::leftJoin('plate','supp_users_self.plate_id','=','plate.id')
                        
        //                 ->select('plate.plate_name','supp_users_self.*')
        //                 ->orderBy('supp_users_self.id','desc')
        //                 ->get()
        //                 ->toArray();
        return view('search.supp_list',['supp_list' => $lists]);
    }

    public function getUser()
    {
        $user_id = Auth::user()->id;

        $user = AdUsersModel::where('ad_users.user_id',$user_id)
                            ->join('users','ad_users.user_id','=','users.id')
                            ->first();
        $user = $user->toArray();
        return $user;
    }
}
