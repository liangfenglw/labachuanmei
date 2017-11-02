<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>帐户信息</title>
    @include('console.share.cssjs')
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->

@include('console.share.admin_head')
@include('console.share.admin_menu')         <!--    左弹菜单 普通会员首页 -->


<div class="content"><div class="Invoice">

    <div class="place">
        <div class="place_ant"><a href="/console/index">首页</a><a href="/console/withdraw/list" class="cur">帐户信息 </a></div>
    </div>
    
    
    <div class="main_o clearfix" style="padding-bottom:60px;">
    
        <h3 class="title4 clearfix"><strong><a>提现详情</a></strong></h3>
        
        <div class="clearfix">

            <div class="wrap_f clearfix" style="width:60%;">
            
<!--
    金额超出五千客服联系确认信息，完成后并发送邮件通知
-->

                <form action="" method="post">
                    {!! csrf_field() !!}                
                    <div class="item_f"><p><i class="LGntas"></i>订单号：</p>
                        <div class="r"><input type="text" name="id" id="textfield" class="txt_f1" value="{{ $info['id'] }}"></div>
                    </div>
                    
                    <div class="item_f"><p><i class="LGntas"></i>用户名：</p>
                        <div class="r"><input type="text" name="name" id="textfield" class="txt_f1" value="{{ $info['users']['name'] }}"></div>
                    </div>

                    <div class="item_f"><p><i class="LGntas"></i>用户角色：</p>
                        <div class="r"><input type="text" readonly="readonly" name="user_level" id="textfield" class="txt_f1"  value="@if($info['ads_user']) {{ $info['ads_user']['level']['level_name'] }}  @else 供应商  @endif" /></div>
                    </div>
                    <div class="item_f"><p><i class="LGntas"></i>账户余额：</p>
                        <div class="r">
                            <input type="text" name="user_money" readonly="readonly" id="textfield" class="txt_f1" value="{{ $info['users']['user_mes']['user_money'] }}" style="width:16%;"><span class="color1" style="padding-left:10px;font-size:16px;" >元</span>
                            <span class="info2_f">
                                <i>*</i> 用户当前账户余额
                            </span>
                        </div>
                    </div>
                    <div class="item_f"><p><i class="LGntas"></i>提现金额：</p>
                        <div class="r">
                            <input type="text" readonly="readonly" name="textfield" id="textfield" class="txt_f1" style="width:16%;" value="{{ $info['user_money'] }}"><span class="color1" style="padding-left:10px;font-size:16px;" >元</span>
                            <span class="info2_f">
                                <i>*</i> 验证用户账户可用余额不得大于提现金额
                            </span>
                        </div>
                    </div>
                    <div class="item_f"><p><i class="LGntas"></i>提现方式：</p>
                        <div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" style="width:16%;" value="{{$paylist[$info['pay_type']]}}" /></div>
                    </div>
                    <div class="item_f"><p><i class="LGntas"></i>提款账号：</p>
                        <div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" style="width:38%;" value="{{$info['pay_user']}}" /></div>
                    </div>
                    <div class="item_f"><p><i class="LGntas"></i>状态：</p>
                        <div class="r radio_w">
                            <label class="rd1 @if($info['status'] == 1) css_cur @endif"><input type="radio" name="status" class="radio_f" value="1" @if($info['status'] == 1) checked @endif/>完成</label>
                            <label class="rd1 @if($info['status'] == 0) css_cur @endif"><input type="radio" name="status" class="radio_f" value="2" @if($info['status'] == 0) checked @endif/>审核中</label>
                            <label class="rd1 @if($info['status'] == 2) css_cur @endif"><input type="radio" name="status" class="radio_f" value="3" @if($info['status'] == 2) checked @endif/>拒提现</label>
                        </div>
                    </div>
                    <div class="item_f"><p><i class="LGntas"></i>备注：</p>
                        <div class="r">
                            <textarea class="txt_ft1" style="height:120px;" readonly="readonly">{{ $info['desc'] }}</textarea>
                        </div>
                    </div>
                    @if($info['status'] == 0)
                    <div class="item_f item_f_2" style="margin-top:50px; margin-left:-157px;">
                        <div class="r"><input type="submit" value="确 认" class="sub5" style="amargin-left:0;" /></div>
                    @else {{-- 已审核通过  --}}
                        <div class="item_f item_f_2" style="margin-top:50px; margin-left:-157px;">
                            <div class="r"><input type="button" onclick="layer.msg('已完成，不能进行操作')" value="已完成" class="sub5" style="amargin-left:0;" /></div>
                        </div>
                    @endif
                </form>
            </div>
                
        </div>
        
    </div>
    
</div></div>

@include('console.share.admin_foot')

<script>
/*  日历  */
    if( $('#datepicker1').length>0 && typeof(picker1)!="object" ){
        var picker1 = new Pikaday({
            field: document.getElementById('datepicker1'),
            firstDay: 1,
            format: "YYYY-MM-DD",
            minDate: new Date('2000-01-01'),
            maxDate: new Date('2020-12-31'),
            yearRange: [2000,2020]
        });
    }
    if( $('#datepicker2').length>0 && typeof(picker2)!="object" ){
        var picker2 = new Pikaday({
            field: document.getElementById('datepicker2'),
            firstDay: 1,
            format: "YYYY-MM-DD",
            minDate: new Date('2000-01-01'),
            maxDate: new Date('2020-12-31'),
            yearRange: [2000,2020]
        });
    }
    if( $('#datepicker3').length>0 && typeof(picker3)!="object" ){
        var picker3 = new Pikaday({
            field: document.getElementById('datepicker3'),
            firstDay: 1,
            format: "YYYY-MM-DD",
            minDate: new Date('2000-01-01'),
            maxDate: new Date('2020-12-31'),
            yearRange: [2000,2020]
        });
    }


</script>

</body>
</html>
