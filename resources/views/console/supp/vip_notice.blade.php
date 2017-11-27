<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>新闻中心</title>
    @include('console.share.cssjs')
	<style>
	.XTxiaoxi .vip_notice{	padding-top:1px;	clear:both;	}
	.XTxiaoxi .vip_notice h3{	font-size:20px;	margin:20px 0 10px;		line-height:30px;	}
	.XTxiaoxi .vip_notice h4{	font-size:18px;	text-indent:2em;	margin:10px 0;	line-height:30px;	}
	.XTxiaoxi .vip_notice p{	text-indent:4em;	margin:0px 0;	line-height:30px;	}
	.XTxiaoxi .vip_notice p.img{	text-align:center;	text-indent:0;	}
	.XTxiaoxi .vip_notice p.img img{	max-width:100%;	}
	</style>
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
        <div class="place_ant"><a href="/console/index">首页</a><a href="/news/" class="cur">消息中心 </a></div>
    </div>
    <div class="main_o">
        <h3 class="title5 clearfix"><strong>最新消息</strong></h3>
        <div class="dhorder_m clearfix">
            <div class="XTread">
                <div class="XTxiaoxi">
                    <h1>{{ $info['article_name'] }}</h1>
                    <span>发布时间：{{ $notice_date }}  &nbsp; &nbsp;  作者：{{ $info['origin'] }}</span>
                    
					<div class="vip_notice">
						
                            {!! $info['content'] !!}
					
					</div>
					
                   {{--  <div class="sxiap"> --}}
                        {{-- <p><a href="">上一篇：xxxxxxxxxxxxx </a></p>
                        <p style="text-align:right;"><a href="">下一篇：yyyyyyyyyyyyyyyy </a></p> --}}
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>  
</div></div>


@include('console.share.admin_foot')

</body>
</html>
