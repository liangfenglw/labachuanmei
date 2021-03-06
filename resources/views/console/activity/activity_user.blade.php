<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>活动管理_喇叭传媒</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    @include('console.share.cssjs')
	<style>
		.tab1_body .a_control{	width:30px;	height:24px;	line-height:24px;	overflow:hidden;	float:right;	text-align:center;
			margin-right:20px;	padding:0 10px;	font-weight:700;	color:#f00;	font-size:30px;		}
	</style>
</head>
<body class="fold"><!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')<!--    左弹菜单 普通会员首页 -->
<div class="content"><div class="Invoice">
    <div class="place">
        <div class="place_ant"><a href="/console/index">首页</a><a  href="/console/activity/list" class="cur">活动管理 </a></div>
    </div>
    <div class="main_o clearfix" style="padding-bottom:20px;">
            <h3 class="title4 clearfix"><strong><a>活动媒体供应商</a></strong>
				<div class="search_1" id="search_act" style="margin-left:50px;float:left;">
					<form method="post" action="" id="form_act">
						<input type="text" name="key_act" class="txt5" id="key_act" placeholder="搜一下" />
						<input type="submit" class="sub4_3" id="sub_act" value="搜索">
					</form>
				</div>
			</h3>
            <div class="dhorder_m">
            <form method="post"  action="/console/activity/user/add">
                {{ csrf_field() }}
                <input type="hidden" name="activity_id" value="{{ $id }}">
                <div class="tab1_body">
                    <table class="table_in1 cur" >
                        @foreach($media as $key => $users)
                            <thead>
                                <tr>
                                    <th colspan="5" style="text-align:left;width:1%; padding-left:1%;">{{ $users['plate_name'] }}
										<label class="check_all"><input type="checkbox" name="" value="" class="checkall" />全选</label>
										<a href="#" class="a_control" data="on" title="收起">-</a>
									</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach($users['self_supp_user'] as $kk => $user)
                                <?php if($i == 0) { echo "<tr>"; } ?>
                                    <?php ++$i; ?>
                                    <td style="text-align:left;width:20%; padding-left:1%;">
                                        <input type="checkbox" name="user_id[]" @if(!empty($users_data) && in_array($user['user_id'], $users_data)) checked="checked" @endif  value="{{ $user['user_id'] or ''}}">【<font color="red">{{ $child_media[$user['plate_id']] or '' }}</font>】{{ $user['media_name'] }}
                                        
                                    </td>
                                <?php if ($i >= 4) { $i=0;echo "</tr>"; } ?>
                                @endforeach
                            </tbody>
                        @endforeach
                            <tbody >
                                    <tr>
                                        <td><input type="submit" name="" class="sub4_3"  value="添加" /></td>
                                    </tr>
                            </tbody>
                        
                    </table>
                </div>
            </form>
        </div>
        </div>
    

</div></div>
@include('console.share.admin_foot')
<script type="text/javascript">
	$(".checkall").click(function(){
		if( $(this).is(":checked") ) {
			$(this).closest("thead").next("tbody").find("input[name='user_id[]']").prop("checked",true);
		}else{
			$(this).closest("thead").next("tbody").find("input[name='user_id[]']").prop("checked",false);
		}
	});
	$("input[name='user_id[]']").click(function(){
		var len = $(this).closest("tbody").find("input[name='user_id[]']").length;
		if( $(this).closest("tbody").find("input[name='user_id[]']:checked").length == len ){
			$(this).closest("tbody").prev("thead").find(".checkall").prop("checked",true);
		}
		if( $(this).closest("tbody").find("input[name='user_id[]']:checked").length < len ){
			$(this).closest("tbody").prev("thead").find(".checkall").prop("checked",false);
		}
	});
	
	$(".a_control").click(function(){
		var data = $(this).attr("data");
		if( data == "on" ){
			$(this).closest("thead").next("tbody").hide();
			$(this).attr("data","off").html("+");
			$(this).attr("title","展开");
		}else{
			$(this).closest("thead").next("tbody").show();
			$(this).attr("data","on").html("-");
			$(this).attr("title","收起");
		}
		return false;
	});

</script>

</body>
</html>
