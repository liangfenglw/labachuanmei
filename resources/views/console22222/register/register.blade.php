<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <link href="/console/css/style.css" rel="stylesheet" type="text/css"/>
    <script src="http://www.jq22.com/jquery/jquery-1.6.2.js"></script>
    {{--<script type="text/javascript" src="{{url('console/js/jquery.reveal.js')}}"></script>--}}
   {{-- <script src="http://www.jq22.com/js/jq.js"></script>--}}
    <script src="{{url('console/js/jquery-2.1.1.min.js')}}"></script>
    <script src="{{url('console/js/layer.js')}}"></script>

</head>
<style type="text/css">
    .reveal-modal{
        left: 50%;
        margin-left: -380px;
        width: 570px;
        position: absolute;
        z-index: 101;
        padding: 30px 100px;
    }
    *{
        margin: 0;
        font-family: "微软雅黑";
    }

</style>
<script type="text/javascript">
    $(function () {
        var _token = $('input[name="_token"]').val();

        $('.close-reveal-modal').click(function () {
            $('.reveal-modal').css({ 'visibility': 'hidden'});
            $('.reveal-modal-bg').css({'display':'none'});

            //跳转页面
            location.href = "./index";
            return false;
        });
        /*background:#ff4a50;*/
        $('#confirm').click(function () {
            var confirm = $('#confirm').val();
            if(confirm==0){
                $('#confirm').val('1');
                $('.LGButton3').css('background','#ff4a50');
            }else{
                $('#confirm').val('0');
                $('.LGButton3').css('background','');
            }
        });
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
            var confirm = $('#confirm').val();
            if(confirm !=1){
                return false
            }

            var mobile_number = $('#mobile_number').val();
            var password = $('#user_password').val();
            var password_confirmation = $('#password_confirmation').val();
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
            if (password == '') {
                layer.msg('密码不能为空');
                return false;
            } else {
                if (password_confirmation == '') {
                    layer.msg('请确认密码');
                    return false;
                }
            }
            if (password != password_confirmation) {
                layer.msg('两次密码不一致');
                return false;
            }
            if (user_code == '') {
                layer.msg('请输入手机验证码');
                return false;
            }
            if (confirm != 1) {
                return false;
            }

            $.ajax({
                url : './register',
                data: {
                    "name": mobile_number,
                    "password": password,
                    "password_confirmation": password_confirmation,
                    "user_code": user_code,
                    "confirm": confirm,
                    '_token': _token
                },
                type: 'post',
                dataType: "json",
                stopAllStart: true,
                success: function (data) {
                    if (data.status == '1') {
                        layer.msg(data.msg || '请求成功');
                         $('input[name="user_id"]').val(data.data);
                         $('.reveal-modal').css({"visibility":'visible'});
                         $('.reveal-modal-bg').css({'display': 'block', 'cursor': 'pointer',
                             'position': 'fixed', 'height': '100%','width': '100%','background': 'rgba(0,0,0,.8)','z-index':'100','top': '0',
                        'left':'0'});
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


        $('#upload_info').click(function () {
            var nickname=$('#nickname').val();
            var Contact_person=$('#Contact_person').val();
            var user_Eail=$('#user_Eail').val();
            var user_QQ=$('#user_QQ').val();
            var user_id= $('input[name="user_id"]').val();

            if (user_id == '') {
                layer.msg('请求错误，请刷新页面重新尝试');
                return false;
            };

            if (nickname == '') {
                layer.msg('昵称不能为空');
                return false;
            } 

            if (Contact_person == '') {
                layer.msg('联系人不能为空');
                return false;
            }

            if (user_QQ == '') {
                layer.msg('QQ不能为空');
                return false;
            }

            if (user_Eail == '') {
                layer.msg('电子邮箱不能为空');
                return false;
            } else {
                if (!checkEmail(user_Eail)) {
                    layer.msg('请输入正确的电子邮箱');
                    return false;
                }
            }


            $.ajax({
                url : './register_perfect',
                data: {
                    'type':"update_info",
                    "nickname": nickname,
                    'user_id':user_id,
                    "Contact_person": Contact_person,
                    "user_Eail": user_Eail,
                    "user_QQ": user_QQ,
                    '_token':_token
                },
                type: 'post',
                dataType: "json",
                stopAllStart: true,
                success: function (data) {
                    if (data.status == '1') {
                        layer.msg(data.msg || '请求成功');
                        //跳转页面
                        location.href = "./index";
                        return false;
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

    });
</script>
<body style="background:url( {{url('console/images/RELogin.jpg')}}) repeat-x top;">
<div id=RELogin style="">
    <div style=" width:250px; margin:auto;"><a href=""><img src="{{url('console/images/logolaba.png')}}"
                                                                                        style=" width:250px; height:auto"></a>
    </div>
    <div style="width: 850px;HEIGHT: 530px;background:#fff;border-radius:10px;">
        <div class=LoginHead>
            <H1>用户注册</H1>
            <div class=LGRight>&nbsp;</DIV>
        </div>
        <div class="LGn1" style="float:left; margin-left:50px;">
            <div class="LGnt6"><p>手机号码:</p>

                <input type="text" name="mobile_number" id="mobile_number" class="LGnt2"/>
                {{ csrf_field() }}
            </div>
            <div class="LGnt6"><p>登录密码:</p>
                <input type="password" name="password" id="user_password" class="LGnt2"/>
            </div>
            <div class="LGnt6"><p>确认密码:</p>
                <input type="password" name="password_confirmation" id="password_confirmation" class="LGnt2"/>
            </div>
            <div class="LGnt6"><p>验证码:</p>
                <input type="text" name="user_code" id="user_code" class="LGnt3"/>
                <div class="LGnt4">
                    <input type="submit" name="button" id="send_sms_button" value="获取验证码" class="LGn3"/>
                </div>
            </div>
            <div class="LGntnn6">
                <input name="confirm" id="confirm" type="checkbox"  value="0"/><span style="margin-left:10px;"><a href="" target="_blank">阅读《服务协议》</a></span>
            </div>
            <a class="big-link" data-reveal-id="myModal">
                <input type="button" name="button" id="submit_button" value="立即注册" class="LGButton3"/>
            </a>
        </div>
        <div class="LGn2">
            <h4>已经注册过？<a href="{{url('console/login')}}"><input type="submit" name="button" id="button" value="登 录"
                                                               class="LGBo1"/></a></h4>
            <span>登录喇叭传媒，三百万网络推广服务商为您服务！</span>
            <p>如有问题，请联系在线客服：</p>
            <div><a href="http://wpa.qq.com/msgrd?v=3&uin=3315033406&site=在线客服&menu=yes" target="_blank">
            <img src="{{url('console/images/LGn2.jpg')}}" alt="点我咨询"></a></div>
        </div>
    </div>
</div>

<!--弹窗完善信息页-->
{{--<div id="myModal" class="reveal-modal">
    <div><img src="{{url('console/images/myModal.jpg')}}"/></div>
    <div style="width:570px;HEIGHT:450px; margin-top:20px;">
        <div class="LGnt7"><p>昵称:</p>
            <input type="text" name="nickname" id="textfield" class="IFN1"/>
        </div>
        <div class="LGnt7"><p>联系人:</p>
            <input type="text" name="Contacts" id="textfield" class="IFN1"/>
        </div>
        <div class="LGnt7"><p>电子邮箱:</p>
            <input type="text" name="E-mail" id="textfield" class="IFN1"/>
            <i>* 请填写有效的邮箱地址，接收通知及定单信息。</i>
        </div>
        <div class="LGnt7"><p>QQ:</p>
            <input type="text" name="QQ" id="textfield" class="IFN1"/>
        </div>
        <div class="LGnt7"><p style=" height:90px;">资料类型:</p>
            <ul style="display:block;">
                <li><input name="" type="checkbox" value=""/>新闻/软文</li>
                <li><input name="" type="checkbox" value=""/>草根微信</li>
                <li><input name="" type="checkbox" value=""/>草根微博</li>
                <li><input name="" type="checkbox" value=""/>草根朋友圈</li>
                <li><input name="" type="checkbox" value=""/>名人/媒体微信</li>
                <li><input name="" type="checkbox" value=""/>名人/媒体微博</li>
                <li><input name="" type="checkbox" value=""/>名人/媒体微信</li>
                <li><input name="" type="checkbox" value=""/>平媒</li>
            </ul>
        </div>
        <div><input type="submit" name="button" id="button" value="保  存" class="LGButton3"/></div>
    </div>
    <a class="close-reveal-modal">&#215;</a>
</div>--}}
<div id="myModal" class="reveal-modal"  style="top: 100px; opacity: 1; visibility: hidden;">
    <div><img src="{{url('console/images/myModal.jpg')}}"></div>
    <div style="width:570px;HEIGHT:450px; margin-top:20px;">
        <div class="LGnt7"><p>昵称:</p>
             <input type="hidden" name="user_id" value="">
            <input type="text" name="nickname" id="nickname" class="IFN1">
        </div>
        <div class="LGnt7"><p>联系人:</p>
            <input type="text" name="Contact_person" id="Contact_person" class="IFN1">
        </div>
        <div class="LGnt7"><p>电子邮箱:</p>
            <input type="text" name="user_Eail" id="user_Eail" class="IFN1">
            <i>* 请填写有效的邮箱地址，接收通知及定单信息。</i>
        </div>
        <div class="LGnt7"><p>QQ:</p>
            <input type="text" name="user_QQ" id="user_QQ" class="IFN1">
        </div>
        {{--<div class="LGnt7"><p style=" height:90px;">资料类型:</p>
            <ul style="display:block;">
                <li><input name="" type="checkbox" value="">新闻/软文</li>
                <li><input name="" type="checkbox" value="">草根微信</li>
                <li><input name="" type="checkbox" value="">草根微博</li>
                <li><input name="" type="checkbox" value="">草根朋友圈</li>
                <li><input name="" type="checkbox" value="">名人/媒体微信</li>
                <li><input name="" type="checkbox" value="">名人/媒体微博</li>
                <li><input name="" type="checkbox" value="">名人/媒体微信</li>
                <li><input name="" type="checkbox" value="">平媒</li>
            </ul>
        </div>--}}
        <div><input type="submit" name="button" id="upload_info" value="保  存" class="LGButton3" style="background:#ff4a50"></div>
    </div>
    <a class="close-reveal-modal">×</a>
</div>
<div class="reveal-modal-bg" style="display:none; cursor: pointer;"></div>
</body>
</html>

