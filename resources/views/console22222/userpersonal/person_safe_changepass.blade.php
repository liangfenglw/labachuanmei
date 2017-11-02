<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>安—修改密码 - 亚媒社</title>
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
		当前位置：<a href="putong_index.php">首页</a> > <a href="person_edit.php">用户信息</a> > <a href="person_safe.php">安全设置</a>
	</div>
	{{ csrf_field() }}
	<div class="main_s">
		<h3 class="title3"><strong>修改密码</strong>
			<a href=""><img class="title3_img" src="{{url('console/images/arr_s.png')}}" alt="" /></a>
			<span class="title3_i"></span>
		</h3>
		
		<div class="safe_2 clearfix">
					<div class="WMain3 WMain3_2 clearfix"><p><i class="LGntas"></i>会员帐号：</p>
						{{$user['name']}}
					</div>
					<div class="WMain3 WMain3_2 clearfix"><p><i class="LGntas"></i>旧密码：</p>
						<input type="password" name="user_password_old" id="user_password_old" class="txt6"  style="height: 40px;">
					</div>
					<div class="WMain3 WMain3_2 clearfix"><p><i class="LGntas"></i>新密码：</p>
						<input type="password" name="user_password_new" id="user_password_new" class="txt6"  style="height: 40px;">
						<div>由字母、数字和特殊符号组成，区分大小写(6~16个字符)。示例：cndns456@#!</div>
					</div>
					<div class="WMain3 WMain3_2 clearfix"><p><i class="LGntas"></i>确认密码：</p>
						<input type="password" name="user_password_new_confirmation" id="user_password_new_confirmation" class="txt6"  style="height: 40px;">
					</div>
					<div class="WMain3 WMain3_2 clearfix" style="margin-top:50px;">
						<input type="submit" id="submit_button" value="提交" class="sub5">
					</div>
					<div class="clr"></div>
		</div>
		<div class="safe2_b" style="width:auto;">
<div style="width:440px;margin:0 auto;text-align:left;position:relative;left:25px;">
密码设置技巧<br/>
密码设置至少6位以上，由数字、字母和符号混合而成，安全性较高。<br/>
不要和用户名太相似，这样容易被人猜到。<br/>
不要用手机号、电话号码、生日、学号、身份证号等个人信息。<br/>
<br/>
友情提醒：用户名和密码要做好相应记录，以免忘记。
</div>
		</div>

		
	</div>
	

</div></div>

@include('console.share.admin_foot')

<script type="text/javascript">
        var _token = $('input[name="_token"]').val();

            function checkpw(pw) {

    			var reg = new RegExp("[a-zA-Z]");
    			var retu = pw.match(reg);
    			reg = new RegExp("[0-9]");
    			retu = pw.match(reg);

    			reg = new RegExp("((?=[\x21-\x7e]+)[^A-Za-z0-9])");
    			retu = pw.match(reg);

                if (retu) {
                    return true;
                } else {
                    return false;
                }
            }


        $('#submit_button').click(function () {

            var user_password_old= $('#user_password_old').val();

            var user_password_new = $('#user_password_new').val();
            var user_password_new_confirmation = $('#user_password_new_confirmation').val();

            if (user_password_old == '') {
                layer.msg('旧密码不能为空');
                return false;
            } 


            if (user_password_new == '') {
                layer.msg('新密码不能为空');
                return false;
            } else {
            	if (user_password_new.length>16 || user_password_new.length<6 ) {
                    layer.msg('新密码必须由字母、数字和特殊符号组成，区分大小写(6~16个字符4)');
                    return false;
            	};
                if (!user_password_new) {
                    layer.msg('新密码必须由字母、数字和特殊符号组成，区分大小写(6~16个字符)');
                    return false;
                }

                if (user_password_new_confirmation == '') {
                    layer.msg('请确认密码');
                    return false;
                }
            }
            if (user_password_new != user_password_new_confirmation) {
                layer.msg('两次密码不一致');
                return false;
            }
            $.ajax({
                url : './person_safe_editpass',
                data: {
                    "user_password_old": user_password_old,
                    "user_password_new": user_password_new,
                    "user_password_new_confirmation": user_password_new_confirmation,
                    '_token': _token
                },
                type: 'post',
                dataType: "json",
                stopAllStart: true,
                success: function (data) {
                    if (data.status == '1') {
                        layer.msg(data.msg || '修改成功');
                        setTimeout("window.location.reload()","2000");
                    } else {
                        layer.msg(data.msg || '请求失败');
                    }
                },
                error: function () {
                    layer.msg('请求错误，请刷新页面重新尝试');
                    return false;
                }
            });
        });

//	$(".logo").addClass("hidden");
$(function(){
//	$(".sidebar-open-button").click();
});

</script>

</body>
</html>
