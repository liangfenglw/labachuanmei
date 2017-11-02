<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>新闻中心</title>
    @include('console.share.cssjs')
</head>
<body class="fold">
@include('console.share.admin_head')
@include('console.share.admin_menu')
<!--    左弹菜单 普通会员首页 -->
<div class="content"><div class="Invoice">
    <div class="banner2">
        <img src="/console/images/banner_news.jpg" width="100%">
    </div>
    
    <div class="place">
        <div class="place_ant"><a href="/console/index">首页</a><a href="/news/" class="cur">新闻中心 </a></div>
    </div>
    <div class="main_o">
        <h3 class="title5 clearfix"><strong>最新消息</strong></h3>
        <div class="dhorder_m clearfix">
            <div class="XTread">
                <div class="XTxiaoxi">
                    <h1>{{$article['article_name']}}</h1>
                    <span>发布时间：{{$article['created_at']}}  作者：{{$article['origin']}}</span>
                    {!! $article['content'] !!}
                    <div class="sxiap">
                        <p>@if($last_article) <a href="/news/{{ $last_article['id'] }}">上一篇：{{$last_article['article_name']}} </a> @endif</p>
                        <p style="text-align:right;">@if($next_article) <a href="/news/{{ $next_article['id'] }}">下一篇：{{$next_article['article_name']}} </a> @endif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div></div>


@include('console.share.admin_foot')

</body>
</html>
