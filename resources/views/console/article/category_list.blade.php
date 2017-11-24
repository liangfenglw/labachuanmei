<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>栏目管理_喇叭传媒</title>
    @include('console.share.cssjs')
</head>
<body class="fold">
<!--    class="fold" 左导航收缩  -->
    @include('console.share.admin_head')
    @include('console.share.admin_menu')
<!--    左弹菜单 普通会员首页 -->
<div class="content"><div class="Invoice">
    <div class="place">
        <div class="place_ant"><a href="/console/index">首页</a><a  class="cur">栏目管理 </a></div>
    </div>
    <div class="main_o" style="padding-bottom:50px;">
        <h3 class="title4"><strong><a href="javascript:;">栏目管理</a></strong></h3>
        <div class="dhorder_m">
            <div class="tab1_body">
                <table class="table_in1 cur" id="datatable1">
                    <thead>
                        <tr>
                            <th style="width:15%;">序号</th>
                            <th style="width:23%;">分类名称</th>
                            <th style="width:22%;">栏目类型</th>
                            <th style="width:20%;">状态</th>
                            <th style="width:20%;">操作</th>
                        </tr>
                    </thead>
                    <tbody id="listcontent">
                        @foreach($category_list as $key => $val)
                            <tr data-id="{{ $val['id'] }}" data-name="{{ $val['category_name'] }}">
                                <td>{{ $val['id'] }}</td>
                                <td>{{ $val['category_name'] }}</td>
                                <td>{{ $category_type[$val['type_id']] }}</td>
                                
                                <td>{{ $val['status'] == 1 ? '在线' : '下架'}}</td>
                                <td><a class="color2" href="/console/article/category/{{ $val['id'] }}">查看</a> <span class="color2">|</span> <a class="color2 del2" href="javascript:;" stype="font-size:10px">删除</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div></div>
@include('console.share.admin_foot')

<script type="text/javascript">
$(".table_in1 td a.del2").click(function(){
    var $tr = $(this).closest("tr");
    var id = $tr.attr("data-id");
    var name = $tr.attr("data-name");
    
    layer.confirm("确认要删除 分类 " + name + " 吗", {
        btn: ['是','取消']
    }, function(){
        $.ajax({
            data:{"id":id,'_token':$('meta[name="csrf-token"]').attr('content')},
            url:"/console/article/category/del",
            type:"post",
            success:function(msg) {
                if (msg.status_code == 200) {
                    $tr.remove();
                    layer.msg("分类 " + name + " 删除成功");
                } else {
                    layer.msg(msg['msg']);
                }
            }
        })
        
    }, function(){

    });

    return false;
});
</script>

<script>
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
                    sZeroRecords : "没有未读消息",
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
            datatable =  $('#datatable1').DataTable(dt_option);
        
    });
    
</script>

</body>
</html>
