<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>新增会员</title>
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
        <div class="place_ant"><a href="/console/index">首页</a> <a  class="cur">新增会员 </a></div>
        
	</div>
	
	<div class="main_o clearfix" style="padding-bottom:80px;">
	
		<h3 class="title4 clearfix"><strong><a>新增会员</a></strong></h3>
		
		<div class="clearfix">

			<div class="wrap_f clearfix" style="width:60%;">
				<form action="" enctype="multipart/form-data" id="user_form" method="post">

				{{ csrf_field() }}
					<div class="item_f"><p><i class="LGntas"></i>用户名：</p>
						<div class="r"><input type="text" name="name" id="name" class="txt_f1" style="width:38%;" value="{{ old('name') }}"></div>
					</div>
					<div class="item_f"><p><i class="LGntas"></i>密码：</p>
						<div class="r"><input type="password" name="password" id="password" class="txt_f1" style="width:38%;"></div>
					</div>
					<div class="item_f"><p style="padding-top:25px;"><i class="LGntas"></i>会员头像：</p>
						<div class="r" style="position:relative;">

							<div class="img_show">
								<img src="{{url('console/images/z_add2.png')}}" id="img_upload" style="cursor:pointer;float:left;margin-right:8px; width:130px; height:130px;" />
								<input type="file" name="head_pic" id="documents_upload_button" placeholder="未选择任何文件" class="txt6 txt6_up upfile upload_f1" accept="image/jpg,image/jpeg,image/gif,image/png" style="width:130px;height:130px;display:none;opacity:0;" />
							</div>
							
							<span class="info1_f valign_m" style="height:95px;padding:0;">
								<i>*</i> 请点击选择图片，仅支持JPG、JPEG、GIF、<br/>PNG格式的图片文件，文件不能大于2MB。
							</span>
						</div>
					</div>
					{{-- <div class="item_f"><p><i class="LGntas"></i>昵称：</p>
						<div class="r"><input type="text" name="nickname" id="nickname" class="txt_f1" style="width:38%;"></div>
					</div> --}}
					<div class="item_f"><p><i class="LGntas"></i>企业名称：</p>
						<div class="r"><input type="text" name="company" id="company" class="txt_f1" style="width:38%;" value="{{ old('company') }}"></div>
					</div>
					<div class="item_f"><p><i class="LGntas"></i>简介：</p>
						<div class="r">
							<textarea class="txt_ft1" name="breif" style="height:90px;width:70%;">{{ old('breif') }}</textarea>
						</div>
						<div class="r">
							<span class="info1_f"><i>*</i> 请输入2-200个字的个人简介</span>
						</div>
					</div>
					<div class="item_f"><p><i class="LGntas"></i>联系人：</p>
						<div class="r"><input type="text" name="contact" id="contact" class="txt_f1" style="width:38%;" value="{{ old('contact') }}"></div>
					</div>
					<div class="item_f"><p><i class="LGntas"></i>联系QQ：</p>
						<div class="r"><input type="text" name="qq" id="qq" class="txt_f1" style="width:38%;" value="{{ old('qq') }}"></div>
					</div>
					<div class="item_f"><p><i class="LGntas"></i>联系电话：</p>
						<div class="r"><input type="text" name="mobile" id="mobile" class="txt_f1" style="width:38%;" value="{{ old('mobile') }}"></div>
					</div>
					<div class="item_f"><p><i class="LGntas"></i>邮箱：</p>
						<div class="r"><input type="text" name="email" id="email" class="txt_f1" style="width:38%;" value="{{ old('email') }}"></div>
						<div class="r">
							<span class="info1_f"><i>*</i> 请填写有效邮箱地址，以便接受通知及订单信息，建议使用QQ，hotmail等邮箱</span>
						</div>
					</div>
					<div class="item_f"><p><i class="LGntas"></i>地址：</p>
						<div class="r"><input type="text" name="address" id="address" class="txt_f1" style="width:38%;" value="{{ old('address') }}"></div>
					</div>

					<div class="item_f item_f_2" style="margin-top:50px;">
						<div class="r"><input type="submit" value="提 交" class="sub5" style="margin-left:0" /></div>
					</div>
				</form>
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


</script>

</body>
</html>
