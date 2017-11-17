<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>已选媒体_喇叭传媒</title>
	<meta name="description" content="" />
	<meta name="keywords" content=""
    @include('console.share.cssjs')
	
	<style>

	</style>
</head>
<body class="fold">			<!--	class="fold" 左导航收缩	-->


@include('console.share.admin_head')
@include('console.share.admin_menu')			<!--	左弹菜单 普通会员首页	-->
{{ csrf_field() }}


<div class="content"><div class="Invoice">

	<div class="banner2">
		<img src="{{url('console/images/banner2.jpg')}}" width="100%">
	</div>
	
	<div class="place">
        <div class="place_ant"><a href="/">首页</a> <a  class="cur">已选媒体 </a></div>
	</div>
	
	<div class="main_o">
		
		<h3 class="title5 clearfix"><strong>全部订单</strong></h3>
		
		<div class="tab1_body">
		
<table class="table_in1 cur table_ah" id="datatable1">
	<thead>
		<tr>
			<th width="6%">勾选</th>
			<th>订单号</th>
			<th>稿件类型</th>
			<th>稿件名称</th>
			<th>生成时间</th>
			<th>金额</th>
			<th style="width:30%;">备注</th>
		</tr>
	</thead>
	<tbody id="listcontent">
	@if($cart_list)
	@foreach($cart_list as $key=>$value)
		<tr>
			<td><label><input type="checkbox" @if(in_array($value['order_sn'],$order_sns)) checked="checked" @endif  name="check_Item" data-id="{{$value['order_sn']}}" data-price="{{$value['user_money']}}"></label></td>
			<td>{{$value['order_sn']}}</td>
			<td>{{$value['type_name']}}</td>
			<td>{{$value['title']}}</td>
			<td>{{$value['created_at']}}</td>
			<td><span class="red price">￥{{$value['user_money']}}</span></td>
			<td class="bz">{{$value['remark']}}</td>
		</tr>
	@endforeach
	@else
	<tr><td><a>还没订单哦</a><td></tr>
	@endif
	
	</tbody>
</table>
		
		</div>

		<div class="info3 clearfix">
			<label><input type="checkbox" id="checkall"/>全选</label>
			<a href="#" class="delorder" id="delorder">删除失效定单</a>
			<a href="#" class="settle" id="settle">结算</a>
			<span class="sp1">结算总金额：<i class="red" id="sum">￥<b>0.00</b></i></span>
			<span class="sp2">已选定单 <i class="red" id="rows_order">1</i> 条</span>
		</div>
							
	</div>	

</div></div>

    <!--	支付弹窗	-->
    <div class="pay_info">
        <h3>总金额</h3>
        <h4 class="sum" id="sum2">￥<b>0.00</b></h4>
        <p>任务将由所下单媒体审核，若资源审核成功后便会执行发布，稍后注意前往我的喇叭传媒平台查看</p>
        <form action="" method="post" id="form1">
            <div class="item">
                <input type="password" name="pass" placeholder="请输入您的平台密码" class="pass" />
            </div>
            <div class="item">
                <button type="submit" class="sub" id="pay">支付</button>
            </div>
        </form>
    </div>

