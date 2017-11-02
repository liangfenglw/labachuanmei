<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>可否申请开具发票，开具何种发票？ - 帮助中心 - 亚媒社</title>
    @include('console.share.cssjs')
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')
<!--    左弹菜单 普通会员首页 -->


<div class="content"><div class="Invoice"><div class="INa1dd">
<div class="main">

    <div class="banner">
        <img src="/console/images/banner_help.jpg" width="100%" />
    </div>
    
    <div class="place">
        当前位置：<a href="/console/index">首页</a> > 帮助中心
    </div>

    <div class="wrap_h">
        <div class="side_h">
            @foreach($category_list as $key => $val)
                <h3><strong>{{ $category_type[$val['0']['type_id']] }}</strong></h3>
                <ul>
                    @foreach($val as $kk => $vv)
                        <li @if($info['category_id'] == $vv['id']) class="cur" @endif><a href="/help?id={{ $vv['id'] }}">{{ $vv['category_name'] }}</a></li>
                    @endforeach
                </ul>
            @endforeach
        </div>
        
        <div class="main_h">
            
            <h3 class="title_main_h">{{ $info['article_name'] }}</h3>
            <div class="content_main_h">
                {!! $info['content'] !!}
            </div>

        </div>
    
    </div>

    <div class="clr"></div>
</div>
</div></div></div>

@include('console.share.admin_menu')

<script type="text/javascript">

//  $(".logo").addClass("hidden");
$(function(){
//  $(".sidebar-open-button").click();
});

</script>

</body>
</html>
