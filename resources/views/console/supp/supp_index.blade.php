<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>供应商首页</title>
    <script type="text/javascript">
        var network_data = "{{$data_all['35']}}".split(',');
        var huwai_data = "{{$data_all['37']}}".split(',');
        var pingmian_data = "{{$data_all['38']}}".split(',');
        var dianshi_data = "{{$data_all['39']}}".split(',');
        var guangbo_data = "{{$data_all['40']}}".split(',');
        var jizhe_data = "{{$data_all['41']}}".split(',');
        var neirong_data = "{{$data_all['42']}}".split(',');
        var xuanchuan_data = "{{$data_all['43']}}".split(',');
        var toufang = "{{ $data_sum }}".split(',');
    </script> 
    @include('console.share.cssjs')
</head>
<body class="fhide">
@include('console.share.admin_head')
 <!--    左弹菜单 普通会员首页 -->
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
                <div class="hd"><ul><li>1</li><li>2</li><li>3</li></ul></div>
                    <!-- 下面是前/后按钮代码，如果不需要删除即可 -->
                    <a class="prev" href="javascript:void(0)"></a>
                    <a class="next" href="javascript:void(0)"></a>
            </div>
    	</div>
        <!--	帐户余额	-->
        <div class="right_balance">
        	<h2>帐户余额</h2>
            <h1>{{ $user_money }}<span>元</span></h1>
			<a href="{{url('userpersonal/onlnetop_up')}}" class="topup">充 值</a>
            <a href="/supp/withdraw" class="withdrawal" style="amargin-left: 40%;">提 现</a>
            <a href="/supp/accout_query" class="mingxi">查看收支明细 ></a>
        </div>
	</div>
    <!--	可用余额等信息	-->
	<div class="info_am clearfix margin_top_40">
		
		<div class="info_am_r">
			<ul class="clearfix">
				<li class="colcnt colcnt1" style="background:#56a5ef; margin-right:2%;">
                	<span><a href="/supp/order">我的订单<p>{{ $order_count }}</p></a></span>
                    <div class="colcntimg"></div>
                </li>
				<li class="colcnt colcnt2" style="background:#fad44f;">
                	<span><a href="/supp/resource">我的媒体<p>{{ $my_resource }}</p></a></span>
                    <div class="colcntimg"></div>
                </li>
				<li class="colcnt colcnt3" style="background:#4fd0b0; margin-left:2%;">
                    <span><a href="/supp/order">浏览足迹<p>{{ $order_count }}</p></a></span>
                    <div class="colcntimg"></div>
				</li>
			</ul>
		</div>
	</div>
    
    <!--    图表  -->
    <div class="info_am clearfix margin_top_40">
    	<div class="left_tongji">
            <h3 class="title1"><strong><a >投放分布</a></strong></h3>
            <div class="tffb_m axis tb_box1" id="gyi_1"></div>
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
					<div id="gyi_2" class="tb_box2"></div>
				</ul>
				<ul class="clearfix" style="display:none;">
					<div id="gyi_3" class="tb_box2"></div>
				</ul>
                <ul class="clearfix" style="display:none;">
					<div id="gyi_4" class="tb_box2"></div>
				</ul>
			</div>
            
            <a href="/supp/accout_query" class="mingxi">查看收支明细 ></a>
		 </div>
	</div>
  

    <!--    图表 
    <div class="tffb radius1 margin_top_40">
        <h3 class="title1"><strong><a >投放分布</a></strong></h3>
        <div class="tffb_m axis" id="tb1">
        </div>
    </div> -->
    
    <!--    任务管理    -->
    <div class="rwgl radius1 margin_top_40 clearfix" style="width:100%;float:none;">
            <h3 class="title1"><strong><a >订单管理</a></strong><a href="/supp/order" class="more">更多&gt;&gt;</a></h3>
            <div class="rwgl_m">

                <div class="tab1_body">
                
    <table class="table_in1 cur" id="datatable1">
        <thead>
            <tr>
                <th>ID号</th>
                <th>稿件类型</th>
                <th>稿件名称</th>
                <th>订单状态</th>
                <th>生成时间</th>
                <th>金额</th>
                <th class="nosort">操作</th>
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
                    <td class="color1">￥{{ $val['supp_money'] }}</td>
                    <td><a href="/supp/order/info/{{ $val['id'] }}" class="color2">查看</a></td>
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
            <h3 class="title2"><strong><a style="border-left:none;">新闻中心</a></strong></h3>
            <ul>
                @foreach($article_new_list as $key => $val)
                    <li class="clearfix"><a href="/news/{{ $val['id'] }}" title="{{ $val['article_name'] }}">{{ $val['article_name'] }}</a><span>{{ $val['created_at'] }}</span></li>
                @endforeach
            </ul>
