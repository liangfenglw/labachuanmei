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
use App\User;
use Auth;
use DB;

class SearchController extends CommonController
{
    public function index(Request $request)
    {
        $user = $this->getUser();
        if ($user['level_id'] >= 2) {
            $supp_list = SuppUsersSelfModel::leftJoin('plate','supp_users_self.plate_id','=','plate.id')
                            ->where('supp_users_self.is_state',1)
                            ->where('supp_users_self.media_name','like','%'.$request->input('keyword').'%')
                            ->select("plate.plate_name",'supp_users_self.*',"supp_users_self.vip_price as proxy_price")
                            ->get()
                            ->toArray();
        } else {
            $supp_list = SuppUsersSelfModel::leftJoin('plate','supp_users_self.plate_id','=','plate.id')
                            ->where('supp_users_self.is_state',1)
                            ->where('supp_users_self.media_name','like','%'.$request->input('keyword').'%')
                            ->select("plate.plate_name",'supp_users_self.*',"supp_users_self.plate_price as proxy_price")
                            ->get()
                            ->toArray();
        }
        // $supp_list = SuppUsersSelfModel::leftJoin('plate','supp_users_self.plate_id','=','plate.id')
                        
        //                 ->select('plate.plate_name','supp_users_self.*')
        //                 ->orderBy('supp_users_self.id','desc')
        //                 ->get()
        //                 ->toArray();
        return view('search.supp_list',['supp_list' => $supp_list]);
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
