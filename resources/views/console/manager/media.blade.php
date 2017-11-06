<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>媒体筛选分类管理</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    @include('console.share.cssjs')
    <style>
    </style>
</head>
<body class="fold">
<!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')
<!--    左弹菜单 普通会员首页 -->
<div class="content"><div class="Invoice">
    <div class="place">
        <div class="place_ant"><a href="/">首页</a><a  class="cur">媒体筛选分类管理 </a></div>
    </div>
    <form action="/console/manager/media" method="post" id="attr_form">
        {!! csrf_field() !!}
        <input type="hidden" name="val" value="" id="val">
        <input type="hidden" name="attr_id" value="" id="attr_id">
    </form>
    <div class="main_o clearfix" style="padding-bottom:0;">
        <h3 class="title4 clearfix"><strong><a>媒体筛选分类管理</a></strong></h3>
        <div class="dhorder_m">
            <div class="tab1">
                <ul class="tab_list_cm">
                    @foreach($plate_list as $key => $val)
                        <li class="cur"><a href="">{{$val['plate_name']}}</a></li>
                    @endforeach
                        <li class=""><a href="">户外媒体</a></li>
                        <li class=""><a href="">平台媒体</a></li>
                        <li class=""><a href="">。。媒体</a></li>
                </ul>
            </div>

            <div class="tab1_body" style="padding-bottom:35px;">
			
                <div class="tab1_body_m" style="display:block;">
                    <div class="list_cm">
						
						<h3 class="h_list_cm clearfix">
							@foreach($lists as $key => $val)
							<strong class="cur"><a href="">{{ $val['plate_name'] }}</a></strong>
							@endforeach
						</h3>
						
						<div class="body_list_cm">
							
							@foreach($lists as $key => $val)
							<div class="m_list_cm">
								@forelse($val['plate_vs_attr'] as $kk => $vv)
									<div class="item_list_cm clearfix" 			@if( $vv['id'] == 20 ) style="display:none;" @endif >
										<span class="sp1">{{ $vv['attr_name'] }}：</span>
										<ul data-id="{{$vv['id']}}">
											<li><a href="">不限</a></li>
											 @forelse($vv['attr_vs_val'] as $kkk => $vvv)
											<li data-id="{{$vvv['id']}}"><a href="">{{ $vvv['attr_value'] }}</a><i>x</i></li>
											@empty
											@endforelse
										</ul>
										<span class="sp2" title="按回车添加分类">
											<input  data-attr-id="{{$vv['id']}}" type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" />
										</span>
									</div>
								@empty
								@endforelse
								
								<!--<div class="" style="margin:25px 0 0;">
<table class="table_in1 cur" style="">
	<thead>
		<tr class="normal">
			<th style="">序号</th>
			<th>网站类型</th>
			<th>入口形式</th>
			<th>入口级别</th>
			<th>覆盖区域</th>
			<th>频道类型</th>
			<th>正文带链接</th>
			<th>收录参考</th>
			<th>价格</th>
			<th style="">操作</th>
		</tr>
	</thead>
	<tbody id="" class="">
		<tr>
			<td>1 {{$key}}</td>
			<td>全国门户</td>
			<td>文字标题</td>
			<td>网站首页</td>
			<td>全国</td>
			<td>新闻财经</td>
			<td>不带</td>
			<td>新闻源</td>
			<td class="color1">￥100.00</td>
			<td><a class="color2" href="/console/add_view?blade_name=list_3">查看</a></td>
		</tr>
		<tr>
			<td>2</td>
			<td>全国门户</td>
			<td>文字标题</td>
			<td>网站首页</td>
			<td>全国</td>
			<td>新闻财经</td>
			<td>不带</td>
			<td>新闻源</td>
			<td class="color1">￥100.00</td>
			<td><a class="color2" href="/console/add_view?blade_name=list_3">查看</a></td>
		</tr>
		<tr>
			<td>3</td>
			<td>全国门户</td>
			<td>文字标题</td>
			<td>网站首页</td>
			<td>全国</td>
			<td>新闻财经</td>
			<td>不带</td>
			<td>新闻源</td>
			<td class="color1">￥100.00</td>
			<td><a class="color2" href="/console/add_view?blade_name=list_3">查看</a></td>
		</tr>
		@if( $key == 0 )
		<tr>
			<td>4</td>
			<td>全国门户</td>
			<td>文字标题</td>
			<td>网站首页</td>
			<td>全国</td>
			<td>新闻财经</td>
			<td>不带</td>
			<td>新闻源</td>
			<td class="color1">￥100.00</td>
			<td><a class="color2" href="/console/add_view?blade_name=list_3">查看</a></td>
		</tr>
		@elseif( $key == 1 )
		<tr>
			<td>5</td>
			<td>全国门户</td>
			<td>文字标题</td>
			<td>网站首页</td>
			<td>全国</td>
			<td>新闻财经</td>
			<td>不带</td>
			<td>新闻源</td>
			<td class="color1">￥100.00</td>
			<td><a class="color2" href="/console/add_view?blade_name=list_3">查看</a></td>
		</tr>
		@else
		<tr>
			<td>4</td>
			<td>全国门户</td>
			<td>文字标题</td>
			<td>网站首页</td>
			<td>全国</td>
			<td>新闻财经</td>
			<td>不带</td>
			<td>新闻源</td>
			<td class="color1">￥100.00</td>
			<td><a class="color2" href="/console/add_view?blade_name=list_3">查看</a></td>
		</tr>
		<tr>
			<td>5</td>
			<td>全国门户</td>
			<td>文字标题</td>
			<td>网站首页</td>
			<td>全国</td>
			<td>新闻财经</td>
			<td>不带</td>
			<td>新闻源</td>
			<td class="color1">￥100.00</td>
			<td><a class="color2" href="/console/add_view?blade_name=list_3">查看</a></td>
		</tr>
		@endif
		
	</tbody>
