<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>用户中心</title>
    <link href="/console/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/console/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/console/css/style2.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="/js/layer.js"></script>
</head>
<body style="background:url(/console/img/RELogin.jpg) repeat-x top;">
<div id=RELogin style="">
    <div style=" width:250px; margin:auto;"><a href=""><img src="/console/img/logolaba.png" style=" width:250px; height:auto"></a></div>
    <div style="width: 850px;HEIGHT: 600px;background:#fff;border-radius:10px;">
        <div class=LoginHead>
            <H1>找回密码</H1>
            <div class=LGRight>&nbsp;</DIV>
        </div>
        <div class="web-width">
            <div class="for-liucheng">
                <div class="liulist for-cur"></div>
                <div class="liulist for-cur"></div>
                <div class="liulist"></div>
                <div class="liulist"></div>
                <div class="liutextbox">
                    <div class="liutext for-cur"><em>1</em><br /><strong>输入用户名</strong></div>
                    <div class="liutext for-cur"><em>2</em><br /><strong>验证身份</strong></div>
                    <div class="liutext"><em>3</em><br /><strong>重置密码</strong></div>
                    <div class="liutext"><em><img src="/console/img/Bpass1.png" /></em><br /><strong>完成</strong></div>
                </div>
            </div>
            <form action="/reset_pwd" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="username" value="@if(isset($user_num) && !empty($user_num)){{$user_num}}@endif">
                <input type="hidden" name="send_type" id="send_type" value="0" >
            <div class="forget-pwd">
                <div class="Bp_zh"><p>验证方式:</p>
                    <select class="selyz" >
                        <option value="0">手机验证</option>
                        <option value="1">邮箱验证</option>
                    </select>
                </div>
              {{--  <div class="LGnt6"><p>用户名:</p>
                    <input type="text" name="username" id="set_username"  class="Bpass_name"  value="@if(isset($user_num) && !empty($user_num)){{$user_num}}@endif"/>
                </div>--}}

                <div class="LGnt6 sel-yzsj"><p>验证手机:</p>
                    <input type="text" name="user_tel" id="user_tel" readonly="readonly"  class="Bpass_name" value="{{ $info['mobile'] }}" />
                </div>
                <div class="LGnt6 sel-yzyx"><p>验证邮箱:</p>
                    <input type="text" name="user_email" id="user_email" readonly="readonly"  class="Bpass_name" value="{{ $info['email'] }}" />
                </div>
                <div class="LGnt6" style=" margin-top:15px; margin-bottom:10%;"><p>验证码:</p>
                    <input type="text" name="user_code" id="textfield"  class="Bpass_"/>
                    <div class="LGnt4"><input type="button" name="code_button" id="code_button" value="获取验证码" class="LGn3"/></div>
                </div>
                <input type="submit" name="button" id="button" value="提 交" class="LGButton3" style="margin-bottom:50px;" />
            </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
    $(function(){
        @if (session('status'))
            layer.msg("{{ session('status') }}");
        @endif
    })
    //导航定位
    $(function(){
        var _token = $('input[name="_token"]').val();
        // $(".nav li:eq(2) a:first").addClass("navCur")
        //验证手机 邮箱
        $(".selyz").change(function(){
            var selval=$(this).find("option:selected").val();
            if(selval=="0"){
                $(".sel-yzsj").show()
                $(".sel-yzyx").hide()
            }
            else if(selval=="1"){
                $(".sel-yzsj").hide()
                $(".sel-yzyx").show()
            }
        });
        $(".selyz").change(function(){
            var opt=$(".selyz").val();
            // var send_num=  $('#send_type').val();
            $('#send_type').val(opt);
        });
        $('#code_button').click(function () {
            var username =$('input[name="username"]').val();
            var send_type=$('#send_type').val();
            if(send_type ==0){
                var user_tel=$('#user_tel').val();
                if (!IsTel(user_tel)) {
                    layer.msg('请输入正确的手机号码');
                    return false;
                }
               //发送手机验证码
                $.ajax({
                    url: '/send_forget_mobile',
                    data: {
                        'type':"find_pass",
                        'username':"{{session('forget_user')}}",
                        'moblie_number': "{{$info['mobile']}}",
                        '_token': _token
                    },
                    type: 'post',
                    dataType: "json",
                    stopAllStart: true,
                    success: function (data) {
                        if (data.status_code == 200) {
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
            }else{
                //发送邮箱验证码
                var user_email=$('#user_email').val();
                $.ajax({
                    url: '/send_forget_email',
                    data: {
                        'type':"find_pass",
                        'username':"{{session('forget_user')}}",
                        'user_email': "{{$info['email']}}",
                        '_token': _token
                    },
                    type: 'post',
                    dataType: "json",
                    stopAllStart: true,
                    success: function (data) {
                        if (data.status_code == 200) {
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

            }
            
        });
        var timeout = 60;
        var int1;
        function setTiming() {
            if (timeout >= 1) {
                clearTimeout(int1);
                $("#code_button").css("cursor", "default");
                $("#code_button").val("" + timeout + " 重新发送");
                int1 = setTimeout(function () {
                    timeout--;
                    setTiming();
                }, 1000);
            } else {
                clearTimeout(int1);
                $("#code_button").val("重新发送");
                $("#code_button").css("cursor", "pointer");
                timeout = 60;
            }
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

    });
</script>
