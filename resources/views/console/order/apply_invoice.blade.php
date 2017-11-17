<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>申请发票_喇叭传媒</title>
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

	<div class="place">
        <div class="place_ant"><a href="/">首页</a> <a   class="cur">申请发票 </a></div>
	</div>
	
	<div class="main_o">
		
		<h3 class="title5 clearfix"><strong>申请发票</strong></h3>
		
		<div class="clearfix wrap_f" style="padding-bottom:50px;">
	
			<div class="IF2">
				
				<form id="form_fp" action="" method="post">
					
					{{ csrf_field() }} 
					<div class="item_f">
						<p>订单号：</p>
						<input type="text" name="order_id" id="order_id" class="txt_f1" style="width:40%;"/>
					</div>
					<div class="item_f">
						<p>票据类型号：</p>
						<label class="rd1 css_cur"><input type="radio" name="invo_type" id="invo_type1" value="1" checked />收据</label>
						<label class="rd1"><input type="radio" name="invo_type" id="invo_type2" value="2" />普通发票（含税）</label>
						<label class="rd1"><input type="radio" name="invo_type" id="invo_type3" value="3" />专用发票（含税）</label>
					</div>
					<div class="item_f"><p>发票明细：</p>
						<select name="detail_type" id="detail_type" class="sel_f1">
						  @foreach($invo_detail as $key=>$value)
							<option value="{{$key}}">{{$value}}</option>
						  @endforeach
						</select>
					</div>
					<div class="item_f"><p>金额类型：</p>
						<label class="rd1 css_cur"><input type="radio" name="money_type" id="radio1" value="1" checked />充值金额</label>
						<label class="rd1"><input type="radio" name="money_type" id="radio2" value="2" /> &nbsp;消费金额</label>
					</div>
					<div class="item_f"><p>发票金额：</p>
						  <input type="text" name="money" id="money" class="txt_f1" style="width:15%;"/>
						  <span style="color:#ff0000; font-size:20px; margin-left:10px;">元</span>
					</div>
					<div class="item_f"><p>发送方式：</p>
						<label class="rd1 css_cur" onclick="Email.style.display='';dizhi.style.display='none';"><input type="radio" name="send_type" id="send_type1" value="1" checked />电子档</label>
						<label class="rd1" onclick="dizhi.style.display='';Email.style.display='none';"><input type="radio" name="send_type" id="send_type2" value="2" />纸质快递1000起</label>
					</div>
					<div class="item_f"><p>发票抬头：</p>
						<input type="text" name="invoice_title" id="invoice_title" class="txt_f1" style="width:40%;"/>
					</div>
					<div class="item_f" id="Email"><p>邮箱地址：</p>
						<input type="text" name="email" id="email" class="txt_f1" style="width:40%;"/>
					</div>
					<div class="item_f" id="dizhi" style="display: none;"><p>联系地址：</p>
						<input type="text" name="address" id="address" class="txt_f1"  style="width:40%;" />
					</div>
					<div class="item_f"><p>备注：</p>
						 <textarea name="remark" id="remark" class="txt_ft1" style="height:120px;width: 78%;"></textarea>
					</div>
					
					<div class="item_f">
						<p>&nbsp;</p>
						<input type="submit" name="button" id="button" value="提 交" class="sub5" style="margin-left:0;margin-top:50px;" />
					</div>
					
				</form>
				
			</div>
			
		</div>

	</div>	

</div></div>

@include('console.share.admin_foot')

<script type="text/javascript">
	
$(function(){
	$("ul.IFN5 li").click(function(){
		var piao_typeid = $(this).attr("data");
		$(this).addClass("cur").siblings("li").removeClass("cur");
		$("#piao_typeid").val( piao_typeid );
	});
});


</script>

</body>
</html>
