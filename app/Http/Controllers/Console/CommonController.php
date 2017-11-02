<?php
/**
 * 公共控制器
 *
 * User: 
 * Date: 2016/11/15 0015
 * Time: 18:30
 */
namespace  App\Http\Controllers\Console;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redis;

use App\Model\NoticeModel;

use Auth;
use Session;
use Carbon\Carbon;


class CommonController extends Controller
{
    public function __construct()
    {

    }
    
    public function checkNotice()
    {
        $count = 0;
        if (Auth::user()->user_type == 2) {
            $count = NoticeModel::where("user_id",Auth::user()->id)->where('is_read',2)->count();
        } elseif(Auth::user()->user_type == 3) {
            $user_id = Auth::user()->id;
            $count = NoticeModel::whereIn("user_id", function($query)use($user_id){
                $query->from('supp_users')->where('parent_id', $user_id)->select('user_id')->get();
            })->where('is_read',2)->count();
        }
        return ['status_code' => 200, 'msg' => $count];

    }

    /**
     * 单图上传
     * @return [type] [description]
     */
    public static function uploadFile($files)
    {
        if (is_array($files)) {
            $upload_file = [];
            foreach ($files as $key => $file) {
                if (!$file->isValid()) {
                    return ['status_code' => 201, 'msg' => '图片为空'];
                }
                $extension = $file->extension();
                if (in_array(strtolower($extension), ['png','jpeg','jpg','bmp'])) {
                    $dir_name = date('Y-m-d', time());
                    // 检测文件夹是否存在
                    if (!is_dir(public_path().'/uploads/'.$dir_name)) {
                        mkdir(public_path().'/uploads/'.$dir_name, 777);
                    }
                    $path = '/uploads/'.$file->store('images/'.$dir_name);
                    $upload_file[$key] = $path;
                }
            }
            return ['status_code' => 200, 'data' => $upload_file];
        }
    }

    public static function uploadExcel($file)
    {
        if (!is_array($file)) { 
            $files = [$file];
        } else {
            $files = $file;
        }
        $upload_file = [];
        foreach ($files as $key => $file) {
            if (!$file->isValid()) {
                return ['status_code' => 201, 'msg' => '不存在文件'];
            }
            $extension = $file->extension();
            if (in_array(strtolower($extension), ['xlsx','xls'])) {
                $dir_name = date('Y-m-d', time());
                // 检测文件夹是否存在
                if (!is_dir(public_path().'/uploads/'.$dir_name)) {
                    mkdir(public_path().'/uploads/'.$dir_name, 777);
                }
                $path = '/uploads/'.$file->store('images/'.$dir_name);
                $upload_file[$key] = $path;
            } else {
                return ['status_code' => 201, 'msg' => '格式错误'];
            }
        }
        if (!is_array($file)) {
            return ['status_code' => 200, 'data' => $path];
        }
    }
}
