<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>注册_喇叭传媒</title>
    <link href="/console/css/style.css" rel="stylesheet" type="text/css"/>
    <script src="http://www.jq22.com/jquery/jquery-1.6.2.js"></script>
    {{--<script type="text/javascript" src="{{url('console/js/jquery.reveal.js')}}"></script>--}}
   {{-- <script src="http://www.jq22.com/js/jq.js"></script>--}}
    <script src="/js/jquery-2.1.1.min.js"></script>
    <script src="/js/layer.js"></script>

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
	
.txt_xieyi{	awidth:90%;	aheight:300px;	aborder:1px solid #E5E5E5;	line-height:26px;	padding:30px 4% 50px;	font-size:16px;	border-radius:10px;
	overflow-y:auto;color:#5c6b78;	margin:0 auto;	}
.txt_xieyi h1{	color:#037ef3;	text-align:center;	font-size:20px;	line-height:30px;	}
aa.txt_xieyi h4{	color:#037ef3;	color:#5c6b78;	text-align:center;	font-size:16px;	line-height:30px;	}

.txt_xieyi h3{	color:#037ef3;	color:#5c6b78;	margin:10px 0 0;	Atext-align:center;	font-size:16px;	line-height:30px;	font-weight:700;	}
.txt_xieyi p{	width:auto;	text-align:left;	margin:5px 0 0;	float:none;font-size:16px;	color:#5c6b78;	}
.layui-layer-loading .layui-layer-content{	width:auto;	}
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
                        location.href = "/console/login";
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
                <input name="confirm" id="confirm" type="checkbox"  value="0"/><span style="margin-left:10px;"><a href="javascript:void(0);" id="show_xieyi" target="_blank">阅读《服务协议》</a></span>
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


<div id="txt_xieyi_wrap" style="display:none;">
<div class="txt_xieyi">
								
<h1>《喇叭传媒平台用户服务协议》</h1>
<p style="text-align:center;">在注册前请仔细阅读如下服务条款：</p>

<h3>一、总则</h3>
<p>1.1、为使用喇叭传媒平台服务（下简称“本服务”），您应当阅读并遵守《喇叭传媒平台用户服务协议》（以下简称“本协议”），以及《喇叭传媒网站保护隐私权之声明》等内容。</p>
<p>1.2、本协议是您与广州安腾网络科技有限公司（以下简称“喇叭传媒公司”）之间就喇叭传媒平台加盟、注册、登录及使用等事宜所订立的权利义务规范。</p>
<p>1.3、请您仔细阅读以下全部内容，您点选“同意”键并完成注册、登录，即视为已完全同意并接受本协议，并愿受其约束；若不同意本协议的任何条款，请不要点选“同意”，也不要使用喇叭传媒平台的任何服务。如您是未成年人，您还应要求您的监护人仔细阅读本协议，并取得他/他们的同意。 </p>
<p>1.4、本协议视为《喇叭传媒服务协议》的补充协议，是其不可分割的组成部分，本协议与《喇叭传媒服务协议》不一致的，以本协议为准。</p>
<p>1.5、本协议内容同时包括喇叭传媒公司可能不断发布的关于喇叭传媒平台服务的相关协议、声明、业务规则及公告指引等内容。上述内容一经正式发布，即为本协议不可分割的组成部分，您同样应当遵守。</p>

<h3>二、定义</h3>
<p>2.1、您：指提交有效申请并经喇叭传媒公司审核同意，在喇叭传媒平台上传、发布内容（包括文字、图片、音频、视频等）的自然人、法人或其他组织。</p>
<p>2.2、喇叭传媒平台：是广州安腾网络科技有限公司旗下喇叭传媒网为您提供的包括媒体刊物出版、内容展现及广告投放的平台服务。</p>
<p>2.3、喇叭传媒网：指喇叭传媒公司所有或经营的网站：www.laba.tw</p>
<p>2.4、用户：指所有直接或间接使用喇叭传媒平台的注册用户、注册会员、喇叭传媒加盟媒体、自媒体。</p>

<h3>三、账户注册和核准</h3>
<p>3.1、在使用本服务前，您需要以真实身份信息注册喇叭传媒平台账号，并及时更新您的注册资料。注册的同时，您需要提供与注册信息相符的相关的身份及资质证明材料，喇叭传媒公司将在审查您提交的相关证明材料后决定是否核准您的注册申请。个人媒体需提供个人手持证件照片，机构媒体除提供加盖单位公章的企业法人营业执照副本复印件或事业单位法人证书复印件外，还应提供相关证明材料，如版权方的授权文件等。</p>
<p>3.2、喇叭传媒公司核准您的注册申请后，您可以依据喇叭传媒公司核准的账号及密码登录并使用喇叭传媒平台，上传或发布相关内容。平台账号归喇叭传媒公司所有，您获得该账号的使用权，使用权仅属于初始申请对象，禁止赠与、借用、租用、转让或售卖。</p>
<p>3.3、喇叭传媒公司仅对您提交的信息和资料进行审核，并不对您账号内发生的行为承担任何责任或提供任何担保。</p>
<p>3.4、如您违反相关法律法规、本协议及喇叭传媒公司发布的其他喇叭传媒平台的规定，喇叭传媒公司有权进行独立判断并随时限制、冻结或终止您对喇叭传媒平台账号的使用，且根据实际情况决定是否恢复使用。由此给您带来的损失（包括但不限于通信中断、用户资料及相关数据清空等），由您自行承担。</p>

<h3>四、您的权利和义务</h3>
<p>4.1、您保证提供给喇叭传媒公司的注册信息和材料真实、完整、合法、有效，并对所有提供的信息和材料承担全部法律责任。</p>
<p>4.2、您应按照喇叭传媒平台公布和提示的规则、流程进行注册操作。注册完成后，应妥善保管、正确和安全的使用账号和密码，您同意在任何情况下不向他人透露账号和密码信息，因您保管不善导致账号密码被盗的，责任由您自行承担。如账号和密码遭到第三方使用或发生其他任何问题，您有义务及时通知喇叭传媒公司。</p>
<p>4.3、您保证对在喇叭传媒平台上传、发布的所有内容享有合法权益，喇叭传媒公司有权要求您提供相应的权属证明。</p>
<p>4.4、您理解并同意，为保证喇叭传媒平台的正常运营及用户的良好体验，您不得利用喇叭传媒平台制作、上传、发布、传播任何法律、法规和政策禁止的信息，或含有其他干扰喇叭传媒公司正常运营和侵犯第三方合法权益的内容。</p>
<p>4.5、您理解并同意，您需要对您账号下发生的一切活动承担全部法律责任，包括但不限于注册登录、申请审核、账号运营、内容发布以及其他任何使用喇叭传媒平台账号所进行的行为。若您的行为引发纠纷或侵犯了任何第三方的合法权益，由您独立承担全部责任，因此给喇叭传媒公司或其他第三方造成损害的，您应该依法予以赔偿。</p>
<p>4.6、您理解并同意，喇叭传媒公司不对您在本服务中相关数据的删除或储存失败负责，请您自行备份本服务中的相关数据。如果您停止使用本服务或服务被终止的，喇叭传媒公司可以从服务器上永久地删除您的数据。</p>
<p>4.7、您理解并同意，您的内容通过喇叭传媒平台一经发布即向公众传播和共享，可能会被其他第三方复制、转载、修改或做其他用途，您应充分意识到此类风险的存在，任何您不愿被他人获知的信息都不应在喇叭传媒平台发布。如果相关行为侵犯了您的合法权益，您可以向喇叭传媒平台投诉，我们将依法进行处理。</p>
<p>4.8、若您需要在喇叭传媒平台进行品牌推广或投放商业广告，必须得到喇叭传媒公司的书面同意，且推广内容必须经过喇叭传媒公司审核。</p>
<p>4.9、本协议未授予您使用喇叭传媒任何商标、服务标记、标识、域名和其他显著品牌特征的权利。</p>

<h3>五、喇叭传媒公司的权利和义务</h3>
<p>5.1、喇叭传媒公司有权核实您的注册信息和材料，如发现该等信息和材料中存在任何问题，可要求您改正或补充相关材料。如果您拒绝改正或补充相关材料，喇叭传媒公司有权做出不予批准注册申请，限制、冻结或终止账号等处理。</p>
<p>5.2、喇叭传媒公司为喇叭传媒平台的开发、运营提供技术支持。</p>
<p>5.3、喇叭传媒公司保留随时变更或终止喇叭传媒平台服务的权利，并无需向您承担任何责任。喇叭传媒公司可通过网页公告、电子邮件、电话或信件传送等方式向您发出通知，该等通知在发送时即视为已送达收件人。</p>
<p>5.4、如果喇叭传媒公司发现或收到第三方举报或投诉您违反本协议约定的，喇叭传媒公司有权不经通知随时对相关内容进行删除，并视行为情节对违规账号处以包括但不限于警告、删除部分或全部订阅用户、限制或禁止使用全部或部分功能、冻结或终止账号的处罚。</p>
<p>5.5、喇叭传媒公司有权在喇叭传媒平台投放各种商业广告或商业信息。</p>
<p>5.6、喇叭传媒公司将在您的最终文章或者刊物展示页的下方，为您提供自定义推广位：，此推广位展示的内容为乙方自身形象广告及所办活动推广广告，不得转让给第三方。</p>
<p>5.7、喇叭传媒公司可能根据实际需要提供需要您支付一定的费用的收费服务。对此，喇叭传媒公司将在相应页面进行通知或公告，只有您根据提示确认您愿意支付相关费用，您才能使用该等收费网络服务。如果您拒绝支付相关费用，则喇叭传媒公司有权不向您提供该等收费服务。</p>

<h3>六、【知识产权】</h3>
<p>6.1、喇叭传媒公司在本服务中提供的内容（包括但不限于网页、文字、图片、音频、视频、图表等）的知识产权归喇叭传媒公司所有，喇叭传媒公司提供本服务时所依托软件的著作权、专利权及其他知识产权均归喇叭传媒公司所有，喇叭传媒公司在本服务中所使用的“喇叭”等商业标识的著作权或商标权归喇叭传媒公司所有。</p>
<p>6.2、您通过喇叭传媒平台上传、发布的任何内容的知识产权仍然属于您或原始版权人所有。</p>
<p>6.3、对于您通过喇叭传媒平台上传、编辑或发布的任何内容，喇叭传媒公司在全世界范围内不限形式和载体地享有永久的、不可撤销的、免费的、非独家的使用权和转授权的权利，包括但不限于修改、复制、发行、展览、改编、汇编、出版、翻译、信息网络传播、广播、表演和再创作及著作权法等法律法规确定的其他权利，您特别授权喇叭传媒公司以自己名义单独对第三方的侵权行为提起诉讼并获得全额赔偿。喇叭传媒公司无须为此向您给予任何报酬或承担任何义务，也无须另行通知。</p>
<p>6.4、上述及其他任何本服务包含的内容的知识产权均受到法律保护，其他未经喇叭传媒公司、您或相关权利人许可的第三人，不得以任何形式进行使用或创造相关衍生作品。</p>

<h3>七、【平台使用规范】</h3>
<p>7.1、禁止发布、传送、传播、储存违反国家法律法规禁止的内容：</p>
<p>7.2、违反宪法确定的基本原则的；</p>
<p> 7.3、危害国家安全，泄露国家秘密，颠覆国家政权，破坏国家统一的；</p>
<p> 7.4、损害国家荣誉和利益的；</p>
<p> 7.5、煽动民族仇恨、民族歧视，破坏民族团结的；</p>
<p> 7.6、破坏国家宗教政策，宣扬邪教和封建迷信的；</p>
<p>7.7、散布谣言，扰乱社会秩序，破坏社会稳定的；</p>
<p> 7.8、散布淫秽、色情、赌博、暴力、恐怖或者教唆犯罪的；</p>
<p> 7.9、侮辱或者诽谤他人，侵害他人合法权益的；</p>
<p> 7.10、煽动非法集会、结社、游行、示威、聚众扰乱社会秩序；</p>
<p>7.11、以非法民间组织名义活动的；</p>
<p>7.12、涉及近期敏感言论和敏感活动，抨击他人的产品或广告，进行负面推广；</p>
<p>7.13、含有法律、行政法规禁止的其他内容的。 </p>
<p>7.14、一旦本平台发现用户发布以上违法内容，本平台将不予审核通过，且有权时刻中止或删除活动，本平台有权利向公安、工商等相关政府机关举报，其后果由广告主自行承担。自用户发布违法内容起，视为用户违约，本平台相应的不再承担本《协议》下的义务。</p>
<p>7.15、若用户发布不实信息，由此带来不良后果，广告主应承担相应责任，与本平台无关。 如用户违反国家法律法规、本《协议》或对本平台进行恶意攻击时，本平台将有权停止向用户提供服务而不需承担任何责任，如导致本平台遭受任何损害或遭受任何来自第三方的纠纷、诉讼、索赔要求,用户须向本平台赔偿相应的损失，如诉讼费、律师费、其他第三方费用、业务影响损失等费用，并且用户需对其违反《协议》所产生的一切后果负全部法律责任。</p>

<h3>八、【服务的中断和终止】</h3>
<p>8.1、在本平台未向用户收取相关服务费用的情况下，本平台可自行全权决定以任何理由 (包括但不限于本平台认为用户已违反本《协议》的字面意义和精神，或用户在超过180天内未登录本平台等) 终止对用户的服务，并不再保存用户在本平台的全部资料（包括但不限于用户信息、商品信息、交易信息等）。同时本平台可自行全权决定，在发出通知或不发出通知的情况下，随时停止提供全部或部分服务。服务终止后，本平台没有义务为用户保留原用户资料或与之相关的任何信息，或转发任何未曾阅读或发送的信息给用户或第三方。</p>
<p>8.2、如用户向本平台提出注销本平台注册用户身份，需经本平台审核同意，由本平台注销该注册用户，用户即解除与本平台的协议关系，但本平台仍保留下列权利：</p>  
<p> 1)、用户注销后，本平台有权保留该用户的资料,包括但不限于以前的用户资料、交易记录等。</p>
<p> 2)、用户注销后，如用户在注销前在本平台交易平台上存在违法行为或违反本《协议》的行为，本平台仍可行使本《协议》所规定的权利。 </p>
<p>8.3、如存在下列情况，本平台可以通过注销用户的方式终止服务： </p>  
<p> 1)、在用户违反本《协议》相关规定时，本平台有权终止向该用户提供服务。本平台将在中断服务时通知用户。但如该用户在被本平台终止提供服务后，再一次直接或间接或以他人名义注册为本平台用户的，本平台有权再次单方面终止为该用户提供服务；</p>  
<p> 2)、一旦本平台发现用户注册资料中主要内容是虚假的，本平台有权随时终止为该用户提供服务； </p>     
<p>3)、用户出现作弊行为，网站可根据情况作出处理，甚至注销用户。</p>
<p> 8.4、其它本平台认为需终止服务的情况。</p>

