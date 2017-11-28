<?php

namespace App\Http\Controllers\Console;

use Illuminate\Http\Request;
use App\Http\Controllers\Console\CommonController;

use App\Model\AdUsersModel;
use App\Model\CustomerModel;
use App\Model\SuppUsersModel;
use App\Model\SuppVsAttrModel;
use App\Model\PlateAttrValueModel;
use App\Model\PlateModel;
use App\Model\UserLevelModel;
use App\Model\CartMode;
use App\Model\CartNetworkModel;
use App\Model\ActivityModel;
use App\Model\ActivityVsUserModel;
use App\Model\SuppUsersSelfModel;

use Auth;
use Cache;
use DB;
use Session;

class MediaController extends CommonController
{
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->request = $request;
    }

    /*
    *百科营销
    */
    public function sale_encyclopedia()
    {
        $user = $this->getUser();
        return view('console.media.sale_encyclopedia',['user'=>$user]);
    }

    /*
    *网络媒体营销
    */
    public function sale_media(Request $request,$id)
    {
        $user = $this->getUser();
        $data = $request->all();
        if (!$id && !$data['id']) {
            return redirect('/')->withInput()->with('status', '操作失败');
        }

        // $rebate_percent = UserLevelModel::where('id',$user['level_id'])->value('rebate_percent');
        // $rebate_percent = $rebate_percent?$rebate_percent:1;
        // if ()
        $category_id = '';

        $user = $this->getUser();
        $page['limit_start'] = 0;
        $page['page_num'] = 10;
        $page['page_statue'] = 0;
        $is_limit = 1;
        $select_val = [];
        if ($this->request->input('user_id')) {
            $select_val= SuppVsAttrModel::where('user_id',$this->request->input('user_id'))
                                ->pluck('attr_value_id')
                                ->toArray();
            $is_limit = 2;
        }
        $html_data = getAttrValueSale($id,1,$is_limit,$select_val);
        if ($html_data['status'] != 1) {
            return redirect('/')->withInput()->with('status', '操作失败');
        }

        $html = $html_data['data']['html'];
        $media = $html_data['data']['media'];
        $select_html = $html_data['data']['select_html'];
        $lists = [];
        $user_ids = [];

        if (\Request::ajax()) {
            $id = $data['id'];
            $page['limit_start'] = isset($data['limit_start'])?$data['limit_start']:0;
            $page['page_num'] = isset($data['page_num'])?$data['page_num']:10;
            $category_id = $data['category_id'];
            $user_ids = get_supp_users_id($id,$category_id,$user['level_id']);

        }else{
            $user_ids = SuppUsersSelfModel::where('plate_id',$id)
                                   ->where('is_state',1)
                                   ->pluck('user_id')
                                   ->toArray();

        }
		$user_ids2 = $user_ids;
        // 查看活动
        $activity = ActivityModel::where('start','<=',date("Y-m-d H:i:s",time()))
                        ->where('over','>=',date("Y-m-d H:i:s",time()))
                        ->select('vip_rate','plate_rate','id')
                        ->first();

        if ($user['level_id'] >= 2) {
            $lists = SuppUsersSelfModel::where('plate_id',$id)
                            ->where('is_state',1)
                            ->distinct()
                            ->with(['attr_value_id','attr_value_id.value'])
                            ->whereIn('supp_users_self.user_id',$user_ids)
                            ->skip($page['limit_start'])
                            ->take($page['page_num'])
                            ->select("*","vip_price as proxy_price")
                            ->get()
                            ->toArray();
        } else {
            $lists = SuppUsersSelfModel::where('plate_id',$id)
                            ->where('is_state',1)
                            ->distinct()
                            ->with(['attr_value_id','attr_value_id.value'])
                            ->whereIn('supp_users_self.user_id',$user_ids)
                            ->skip($page['limit_start'])
                            ->take($page['page_num'])
                            ->select("*","plate_price as proxy_price")
                            ->get()
                            ->toArray();
        }
        if (!empty($activity)) {
            $user_ids = ActivityVsUserModel::where('activity_id',$activity->id)->pluck('user_id')->toArray();
            if ($user['level_id'] >= 2) {
                $rate = number_format($activity->vip_rate / 100, 2);
            } else {
                $rate = number_format($activity->plate_rate / 100, 2);
            }
            foreach ($lists as $key => $value) {
                if (in_array($value['user_id'], $user_ids)) {
                    $lists[$key]['proxy_price'] = number_format($value['proxy_price'] * $rate, 2);
                }
            }
        }
        $lists = matched_list($id,$category_id,$lists);

        if (count($user_ids2)>(count($lists)+$page['limit_start'])) {
            $page['page_statue'] = 1;
        }

        $page['limit_start']+= count($lists);

        if (\Request::ajax()) {
                return ['status'=>1,'data'=>$lists,'msg'=>'操作成功','resource_count'=>count($user_ids2),'page'=>$page];
        }
        
        // 怕需要扩展 for_apply修改
        $assign = [
            1 => ['user' => $user, 
                  'html' => $html,
                  'lists' => $lists,
                  'resource_count' => count($user_ids2),
                  'page_statue',
                  'page' => $page, 
                  'media' => $media,
                  'select_html' => $select_html]
        ];
        switch ($id) {
            case 1:
                return view('console.media.sale_media_news', $assign['1']);
                break;
            case 10:
                return view('console.media.sale_media_video', $assign['1']);
                break;
            case 17:
                 return view('console.media.sale_media_bbs', $assign['1']);
                break;
            case 25:
                 return view('console.media.sale_media_microblog', $assign['1']);
                break;
            case 33: //木有
                 return view('console.media.sale_media_qa', $assign['1']);
                break;
            case 36:
                 return view('console.media.sale_media_wechat', $assign['1']);
                break;
            default:return view('console.media.sale_media', $assign['1']);
                break;
        }
        // dd($media);
        // return view('console.media.sale_media',['user'=>$user,'html'=>$html,'lists'=>$lists,'resource_count'=>count($user_ids),'page_statue','page'=>$page,'media'=>$media]);
    }

    /*
    *获取选中资源的信息
    */
    public function get_resource(Request $request)
    {
        $user = $this->getUser();
        $data = $request->all();
        $media_id = $data['media_id'];

        $category_id = $data['category_id'];

        $user_id = $data['id'];
        // 查看活动
        $activity = ActivityModel::where('start','<=',date("Y-m-d H:i:s",time()))
                        ->where('over','>=',date("Y-m-d H:i:s",time()))
                        ->select('vip_rate','plate_rate','id')
                        ->first();

        if ($user['level_id'] >= 2) {
            $lists = SuppUsersSelfModel::where('plate_id',$media_id)
                            ->where('is_state',1)
                            ->distinct()
                            ->with(['attr_value_id', 'attr_value_id.value'])
                            ->where('supp_users_self.user_id',$user_id)
                            ->select("*","vip_price as proxy_price")
                            ->get()
                            ->toArray();
        } else {
            $lists = SuppUsersSelfModel::where('plate_id',$media_id)
                        ->where('is_state',1)
                        ->distinct()
                        ->with(['attr_value_id','attr_value_id.value'])
                        ->where('supp_users_self.user_id',$user_id)
                        ->select("*","plate_price as proxy_price")
                        ->get()
                        ->toArray();
        }
        if (!empty($activity)) {
            $user_ids = ActivityVsUserModel::where('activity_id',$activity->id)->pluck('user_id')->toArray();
            if ($user['level_id'] >= 2) {
                $rate = number_format($activity->vip_rate / 100, 2);
            } else {
                $rate = number_format($activity->plate_rate / 100, 2);
            }
            foreach ($lists as $key => $value) {
                if (in_array($value['user_id'], $user_ids)) {
                    $lists[$key]['proxy_price'] = number_format($value['proxy_price'] * $rate, 2);
                }
            }
        }
        

        $lists = matched_list($media_id,$category_id,$lists);

            return ['status'=>1,'data'=>$lists,'msg'=>'操作成功'];
    }


    /*
    *获取用户信息
    */
    public function getUser()
    {
        $user_id = Auth::user()->id;

        $user = AdUsersModel::where('ad_users.user_id',$user_id)
                            ->join('users','ad_users.user_id','=','users.id')
                            ->first();
        $user = $user->toArray();
        return $user;
    }

    public function  upload(Request $request)
    {
        $data = $request->all();
        if (isset($data['file'])) {
            // $input = Input::except('_token','head_pic');
            $path = 'uploads/file/'.Auth::user()->id;
            $res = $this->uploadpic('file',$path);

            switch ($res){
                case 1: return ['status'=>2,'data'=>[],'msg'=>'文档上传失败']; 
                case 2: return ['status'=>2,'data'=>[],'msg'=>'文档不合法'];
                case 3: return ['status'=>2,'data'=>[],'msg'=>'文档后缀不对'];
                case 4: return ['status'=>2,'data'=>[],'msg'=>'文档储存失败'];
                default :
                $file = $res;
            }
            return ['status'=>1,'data'=>['file'=>$file],'msg'=>''];
        }
        return ['status'=>2,'data'=>[],'msg'=>'请上传文档'];

    }



    //    上传图片
    public function uploadpic($filename, $filepath)
    {
        //        1.首先检查文件是否存在
        if ($this->request->hasFile($filename)){
            //          2.获取文件
            $file = $this->request->file($filename);
            //          3.其次检查图片手否合法
            if ($file->isValid()){
                 // $originalName = $file->getClientOriginalName(); // 文件原名
                $ext = $file->getClientOriginalExtension();     // 扩展名
                // dd($ext);
    //                先得到文件后缀,然后将后缀转换成小写,然后看是否在否和图片的数组内
                // dd(strtolower($file->extension()));
                if(in_array($ext,['doc','docx','ppt','pptx','xls','vsd','pot','pps','rtf','wps','pdf','txt','bin'])){
                    //          4.将文件取一个新的名字
                    $newName = 'file'.time().rand(100000, 999999).".$ext";
                    //           5.移动文件,并修改名字
                    if($file->move($filepath,$newName)){
                        return $filepath.'/'.$newName;   //返回一个地址
                    }else{
                        return 4;
                    }
                }else{
                    return 3;
                }

            }else{
                return 2;
            }
        }else{
            return 1;
        }
    }
}
