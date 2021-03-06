<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>帐—申请发票列表 - 亚媒社</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    @include('console.share.cssjs')    

    </style>
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->

@include('console.share.admin_head')
@include('console.share.admin_menu')            <!--    左弹菜单 普通会员首页 -->


<div class="content"><div class="Invoice">

    <div class="place">
        当前位置：<a href="/console/index">首页</a> > 帐户信息
    </div>
    <div class="main_o" style="padding-bottom:0;">
        <h3 class="title4"><strong><a href="javascript:;">申请发票列表</a></strong>
            <div class="search_1">
<!--
                <form action="" method="" name="">
-->
                <div style="float:right;">
                    <div class="l">
                        <span>起始时间</span>
                    </div>
                    <div class="l">
                        <input type="text" class="txt2" id="datepicker1" />-<input type="text" class="txt2" id="datepicker2" />
                    </div>
                    <div class="l">
                        <select name="" class="sel1" id="mediatype">
                            <option value="1">订单号</option>
                            <option value="2">用户名</option>
                        </select>
                    </div>
                    <div class="l">
                        <input type="text" name="keyword" id="keyword" class="txt5" placeholder="订单号" />
                        <input type="submit" name="submit" class="sub4_2" id="searchnews" value="查询" />
                    </div>
                </div>
<!--
                </form>
-->
            </div>
            <div class="clr"></div>
        </h3>
        <div class="dhorder_m">
            <div class="tab1_body">
                <table class="table_in1 cur" id="datatable1">
                    <thead>
                        <tr>
                            <th>订单号</th>
                            <th>用户名</th>
                            <th>用户角色</th>
                            <th>票据型号</th>
                            <th>发票明细</th>
                            <th>金额类型</th>
                            <th>发票金额</th>
                            <th>发送方式</th>
                            <th>状态</th>
                            <th class="nosort">操作</th>
                        </tr>
                    </thead>
                    <tbody id="listcontent">
                        
                    </tbody>
                </table>
            </div>

        </div>
        
    </div>
    

</div></div>

@include('console.share.admin_foot')

<script type="text/javascript">
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

//<div id="datatable1_filter" class="dataTables_filter"><label>搜索<input type="search" class="" placeholder="过滤..." aria-controls="datatable1"></label></div>
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
                get_ajax_list();
            })
            
    })
    $(function(){
        get_ajax_list();
    })
    
    function get_ajax_list()
    {
        $.ajax({
            type:"get",
            url:"/console/invo/lists",
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
                }
            }
        })
    }


</script>

</body>
</html>
