<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>订单申诉_喇叭传媒</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    @include('console.share.cssjs')
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->


@include('console.share.admin_head')
@include('console.share.admin_menu')            <!--    左弹菜单 普通会员首页 -->


<div class="content"><div class="Invoice">

    <div class="place">
        <div class="place_ant"><a href="/console/index">首页</a><a href="/order/order_list">订单管理 </a><a  class="cur">订单申诉 </a></div>
    </div>
    
    <div class="main_o">
        
        <h3 class="title5 clearfix"><strong>我的订单</strong></h3>
        
        <div class="clearfix wrap_f" style="padding-bottom:50px;">
        
            <form action="" method="post" enctype="multipart/form-data" id="user_form" onsubmit="return checkForm();">
        {{ csrf_field() }} 
                <input type="hidden" name="order_id" value="{{$info['id']}}">
                <input type="hidden" name="type_name" value="{{$info['type_name']}}">
                <input type="hidden" name="title" value="{{$info['parent_order']['title']}}">
                <input type="hidden" name="type_id" value="{{$info['type_id']}}">
                <div class="item_f"><p><i class="LGntas"></i>订单号：</p>
                    <div class="r"><input type="text" name="textfield" disabled="disabled" value="{{ $info['order_id'] }}" id="textfield" class="txt_f1" style=""></div>
                </div>
                @if($user['level_id'] == 2 && $is_parent)
                <div class="item_f"><p><i class="LGntas"></i>所属用户：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" style="" value="{{$info['parent_order']['user']['name']}}" disabled="disabled"></div>
                </div>
                @endif
                <div class="item_f"><p><i class="LGntas"></i>订单状态：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" disabled="disabled" class="txt_f1" value="{{ getOrderType($info['order_network']['order_type']) }}"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>稿件类型：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" disabled="disabled" value="{{ $info['type_name'] }}" class="txt_f1" style=""></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>稿件名称：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" disabled="disabled" value="{{ $info['title'] }}" style="width:52%;"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>完成链接：</p>
                    <div class="r"><input type="text" name="success_url" id="success_url" disabled="disabled" value="{{ $info['success_url'] }}" class="txt_f1" style="width:73%;"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>完成截图：</p>
                    <div class="r" style="position:relative;">
                        <img src="{{$info['success_pic']}}" id="img_upload" style="cursor:pointer; width:130px; height:130px;" />
                        <!-- <input type="file" name="success_pic" id="success_pic" placeholder="未选择任何文件" class="upload_f1" accept="image/*" style=""> -->
                    </div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>申诉标题：</p>
                    <div class="r"><input type="text" name="appeal_title" id="appeal_title" disabled="disabled" value="{{ $info['appeal_title'] }}" class="txt_f1" style="width:52%;"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>申诉内容：</p>
                    <div class="r">
                        <textarea class="txt_ft1" name="content" disabled>{{ $info['content'] }}</textarea>
                    </div>
                </div>
                <!-- <div class="item_f"><p><i class="LGntas"></i>申诉状态：</p>
                    <div class="r">
                        <select class="sel_f1">
                            <option value="1">已完成</option>
                            <option value="2">未完成</option>
                            <option value="3">......</option>
                        </select>
                    </div>
                </div> -->
                <!--    管理员可处理申诉状态及申诉反馈，首次提交时不显示 ，查看申诉订单时显示 -->
                @if($info['order_feedback'])
                <div class="item_f"><p><i class="LGntas"></i>申诉反馈：</p>
                    <div class="r">
                        <textarea class="txt_ft1" style="height:98px;" name="order_feedback" disabled>{{$info['order_feedback']}}</textarea>
                    </div>
                </div>
                @endif
                <!-- <div class="item_f item_f_2" style="margin-top:50px;margin-left:-157px"">
                    <div class="r"><input type="submit" value="确 认" class="sub5"></div>
                </div> -->
            </form>
            
        </div>

    </div>  

</div></div>

@include('console.share.admin_foot')

<script type="text/javascript">
// 判断输入框是否为空
function checkForm(){
    
    var order_id = $("#user_form").find("input[name='order_id']").val();                    
    var type_name = $("#user_form").find("input[name='type_name']").val();    
    var title = $("#user_form").find("input[name='title']").val();  
    var success_url = $("#user_form").find("input[name='success_url']").val();      
    var success_pic = $("#user_form").find("input[name='success_pic']").val();  
    var appeal_title = $("#user_form").find("input[name='appeal_title']").val(); 
    var content = $("#user_form").find("textarea[name='content']").val();   


    if($.trim(order_id) == '')
    {
        layer.msg('系统繁忙');
        return false;
    }    

    if($.trim(type_name) == '')
    {
        layer.msg('系统繁忙');
        return false;
    }    

    if($.trim(title) == '')
    {
        layer.msg('系统繁忙');
        return false;
    }    

    if($.trim(success_url) == '')
    {
        layer.msg('请填写完成链接');
        return false;
    }

    if($.trim(success_pic) == '')
    {
        layer.msg('请上传完成截图');
        return false;
    }

    if($.trim(appeal_title) == '')
    {
        layer.msg('请填写申诉标题');
        return false;
    }

    if($.trim(content) == '')
    {
        layer.msg('请填写申诉内容');
        return false;
    }

    return true;
}
    
$(function(){

});


</script>

</body>
</html>
