<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>账户提现_喇叭传媒</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    @include('console.share.cssjs')
    
    <style>

    </style>
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->


@include('console.share.admin_head')
@include('console.share.admin_menu')            <!--    左弹菜单 普通会员首页 -->


<div class="content"><div class="Invoice">

    @include('console.share.user_menu')

    <div class="place">
        <div class="place_ant"><a href="/console/index">首页</a> <a href="{{url('supp/withdraw')}}"  class="cur">账户查询 </a></div>
    </div>
    
    <div class="main_s">
        <h3 class="title3"><strong>账户提现</strong></span></h3>
        {{ csrf_field() }}
        <div class="clearfix wrap_f" style="padding-top:80px; width:94%;">
        	<div class="tixian_left">	
                <h3 class="wrap_h3">可提现金额</h3>
                <h4 class="wrap_h4">￥<span id="balance">{{$balance}}</span></h4>
            </div>
            <div class="tixian_ant">    
                <div class="item_f"><p><i class="LGntas"></i>提现金额：</p>
                    <div class="r"><input onkeyup="this.value=this.value.replace(/[^\d-]/g,'')"  type="text" name="tixian" id="tixian" class="txt_f1" style="width:80%;"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>提现方式：</p>
                    <div class="r">
                        <select class="sel_f1" id="pay_type" name="pay_type" style="width:83%;">
                        @foreach($pay_list as $key =>$value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>提现账户：</p>
                    <div class="r"><input type="text" name="pay_user" id="pay_user" class="txt_f1" style="width:80%;"></div>
                </div>
                <div class="item_f item_f_2" style="margin-top:100px;">
                    <div class=""><input type="submit" value="提 交" id="tixian_at" class="sub5" style="margin:0 auto;display:block;" /></div>
                </div>
                <div class="clr"></div>
            </div>	
			<div class="tixian_right"><img src="/console/images/tixian_right.png" /></div>
        </div>
    </div>
    

</div></div>

@include('console.share.admin_foot')

<!--    支付弹窗    -->
<div class="pay_info">
    <h3>提现金额</h3>
    <h4 class="sum" id="sum2">￥<b>0.00</b></h4>  
     <p>尊敬的用户，您的提现金额将会在24小时后到账。</p>  
    <!-- <form action="" method="post" id="form1"> -->
        <div class="item">
            <input type="password" name="password" id="password" placeholder="请输入您的登录密码" class="pass" />
        </div>
        <div class="item">
            <button type="submit" id="onsubmit" class="sub">确 定</button>
        </div>
    <!-- </form> -->
</div>

<script type="text/javascript">
var _token = $('input[name="_token"]').val();

/*  点击结算弹出支付    */
$("#tixian_at").click(function(){
    event.preventDefault();
    var tixian = $.trim($("#tixian").val());
    var balance = $.trim($("#balance").html());
    var pay_user = $.trim($("#pay_user").val());
    var pay_type = $("#pay_type").val();

    if ( isNaN(tixian) ) {
        layer.msg("请输入正确的提现金额");    return;
    }
    if (!pay_type) {
        layer.msg("请选择体现方式");   return;
    };
    if( tixian == "" ){         layer.msg("请输入提现金额");   return;     }
    if( tixian - balance >= 0 || tixian<0 ){    layer.msg("提现金额不能超过可提现金额"); return;     }
    if( pay_user == "" ){       layer.msg("请输入提现帐户");   return;     }
    $("#sum2 b").html(tixian);
    layer.open({
        type: 1,
        title: " ",
        shadeClose: true, //开启遮罩关闭
        skin: 'pay_info_w', //加上class设置样式
        area: ['430px'], //宽高
        content: $(".pay_info")
    });
});

$("#onsubmit").click(function(){
    var tixian = $.trim($("#tixian").val());
    var pay_user = $.trim($("#pay_user").val());
    var pay_type = $("#pay_type").val();
    var password = $("#password").val();
    if (password == '') {
        layer.msg("请输入登录密码");   return;
    }

    $.ajax({
        url : '/supp/withdraw',
        data: {
            "balance": tixian,
            "pay_user": pay_user,
            "pay_type": pay_type,
            "password": password,
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
})
</script>

</body>
</html>
