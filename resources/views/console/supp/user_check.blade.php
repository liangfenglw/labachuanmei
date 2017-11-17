<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>证件信息_喇叭传媒</title>
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
        <div class="place_ant"><a href="/console/index">首页</a><a href="/userpersonal/person_safe" class="cur">安全设置 </a></div>
    </div>
    
    <div class="main_s">
        <h3 class="title3"><strong>会员认证</strong></h3>
        <div class="safe_2 clearfix">
                    <div class="WMain3 WMain3_2 clearfix"><p><i class="LGntas"></i>会员帐号：</p>
                        {{$user['name']}}
                    </div>
                    <div class="WMain3 WMain3_2 clearfix"><p><i class="LGntas"></i>认证图：</p>
                        <div class="img_up" id="img_up">
                            <div class="img_show">
                            	<img src="{{$user['media_check_file']}}" >
                            	<input type="file" name="..name.." class="txt6 txt6_up upfile upload_f1" accept="image/jpg,image/jpeg,image/png" style="width:130px;height:130px;display:none;opacity:0;"	/>
                            </div>
                        </div>
                    </div>
                    <div class="WMain3 WMain3_2 clearfix" style="margin-top:110px; margin-left:-40px">
						<input value="提交" class="sub5" type="submit">
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
	console.log(path);
	console.log(path1);
	console.log(name);
	console.log($("#path_file").val());
})

</script>

</body>
</html>