</table>
								</div>-->
								
							</div>
							@endforeach
							
						</div>
						
						
						<div class="table">
						
						
						</div>
						
                    </div>
                </div>
				
                <div class="tab1_body_m" style="display:none;">
                    2       
                </div>
                <div class="tab1_body_m" style="display:none;">
                    3   
                </div>
                <div class="tab1_body_m" style="display:none;">
                    4   
                </div>
                <div class="tab1_body_m" style="display:none;">
                    5   
                </div>
                <div class="tab1_body_m" style="display:none;">
            6   
                </div>
                <div class="tab1_body_m" style="display:none;">
            7   
                </div>
                <div class="tab1_body_m" style="display:none;">
            8   
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>

@include('console.share.admin_foot')
<script>
	$(".h_list_cm strong a").click(function(){
		var index = $(this).parent("strong").index();
		$(this).parent("strong").addClass("cur").siblings("strong").removeClass("cur");
		$(this).closest(".list_cm").find(".body_list_cm .m_list_cm").eq(index).css("display","block").siblings().css("display","none");
		return false;
	});
	$(".h_list_cm strong").eq(0).find("a").click();
	
$(function(){

    $(".tab1>ul>li>a").unbind("click");     /*  取消原切换事件，改成下面的新切换事件  */
    $(".tab1>ul>li>a").click(function(){
        var index=$(this).parent("li").index();
        $(this).parent("li").addClass("cur").siblings("li").removeClass("cur");
        $(this).parents(".tab1").next(".tab1_body").find(".tab1_body_m").css("display","none").eq(index).css("display","block");
        return false;
    });

	
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:"post",
    });
/*  按回车添加分类 */
	$(".item_list_cm ul").on('click', 'li i', function(){
		var objli = $(this).closest("li");
		var id1 = objli.closest("ul").attr("data-id");
		var id2 = objli.attr("data-id");
		var txt = $(this).prev("a").html();
		layer.confirm("确认要删除 " + txt + " ?", {
			btn: [ '删除', '取消' ]
		}, function(index, layero){

			$.ajax({
                data:{"id":id2},
                url:"/console/manager/del_attr/"+id2,
                type:'post',
                dataType:'json',
                success:function(msg){
                    if (msg.status_code == 200) {
                        objli.remove();
                        layer.close(index);
                        layer.msg("删除分类 " + txt + " 成功");
                    } else {
                        layer.msg("删除分类 " + txt + " 失败");
                    }
                }
            })
						
		});
	});
    $('input.txt_cm').on('keypress',function(event){
        if(event.keyCode == 13){        //按回车
            var str = $.trim($(this).val());
            var att_id = $.trim($(this).attr('data-attr-id'));
            if( str == "" ){
                layer.msg("分类名称不能为空");
            }else{
                var flag = 0;
                $(this).closest(".item_list_cm").find("ul li a").each(function(){
                    var str2 = $(this).html();
                    if( str == str2 ){          //分类已存在
                        flag = 1;
                        return false;
                    }
                });
                if ( flag == 1) {
                    layer.msg("分类名称 "+str+" 已经存在");
                } else {
                    var obj = $(this);

                    $.ajax({
                        url:"/console/manager/media",
                        type:'post',
                        data:{"val":str,"attr_id":att_id},
                        dataType:"json",
                        async:"false",
                        success:function(msg){
							console.log(msg);
                            if (msg.status_code == 200) {
                                var newli = '<li><a href="#">' + str + '</a><i>x</i></li>';
                                obj.closest(".item_list_cm").find("ul").append(newli);
                                layer.msg("成功添加分类 " + str);
                                obj.val("");
                            } else {
                                layer.msg(msg.msg);
                                obj.val("");
                            }
                        },error:function(){

                        }
                    })
                    
                }
            }
        }
    }); 
	
	
	var datatable;
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
//	datatable =  $('#datatable1').DataTable(dt_option);
	datatable =  $('.table_in1').DataTable(dt_option);
	
});
</script>
</body>
</html>
