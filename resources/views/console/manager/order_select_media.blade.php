<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>媒体选择_喇叭传媒</title>
        @include('console.share.cssjs')
    </head>
 <style>
.tab2 ul li a {
    font-size: 24px;
    color: #2f4050;
}
</style>

<body class="fold">
@include('console.share.admin_head')
@include('console.share.admin_menu')
<div class="content"><div class="Invoice">
    <div class="place">
        <div class="place_ant"><a href="/console/index">首页</a> <a class="cur">媒体选择</a> </div>
        
    </div>
    <div class="main_o clearfix" style="padding-bottom:0;">
        <h3 class="title4 clearfix">
            <div class="tab2" style="float:left;">
                <ul class="clearfix" style="float:left;">
                    <li class=""><a href="/console/manager/order/info/{{ Request::input('order_id') }}">我的订单</a></li>
                    <li class="cur"><a href="javascript:void(0);">媒体选择</a></li>
                </ul>
            </div>

            <div class="search_1">
                <form action="" method="get" name="">
                <div style="float:right;">
                    <div class="l">
                        <span>起始时间</span>
                    </div>
                    <div class="l">
                        <input type="hidden" name="id" value="{{ Request::input('id') }}">
                        <input type="text" name="start" class="txt2" id="datepicker1" value="{{ Request::input('start') }}" />-<input type="text" name="end" class="txt2" id="datepicker2" value="{{ Request::input('end') }}" />
                    </div>
                   <!--  <div class="l">
                        <select name="plate_id" class="sel1" id="mediatype">
                            <option value="0">媒体类型</option>
                            <option value="">网络媒体</option>
                            <option value="">户外媒体</option>
                            <option value="">平面媒体</option>
                            <option value="">......</option>
                        </select>
                    </div> -->
                     <div class="l">
                        <input type="text" name="keyword" id="keyword" class="txt5" placeholder="媒体名称"  value="{{ Request::input('keyword') }}" />
                        <input type="submit" name="submit" class="sub4_3" id="searchnews" value="查询" />
                    </div>
                    <div class="l">
                        <a class="sub4_2" href="javascript:;" onclick="get_excel();" target="_blank" style="background:#7db6eb">导出列表</a>
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
            <th>媒体名称</th>
            <th>媒体类型</th>
            <th>供应商</th>
            <th>创建时间</th>
            <th>订单数</th>
            <th>价格</th>
            <th>状态</th>
            <th class="nosort">操作</th>
        </tr>
    </thead>
    <tbody id="listcontent">
        @foreach($lists as $key => $val)
        <tr>
            <td>{{ $val['user_id'] }}</td>
            <td>{{ $val['media_name'] }}</td>
            <td>{{ $val['child_plate']['plate_name'] }}</td>
            <td>{{ $val['parent_user']['name'] }}</td>
            <td>{{ $val['created_at'] }}</td>
            <td>{{ $val['order_count'] }}</td>
            <td class="color1">￥{{ $val['proxy_price'] }}</td>
            <td>{{ getSuppUserType($val['is_state']) }}</td>
            <td><a class="color2" href="/usermanager/suppResourceInfo?id={{ $val['user_id'] }}">查看</a> &nbsp;  &nbsp; 
            @if($order_info['media_type'] != 13 && $order_info['order_type'] != 10 && $order_info['order_type'] != 3)
            <label class="color2">
                <a class="color1" href="/console/managerOrder/setOrderMedia?order_id={{ Request::input('order_id') }}&user_id={{ $val['user_id'] }}" data_id="{{ $val['user_id'] }}"/> 指派订单</a>
            </label>
            @endif
        </td>
         </tr>
        <!-- <td>{{ $val['proxy_price'] }}</td> -->
        @endforeach
        </tbody>
    </table>
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
    function get_excel()
    {
        var hrefs = '/usermanager/resources_list?get_excel=1';
        hrefs += '&start='+$("#datepicker1").val();
        hrefs += '&end='+$("#datepicker2").val();
        hrefs += '&mediatype='+$("#mediatype").val();
        hrefs += '&username='+$("#keyword").val();
        hrefs += "&pid={{ Request::input('pid') }}";
        $("#get_excel").attr('href',hrefs);
        // alert(hre)
        window.open(hrefs);
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
            
//          var _token = $('input[name="_token"]').val();
            $("#searchnews").click(function () {
                // default_ajax();
            })
    });
    function default_ajax() {
        $.ajax({
                type:"get",
                url:"/usermanager/ads_list",
                dataType:'html',
                data:{
                    'start':$("#datepicker1").val(),
                    'end':$("#datepicker2").val(),
                    'mediatype':$("#mediatype").val(),
                    'username':$("#keyword").val(),
                    'pid':"{{ Request::input('pid') }}",
                },
                success:function (msg) {
                    // console.log("msg:" + msg);
                    if (msg) {
                        if( $.fn.dataTable.isDataTable(" #datatable1 ") ){
                            datatable.destroy();
                        }
                        $('#listcontent').html(msg);
                        // datatable =  $('#datatable1').DataTable(dt_option);
                    } else {
                        if( $.fn.dataTable.isDataTable(" #datatable1 ") ){
                            // datatable.destroy();
                        }
                        $('#listcontent').html("<tr><td colspan='10'>没有查询到数据！</td></tr>");          //7 表格列数
                        // window.location.reload();
                    }
                }
            })
    }
</script>

</body>
</html>
