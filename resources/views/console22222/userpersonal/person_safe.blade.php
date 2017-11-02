<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>安全设置 - 亚媒社</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />

    @include('console.share.cssjs')
	
	<style>

	</style>
</head>
<body class="fold">			<!--	class="fold" 左导航收缩	-->

@include('console.share.admin_head')
@include('console.share.admin_menu')


<div class="content"><div class="Invoice">

	
	@include('console.share.user_menu')

	<div class="place">
		当前位置：<a href="/">首页</a> > 用户信息
	</div>
	
	<div class="main_s">
		<h3 class="title3"><strong>安全设置</strong>
			<a href=""><img class="title3_img" src="{{url('console/images/arr_s.png')}}" alt="" /></a>
			<span class="title3_i"></span>
		</h3>
		<div class="safe_1">
					<div class="safe_1_t clearfix">
						<img src="{{url('console/images/avatar.png')}}" class="l">
						<div class="r">
							<p>会员帐号：{{$user['name']}}</p>
							@if($user_type == 2) <p>会员等级：{{$user['level_name']}}</p>@endif
							<p>注册时间：{{$user['created_at']}}</p>
						</div>
					</div>
					<div class="safe_1_m clearfix">
						<span class="l">您当前的帐号安全程度</span>
						<span class="r">安全级别：<i>{{$safe_type}}</i></span>
						<span class="m"><i style="width: {{$danger_percent}}%;"></i></span>	<!--	低 rank_L	中 rank_M	高 rank_H	-->
					</div>
					<div class="safe_1_b">
						<ul class="ul_table1">
							<li><span class="sp1">修改密码</span>
								<span class="sp2">安全性高的密码可以使帐号更安全。建议您定期更换密码，设置一个包含字母、符号、数字组成且长度不少于6位的密码。</span>
								<span class="sp3">
									<i class="@if($user['pw_status'])ok @else not-ok @endif">@if($user['pw_status'])已@else未@endif设置</i>
								</span>
								<span class="sp4">
									<a href="person_safe_changepass">@if($user['pw_status'])修改@else设置@endif</a>
								</span>
							</li>
							<li><span class="sp1">绑定手机</span>
								<span class="sp2">@if($user['mobile'])您的手机：{{substr_replace($user['mobile'],'*****',3,5)}}。@endif绑定认证后可用于手机找回密码、接收手机动态验证码等，使您的账户更加安全。</span>
								<span class="sp3">
									<i class="@if($user['mobile'])ok @else not-ok @endif">@if($user['mobile'])已@else未@endif绑定</i>
								</span>
								<span class="sp4">
									<a href="person_safe_phone">@if($user['mobile'])查看@else修改@endif</a>
								</span>
							</li>
							<li><span class="sp1">绑定邮箱</span>
								<span class="sp2">@if($user['email'])您的邮箱：{{$user['email']}}。@endif绑定认证后可用于邮箱找回密码、接受订单提醒、重置用户名等，保障您的账户更加安全。</span>
								<span class="sp3">
									<i class="@if($user['email'])ok @else not-ok @endif">@if($user['email'])已@else未@endif绑定</i>
								</span>
								<span class="sp4">
									<a href="person_safe_email">@if($user['email'])查看@else修改@endif</a>
								</span>
							</li>
							<li><span class="sp1">密保问题</span>
								<span class="sp2">设置安保问题可以进一步提升您的账户安全性及重置用户名。</span>
								<span class="sp3">
									<i class="@if($user['security_status'])ok @else not-ok @endif">@if($user['security_status'])已@else未@endif设置</i>
								</span>
								<span class="sp4">
									<a href="person_safe_question">@if($user['security_status'])修改@else设置@endif</a>
								</span>
							</li>
							<li><span class="sp1">证件信息</span>
								<span class="sp2">证件以及个人信息涉及您的隐秘信息，可以用于确认您的身份。</span>
								<span class="sp3">
									<i class="@if($user['certificate_status'])ok @else not-ok @endif">@if($user['certificate_status'])已@else未@endif设置</i>
								</span>
								<span class="sp4">
									<a href="@if($user_type == 2)person_safe_certificate @else /supp/user_check  @endif">@if($user['certificate_status'])修改@else设置@endif</a>
								</span>
							</li>
						</ul>
					</div>
				
				
		</div>
	</div>
	

</div></div>

@include('console.share.admin_foot')

<script type="text/javascript">

//	$(".logo").addClass("hidden");
$(function(){
//	$(".sidebar-open-button").click();
});

</script>

</body>
</html>