<!--            <div class="mingxi"><a href="/news/" >更多 >></a></div>		-->
			<a href="/news/" class="more_1">更多 ></a>
            <div class="clr"></div>
        </div>
        <div class="row3 row3_2 radius1">
            <h3 class="title2"><strong><a style="border-left:none;">新增媒体</a></strong></h3>
            <div class="m_row3_2"><a href="/supp/resource">
                <img src="/console/images/xinzengziyuan.jpg" style="max-width:100%;padding-top:20px;" />
                 <p style="text-align:center; color:#ff9b3a; font-size:20px; font-weight:400; line-height:35px;">喇叭传媒邀您加入<br/><span style="font-size:30px; line-height:50px;">一起打造全新传媒生态圈！</span></p>
            </a></div>
			<a href="/supp/resource" class="more_1">更多 ></a>
        </div>
        <div class="row3 row3_3 radius1">
            <h3 class="title2"><strong><a style="border-left:none;">联系我们</a></strong></h3>
            <div class="row3_3_m">
                <p>请输入你的电话号码<br/>
                    稍后即可接到我们的来电。</p>
                <div class="callback">
                    <form>
                        <input type="button" name="submit" id="phone_order_sub" value="免费回电" class="sub3"/>
                        <div class="w_txt4">
                            <input type="text" id="phone_order_num" value="" placeholder="请输入手机号码" class="txt4" style=" width:280px" />
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
        "order" : [[3,"desc"]]
    };
    datatable =  $('#datatable1').DataTable(dt_option);
});
$(function(){
    if( $('#tb2').length > 0 ){
        var myChart2 = echarts.init(document.getElementById('tb2'));
        option2 = {
            title : { show: false },
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                orient: 'vertical',
                left: 'right',
                top: 'center',
                align: 'left',
                data: ['完成','未完成','流单','预约状态','取消']
            },
            series : [
                {
                    name: '访问来源',
                    type: 'pie',
                    radius : '80%',
                    center: ['40%', '50%'],
                    data:[
                        {value:"{{$order_status_count['success_count']}}", name:'完成'},
                        {value:"{{$order_status_count['fail_count']}}", name:'未完成'},
                        {value:"{{$order_status_count['give_up_count']}}", name:'流放'},
                        {value:"{{$order_status_count['ing_count']}}", name:'预约状态'},
                        {value:"{{$order_status_count['return_count']}}", name:'取消'}
                    ],
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };
        myChart2.setOption(option2);
    }
    // 首页投放分布
    if( $("#tb1").length>0 ){
        var myChart = echarts.init(document.getElementById('tb1'));
        // 指定图表的配置项和数据
        var dataMap = {};
        function dataFormatter(obj) {
            var pList = ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'];
            var temp;
            for (var year = 2002; year <= 2002; year++) {
                var max = 0;
                var sum = 0;
                temp = obj[year];
                for (var i = 0, l = temp.length; i < l; i++) {
                    max = Math.max(max, temp[i]);
                    sum += temp[i];
                    obj[year][i] = {
                        name : pList[i],
                        value : temp[i]
                    }
                }
                obj[year + 'max'] = Math.floor(max / 100) * 100;
                obj[year + 'sum'] = sum;
            }
            return obj;
        }

        dataMap.dataWL = dataFormatter({
             2002:[{{$data_all['35']}}] /*网络媒体*/  
        });

        dataMap.dataHW = dataFormatter({
            2002:[{{$data_all['37']}}] /*户外媒体*/  
        });

        dataMap.dataBM = dataFormatter({
            2002:[{{$data_all['38']}}] /*平面媒体*/
        });

        dataMap.dataDS = dataFormatter({
             2002:[{{$data_all['39']}}] /*电视媒体*/
        });

        dataMap.dataGB = dataFormatter({
           2002:[{{$data_all['40']}}] /*广播媒体*/
        });

        dataMap.dataJZ = dataFormatter({
           2002:[{{$data_all['41']}}] /*记者预约*/
        });

        dataMap.dataDX = dataFormatter({
            2002:[{{$data_all['42']}}] /*内容代写*/
        });

        dataMap.dataDZ = dataFormatter({
            2002:[{{$data_all['43']}}] /*宣传定制*/
        });

        option = {
            baseOption: {
                timeline: {
                    // y: 0,
                    axisType: 'category',
                    // realtime: false,
                    // loop: false,
                    autoPlay: false,
                    // currentIndex: 2,
                    playInterval: 1000,
                    // controlStyle: {
                    //     position: 'left'
                    // },
                    show:false,
                    label: {
                        formatter : function(s) {
                            return (new Date(s)).getFullYear();
                        }
                    }
                },
                title: {
                   /* subtext: '数据来自国家统计局'*/
                },
                tooltip: {},
                legend: {
                    x: 'center',
                    data: ['网络媒体', '户外媒体', '平面媒体', '电视媒体', '广播媒体', '记者预约', '内容代写', '宣传定制']
                },
                calculable : true,
                grid: {
                    top: 80,
                    bottom: 50
                },
                xAxis: [
                    {
                        'type':'category',
                        'axisLabel':{'interval':0},
                        'data':[
                            '1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'
                        ],
                        splitLine: {show: false}
                    }
                ],
                yAxis: [
                    {
                        type: 'value',
                        name: '订单数（条）'
                        ,interval: 100
                    }
                ],
                series: [
                    {name: '网络媒体', type: 'bar'},
                    {name: '户外媒体', type: 'bar'},
                    {name: '平面媒体', type: 'bar'},
                    {name: '电视媒体', type: 'bar'},
                    {name: '广播媒体', type: 'bar'},
                    {name: '记者预约', type: 'bar'},
                    {name: '内容代写', type: 'bar'},
                    {name: '宣传定制', type: 'bar'},
                    {
                        name: '分类订单占比',
                        type: 'pie',
                        center: ['85%', '35%'],
                        radius: '28%'
                    }
                ]
            },
            options: [
                {
                    /*title: {text: '2002全国宏观经济指标'},*/
                    series: [
                        {data: dataMap.dataWL['2002']},
                        {data: dataMap.dataHW['2002']},
                        {data: dataMap.dataBM['2002']},
                        {data: dataMap.dataDS['2002']},
                        {data: dataMap.dataGB['2002']},
                        {data: dataMap.dataJZ['2002']},
                        {data: dataMap.dataDX['2002']},
                        {data: dataMap.dataDZ['2002']},

                        {data: [
                            // 投放扇形图位置
                            {name: '网络媒体', value: dataMap.dataWL['2002sum']},
                            {name: '户外媒体', value: dataMap.dataHW['2002sum']},
                            {name: '平面媒体', value: dataMap.dataBM['2002sum']},
                            {name: '电视媒体', value: dataMap.dataDS['2002sum']},
                            {name: '广播媒体', value: dataMap.dataGB['2002sum']},
                            {name: '记者预约', value: dataMap.dataJZ['2002sum']},
                            {name: '内容代写', value: dataMap.dataDX['2002sum']},
                            {name: '宣传定制', value: dataMap.dataDZ['2002sum']}
                        ]}
                    ]
                }
            ]
        };
        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);  
    }
    if( $('#tb3').length > 0 ){
        var myChart3 = echarts.init(document.getElementById('tb3'));
        option3 = {
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b}: {c} ({d}%)"
            },
            color:['#1ab394', '#aaa'],
            legend: {
                show: false,
                orient: 'vertical',
                x: 'left',
                data:['可用余额','不可用余额']
            },
            series: [
                {
                    name:'余额',
                    type:'pie',
                    radius: ['70%', '84%'],
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
                        {value:{{$user_money}}, name:'可用余额'},
                        {value:{{$used_money}}, name:'不可用余额'}
                    ]
                }
            ]
        };
        myChart3.setOption(option3);    
    }
})
</script>

