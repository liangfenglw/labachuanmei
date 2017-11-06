<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>高级会员首页</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    @include('console.share.cssjs')
</head>
<body>
@include('console.share.admin_head')
@include('console.share.admin_menu')<!--    左弹菜单 普通会员首页 -->

<div class="content"><div class="Invoice"><div class="INa1dd">
<div class="main">

    <div class="banner">
    	<!--	幻灯片	-->
        <div class="left_banner">
            <div id="slideBox" class="slideBox">
                <div class="bd">
                    <ul>
                        <li><a href="javascript:;" target="_blank"><img src="/console/img/1.jpg" /></a></li>
                        <li><a href="javascript:;" target="_blank"><img src="/console/img/2.jpg" /></a></li>
                        <li><a href="javascript:;" target="_blank"><img src="/console/img/3.jpg" /></a></li>
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
            <h1>{{$user_money}} <span>元</span></h1>
            <a href="/userpersonal/onlnetop_up" class="topup">充 值</a>
            <a href="/userpersonal/account_enchashment" class="withdrawal">提 现</a>
            <a href="/userpersonal/account_query" class="mingxi">查看收支明细 ></a>
        </div>
	</div>
    
    <!--    可用余额等信息 -->
	<div class="info_am clearfix margin_top_40">
		<div class="info_am_r">
			<ul class="clearfix">
				<li class="colcnt" style="background:#57a5ef; margin-right:2%;">
                	<span><a href="/order/order_list">我的订单<p>{{$order_count}}</p></a></span>
                    <div class="colcntimg"><img src="/console/images/GL14.png" /></div>
                </li>
				<li class="colcnt" style="background:#a3da86;">
                	<span><a href="/userpersonal/user_manage">我的代理会员<p>{{$child_user_count}}</p></a></span>
                    <div class="colcntimg"><img src="/console/images/GL16nt.png" width="120%"/></div>
                </li>
				<li class="colcnt" style="background:#4fd0b1; margin-left:2%;">
                    <span><a href="/order/order_list">代理会员总单<p>{{ $child_order_num }}</p></a></span>
                    <div class="colcntimg"><img src="/console/images/GL16.png" /></div>
				</li>
			</ul>
		</div>
	</div>

   	<!--	图表	-->
	<div class="info_am clearfix margin_top_40">
    	<div class="left_tongji">
            <h3 class="title1"><strong><a >投放分布</a></strong></h3>
			<div class="tffb_m axis tb_box1" id="gji_1"></div>
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
        <div class="right_tongji">
        	
            <div class="tab2">
            	<h4 style="line-height: 76px;color: #505050; float:left;text-decoration: none;font-size: 24px;padding-left: 23px;">订单统计</h4>
				<ul class="clearfix" style="float:left;">
					<li class="cur"><a href="javascript:void(0)">本月</a></li>
					<li><a href="javascript:void(0)">上月</a></li>
                    <li><a href="javascript:void(0)">全年</a></li>
				</ul>
			</div>
			<div class="tab2_body">
				<ul class="clearfix" style="display:block;">
					<div id="gji_2" class="tb_box2"></div>
				</ul>
				<ul class="clearfix" style="display:none;">
					<div id="gji_3" class="tb_box2"></div>
				</ul>
                <ul class="clearfix" style="display:none;">
					<div id="gji_4" class="tb_box2"></div>
				</ul>
			</div>
            
            <a href="/userpersonal/account_query" class="mingxi">查看收支明细 ></a>
		 </div>
	</div>
    <!--    任务管理    -->
    <div class="rwgl radius1 margin_top_40 clearfix" style="width:100%;float:none;">
            <h3 class="title1"><strong><a >订单管理</a></strong><a href="/order/order_list" class="more">更多&gt;&gt;</a></h3>
            <div class="rwgl_m">

                <div class="tab1_body">
                
    <table class="table_in1 cur" id="datatable1">
        <thead>
            <tr>
                <th>ID号</th>
                <th>稿件类型</th>
                <th>稿件名称</th>
                <th>订单状态</th>       <!--    （受理，未受理）    -->
                <th>生成时间</th>
                <th>金额</th>
                <th class="nosort">操作</th>          <!--    （查看）    -->
            </tr>
        </thead>
        <tbody>
            @foreach($order_list as $key => $val)
                <tr>
                    <td>{{ $val['id'] }}</td>
                    <td>{{ $val['type_name'] }}</td>
                    <td>{{ $val['parent_order']['title'] }}</td>
                    <td>{{ getOrderType($val['order_type']) }}</td>
                    <td>{{ $val['created_at'] }}</td>
                    <td class="color1">￥{{ $val['user_money'] }}</td>
                    <td><a href="/order/order_detail/{{ $val['id'] }}" class="color2">查看</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

                </div>
            </div>
    </div>

    <!--    新闻中心、盈利状况、联系我们  -->
    <div class="box_1 clearfix margin_top_40">
        <div class="row3 row3_1 radius1">
        {{-- more&gt;&gt; --}}
            <h3 class="title2"><strong><a>新闻中心</a></strong></h3>
            <ul>
                @foreach($article_new_list as $key => $val)
                    <li class="clearfix"><a href="/news/{{ $val['id'] }}" title="{{ $val['article_name'] }}">{{ $val['article_name'] }}</a><span>{{ $val['created_at'] }}</span></li>
                @endforeach
            </ul>
           <div class="mingxi"> <a href="/news/" class="more">更多>></a></div>
            <div class="clr"></div>
        </div>
        <div class="row3 row3_2 radius1">
            <h3 class="title2"><strong><a>盈利状况</a></strong></h3>
            <ul>
                <li class="li1"><p>分销会员总收益<b>￥{{ $vip_all }}</b></p></li>
                <li class="li2"> <p>纯分销收益<b>￥{{ $parent_commision }}</b></p></li>
                <li class="li3"><p>占账户总金率<b>{{ $parent_commision / $user_money }}</b></p></li>
            </ul>
        </div>
        <div class="row3 row3_3 radius1">
            <h3 class="title2"><strong><a >联系我们</a></strong></h3>
            <div class="row3_3_m">
                <p>请输入你的电话号码<br/>
                    稍后即可接到我们的来电。</p>
                <div class="callback">
                    <form>
                        <input type="button" name="submit" id="phone_order_sub" value="免费回电" class="sub3" />
                        <div class="w_txt4">
                            <input type="text" id="phone_order_num" value="" placeholder="请输入手机号码" class="txt4" />
                        </div>  
                    </form>
                </div>
                <p style="color:#FF8400;">该通话对您免费，请放心接听。</p>
                <p>手机请直接输入<br/>座机前请加区号</p>
            </div>
        </div>
    </div>


    <div class="clr"></div>
