<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>高级会员首页 - 亚媒社</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    @include('console.share.cssjs')
</head>
<body>
@include('console.share.admin_head')
@include('console.share.admin_menu')<!--    左弹菜单 普通会员首页 -->

<div class="content"><div class="Invoice"><div class="INa1dd">
<div class="main">

    <!--    幻灯片 -->
    <div class="banner">
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


    <!--    可用余额等信息 -->
    <div class="info_am clearfix margin_top_40">
        <div class="info_am_l clearfix">
            <div class="circle1">
                <h4>可用余额</h4>
                <p>{{$user_money}}</p>
                <!--    图表  -->
                <div id="tb3">
                
                </div>
            </div>
            <ul class="clearfix">
                <li class="col-3"><a href="/userpersonal/account_query"><img src="/console/images/ico_yue.png" />账户余额</a></li>
                <li class="col-3"><a href="/userpersonal/account_enchashment"><img src="/console/images/ico_tixian.png" />申请提现</a></li>
                <li class="col-3"><a href="/userpersonal/account_query"><img src="/console/images/ico_mingxi.png" />收支明细</a></li>
            </ul>
        </div>
        <div class="info_am_r">
            <ul class="clearfix">
                <li class="col-3"><div class="circle2"><img src="/console/images/ico_dingdan.png" /><i>{{$order_count}}</i></div>
                    <h4><a href="/order/order_list">我的订单</a></h4>
                    <p><a href="javascript:;">查看全部订单</a></p></li>
                <li class="col-3"><div class="circle2"><img src="/console/images/ico_dailihuiyuan.png" /><i>{{$child_user_count}}</i></div>
                    <h4><a href="/userpersonal/user_manage">我的代理会员</a></h4>
                    <p>拥有会员数量</p></li>
                <li class="col-3">
                    <div class="circle3">
                        <!--    图表  -->
                        <div id="tb2">
                            
                        </div>
                    </div>
                    <h4><a href="javascript:;">订单统计</a></h4>
                    <p>{{ $month }}/月</p></li>
            </ul>
        </div>
    </div>

    <!--    图表  -->
    <div class="tffb radius1 margin_top_40">
        <h3 class="title1"><strong><a >投放分布</a></strong></h3>
        <div class="tffb_m axis" id="tb1">
        </div>
    </div>
    
    <!--    任务管理    -->
    <div class="rwgl radius1 margin_top_40 clearfix" style="width:100%;float:none;">
            <h3 class="title1"><strong><a >任务管理</a></strong><a href="/order/order_list" class="more">more&gt;&gt;</a></h3>
            <div class="rwgl_m">

                <div class="tab1_body">
                
    <table class="table_in1 cur" id="datatable1">
        <thead>
            <tr>
                <th>ID号</th>
                <th>订单类型</th>
                <th>活动名称</th>
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
            <h3 class="title2"><strong><a>新闻中心</a></strong><a href="/news/" class="more"></a></h3>
            <ul>
                @foreach($article_new_list as $key => $val)
                    <li class="clearfix"><a href="/news/{{ $val['id'] }}" title="{{ $val['article_name'] }}">{{ $val['article_name'] }}</a><span>{{ $val['created_at'] }}</span></li>
                @endforeach
            </ul>
            <div class="clr"></div>
        </div>
        <div class="row3 row3_2 radius1">
            <h3 class="title2"><strong><a>盈利状况</a></strong></h3>
            <ul>
                <li class="li1">
                    <p>分销会员总收益<br>
                        <b>￥{{ $vip_all }}</b></p>
                    <span></span></li>
                <li class="li2">
                    <p>纯分销收益<br>
                        <b>￥{{ $parent_commision }}</b></p>
                    <span></span></li>
                <li class="li3">
                    <p>占账户总金率<br>
                        <b>￥{{ $parent_commision / $user_money }}</b></p>
                    <span></span></li>
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

</body>
</html>
