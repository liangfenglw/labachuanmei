<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>订单申诉 - 亚媒社</title>
    @include('console.share.cssjs')
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')            <!--    左弹菜单 普通会员首页 -->


<div class="content"><div class="Invoice">

    <div class="place">
        当前位置：<a href="/console/index">首页</a> > <a href="/order/order_list">订单管理</a> > 订单申诉
    </div>
    
    <div class="main_o">
        
        <h3 class="title5 clearfix"><strong>我的订单</strong></h3>
        
        <div class="clearfix wrap_f" style="padding-bottom:50px;">
        
            <form action="" method="post" enctype="multipart/form-data" id="user_form" onsubmit="return checkForm();">
        {{ csrf_field() }} 
                <!-- <input type="hidden" name="order_id" value=""> -->
                <!-- <input type="hidden" name="type_name" value="">
                <input type="hidden" name="title" value=""> -->
                <input type="hidden" name="type_id" id="type_id" value="">
                <input type="hidden" name="order_sn" id="order_sn" value="">
                <div class="item_f"><p><i class="LGntas"></i>订单号：</p>
                    <div class="r"><input type="text" name="order_id"  value="" onblur="select_appeal_order()" id="order_id" class="txt_f1" style=""></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>活动类型：</p>
                    <div class="r"><input type="text" name="type_name" id="type_name" value="" class="txt_f1" style=""></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>活动名称：</p>
                    <div class="r"><input type="text" name="title" id="title" class="txt_f1" value="" style="width:48%;"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>完成链接：</p>
                    <div class="r"><input type="text" name="success_url" id="success_url" class="txt_f1" style="width:73%;"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>完成截图：</p>
                    <div class="r" style="position:relative;">
                        <img src="{{url('console/images/z_add2.png')}}" id="img_upload" style="cursor:pointer;" />
                        <input type="hidden" name="success_pic" id="success_pic"  value="">
                    </div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>申诉标题：</p>
                    <div class="r"><input type="text" name="appeal_title" id="appeal_title" class="txt_f1" style="width:48%;"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>申诉内容：</p>
                    <div class="r">
                        <textarea class="txt_ft1" name="content"></textarea>
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
               <!--  <div class="item_f"><p><i class="LGntas"></i>申诉反馈：</p>
                    <div class="r">
                        <textarea class="txt_ft1" style="height:98px;" name="order_feedback"></textarea>
                    </div>
                </div> -->
                <div class="item_f item_f_2" style="margin-top:50px;">
                    <div class="r"><input type="submit" value="确 认" class="sub_f1"></div>
                </div>
            </form>
            
        </div>

    </div>  

</div></div>

@include('console.share.admin_foot')

<script type="text/javascript">
// 判断输入框是否为空
var _token = $("input[name=_token]").val();
$(function(){
    @if(Request::input('id'))
        $("#user_form").find("input[name='order_id']").val({{Request::input('id')}});
        ajax_order_info({{Request::input('id')}})
    @endif
})

function ajax_order_info(order_id) {
    $.ajax({
        url: "select_appeal_order",
        data: {
            'order_id' : order_id,
            '_token' : _token
        },
        type: 'post',
        dataType: "json",
        success: function (data) {
            /*layer.close(1);*/
            if (data.status == '1') {
                $("#order_sn").val(data.data.order_sn);
                $("#type_id").val(data.data.type_id);
                $("#type_name").val(data.data.type_name);
                $("#title").val(data['data']['parent_order']['title']);
                $("#success_url").val(data['data']['success_url']);
                $("#img_upload").attr('src',data['data']['success_pic']);
                $("#user_form").find("input[name='success_pic']").val(data['data']['success_pic']);  

            }else {
                layer.msg(data.msg || '操作失败');
            }
        },
        error: function (data) {
            layer.msg(data.msg || '网络发生错误');
            return false;
        }
    }); 
}
function select_appeal_order () {
    var order_id = $("#user_form").find("input[name='order_id']").val();
    if($.trim(order_id) == '')
    {
        layer.msg('订单号不能为空');
        return false;
    }
    ajax_order_info(order_id);
    
}
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

    // if($.trim(success_pic) == '')
    // {
    //     layer.msg('请上传完成截图');
    //     return false;
    // }

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
