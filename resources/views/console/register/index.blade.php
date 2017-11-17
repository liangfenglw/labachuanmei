<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>管理员首页_喇叭传媒</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <script type="text/javascript">
        var network_data = "{{$data_all['35']}}";
        var huwai_data = "{{$data_all['37']}}";
        var pingmian_data = "{{$data_all['38']}}";
        var dianshi_data = "{{$data_all['39']}}";
        var guangbo_data = "{{$data_all['40']}}";
        var jizhe_data = "{{$data_all['41']}}";
        var neirong_data = "{{$data_all['42']}}";
        var xuanchuan_data = "{{$data_all['43']}}";
        var toufang = "{{ $data_sum }}";
    </script> 

    @include('console.share.cssjs')
</head>
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
<body>
@include('console.share.admin_head')
@include('console.share.admin_menu')
<!--    左弹菜单 管理员首页  -->
<div class="content"><div class="Invoice"><div class="INa1dd">
<div class="main">

    <div class="banner">
       <!--	幻灯片	-->
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
        <div class="right_balance right_balance2">
        	<h2>帐户余额</h2>
            <h1>{{ $all_user_money }} <span>元</span></h1>
				{{--
			<a href="/userpersonal/onlnetop_up" class="topup">充 值</a>
            <a href="/userpersonal/account_enchashment" class="withdrawal">提 现</a>
            <a href="/userpersonal/account_query" class="mingxi">查看收支明细 ></a>
				--}}
        </div>
    </div>
    
    <!--	可用余额等信息	-->
	<div class="info_am clearfix margin_top_40">
		<div class="info_am_r">
			<ul class="clearfix">
				<li class="colcnt colcnt1" style="background:#56a5ef; margin-right:2%;">
                	<span><a href="/console/manager/order/35">订单总数<p>{{$order_count}}</p></a></span>
                    <div class="colcntimg"></div>
                </li>
				<li class="colcnt colcnt2_nt" style="background:#fca652;">
                	<span><a href="/console/add_view?blade_name=list_2">媒体总数<p>{{$supp_user_count}}</p></a></span>
                    <div class="colcntimg"></div>
                </li>
				<li class="colcnt colcnt3_nt" style="background:#a3da85; margin-left:2%;">
                    <span><a href="/user/ad_user_list">会员总数<p>{{$ads_user_count}} </p></a></span>
                    <div class="colcntimg"></div>
				</li>
			</ul>
		</div>
	</div>
   
    <div class="info_am clearfix margin_top_40">
   	 <!--	图表	-->
		<div class="left_tongji">
            <h3 class="title1"><strong><a >投放分布</a></strong></h3>
			<div class="tffb_m axis tb_box1" id="gli_1"></div>
			<div class="tb1_tab">
				<span class="sp1"><a class="cur" href="#">总投放</a></span>
				<ul class="clearfix">
					<li class="li2"><a href="javascript:;">网络媒体</a></li>
					<li class="li3"><a href="javascript:;">户外媒体</a></li>
					<li class="li4"><a href="javascript:;">平面媒体</a></li>
					<li class="li5"><a href="javascript:;">电视媒体</a></li>
					<li class="li6"><a href="javascript:;">广播媒体</a></li>
					<li class="li7"><a href="javascript:;">记者报料</a></li>
					<li class="li8"><a href="javascript:;">内容代写</a></li>
					<li class="li9"><a href="javascript:;">宣传定制</a></li>
				</ul>
			</div>
        </div>
        <!--	新会员、新媒体商-->
        <div class="right_yonghu">
        	<div class="yonghu_list">
                <h3 class="title1"><strong><a >新会员</a></strong></h3>
                <div class="tab2_body">
                    <ul class="clearfix">
                        @foreach($ads_users_list as $key => $val)
                        <li><a href="/usermanager/adsinfo/{{$val['user_id']}}" title="{{$val['nickname']}}"><img src="{{url('console/images/pic4.jpg')}}" alt="" /><p>{{$val['nickname']}}</p></a></li>
                    	@endforeach
                    </ul>
				</div>
				<a href="/user/ad_user_list" class="more_1">更多 ></a>
             </div>
             
             <div class="yonghu_list" style="margin-top:25px!important;	margin-top:25px;">
                <h3 class="title1"><strong><a >新供应商</a></strong></h3>
                <div class="tab2_body">
                    <ul class="clearfix">
                        @foreach($supp_users_list as $key => $val)
                            <li><a href="/usermanager/supps/{{$val['user_id']}}" title="{{$val['name']}}"><img 
                        src="{{url('console/images/pic4.jpg')}}" alt="" /><p>{{$val['name']}}</p></a></li>
                        @endforeach
                    </ul>
				</div>
				<a href="/usermanager/ads_list" class="more_1">更多 ></a>
             </div>
             
		 </div>
	</div>
       
    
    <div class="clearfix margin_top_40">
        <!--    最新受理订单  -->
        <div class="rwgl radius1">
            <h3 class="title1"><strong><a >订单管理</a></strong>
                <a href="/console/new_order_list" class="more">更多>></a>
            </h3>
            <div class="rwgl_m">

                <div class="tab1_body">
                    <table class="table_in1 cur">
                        <thead>
                            <tr>
                                <th>订单号</th>
                                <th>稿件类型</th>
                                <th>稿件名称</th>
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
<!--		<div class="mingxi"><a href="/console/article/manager" class="more">更多>></a></div>		-->
			<a href="/console/article/manager" class="more_1">更多 ></a>
            <div class="clr"></div>
        </div>
        <div class="row3 row3_2 radius1">
			<h3 class="title2"><strong><a >盈利状况</a></strong></h3>
			<ul>
                <li class="li1"><p>会员总金额<b>￥{{$ads_user_money}}</b></p></li>
                <li class="li2"><p>平台纯收益<b>￥{{$pingtai_user_money}}</b></p></li>
                <li class="li3"><p>供应商总金额<b>￥{{$supp_user_money}}</b></p></li>
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
			<a href="/console/phone_order" class="more_1">更多 ></a>
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
$(function(){
    /*  管理员首页 投放分布 */
if( $("#gli_1").length>0 ){
    /*  数据  */
    var opt1 = [
        { name:'总投放',   type:'line', data:[{{ $data_sum }}] },
        { name:'网络媒体', type:'line', data:[{{$data_all['35'] }}]},
        { name:'户外媒体', type:'line', data:[{{$data_all['37']}}] },
        { name:'平面媒体', type:'line', data:[{{$data_all['38']}}] },
        { name:'电视媒体', type:'line', data:[{{$data_all['39']}}] },
        { name:'广播媒体', type:'line', data:[{{$data_all['40']}}] },
        { name:'记者报料', type:'line', data:[{{$data_all['41']}}] },
        { name:'内容代写', type:'line', data:[{{$data_all['42']}}] },
        { name:'宣传定制', type:'line', data:[{{$data_all['43']}}] }
    ];
    var myChart1 = echarts.init(document.getElementById('gli_1'));
    var option1 = {
        tooltip: {
            trigger: 'axis',
            axisPointer: { type: 'line' }
        },
        color: [ '#037EF3', '#FFCE55', '#a0d468', '#fb6e52', '#48cfae', '#60d8e3', '#606fe3', '#eb943f', '#ed597f' ],
        legend: { show: false },
        grid: {
            left: '5%',
            right: '5%',
            bottom: '8%',
            containLabel: true
        },
        toolbox: {
            top: '2%',
            right: '5%',
            feature: {
                saveAsImage: {}
            }
        },
        tooltip: {
            trigger: 'item',
            formatter: "<div style='padding:10px 30px;'><p style='font-size:18px;text-align:center;line-height:24px;'>{b}份 {a}</p><p style='font-size:28px;text-align:center;line-height:36px;'>{c}</p></div>"
            },
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
        },
        yAxis: {
            type: 'value'
            ,interval: 500
            ,max: 5000
        },
        series: [
            { name:'',   type:'line', data:[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0] }
             // { name:'总投放',   type:'line', data:[300, 600, 500, 800, 1100, 1500, 2500,2000,2600,3100,3700,4500] }
        ]
    };
    option1.series[0].name = opt1[0].name;
    option1.series[0].data = opt1[0].data;
    option1.color[0] = color1[0];
    myChart1.setOption(option1);
}  
})
</script>

</body>
</html>
