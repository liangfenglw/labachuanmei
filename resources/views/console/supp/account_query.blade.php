<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>账户查询</title>
    @include('console.share.cssjs') 
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')
<!--    左弹菜单 供应商首页  -->
<div class="content"><div class="Invoice">
    @include('console.share.user_menu')
    <div class="place">
        <div class="place_ant"><a href="/console/index">首页</a><a href="/supp/accout_query" class="cur">账户查询 </a></div>
    </div>
    <div class=" clearfix"><div class="main_aq">
        <div class="aq_left">
            <h2>账户总金额</h2>
            <h1>{{ $all_get_money }}元</h1>
            <h2>余额</h2>
            <h1>{{ $user_money }}元</h1>
            <a href="/supp/withdraw" class="tx_right" style="margin-left:40%;">提 现</a>
        </div>
        <div class="aq_right">
            <div class="aq_righttop">
                <!--    环状图 -->
                <div class="minh tb_box5" id="tb_gyscx1"></div>
            </div>
            <div class="aq_rightbottom">
                <div class="snt" style="border-right:1px solid #ccc;"><hd>已完成订单数</hd><span>{{ $success_order_count }}</span></div>
                <div class="snt"><hd>拥有媒体资源数</hd><span>{{ $media_count }}</span></div>
            </div>
        </div>
    </div></div>
    
    <div class="main_o clearfix  margin_top_40" style="padding-bottom:0px;">
        <h3 class="title3" style="padding:20px 30px 0 20px;"><strong>财务明细</strong>
            <a href="/supp/accout_query?get_excel=1&start={{ Request::input('start') }}&end={{ Request::input('end') }}&keyword={{ Request::input('keyword') }}&mediatype={{ Request::input('mediatype') }}&get_excel=1" target="_blank" id="get_excel" class="btn_o" style="float:right; margin:5px 0 0 0;">导出财务明细</a>
        </h3>
        <div class="dhorder_m">
            <div class="tab1">
                <ul>       
                    <li @if(empty(Request::input('search_type'))) class="cur" @endif><a href="#">提现</a></li>
                    <li @if(Request::input('search_type') == 1) class="cur" @endif><a href="#">收入</a></li>
                </ul>
                <div class="search_2">
                    <form action="" method="get" name="">
                        <div class="l">
                            <span>起止时间</span>
                        </div>

                        <div class="l">
                            <input type="text" class="txt2" id="datepicker1" value="{{ Request::input('start') }}" name="start" />-<input type="text" class="txt2" name="end" id="datepicker2" value="{{ Request::input('end') }}" />
                        </div>
                        <div class="l">
                            <select name="mediatype" class="sel1" id="mediatype">
                                @foreach($plate_lists as $key => $val)
                                    <option value="{{ $val['value'] }}" @if(Request::input('mediatype') == $val['value']) @endif>{{ $val['plate_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="l">
                            <input type="hidden" name="search_type" id="search_type" value="{{ Request::input('search_type') or 0 }}">
                            <input type="text" name="keyword" id="keyword" class="txt5" value="{{ Request::input('keyword') }}" placeholder="订单号" />
                            <input type="submit" name="submit" class="sub4_3" value="查询" />
                            {{-- id="searchnews" --}}
                        </div>
                    </form>
                </div>
            </div>
            <div class="tab1_body" style="">
                <div class="tab1_body_m"  @if(Request::input('search_type') != 1) style="display:block;" @else style="display:none;" @endif>
                    <table class="table_in1 cur" id="datatable1">
                        <thead>
                            <tr>
                                <th>日期</th>
                                <th>订单号</th>
                                <th>稿件类型</th>
                                <th>稿件名称</th>
                                <th>状态</th>
                                <th>完成链接/截图</th>
                                <th>金额</th>
                            </tr>
                        </thead>
                        <tbody id="listcontent1">
                            @foreach($withdraw as $key => $value)
                                <tr>
                                    <td>{{ $value['created_at'] }}</td>
                                    <td>{{ $value['order_sn'] }}</td>
                                    <td>{{ getPayType([$value['pay_type']]) }}</td>
                                    <td>{{ $value['pay_user'] }}</td>
                                    <td>{{ getCashStatus([$value['status']]) }}</td>
                                    <td><span class="color_red2">{{ $value['user_money'] }}元</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <div class="tab1_body_m" style="display:none;">
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
                        </tbody>
                    </table>
                </div> --}}
                <div class="tab1_body_m" @if(Request::input('search_type') == 1) style="display:block;" @else style="display:none;" @endif>
                    <table class="table_in1 cur" id="datatable4">
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
                            @foreach($get_money as $key => $value)
                                <tr>
                                    <td>{{ $value['created_at'] }}</td>
                                    <td>{{ $value['order_id'] }}</td>
                                    <td>{{ $value['type_name'] }}</td>
                                    <td>{{ $value['title'] }}</td>
                                    <td>{{ ($value['order_type']) }}</td>
                                    <td>
                                        <a href="{{ $value['success_url'] }}" target="_blank">
                                        <img class="link" src="{{ $value['success_pic'] }}" alt="|"/></a>
                                    </td>
                                    <td><span class="color_red2">{{ $value['supp_money'] }}元</span></td>
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
/*  日历  */
    if( $('#datepicker1').length>0 && typeof(picker1)!="object" ){
        var picker1 = new Pikaday({
            field: document.getElementById('datepicker1'),
            firstDay: 1,
            format: "YYYY-MM-DD",
            minDate: new Date('2000-01-01'),
            maxDate: new Date('2020-12-31'),
            yearRange: [2000,2020]
        });
    }
    if( $('#datepicker2').length>0 && typeof(picker2)!="object" ){
        var picker2 = new Pikaday({
            field: document.getElementById('datepicker2'),
            firstDay: 1,
            format: "YYYY-MM-DD",
            minDate: new Date('2000-01-01'),
            maxDate: new Date('2020-12-31'),
            yearRange: [2000,2020]
        });
    }
/*  表格切换分页  */
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
            datatable4 =  $('#datatable4').DataTable(dt_option);
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
                if( index == "3" ){
                    url = "/userpersonal/account_query/type/2";
                    data_table = "#datatable4";
                    data_tbody = "#listcontent4";
                    datatable0 = datatable4;
                }
            })
            $(".tab1 ul li a").unbind("click");     /*  取消原切换事件，改成下面的新切换事件  */
            $(".tab1>ul>li>a").click(function(){
                var index=$(this).parent("li").index();
                // 控制筛选框
                if (index == 1) { //收入
                    $("#search_type").val(1);
                } else {
                    $("#search_type").val(0);
                }
                // index = $(".tab1 ul li.cur").index();
                if( index == "0" ){
                    url = "/supp/accout_query?search_type =0";
                }
                if( index == "1" ){
                    url = "/supp/accout_query?search_type=1";
                }
                if( index == "2" ){
                    url = "/supp/accout_query?search_type=1";
                }
                if( index == "3" ){
                    url = "/supp/accout_query?search_type=1";
                }
                url += "&start={{ Request::input('start') }}&end={{ Request::input('end') }}&keyword={{ Request::input('keyword') }}&mediatype={{ Request::input('mediatype') }}&get_excel=1";
                $("#get_excel").attr('href',url);

                $(this).parent("li").addClass("cur").siblings("li").removeClass("cur");
                $(this).parents(".tab1").next(".tab1_body").find(".tab1_body_m").css("display","none").eq(index).css("display","block");
                return false;
            });
    })
