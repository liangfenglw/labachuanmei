<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>交易失败 - 亚媒社</title>
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

	<div class="banner2">
		<img src="{{url('console/images/banner2.jpg')}}" width="100%">
	</div>
	
	<div class="place">
		当前位置：<a href="/">首页</a> > 订单结算
	</div>
	
	<div class="main_o clearfix">
		
		<div class="w_success clearfix">
			<div class="w_success_t clearfix">
				<img src="{{url('console/images/no.png')}}" />
				<div>
					<h3>交易失败</h3>
					<p>感谢您使用喇叭传媒平台支付</p>
				</div>
			</div>
			<div class="w_success_m">
				@if($order_type!='recharge')<p>如果您有平台其他账户金额信息，<a href="/order/order_list">查看付款订单</a></p>@endif
				<p>您可能需要：<a href="/userpersonal/account_query">查看余额</a>|<a href="/userpersonal/account_query">消费记录</a>|<a href="/userpersonal/onlnetop_up">我要充值</a>|<a href="fapiao.php">申请发票</a></p>
			</div>
		</div>

							
	</div>	

</div></div>



@include('console.share.admin_foot')

</body>
</html>
