<?php

namespace App\Http\Controllers\Console;

use Illuminate\Http\Request;
use App\Http\Controllers\Console\CommonController;

use App\Model\ArticleModel;
use App\Model\NewsReadLogModel;
use App\Model\NoticeModel;

use Auth;
use Cache;
use DB;
use Session;

class NewsController extends CommonController
{
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->request = $request;
    }

    public function index()
    {
        $user_id = Auth::user()->id;
        // 获取未读
        $news = ArticleModel::where('category_id',22)
                    ->whereNotIn('id',function($query) use($user_id) {
                        $query->from('news_read_log')->where('user_id',$user_id)->select('article_id');
                    })
                    ->orderBy('id','desc')
                    ->get()
                    ->toArray();

        // 获取已读
        $read_news = ArticleModel::where('category_id',22)
                    ->whereIn('id',function($query) use($user_id) {
                        $query->from('news_read_log')->where('user_id',$user_id)->select('article_id');
                    })
                    ->orderBy('id','desc')
                    ->get()
                    ->toArray();
        if (Auth::user()->user_type == 2) {
            $notice_list = NoticeModel::where('user_id', $user_id)
                                ->whereIn('type',[1,2])
                                ->where('is_read',2)
                                ->get()
                                ->toArray();
            $read_notice = NoticeModel::where('user_id', $user_id)
                                    ->whereIn('type',[1,2])
                                    ->where('is_read',1)
                                    ->get()
                                    ->toArray();
        } elseif (Auth::user()->user_type == 3) {
            $notice_list = NoticeModel::whereIn('user_id', function($query)use($user_id){
                $query->from('supp_users')->where('parent_id', $user_id)->select('user_id')->get();
            })
                                ->where('type',1)
                                ->where('is_read',2)
                                ->get()
                                ->toArray();
            $read_notice = NoticeModel::whereIn('user_id', function($query)use($user_id){
                $query->from('supp_users')->where('parent_id', $user_id)->select('user_id')->get();
            })
                                    ->where('type',1)
                                    ->where('is_read',1)
                                    ->get()
                                    ->toArray();
        }
        

        $read_list = array_merge($read_news, $read_notice);
        $read_list = array_reverse(array_sort($read_list, function($value)
        {
            return $value['updated_at'];
        }));

        $lists = array_merge($notice_list, $news);
        $lists = array_reverse(array_sort($lists, function($value)
        {
            return $value['created_at'];
        }));
        return view('news.news_list',
            ['news' => $lists,
             'read_news' => $read_list]);
    }

    public function readNews($id)
    {
        $article = ArticleModel::where('id',$id)->where('category_id',22)->first()->toArray();
        if (!$article) {
            return redirect('/news')->with('status', '文章不存在或已删除');
        }
        $is_read = NewsReadLogModel::where('article_id',$id)->where('user_id',Auth::user()->id)->first();
        if (!$is_read) {
            $log = new NewsReadLogModel;
            $log->user_id = Auth::user()->id;
            $log->article_id = $id;
            $log->save();
        }
        // 获取上一篇
        $last_article = ArticleModel::where('id','<',$id)
                                ->where('category_id',22)
                                ->select('id','article_name')
                                ->orderBy('id','desc')
                                ->first();

                               
        // 获取下一篇
        $next_article = ArticleModel::where('id','>',$id)
                                ->where('category_id',22)
                                ->select('id','article_name')
                                ->orderBy('id','asc')
                                ->first();
        if ($next_article) {
            $next_article = $next_article->toArray();
        }
        if ($last_article) {
            $last_article = $last_article->toArray();
        }
                                // 
        return view('news.news_read',
            ['article' => $article,
             'last_article' => $last_article,
             'next_article' => $next_article]);

    }
}
