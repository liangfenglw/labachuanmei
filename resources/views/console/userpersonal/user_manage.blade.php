<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>会员管理_喇叭传媒</title>
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
		<div class="place_ant"><a href="/">首页</a> <a href="{{url('userpersonal/user_manage')}}"  class="cur">会员管理</a></div>
	</div>
	
	<div class="main_o" style="padding-bottom:0px; min-height:580px">
		
		<h3 class="title4"><strong><a href="javascript:;">会员管理</a></strong>
			<div class="search_1">
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
						<input type="text" name="keyword" id="keyword" class="txt5" placeholder="用户名" />
						<input type="submit" name="submit" class="sub4_3" id="searchnews" value="查询" />
						<a class="sub4_2" style="background:#7db6eb;" href="javascript:;" id="get_excel" onclick="get_excel()">导出列表</a>
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
			<th>序号</th>
			<th>用户名</th>
			<th>订单数</th>
			<th>订单金额</th>
			<th>订单提成</th>
			<th>创建时间</th>
            <th>状态</th>
			<th class="nosort">操作</th>
		</tr>
	</thead>
	<tbody id="listcontent">

	</tbody>
</table>
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
            $("#searchnews").click(function () {
            	get_son_order_list();
             })
            
    })
$(function(){
    get_order_list();
})

function get_order_list()
{
    $.ajax({
        type:"get",
        // url:"/console/manager/order/",
        dataType: 'html',
        data:{
            'start':$("#datepicker1").val(),
            'end':$("#datepicker2").val(),
            // 'mediatype':$("#mediatype").val(),
            'name':$("#keyword").val()
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
            }
        }
    })
}


</script>

</body>
</html>
