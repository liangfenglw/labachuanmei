<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>安—绑定手机 - 亚媒社</title>
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
		当前位置：<a href="\">首页</a> > <a href="{{url('userpersonal/person_edit')}}">用户信息</a> > <a href="{{url('userpersonal/person_safe')}}">安全设置</a>
	</div>
	
	<div class="main_s">
		<h3 class="title3"><strong>绑定手机</strong>
			<a href=""><img class="title3_img" src="{{url('console/images/arr_s.png')}}" alt="" /></a>
			<span class="title3_i"></span>
		</h3>
		<div class="safe_2 clearfix">
			<div class="WMain3 WMain3_2 clearfix"><p><i class="LGntas"></i>会员帐号：</p>
				{{$user['name']}}
			</div>
			<div class="WMain3 WMain3_2 clearfix"><p><i class="LGntas"></i>手机号码：</p>
				<input type="text" name="mobile_number"  id="mobile_number" @if($user['mobile']) value="{{$user['mobile']}}" disabled @endif class="txt_f1" style="width:40%;">
				<div><span>@if(!$user['mobile'])输入有效的手机号码，以便接收系统通知及重置用户名@endif</span></div>
			</div>
			@if(!$user['mobile'])
			<div class="WMain3 WMain3_2 clearfix"><p><i class="LGntas"></i>手机验证码：</p>
				<input type="text" name="user_code" id="user_code" class="Bpass_ " style="margin-right: 10px;width:12%;">
				<input type="submit" name="send_sms_button" value="获取验证码" id="send_sms_button" class="LGn3" style="cursor:pointer;height:37px;line-height:37px;">
			</div>
			<div class="WMain3 WMain3_2 clearfix" style="margin-top:50px;">
				<input type="submit" value="提交" id="submit_button" class="sub5">
			</div>
			@endif
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
            var moblie_number = $('#mobile_number').val();
            //判断手机号码是否正确合法
            if (!IsTel(moblie_number)) {
                layer.msg('请输入正确的手机号码');
                $("#mobile_number").focus();
                return false;
            }
                $.ajax({
                url : './sendSms',
                data: {
                    // 'type':"register",
                    'phone': moblie_number,
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

            var mobile_number = $('#mobile_number').val();
            var user_code = $('#user_code').val();

            if (mobile_number == '') {
                layer.msg('手机号码不能为空');
                return false;
            } else {
                if (!IsTel(mobile_number)) {
                    layer.msg('请输入正确的手机号码');
                    return false;
                }
            }

            if (user_code == '') {
                layer.msg('请输入手机验证码');
                return false;
            }

            $.ajax({
                url : './post_safe_phone',
                data: {
                    "phone": mobile_number,
                    "user_code": user_code,
                    '_token': _token
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

        function IsTel(Tel) {
            var re = new RegExp(/^((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)$/);
            var retu = Tel.match(re);
            if (retu) {
                return true;
            } else {
                return false;
            }
        }
//	$(".sidebar-open-button").click();
});

</script>

</body>
</html>
