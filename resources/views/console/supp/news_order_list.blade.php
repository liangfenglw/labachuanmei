<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>最新受理订单</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    @include('console.share.cssjs')
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')
<style type="text/css">
    
</style>

<div class="content"><div class="Invoice">
        {{ csrf_field() }}
    <div class="banner2">
        <img src="{{url('console/images/1.jpg')}}" width="100%">
    </div>
    
    <div class="place">
         <div class="place_ant"><a href="/console/index">首页</a><a class="cur">最新受理订单 </a></div>
    </div>
    
    <div class="main_o clearfix" style="padding-bottom:0; min-height:470px">
    
        <h3 class="title5 clearfix"><strong>最新受理订单</strong></h3>
    
        <div class="dhorder_m">
            <div class="tab1_body">
<table class="table_in1 cur" id="datatable1">
    <thead>
        <tr>
            <th>ID号</th>
            <th>稿件类型</th>
            <th>稿件名称</th>
            <th>订单状态</th>
            <!-- <th>订单描述</th> -->
            <th>生成时间</th>
            <th>金额</th>
            <th class="nosort">操作</th>
        </tr>
    </thead>
    <tbody id="listcontent">
    @foreach($order_list as $key=>$value)
        <tr>
            <td>{{$value['id']}}</td>
            <td>{{$value['type_name']}}</td>
            <td>{{$value['title']}}</td>
            <td>
                @if($value['order_type'] == 13)
                    @if($value['supp_status'] == 1) 取消订单 @endif
                    @if($value['deal_with_status'] == 2) 重做中 @endif
                    @if($value['deal_with_status'] == 3) 完成 @endif
                    @if($value['deal_with_status'] == 1) 退款订单 @endif
                @elseif($value['order_type'] == 12)
                    @if($value['supp_status'] == 1) 申请退款 @endif
                @else
                    {{$status[$value['order_type']]}}
                @endif
            </td>
            <td>{{$value['created_at']}}</td>
            <td class="color1">￥{{$value['user_money']}}</td>
            <td><a class="color2" href="/supp/order/info/{{$value['id']}}">查看</a></td>
        </tr>
    @endforeach
        
    </tbody>
</table>
            </div>
        </div>

                            
    </div>  

</div></div>



@include('console.share.admin_foot')

<script>
    var datatable;

        var _token = $('input[name="_token"]').val();
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
    });

    function setnotice (notice_id,id) {
         $.ajax({
                url : './setnotice',
                data: {
                    // 'type':"register",
                    'id': notice_id,
                    '_token': _token
                },
                type: 'post',
                dataType: "json",
                stopAllStart: true,
                success: function (data) {
                    if (data.status == '1') {
                        if ({{Auth::user()->user_type}} == 3) {
                            location.href = '/supp/order/info/'+id;
                        } else {
                            location.href = "/order/order_detail/"+id;
                        }
                    } else {
                        layer.msg(data.msg || '操作失败');
                    }
                },
                error: function () {
                    layer.msg('网络发生错误！！');
                    return false;
                }
            });
    }
</script>

</body>
</html>
