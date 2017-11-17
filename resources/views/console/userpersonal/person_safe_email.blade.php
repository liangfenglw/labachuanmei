<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>绑定邮箱_喇叭传媒</title>
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
	{{ csrf_field() }}

	<div class="place">
		<div class="place_ant"><a href="/">首页</a> <a href="{{url('userpersonal/person_edit')}}">用户信息 </a> <a href="{{url('userpersonal/person_safe')}}"  class="cur">安全设置 </a></div>
	</div>
	
	<div class="main_s">
		<h3 class="title3"><strong>绑定邮箱</strong></h3>
		<div class="safe_2 clearfix">
			<div class="WMain3 WMain3_2 clearfix"><p><i class="LGntas"></i>会员帐号：</p>
				{{$user['name']}}
			</div>
			<div class="WMain3 WMain3_2 clearfix"><p><i class="LGntas"></i>邮箱地址：</p>
				<input type="text" name="email" id="email" @if($user['email']) value="{{$user['email']}}" disabled @endif  class="txt_f1" style="width:40%;">
				<div><span>输入有效的邮箱地址，以便接收系统邮件通知及重置用户名 示例：cndns@163.com</span></div>
			</div>
			<div class="WMain3 WMain3_2 clearfix"><p><i class="LGntas"></i>邮箱验证码：</p>
				<input type="text" name="user_code" id="user_code" class="Bpass_" style="margin-right: 10px;width:18%;">
				<input type="submit" name="send_sms_button" id="send_sms_button" value="获取验证码" class="LGn3" style="cursor:pointer;height:45px;line-height:45px;">
			</div>
            @if($user['email'])
                <div class="WMain3 WMain3_2 clearfix"><p><i class="LGntas"></i>新邮箱地址：</p>
                    <input type="text" name="n_email" id="n_email"   class="txt_f1" style="width:40%;">
                    <div></div>
                </div>
            @else
                <input type="hidden" name="n_email" id="n_email" value="" class="txt_f1" style="width:40%;">
            @endif
			<div class="WMain3 WMain3_2 clearfix" style="margin-top:50px;margin-left:-30px">
				<input type="submit" value="提交" id="submit_button" class="sub5">
			</div>
			
			<div class="clr"></div>
		</div>
		<div class="safe2_b">
			友情提醒：用户名和密码要做好相应记录，以免忘记。
		</div>
	</div>
	

</div></div>

@include('console.share.admin_foot')

<script type="text/javascript">

//	$(".logo").addClass("hidden");
$(function(){

        var _token = $('input[name="_token"]').val();

        $("#send_sms_button").click(function () {
            // var _form=form.getFormData();//获取表单参数
            var email = $('#email').val();
            //判断电子邮箱是否正确合法
            if (!checkEmail(email)) {
                layer.msg('请输入正确的电子邮箱');
                $("#mobile_number").focus();
                return false;
            }
                $.ajax({
                url : './sendSmtp',
                data: {
                    // 'type':"register",
                    'email': email,
                    '_token': _token
                },
                type: 'post',
                dataType: "json",
                stopAllStart: true,
                success: function (data) {
                    if (data.status == '1') {
                        setTiming();
                        layer.msg(data.msg || '请求成功');

                    } else {
                        layer.msg(data.msg || '请求失败');
                    }
                },
                error: function () {
                    layer.msg('网络发生错误！！');
                    return false;
                }
            });
        });


        var timeout = 60;
        var int1;
        function setTiming() {
            if (timeout >= 1) {
                clearTimeout(int1);
                $("#send_sms_button").attr("disabled", "disabled");
                $("#send_sms_button").css("cursor", "default");
                $("#send_sms_button").val("" + timeout + " 重新发送");
                int1 = setTimeout(function () {
                    timeout--;
                    setTiming();
                }, 1000);
            } else {
                clearTimeout(int1);
                $("#send_sms_button").val("重新发送");
                $('#send_sms_button').removeAttr("disabled");
                $("#send_sms_button").css("cursor", "pointer");
                timeout = 60;
            }
        }



        $('#submit_button').click(function () {
            var n_email;
            var email = $('#email').val();
            var user_code = $('#user_code').val();
            if (email == '') {
                layer.msg('手机号码不能为空');
                return false;
            } else {
                if (!checkEmail(email)) {
                    layer.msg('请输入正确的电子邮箱');
                    return false;
                }
            }

            if (user_code == '') {
                layer.msg('请输入验证码');
                return false;
            }
            n_email = $("#n_email").val();
            @if($user['email'])
                if (!n_email) {
                    layer.msg('请输入新的电子邮箱');
                    return false;
                }
            @endif
            $.ajax({
                url : './post_safe_email',
                data: {
                    "email": email,
                    "user_code": user_code,
                    '_token': _token,
                    'n_email':n_email
                },
                type: 'post',
                dataType: "json",
                stopAllStart: true,
                success: function (data) {
                    if (data.status == '1') {
                        layer.msg(data.msg || '请求成功');
                    	window.location.reload();
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
//	$(".sidebar-open-button").click();
});

</script>

</body>
</html>
