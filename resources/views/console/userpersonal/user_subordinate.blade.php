<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>代理会员详情_喇叭传媒</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
    @include('console.share.cssjs')
</head>
<body class="fold">			<!--	class="fold" 左导航收缩	-->

@include('console.share.admin_head')
@include('console.share.admin_menu')			<!--	左弹菜单 普通会员首页	-->


<div class="content"><div class="Invoice">


	@include('console.share.user_menu')

	<div class="place">
        <div class="place_ant"><a href="/console/index">首页</a> <a href="{{url('userpersonal/user_manage')}}"  class="cur">代理会员管理</a></div>
	</div>
	
	<div class="main_o clearfix" style="padding-bottom:30px;">
	
		<h3 class="title3" style="padding:20px 0 0 0;"><strong>代理会员详情</strong></h3>

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
							<img src="{{ $info['head_pic'] }}" width="50%" id="img_upload" style="cursor:pointer;float:left;margin-right:8px; width:130px; height:130px;" />
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
					{{-- VIP的审核 --}}
                    @if(in_array($info['check_status'], [2]))
                        <div class="item_f"><p><i class="LGntas"></i>状态：</p>
                            <div class="r radio_w">
                                <label class="rd1 @if($info['check_status'] == 4)  css_cur @endif"><input type="radio" name="check_status" class="radio_f" value="4" />通过</label>
                                <label class="rd1 @if($info['check_status'] == 2)  css_cur @endif"><input type="radio" name="check_status" class="radio_f" value="2" />审核</label>
                                <label class="rd1 @if($info['check_status'] == 3)  css_cur @endif"><input type="radio" name="check_status" class="radio_f" value="3" />不通过</label>
                            </div>
                        </div>
                    @else
                        <div class="item_f"><p><i class="LGntas"></i>状态：</p>
                            <div class="r radio_w">
                                <label class="rd1 @if($info['user']['is_login'] == 1)  css_cur @endif"><input  type="radio"  name="is_login" class="radio_f" value="1" />启用</label>
                                <label class="rd1 @if($info['user']['is_login'] == 2)  css_cur @endif"><input type="radio"  name="is_login" class="radio_f" value="2" />审核</label>
                                
                            </div>
                        </div>
                    @endif
				</form>
			</div>
			
			<div class="wrap_fr" style="width:47%;margin-right:2%;">
				<div class="wrap_fr3">
					<h3 style="padding-bottom:0;">一周订单统计数据表</h3>
				<!--	柱状图	-->
					<div class="tb_box3" id="tb_hv1">
						
					</div>
					<h3 style="color:#747474;margin-top:60px; text-align:left;">盈利状况</h3>
					<div class="clearfix">
						<div class="l row3_22">
							<ul style="padding-top:18px;">
								<li class="li1"><p>总订单数(已完成)<br/><b>{{ $info['parent_order_num'] }}</b></p></li>
								<li class="li2"><p>订单提成<br/><b>￥{{ $info['parent_order_commision'] }}</b></p></li>
							</ul>
						</div>
					<!--	饼状图	-->
						<div class="r tb_box4" id="tb_dl2"> <!--id="tb_hv2"-->
							
						</div>
					</div>
					
				</div>
			</div>
				
		</div>
		
	</div>
	
	
	
	<div class="main_o clearfix" style="padding-bottom:0;">
	
		<h3 class="title3" style="padding:20px 30px 0 20px;"><strong>订单列表</strong>
        <a class="btn_o" href="/userpersonal/user_subordinate/{{ $info['id'] }}" style="float:right; margin:5px 0 0 0;">导出列表</a>
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
						<select name="" class="sel1" id="mediatype" style="display:none;">
							<option value="35">网络媒体</option>
<!--
							@foreach($media as $key => $val)
								<option value="{{ $val['id'] }}">{{ $val['plate_name'] }}</option>
							@endforeach
-->
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
			<div class="tab1_body">