<script type="text/javascript">
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
// 供应商首页 订单统计 本月
if( $('#gyi_2').length > 0 ){
    var myChart2 = echarts.init(document.getElementById('gyi_2'));
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
// 供应商首页 订单统计 上月
if( $('#gyi_3').length > 0 ){
        var myChart3 = echarts.init(document.getElementById('gyi_3'));
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

// 供应商首页 订单统计 全年
if( $('#gyi_4').length > 0 ){
        var myChart4 = echarts.init(document.getElementById('gyi_4'));
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
// 供应商首页 投放分布
if( $("#gyi_1").length>0 ){
    /*  数据  */
    var opt1 = [
        { name:'总投放',   type:'line', data:[toufang[0],toufang[1],toufang[2],toufang[3],toufang[4],toufang[5],toufang[6],toufang[7],toufang[8],toufang[9],toufang[10],toufang[11]]},
        { name:'网络媒体', type:'line', data:[network_data['0'],network_data['1'],network_data['2'],network_data['3'],network_data['4'],network_data['5'],network_data['6'],network_data['7'],network_data['8'],network_data['9'],network_data['10'],network_data['11']] },
        { name:'户外媒体', type:'line', data:[huwai_data['0'],huwai_data['1'],huwai_data['2'],huwai_data['3'],huwai_data['4'],huwai_data['5'],huwai_data['6'],huwai_data['7'],huwai_data['8'],huwai_data['9'],huwai_data['10'],huwai_data['11']] },
        { name:'平面媒体', type:'line', data:[pingmian_data['0'],pingmian_data['1'],pingmian_data['2'],pingmian_data['3'],pingmian_data['4'],pingmian_data['5'],pingmian_data['6'],pingmian_data['7'],pingmian_data['8'],pingmian_data['9'],pingmian_data['10'],pingmian_data['11']] },
        { name:'电视媒体', type:'line', data:[dianshi_data['0'],dianshi_data['1'],dianshi_data['2'],dianshi_data['3'],dianshi_data['4'],dianshi_data['5'],dianshi_data['6'],dianshi_data['7'],dianshi_data['8'],dianshi_data['9'],dianshi_data['10'],dianshi_data['11']] },
        { name:'广播媒体', type:'line', data:[guangbo_data['0'],guangbo_data['1'],guangbo_data['2'],guangbo_data['3'],guangbo_data['4'],guangbo_data['5'],guangbo_data['6'],guangbo_data['7'],guangbo_data['8'],guangbo_data['9'],guangbo_data['10'],guangbo_data['11']] },
        { name:'记者报料', type:'line', data:[jizhe_data['0'],jizhe_data['1'],jizhe_data['2'],jizhe_data['3'],jizhe_data['4'],jizhe_data['5'],jizhe_data['6'],jizhe_data['7'],jizhe_data['8'],jizhe_data['9'],jizhe_data['10'],jizhe_data['11']] },
        { name:'内容代写', type:'line', data:[neirong_data['0'],neirong_data['1'],neirong_data['2'],neirong_data['3'],neirong_data['4'],neirong_data['5'],neirong_data['6'],neirong_data['7'],neirong_data['8'],neirong_data['9'],neirong_data['10'],neirong_data['11']] },
        { name:'宣传定制', type:'line', data:[xuanchuan_data['0'],xuanchuan_data['1'],xuanchuan_data['2'],xuanchuan_data['3'],xuanchuan_data['4'],xuanchuan_data['5'],xuanchuan_data['6'],xuanchuan_data['7'],xuanchuan_data['8'],xuanchuan_data['9'],xuanchuan_data['10'],xuanchuan_data['11']] }
    ];

    var myChart1 = echarts.init(document.getElementById('gyi_1'));
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
