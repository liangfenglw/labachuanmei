<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>安—证件信息 - 亚媒社</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    @include('console.share.cssjs')
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')
<div class="content"><div class="Invoice">
    @include('console.share.user_menu')
    <div class="place">
        当前位置：<a href="/">首页</a> > <a href="person_edit">用户信息</a> > <a href="person_safe">安全设置</a>
    </div>
    
    <div class="main_s">
        <h3 class="title3"><strong>会员认证</strong>
            <a href=""><img class="title3_img" src="{{url('console/images/arr_s.png')}}" alt="" /></a>
            <span class="title3_i"></span>
        </h3>
        
        <div class="safe_2 clearfix">
                    <div class="WMain3 WMain3_2 clearfix"><p><i class="LGntas"></i>会员帐号：</p>
                        {{$user['name']}}
                    </div>
                    <div class="WMain3 WMain3_2 clearfix"><p><i class="LGntas"></i>认证图：</p>
                        <div class="img_up" id="img_up">
                            <img src="/uploads/{{$user['media_check_file']}}">
                        </div>
                    </div>
                    <div class="clr"></div>
        </div>
        <div class="safe2_b">
            友情提醒：用户名和密码要做好相应记录，以免忘记。
        </div>


        
    </div>
    

</div></div>

@include('console.share.admin_foot')

<script type="text/javascript">
// 判断输入框是否为空
function checkForm(){
    
    var input_file = $("#user_form").find("input[name='input_file']").val();                    
    

    if($.trim(input_file) == '')
    {
        layer.msg('请上传证件副件');
        return false;
    }

    return true;
}

//  $(".logo").addClass("hidden");
$(function(){
//  $(".sidebar-open-button").click();
});

$("#input_file").change(function(){
//  var filepath=$(this).val();
//  $("#path_file").val(filepath);  // C:\fakepath\1.jpg
    
    var path=$(this).val();
    var path1 = path.lastIndexOf("\\");
    var name = path.substring(path1+1);
    $("#path_file").val(name);
})

</script>

</body>
</html>
