<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>账户查询 - 亚媒社</title>
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
		<div class="place_ant"><a href="/console/index">首页</a><a href="/userpersonal/account_query" class="cur">账户查询</a></div>
	</div>
	
	<div class=" clearfix"><div class="main_aq">
		<div class="aq_left">
        	<h2>账户总金额</h2>
            <h1>{{$money_percent['money_all'] or '0.00'}}元</h1>
            <h2>余额</h2>
            <h1>{{$money_percent['user_money'] or '0.00'}}元</h1>
            <a href="{{url('userpersonal/onlnetop_up')}}" class="cz_left">充 值</a>
            <a href="{{url('userpersonal/account_enchashment')}}" class="tx_right">提 现</a>
        </div>
        <div class="aq_right">
        	<div class="aq_righttop" style="height: 400px;">
            	<!--	柱状图	-->
				<div class="minh tb_box6" id="tb_ptcx1"></div>
            </div>
            <!--<div class="aq_rightbottom">
            	<div class="snt" style="border-right:1px solid #ccc;"><hd>已完成订单数</hd><span>{{$order_count_all}}</span></div>
                <div class="snt"><hd>拥有媒体资源数</hd><span>52512</span></div>
            </div>-->
        </div>
	</div></div>



	{{ csrf_field() }}
	
	<div class="main_o clearfix margin_top_40" style="padding-bottom:0;">
		<h3 class="title3" style="padding:20px 30px 0 20px;"><strong>财务明细</strong>
			<a href="/userpersonal/account_query/type/0?get_excel=1" class="btn_o" id="get_excel" style="float:right; margin:5px 0px 0 0;" target="_blank">导出财务明细</a>
		</h3>
		

		<div class="dhorder_m">
			<div class="tab1">
				<ul>       
					<li @if(empty(Request::input('type'))) class="cur" @endif><a href="/userpersonal/account_query?type=0">全部</a></li>
					<li @if(Request::input('type') == 3) class="cur" @endif><a href="/userpersonal/account_query?type=3">提现</a></li>
					<li @if(Request::input('type') == 1) class="cur" @endif><a href="/userpersonal/account_query?type=1">充值</a></li>
					<li @if(Request::input('type') == 2) class="cur" @endif><a href="/userpersonal/account_query?type=2">消费</a></li>
				</ul>
				<div class="search_2">
					 <form action="" method="" name="">
						<div class="l">
							<span>起止时间</span>
						</div>

						<div class="l">
							<input type="text" class="txt2" id="datepicker1" />-<input type="text" class="txt2" id="datepicker2" />
						</div>
						<div class="l">
							<select name="" class="sel1" id="mediatype">
								@foreach($media as $key => $val)
									<option value="{{ $val['value'] }}">{{ $val['plate_name'] }}</option>
								@endforeach
							</select>
						</div>
						<div class="l">
							<input type="text" name="keyword" id="keyword" class="txt5" placeholder="订单号" />
							<input type="submit" name="submit" class="sub4_3" id="searchnews" value="查询" />
						</div>
					</form> 
				</div>

			</div>
			<div class="tab1_body" style="">
				<div class="tab1_body_m">
					<table class="table_in1 cur" id="datatable1">
						<thead>
							<tr>
								<th>日期</th>
								<th>订单号</th>
								<th>订单类型</th>
								<th>活动名称</th>
								<th>状态</th>
								<th>完成链接/截图</th>
								<th>金额</th>
							</tr>
						</thead>
						<tbody id="listcontent1">
							@foreach($order_list as $key => $val)
								<tr>
									<td>{{ $val['created_at'] }}</td>
									<td>{{ $val['order_id']}}</td>
									<td>{{ $val['type_name'] or '/'}}</td>
									<td>{{ $val['order_title']}}</td>
									<td>{{ $val['order_type'] }}</td>
									<td>{{ $val['success_url'] }} | <img src="{{$val['success_pic']}}"></td>
									<td><span class="color_red2">{{ $val['user_money'] }}元</span></td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="tab1_body_m" style="display:none;">
					<table class="table_in1 cur" id="datatable2">
						<thead>
							<tr>
								<th>日期</th>
								<th>订单号</th>
								<th>消费方式</th>
								<th>消费账号</th>
								<th>状态</th>
								<th>金额</th>
							</tr>
						</thead>
						<tbody id="listcontent2">
							@foreach($get_money as $key => $val)
								<tr>
									<td>{{ $val['created_at'] }}</td>
									<td>{{ $val['order_sn'] }}</td>
									<td>{{ $val['pay_type'] }}</td>
									<td>{{ $val['pay_user']}}</td>
									<td>{{ $val['order_status'] }}</td>
									<td><span class="color_red2">{{ $val['user_money'] }}元</span></td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="tab1_body_m" style="display:none;">
					<table class="table_in1 cur" id="datatable3">
						<thead>
							<tr>
								<th>日期</th>
								<th>订单号</th>
								<th>消费方式</th>
								<th>消费账号</th>
								<th>状态</th>
								<th>金额</th>
							</tr>
						</thead>
						<tbody id="listcontent3">
							@foreach($charge as $key => $val)
								<tr>
									<td>{{ $val['created_at'] }}</td>
									<td>{{ $val['order_sn'] }}</td>
									<td>{{ $val['pay_type'] }}</td>
									<td>{{ $val['pay_user'] }}</td>
									<td>{{ $val['order_type'] }}</td>
									<td><span class="color_red2">{{ $val['user_money'] }}元</span></td>
								</tr>
							@endforeach
							
						</tbody>
					</table>
				</div>
				<div class="tab1_body_m" style="display:none;">
					<table class="table_in1 cur" id="datatable4">
						<thead>
							<tr>
								<th>日期</th>
								<th>订单号</th>
								<th>订单类型</th>
								<th>订单名称</th>
								<th>订单状态</th>
								<th>截图/链接</th>
								<th>金额</th>
							</tr>
						</thead>
						<tbody id="listcontent4">
							@foreach($used as $key => $val)
								<tr>
									<td>{{ $val['created_at'] }}</td>
									<td>{{ $val['order_id'] }}</td>
									<td>{{ $val['type_name'] }}</td>
									<td>{{ $val['title'] }}</td>
									<td>{{ $val['order_type'] }}</td>
									<td><a href="{{ $val['success_url'] }}" target="_blank">
											<img class="link" src="{{ $val['success_pic'] }}" alt="链接/截图" />
										</a></td>
									<td><span class="color_red2">{{ $val['user_money'] }}元</span></td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div></div>

