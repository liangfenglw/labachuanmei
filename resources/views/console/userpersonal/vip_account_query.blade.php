<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>账户查询_喇叭传媒</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    @include('console.share.cssjs')
    
    <style>

    </style>
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->

@include('console.share.admin_head')
@include('console.share.admin_menu')            <!--    左弹菜单 普通会员首页 -->
<div class="content"><div class="Invoice">
    @include('console.share.user_menu')

    <div class="place">
        <div class="place_ant"><a href="/">首页</a> <a href="{{url('userpersonal/account_query')}}"  class="cur">账户查询 </a></div>
    </div>
    
    <div class=" clearfix"><div class="main_aq">
           <div class="aq_left">
                <h2>账户总金额</h2>
                <h1>{{$user_all_money or '0.00'}}元</h1>
                <h2>余额</h2>
                <h1>{{$ads_user_money or '0.00'}}元</h1>
                <a href="{{url('userpersonal/onlnetop_up')}}" class="cz_left cz_left2">充 值</a>
            </div>
            <div class="aq_right">
                <div class="aq_righttop" style="height: 400px;">
                    <div class="minh tb_box6" id="tb_ptcx1"></div>
                </div>
            </div>  
    </div></div>
        {{ csrf_field() }}
    <div class="main_o clearfix margin_top_40" style="padding-bottom:0;">
        <h3 class="title3" style="padding:20px 0 0 20px;"><strong>财务明细</strong>
            <a href="/userpersonal/account_query/type/2?get_excel=1&start={{ Request::input('start') }}&end={{ Request::input('end') }}&keyword={{ Request::input('keyword') }}&mediatype={{ Request::input('mediatype') }}" class="btn_o" id="get_excel" style="float:right; margin:15px 30px 0 0;" target="_blank">导出财务明细</a>
        </h3>
        <div class="dhorder_m">
            <div class="tab1">
                <ul>       
                    <li @if(empty(Request::input('type'))) class="cur" @endif><a href="/userpersonal/account_query?type=0">订单</a></li>
                    <li @if(Request::input('type') == 3) class="cur" @endif><a href="/userpersonal/account_query?type=3">提现</a></li>
                    <li @if(Request::input('type') == 1) class="cur" @endif><a href="/userpersonal/account_query?type=1">充值</a></li>
                    <!--<li @if(Request::input('type') == 2) class="cur" @endif><a href="/userpersonal/account_query?type=2">消费</a></li>-->
                </ul>
                <div class="search_2" >
                     <form action="" method="get" name="">
                        <div class="l">
                            <span>起止时间</span>
                        </div>

                        <div class="l">
                            <input type="text" class="txt2" name="start" id="datepicker1" />-
                            <input type="text" class="txt2" name="end" id="datepicker2" />
                        </div>
                        <div class="l">
                            <select name="mediatype" class="sel1" id="mediatype">
                                @foreach($media as $key => $val)
                                    <option value="{{ $val['value'] }}">{{ $val['plate_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="l">
                            <input type="hidden" name="type" id="search_type" value="2">
                            <input type="text" name="keyword" id="keyword" class="txt5" placeholder="订单号" />
                            <input type="submit" name="submit" class="sub4_3" id="" value="查询" />
                        </div>
                    </form> 
                </div>

            </div>
            <div class="tab1_body" style="">
                <div class="tab1_body_m">
                    <table class="table_in1 cur" id="datatable1">
                        <thead>
                            <tr>
                                <th>日期</th>
                                <th>订单号</th>
                                <th>稿件类型</th>
                                <th>稿件名称</th>
                                <th>订单状态</th>
                                <th>截图/链接</th>
                                <th>金额</th>
                            </tr>
                        </thead>
                        <tbody id="listcontent4">
                            @foreach($used as $key => $val)
                                <tr>
                                    <td>{{ $val['created_at'] }}</td>
                                    <td>{{ $val['order_id'] }}</td>
                                    <td>{{ $val['type_name'] }}</td>
                                    <td>{{ $val['title'] }}</td>
                                    <td>{{ $val['order_type'] }}</td>
                                    <td>
                                        <a href="{{ $val['success_url'] }}" target="_blank">
                                            <img class="link" src="{{ $val['success_pic'] }}" alt="|" />
                                        </a>
                                        </td>
                                    <td><span class="color_red2">{{ $val['user_money'] }}元</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab1_body_m" style="display:none;">
                    <table class="table_in1 cur" id="datatable2">
                        <thead>
                            <tr>
                                <th>日期</th>
                                <th>订单号</th>
                                <th>消费方式</th>
                                <th>消费账号</th>
                                <th>状态</th>
                                <th>金额</th>
                            </tr>
                        </thead>
                        <tbody id="listcontent2">
                            @foreach($get_money as $key => $val)
                                <tr>
                                    <td>{{ $val['created_at'] }}</td>
                                    <td>{{ $val['order_sn'] }}</td>
                                    <td>{{ $val['pay_type'] }}</td>
                                    <td>{{ $val['pay_user']}}</td>
                                    <td>{{ $val['order_status'] }}</td>
                                    <td><span class="color_red2">{{ $val['user_money'] }}元</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab1_body_m" style="display:none;">
                    <table class="table_in1 cur" id="datatable3">
                        <thead>
                            <tr>
                                <th>日期</th>
                                <th>订单号</th>
                                <th>消费方式</th>
                                <th>消费账号</th>
                                <th>状态</th>
                                <th>金额</th>
                            </tr>
                        </thead>
                        <tbody id="listcontent3">
                            @foreach($charge as $key => $val)
                                <tr>
                                    <td>{{ $val['created_at'] }}</td>
                                    <td>{{ $val['order_sn'] }}</td>
                                    <td>{{ $val['pay_type'] }}</td>
                                    <td>{{ $val['pay_user'] }}</td>
                                    <td>@if($val['status'] == 1) 充值成功 @else 充值失败 @endif</td>
                                    <td><span class="color_red2">{{ $val['user_money'] }}元</span></td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div></div>

@include('console.share.admin_foot')
<script>
$(function(){
    if( $('#datepicker1').length > 0 && typeof(picker1)!="object" ){
        var picker1 = new Pikaday({
            field: document.getElementById('datepicker1'),
            firstDay: 1,
            format: "YYYY-MM-DD",
            minDate: new Date('2000-01-01'),
            maxDate: new Date('2020-12-31'),
            yearRange: [2000,2020]
        });
    }

    if( $('#datepicker2').length > 0 && typeof(picker2)!="object" ){
        var picker2 = new Pikaday({
            field: document.getElementById('datepicker2'),
            firstDay: 1,
            format: "YYYY-MM-DD",
            minDate: new Date('2000-01-01'),
            maxDate: new Date('2020-12-31'),
            yearRange: [2000,2020]
        });
    }
})
//  普通会员_账户查询—提现充值列表明细
if( $('#tb_ptcx1').length > 0 ){
    var myChart1 = echarts.init(document.getElementById('tb_ptcx1'));
    option1 = {
            title: {
                text: '发布订单的类型统计',
                textAlign: 'center',
                left: '20%',
                top: '40px',
                subTop: 'center',
                textStyle:{ fontSize: '26', color: '#505050', fontFamily: 'SimHei', fontWeight: 'normal' },
            },
            tooltip: {
                trigger: 'item',
                formatter: "<div style='font-size:16px;line-height:30px;padding:5px;'>{b} <br/> {c} ({d}%)</div>"
            },
            color:['#5D9CEC', '#FB6E52', '#FFCE55', '#A0D468', '#5F52A0', '#D48265', '#00561F', '#E2E2E2'],
            legend: {
                show: true,
                left: '45%',
                top: '20%',
                itemGap: 80,
                itemWidth: 20,
                itemHeight: 22,
                textStyle:{ fontSize: '24' },
//              data:['网络媒体']//,'户外媒体','平面媒体','电视媒体','广播媒体','记者报料','内容代写','宣传定制']
                data:['网络媒体','户外媒体','平面媒体','电视媒体','广播媒体','记者报料','内容代写','宣传定制']
            },
            grid: {
                containLabel: true
            },
            series: [
                {
                    type:'pie',
                    radius: ['45%', '60%'],
                    center: ['20%', '58%'],
                    avoidLabelOverlap: false,
                    label: {
                        normal: {
                            show: false,
                            position: 'center'
                        },
                        emphasis: {
                            show: true,
                            formatter: '{b} \n {c} \n {d}%',
                            textStyle: { fontSize: '20', fontWeight: 'bold' }
                        }
                    },
                    labelLine: {
                        normal: { show: false }
                    },
                    data:[
                        {value:{{ $order_count_all['35'] }}, name:'网络媒体'
                            ,markPoint: {
                                symbol: 'pin'
                            }
                        },
//                      {value:{{ $order_count_all['35'] }}, name:'网络媒体'},
                        {value:{{ $order_count_all['37'] }}, name:'户外媒体'},
                        {value:{{ $order_count_all['38'] }}, name:'平面媒体'},
                        {value:{{ $order_count_all['39'] }}, name:'电视媒体'},
                        {value:{{ $order_count_all['40'] }}, name:'广播媒体'},
//                      {value:{{ $order_count_all['41'] }}, name:'记者预约'},
                        {value:{{ $order_count_all['41'] }}, name:'记者报料'},
                        {value:{{ $order_count_all['42'] }}, name:'内容代写'},
                        {value:{{ $order_count_all['43'] }}, name:'宣传定制'}
                    ]
                }
            ]
    };
    myChart1.setOption(option1);
}
var _token = $('input[name="_token"]').val();

/*  表格切换分页  */
    var datatable0;
    var datatable1;
    var datatable2;
    var datatable3;
    var datatable4;
    $(function () {
            var dt_option = {
                "searching" : false,        //是否允许Datatables开启本地搜索
                "paging" : true,            //是否开启本地分页
                "pageLength" : 5,           //每页显示记录数
                "lengthChange" : false,     //是否允许用户改变表格每页显示的记录数 
                "lengthMenu": [ 5, 10, 100 ],       //用户可选择的 每页显示记录数
                "info" : true,
                "columnDefs" : [{
                    "targets": 'nosort',
                    "orderable": false
                }],
                "pagingType": "simple_numbers",
                "language": {
                    "search": "搜索",
                    sZeroRecords : "没有查询到数据",
                    "info": "显示第 _PAGE_/_PAGES_ 页，共_TOTAL_条",
                    "infoFiltered": "(筛选自_MAX_条数据)",
                    "infoEmpty": " ",
                    oPaginate: {    
                        "sFirst" : "首页",
                        "sPrevious" : "上一页",
                        "sNext" : "下一页",
                        "sLast" : "尾页"    
                    },
                    searchPlaceholder: "过滤..."
                }
                ,"order" : [[0,"desc"]]
            };
            datatable1 =  $('#datatable1').DataTable(dt_option);
            datatable2 =  $('#datatable2').DataTable(dt_option);
            datatable3 =  $('#datatable3').DataTable(dt_option);
            
            datatable0 = datatable1;
            
            $("#searchnews").click(function () {
                event.preventDefault();
                var data_table,
                    index = $(".tab1 ul li.cur").index();
                if( index == "0" ){
                    url = "/userpersonal/account_query/type/0";
                    data_table = "#datatable1";
                    data_tbody = "#listcontent1";
                    datatable0 = datatable1;
                }
                if( index == "1" ){
                    url = "/userpersonal/account_query/type/3";
                    data_table = "#datatable2";
                    data_tbody = "#listcontent2";
                    datatable0 = datatable2;
                }
                if( index == "2" ){
                    url = "/userpersonal/account_query/type/1";
                    data_table = "#datatable3";
                    data_tbody = "#listcontent3";
                    datatable0 = datatable3;
                }
                
            })
            $(".tab1 ul li a").unbind("click");     /*  取消原切换事件，改成下面的新切换事件  */
            $(".tab1>ul>li>a").click(function(){
                var index=$(this).parent("li").index();
                // 控制筛选框
                if (index == 3) { //消费
                    $("#search_type").val(2);
                    $(".search_2").show();
                } else if(index == 0) {
                    $("#search_type").val(0);
                    $(".search_2").show();
                } else {
                    $("#search_type").val(0);
                    $(".search_2").hide();
                }
                if( index == "0" ){
                    url = "/userpersonal/account_query/type/0";
                }
                if( index == "1" ){
                    url = "/userpersonal/account_query/type/3";
                }
                if( index == "2" ){
                    url = "/userpersonal/account_query/type/1";
                }
                
                url += "?start={{ Request::input('start') }}&end={{ Request::input('end') }}&keyword={{ Request::input('keyword') }}&mediatype={{ Request::input('mediatype') }}&get_excel=1";
                $("#get_excel").attr('href',url);

                $(this).parent("li").addClass("cur").siblings("li").removeClass("cur");
                $(this).parents(".tab1").next(".tab1_body").find(".tab1_body_m").css("display","none").eq(index).css("display","block");
                return false;
            });
    })

</script>

</body>
</html>
