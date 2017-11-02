<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>会员信息修改 - 亚媒社</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
    @include('console.share.cssjs')
</head>
<body class="fold">			<!--	class="fold" 左导航收缩	-->
@include('console.share.admin_head')
@include('console.share.admin_menu')
<div class="content"><div class="Invoice">
	@include('console.share.user_menu')
	<div class="place">
		当前位置：<a href="/console/index">首页</a> > 用户信息
	</div>
	
	<div class="main_s">
		<h3 class="title3"><strong>用户资料</strong>
			<a href=""><img class="title3_img" src="{{url('console/images/arr_s.png')}}" alt="" /></a>
			<span class="title3_i"></span>
		</h3>
		<div class="safe_1 clearfix">
			<div class="wrap_fl clearfix">
				<form action="" method="post" enctype="multipart/form-data" id="user_form" onsubmit="return checkForm();">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<div class="item_f"><p><i class="LGntas"></i>用户名：</p>
						<div class="r"><input type="text" name="name" value="{{$user['name']}}" @if($user['name']) disabled @endif  class="txt_f1" style="width:50%;"></div>
					</div>
					<div class="item_f"><p style="padding-top:25px;"><i class="LGntas"></i>会员头像：</p>
						<div class="r" style="position:relative;">
							<img src="@if($user['head_pic']!='') {{$user['head_pic']}} @else {{url('console/images/z_add2.png')}} @endif" id="img_upload"  style="cursor:pointer;float:left;margin-right:8px;width:50%" />
							<input type="file" name="head_pic" id="documents_upload_button" onchange="loadImage(this)" placeholder="未选择任何文件" class="upload_f1" accept="image/*" style="" />
							<input type="hidden" name="head_pic_old" value="{{$user['head_pic']}}" />
							<span class="info1_f valign_m" style="height:95px;padding:0;">
								<i>*</i> 请点击选择图片，仅支持JPG、JPEG、GIF、PNG格式的图片文件，文件不能大于2MB。
							</span>
						</div>
					</div>
					<div class="item_f"><p><i class="LGntas"></i>昵称：</p>
						<div class="r"><input type="text" value="{{$user['nickname']}}"  name="nickname" class="txt_f1" style="width:50%;"></div>
					</div>
					<div class="item_f"><p><i class="LGntas"></i>企业名称：</p>
						<div class="r"><input type="text" value="{{$user['company']}}"  name="company" class="txt_f1" style="width:50%;"></div>
					</div>
					<div class="item_f"><p><i class="LGntas"></i>简介：</p>
						<div class="r">
							<textarea class="txt_ft1" name="breif" style="height:98px;">{{$user['breif']}} </textarea>
						</div>
						<div class="r">
							<span class="info1_f"><i>*</i> 请输入2-200个字的个人简介</span>
						</div>
					</div>
					<div class="item_f"><p><i class="LGntas"></i>联系人：</p>
						<div class="r"><input type="text" value="{{$user['contact']}}"  name="contact" class="txt_f1" style="width:50%;"></div>
					</div>
					<div class="item_f"><p><i class="LGntas"></i>QQ：</p>
						<div class="r"><input type="text" value="{{$user['qq']}}" name="qq"  class="txt_f1" style="width:50%;"></div>
					</div>
					<div class="item_f"><p><i class="LGntas"></i>手机：</p>
						<div class="r"><input type="text" name="mobile" value="{{$user['mobile']}}" disabled @if($user['mobile'])  @endif class="txt_f1" style="width:50%;"></div>
					</div>
					<div class="item_f"><p><i class="LGntas"></i>邮箱：</p>
						<div class="r"><input type="text" name="email" value="{{$user['email']}}" disabled @if($user['email']) disabled @endif class="txt_f1" style="width:50%;"></div>
						<div class="r">
							<span class="info1_f"><i>*</i> 请填写有效邮箱地址，以便接受通知及订单信息，建议使用QQ，hotmail等邮箱</span>
						</div>
					</div>
					<div class="item_f"><p><i class="LGntas"></i>地址：</p>
						<div class="r"><input type="text" name="address" value="{{$user['address']}}" class="txt_f1" style="width:50%;"></div>
					</div>
					<div class="item_f item_f_2" style="margin-top:50px;">
						<div class="r"><input type="submit" value="提 交" class="sub_f1" style="margin-left:15%;" /></div>
					</div>
				</form>
			</div>
			
			<div class="wrap_fr">
				<div class="wrap_fr1">
					<h3>完善资料</h3>
					<p>资料更完整，账号更安全。完善资料将帮助我们更好的提供服务。</p>
				</div>
				<div class="wrap_fr2">
					<img src="{{url('console/images/pic_ue.jpg')}}" />
				</div>
			</div>
				
		</div>
	</div>
	

