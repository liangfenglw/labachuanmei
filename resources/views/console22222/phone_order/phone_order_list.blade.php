<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>内—首页回拔电话列表 - 喇叭传媒</title>
    @include('console.share.cssjs')
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->
    @include('console.share.admin_head')
    @include('console.share.admin_menu')
<div class="content">
    <div class="Invoice">
        <div class="place">
            当前位置：<a href="/console/index">首页</a> > 账户信息
        </div>
        <div class="main_o" style="padding-bottom:0px;">
            <h3 class="title4"><strong><a href="/console/phone_order">回拔电话管理列表</a></strong></h3>
        
            <div class="dhorder_m">
                <div class="tab1_body">
                    <table class="table_in1 cur" id="datatable1">
                        <thead>
                            <tr>
                                <th style="width:20%;">用户名</th>
                                <th style="">用户角色</th>
                                <th style="">联系电话</th>
                                <th style="">日期</th>
                                <th style="width:15%;">状态</th>
                            </tr>
                        </thead>
                        <tbody id="listcontent">
                            @foreach($phone_order_list as $key => $val)
                                <tr>
                                    <td>{{$val['name']}}</td>
                                    <td>{{$val['level_name']}}</td>
                                    <td>{{$val['contact_phone']}}</td>
                                    <td>{{$val['created_at']}}</td>
                                    <td><a class="color1" href="javascript:;" id="href_{{$val['id']}}" @if($val['status']  != '完成') onclick="update(this)" @endif data-id="{{$val['id']}}" data-name="{{$val['name']}}">{{ $val['status'] }}</a></td>
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
    function update(obj) {
        var name = $(obj).attr('data-name');
        var id = $(obj).attr('data-id');
        layer.confirm("确认已完成 " + name + " 吗", {
            btn: ['是','取消']
        }, function(){
            $.ajax({
                url:"/console/phone_order/id/"+id,
                type:'get',
                dataType:'json',
                success:function(msg) {
                    if (msg.status_code == 200) {
                        $("#href_"+id).text('完成');
                        $("#href_"+id).attr('onclick','');
                        layer.msg(msg['msg']);
                    }
                },
                error:function(msg) {
                }
            })
        }, function(){

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
                "order" : [[2,"desc"]]
            };
            datatable =  $('#datatable1').DataTable(dt_option);
    })
    
    $(".table_in1 td a.del").click(function(){
        var $tr = $(this).closest("tr");
        var id = $tr.find("input[name=news_id]").val();
        var name = $tr.find("td.td_title").html();
        
        layer.confirm("确认要删除 文章 " + name + " 吗", {
            btn: ['是','取消']
        }, function(){
            /*
                ajax删除文章
            */
            $tr.remove();
            layer.msg("分类 " + name + " 删除成功");
        }, function(){

        });

        return false;
    });
</script>

</body>
</html>
