<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>订单管理_喇叭传媒</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />

    @include('console.share.cssjs')
	
	<style>
		#container{				max-width:100%;	}
		#edui1{					max-width:100%;	}
		#edui1_iframeholder{	max-width:100%;	}
	</style>
</head>
<body class="fold">			<!--	class="fold" 左导航收缩	-->


@include('console.share.admin_head')
@include('console.share.admin_menu')			<!--	左弹菜单 普通会员首页	-->


<div class="content"><div class="Invoice">

	
	@include('console.share.user_menu')

	<div class="place">
        <div class="place_ant"><a href="/">首页</a><a href="/order/order_list" class="cur">订单管理 </a></div>
	</div>
	
	<div class="main_o">
		
		<h3 class="title4"><strong><a href="/order/order_list">订单管理</a></strong>
			<div class="search_1">
		{{ csrf_field() }}

				<form method="" name="">

				<div style="float:right;">
					<div class="l">
						<span>起始时间</span>
					</div>
					<div class="l">
						<input type="text" class="txt2" id="datepicker1" name="start" value="{{ Request::input('start') }}" />-<input type="text" class="txt2" id="datepicker2" name="end" value="{{ Request::input('end') }}"/>
					</div>
					<div class="l">
						<select name="mediatype" class="sel1" id="mediatype">
							{{-- <option value="0">请选择</option> --}}
							<option value="35">网络媒体</option>
						</select>
					</div>
					<div class="l">
						<input type="text" name="orderid" value="{{ Request::input('orderid') }}" id="keyword" class="txt5" placeholder="订单号" />
						<input type="submit" name="submit" class="sub4_3" id="searchnews" value="查询" />
					</div>
				</div>
				</form>

			</div>
			<div class="clr"></div>
		</h3>
		<div class="dhorder_m" style="min-height:350px;">
			<div class="tab1">
				<ul>
				<!-- 	<li class="cur"><a href="">全部订单</a></li>
					<li><a href="">预约状态</a></li>
					<li><a href="">已完成</a></li>
					<li><a href="">正执行</a></li>
					<li><a href="">已流单</a></li>
					<li><a href="">已拒单</a></li>
					<li><a href="order_list1.php">申诉订单</a></li>
					<li><a href="">退还</a></li> -->
					<li @if($order_type == 0)class="cur" @endif><a href="/order/order_list">全部订单</a></li>
                    <li @if($order_type == 1)class="cur" @endif><a href="/order/order_list/1">预约状态</a></li>
                    <li @if($order_type == 5)class="cur" @endif><a href="/order/order_list/5">已完成</a></li>
                    <li @if($order_type == 4)class="cur" @endif><a href="/order/order_list/4">正执行</a></li>
                    <li @if($order_type == 3)class="cur" @endif><a href="/order/order_list/3">已流单</a></li>
                  {{--   <li @if($order_type == 2)class="cur" @endif><a href="/order/order_list/2">已拒单</a></li> --}}
                    <li @if($order_type == 100)class="cur" @endif><a href="/order/order_list/100">退款订单</a></li>
                    <li @if($order_type == 9)class="cur" @endif><a href="/order/order_list/9">申诉订单</a></li>
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
								<th>开始时间</th>
								<th>结束时间</th>
								<th>价格</th>
								<th>媒体名称</th>
								<th>完成链接/截图</th>
								<th>订单状态</th>
								<th class="nosort">操作</th>		<!--	（查看 退款）	-->
							</tr>
						@elseif( $order_type == 1 )
							<tr>
								<th>订单号</th>
								<th>稿件名称</th>
								<th>稿件类型</th>
								<th>开始时间</th>
								<th>结束时间</th>
								<th>价格</th>
								<th>媒体名称</th>
								<th>订单状态</th>
								<th>完成链接/截图</th>
								<th class="nosort">操作</th>		<!--	（查看 退款）	-->
							</tr>
						@elseif( $order_type == 5 )
							<tr>
								<th>订单号</th>
								<th>稿件名称</th>
								<th>稿件类型</th>
								<th>价格</th>
								<th>媒体名称</th>
								<th>完成链接/截图</th>
								{{-- <th>质检状态</th> --}}
								<th>订单状态</th>
								<th class="nosort">操作</th>		<!--	（查看）	-->
							</tr>
						@elseif( $order_type == 4 )
							<tr>
								<th>订单号</th>
								<th>稿件名称</th>
								<th>稿件类型</th>
								<th>价格</th>
								<th>媒体名称</th>
								<th>完成链接/截图</th>
								<th>订单状态</th>
								<th class="nosort">操作</th>		<!--	（查看 退款）	-->
							</tr>
						@elseif( $order_type == 3 )
							<tr>
								<th>订单号</th>
								<th>稿件名称</th>
								<th>稿件类型</th>
								<th>开始时间</th>
								<th>结束时间</th>
								<th>价格</th>
								<th>媒体名称</th>
								<th>订单状态</th>
								<th class="nosort">操作</th>		<!--	（查看）	-->
							</tr>
						{{-- @elseif( $order_type == 2 )
							<tr>
								<th>订单号</th>
								<th>稿件名称</th>
								<th>稿件类型</th>
								<th>开始时间</th>
								<th>结束时间</th>
								<th>价格</th>
								<th>媒体名称</th>
								<th>订单状态</th>
								<th class="nosort">操作</th>		<!--	（查看）	-->
							</tr> --}}
						@elseif( $order_type == 100 )
							<tr>
								<th>订单号</th>
								<th>稿件名称</th>
								<th>稿件类型</th>
								<th>开始时间</th>
								<th>结束时间</th>
								<th>价格</th>
								<th>媒体名称</th>
								<th>订单状态</th>
								<th>退款状态</th>
								<th class="nosort">操作</th>		<!--	（查看 取消退款）	-->
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
						<!--
								<tr>
									<th>订单号</th>
									<th>活动名称</th>
									<th>订单类型</th>
									<th>开始时间</th>
									<th>结束时间</th>
									<th>价格</th>
									<th>订单状态</th>
									@if($user_array['level_id'] == 2)
									<th>所属用户</th>
									@endif
									<th>完成链接/截图</th>
									<th class="nosort">操作</th>
								</tr>
						-->
					</thead>
					<tbody id="listcontent">
						@foreach($order_list as $key => $value)
							@if($order_type == 1)
								<tr>
									<td>{{ $value['id'] }}</td>
		                            <td>{{ $value['title'] }}</td>
		                            <td>{{ $value['type_name'] }}</td>
		                             <td>{{ $value['start_at'] }}</td>
		                            <td>{{ $value['over_at'] }}</td>
		                            <td class="color1">￥{{ $value['user_money'] }}</td>
									<td>{{ $value['self_user']['media_name'] }}</td>
		                            <td>{{ $status[$value['order_type']] }}</td>
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
		                            <td><a class="color2" href="/order/order_detail/{{ $value['id'] }}">查看</a></td>
		                        </tr>
							@elseif($order_type == 4) {{-- 正执行 --}}
								<tr>
									<td>{{ $value['id'] }}</td>
		                            <td>{{ $value['title'] }}</td>
		                            <td>{{ $value['type_name'] }}</td>
		                            <td class="color1">￥{{ $value['user_money'] }}</td>
										<td>{{ $value['self_user']['media_name'] }}</td>
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
		                            <td><a class="color2" href="/order/order_detail/{{ $value['id'] }}">查看</a></td>
		                        </tr>
		                    @elseif($order_type == 5) {{-- 已完成 --}}
								<tr>
									<td>{{ $value['id'] }}</td>
		                            <td>{{ $value['title'] }}</td>
		                            <td>{{ $value['type_name'] }}</td>
		                            <td class="color1">￥{{ $value['user_money'] }}</td>
										<td>{{ $value['self_user']['media_name'] }}</td>
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
		                            <td>
		                            	@if($value['order_type'] == 13 && $value['deal_with_status'] == 3)
		                            		拒绝退款，订单完成
		                            	@else
		                            		{{ $status[$value['order_type']] }}
		                            	@endif
	                            	</td>
		                            <td><a class="color2" href="/order/order_detail/{{ $value['id'] }}">查看</a></td>
		                        </tr>
		                    @elseif($order_type == 9) {{-- 已完成 --}}
								<tr>
									<td>{{ $value['id'] }}</td>
		                            <td>{{ $value['type_name'] }}</td>
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
		                            <td><a class="color2" href="/order/order_detail/{{ $value['id'] }}">查看</a></td>
		                        </tr>
		                    @elseif($order_type == 100)
		                    	<tr>
									<td>{{ $value['id'] }}</td>
		                            <td>{{ $value['title'] }}</td>
		                            <td>{{ $value['type_name'] }}</td>
		                            <td>{{ $value['start_at'] }}</td>
		                            <td>{{ $value['over_at'] }}</td>
		                            <td class="color1">￥{{ $value['user_money'] }}</td>

										<td>{{ $value['self_user']['media_name'] }}</td>
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
		                            <td>
		                            	@if($value['order_type'] == 13 && $value['deal_with_status'] == 3)
		                            		退款失败
		                            	@else
		                            		{{ $status[$value['order_type']] }}</td>
		                            	@endif
		                            	
		                            <td><a class="color2" href="/order/order_detail/{{ $value['id'] }}">查看</a></td>
		                        </tr>
							@elseif($order_type == 3)
		                    	<tr>
									<td>{{ $value['id'] }}</td>
		                            <td>{{ $value['title'] }}</td>
		                            <td>{{ $value['type_name'] }}</td>
		                            <td>{{ $value['start_at'] }}</td>
		                            <td>{{ $value['over_at'] }}</td>
		                            <td class="color1">￥{{ $value['user_money'] }}</td>
									<td>{{ $value['self_user']['media_name'] }}</td>
		                            
		                            <td>
		                            	@if($value['order_type'] == 13 && $value['deal_with_status'] == 3)
		                            		退款失败
		                            	@else
		                            		{{ $status[$value['order_type']] }}</td>
		                            	@endif
		                            	
		                            <td><a class="color2" href="/order/order_detail/{{ $value['id'] }}">查看</a></td>
		                        </tr>
							@else 
								<tr>
									<td>{{ $value['id'] }}</td>
		                            <td>{{ $value['title'] }}</td>
		                            <td>{{ $value['type_name'] }}</td>
		                            <td>{{ $value['start_at'] }}</td>
		                            <td>{{ $value['over_at'] }}</td>
		                            <td class="color1">￥{{ $value['user_money'] }}</td>

										<td>{{ $value['self_user']['media_name'] }}</td>
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
		                            <td><a class="color2" href="/order/order_detail/{{ $value['id'] }}">查看</a></td>
		                        </tr>
	                        @endif
                    	@endforeach
					</tbody>
				</table>
			</div>
			<div style="padding:0px 22px;background:#fff;">
				<div class="info_hdorder clearfix">
					<ul>
					       <li class="cur">{{ $order_statistics['all_count'] or 0}}个/{{ $order_statistics['all_money'] or 0 }}元<br/>总订单数</li>
                            <li>{{ $order_statistics['success_count'] }}个/{{ $order_statistics['success_money'] or 0 }}元<br/>已完成</li>
                            <li>{{ $order_statistics['flow_order_count'] }}个/{{ $order_statistics['flow_order_money'] or 0 }}元<br/>流单数</li>
                            <li>{{ $order_statistics['give_up_count'] }}个/{{ $order_statistics['give_up_money'] or 0 }}元<br/>取消数</li>
                            <li>{{ $order_statistics['refuse_order'] }}个/{{ $order_statistics['refuse_money'] or 0 }}元<br/>拒单数</li>
					</ul>
	       		    </div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
