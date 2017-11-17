<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>添加管理员_喇叭传媒</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    @include('console.share.cssjs')
</head>
<body class="fold">
@include('console.share.admin_head')
@include('console.share.admin_menu')<!--    左弹菜单 普通会员首页 -->
<div class="content">
    <div class="Invoice">
        <div class="place">
            <div class="place_ant"><a href="/console/index">首页</a> <a href="/usermanager/adminuser/list" class="cur">管理员列表</a></div>
        </div>
        <div class="main_o clearfix" style="padding-bottom:20px; min-height:650px;">
            <h3 class="title4 clearfix"><strong><a>添加管理员</a></strong></h3>
            <div class="safe_1 clearfix">
                <div class="wrap_fl clearfix" style="width: 50%">
                    <form action="/usermanager/adminuser/add" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="user_id" value="">
                        <div class="item_f"><p><i class="LGntas"></i>用户名：</p>
                            <div class="r"><input type="text" name="name" id="textfield" class="txt_f1" style="width:75%;" value=""></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>用户组：</p>
                            <div class="r">
                                <select class="sel_f1" style="min-width:150px;width:50%;" name="level_id" onchange="getCategory(this);">
                                    @foreach($role as $key => $value)
                                        <option value="{{ $value['id'] }}">{{ $value['level_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>新密码：</p>
                            <div class="r"><input type="text" name="newpwd" class="txt_f1" style="width:75%;"></div>
                        </div>
                      <!--   <div class="item_f"><p><i class="LGntas"></i>创建时间：</p>
                            <div class="r">
                                </div>
                        </div> -->
                        <div class="item_f item_f_2" style="margin-top:20px;">
                            <div class="r"><input type="submit" value="提 交" class="sub5" style="margin-left:0;" /></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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
    if( $('#datepicker3').length>0 && typeof(picker3)!="object" ){
        var picker3 = new Pikaday({
            field: document.getElementById('datepicker3'),
            firstDay: 1,
            format: "YYYY-MM-DD",
            minDate: new Date('2000-01-01'),
            maxDate: new Date('2020-12-31'),
            yearRange: [2000,2020]
        });
    }

    var datatable;
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
                },
                "order" : [[0,"desc"]]
            };
            datatable =  $('#datatable1').DataTable(dt_option);
            
//          var _token = $('input[name="_token"]').val();
            $("#searchnews").click(function () {
                $.ajax({
                    type:"post",
//                  url:"/Admin/searchnewspage",
                    url:"data_admin_user_view.php",
                    dataType: 'html',
                    data:{
                        'start':$("#datepicker1").val(),
                        'end':$("#datepicker2").val(),
                        'mediatype':$("#mediatype").val(),
                        'orderid':$("#keyword").val()
                    },
                    success:function (msg) {
                        console.log("msg:" + msg);
                        if (msg) {
                            if( $.fn.dataTable.isDataTable(" #datatable1 ") ){
                                datatable.destroy();
                            }
                            $('#listcontent').html(msg);
                            datatable =  $('#datatable1').DataTable(dt_option);
                        } else {
                            if( $.fn.dataTable.isDataTable(" #datatable1 ") ){
                                datatable.destroy();
                            }
                            $('#listcontent').html("<tr><td colspan='10'>没有查询到数据！</td></tr>");          //7 表格列数
//                        window.location.reload();
                        }
                    }
                })
            })
    });
    
/*  柱状图 */
if( $('#tb_hv1').length > 0 ){
    var myChart_hv1 = echarts.init(document.getElementById('tb_hv1'));
    option_hv1 = {
        color: ['#3398DB'],
        tooltip : {
            trigger: 'axis',
            axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis : [
            {
                type : 'category',
//              data : ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                data : ['网络媒体', '户外媒体', '平面媒体', '电视媒体', '广播媒体', '内容代写', '记者报料'],
                axisTick: {
                    alignWithLabel: true
                }
            }
        ],
        yAxis : [
            {
                type : 'value'
            }
        ],
        series : [
            {
                name:'直接访问',
                type:'bar',
                barWidth: '60%',
                data:[10, 52, 200, 334, 390, 330, 220]
            }
        ]
    };
    myChart_hv1.setOption(option_hv1);
}

/*  饼状图 */
if( $('#tb_hv2').length > 0 ){
    var myChart_hv2 = echarts.init(document.getElementById('tb_hv2'));
    option_hv2 = {
        title : {
            text: '会员账户金额分布统计图',
            subtext: '今天天气',
            x:'75',
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
            data: ['平台纯收益','充值金额','提现金额','订单消费金额']
        },
        series : [
            {
                name: '访问来源',
                type: 'pie',
                radius : '55%',
                center: ['60%', '55%'],
                data:[
                    {value:335, name:'平台纯收益'},
                    {value:310, name:'充值金额'},
                    {value:234, name:'提现金额'},
                    {value:135, name:'订单消费金额'}
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

</body>
</html>