@include('console.share.admin_foot')

    <script type="text/javascript">
	var _token = $('input[name="_token"]').val();
        /*	计算金额	*/
        function reset_total(){
            var total=0;
            var rows_order=0;
            $("input[name='check_Item']").each(function(){
                var price=parseFloat($(this).attr("data-price"));
                if( $(this).is(":checked") ){
                    total += price;
                    rows_order++;
                }
            });
            $("#rows_order").text(rows_order);
            $("#sum b").text(total);
            $("#sum2 b").text(total);
        }
        $(".table_in1 input:checkbox").change(function(){
            reset_total();
        });

        /*	全选	*/
        $("#checkall").on("click",function(){
            if( $(this).is(":checked") ) {
                $("input[name='check_Item']").prop("checked",true);
            }else{
                $("input[name='check_Item']").prop("checked",false);
            }
            reset_total();
        });

        /*	删除选中订单	*/
        $("#delorder").click(function(){
        		var id_arr = [];
                $("input[name='check_Item']").each(function(){
                    if( $(this).is(":checked") ){
            			id_arr.push($(this).attr('data-id'));
                    }
                });
                if (id_arr == '') {
					layer.msg('请勾选订单');
					return false;
                };
            event.preventDefault();
            layer.confirm("确定要删除选中的订单吗？",{
                btn:["确定","取消"]
            },function(){



        		id_arr = id_arr.toString();

            	$.ajax({
					url: "delete_order",
					data: {
						'id_arr' : id_arr,
						'_token' : _token
					},
					type: 'post',
					dataType: "json",
					success: function (data) {
						/*layer.close(1);*/
						if (data.status == '1') {
                            $("input[name='check_Item']").each(function(){
                            	if( $.inArray($(this).attr('data-id'), data.data)>-1 ){
                            		console.log($(this).attr('data-id'));
			                        $(this).closest("tr").remove();
                            	}
			                });

			                layer.msg('删除成功', {icon: 1});
			                reset_total();
						} else if(data.status == '3'){
                            layer.msg(data.msg || '未找到失效订单');
						}else {
							layer.msg(data.msg || '操作失败');
						}
					},
					error: function (data) {
						layer.msg(data.msg || '网络发生错误');
						return false;
					}
				});

                // $("input[name='check_Item']").each(function(){
                //     if( $(this).is(":checked") ){
                //         $(this).closest("tr").remove();
                //     }
                // });
            },function(){
                layer.msg('删除已取消', {icon: 1});
            });
        });
        /*	点击结算弹出支付	*/
		var orderdata = [];
        $("#settle").click(function(){
            event.preventDefault();
			if( $("input[name=check_Item]:checked").length>0 ){
				var pay_order_id = '';
				var _token = $("input[name=_token]").val();
				var order_id = "";
				var price = $.trim($("#sum b").html());
				var open_status = 0;
				$("input[name=check_Item]:checked").each(function(){
					var order_id2 = $(this).closest("tr").attr("order_id");
					if( order_id == "" ){
						order_id += order_id2;
					}else{
						order_id += "," + order_id2;
					}
				});
			
				orderdata["_token"] = _token;
				orderdata["order_id"] = order_id;
				orderdata["price"] = price;


        		var id_arr = [];
                $("input[name='check_Item']").each(function(){
                    if( $(this).is(":checked") ){
            			id_arr.push($(this).attr('data-id'));
                    }
                });

        		id_arr = id_arr.toString();
				$.ajax({
					url: "check_order",
					data: {
						'id_arr' : id_arr,
						'_token' : _token
					},
					type: 'post',
					dataType: "json",
					success: function (data) {
						/*layer.close(1);*/
						if (data.status == '1') {
                            $("input[name='check_Item']").each(function(){
                            	if( $.inArray($(this).attr('data-id'), data.data)==-1 ){
                            		console.log($(this).attr('data-id'));
			                        // $(this).closest("tr").remove();
			                         $(this).attr("checked", false); 
                            	}else{
                            		pay_order_id += "," + $(this).attr('data-id');
                            	}
			                });
			                reset_total();

							layer.open({
								type: 1,
								title: " ",
								shadeClose: true, //开启遮罩关闭
								skin: 'pay_info_w', //加上class设置样式
								area: ['430px'], //宽高
								content: $(".pay_info")
							});
						}else {
							layer.msg(data.msg || '选中订单已失效');
							return false;
						}
					},
					error: function (data) {
						layer.msg(data.msg || '网络发生错误');
						return false;
					}
				});
			}else{
				layer.msg("请选择订单");
			}
        });
		/*	支付	*/
		$("#pay").click(function(){
			var pass = $("input[name=pass]").val();
			if( $.trim(pass) == "" || pass.length < 6 ){
				layer.msg("密码不能为空或者小于6位");
				return false;
			}

    		var id_arr = [];
            $("input[name='check_Item']").each(function(){
                if( $(this).is(":checked") ){
        			id_arr.push($(this).attr('data-id'));
                }
            });

        	id_arr = id_arr.toString();
			$.ajax({
					url: "cart_Settlement",
					data: {
						'id_arr' : id_arr,
						'password' : pass,
						'_token' : _token
					},
					type: 'post',
					dataType: "json",
					success: function (data) {
						/*layer.close(1);*/
						if (data.status == '1') {
                            layer.msg(data.msg || '提交成功');
                            window.location.href='/payment/pay_success/';
						} else if(data.status == '3') {
							layer.msg(data.msg);
                            setTimeout("window.location.href='/userpersonal/onlnetop_up'","2000");
						} else {
                            layer.msg(data.msg || '提交失败');
                        }
					},
					error: function (data) {
						layer.msg(data.msg || '网络发生错误');
						return false;
					}
				});
			
			return false;
		});
		
        reset_total();
		
    </script>
</body>
</html>
