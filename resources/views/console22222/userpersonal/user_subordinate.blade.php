<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>代理会员详情 - 亚媒社</title>
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
		当前位置：<a href="/">代理会员管理</a> > 会员详情
	</div>
	
	<div class="main_o clearfix" style="padding-bottom:30px;">
	
		<h3 class="title3" style="padding:20px 30px 0 20px;"><strong>会员信息</strong>
			<a href=""><img class="title3_img" src="/console/images/arr_s.png" alt=""></a>
			<span class="title3_i"></span>
		</h3>

		<div class="safe_1 clearfix">

			<div class="wrap_fl clearfix" style="width:35%;">
				<form action="" method="post">
					<div class="item_f"><p><i class="LGntas"></i>用户名：</p>
						<div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" style="width:75%;" value="{{ $info['name'] }}" readonly="readonly"></div>
					</div>
					<div class="item_f"><p><i class="LGntas"></i>创建时间：</p>
						<div class="r"><input type="text" name="textfield" id="datepicker3" class="txt_f1" style="width:75%;" value="{{ $info['created_at'] }}" readonly="readonly"></div>
					</div>
					<div class="item_f"><p style="padding-top:25px;"><i class="LGntas"></i>会员头像：</p>
						<div class="r" style="position:relative;">
							<img src="{{ $info['head_pic'] }}" width="50%" id="img_upload" style="cursor:pointer;float:left;margin-right:8px;" />
						</div>
					</div>
					<div class="item_f"><p><i class="LGntas"></i>昵称：</p>
						<div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" style="width:75%;" readonly="readonly" value="{{ $info['nickname'] }}"></div>
					</div>
					<div class="item_f"><p><i class="LGntas"></i>联系电话：</p>
						<div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" style="width:75%;" readonly="readonly" value="{{ $info['mobile'] }}"></div>
					</div>
					<div class="item_f"><p><i class="LGntas"></i>联系QQ：</p>
						<div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" style="width:75%;" readonly="readonly" value="{{ $info['qq'] }}"></div>
					</div>
					<div class="item_f"><p><i class="LGntas"></i>邮箱：</p>
						<div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" style="width:75%;" readonly="readonly" value="{{ $info['email'] }}"></div>
					</div>
					<div class="item_f"><p><i class="LGntas"></i>联系地址：</p>
						<div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" style="width:75%;" readonly="readonly" value="{{ $info['address'] }}"></div>
					</div>
					{{-- <div class="item_f"><p><i class="LGntas"></i>状态：</p>
						<div class="r radio_w">
							<label><input type="radio" name="status" class="radio_f" value="1" />在线</label>
							<label><input type="radio" name="status" class="radio_f" value="2" />下架</label>
							<label><input type="radio" name="status" class="radio_f" value="3" />审核</label>
						</div>
					</div> --}}
					{{-- <div class="item_f item_f_2" style="margin-top:20px;">
						<div class="r"><input type="submit" value="提 交" class="sub_f1" style="margin-left:15%;" /></div>
					</div> --}}
				</form>
			</div>
			
			<div class="wrap_fr" style="width:47%;margin-right:2%;">
				<div class="wrap_fr3">
					<h3 style="padding-bottom:0;">一周订单统计数据表</h3>
				<!--	柱状图	-->
					<div class="" id="tb_hv1">
						
					</div>
					<h3 style="color:#1ab394;margin-top:60px;">账户盈利状况</h3>
					<div class="clearfix">
						<div class="l row3_22">
							<ul style="padding-top:18px;">
								<li class="li1">
									<p>会员总金额<br/>
										<b>￥{{ $user_money }}</b></p>
									<span></span></li>
								<li class="li2">
									<p>平台纯收益<br/>
										<b>￥{{ $commission }}</b></p>
									<span></span></li>
							</ul>
						</div>
					<!--	饼状图	-->
						<div class="r " id="tb_hv2">
							
						</div>
					</div>
					
				</div>
			</div>
				
		</div>
		
	</div>
	
	
	
	<div class="main_o clearfix" style="padding-bottom:0;">
	
		<h3 class="title3" style="padding:20px 30px 0 20px;"><strong>订单明细</strong>
			<a href=""><img class="title3_img" src="/console/images/arr_s.png" alt=""></a>
			<span class="title3_i"></span>
		</h3>


		<h3 class="title4 clearfix">
			<div class="search_1" style="float:none;margin-left:55px;margin-right:30px;">

				<div style="float:left;">
					<div class="l">
						<span>起始时间</span>
					</div>
					<div class="l">
						<input type="text" class="txt2" id="datepicker1" />-<input type="text" class="txt2" id="datepicker2" />
					</div>
					<div class="l">
						<select name="" class="sel1" id="mediatype">
							@foreach($media as $key => $val)
								<option value="{{ $val['id'] }}">{{ $val['plate_name'] }}</option>
							@endforeach
						</select>
					</div>
					<div class="l">
						<input type="text" name="keyword" id="keyword" class="txt5" placeholder="订单号" />
						<input type="submit" name="submit" class="sub4_3" id="searchnews" value="查询" />
					</div>
				</div>
				<a class="sub4_2" href="#" style="float:right;">导出订单明细</a>
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
			<th>活动名称</th>
			<th>订单类型</th>
			<th>开始时间</th>
			<th>结束时间</th>
			<th>平台价格</th>
			<th>返利</th>
			<th>订单状态</th>
			<th>完成链接/截图</th>
		</tr>
	</thead>
	<tbody id="listcontent">
		@forelse($data_lists as $key => $val)
			<tr>
			<td>{{ $val['order_id'] }}</td>
			<td>{{ $val['title'] }}</td>
			<td>{{ $val['type_name'] }}</td>
			<td>{{ $val['start_at'] }}</td>
			<td>{{ $val['over_at'] }}</td>
			<td class="color1">￥{{ $val['user_money'] }}</td>
			<td class="color1">￥{{ $val['commission'] }}</td>
			<td>{{ $val['order_type'] }}</td>
			<td class="link-pic"><a href="{{ $val['success_url'] }}"><img src="{{ $val['success_pic'] }}"></a></td>
		</tr>
		@empty
			<tr><td colspan='9'>没有查询到数据！</td></tr>
		@endforelse
	</tbody>