@include('console.share.admin_foot')

<!--	退款弹窗	-->
<div class="yueyue_info tuikuan_info clearfix" style="display: none;">
	
	<h3 class="title5 clearfix"><strong style="color:#0582f5;">申请退款</strong></h3>
	
	<div class="clearfix wrap_f" style="padding-bottom:50px;width:80%;">
		<form action="" method="post">
											
			<div class="item_f"><p><i class="LGntas"></i>退款原因：</p>
				<div class="r" id="ue_box">
					<script id="container" name="content" type="text/plain" style="amax-width:850px;height:150px;awidth:auto;"></script>
				</div>
			</div>
			<div class="item_f"><p><i class="LGntas"></i>退款金额：</p>
				<div class="r">
					<input type="text" name="" id="" class="txt_f1" style="" value="" /><span class="color1" style="padding-left:10px;">元</span>
				</div>
			</div>

			<div class="item_f item_f_2" style="margin-top:30px;">
				<div class="r"><input type="submit" value="提 交" class="sub5" style="margin:0;"></div>
			</div>

		</form>
	</div>
	
</div>


<script type="text/javascript">
/*	日历	*/
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
				"searching" : false,		//是否允许Datatables开启本地搜索
				"paging" : true,			//是否开启本地分页
				"pageLength" : 8,			//每页显示记录数
				"lengthChange" : false,		//是否允许用户改变表格每页显示的记录数 
				"lengthMenu": [ 5, 10, 100 ],		//用户可选择的 每页显示记录数
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
			
	})

/*	退款	*/

	var ue = UE.getEditor('container');
	$("tbody").on("click", ".tuikuan", function(){
		var id = $(this).attr("data-id");
		console.log("id:",id);
		event.preventDefault();
		layer.open({
			type: 1,
			title: " ",
			shadeClose: true, //开启遮罩关闭
			skin: 'yuyue_info_w', //加上class设置样式
			area: ['65%','80%'], //宽高
			content: $(".tuikuan_info"),
			success: function(layero){
				layer.setTop(layero); //重点2
//				$(".yuyue_info").css("z-index","100000");
				if( typeof(ue) == "object" ){
//					console.log("object..");
					$("#edui4_body").click();
					$("#edui4_body").click();
				}else{
//					console.log("not object..");
					
				}
			}
		});

		return false;
	});
	
</script>

</body>
</html>