</div>
</div></div></div>

@include('console.share.admin_foot')

<script type="text/javascript">
$(function(){
    
    /*  任务管理 分页 */
    var datatable;
    var dt_option = {
        "searching" : false,        //是否允许Datatables开启本地搜索
        "paging" : true,            //是否开启本地分页
        "pageLength" : 5,           //每页显示记录数
        "lengthChange" : false,     //是否允许用户改变表格每页显示的记录数 
        "lengthMenu": [ 5, 10, 100 ],       //用户可选择的 每页显示记录数
        "info" : true,
        "columnDefs" : {
            "targets": 'nosort',
            "orderable": false
        },
        "pagingType": "simple_numbers",
        "language": {
            "search": "搜索",
            "sZeroRecords" : "没有查询到数据",
            "info": "显示第 _PAGE_/_PAGES_ 页，共_TOTAL_条派单订单",
            "infoFiltered": "(筛选自_MAX_条数据)",
            "infoEmpty": "没有符合条件的数据",
            "oPaginate": {    
                "sFirst" : "首页",
                "sPrevious" : "上一页",
                "sNext" : "下一页",
                "sLast" : "尾页"    
            },
            "searchPlaceholder": "过滤..."
        },
        "order" : [[0,"desc"]]
    };
    datatable =  $('#datatable1').DataTable(dt_option);

});
$(function(){

})
$(function(){
	$(".tab2 li a").click(function(){
		var index = $(this).parent().index();
		var in2 = index + 2;
		$(this).parent().addClass("cur").siblings().removeClass("cur");
		$(this).closest(".tab2").next(".tab2_body").find("ul").eq(index).css("display","block").siblings("ul").css("display","none");
		eval( "myChart" + in2 + ".resize()" );
		return false;
	});
	
});
if( $('#gji_2').length > 0 ){
    var myChart2 = echarts.init(document.getElementById('gji_2'));
    var option2 = {
            title: {
                text: '本月订单',
                subtext: "{{ $order_status_count['now_success_count'] + $order_status_count['now_give_up_count'] + $order_status_count['now_return_count'] + $order_status_count['now_ing_count'] + $order_status_count['now_fail_count'] }}",
                left: 'center',
                top: '36%',
                textStyle:{ fontSize: '30' },
                subtextStyle:{ fontSize: '30', color: '#000', fontWeight: 'bold' },
                itemGap: 10
            },
            tooltip: {
                trigger: 'item',
                formatter: "<div style='padding:10px 30px;'><p style='font-size:18px;text-align:center;line-height:24px;'>{b}</p><p style='font-size:28px;text-align:center;line-height:36px;'>{c}</p></div>"
            },
            color:['#5d9cec', '#fb6e52','#ffce55','#a0d468','#e2e2e2'],
            legend: {
                show: true,
                orient: 'horizontal',
                x: 'center',
                y: 'bottom',
                itemGap: 45,
                itemWidth: 20,
                itemHeight: 22,
                textStyle:{ fontSize: '22' },
                data:['已完成','流单','退还','预约','未完成']
            },
            grid: {
                containLabel: true
            },
            series: [
                {
                    name:'余额',
                    type:'pie',
                    radius: ['60%', '80%'],
                    center: ['50%', '42%'],
                    avoidLabelOverlap: false,
                    label: {
                        normal: {
                            show: false,
                            position: 'center'
                        },
                        emphasis: {
                            show: false,
                            textStyle: {
                                fontSize: '20',
                                fontWeight: 'bold'
                            }
                        }
                    },
                    labelLine: {
                        normal: {
                            show: false
                        }
                    },
                    data:[
                        {value:"{{ $order_status_count['now_success_count'] }}", name:'已完成'},
                        {value:"{{ $order_status_count['now_give_up_count'] }}", name:'流单'},
                        {value:"{{ $order_status_count['now_return_count'] }}", name:'退还'},
                        {value:"{{ $order_status_count['now_ing_count'] }}", name:'预约'},
                        {value:"{{ $order_status_count['now_fail_count'] }}", name:'未完成'}
                    ]
                }
            ]
    };
    myChart2.setOption(option2);
}
if( $('#gji_3').length > 0 ){
        var myChart3 = echarts.init(document.getElementById('gji_3'));
        var option3 = {
            title: {
                text: '上月订单',
                subtext: "{{ $order_status_count['last_success_count'] + $order_status_count['last_give_up_count'] + $order_status_count['last_return_count'] + $order_status_count['last_ing_count'] + $order_status_count['last_fail_count'] }}",
                left: 'center',
                top: '36%',
                textStyle:{ fontSize: '30' },
                subtextStyle:{ fontSize: '30', color: '#000', fontWeight: 'bold' },
                itemGap: 10
            },
            tooltip: {
                trigger: 'item',
                formatter: "<div style='padding:10px 30px;'><p style='font-size:18px;text-align:center;line-height:24px;'>{b}</p><p style='font-size:28px;text-align:center;line-height:36px;'>{c}</p></div>"
            },
            color:['#5d9cec', '#fb6e52','#ffce55','#a0d468','#e2e2e2'],
            legend: {
                show: true,
                orient: 'horizontal',
                x: 'center',
                y: 'bottom',
                itemGap: 45,
                itemWidth: 20,
                itemHeight: 22,
                textStyle:{ fontSize: '22' },
                data:['已完成','流单','退还','预约','未完成']
            },
            grid: {
                containLabel: true
            },
            series: [
                {
                    name:'余额',
                    type:'pie',
                    radius: ['60%', '80%'],
                    center: ['50%', '42%'],
                    avoidLabelOverlap: false,
                    label: {
                        normal: {
                            show: false,
                            position: 'center'
                        },
                        emphasis: {
                            show: false,
                            textStyle: {
                                fontSize: '20',
                                fontWeight: 'bold'
                            }
                        }
                    },
                    labelLine: {
                        normal: {
                            show: false
                        }
                    },
                    data:[
                        {value:"{{ $order_status_count['last_success_count'] }}", name:'已完成'},
                        {value:"{{ $order_status_count['last_give_up_count'] }}", name:'流单'},
                        {value:"{{ $order_status_count['last_return_count'] }}", name:'退还'},
                        {value:"{{ $order_status_count['last_ing_count'] }}", name:'预约'},
                        {value:"{{ $order_status_count['last_fail_count'] }}", name:'未完成'}
                    ]
                }
            ]
        };
        myChart3.setOption(option3);
}
if( $('#gji_4').length > 0 ){
        var myChart4 = echarts.init(document.getElementById('gji_4'));
        var option4 = {
            title: {
                text: '今年订单',
                subtext: "{{ $order_status_count['success_count'] + $order_status_count['give_up_count'] + $order_status_count['return_count'] + $order_status_count['ing_count'] + $order_status_count['fail_count'] }}",
                left: 'center',
                top: '36%',
                textStyle:{ fontSize: '30' },
                subtextStyle:{ fontSize: '30', color: '#000', fontWeight: 'bold' },
                itemGap: 10
            },
            tooltip: {
                trigger: 'item',
                formatter: "<div style='padding:10px 30px;'><p style='font-size:18px;text-align:center;line-height:24px;'>{b}</p><p style='font-size:28px;text-align:center;line-height:36px;'>{c}</p></div>"
            },
            color:['#5d9cec', '#fb6e52','#ffce55','#a0d468','#e2e2e2'],
            legend: {
                show: true,
                orient: 'horizontal',
                x: 'center',
                y: 'bottom',
                itemGap: 45,
                itemWidth: 20,
                itemHeight: 22,
                textStyle:{ fontSize: '22' },
                data:['已完成','流单','退还','预约','未完成']
            },
            grid: {
                containLabel: true
            },
            series: [
                {
                    name:'余额',
                    type:'pie',
                    radius: ['60%', '80%'],
                    center: ['50%', '42%'],
                    avoidLabelOverlap: false,
                    label: {
                        normal: {
                            show: false,
                            position: 'center'
                        },
                        emphasis: {
                            show: false,
                            textStyle: {
                                fontSize: '20',
                                fontWeight: 'bold'
                            }
                        }
                    },
                    labelLine: {
                        normal: {
                            show: false
                        }
                    },
                    data:[
                        {value:"{{ $order_status_count['success_count'] }}", name:'已完成'},
                        {value:"{{ $order_status_count['give_up_count'] }}", name:'流单'},
                        {value:"{{ $order_status_count['return_count'] }}", name:'退还'},
                        {value:"{{ $order_status_count['ing_count'] }}", name:'预约'},
                        {value:"{{ $order_status_count['fail_count'] }}", name:'未完成'}
                    ]
                }
            ]
        };
        myChart4.setOption(option4);
}
if( $("#gji_1").length>0 ){
    /*  数据  */
    var opt1 = [
        { name:'总投放',   type:'line', data:[{{ $data_sum }}] },
        { name:'网络媒体', type:'line', data:[{{$data_all['35']}}] },
        { name:'户外媒体', type:'line', data:[{{$data_all['37']}}] },
        { name:'平面媒体', type:'line', data:[{{$data_all['38']}}] },
        { name:'电视媒体', type:'line', data:[{{$data_all['39']}}] },
        { name:'广播媒体', type:'line', data:[{{$data_all['40']}}] },
        { name:'记者报料', type:'line', data:[{{$data_all['41']}}] },
        { name:'内容代写', type:'line', data:[{{$data_all['42']}}] },
        { name:'宣传定制', type:'line', data:[{{$data_all['43']}}] }
    ];

    var myChart1 = echarts.init(document.getElementById('gji_1'));
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
        ]
    };
    option1.series[0].name = opt1[0].name;
    option1.series[0].data = opt1[0].data;
    option1.color[0] = color1[0];
    myChart1.setOption(option1);
}
</script>


</body>
</html>
