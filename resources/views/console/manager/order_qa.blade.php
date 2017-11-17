<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>申诉订单详情_喇叭传媒</title>
    @include('console.share.cssjs')
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')      <!--    左弹菜单 普通会员首页 -->
<div class="content"><div class="Invoice">
    <div class="place">
        <div class="place_ant"><a href="/console/index">首页</a><a  href="/console/manager/order/35">订单管理 </a><a  class="cur">订单申诉 </a></div>
    </div>
    <div class="main_o">
        <h3 class="title5 clearfix"><strong>我的订单</strong></h3>
        <div class="clearfix wrap_f" style="padding-bottom:50px;">
            <form action="" method="post" onsubmit="return sub_form();">
                {!! csrf_field() !!}                
                <div class="item_f"><p><i class="LGntas"></i>订单号：</p>
                    <div class="r">
                        <input type="text" name="order_id" id="textfield" class="txt_f1" readonly="readonly" value="{{$info['order_id']}}">
                        <span class="color1" style="padding-left:10px;"><a href="/console/manager/order/info/{{$info['order_id']}}?type=1"></a></span>
                    </div>

                </div>
                <div class="item_f"><p><i class="LGntas"></i>所属用户：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" readonly="readonly"  class="txt_f1" value="{{ $info['nickname'] }}"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>所属媒体：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" readonly="readonly"  class="txt_f1" value="{{ $info['media_name'] }}"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>稿件类型：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" readonly="readonly"  class="txt_f1" value="{{ $info['type_name'] }}"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>稿件名称：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" readonly="readonly"  class="txt_f1" style="width:48%;" value="{{ $info['title'] }}"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>完成链接：</p>
                    <div class="r">
                        <input type="text" name="textfield" readonly="readonly"  id="textfield" class="txt_f1" style="width:73%;" value="{{ $info['success_url'] }}">
                    </div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>完成截图：</p>
                    <div class="r" style="position:relative;">
                        <div class="img_show">
                        	<img src="{{ $info['success_pic'] }}" style="width:130px; height:130px;">
                        	<input type="file" name="" class="txt6 txt6_up upfile upload_f1" style="width:130px;height:130px;display:none;opacity:0;"	/>
                        </div>
                    </div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>申诉标题：</p>
                    <div class="r">
                        <input type="text" readonly="readonly"  name="textfield" id="textfield" class="txt_f1" style="width:48%;" value="{{ $info['appeal_title'] }}"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>申诉内容：</p>
                    <div class="r">
                        <textarea class="txt_ft1" readonly="readonly" >{{ $info['content'] }}</textarea>
                    </div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>申诉状态：</p>
                    <div class="r">
                        <select class="sel_f1" disabled="disabled">
                            <option value="0" @if($info['order_type'] == 0) selected="selected" @endif>未完成</option>
                            <option value="1" @if($info['order_type'] == 1) selected="selected" @endif>成功</option>
                        </select>
                    </div>
                </div>
               <div class="item_f" style="@if(!$info['qa_change']) display: none @endif" id="qa_change"><p><i class="LGntas"></i>质量扣款：</p>
                    <div class="r">
                        <input type="text" name="qa_change" id="qa_change2" value="{{$info['qa_change']}}" class="txt_f1">元
                    </div>
                </div>
                <!--    管理员可处理申诉状态及申诉反馈，首次提交时不显示 ，查看申诉订单时显示 -->
                <div class="item_f"><p><i class="LGntas"></i>申诉反馈：</p>
                    <div class="r">
                        <textarea class="txt_ft1" name="order_feedback" style="height:98px;">{{ $info['order_feedback'] }}</textarea>
                    </div>
                </div>
                @if($info['order_type'] != 1)
                 <div class="item_f"><p><i class="LGntas"></i>申诉操作：</p>
                    <div class="r">
                        <select class="sel_f1" name="opeare" id="opeare" onchange="select_show(this);">
                            <option value="0" selected="selected">未完成</option>
                            <option value="1">成功</option>
                        </select>
                    </div>
                </div>
                @endif
                <script type="text/javascript">
                    function select_show(obj) {
                        if ($(obj).val() == 0) {
                            $("#qa_change").hide();
                        } else if ($(obj).val() == 1) {
                            $("#qa_change").show();
                        }
                    }
                </script>
                @if($info['order_type'] != 1)
                    <div class="item_f item_f_2" style="margin-top:50px; margin-left:0;">
                        <div class="r"><input type="submit" value="确 认" class="sub_f1"></div>
                    </div>
                @endif
                {{-- 完成 --}}
                @if($info['order_type'] == 1)
                    <div class="item_f item_f_2" style="margin-top:50px; margin-left:0;">
                        <div class="r"><input type="button" onclick="layer.msg('已完成申诉,不可进行操作')" value="已完成申诉" class="sub5"></div>
                    </div>
                @endif
            </form>
            
        </div>

    </div>  

</div></div>

@include('console.share.admin_foot')

<script type="text/javascript">
var order_user_money = "{{$info['user_money']}}";
function sub_form() {
    if ($("#opeare").val() == 1){
        var qa = $("#qa_change2").val();
        if (order_user_money < qa) {
            layer.msg("质检扣款金额不能大于交易金额");
            return false;
        }
    }
    return true;
}


</script>

</body>
</html>