<table class="table_in1 cur" id="datatable1">
	<thead>
		<tr>
			<th>订单号</th>
			<th>稿件名称</th>
			<th>稿件类型</th>
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
<!--			<td class="link-pic"><a href="{{ $val['success_url'] }}"><img src="{{ $val['success_pic'] }}"></a></td>		-->
				<td class="link-pic">
					<div class="success-urlpic">
						@if( $val['success_url'] && $val['success_pic'] )
							<a target="_blank" href="{{ $val['success_url'] }}"><img src="{{ $val['success_pic'] }}"></a>
						@elseif( $val['success_url'] )
							<a target="_blank" href="{{ $val['success_url'] }}">链接地址</a>
						@elseif( $val['success_pic'] )
							<img src="{{ $val['success_pic'] }}">
						@else
						@endif
					</div>
				</td>
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
				"order" : [[0,"desc"]]
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
								htmls += '<td class="link-pic"><a href="'+msg[i]['success_url']+'"><img src="'+msg[i]['success_pic']+'"></a></td></td></tr>';
							}
							$('#listcontent').html(htmls);
							datatable =  $('#datatable1').DataTable(dt_option);
                        } else {
							if( $.fn.dataTable.isDataTable(" #datatable1 ") ){
								datatable.destroy();
							}
                            $('#listcontent').html("<tr><td colspan='9'>没有查询到数据！</td></tr>");
                        }
                    }
                })
            })
	});
if( $('#tb_dl2').length > 0 ){
	var myChart2 = echarts.init(document.getElementById('tb_dl2'));
	option2 = {
			title: {
				text: '用户账户金额分布统计图',
				left: 'center',
				top: '45px',
				textStyle:{ fontSize: '20', color: '#505050', fontFamily: 'SimHei', fontWeight: 'normal' },
			},
			tooltip: {
				trigger: 'item',
				formatter: "<div style='font-size:16px;line-height:30px;padding:5px;'>{b} <br/> {c} ({d}%)</div>"
			},
			color:['#5d9cec', '#fb6e52','#ffce55','#a0d468','#e2e2e2'],
			legend: {
				show: true,
				orient: 'vertical',
				left: '57%',
				top: '150px',
				itemGap: 50,
				itemWidth: 20,
				itemHeight: 22,
				textStyle:{ fontSize: '20' },
				data:['下属会员金额','帐户总金额']
			},
			grid: {
				containLabel: true
			},
			series: [
				{
					type:'pie',
					radius: ['40%', '50%'],
					center: ['30%', '60%'],
					avoidLabelOverlap: false,
					label: {
						normal: {
							show: false,
							position: 'center'
						},
						emphasis: {
							show: false,
							textStyle: { fontSize: '20', fontWeight: 'bold' }
						}
					},
					labelLine: {
						normal: { show: false }
					},
					data:[
						{value:1126, name:'下属会员金额'},
						{value:986, name:'帐户总金额'}
					]
				}
			]
	};
	myChart2.setOption(option2);
}

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
if( $('#tb_dl2').length > 0 ){
	var myChart2 = echarts.init(document.getElementById('tb_dl2'));
	option2 = {
			title: {
				text: '用户账户金额分布统计图',
				left: 'center',
				top: '45px',
				textStyle:{ fontSize: '20', color: '#505050', fontFamily: 'SimHei', fontWeight: 'normal' },
			},
			tooltip: {
				trigger: 'item',
				formatter: "<div style='font-size:16px;line-height:30px;padding:5px;'>{b} <br/> {c} ({d}%)</div>"
			},
			color:['#5d9cec', '#fb6e52','#ffce55','#a0d468','#e2e2e2'],
			legend: {
				show: true,
				orient: 'vertical',
				left: '57%',
				top: '150px',
				itemGap: 50,
				itemWidth: 20,
				itemHeight: 22,
				textStyle:{ fontSize: '20' },
				data:['订单提成','账户余额']
			},
			grid: {
				containLabel: true
			},
			series: [
				{
					type:'pie',
					radius: ['40%', '50%'],
					center: ['30%', '60%'],
					avoidLabelOverlap: false,
					label: {
						normal: {
							show: false,
							position: 'center'
						},
						emphasis: {
							show: false,
							textStyle: { fontSize: '20', fontWeight: 'bold' }
						}
					},
					labelLine: {
						normal: { show: false }
					},
					data:[
						{value:{{ $info['parent_order_commision'] }}, name:'订单提成'},
						{value:{{ $user_money }}, name:'账户余额'}
					]
				}
			]
	};
	myChart2.setOption(option2);
}
	
</script>

</body>
</html>
