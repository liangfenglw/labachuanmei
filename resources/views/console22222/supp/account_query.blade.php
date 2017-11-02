<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('console.share.cssjs') 
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')
<!--    左弹菜单 供应商首页  -->
<div class="content"><div class="Invoice">
    @include('console.share.user_menu')
    <div class="place">
        当前位置：<a href="/console/index">首页</a> > 账户查询
    </div>
    <div class="main_aq">
        <h3 class="title3"><strong>账户详情</strong>
            <a href="javascript:;"><img class="title3_img" src="{{url('console/images/arr_s.png')}}" alt="" /></a>
            <span class="title3_i"></span>
        </h3>
        <div class="clearfix " >
            <!--    柱状图 -->
            <div class="r minh" id="tb_aq1"></div>
            <div class="account_0">
                <ul>
                    <li><p>账户总金额：</p><span>￥{{ $all_get_money }}元</span></span></li>
                    <li><p>余额：</p><span>￥{{ $user_money }}元</span></span></li>
                </ul>
                <a href="/supp/withdraw" class="account_1">提 现</a>
            </div>
            <div class="account_3">
                <div class="account_5" style="border-top:none;">
                    <div class="account_6"><img src="/console/images/aq2_0.png"></div>
                    <p>拥有媒体资源数：<span>{{ $media_count }}个</span></p>
                </div>
                <div class="account_5">
                    <div class="account_6"><img src="/console/images/aq2.png"></div>
                    <p>已完成订单数：<span>{{ $success_order_count }}个</span></p>
                </div>
            </div>
            <!--    柱状图 -->
            <div class="r minh" id="tb_aq2"></div>
        </div>      
    </div>


    <div class="main_o clearfix" style="padding-bottom:0px;">
        <h3 class="title3" style="padding:20px 30px 0 20px;"><strong>财务明细</strong>
            <a href="javascript:;"><img class="title3_img" src="/console/images/arr_s.png" alt=""></a>
            <span class="title3_i"></span>
        </h3>
        <div class="dhorder_m">
            <div class="tab1">
                <ul>       
                    <li class="cur"><a href="#">提现</a></li>
                    <li><a href="#">收入</a></li>
                </ul>
                <div class="search_2">
                    <form action="" method="" name="">
                        <div class="l">
                            <span>起止时间</span>
                        </div>

                        <div class="l">
                            <input type="text" class="txt2" id="datepicker1" />-<input type="text" class="txt2" id="datepicker2" />
                        </div>
                        <div class="l">
                            <select name="" class="sel1" id="mediatype">
                                <option value="0">请选择</option>
                                @foreach($plate_lists as $key => $val)
                                    <option value="{{ $val['id'] }}">{{ $val['plate_name'] }}</option>
                                @endforeach
                                
                            </select>
                        </div>
                        <div class="l">
                            <input type="text" name="keyword" id="keyword" class="txt5" placeholder="订单号" />
                            <input type="button" name="submit" class="sub4_3" id="searchnews" value="查询" />
                        </div>
                    </form>
                </div>
                <a href="/supp/accout_query?get_excel=1" target="_blank" id="get_excel" class="sub4_2" style="float:right; margin:15px 30px 0 0;">导出财务明细</a>
            </div>
            <div class="tab1_body" style="">
                <div class="tab1_body_m" style="display:block;">
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
                    <table class="table_in1 cur" id="datatable4">
                        <thead>
                            <tr>
                                <th>日期</th>
                                <th>订单号</th>
                                <th>订单类型</th>
                                <th>订单名称</th>
                                <th>订单状态</th>
                                <th>截图/链接</th>
                                <th>金额</th>
                            </tr>
                        </thead>
                        <tbody id="listcontent4">
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

