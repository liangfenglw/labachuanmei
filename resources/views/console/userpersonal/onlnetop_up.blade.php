<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>充值_喇叭传媒</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
    @include('console.share.cssjs')
	<style>
		.wx_code{	display:inline-block;	position:absolute;	margin-left:30px;	}
		.wx_code p{		text-align:center;	float:none;	}
		.wx_code p img{		}
		
	</style>
</head>
<body class="fold">			<!--	class="fold" 左导航收缩	-->


@include('console.share.admin_head')
@include('console.share.admin_menu')			<!--	左弹菜单 普通会员首页	-->
<div class="content"><div class="Invoice">
	@include('console.share.user_menu')
	<div class="place">
        <div class="place_ant"><a href="/">首页</a> <a href="{{url('userpersonal/account_query')}}"  class="cur">账户查询 </a></div>
	</div>
	
	<div class="main_s">
		<h3 class="title3"><strong>帐户充值</strong></h3>
		
		<div class="IF1 clearfix" style="padding:70px 0% 0 5%;width:57%;">
			<div class="IF3"><p>充值金额:</p>
				 <input type="text" name="recharge" id="recharge" class="txt_f1" style="width:14%;">
				 <input type="hidden" name="pay" id="pay" value="">
				 <span>元</span>
			</div>
			<div class="LGnt8">
				<ul>
                    @foreach($lists as $list)
					<li class="rechargelist">{{$list}}</li>
					@endforeach
				</ul>
			</div>
			<div class="IF3"><p>充值方式:</p>
				<ul class="LGnt9" id="pay_list">
                    <li onclick="selectpay('wx')"><img src="{{url('console/images/LGnta1.jpg')}}"/></li>
					<li onclick="selectpay('ali')"><img src="{{url('console/images/LGnta2.jpg')}}" /></li>
				</ul>
			</div>
			<div class="IF3">
				<p>&nbsp;</p>
				<div class="IFN4">
					<span style="color:#ff0000; font-weight:700">注意事项</span>
					<span><i style="color:#ff0000;">每次10元起充，</i>如果您有支付宝、网上银行账户，请使用在线充值，即时到账！如果您不方便在线充值，可联系客服代充。客服QQ：3315033406 电话：020-34206485</span>
					<span></span>
				</div>
			</div>
			<div class="IF3" style="margin-top:20px;" id="payimg">
				<p>&nbsp;</p>
				<input type="submit" name="paybutton" id="paybutton" value="立即充值" class="sub5" style="margin-left:0px;"/>
			</div>
		</div>



		
	</div>
	

</div></div>

@include('console.share.admin_foot')

<script type="text/javascript">
    var order_sn;
$(function(){
	$(".LGnt8 ul li").click(function(){
		var a = $.trim($(this).html());
		a = a.replace("元","");
		$("input[name=name1]").val(a);
	});


    var type = 'alipay';
    $(".rechargelist").click(function () {
        $("#recharge").val($(this).html());
    });



    $("#paybutton").click(function () {
        var charge = $("#recharge").val();
        var pay = $("#pay").val();
        var url = '';
        if (pay == '') {
            layer.msg('请选择充值方式!');
            return false;
        }else{
        	if (pay == 'wx') {
        		url = "{{url('/payment/balance_pay_wx')}}";
        	}else{
        		url = "{{url('/payment/balance_pay_ali')}}";
        	}
        }
        if(charge==""){
            layer.msg('请先输入金额!');
        }else{
            $.ajax({
                type: "get",
                url: url,
                data: {
                    "money": charge,
                    "pay": pay
                },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        if (pay == 'wx') {
//                        	$("#payimg").append(data.data);
                        	$("#payimg").find(".wx_code").remove();
                        	$("#payimg").append("<div class='wx_code'><p>" + data.data + "</p><p>扫码付费</p></div>");
                    		order_sn = data.order_sn;
                    		select_order();
                        	return false;
                        };
                        window.location.href = data.data;
                    }else{
//                                console.log(data.data);
                        layer.msg(data.msg);
                    }
                }
            });
        }
    })
});
// 触发ajax请求，查询微信是否支付成功
function select_order () {
    $.ajax({
            type : "get",
        	url:"{{url('/payment/ajax_check_balance')}}",//+tab,
            data :{order_sn:order_sn} ,
            dataType:'json',
        success: function(data){
          if(data.data['status'] == 1){
           	layer.msg('恭喜支付成功');
            window.location.href = "{{url('/payment/pay_success')}}";
            return false;
          }else{
            setTimeout("select_order()",3000);
          }
        }
    });
}




    function selectpay (argument) {
    	$("#pay").val(argument);
    }
	$("#pay_list li").click(function(){
		$(this).addClass("cur").siblings("li").removeClass("cur");
	});

</script>

</body>
</html>