@include('console.share.admin_foot')

<script>

/*	饼状图	*/
if( $('#tb_aq1').length > 0 ){
	var myChart_hv2 = echarts.init(document.getElementById('tb_aq1'));
	option_hv2 = {
		title : {
			text: '',
			subtext: '',
			x:'75',
			y:'bottom',
			textStyle:{
				fontSize: '14',
				color: '#c23531',
				fontWeight: 'normal'
			}
		},
		tooltip : {
			trigger: 'item',
			formatter: "{a} <br/>{b} : {c} ({d}%)"
		},
		legend: {
			orient: 'vertical',
			left: 'left',
			data: []
		},
		series : [
			{
				name: '访问来源',
				type: 'pie',
				radius : '55%',
				center: ['60%', '55%'],
				data:[
					{value:{{$money_percent['user_money'] or 0}}, name:'总金额'},
					// {value:310, name:'充值金额'},
					{value:{{$money_percent['money_enchashment'] or 0}}, name:'提现金额'},
					{value:{{$money_percent['money_consume'] or 0}}, name:'消费金额'}
				],
				itemStyle: {
					emphasis: {
						shadowBlur: 10,
						shadowOffsetX: 0,
						shadowColor: 'rgba(0, 0, 0, 0.5)'
					}
				}
			}
		]
	};
	myChart_hv2.setOption(option_hv2);
}
	
</script>
<script>

var _token = $('input[name="_token"]').val();