//  供应商 帐户查询
if( $('#tb_gyscx1').length > 0 ){
    var myChart1 = echarts.init(document.getElementById('tb_gyscx1'));
    option1 = {
            title: {
                text: '发布订单的类型统计',
                textAlign: 'center',
                left: '20%',
                top: '35px',
                textStyle:{ fontSize: '26', color: '#505050', fontFamily: 'SimHei', fontWeight: 'normal' },
            },
            tooltip: {
                trigger: 'item',
                formatter: "<div style='font-size:16px;line-height:30px;padding:5px;'>{b} <br/> {c} ({d}%)</div>"
            },
            color:['#5D9CEC', '#FB6E52', '#FFCE55', '#A0D468', '#5F52A0', '#D48265', '#00561F', '#E2E2E2'],
            legend: {
                show: true,
                left: '35%',
                top: '38%',
                itemGap: 55,
                itemWidth: 20,
                itemHeight: 22,
                textStyle:{ fontSize: '24' },
                data:['网络媒体']//,'户外媒体','平面媒体','电视媒体','广播媒体','记者报料','内容代写','宣传定制']
            },
            grid: {
                containLabel: true
            },
            series: [
                {
                    type:'pie',
                    radius: ['45%', '60%'],
                    center: ['20%', '62%'],
                    avoidLabelOverlap: false,
                    label: {
                        normal: {
                            show: false,
                            position: 'center'
                        },
                        emphasis: {
                            show: false,
                            textStyle: { fontSize: '20', fontWeight: 'bold' }
                        }
                    },
                    labelLine: {
                        normal: { show: false }
                    },
                    data:[
                        {value:{{ $order_count_all['35'] }}, name:'网络媒体'},
                        // {value:{{ $order_count_all['37'] }}, name:'户外媒体'},
                        // {value:{{ $order_count_all['38'] }}, name:'平面媒体'},
                        // {value:{{ $order_count_all['39'] }}, name:'电视媒体'},
                        // {value:{{ $order_count_all['40'] }}, name:'广播媒体'},
                        // {value:{{ $order_count_all['41'] }}, name:'记者预约'},
                        // {value:{{ $order_count_all['42'] }}, name:'内容代写'},
                        // {value:{{ $order_count_all['43'] }}, name:'宣传定制'}
                    ]
                }
            ]
    };
    myChart1.setOption(option1);
}
</script>

</body>
</html>
