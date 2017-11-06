<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>订单管理</title>
    @include('console.share.cssjs')
</head>
<body class="fold">
@include('console.share.admin_head')
@include('console.share.admin_menu')
<div class="content"><div class="Invoice">
    @include('console.share.user_menu')
    <div class="place">
         <div class="place_ant"><a href="/console/index">首页</a><a href="/supp/order" class="cur">订单管理 </a></div>
    </div>
    
    <div class="main_o" style="padding-bottom:35px;">
        <h3 class="title4"><strong><a href="#">订单管理</a></strong>
            <div class="search_1">
                <div style="float:right;">
                    <form>
                        <div class="l">
                            <span>起始时间</span>
                        </div>
                        <div class="l">
                            <input type="text" name="mediatype" class="txt2" id="datepicker1" value="{{ Request::input('start') }}" />-<input type="text" class="txt2" id="datepicker2" name="end" value="{{ Request::input('end') }}" />
                        </div>
                        <div class="l">
                            <select name="mediatype" class="sel1" id="mediatype">
                                <option value="0">请选择</option>
                                <option value="35" @if(Request::input('mediatype') == 35) selected="selected" @endif>网络媒体</option>
                            </select>
                        </div>
                        <div class="l">
                            <input type="text" name="orderid" id="keyword" class="txt5" placeholder="订单号" value="{{ Request::input('orderid') }}" />
                            <input type="submit" name="submit" class="sub4_3" id="searchnews" value="查询" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="clr"></div>
        </h3>
        <div class="dhorder_m">
            <div class="tab1">
                <ul>
                    <li @if($order_type == 0)class="cur" @endif><a href="/supp/order">全部订单</a></li>
                    <li @if($order_type == 1)class="cur" @endif><a href="/supp/order/1">预约状态</a></li>
                    <li @if($order_type == 5)class="cur" @endif><a href="/supp/order/5">已完成</a></li>
                    <li @if($order_type == 4)class="cur" @endif><a href="/supp/order/4">正执行</a></li>
                    <li @if($order_type == 3)class="cur" @endif><a href="/supp/order/3">已流单</a></li>
                    <li @if($order_type == 2)class="cur" @endif><a href="/supp/order/2">已拒单</a></li>
                    <li @if($order_type == 100)class="cur" @endif><a href="/supp/order/100">退款订单</a></li>
                    {{-- <li @if($order_type == 9)class="cur" @endif><a href="/supp/order/9">申诉订单</a></li> --}}
                    <!-- <li><a href="">退还</a></li> -->
                </ul>
            </div>
            <div class="tab1_body">
                <table class="table_in1 cur" id="datatable1">
                    <thead>
						@if( $order_type == 0 )
							<tr>
								<th>订单号</th>
								<th>稿件名称</th>
								<th>稿件类型</th>
								<th>截止时间</th>
								<th>价格</th>
								<th>完成链接/截图</th>
								<th>订单状态</th>
								<th class="nosort">操作</th>
							</tr>
						@elseif( $order_type == 1 )
							<tr>
								<th>订单号</th>
								<th>稿件名称</th>
								<th>稿件类型</th>
								<th>截止时间</th>
								<th>价格</th>
								<th>订单状态</th>
								<th class="nosort">操作</th>
							</tr>
						@elseif( $order_type == 5 )
							<tr>
								<th>订单号</th>
								<th>稿件名称</th>
								<th>稿件类型</th>
								<th>价格</th>
								<th>完成链接/截图</th>
								{{-- <th>质检状态</th> --}}
								<th>订单状态</th>
								<th class="nosort">操作</th>
							</tr>
						@elseif( $order_type == 4 )
							<tr>
								<th>订单号</th>
								<th>稿件名称</th>
								<th>稿件类型</th>
								<th>价格</th>
								<th>完成链接/截图</th>
								<th>订单状态</th>
								<th class="nosort">操作</th>
							</tr>
						@elseif( $order_type == 3 )
							<tr>
								<th>订单号</th>
								<th>稿件名称</th>
								<th>稿件类型</th>
								<th>截止时间</th>
								<th>价格</th>
								<th>订单状态</th>
								<th class="nosort">操作</th>
							</tr>
						@elseif( $order_type == 2 )
							<tr>
								<th>订单号</th>
								<th>稿件名称</th>
								<th>稿件类型</th>
								<th>截止时间</th>
								<th>价格</th>
								<th>订单状态</th>
								<th class="nosort">操作</th>
							</tr>
						@elseif( $order_type == 100 )
							<tr>
								<th>订单号</th>
								<th>稿件名称</th>
								<th>稿件类型</th>
								<th>截止时间</th>
								<th>价格</th>
								<th>订单状态</th>
								{{-- <th>退款状态</th> --}}
								<th class="nosort">操作</th>
							</tr>
						@elseif( $order_type == 9 )
							<tr>
								<th>订单号</th>
								<th>稿件类型</th>
								<th>完成链接/截图</th>
								<th>申诉状态</th>
								<th class="nosort">操作</th>
							</tr>
						@endif
                    </thead>
                    <tbody id="listcontent">
                        @if($order_type == 1)
                            @foreach($order_list as $key => $value)
                                <tr>
                                    <td>{{ $value['id'] }}</td>
                                    <td>{{ $value['title'] }}</td>
                                    <td>{{ $value['type_name'] }}</td>
                                    {{-- <td>{{ $value['start_at'] }}</td> --}}
                                    <td>{{ $value['over_at'] }}</td>
                                    <td class="color1">￥{{ $value['supp_money'] }}</td>
                                    <td>{{ $status[$value['order_type']] }}</td>
                                    <td>
                                        <a class="color2" href="/supp/order/info/{{ $value['id'] }}">查看</a>
                                    </td>
                                </tr>
                            @endforeach
                        @elseif ($order_type == 2)
                            @foreach($order_list as $key => $value)
                                <tr>
                                    <td>{{ $value['id'] }}</td>
                                    <td>{{ $value['title'] }}</td>
                                    <td>{{ $value['type_name'] }}</td>
                                    <td>{{ $value['over_at'] }}</td>
                                    <td class="color1">￥{{ $value['supp_money'] }}</td>
                                    
                                    <td>{{ $status[$value['order_type']] }}</td>
                                    <td>
                                        <a class="color2" href="/supp/order/info/{{ $value['order_id'] }}">查看</a>
                                    </td>
                                </tr>
                            @endforeach
                        @elseif( $order_type == 4 ) {{-- 执行中 --}}
                            @foreach($order_list as $key => $value)
                                <tr>
                                    <td>{{ $value['id'] }}</td>
                                    <td>{{ $value['title'] }}</td>
                                    <td>{{ $value['type_name'] }}</td>
                                    {{-- <td>{{ $value['start_at'] }}</td> --}}
                                    <td>{{ $value['supp_money'] }}</td>
                                    <td class="link-pic">
										<div class="success-urlpic">
											@if( $value['success_url'] && $value['success_pic'] )
												<a target="_blank" href="{{ $value['success_url'] }}"><img src="{{ $value['success_pic'] }}"></a>
											@elseif( $value['success_url'] )
												<a target="_blank" href="{{ $value['success_url'] }}">链接地址</a>
											@elseif( $value['success_pic'] )
												<img src="{{ $value['success_pic'] }}">
											@else
											@endif
										</div>
                                    </td>
                                    <td>{{ $status[$value['order_type']] }}</td>
                                    <td>
                                        <a class="color2" href="/supp/order/info/{{ $value['id'] }}">查看</a>
                                    </td>
                                </tr>
                            @endforeach
                        @elseif( $order_type == 5 ) {{-- 执行中 --}}
                            @foreach($order_list as $key => $value)
                                <tr>
                                    <td>{{ $value['id'] }}</td>
                                    <td>{{ $value['title'] }}</td>
                                    <td>{{ $value['type_name'] }}</td>
                                    {{-- <td>{{ $value['start_at'] }}</td> --}}
                                    <td>{{ $value['supp_money'] }}</td>
                                    <td class="link-pic">
										<div class="success-urlpic">
											@if( $value['success_url'] && $value['success_pic'] )
												<a target="_blank" href="{{ $value['success_url'] }}"><img src="{{ $value['success_pic'] }}"></a>
											@elseif( $value['success_url'] )
												<a target="_blank" href="{{ $value['success_url'] }}">链接地址</a>
											@elseif( $value['success_pic'] )
												<img src="{{ $value['success_pic'] }}">
											@else
											@endif
										</div>
                                    </td>
                                    <td>{{ $status[$value['order_type']] }}</td>
                                    <td>
                                        <a class="color2" href="/supp/order/info/{{ $value['id'] }}">查看</a>
                                    </td>
                                </tr>
                            @endforeach
                        @elseif($order_type == 9)
                            @foreach($order_list as $key => $value)
                                <tr>
                                    <td>{{ $value['id'] }}</td>
                                    <td>{{ $value['title'] }}</td>
                                    <td>{{ $value['type_name'] }}</td>
                                    {{-- <td>{{ $value['start_at'] }}</td> --}}
                                    
                                    <td>{{ $status[$value['order_type']] }}</td>
                                    <td>
                                        <a class="color2" href="/supp/order/info/{{ $value['id'] }}">查看</a>
                                    </td>
                                </tr>
                            @endforeach
                        @elseif($order_type == 100)
                            @foreach($order_list as $key => $value)
                                <tr>
                                    <td>{{ $value['id'] }}</td>
                                    <td>{{ $value['title'] }}</td>
                                    <td>{{ $value['type_name'] }}</td>
                                    {{-- <td>{{ $value['start_at'] }}</td> --}}
                                     <td>{{ $value['over_at'] }}</td>
                                     <td class="color1">￥{{ $value['supp_money'] }}</td>
                                    <td>{{ $status[$value['order_type']] }}</td>
                                    <td>
                                        <a class="color2" href="/supp/order/info/{{ $value['id'] }}">查看</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            @foreach($order_list as $key => $value)
                                <tr>
                                    <td>{{ $value['id'] }}</td>
                                    <td>{{ $value['title'] }}</td>
                                    <td>{{ $value['type_name'] }}</td>
                                    {{-- <td>{{ $value['start_at'] }}</td> --}}
                                    <td>{{ $value['over_at'] }}</td>
                                    <td class="color1">￥{{ $value['supp_money'] }}</td>
                                    <td class="link-pic">
										<div class="success-urlpic">
											@if( $value['success_url'] && $value['success_pic'] )
												<a target="_blank" href="{{ $value['success_url'] }}"><img src="{{ $value['success_pic'] }}"></a>
											@elseif( $value['success_url'] )
												<a target="_blank" href="{{ $value['success_url'] }}">链接地址</a>
											@elseif( $value['success_pic'] )
												<img src="{{ $value['success_pic'] }}">
											@else
											@endif
										</div>
                                    </td>
                                    <td>{{ $status[$value['order_type']] }}</td>
                                    <td>
                                        <a class="color2" href="/supp/order/info/{{ $value['id'] }}">查看</a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div style="padding:0px 22px;background:#fff;">
                <div class="info_hdorder clearfix">
                        <ul>
                            <li class="cur">{{ $order_statistics['all_count'] or 0}}个/{{ $order_statistics['all_money'] or 0 }}元 <br/>总订单数</li>
                            <li>{{ $order_statistics['success_count'] }}个/{{ $order_statistics['success_money'] or 0 }}元 <br/>已完成</li>
                            <li>{{ $order_statistics['flow_order_count'] }}个/{{ $order_statistics['flow_order_money'] or 0 }}元 <br/>流单数</li>
                            <li>{{ $order_statistics['give_up_count'] }}个/{{ $order_statistics['give_up_money'] or 0 }}元 <br/>取消数</li>
                            <li>{{ $order_statistics['refuse_order'] }}个/{{ $order_statistics['refuse_money'] or 0 }}元 <br/>拒单数</li>
                        </ul>
                </div>
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

    
$(function(){
    $(".tab1>ul>li>a").unbind("click");
});

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
                "order" : [[0,"desc"]]
            };
            datatable =  $('#datatable1').DataTable(dt_option);
			// getOrderList();
            var _token = $('input[name="_token"]').val();
            $("#searchnews").click(function () {
                // getOrderList();
            })
            function getOrderList() {
                $.ajax({
                    type:"get",
                    url:"/supp/order",
                    dataType: 'html',
                    data:{
                        'start':$("#datepicker1").val(),
                        'end':$("#datepicker2").val(),
                        'mediatype':$("#mediatype").val(),
                        'orderid':$("#keyword").val(),
                        'ordertype':"{{$order_type}}",
                        'token':_token,
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
//							$('#listcontent').html("<tr><td colspan='11'>没有查询到数据！</td></tr>");           // 表格列数
							datatable =  $('#datatable1').DataTable(dt_option);
                        }
                    }
                })
            }
            
    })


</script>

</body>
</html>
