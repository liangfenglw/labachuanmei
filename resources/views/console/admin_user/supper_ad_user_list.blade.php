<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>用户管理_喇叭传媒</title>
    @include('console.share.cssjs')
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')
<!--    左弹菜单 普通会员首页 -->

<div class="content"><div class="Invoice">

    <div class="place">
         <div class="place_ant"><a href="/console/index">首页</a><a class="cur">用户管理 </a></div>
    </div>
    
    <div class="main_o clearfix" style="padding-bottom:0;">
    
        <h3 class="title4 clearfix"><strong><a>高级会员管理</a></strong>
            <div class="search_1">
                <form action="" method="" name="">
                <div style="float:right;">
                    <div class="l">
                        <span>起始时间</span>
                    </div>
                    <div class="l">
                        <input type="text" class="txt2" id="datepicker1" name="start" value="{{ Request::input('start') }}"/>-<input type="text" class="txt2" id="datepicker2" name="end" value="{{ Request::input('end') }}"/>
                    </div>
                    <div class="l">
                        <input type="text" name="keyword" id="keyword" class="txt5" value="{{ Request::input('keyword') }}" placeholder="用户名" />
                        <input type="submit" name="submit" class="sub4_3" value="查询" />
                    </div>
                    <div class="l">
                        <a class="sub4_2" id="get_excel" href="javascript:;" onclick="get_excel();" style="background: #7db6eb;">导出列表</a>
                    </div>
                </div>
                </form>
            </div>
            <div class="clr"></div>
        </h3>
    
        <div class="dhorder_m">
            <div class="tab1_body">
                <table class="table_in1 cur" id="datatable1">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>用户名</th>
                            <th>创建时间</th>
                            <th>订单数</th>
                            <th>账户余额</th>
                            <th>会员资源</th>
                            <th>状态</th>
                            <th class="nosort">操作</th>
                        </tr>
                    </thead>
                    <tbody id="listcontent">
                        @foreach($lists as $key => $value)
                            <tr>
                                <td>{{ $value['user_id'] }}</td>
                                <td>{{ $value['name'] }}</td>
                                <td>{{ $value['created_at'] }}</td>
                                <td>{{ $value['order_count'] }}</td>
                                <td class="color1">{{ $value['user_money'] }}</td>
                                <td>{{ $value['child_user_num'] }}</td>
                                <td>@if($value['is_login'] == 1) 在线 @else 下架 @endif</td>
                                <td><a class="color2" href="/user/ad_user/{{ $value['user_id'] }}">查看</td>
                            </tr>
                        @endforeach
                    </tbody>   
                </table>
            </div>
        </div>
    </div>  
    </div>
</div>
@include('console.share.admin_foot')
<script>
function get_excel()
    {
        var hrefs = '/user/ajax/ad_user_list?get_excel=1&level_id=2';
        hrefs += "&start="+$("#datepicker1").val();
        hrefs += "&end="+$("#datepicker2").val();
        hrefs += "&mediatype="+$("#mediatype").val();
        hrefs += "&orderid="+$("#keyword").val();
        window.open(hrefs);
    }
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
    
    var datatable;
    $(function () {
            var dt_option = {
                "searching" : false,        //是否允许Datatables开启本地搜索
                "paging" : true,            //是否开启本地分页
                "pageLength" : 8,           //每页显示记录数
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
            
            $("#searchnews").click(function () {
                // default_ajax();
            })
    });

function default_ajax() {
    $.ajax({
        type:"post",
        url:"/user/ajax/ad_user_list",
        dataType: 'html',
        data:{
            '_token':$('meta[name="csrf-token"]').attr('content'),
            'start':$("#datepicker1").val(),
            'end':$("#datepicker2").val(),
            'mediatype':$("#mediatype").val(),
            'orderid':$("#keyword").val(),
            'level_id':2,
        },
        success:function (msg) {
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
                $('#listcontent').html("<tr><td colspan='10'>没有查询到数据！</td></tr>");
            }
        }
    })
}
</script>

</body>
</html>
