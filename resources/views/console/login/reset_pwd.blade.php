<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>重设密码_喇叭传媒</title>
    <link href="/console/css/style.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="/js/layer.js"></script>
</head>
<body style="background:url(/console/img/RELogin.jpg) repeat-x top;">
<div id=RELogin style="">
    <div style="width:250px; margin:auto;"><a href="/console/index"><img
                    src="/console/img/logolaba.png" style=" width:250px; height:auto"></a></div>
    <div style="width: 850px;HEIGHT: 530px;background:#fff;border-radius:10px;">
        <div class=LoginHead>
            <H1>找回密码</H1>
            <div class=LGRight>&nbsp;</DIV>
        </div>
        <div class="web-width">
            <div class="for-liucheng">
                <div class="liulist for-cur"></div>
                <div class="liulist for-cur"></div>
                <div class="liulist for-cur"></div>
                <div class="liulist"></div>
                <div class="liutextbox">
                    <div class="liutext for-cur"><em>1</em><br/><strong>输入用户名</strong></div>
                    <div class="liutext for-cur"><em>2</em><br/><strong>验证身份</strong></div>
                    <div class="liutext for-cur"><em>3</em><br/><strong>重置密码</strong></div>
                    <div class="liutext"><em><img src="/console/img/Bpass1.png"/></em><br/><strong>完成</strong>
                    </div>
                </div>
            </div>
            <div class="forget-pwd">
                <div class="LGnt6">
                    <input type="hidden" name="username" id="username" class="Bpass_name"
                           value="@if(isset($username)){{$username}}@endif"/>
                </div>

                <div class="LGnt6"><p>新密码:</p>
                    {{ csrf_field() }}
                    <input type="password" name="new_password" id="new_password" class="Bpass_name"/>
                </div>
                <div class="LGnt6" style=" margin-top:15px; margin-bottom:10%;"><p>确认密码:</p>
                    <input type="password" name="new_password2" id="new_password2" class="Bpass_name"/>
                </div>
                <input type="submit" name="button" id="sub_button" value="提 交" class="LGButton3"
                       style="margin-bottom:50px;"/>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
    $(function () {
        var _token = $('input[name="_token"]').val();
        $('#sub_button').click(function () {
            var user = $('#username').val();
            var password = $('#new_password').val();
            var password2 = $('#new_password2').val();
            if (password != password2) {
                layer.msg('输入的密码不一致！');
            }
            $.ajax({
                url: '/update/forget_pwd',
                data: {
                    'type': "find_pass",
                    'password': password,
                    '_token': _token
                },
                type: 'post',
                dataType: "json",
                stopAllStart: true,
                success: function (data) {
                    if (data.status_code == 200) {
                        layer.msg(data.msg || '请求成功');
                        setTimeout(function () {
                            window.location.href = "/console/index";
                        }, 3000);
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
    });
</script>