</table>
			</div>
		</div>

							
	</div>	

</div></div>



@include('console.share.admin_foot')

<script>
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
	if( $('#datepicker3').length>0 && typeof(picker3)!="object" ){
		var picker3 = new Pikaday({
			field: document.getElementById('datepicker3'),
			firstDay: 1,
			format: "YYYY-MM-DD",
			minDate: new Date('2000-01-01'),
			maxDate: new Date('2020-12-31'),
			yearRange: [2000,2020]
		});
	}

	var datatable;
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
			
			var _token = $('input[name="_token"]').val();
            $("#searchnews").click(function () {
                $.ajax({
                    type:"post",
					url:"/userpersonal/ajax_child_order_list",
					dataType: 'json',
                    data:{
						'start':$("#datepicker1").val(),
						'end':$("#datepicker2").val(),
						'mediatype':$("#mediatype").val(),
						'orderid':$("#keyword").val(),
						'user_id':{{$info['user_id']}},
						'_token':_token
                    },
                    success:function (msg) {
                        if (msg) {
							if( $.fn.dataTable.isDataTable(" #datatable1 ") ){
								datatable.destroy();
							}
							var htmls = "";
							for ( var i in msg) {
								htmls += '<tr>';
								htmls += '<td>'+msg[i]['order_id']+'</td>';
								htmls += '<td>'+msg[i]['title']+'</td>';
								htmls += '<td>'+msg[i]['type_name']+'</td>';
								htmls += '<td>'+msg[i]['start_at']+'</td>';
								htmls += '<td>'+msg[i]['over_at']+'</td>';
								htmls += '<td class="color1">'+msg[i]['user_money']+'</td>';
								htmls += '<td class="color1">'+msg[i]['commission']+'</td>';
								htmls += '<td>'+msg[i]['order_type']+'</td>';
								htmls += '<td class="link-pic"><a href="'+msg[i]['success_url']+'"><img src="'+msg[i]['success_pic']+'></a></td></td></tr>';
							}
							$('#listcontent').html(htmls);
							datatable =  $('#datatable1').DataTable(dt_option);
                        } else {
							if( $.fn.dataTable.isDataTable(" #datatable1 ") ){
								datatable.destroy();
							}
                            $('#listcontent').html("<tr><td colspan='9'>没有查询到数据！</td></tr>");			//7 表格列数
//                        window.location.reload();
                        }
                    }
                })
            })
	});
	
/*	柱状图	*/
if( $('#tb_hv1').length > 0 ){
	var myChart_hv1 = echarts.init(document.getElementById('tb_hv1'));
	option_hv1 = {
		color: ['#3398DB'],
		tooltip : {
			trigger: 'axis',
			axisPointer : {            // 坐标轴指示器，坐标轴触发有效
				type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
			}
		},
		grid: {
			left: '3%',
			right: '4%',
			bottom: '3%',
			containLabel: true
		},
		xAxis : [
			{
				type : 'category',
				data : ["{{$plate_data['35']['plate_name']}}", "{{$plate_data['37']['plate_name']}}", "{{$plate_data['38']['plate_name']}}", "{{$plate_data['39']['plate_name']}}", "{{$plate_data['40']['plate_name']}}", "{{$plate_data['41']['plate_name']}}", "{{$plate_data['42']['plate_name']}}","{{$plate_data['43']['plate_name']}}"],
				axisTick: {
					alignWithLabel: true
				}
			}
		],
		yAxis : [
			{
				type : 'value'
			}
		],
		series : [
			{
				name:'直接访问',
				type:'bar',
				barWidth: '60%',
				data:[{{$plate_data['35']['order_count']}}, {{$plate_data['37']['order_count']}}, {{$plate_data['38']['order_count']}}, {{$plate_data['39']['order_count']}}, {{$plate_data['40']['order_count']}}, {{$plate_data['41']['order_count']}}, {{$plate_data['42']['order_count']}},{{$plate_data['43']['order_count']}}]
			}
		]
	};
	myChart_hv1.setOption(option_hv1);
}

/*	饼状图	*/
if( $('#tb_hv2').length > 0 ){
	var myChart_hv2 = echarts.init(document.getElementById('tb_hv2'));
	option_hv2 = {
		title : {
			text: '代理会员占账户收益统计图',
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
			data: ['下属会员金额','账户总金额']
		},
		series : [
			{
				name: '访问来源',
				type: 'pie',
				radius : '45%',
				center: ['60%', '45%'],
				data:[
					{value:100, name:'下属会员金额'},
					{value:900, name:'账户总金额'}
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

</body>
</html>