<h3>九、【不可抗力】</h3>
<p>9.1、因不可抗力或者其他意外事件，使得本《协议》的履行不可能、不必要或者无意义的，双方均不承担责任。本《协议》所称之不可抗力亦指不能预见、不能避免并不能克服的客观情况，包括但不限于战争、台风、水灾、火灾、雷击或地震、罢工、暴动、法定疾病、黑客攻击、网络病毒、电信部门技术管制、政府行为或任何其它自然或人为造成的灾难等客观情况。</p>

<h3>十、【其他】</h3>
<p>10.1、您和喇叭传媒公司均是独立的主体，在任何情况下本协议不构成双方之间的代理、合伙、合营或雇佣关系。</p>
<p>10.2、喇叭传媒公司有权在必要时修改本协议条款，您可以在相关服务页面查阅最新版本的协议条款。如您继续使用喇叭传媒平台，即意味着同意并自愿遵守修改后的协议。</p>
<p>10.3、本协议条款无论因何种原因部分无效或不可执行，其余条款仍有效，对双方具有约束力。</p>
<p>10.4、如双方就本协议内容或其执行发生任何争议，双方应尽量友好协商解决。协商不成时，任何一方均可向喇叭传媒公司所在地有管辖权的人民法院提起诉讼。本协议的成立、生效、履行、解释及纠纷解决，都适用于中华人民共和国的法律。</p>
<p>10.5、如双方对于本协议有不同意见，可另行签署协议。该协议与本协议不一致时，以双方另行签署的协议为准。 </p>

<p>&nbsp;</p>


</div>
</div>

<script>
$("#show_xieyi").click(function(){
	
	layer.open({
		type: 1,
		shadeClose: true,
		skin: 'layui-layer-rim', //加上边框
		area: ['60%', '70%'], //宽高
		content: $('#txt_xieyi_wrap')
	});
	
	
});

</script>

</body>
</html>

