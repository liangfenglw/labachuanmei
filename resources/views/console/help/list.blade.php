<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>帮助中心_喇叭传媒</title>
    @include('console.share.cssjs')
</head>

<body class="fold">         <!--    class="fold" 左导航收缩  -->
    @include('console.share.admin_head')
    @include('console.share.admin_menu')
    <!--    左弹菜单 普通会员首页 -->
<div class="content"><div class="Invoice">
<div class="main">
    <div class="banner_ntimg"><img src="/console/images/banner_help.jpg" width="100%" /></div>
    
    <div class="place">
         <div class="place_ant"><a href="/">首页</a><a href="/help/"  class="cur">帮助中心 </a></div>
    </div>

    <div class="wrap_h">
		<div class="side_h">
            @foreach($category_list as $key => $val)
                <h3><strong>{{ $category_type[$val['0']['type_id']] }}</strong></h3>
                <ul>
                    @foreach($val as $kk => $vv)
                        <li @if($catid == $vv['id']) class="cur" @endif><a href="/help?id={{ $vv['id'] }}">{{ $vv['category_name'] }}</a></li>
                    @endforeach
                </ul>
            @endforeach
        </div>
        
        <div class="main_h">
            <ul class="list_mian_h">
                @foreach($article_list as $key => $val)
                    <li><a href="/help/{{ $val['id'] }}">【{{ $category_type[$val['type_id']] }}】{{ $val['article_name'] }}</a></li>
                @endforeach
            </ul>
            <div class="page_1 page_1_2" style="margin-top:70px;text-align:center;">
               
                    {!! $article_list->appends(['id' => $catid])->render() !!}
                
            </div>
        </div>
   
    </div>

    <div class="clr"></div>
</div>
</div></div>
@include('console.share.admin_foot')
<script type="text/javascript">
//  $(".logo").addClass("hidden");
$(function(){
//  $(".sidebar-open-button").click();
});

</script>

</body>
</html>
