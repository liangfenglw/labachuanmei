<?php
namespace App\Http\Controllers\Console;

use Illuminate\Http\Request;
use App\Http\Controllers\Console\CommonController;
use App\Model\CategoryModel;
use App\Model\ArticleModel;


use Auth;
use Cache;
use DB;
use Session;

class HelpController extends CommonController
{
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->request = $request;
    }

    public function index(Request $request)
    {
        $catid = empty($request->input('id')) ? 0 : $request->input('id');

        // 获取栏目
        $category_type = \Config::get("category");
        $lists = CategoryModel::whereIn('type_id',array_keys($category_type))
                                    ->where('status',1)
                                    ->whereNotIn('id',[22,27]) //最新消息
                                    ->orderBy('sortorder','desc') 
                                    ->get()
                                    ->toArray();
        $category_list = [];
        foreach ($lists as $key => $val) {
            if ($catid == 0 && $key == 0) {
                $catid = $val['id'];
            }
            $category_list[$val['type_id']][] = $val;
        }
        //默认取第一个栏目文章
        $article = ArticleModel::where('category_id',$catid)
                        ->select('id','category_id','article_name','type_id')
                        ->paginate(1);

        // dd($category_list);
        return view('console.help.list',
            ['category_list' => $category_list, 'category_type' => $category_type, 'catid' => $catid, 'article_list' => $article]);
    }

    public function article($id)
    {
        $category_type = \Config::get("category");
        $lists = CategoryModel::whereIn('type_id',array_keys($category_type))
                                    ->where('status',1)
                                    ->orderBy('sortorder','desc')
                                    ->whereNotIn('id',[22,27]) //最新消息
                                    ->get()
                                    ->toArray();

        $category_list = [];
        foreach ($lists as $key => $val) {
            $category_list[$val['type_id']][] = $val;
        }

        $info = ArticleModel::with('category')->where('id',$id)->first();

        return view('console.help.article',['info' => $info, 'category_list' => $category_list, 'category_type' => $category_type]);
    }
}
