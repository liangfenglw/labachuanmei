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
    <div class="place">
        <div class="place_ant"><a href="/console/index">首页</a><a  class="cur">订单管理 </a></div>
    </div>
    
    <div class="main_o" style="padding-bottom:0;">
        
        <h3 class="title4"><strong><a href="javascript:;">网络媒体</a></strong>
            <form>
            <div class="search_1">
                <div style="float:right;">
                    <div class="l">
                        <span>起始时间</span>
                    </div>
                    <div class="l">
                        <input type="text" class="txt2" id="datepicker1" name="start" />-<input type="text" class="txt2" id="datepicker2" name="end" />
                    </div>
                    <div class="l">
                        <select name="plate_id" class="sel1" id="mediatype">
                            <option value="0">请选择</option>
                            @foreach($child_plate as $key => $val)
                            <option value="{{$val['id']}}">{{$val['plate_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="l">
                        <input type="text" name="keyword" id="keyword" class="txt5" placeholder="订单号" />
                        <input type="submit" name="submit" class="sub4_3" id="searchnews" value="查询" />
                    </div>
                </div>
            </div>
            <div class="clr"></div>
            </form>
        </h3>
        <div class="dhorder_m" style="min-height:640px">
            <div class="tab1">
                <ul>
                    <li @if(empty(Request::input('type'))) class="cur" @endif><a href="/console/manager/order/35">全部订单</a></li>
                    <li @if(Request::input('type') == 11) class="cur" @endif><a href="/console/manager/order/35?type=11">未匹配</a></li>
                    <li @if(Request::input('type') == 1) class="cur" @endif><a href="/console/manager/order/35?type=1">预约状态</a></li>
                    <li @if(Request::input('type') == 10) class="cur" @endif><a href="/console/manager/order/35?type=10">已完成</a></li>
                    <li  @if(Request::input('type') == 4) class="cur" @endif><a href="/console/manager/order/35?type=4">正执行</a></li>
                    <li @if(Request::input('type') == 3) class="cur" @endif><a href="/console/manager/order/35?type=3">已流单</a></li>
                    <li @if(Request::input('type') == 2) class="cur" @endif><a href="/console/manager/order/35?type=2">已拒单</a></li>
                    <li @if(Request::input('type') == 12) class="cur" @endif><a href="/console/manager/order/35?type=12">退款订单</a></li>
                    <li @if(Request::input('type') == 9) class="cur" @endif><a href="/console/manager/order/35?type=9">申诉订单</a></li>
                </ul>
                <a class="btn2_o" href="javascript:;" id="get_excel" onclick="get_excel()">导出列表</a>
            </div>
            <div class="tab1_body">
                <table class="table_in1 cur" id="datatable1">
                    <thead>
                        @if(Request::input('type') == 100)
                            <tr>
                                <th>订单号</th>
                                <th>稿件标题</th>
                                <th>稿件类型</th>
                                <th>开始时间</th>
                                <th>结束时间</th>
                                <th>价格</th>
                                <th>所属用户</th>
                                <th>供应商</th>
                                <th>媒体名称</th>
                                <th>订单状态</th>
                                <th class="nosort">操作</th>
                            </tr>
                        @elseif(Request::input('type') == 1)
                            <tr>
                                <th>订单号</th>
                                <th>稿件标题</th>
                                <th>稿件类型</th>
                                <th>开始时间</th>
                                <th>结束时间</th>
                                <th>价格</th>
                                <th>所属用户</th>
                                <th>供应商</th>
                                <th>媒体名称</th>
                                <th>订单状态</th>
                                <th class="nosort">操作</th>
                            </tr>
                        @elseif(Request::input('type') == 10)
                            <tr>
                                <th>订单号</th>
                                <th>稿件标题</th>
                                <th>稿件类型</th>
                                <th>价格</th>
                                <th>所属用户</th>
                                <th>供应商</th>
                                <th>媒体名称</th>
                                <th>完成链接/截图</th>
                                <th>订单状态</th>
                                <th class="nosort">操作</th>
                            </tr>
                        @elseif(Request::input('type') == 4)
                            <tr>
                                <th>订单号</th>
                                <th>稿件标题</th>
                                <th>稿件类型</th>
                                <th>价格</th>
                                <th>所属用户</th>
                                <th>供应商</th>
                                <th>媒体名称</th>
                                <th>完成链接/截图</th>
                                <th>订单状态</th>
                                <th class="nosort">操作</th>
                            </tr>
                        @elseif(Request::input('type') == 3)
                            <tr>
                                <th>订单号</th>
                                <th>稿件标题</th>
                                <th>稿件类型</th>
                                <th>开始时间</th>
                                <th>结束时间</th>
                                <th>价格</th>
                                <th>所属用户</th>
                                <th>供应商</th>
                                <th>媒体名称</th>
                                <th>订单状态</th>
                                <th class="nosort">操作</th>
                            </tr>
                        @elseif(Request::input('type') == 2)
                            <tr>
                                <th>订单号</th>
                                <th>稿件标题</th>
                                <th>稿件类型</th>
                                <th>开始时间</th>
                                <th>结束时间</th>
                                <th>价格</th>
                                <th>所属用户</th>
                                <th>供应商</th>
                                <th>媒体名称</th>
                                <th>订单状态</th>
                                <th class="nosort">操作</th>
                            </tr>
                        @elseif(Request::input('type') == 1000)
                            <tr>
                                <th>订单号</th>
                                <th>稿件标题</th>
                                <th>稿件类型</th>
                                <th>截止时间</th>
                                <th>价格</th>
                                <th>所属用户</th>
                                <th>供应商</th>
                                <th>媒体名称</th>
                                <th>订单状态</th>
                                <th>退款状态</th>
                                <th class="nosort">操作</th>
                            </tr>
                        @elseif(Request::input('type') == 9)
                            <tr>
                                <th>订单号</th>
                                <th>稿件类型</th>
                                <th>所属用户</th>
                                <th>供应商</th>
                                <th>媒体名称</th>
                                <th>完成链接/截图</th>
                                <th>申诉状态</th>
                                <th class="nosort">操作</th>
                            </tr>
                        @elseif(Request::input('type') == 11)
                            <tr>
                                <th>订单号</th>
                                <th>稿件标题</th>
                                <th>稿件类型</th>
                                <th>开始时间</th>
                                <th>结束时间</th>
                                <th>价格</th>
                                <th>所属用户</th>
                                <th>媒体名称</th>
                                <th>订单状态</th>
                                <th class="nosort">操作</th>
                            </tr>
                        @else
                            {{-- 全部订单 --}}
                             <tr>
                                <th>订单号</th>
                                <th>稿件标题</th>
                                <th>稿件类型</th>
                                <th>开始时间</th>
                                <th>结束时间</th>
                                <th>价格</th>
                                <th>所属用户</th>
                                <th>供应商</th>
                                <th>媒体名称</th>
                                <th style="max-width: 230px;">完成链接/截图</th>
                                <th>订单状态</th>
                                <th class="nosort">操作</th>
                            </tr>
                        @endif
                       
                    </thead>
                    <tbody id="listcontent">
                        {{-- 全部订单 --}}
                        @if(Request::input('type') == 1)
                            @foreach($child_lists as $key => $value)
                                <tr>
                                    <td>{{ $value['id'] }}</td>
                                    <td>{{ $value['title'] }}</td>
                                    <td>{{ $value['type_name'] }}</td>
                                    <td>{{ $value['start_at'] }}</td>
                                    <td>{{ $value['over_at'] }}</td>
                                    <td class="color1">{{ $value['user_money'] }}</td>
                                    <td>{{ $value['username'] }}</td>
                                    <td>{{ $value['supp_user']['parent_user']['name'] }}</td>
                                    <td>{{ $value['supp_user']['media_name'] }}</td>
                                    
                                    <td class="color1">
                                    {{ getOrderType($value['order_type']) }}
                                    </td>
                                    <td><a class="color2" href="/console/manager/order/info/{{ $value['id'] }}">查看</a></td></tr>
                            @endforeach
                        @elseif(Request::input('type') == 4) {{-- 正执行 --}}
                            @foreach($child_lists as $key => $value)
                                <tr>
                                    <td>{{ $value['id'] }}</td>
                                    <td>{{ $value['title'] }}</td>
                                    <td>{{ $value['type_name'] }}</td>
                                    <td class="color1">{{ $value['user_money'] }}</td>
                                    {{-- <td>{{ $value['start_at'] }}</td> --}}
                                    {{-- <td>{{ $value['over_at'] }}</td> --}}
                                    {{-- <td class="color1">{{ $value['user_money'] }}</td> --}}
                                    <td>{{ $value['username'] }}</td>
                                     <td>{{ $value['supp_user']['parent_user']['name'] }}</td>
                                    <td>{{ $value['supp_user']['media_name'] }}</td>
                                    <td>
										<div class="success-urlpic">
                                        @if($value['success_url'])
                                            <a target="_blank" href="{{ $value['success_url'] }}">链接地址</a>
                                        @else
                                            @if ($value['success_pic'])
                                                 <img src="{{ $value['success_pic'] }}">
                                            @endif
                                        @endif
										</div>
                                    </td>
                                    <td class="color1">
                                    {{ getOrderType($value['order_type']) }}
                                    @if($value['deal_with_status'] == 2)
                                        ，重做
                                    @elseif($value['deal_with_status'] == 1)
                                        ，此订单退款处理
                                    @elseif($value['deal_with_status'] == 3) 
                                        ，不同意申诉，结款
                                    @endif
                                    </td>
                                    <td><a class="color2" href="/console/manager/order/info/{{ $value['id'] }}">查看</a></td></tr>
                            @endforeach
                        @elseif(Request::input('type') == 9) {{-- 申诉订单 --}}
                            @foreach($child_lists as $key => $value)
                                <tr>
                                    <td>{{ $value['id'] }}</td>
                                    <td>{{ $value['title'] }}</td>
                                    <td>{{ $value['type_name'] }}</td>
                                    <td>{{ $value['supp_user']['parent_user']['name'] }}</td>
                                    <td>{{ $value['supp_user']['media_name'] }}</td>
                                    <td>
										<div class="success-urlpic">
                                        @if($value['success_url'])
											<a target="_blank" href="{{ $value['success_url'] }}">链接地址</a>
                                        @else
                                            @if ($value['success_pic'])
                                                 <img src="{{ $value['success_pic'] }}">
                                            @endif
                                        @endif
										</div>
                                    </td>
                                    <td class="color1">
                                        {{ getOrderType($value['order_type']) }}
                                    </td>
                                    <td><a class="color2" href="/console/manager/order/info/{{ $value['id'] }}">查看</a></td></tr>
                            @endforeach
                        @elseif(Request::input('type') == 10) {{-- 未匹配订单 --}}
                            @foreach($child_lists as $key => $value)
                                <tr>
                                    <td>{{ $value['id'] }}</td>
                                    <td>{{ $value['title'] }}</td>
                                    <td>{{ $value['type_name'] }}</td>
                                    <td class="color1">{{ $value['user_money'] }}</td>
                                    <td>{{ $value['username'] }}</td>
                                    <td>{{ $value['supp_user']['parent_user']['name'] }}</td>
                                    <td>{{ $value['supp_user']['media_name'] }}</td>
                                    <td>
										<div class="success-urlpic">
										@if($value['success_url'])
											<a target="_blank" href="{{ $value['success_url'] }}">链接地址</a>
										@else
											@if ($value['success_pic'])
												 <img src="{{ $value['success_pic'] }}">
											@endif
										@endif
										</div>
                                    </td>
                                    <td class="color1">
                                    {{ getOrderType($value['order_type']) }}
                                    @if($value['media_type'] == 12)
                                        重指派
                                    @endif

                                        
                                        {{-- {{ $value['qa_change'] ? $value['qa_change'] : 0 }} --}}
                                    </td>
                                    <td><a class="color2" href="/console/manager/order/info/{{ $value['id'] }}">查看</a></td></tr>
                            @endforeach
                        @elseif(Request::input('type') == 11) {{-- 未匹配订单 --}}
                            @foreach($child_lists as $key => $value)
                                <tr>
                                    <td>{{ $value['id'] }}</td>
                                    <td>{{ $value['title'] }}</td>
                                    <td>{{ $value['type_name'] }}</td>
                                    <td>{{ $value['start_at'] }}</td>
                                    <td>{{ $value['over_at'] }}</td>
                                    <td class="color1">{{ $value['user_money'] }}</td>
                                    <td>{{ $value['username'] }}</td>
                                    <td>{{ $value['supp_user']['media_name'] }}</td>
                                    <td class="color1">
                                    {{ getOrderType($value['order_type']) }}
                                    @if($value['media_type'] == 12)
                                        重指派
                                    @endif
                                    </td>
                                    <td><a class="color2" href="/console/manager/order/info/{{ $value['id'] }}">查看</a></td></tr>
                            @endforeach
                        @else
                            @foreach($child_lists as $key => $value)
                                <tr>
                                    <td>{{ $value['id'] }}</td>
                                    <td>{{ $value['title'] }}</td>
                                    <td>{{ $value['type_name'] }}</td>
                                    <td>{{ $value['start_at'] }}</td>
                                    <td>{{ $value['over_at'] }}</td>
                                    <td class="color1">{{ $value['user_money'] }}</td>
                                    <td>{{ $value['username'] }}</td>
                                    <td>{{ $value['supp_user']['parent_user']['name'] or '' }}</td>
                                    <td>{{ $value['supp_user']['media_name'] }}</td>
                                    <td>
										<div class="success-urlpic">
                                        @if($value['success_url'])
											<a target="_blank" href="{{ $value['success_url'] }}">链接地址</a>
										@else
											@if ($value['success_pic'])
												<img src="{{ $value['success_pic'] }}">
											@endif
										@endif
										</div>
                                    </td>
                                    <td class="color1">
                                    {{ getOrderType($value['order_type']) }}
                                    @if($value['deal_with_status'] == 2)
                                        ，重做
                                    @elseif($value['deal_with_status'] == 1)
                                        ，此订单退款处理
                                    @elseif($value['deal_with_status'] == 3) 
                                        ，不同意申诉，结款
                                    @endif
                                    @if($value['media_type'] == 12)
                                        重指派
                                    @endif
                                    </td>
                                    <td><a class="color2" href="/console/manager/order/info/{{ $value['id'] }}">查看</a></td></tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
            </div>

        </div>
    </div>
    </div>
</div>

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
	
	function get_excel()
	{
		var type = "{{Request::input('type')}}";
		if (!type) {
			type = 0;
		}
		url = "/console/manager/order/{{$media_id}}?type="+type+"&get_excel=1";
		url += "&start="+$("#datepicker1").val();
		url += "&end="+$("#datepicker2").val();
		url += "&mediatype="+$("#mediatype").val();
		url += "&orderid="+$("#keyword").val();
		window.open(url);
	}
	
	//<div id="datatable1_filter" class="dataTables_filter"><label>搜索<input type="search" class="" placeholder="过滤..." aria-controls="datatable1"></label></div>
    var datatable;
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
            
//	var _token = $('input[name="_token"]').val();
	$("#searchnews").click(function () {
		// get_order_list();
	})
            
	// get_order_list();

	function get_order_list()
	{
		$.ajax({
			type:"get",
			url:"/console/manager/order/{{$media_id}}",
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
					$('#listcontent').html("<tr><td colspan='10'>没有查询到数据！</td></tr>");           //7 表格列数
				}
			}
		})
	}

</script>

</body>
</html>
