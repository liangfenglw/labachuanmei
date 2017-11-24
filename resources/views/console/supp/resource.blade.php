<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>媒体管理_喇叭传媒</title>
    @include('console.share.cssjs') 
</head>
<body class="fhide">         <!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')

<div class="content"><div class="Invoice">
    @include('console.share.user_menu')
    <div class="place">
        <div class="place_ant"><a href="/console/index">首页</a><a href="/supp/resource" class="cur">媒体管理 </a></div>
    </div>
    
    <div class="main_o">
        
        <h3 class="title4"><strong><a href="javascript:;">媒体推荐</a></strong>
            <ul class="add_resource2">
                @foreach($plate_lists as $key => $val)
                    <li><a href="/supp/resource/{{ $val['id'] }}">添加{{$val['plate_name']}}</a></li>
                @endforeach
            </ul>
			<div class="search_1" style="float:right;">
				<form action="/supp/uploadMedia" method="post" style="position:relative;float:left;" class="form_up" enctype="multipart/form-data">
                {!! csrf_field() !!}
					<a class="sub4_2" href="javascript:;" id="up_excel" style="background:#7db6eb;margin:0;" >导入媒体</a>
					<input type="file" name="file" class="txt6 txt6_up upfile upload_f1" style="width:100%;height:30px;display:none;opacity:0;"	/>
					<input type="hidden" name="plate_id" id="plate_id" />
				</form>
				<a class="sub4_2" style="background:#7db6eb;" href="javascript:;" id="get_excel" onclick="window.open('/uploads/file/供应商媒体上传模板.zip')">导出模板</a>
			</div>
        </h3>
		
        <div class="dhorder_m">
            <div class="tab1 2">
                <strong class="l" style="font-size:24px;font-weight:400;color:#000000;">媒体管理</strong>
                <ul id="nav2_ul">
                    @foreach($child_plate as $key => $val)
                        <li data-plateid={{ $val['id'] }} onclick="window.location='/order/order_appeal'" @if($key == 0) class="cur" @endif @if(Request::input('tid') == $val['id']) class="cur" @endif ><a  >{{ $val['plate_name'] }}({{ $val['res_count'] }})</a></li>
                    @endforeach
                </ul>
            </div>
            
            <div class="tab1_body" style="amin-height:515px;">
                @foreach($child_plate as $key => $val)
				<div class="tab1_body_m" style="@if($key == 0) display:block; @else display:none; @endif">
                    <table class="table_in1 @if($key == 0) cur @else cur @endif" id="datatable{{$key+1}}">
                        <thead>
                            <tr>
                                <th style="awidth:18%;">媒体名称</th>
                                <th>媒体类型</th>
                                <th>价格</th>
                                <th>订单数</th>
                                <th>审核状态</th>
                                <th>是否上架</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($val['lists'] as $kk => $vv)
                                <tr>
                                    <td class="logo-title">{{$vv['name']}}</td>
                                    <td>{{ $val['plate_name'] }}</td>
                                    <td class="color1">￥{{ $vv['proxy_price'] }}</td>
                                    <td>{{ $vv['order_count'] }}</td>
                                    <td>{{$state_status[$vv['is_state']]}}</td>
                                    <td class="color1">{{ $media_status[$vv['is_state']] }}</td>
                                    <td><a href="/supp/resource/info/{{ $vv['id'] }}" class="color2">查看</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
				</div>
                @endforeach
            </div>
            
            <div style="padding:50px 33px 10px;background:#fff;">
                <div class="info_hdorder clearfix">
                    <ul>
                        <li  class="cur"> {{ $all['res_count'] }}/个<br>媒体总数</li>
                        <li>  {{ $all['res_success'] }}<br>审核通过</li>
                        <li> {{ $all['res_del'] }}/个<br>下架媒体</li>
                        <li> {{ $all['res_check'] }}/个<br>待审核</li>
                        <!-- <li>平台数：  0</li> -->
                    </ul>
                </div>
            </div>
        </div>

    </div>  

</div></div>
@include('console.share.admin_foot')

<script type="text/javascript">
/*	表格切换分页	*/
	var datatable0;
	var datatable1;
	var datatable2;
	var datatable3;
	var datatable4;
	var datatable5;
	var datatable6;
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
				}
				,"order" : [[0,"desc"]]
			};
			datatable1 =  $('#datatable1').DataTable(dt_option);
			datatable2 =  $('#datatable2').DataTable(dt_option);
			datatable3 =  $('#datatable3').DataTable(dt_option);
			datatable4 =  $('#datatable4').DataTable(dt_option);
			datatable5 =  $('#datatable5').DataTable(dt_option);
			datatable6 =  $('#datatable6').DataTable(dt_option);
			datatable0 = datatable1;
			
			$(".tab1 ul li a").unbind("click");		/*	取消原切换事件，改成下面的新切换事件	*/
			$(".tab1>ul>li>a").click(function(){
				var index=$(this).parent("li").index();
				$(this).parent("li").addClass("cur").siblings("li").removeClass("cur");
				$(this).parents(".tab1").next(".tab1_body").find(".tab1_body_m").css("display","none").eq(index).css("display","block");
				return false;
			});

	});
	
	
	function get_excel(){
		var type = "";
		if (!type) {
			type = 0;
		}
		url = "/console/manager/order/35?type="+type+"&get_excel=1";
		url += "&start="+$("#datepicker1").val();
		url += "&end="+$("#datepicker2").val();
		url += "&mediatype="+$("#mediatype").val();
		url += "&orderid="+$("#keyword").val();
		window.open(url);
	}
	$(".form_up a").click(function(){
		var plate_id = $("#nav2_ul li.cur").attr("data-plateid");
		$("#plate_id").val( plate_id );
		console.log( plate_id );
		$(this).siblings(".upfile").click();
	});
	$(".upfile").change(function(){
		$(".form_up").submit();
	});

</script>

</body>
</html>