/*  饼状图 */
if( $('#tb_aq1').length > 0 ){
    var myChart_hv2 = echarts.init(document.getElementById('tb_aq1'));
    option_hv2 = {
        title : {
            text: '',
            subtext: '',
            x:'center',
            y:'bottom',
            textStyle:{
                fontSize: '14',
                color: '#c23531',
                fontWeight: 'normal'
            }
        },
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            orient: 'vertical',
            left: 'left',
            data: []
        },
        series : [
            {
                name: '访问来源',
                type: 'pie',
                radius : '45%',
                center: ['50%', '55%'],
                data:[
                    {value:"{{$all_get_money}}", name:'总金额'},
                    {value:"{{$user_money}}", name:'余额'},
                    {value:"{{$all_withdraw}}", name:'提现金额'},
                    // {value:135, name:'消费金额'}
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
    myChart_hv2.setOption(option_hv2);
}
    
</script>
<script>
/*  饼状图 */
if( $('#tb_aq2').length > 0 ){
    var myChart_hv2 = echarts.init(document.getElementById('tb_aq2'));
    option_hv2 = {
        title : {
            text: '受理成功的订单统计',
            subtext: '',
            x:'center',
            y:'top',
            textStyle:{
                fontSize: '18',
                color: '#474747',
                fontWeight: 'normal'
            }
        },
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            orient: 'vertical',
            left: 'left',
            data: []
        },
        series : [
            {
                name: '访问来源',
                type: 'pie',
                radius : '45%',
                center: ['50%', '55%'],
                data:[
                    @foreach($data as $key => $val)
                        {value:"{{$val['order_count']}}", name:"{{ $val['plate_name'] }}"},
                    @endforeach
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
    myChart_hv2.setOption(option_hv2);
}
    
</script>
<script>
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
                    "infoEmpty": "没有符合条件的数据",
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
            $("#searchnews").click(function () {
                event.preventDefault();
                get_account_list();
            })
        $(function(){
            get_account_list(0);
        })
        var query_type = 1;
        function get_account_list() {
            var data_table,
            index = $(".tab1 ul li.cur").index();
            if (query_type == 0) {
                data_table = "#datatable4";
                data_tbody = "#listcontent4";
                datatable0 = datatable1;
            } else {
                data_table = "#datatable2";
                data_tbody = "#listcontent2";
                datatable0 = datatable1;
            }
            $.ajax({
                    type:"get",
                    url:"/supp/accout_query",
                    dataType: 'html',
                    data:{
                        'start':$("#datepicker1").val(),
                        'end':$("#datepicker2").val(),
                        'mediatype':$("#mediatype").val(),
                        'keytype':$("#keytype").val(),
                        'orderid':$("#keyword").val(),
                        'query_type':query_type,
                    },
                    success:function (msg) {
                        msg = $.trim(msg);
                        if(msg){
                            if( $.fn.dataTable.isDataTable(data_table) ){
                                // datatable0.destroy();
                            }
                            $(data_tbody).html(msg);
                            // datatable0 =  $(data_table).DataTable(dt_option);
                        } else {
                            if( $.fn.dataTable.isDataTable(data_table) ){
                                // datatable0.destroy();
                            }
                            $(data_tbody).html("<tr><td colspan='8'>没有查询到数据！</td></tr>");           //7 表格列数
                        }
                        var hrefs = '/supp/accout_query?get_excel=1';
                        hrefs += "&start="+$("#datepicker1").val();
                        hrefs += "&end="+$("#datepicker2").val();
                        hrefs += "&mediatype="+$("#mediatype").val();
                        hrefs += "&keytype="+$("#keytype").val();
                        hrefs += "&orderid="+$("#keyword").val();
                        hrefs += "&query_type="+query_type;
                        $("#get_excel").attr('href',hrefs);
                        // if( index == "0" ){ datatable2 = datatable0;    }
                        // if( index == "2" ){ datatable3 = datatable0;    }
                        // if( index == "3" ){ datatable4 = datatable0;    }
                    }
                    
                })
        }
            
        $(".tab1 ul li a").unbind("click");     /*  取消原切换事件，改成下面的新切换事件  */
        $(".tab1>ul>li>a").click(function(){
            var index=$(this).parent("li").index();
            if (query_type == 1) {


                query_type = 0;
            } else {
                query_type = 1;
            }
            get_account_list();
            $(this).parent("li").addClass("cur").siblings("li").removeClass("cur");
            $(this).parents(".tab1").next(".tab1_body").find(".tab1_body_m").css("display","none").eq(index).css("display","block");
            return false;
        });
    })
</script>

</body>
</html>
