<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>活动管理</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    @include('console.share.cssjs')
</head>
<body class="fold"><!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')<!--    左弹菜单 普通会员首页 -->
<div class="content"><div class="Invoice">
    <div class="place">
        <div class="place_ant"><a href="/console/index">首页</a><a href="/console/activity/list" class="cur">活动管理 </a></div>
    </div>
    <div class="main_o clearfix" style="padding-bottom:20px;">
            <h3 class="title4 clearfix"><strong><a>活动管理</a></strong></h3>
            <div class="safe_1 clearfix">
                <div class="wrap_fl clearfix" style="width: 50%">
                    <form action="/console/activity/info/update" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="activity_id" value="{{ $info['id'] or 0 }}">
                        <div class="item_f"><p><i class="LGntas"></i>活动名称：</p>
                            <div class="r"><input type="text" name="activity_name" id="" class="txt_f1" style="width:75%;" value="{{ $info['activity_name'] or '' }}"></div>
                        </div>
                        <div class="item_f">
                            <p><i class="LGntas">*</i>开始时间:</p>
								<input type="text" name="start" id="datepicker1" class="txt2" value="{{ $info['start'] or '' }}" />
								<select class="sel_t1 options_h" name="name4_1">
									<option @if(!empty($start) && $start['0'] == '00') selected="selected" @endif value='00'>00</option>
                                    <option @if(!empty($start) && $start['0'] == '01') selected="selected" @endif value='01'>01</option>
                                    <option @if(!empty($start) && $start['0'] == '23') selected="selected" @endif value='23'>23</option>
								</select>时
								<select class="sel_t1 options_m" name="name4_2">
									<option @if(!empty($start) && $start['1'] == '00') selected="selected" @endif value='00'>00</option>
                                    <option @if(!empty($start) && $start['1'] == '01') selected="selected" @endif value='01'>01</option>
                                    <option @if(!empty($start) && $start['1'] == '59') selected="selected" @endif value='59'>59</option>
								</select>分
						</div>
						<div class="item_f"><p><i class="LGntas">*</i>截止时间:</p>
							<input type="text" name="over" id="datepicker2" class="txt2" value="{{ $info['over'] or '' }}" />
							<select class="sel_t1 options_h" name="name5_1">
                                <option @if(!empty($over) && $over['0'] == '00') selected="selected" @endif value='00'>00</option>
                                <option @if(!empty($over) && $over['0'] == '01') selected="selected" @endif value='01'>01</option>
                                <option @if(!empty($over) && $over['0'] == '23') selected="selected" @endif value='23'>23</option>
							</select>时
							<select class="sel_t1 options_m" name="name5_2">
                                <option @if(!empty($over) && $over['1'] == '00') selected="selected" @endif value='00'>00</option>
                                <option @if(!empty($over) && $over['1'] == '01') selected="selected" @endif value='01'>01</option>
                                <option @if(!empty($over) && $over['1'] == '59') selected="selected" @endif value='59'>59</option>
							</select>分
						</div>
                        <div class="item_f"><p><i class="LGntas"></i>平台优惠率：</p>
                            <div class="r">
                                <input type="text" name="plate_rate" id="" class="txt_f1" style="width:16%;" value="{{ $info['plate_rate'] or 100 }}">
                                <span class="color1" style="padding-left:10px;">%</span></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>会员优惠率：</p>
                            <div class="r">
                                <input type="text" name="vip_rate" id="" class="txt_f1" style="width:16%;" value="{{ $info['vip_rate'] or 100  }}">
                                <span class="color1" style="padding-left:10px;">%</span></div>
                        </div>
                        <div class="item_f item_f_2" style="margin-top:20px;">
                            <div class="r"><input type="submit" value="提 交" class="sub5" style="margin-left:0;" /></div>
                        </div>
                    </form>
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
                "order" : [[3,"desc"]]
            };
            datatable =  $('#datatable1').DataTable(dt_option);
//          var _token = $('input[name="_token"]').val();
            $("#searchnews").click(function () {
                $.ajax({
                    type:"post",
//                  url:"/Admin/searchnewspage",
                    url:"data_admin_order_list1.php",
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
                            $('#listcontent').html("<tr><td colspan='8'>没有查询到数据！</td></tr>");           //7 表格列数
//                        window.location.reload();
                        }
                    }
                })
            })
            
    })
	

</script>

</body>
</html>