</div></div>

@include('console.share.admin_foot')

<script type="text/javascript">
// 判断输入框是否为空
function checkForm(){
	
	var head_pic_old = $("#user_form").find("input[name='head_pic_old']").val();					
	var head_pic = $("#user_form").find("input[name='head_pic']").val();	

	var nickname = $("#user_form").find("input[name='nickname']").val();			
	var company = $("#user_form").find("input[name='company']").val();		
	var breif = $("#user_form").find("textarea[name='breif']").val();		
	var contact = $("#user_form").find("input[name='contact']").val();		
	var qq = $("#user_form").find("input[name='qq']").val();			
	var mobile = $("#user_form").find("input[name='mobile']").val();			
	var email = $("#user_form").find("input[name='email']").val();			
	var address = $("#user_form").find("input[name='address']").val();		


    if($.trim(head_pic) == '' && $.trim(head_pic_old) == '')
	{
        layer.msg('请上传会员头像');
		return false;
	}

    if($.trim(breif).length>200 || $.trim(breif).length<2)
	{
        layer.msg('请输入2-200个字的个人简介');
		return false;
	}

	// if ($.trim(mobile) !== '') {
	// 	if (!IsTel(mobile)) {
 //            layer.msg('请输入正确的手机号码');
	// 		return false;
	// 	};
	// };

	// if ($.trim(email) == '') {
 //        layer.msg('电子邮箱不能为空');
	// 	return false;
	// };

 //    if(!checkEmail(email))
	// {
 //        layer.msg('请输入正确的电子邮箱');
	// 	return false;
	// }

	return true;
}

        function IsTel(Tel) {
            var re = new RegExp(/^((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)$/);
            var retu = Tel.match(re);
            if (retu) {
                return true;
            } else {
                return false;
            }
        }


        /**
        * 邮箱格式判断
        * @param str
        */
        function checkEmail(str){
            var reg = /^[a-z0-9]([a-z0-9\\.]*[-_]{0,4}?[a-z0-9-_\\.]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+([\.][\w_-]+){1,5}$/i;
            if(reg.test(str)){
                return true;
            }else{
                return false;
            }
        }


function loadImage(img) {
            var filePath = img.value;
            var fileExt = filePath.substring(filePath.lastIndexOf("."))
                .toLowerCase();
 
            if (!checkFileExt(fileExt)) {
        		layer.msg('您上传的文件不是图片,请重新上传！');
                img.value = "";
                return;
            }
            if (img.files && img.files[0]) {
//                alert(img);
//                alert(img.files[0])
                // alert('你选择的文件大小' + (img.files[0].size / 1024).toFixed(0) + "kb");
                if ((img.files[0].size / 1024).toFixed(0)>2048) {
        			layer.msg('抱歉，你选择的文件不能超过2M');
                	return false;
				};
//                var xx = img.files[0];
//                for (var i in xx) {
//                    alert(xx[i])
//                }
            } else {
                img.select();
                var url = document.selection.createRange().text;
                try {
                    var fso = new ActiveXObject("Scripting.FileSystemObject");
                } catch (e) {
        			layer.msg('如果你用的是ie8以下 请将安全级别调低！');
                }
                // alert("文件大小为：" + (fso.GetFile(url).size / 1024).toFixed(0) + "kb");
                if ((img.files[0].size / 1024).toFixed(0)>2048) {
        			layer.msg('抱歉，你选择的文件不能超过2M');
                	return false;
				};
            }
        } 
        function checkFileExt(ext) {
            if (!ext.match(/.jpg|.gif|.png|.bmp/i)) {
                return false;
            }
            return true;
        }

//	$(".logo").addClass("hidden");
$(function(){
//	$(".sidebar-open-button").click();
});

</script>

</body>
</html>
