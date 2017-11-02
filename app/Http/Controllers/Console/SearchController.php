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
        $supp_list = SuppUsersSelfModel::leftJoin('plate','supp_users_self.plate_id','=','plate.id')
                        ->where('supp_users_self.media_name','like','%'.$request->input('keyword').'%')
                        ->select('plate.plate_name','supp_users_self.*')
                        ->orderBy('supp_users_self.id','desc')
                        ->get()
                        ->toArray();
        $zhekou = UserLevelModel::where('id',session('user')['level_id'])->first()->rebate_percent;
        // dd($supp_list);
        return view('search.supp_list',['supp_list' => $supp_list, 'zhekou' => $zhekou]);
    }
}
