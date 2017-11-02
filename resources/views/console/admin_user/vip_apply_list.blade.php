<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>申请高级会员</title>
    @include('console.share.cssjs')
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')
<!--    左弹菜单 普通会员首页 -->

<div class="content"><div class="Invoice">

    <div class="place">
        <div class="place_ant"><a href="/console/index">首页</a><a  href="/console/article/category/manager" class="cur">用户管理 </a></div>
    </div>
    
    <div class="main_o clearfix" style="padding-bottom:0;">
    
        <h3 class="title4 clearfix"><strong><a>申请高级会员</a></strong>
            <div class="search_1">
                <div style="float:right;">
                    <div class="l">
                        <span>起始时间</span>
                    </div>
                    <div class="l">
                        <input type="text" class="txt2" id="datepicker1" />-<input type="text" class="txt2" id="datepicker2" />
                    </div>
                    <div class="l">
                        <select name="" class="sel1" id="mediatype">
                            <option value="2">待审</option>
                            <option value="3">不通过</option>
                        </select>
                    </div>
                    <div class="l">
                        <input type="text" name="keyword" id="keyword" class="txt5" placeholder="用户名" />
                        <input type="submit" name="submit" class="sub4_3" id="searchnews" value="查询" />
                    </div>
                    <div class="l">
                        <a class="sub4_2" href="javascript:;" onclick="get_excel();" style="background: #7db6eb;">导出列表</a>
                    </div>
                </div>
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
                            {{-- <th>所属会员</th> --}}
                            <th>创建时间</th>
                            <th>订单数</th>
                            <th>账户余额</th>
                            <th>申请状态</th>
                            <th class="nosort">操作</th>
                        </tr>
                    </thead>
                    <tbody id="listcontent">
                        @foreach($lists as $key => $value)
                            <tr>
                                <td>{{ $value['user_id'] }}</td>
                                <td>{{ $value['nickname'] }}</td>
                                <td>{{ $value['created_at'] }}</td>
                                <td>{{ $value['order_count'] }}</td>
                                <td class="color1">{{ $value['user_money'] }}</td>
                                <td>{{ getVipCheckType($value['check_status']) }}</td>
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
        url = "/user/apply?get_excel=1&check_status=2";
        url += "&start="+$("#datepicker1").val();
        url += "&end="+$("#datepicker2").val();
        url += "&mediatype="+$("#mediatype").val();
        url += "&orderid="+$("#keyword").val();
        window.open(url);
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
                "order" : [[3,"desc"]]
            };
            datatable =  $('#datatable1').DataTable(dt_option);
            
//          var _token = $('input[name="_token"]').val();
            $("#searchnews").click(function () {
                default_ajax();
            })
    });

function default_ajax() {
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type:"get",
        url:"",
        dataType: 'html',
        data:{
            'start':$("#datepicker1").val(),
            'end':$("#datepicker2").val(),
            'check_status':$("#mediatype").val(),
            'orderid':$("#keyword").val(),
            '_token':token,
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
