<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>订单管理</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />

    @include('console.share.cssjs')
	
	<style>

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
							<option value="0">请选择</option>
							<option value="35">网络媒体</option>
						</select>
					</div>
					<div class="l">
						<input type="text" name="keyword" id="keyword" class="txt5" placeholder="订单号" />
						<input type="submit" name="submit" class="sub4_3" id="searchnews" value="查询" />
					</div>
				</div>
<!--
				</form>
-->
			</div>
			<div class="clr"></div>
		</h3>
		<div class="dhorder_m">
			<div class="tab1">
				<ul>
					<li @if($order_type == 0)class="cur" @endif><a href="/order/order_list">全部订单</a></li>
                    <li @if($order_type == 1)class="cur" @endif><a href="/order/order_list/1">预约状态</a></li>
                    <li @if($order_type == 5)class="cur" @endif><a href="/order/order_list/5">已完成</a></li>
                    <li @if($order_type == 4)class="cur" @endif><a href="/order/order_list/4">正执行</a></li>
                    <li @if($order_type == 3)class="cur" @endif><a href="/order/order_list/3">已流单</a></li>
                    <li @if($order_type == 2)class="cur" @endif><a href="/order/order_list/2">已拒单</a></li>
                    <li @if($order_type == 100)class="cur" @endif><a href="/order/order_list/100">退款订单</a></li>
                    <li @if($order_type == 9)class="cur" @endif><a href="/order/order_list/9">申诉订单</a></li>
					<!-- <li><a href="">退还</a></li> -->
				</ul>
				<a class="btn_o" href="/order/order_appeal">订单申诉</a>
			</div>
			<div class="tab1_body">
<table class="table_in1 cur" id="datatable1">
	<thead>
		<tr>
			<th>订单号</th>
			<th>稿件类型</th>
			<th>完成链接/截图</th>
			<th>申诉标题</th>
			<th>申诉时间</th>
			<th>申诉状态</th>
<!--
			<th>所属于用户</th>
-->
			<th class="nosort">操作</th>
		</tr>
	</thead>
	<tbody id="listcontent">
		
	</tbody>
</table>
			</div>
					
<!--
			<div class="page_1" style="margin-top:15px;padding-bottom:15px;">
				<span class="info">显示第 0 至 0 项结果，共 0 项</span>
				<span class="pages">
<a href="" class="prev">上一页</a>
<a href="" class="cur">1</a>
<a href="">2</a>
<a href="">3</a>
<a href="">4</a>
<a href="">5</a>
<span class="sus">...</span>
<a href="">248</a>
<a href="" class="next">下一页</a>
				</span>
			</div>
-->
		
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
	

</div></div>

@include('console.share.admin_foot')

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
//			var _token = $('input[name="_token"]').val();

                getOrderList();
            var _token = $('input[name="_token"]').val();
            $("#searchnews").click(function () {
                getOrderList();
            })
            function getOrderList() {
                $.ajax({
                    type:"get",
                    url:"order_list",
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
                            $('#listcontent').html("<tr><td colspan='8'>没有查询到数据！</td></tr>");           //7 表格列数
//                        window.location.reload();
                        }
                    }
                })
            }
			
	})


</script>

</body>
</html>
