<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <link href="{{url('console/css/style.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript"  src="/console/js/layer/layer.js"></script>
</head>
<body style="background:url(../console/img/RELogin.jpg)  repeat-x top;">
<div id=Login>
    <div style=" width:250px; margin:auto;"><a href=""><img src="{{url('console/img/logolaba.png')}}" style=" width:250px; height:auto"></a></div>
    <form action="/console/post" method="post">
        {{ csrf_field() }}
        <div style="width: 630px;HEIGHT: 400px;background:#fff;border-radius:10px;">
            <div class=LoginHead>
                <H1>用户登录</H1>
                <div class=CopyRight>&nbsp;</DIV>
            </div>
            <div class="LGn1">
                <div class="LGnt1"><p>用户名:</p>
                    <input type="text" name="name" id="username"  class="LGnt2" value="{{old('username')}}"/>
                    {{--<i>忘记用户名？</i>--}}
                </div>
                <div class="LGnt1"><p>密&nbsp;&nbsp;&nbsp;&nbsp;码:</p>
                    <input type="password" name="password" id="password"  class="LGnt2"/>
                    <i><a href="/forget">忘记密码？</a></i>
                </div>
                <div class="LGnt1"><p>验证码:</p>
                    <input type="text" name="captcha" id="user_code"  class="LGnt3"/>
                    <div class="LGnt4"><img src="{{ captcha_src() }}" onclick="this.src='{{captcha_src()}}?r='+Math.random();" alt=""></div>
                </div>
                <div style="float:left; margin-left:45px;">
                    <input type="submit" name="button" id="button" value="提 交" class="LGButton1"/>
                   <a href="{{url('console/register')}}"> <input type="button" name="button" id="button" value="注 册" class="LGButton2"/></a>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>
<script type="text/javascript">
$(function(){
    @if (session('status'))
        layer.msg("{{ session('status') }}");
    @endif
})
$(function(){
    @if (session('error'))
        layer.msg("{{ session('error') }}");
    @endif
})
@foreach ($errors->all() as $message)
    layer.msg("{{ $message }}");
@endforeach
</script>
