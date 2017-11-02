<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>管理员首页 - 亚媒社</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    @include('console.share.cssjs')
</head>
<body>
<style>
.mingxi11 {
    width: 100%;
    float: left;
    text-align: center;
    line-height: 45px;
    color: #78b5ec;
    font-size: 18px;}
.table_in1 th{ height:45px;}
</style>

@include('console.share.admin_head')
@include('console.share.admin_menu')

         <!--    左弹菜单 管理员首页  -->

<div class="content"><div class="Invoice"><div class="INa1dd">
<div class="main">

    <!--    幻灯片 -->
	<div class="banner">
        <div class="left_banner">
            <div id="slideBox" class="slideBox">
                <div class="bd">
                    <ul>
                        <li><a href="javascript:;" target="_blank"><img src="{{url('console/img/1.jpg')}}" /></a></li>
						<li><a href="javascript:;" target="_blank"><img src="{{url('console/img/2.jpg')}}" /></a></li>
						<li><a href="javascript:;" target="_blank"><img src="{{url('console/img/3.jpg')}}" /></a></li>
                    </ul>
                </div>
                <div class="hd">
                    <ul><li>1</li><li>2</li><li>3</li></ul>
                </div>
    
                <!-- 下面是前/后按钮代码，如果不需要删除即可 -->
                <a class="prev" href="javascript:void(0)"></a>
                <a class="next" href="javascript:void(0)"></a>
            </div>
        </div>
        <!--	帐户余额	-->
        <div class="right_balance">
        	<h2>帐户余额</h2>
            <h1>{{ $all_user_money }} <span>元</span></h1>
            <a href="" class="mingxi11">查看收支明细 ></a>
             <div style="width:100%; height:110px; float:left;"></div>
        </div>
	</div>
	
	<!--	可用余额等信息	-->
	<div class="info_am clearfix margin_top_40">
		
		<div class="info_am_r">
			<ul class="clearfix">
				<li class="colcnt" style="background:#56a5ef; margin-right:2%;">
                	<span><a href="">平台订单<p>{{$order_count}}</p></a></span>
                    <div class="colcntimg"><img src="{{url('console/images/GL14.png')}}" /></div>
                </li>
				<li class="colcnt" style="background:#fca652;">
                	<span><a href="">平台资源<p>{{$supp_user_count}}</p></a></span>
                    <div class="colcntimg"><img src="{{url('console//images/GL15nt.png')}}" width="120%"/></div>
                </li>
				<li class="colcnt" style="background:#a3da85; margin-left:2%;">
                    <span><a href="">平台用户<p>{{$ads_user_count}}</p></a></span>
                    <div class="colcntimg"><img src="{{url('console//images/GL16nt.png')}}" /></div>
				</li>
			</ul>
		</div>
	</div>
	
	<!--	图表	-->
	<div class="info_am clearfix margin_top_40">
		<div class="left_tongji">
            <h3 class="title1"><strong><a >投放分布</a></strong></h3>
			<div class="tffb_m axis tb_box1" id="gli_1"></div>
			<div class="tb1_tab">
				<span class="sp1"><a class="cur" href="#">总投放</a></span>
				<ul class="clearfix">
					<li class="li2"><a href="#">网络媒体</a></li>
					<li class="li3"><a href="#">户外媒体</a></li>
					<li class="li4"><a href="#">平面媒体</a></li>
					<li class="li5"><a href="#">电视媒体</a></li>
					<li class="li6"><a href="#">广播媒体</a></li>
					<li class="li7"><a href="#">记者报料</a></li>
					<li class="li8"><a href="#">内容代写</a></li>
					<li class="li9"><a href="#">宣传定制</a></li>
				</ul>
			</div>
        </div>
        <div class="right_yonghu">
        	<div class="yonghu_list">
                <h3 class="title1"><strong><a >新用户</a></strong></h3>
                <div class="tab2_body">
                    <ul class="clearfix">
					@foreach($ads_users_list as $key => $val)
                        <li><a href="/usermanager/adsinfo/{{$val['user_id']}}" title="{{$val['nickname']}}"><img src="{{url('console/images/pic4.jpg')}}" alt="" /><p style="adisplay:none;">{{$val['nickname']}}</p></a></li>
                    @endforeach
                    </ul>
                 </div>
             </div>
             
             <div class="yonghu_list" style="margin-top:25px!important;	margin-top:25px;">
                <h3 class="title1"><strong><a >新媒体商</a></strong></h3>
                <div class="tab2_body">
                    <ul class="clearfix">
					@foreach($supp_users_list as $key => $val)
                        <li><a href="/usermanager/supps/{{$val['user_id']}}" title="{{$val['name']}}"><img 
                    src="{{url('console/images/pic4.jpg')}}" alt="" /><p style="adisplay:none;">{{$val['name']}}</p></a></li>
                    @endforeach
                    </ul>
                 </div>
             </div>
             
		 </div>
	</div>

   
    <div class="clearfix margin_top_40">
        <!--    最新受理订单  -->
        <div class="rwgl radius1">
            <h3 class="title1"><strong><a >最新受理订单</a></strong>
                <a href="/console/new_order_list" class="more">more>></a>
            </h3>
            <div class="rwgl_m">

                <div class="tab1_body">
                
    <table class="table_in1 cur">
        <thead>
            <tr>
                <th>订单号</th>
                <th>订单类型</th>
                <th>活动名称</th>
                <th>订单状态</th>       <!--    （受理，未受理）    -->
                <th>生成时间</th>
                <th>金额</th>
                <th>操作</th>         <!--    （查看）    -->
            </tr>
        </thead>
        <tbody>
            @foreach($order_list as $key => $val)
                <tr>
                    <td>{{ $val['id'] }}</td>
                    <td>{{ $val['type_name'] }}</td>
                    <td>{{ $val['title'] }}</td>
                    <td>{{ getOrderType($val['order_type']) }}</td>
                    <td>{{ $val['created_at'] }}</td>
                    <td class="color1">￥{{ $val['user_money'] }}</td>
                    <td><a href="/console/manager/order/info/{{ $val['id'] }}" class="color2">查看</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

                </div>
            </div>
        </div>
        
    </div>

    <!--    新闻中心、盈利状况、联系我们  -->
    <div class="box_1 clearfix margin_top_40">
        <div class="row3 row3_1 radius1">
            <h3 class="title2"><strong><a href="javascript:;">新闻中心</a></strong></h3>
            <ul>
               @foreach($article_new_list as $key => $val)
                    <li class="clearfix"><a href="/news/{{ $val['id'] }}" title="{{ $val['article_name'] }}">{{ $val['article_name'] }}</a><span>{{ $val['created_at'] }}</span></li>
                @endforeach
            </ul>
			<div class="mingxi"><a href="/console/article/manager" >更多 ></a></div>
            <div class="clr"></div>
        </div>
		<div class="row3 row3_2 radius1">
			<h3 class="title2"><strong><a >盈利状况</a></strong></h3>
			<ul>
				<li class="li1"><p>会员总金额<b>￥{{$ads_user_money}}</b></p></li>
				<li class="li2"><p>平台纯收益<b>￥{{$supp_user_money}}</b></p></li>
				<li class="li3"><p>供应商总金额<b>￥{{$pingtai_user_money}}</b></p></li>
			</ul>
		</div>
		<div class="row3 row3_3 radius1">
			<h3 class="title2"><strong><a >回拔电话列表</a></strong></h3>
			<div class="bd_phone">
				<div class="rwgl_m">
					<div class="tab1_body">
						<table class="table_in1 cur">
							<thead>
								<tr>
									<th>用户名</th>
									<th>用户角色</th>
									<th>联系电话</th>
									<th>状态</th>
								</tr>
							</thead>
							<tbody>
                                @foreach($phone_orders as $key => $val)
                                    <tr>
                                        <td>{{$val['name']}}</td>
                                        <td>{{$val['level_name']}}</td>
                                        <td>{{$val['contact_phone']}}</td>
                                        <td><a href="{{ $val['href'] }}" class="color2">{{$val['status']}}</a></td>
                                    </tr> 
                                @endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
            <div class="mingxi"><a href="/console/phone_order" >更多 ></a></div>
		</div>		

    </div>


    <div class="clr"></div>
</div>
</div></div></div>

@include('console.share.admin_foot')

<script type="text/javascript">
$(function(){
    
    $(".tab2 li a").click(function(){
        var index = $(this).parent().index();
        console.log(index);
        $(this).parent().addClass("cur").siblings().removeClass("cur");
        $(this).closest(".tab2").next(".tab2_body").find("ul").eq(index).css("display","block").siblings("ul").css("display","none");
        return false;
    });

    
});
</script>

</body>
</html>
