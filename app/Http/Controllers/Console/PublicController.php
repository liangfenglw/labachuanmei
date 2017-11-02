<?php 
namespace App\Http\Controllers\Console;

use Illuminate\Http\Request;
use App\Http\Controllers\Console\CommonController;
use App\Model\CategoryModel;
use App\Model\ArticleModel;
use App\Model\PhoneOrderModel;
use App\User;
use Auth;
use Cache;
use DB;
use Session;

class PublicController extends CommonController
{
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->request = $request;
    }

    public function addPhoneOrder()
    {
        $phone_num = $this->request->input('phone_num');
        preg_phone_reg($phone_num);
        $res = PhoneOrderModel::where('user_id',Auth::user()->id)
                        ->where('contact_phone',$phone_num)
                        ->whereBetween('created_at',[date("Y-m-d",time())." 00:00:00",date("Y-m-d",time())." 23:59:59"])
                        ->first();
        if ($res) {
            return ['status_code' => 201, 'msg' => '请勿在当天内重复添加相同号码'];
        }

        $phone_order = new PhoneOrderModel;
        $phone_order->contact_phone = $phone_num;
        $phone_order->user_id = Auth::user()->id;
        if ($phone_order->save()) {
            return ['status_code' => 200, 'msg' => '尊敬的用户，客服稍后将会联系您'];
        } else {
            return ['status_code' => 201, 'msg' => '网络繁忙'];
        }
    }

    /**
     * 搜索媒体
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function searchMedia(Request $request)
    {
        $media_name = trim($request->input('media_name'));
        $list = User::where('name','like','%'.$media_name.'%')->select('name','id')->get();
        $data = [];
        foreach ($list as $key => $value) {
            $data[] = [
                'name' => $value['name'], 
                'id' => $value['id'], 
                'val' => $value['name'].' | '. $value['id']
            ];
        }
        return ['status_code' => 200, 'msg' => '查询成功', 'data' => $data];
    }
}