/*	表格切换分页	*/
	var datatable0;
	var datatable1;
	var datatable2;
	var datatable3;
	var datatable4;
	$(function () {
			var dt_option = {
				"searching" : false,		//是否允许Datatables开启本地搜索
				"paging" : true,			//是否开启本地分页
				"pageLength" : 5,			//每页显示记录数
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
					"infoEmpty": " ",
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
			datatable1 =  $('#datatable1').DataTable(dt_option);
			datatable2 =  $('#datatable2').DataTable(dt_option);
			datatable3 =  $('#datatable3').DataTable(dt_option);
			datatable4 =  $('#datatable4').DataTable(dt_option);
			datatable0 = datatable1;
			
            $("#searchnews").click(function () {
				event.preventDefault();
				var data_table,
					index = $(".tab1 ul li.cur").index();
				if( index == "0" ){
					url = "/userpersonal/account_query/type/0";
					data_table = "#datatable1";
					data_tbody = "#listcontent1";
					datatable0 = datatable1;
				}
				if( index == "1" ){
					url = "/userpersonal/account_query/type/3";
					data_table = "#datatable2";
					data_tbody = "#listcontent2";
					datatable0 = datatable2;
				}
				if( index == "2" ){
					url = "/userpersonal/account_query/type/1";
					data_table = "#datatable3";
					data_tbody = "#listcontent3";
					datatable0 = datatable3;
				}
				if( index == "3" ){
					url = "/userpersonal/account_query/type/2";
					data_table = "#datatable4";
					data_tbody = "#listcontent4";
					datatable0 = datatable4;
				}
				console.log(index);
				console.log(url);
                $.ajax({
                    type:"get",
					url:url,
					dataType:'json',
                    data:{
                        'start':$("#datepicker1").val(),
                        'end':$("#datepicker2").val(),
                        'mediatype':$("#mediatype").val(),
                        'keytype':$("#keytype").val(),
                        'orderid':$("#keyword").val()
                    },
                    success:function (msg) {
                        if(msg){
							if( $.fn.dataTable.isDataTable(data_table) ){
								datatable0.destroy();
							}
							var htmls = "";
							for (i in msg) {
								console.log(msg[i]);
								htmls += "<tr>";
								htmls += "<td>"+msg[i]['created_at']+"</td>";
								htmls += "<td>"+msg[i]['order_id']+"</td>";
								htmls += "<td>"+msg[i]['type_name']+"</td>";
								htmls += "<td>"+msg[i]['title']+"</td>";
								htmls += "<td>"+msg[i]['order_type']+"</td>";
								htmls += "<td><a href=\""+msg[i]['success_url']+"\" target=\"_blank\"> <img class=\"link\" src=\""+msg[i]['success_pic']+"\" alt=\"链接/截图\"></a></td>";
								htmls += "<td><span class=\"color_red2\">"+msg[i]['user_money']+"元</span></td></tr>";
							}
							$(data_tbody).html(htmls);
							datatable0 =  $(data_table).DataTable(dt_option);
                        } else {
							if( $.fn.dataTable.isDataTable(data_table) ){
								datatable0.destroy();
							}
                            $(data_tbody).html("<tr><td colspan='7'>没有查询到数据！</td></tr>");			//7 表格列数
                        }
                        url += '&get_excel=1';
                        if (index == 3) {
                        	url += "&start="+$("#datepicker1").val();
	                        url += "&end="+$("#datepicker2").val();
	                        url += "&mediatype="+$("#mediatype").val();
	                        url += "&keytype="+$("#keytype").val();
	                        url += "&orderid="+$("#keyword").val();
                        }

                        $("#get_excel").attr('href',url);
						if( index == "0" ){	datatable1 = datatable0;	}
						if( index == "1" ){	datatable2 = datatable0;	}
						if( index == "2" ){	datatable3 = datatable0;	}
						if( index == "3" ){	datatable4 = datatable0;	}
                    }
                })
            })
			
		$(".tab1 ul li a").unbind("click");		/*	取消原切换事件，改成下面的新切换事件	*/
		$(".tab1>ul>li>a").click(function(){
			var index=$(this).parent("li").index();
			if (index == 3) { //消费
				$(".search_2").show();
			} else {
				$(".search_2").hide();
			}
			index = $(".tab1 ul li.cur").index();
			if( index == "0" ){
				url = "/userpersonal/account_query/type/0";
			}
			if( index == "1" ){
				url = "/userpersonal/account_query/type/3";
			}
			if( index == "2" ){
				url = "/userpersonal/account_query/type/1";
			}
			if( index == "3" ){
				url = "/userpersonal/account_query/type/2";
			}
			url += '&get_excel=1';
			$("#get_excel").attr('href',url);
			$(this).parent("li").addClass("cur").siblings("li").removeClass("cur");
			$(this).parents(".tab1").next(".tab1_body").find(".tab1_body_m").css("display","none").eq(index).css("display","block");
			return false;
		});
	})

</script>

</body>
</html>
