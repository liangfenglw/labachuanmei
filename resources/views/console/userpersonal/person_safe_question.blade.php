<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>密保_喇叭传媒</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />

    @include('console.share.cssjs')
	
	<style>
		
	</style>
</head>
<body class="fold">			<!--	class="fold" 左导航收缩	-->

@include('console.share.admin_head')
@include('console.share.admin_menu')


<div class="content"><div class="Invoice">

	@include('console.share.user_menu')

	<div class="place">
		<div class="place_ant"><a href="/">首页</a> <a href="{{url('userpersonal/person_edit')}}">用户信息 </a> <a href="{{url('userpersonal/person_safe')}}"  class="cur">安全设置 </a></div>
	</div>
	
	<div class="main_s">
		<h3 class="title3"><strong>密保设置</strong>
			
            {{-- 如果为1 则是重新设置密保 --}}
			@if($security_status == 1) 要先回答正确原密保 @endif
		</h3>
		<div class="safe_2 clearfix">
					<div class="WMain3 WMain3_2 clearfix"><p><i class="LGntas"></i>会员帐号：</p>
						{{$user['name']}}
					</div>
					
				<form  method="post" id="question_form" onsubmit="return false;">
					{{ csrf_field() }}

					<input type="hidden" name="security_status" id="security_status" value="{{$security_status}}">

                    @foreach($security_question_cat as $key => $value)
					<div class="WMain3 WMain3_2 clearfix"><p><i class="LGntas"></i>{{$value['name']}}：</p>
						<select class="sel_2" id="question_{{$value['id']}}" name="question[{{$value['id']}}][]" @if($security_status) disabled="disabled"   @endif style="height: 45px; color: #666">
                    		@foreach($value['question'] as $k => $v)
							<option @if($security_status && $value['answer'] == $v['id']) selected="selected"   @endif value="{{$v['id']}}">{{$v['name']}}</option>
							@endforeach
						</select>
					</div>
					<div class="WMain3 WMain3_2 clearfix"><p><i class="LGntas"></i>您的回答：</p>
						<input type="text" name="answer[{{$value['id']}}][]" id="answer_{{$value['id']}}" class="txt6"  style="height: 45px; color: #666">

					</div>

					
					@if($security_status)
					@foreach($value['question'] as $k => $v)
					@if($value['answer'] == $v['id'])
					<input type="hidden" name="question[{{$value['id']}}][]" id="security_status" value="{{$v['id']}}">
					@endif
					@endforeach
					@endif



					@endforeach
					<div class="WMain3 WMain3_2 clearfix" style="margin-top:50px;margin-left:-30px">
						<input type="button" id="submit_button" value="提交" class="sub5">
					</div>
					<div class="clr"></div>
					</form>
		</div>
		<div class="safe2_b">
			友情提醒：用户名和密码要做好相应记录，以免忘记。
		</div>
	</div>
	

</div></div>

@include('console.share.admin_foot')

<script type="text/javascript">

//	$(".logo").addClass("hidden");
$(function(){
        $('#submit_button').click(function () {
            var security_status = $('#security_status').val();
            var url = './post_safe_question';
            if (security_status > 0) {
            	url = './post_safe_question_select';
            };
            if ({{$security_status}} == 1) {
               layer.confirm('现在正在重新设置新密保', {
                  btn: ['确认','取消'] //按钮
                }, function() {
                    sub_ajax_question(url);
                }, function(){
                    layer.close();
                }); 
            } else {
                sub_ajax_question(url);
            }
        });
});

function sub_ajax_question(url) {
    $.ajax({
        url : url,
        data: $("#question_form").serialize(),
        type: 'post',
        dataType: "json",
        stopAllStart: true,
        success: function (data) {
            if (data.status == '1') {
                layer.msg(data.msg || '请求成功');
                window.location.href='/userpersonal/person_safe';
                // window.location.reload();
            } else {
                layer.msg(data.msg || '请求失败');
            }
        },
        error: function () {
            layer.msg('请求错误，请刷新页面重新尝试');
            return false;
        }
    });
}

</script>

</body>
</html>
