<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>{{$media['plate_name']}}_喇叭传媒</title>

	<meta name="description" content="" />
	<meta name="keywords" content="" />

    @include('console.share.cssjs')

	<style>
	#error_show a{    font-size: 16px;    color: #ff0000; padding-left:50%; float:left; width:100%; line-height:30px; border-top:1px solid #eee;padding-top: 20px;}
	body .logo-title img{	display:none;	}
	</style>
</head>
<body class="fold">			<!--	class="fold" 左导航收缩	-->

@include('console.share.admin_head')
@include('console.share.admin_menu')			<!--	左弹菜单 普通会员首页	-->


<div class="content"><div class="Invoice">

	<div class="place">
		 <div class="place_ant"><a href="/console/index">首页</a><a  class="cur">{{$media['plate_name']}} </a></div>
	</div>
	
	<div class="main_o clearfix" style="">
	
		<h3 class="title5 clearfix"><strong>{{$media['plate_name']}}</strong></h3><!--视频营销-->
		
		<div class="Wikipedia">
		
			<div class="sbox_1 clearfix">
				<div class="sbox_1_w" id="attr_val">
        			{{ csrf_field() }}
					{!!$html!!}
				</div>
			</div>
			<div class="sbox_2 clearfix radius1">
				<strong class="l">已选择：</strong>
				<ul class="m">{!! $select_html !!}</ul>
				
			</div>
			<div class="sbox_3">
				<h4>
					<span class="r">每页显示
						<select class="" id="page_nums">
							<option value="10">10</option>
							<option value="5">5</option>
							<option value="4">4</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
						</select>条记录
					</span>
					<strong class="l">共<b id='resource_count'> @if(!empty(Request::input('user_id'))) 0 @else {{$resource_count}} @endif </b>条媒体</strong>
				</h4>
				<div class="sbox_3_table tab1_body clearfix" style="margin-top:15px;" id="error_show">
					<table class="table_in1 cur" style="margin:0;" id="resource_table">
						<thead id="title_bbs">
							<tr class="normal">
								<th><label class="check_all" style="margin:0;"><input type="checkbox" name="checkall" value="1" class="checkall" />全选</label></th>
								<th style="width:18%;">媒体名称</th>
								<th>平台</th>
								<th>视频类型</th>
								<th>粉丝量</th>
								<th>性别</th>
								<!-- <th>阅读量</th> -->
								<th>价格</th>
								<th style="min-width:120px;">活动价</th>
								<th style="width:20%;">备注</th>
							</tr>
						</thead>
						
						@if(!empty(Request::input('user_id')))
						<tbody id="wrapper_i"></tbody>
						@else
						<tbody id="wrapper_i">
							@if($lists)
								@foreach($lists as $k => $v)
								<tr rst_id="{{$v['user_id']}}">
									<td>&nbsp; &nbsp; <input type="checkbox" name="check_1" value="" /></td>
									<td class="logo-title"><img src="{{$v['media_logo']}}">{{$v['media_name']}}</td>
									<td>@if(isset($v['platform_type'])){{$v['platform_type']}}@else 不限 @endif</td>
									<td>@if(isset($v['video_type'])){{$v['video_type']}}@else 不限 @endif</td>
									<td>@if(isset($v['fans'])){{$v['fans']}}@else 不限 @endif</td>
									<td>@if(isset($v['sex_type'])){{$v['sex_type']}}@else 不限 @endif</td>
									<td class="color1">￥{{$v['proxy_price']}}</td>
									<td class="color1">@if(empty($v['member_price'])) @else ￥{{$v['member_price']}} @endif</td>
									<td>{{$v['remark']}}</td>
								</tr>
								@endforeach
							@else
								<tr id="no-data"><td colspan="10"><a>抱歉，暂无媒体</a></td></tr>
							@endif
						</tbody>
						@endif
					</table>
					<div class="sbox_3_b" style="width:auto;height:auto;" id="page">
						@if($page['page_statue'])<a href="javascript:void(0);" onclick="page_load()" class="more"  style="adisplay:none;">加载更多</a>
						<div id="demo1"></div>@endif
					</div>
				</div>
			</div>
			
			<div class="WIn2 tab1_body clearfix" style="margin-top:50px;">
				<h2 style="margin-top:0;">已选媒体</h2>
				<table class="table_in1 cur" style="margin:0;">
					<thead>
						
						<tr class="normal">
							<th style="">选择</th>
							<th style="width:18%;">媒体名称</th>
							<th>平台</th>
							<th>视频类型</th>
							<th>粉丝量</th>
							<th>性别</th>
							<th>价格</th>
							<th style="width:8%;">操作</th>
						</tr>
					</thead>
					<tbody id="select_media">
				
					</tbody>
				</table>
			</div>
		
			<div class="sbox_5 clearfix" style="margin-top:50px;">
			<!--	稿件上传表单	-->
				<form id="form1" style="position:absolute;z-index:1000;">

        				{{ csrf_field() }}
					<!-- <input type="hidden" name="_token" value="x6WF98UczCSVQeCOopUjsUNWUf0inoxZcd4qATQg"> -->
					<input type="file" name="file" id="Manuscripts" class="txt6 txt6_up" 
						style="display:none;opacity:0;"	/>
				</form>

				<div class="WIn2" style="margin-top:0;">
					<h2>创建内容</h2>
					
				<form id="form5">
					<div class="WMain1" style="border:none;margin-left:8%; width:85%">
						<div class="WMain2">
							<ul>
								<li style="display:block;">
									<div class="WMain3"><p><i class="LGntas">*</i>合作形式:</p>
										<input type="text" name="name7" id="name7" maxlength="25"
											placeholder="" class="txt_f1" style="width:45%;" />
									</div>
									<div class="WMain3"><p><i class="LGntas">*</i>直播标题:</p>
										<input type="text" name="name1" id="name1" maxlength="25"
											placeholder="可输入25个汉字" class="txt_f1" style="width:45%;"/>
									</div>
									<!-- <div class="WMain3"><p><i class="LGntas">*</i>具体形式:</p>
										<label><input type="radio" name="name2" value="1" checked onclick="waibu.style.display='';shangchuan.style.display='none';bianji.style.display='none';$('#Manuscripts').hide();" checked/>外部连接</label>
										<label><input type="radio" name="name2" value="2" onclick="shangchuan.style.display='';waibu.style.display='none';bianji.style.display='none';$('#Manuscripts').show();setOffset('#Manuscripts','#upload_file');"/>上传文档</label>
										<label><input type="radio" name="name2" value="3" onclick="bianji.style.display='';waibu.style.display='none';shangchuan.style.display='none';$('#Manuscripts').hide();"/>内部编辑</label>
									</div> -->

									<div class="WMain3"><p><i class="LGntas">*</i>具体形式：</p>
										<label class="rd1"><input type="radio" name="name2" value="1" />活动现场直播</label>
										<label class="rd1"><input type="radio" name="name2" value="2" />产品使用</label>
										<label class="rd1"><input type="radio" name="name2" value="3" />店铺体验</label>
										<label class="rd1"><input type="radio" name="name2" value="4" />游戏直播</label>
									</div>
									
									<div class="WMain3"  id="bianji">
										<div class="WMain3 WMain3_1"><p><i class="LGntas">*</i>直播内容：</p>
											<script id="container" name="content" type="text/plain" style="width:80%;aheight:300px;width:auto;"></script>
										</div>
									</div>															
									<div class="WMain3 WMain3_1"><p><i class="LGntas"></i>直播地点:</p>
										<div id="key_input">
											<input type="text" name="name3" id="name3" class="txt_f1" style="width:45%;" placeholder=""/>
											<!--<p>还可输入<b>100</b>个字</p>-->
										</div>
									</div>
									<div class="WMain3 WMain3_2"><p><i class="LGntas">*</i>开始时间:</p>
										<input type="text" name="name4" id="datepicker1" class="txt2"/>
										<select class="sel_t1 options_h" name="name4_1">
										@for($i=0;$i<24;$i++)
										<option value='{{sprintf("%02d",$i)}}'>{{sprintf("%02d",$i)}}</option>
										@endfor
										
										</select>时
										<select class="sel_t1 options_m" name="name4_2">
										@for($i=0;$i<60;$i++)
										<option value='{{sprintf("%02d",$i)}}'>{{sprintf("%02d",$i)}}</option>
										@endfor
											
										</select>分
										<span id="time1-error">请选择当前时间后，7天之内的时间</span>
									</div>
									<div class="WMain3 WMain3_2"><p><i class="LGntas">*</i>截止时间:</p>
										<input type="text" name="name5" id="datepicker2" class="txt2"/>
										<select class="sel_t1 options_h" name="name5_1">
										@for($i=0;$i<24;$i++)
										<option value='{{sprintf("%02d",$i)}}'>{{sprintf("%02d",$i)}}</option>
										@endfor
											
										</select>时
										<select class="sel_t1 options_m" name="name5_2">
										@for($i=0;$i<60;$i++)
										<option value='{{sprintf("%02d",$i)}}'>{{sprintf("%02d",$i)}}</option>
										@endfor
											
										</select>分
										<span id="time2-error">请选择开始时间24小时后，7天之内的时间</span>
									</div>
									<div id="shangchuan" title="上传文档">
										<div class="WMain3 WMain3_2"><p><i class="LGntas">*</i>上传附件:</p>
											<input type="text" name="name2_2_2" id="name2_2_2" class="txt6" style="width:43%;" readonly />
											<button type="button" name="upload_file" id="upload_file" class="txt7" style=" width:80px;">导入</button><br/>
											<span style="margin-left: 145px;">选填，如果您的文章已编辑完成，请复制链接到此处，并点击“导入”。</span>
										</div>
									</div>
									<div class="WMain3 WMain3_1"><p><i class="LGntas"></i>备注:</p>
										<div id="xinwenbeizhu">
											<textarea type="text" name="name6" id="name6" class="txt_ft1"></textarea>
											<p>还可输入<b>500</b>个字</p>
										</div>
									</div>
									<div class="item_f item_f_2" style="margin-top:50px;margin-left:-145px;">
                                        <div class="r"><input type="submit" value="确 认" class="sub5"></div>
                                    </div>
                                    <!--<div class="clr btn_sub_w">
										<button type="submit" value="submit" class="btn_sub"><img src="{{url('console/images/WLButton.png')}}">
										</button>
									</div>-->
								</li>
							</ul>
						</div>
					</div>
					</form>
					
				</div>
			</div>
		</div>
					
	</div>
	
</div></div>



@include('console.share.admin_foot')

<script type="text/javascript">
	var id = {{$media['id']}}; 
    var limit_start = {{$page['limit_start']}};
    var page_num = {{$page['page_num']}};
	/*	百度编辑器	*/
	var ue = UE.getEditor('container');
	var _token = $('input[name="_token"]').val();
	function page_load (argument) {
		page_num_new = $("#page_nums").val();


        var category_arr = [];
        var id_arr = [];
        $('#attr_val ul[set_name="network"] a.cur').each(function(){
            id_arr.push($(this).attr('data_id'));
            category_arr.push($(this).attr('category_id'));
        })
        data_id = category_arr.toString();
        category_id = id_arr.toString();

		$.ajax({
			url: '',
			data: {
				'id':id,
				'page_num':page_num_new,
				'limit_start':limit_start,
				'category_id':category_id,
				'_token': _token
			},
			type: 'post',
			dataType: "json",
			stopAllStart: true,
			success: function (data) {
				var sum = data.data.length;
				limit_start  = data.page.limit_start;
				page_num  = data.page.page_num;
				// console.log(limit_start);
				result='';
				if (data.status == '1') {
					if (data.data.length>0) {
					//页面渲染
					for(var i=0; i< sum; i++){
						if (!data.data[i]['publish_type']) {
							data.data[i]['publish_type']='不限';
						};
						if (!data.data[i]['video_type']) {
							data.data[i]['video_type']='不限';
						};

						if (!data.data[i]['fans']) {
							data.data[i]['fans']='不限';
						};
						
						if (!data.data[i]['sex_type']) {
							data.data[i]['sex_type']='不限';
						};

						result += '<tr rst_id="'+data.data[i]['user_id']+
						'"><td class="logo-title"><img src="'+data.data[i]['media_logo']+'">' +
							data.data[i]['media_name']+'</td>'+
							'<td>'+data.data[i]['publish_type']+'</td>'+
							'<td>'+data.data[i]['video_type']+'</td>'+
							'<td>'+data.data[i]['fans']+'</td><td>'+data.data[i]['sex_type']+'</td>'+
							'<td class="color1">￥'+data.data[i]['proxy_price']+'</td><td>'+
							data.data[i]['remark']+'</td></tr>';
					}

					// $('#wrapper_i').html('');
					$('#wrapper_i').append(result);
					$('#page').html('');
					if (data.page.page_statue>0) {
						$('#page').append('<a href="javascript:void(0);" onclick="page_load()" class="more"  style="adisplay:none;">加载更多</a>');
					}
				}else{
					$('#page').html('');
					layer.msg('抱歉，暂无更多媒体');
				}
					// $('#wrapper_i').html("");
					// $('#wrapper_i').append(result);
					
				} else {
					layer.msg(data.msg || '请求失败');
				}
			},
			error: function (data) {
				layer.msg(data.msg || '网络发生错误');
			}
		});
	}
	$('#wrapper_i').on("click","tr",function(){
		// allen
		var num = parseInt($("#resource_count_select").text());
		$('#resource_count_select').html(num+1);
		$(this).addClass("choose");
		$(this).find("input[name='check_1']").prop("checked",true);		//+
		var rst_id = $(this).attr('rst_id');
		var sta='';
		$("#select_media").find('tr').each(function () {
			if($(this).attr('rst_id')==rst_id){
				$(this).remove();
				sta="1";
			}
		});
		if(sta=='1'){
			$(this).removeClass("choose");
			$(this).find("input[name='check_1']").prop("checked",false);		//+
			$('#resource_count_select').html(num-1);
		// alert(num);
			return false
		}

        var category_arr = [];
        var id_arr = [];
        $('#attr_val ul[set_name="network"] a.cur').each(function(){
            id_arr.push($(this).attr('data_id'));
            category_arr.push($(this).attr('category_id'));
        })

        category_id = id_arr.toString();

		$.ajax({
			url:'/media/get_resource',
			data: {
				'id':rst_id,
				'media_id':{{$media['id']}},
				"category_id":category_id,
				'_token':_token
			},
			type: 'post',
			dataType: "json",
			stopAllStart: true,
			success: function (data) {
				var result='';
				var _get=data.data;
				var sum = data.data.length;
				if (data.status == '1') {
					for(var i=0; i< sum; i++){
						if (!data.data[i]['platform_type']) {
							data.data[i]['platform_type']='不限';
						};
						if (!data.data[i]['video_type']) {
							data.data[i]['video_type']='不限';
						};
						if (!data.data[i]['fans']) {
							data.data[i]['fans']='不限';
						};
						if (!data.data[i]['sex_type']) {
							data.data[i]['sex_type']='不限';
						};

						result +='<tr rst_id="'+data.data[i]['user_id']+'" screen_attr_value_ids ="'+data.data[i]['screen_attr_value_ids']+'" >'+
						'<td><label class=""><input type="radio" class="choose_media" name="choose_media" value="'+data.data[i]['user_id']+'" /></label></td>'+
						'<td class="logo-title">'+'<img src="'+data.data[i]['media_logo']+'">'+
						data.data[i]['media_name']+'</td><td>'+data.data[i]['platform_type']+'</td>'+
							'<td>'+data.data[i]['video_type']+'</td><td>'+data.data[i]['fans']+
							'<td>'+data.data[i]['sex_type']+
							'</td></td><td class="color1">￥'+data.data[i]['proxy_price']+'</td>'+
							'<td><a href="#" class="del">删除</a><input type="hidden" name="screen_attr_value_ids" value="'+
							data.data[i]['screen_attr_value_ids']+'" /></td></tr>';


					}
					$('#select_media').append(result);
				} else {
					layer.msg(data.msg || '请求失败');
				}
			},
			error: function () {
				layer.msg(data.msg || '网络发生错误');
				return false;
			}
		});
		return false
	});
			 
	//点击已选媒体的x删除事件
	$("#select_media").on("click","tr td a.del",function(){
		var rst_id = $(this).closest("tr").attr("rst_id");
		$(this).closest("tr").remove();
		$("#wrapper_i tr[rst_id=" + rst_id + "]").removeClass("choose");
		$("#wrapper_i tr[rst_id=" + rst_id + "]").find("input[name='check_1']").prop("checked",false);		//+
		return false;
	});
			 
	$(".sbox_1_item .m ul li a").click(function () {
		var option = $(this).parents(".m").prev("span").attr("data");
		var value = $.trim($(this).html());
		if( typeof($(this).parent().attr("data_id")) == "undefined" ){
			var data_id = "-1";
		}else{
			var data_id = $(this).parent().attr("data_id");
		}
		var li = "<li data='" + option + "' data_id='" + data_id + "'><a href=''>" + value + "</a></li>";
		
		if( data_id == "-1" ){
			$(this).addClass("cur").parent().siblings("li").find("a").removeClass("cur");
			$(".sbox_2 .m li[data='" + option + "']").remove();
		}else{
//			if( option == "option_5" ){			//单选
			if( 1 ){			//单选
				if( $(this).hasClass("cur") ){
					$(this).removeClass("cur");
					$(this).parent().siblings("li").eq(0).find("a").addClass("cur");
					$(".sbox_2 .m li[data='" + option + "'][data_id='" + data_id + "'").remove();
				}else{
					$(this).addClass("cur").parent().siblings("li").find("a").removeClass("cur");
					$(".sbox_2 .m li[data='" + option + "']").remove();
					$(".sbox_2 .m").append(li);
				}
			}else{
				if( $(this).hasClass("cur") ){
					$(this).removeClass("cur");
					$(".sbox_2 .m li[data='" + option + "'][data_id='" + data_id + "'").remove();
					if( $(this).closest("ul").find("a.cur").length < 1 ){
						$(this).parent().siblings("li").eq(0).find("a").addClass("cur");
					}
				}else{
					$(this).addClass("cur").parent().siblings("li").eq(0).find("a").removeClass("cur");
					$(".sbox_2 .m").append(li);
				}
			}
		}
		
		var  opt = getDataArr2();
		var  key ='category_id';
		var  dt=[];
		for(var i=0;i< opt.length;i++){
			if(opt[i].data_id != ''){
				dt[i]=opt[i].data_id
			}
		}
		if(dt ==''){
			$('#wrapper_i').html($page_data2);
			/*	返回数据 分页	*/
			$page_data = $("#wrapper_i tr");
			data_len = $page_data.length;
			nums = $("#page_nums").val();
			laypage_l($("#wrapper_i"), $("#demo1"), $page_data, data_len, nums);
			return false;
		}

        var category_arr = [];
        var id_arr = [];
		page_num_new = $("#page_nums").val();
        $('#attr_val ul[set_name="network"] a.cur').each(function(){
            id_arr.push($(this).attr('data_id'));
            category_arr.push($(this).attr('category_id'));
        })
        data_id = category_arr.toString();
        category_id = id_arr.toString();
        // console.log(category_id);
        // alert(category_id);
		//请求数据，加载页面
		$.ajax({
			url: '',
			data: {
				'id':id,
				'category_id':category_id,
				'page_num':page_num_new,
				'_token': _token
			},
			type: 'post',
			dataType: "json",
			stopAllStart: true,
			success: function (data) {
				var sum = data.data.length;
				var get_data = data.data;
				limit_start  = data.page.limit_start;
				page_num  = data.page.page_num;
				result='';
				if (data.status == '1') {
					if (data.data.length>0) {

					$('#title_bbs').show();
					//页面渲染
					for(var i=0; i< sum; i++){
                        var vg=get_data[i].standard;
                        var vt=get_data[i].Entrance_form;
                        var vb=get_data[i].Entrance_level;
						console.log(get_data[i]);
                        if( !get_data[i].standard || get_data[i].standard==''){
                            vg  = "不限";
                        }else{
                            vg= get_data[i].standard;
                        }
                        if( !get_data[i].Entrance_form || get_data[i].Entrance_form==''){
                            vt = "不限";
                        }else{
                            vt= get_data[i].Entrance_form;
                        }
                        if( !get_data[i].Entrance_level || get_data[i].Entrance_level==''){
                            vb  = "不限";
                        }else{
							vb= get_data[i].Entrance_level;
                        }

						if (!data.data[i]['publish_type']) {
							data.data[i]['publish_type']='不限';
						};
						if (!data.data[i]['video_type']) {
							data.data[i]['video_type']='不限';
						};

						if (!data.data[i]['fans']) {
							data.data[i]['fans']='不限';
						};
						
						if (!data.data[i]['sex_type']) {
							data.data[i]['sex_type']='不限';
						};

						result += '<tr rst_id="'+data.data[i]['user_id']+'">' + 
							'<td>&nbsp; &nbsp; <input type="checkbox" name="check_1" value="" /></td>' + 
							'<td class="logo-title"><img src="'+data.data[i]['media_logo']+'">' +
							data.data[i]['media_name']+'</td><td>'+data.data[i]['publish_type']+'</td><td>'+
							data.data[i]['video_type']+'</td><td>'+data.data[i]['fans']+'</td><td>'+
							data.data[i]['sex_type']+'</td><td class="color1">￥'+data.data[i]['proxy_price']+'</td><td>'+
							data.data[i]['remark']+'</td></tr>';
					}

					
					$('#resource_count').html(data.resource_count);
					$('#wrapper_i').html('');
					// $('#resource_table').html("");
					$("#error_show a").remove();
					$('#wrapper_i').append(result);
				}else{
					$('#resource_count').html(0);
					$('#title_bbs').hide();
					$('#wrapper_i').html(result);
					// $('#resource_table').html("");
					$("#error_show a").remove();
					$('#resource_table').append('<a>抱歉，暂无资源</a>');
				}
					// $('#wrapper_i').html("");
					// $('#wrapper_i').append(result);
					$('#page').html('');
					if (data.page.page_statue>0) {
							// alert(43);
						$('#page').append('<a href="javascript:void(0);" onclick="page_load()" class="more"  style="adisplay:none;">加载更多</a>');
					};
					
					/*	返回数据 分页	*/
					$page_data = $("#wrapper_i tr");
					data_len = $page_data.length;
					nums = $("#page_nums").val();
					laypage_l($("#wrapper_i"), $("#demo1"), $page_data, data_len, nums);
					
				} else {
					layer.msg(data.msg || '请求失败');
				}
			},
			error: function (data) {
				layer.msg(data.msg || '网络发生错误');
			}
		});
		return false;
	});

	function getDataArr2() {
		var opt_2 = [];
		$('.sbox_1_item').each(function(key,vel){
				opt_2[key] = "";
				if( $(this).find("ul li a.cur").length <= 1 ){
					if( typeof($(this).find("ul li a.cur").parent().attr("data_id")) == "undefined" ){
						var data_id = "-1";
					}else{
						var data_id = $(this).find("ul li a.cur").parent().attr("data_id");
					}
					opt_2[key] = data_id;
				}else{
					$(this).find("ul li a.cur").each(function(key2,vel2){
						if( key2 == 0 ){
							opt_2[key] += $(this).parent().attr("data_id");
						}else{
							opt_2[key] += "," + $(this).parent().attr("data_id");
						}
					});
				}
		});
		console.log("opt_2:");
		console.log(opt_2);
		return opt_2;
		
	}
	function getDataArr() {
		var opt_1 = [];
		$(".sbox_1_item").each(function () {
			var index = $(this).index(".sbox_1_item");
			opt_1[index] = [];
			var category_id = $(this).find(".m>ul").attr("category_id");
			if ($(this).find(".m>ul").find("a.cur").parent().attr("data_id")) {
				var data_id = $(this).find(".m>ul").find("a.cur").parent().attr("data_id");
			} else {
				var data_id = "";
			}
			opt_1[index]["category_id"] = category_id;
			opt_1[index]["data_id"] = data_id;
		});
		return opt_1;

	}

	$(".sbox_2 .m").on("click", "li a", function () {
		var option = $(this).parent("li").attr("data");
		var data_id = $(this).parent("li").attr("data_id");
		var value = $.trim($(this).html());
		$(this).parent("li").remove();
//		$(".sbox_1_item span.l[data='" + option + "']").next(".m").find("ul li[data_id='" + data_id + "'] a").removeClass("cur");
		$(".sbox_1_item span.l[data='" + option + "']").next(".m").find("ul li[data_id='" + data_id + "'] a").click();
//		$(".sbox_1_item span.l[data='" + option + "']").next(".m").find("ul li:first-child a").click();
//		$(".sbox_1_item span.l[data='" + option + "']").next(".m").find("ul li:first-child a").addClass("cur");
		return false;
	});
	
	$(".sbox_1_item .r a").click(function () {
		if ($(this).attr("data") == "on") {
			$(this).attr("data", "off");
			$(this).parent().siblings(".m").find("ul").css("height", "30px");
			$(this).parents(".sbox_1_item").css("height", "52px");
		} else {
			$(this).attr("data", "on");
			$(this).parent().siblings(".m").find("ul").css("height", "auto");
			$(this).parents(".sbox_1_item").css("height", "auto");
			var height = $(this).parents(".sbox_1_item").height();
			//	console.log(height);
			$(this).parents(".sbox_1_item").find(".l").css("height", height);
		}
		return false;
	});

	/*	设置选中tr背景色	*/
	function setTrBg(){
		if($("#select_media tr").length > 1){
			$("#select_media tr").each(function(){
				var rst_id = $(this).attr("rst_id");
				if( $("#wrapper_i tr[rst_id="+rst_id+"]").length>0 ){
					$("#wrapper_i tr[rst_id="+rst_id+"]").addClass("choose");;
				}
			});
		}
	}
	
	/*	分页函数
		$id1		要分页的数据元素父元素		$("#wrapper_i")
		$id2		页码所在的容器				demo1	或	$("#demo1")
		$data		要分页的数据元素集合		$("#wrapper_i tr")
		rows		数据条数					$("#wrapper_i tr").length
		nums		每页显示条数				10
		laypage_l($("#wrapper_i"), $("#demo1"), $("#wrapper_i tr"), $("#wrapper_i tr").length, 10);
	*/
	function laypage_l($id1, $id2, $data, rows, nums){
		nums = nums || 10;
		// allen b
		// $(".sbox_3 h4 strong b").html(rows);
		// $(".sbox_2 span.r b").html(rows);
		layui.use(['laypage', 'layer'], function(){
			var laypage = layui.laypage
				,layer = layui.layer;

			var render = function(curr){
				var str = '', last = curr*nums - 1;
				last = last >= rows ? (rows - 1) : last;
				for(var i = (curr*nums - nums); i <= last; i++){
					str += $data.eq(i).prop("outerHTML");
				}
				return str;
			};
			
			laypage({
				cont: $id2
				,pages: Math.ceil(rows / nums) //得到总页数
				,jump: function(obj){
					$id1.html(render(obj.curr));
					setTrBg();
				}
			});
		});
	}

	/*	默认数据 分页	*/
	var $page_data = $("#wrapper_i tr");
	var $page_data2 = $("#wrapper_i").html();
	var data_len = $page_data.length;
	var nums = 10;
	laypage_l($("#wrapper_i"), $("#demo1"), $page_data, data_len, nums);

	// $("#page_nums").change(function(){
	// 	var nums = $(this).val();
	// 	laypage_l($("#wrapper_i"), $("#demo1"), $page_data, data_len, nums);
	// });
	
	/*	还可输入字数提示	*/
	var len_input = 100 ;
	var len_textarea = 500 ;
	$('#key_input input').keyup(function(){ 
		var txtLeng = $('#key_input input').val().length;
		if( txtLeng>len_input ){  
			$('#key_input p b').text('0'); 
			var fontsize = $('#key_input input').val().substring(0,len_input);
			$('#key_input input').val( fontsize );
		}else{
			$('#key_input p b').text(len_input-txtLeng);
		}
	});
	$('#xinwenbeizhu textarea').keyup(function(){ 
		var txtLeng = $('#xinwenbeizhu textarea').val().length;
		if( txtLeng>len_textarea ){  
			$('#xinwenbeizhu p b').text('0'); 
			var fontsize = $('#xinwenbeizhu textarea').val().substring(0,len_textarea);
			$('#xinwenbeizhu textarea').val( fontsize );
		}else{
			$('#xinwenbeizhu p b').text(len_textarea-txtLeng);
		}
	});

	/*	稿件上传	*/
	var options = {
       url : "{{url('media/upload')}}",
        url : "",
		type : "post",
		// data : { return_type : "string" },
		enctype: 'multipart/form-data',
        success : function(ret) {
			// console.log("ret1:")
			// console.log(typeof(ret))
			// console.log(ret)
			if( typeof(ret) == "string" ){	ret = JSON.parse(ret);	}
			if(ret.sta == "1"){
				layer.msg('文件上传成功');
				$('input[name="name2_2_2"]').val(ret.md5);
			}else{
				layer.msg(ret.msg);
			}
        },  
        error : function(ret){  
			layer.msg("网络错误");
			console.log(ret);
			console.log(JSON.parse(ret.responseText).msg);
        },  
		clearForm : false,
        timeout : 100000
    };
	
	$("#upload_file").click(function(){
		$("#Manuscripts").click();
	});
	
	$("#Manuscripts").change(function () {
		// alert(9);
		// $("#form1").ajaxSubmit(options);
 			//创建FormData对象
			var data = new FormData($('#form1')[0]);
			$.ajax({
				url: "{{url('media/upload')}}",
					type: 'POST',
					data: data,
					dataType: 'JSON',
					cache: false,
					processData: false,
					contentType: false
			}).done(function(ret){
				console.log(ret);
				if(ret.status == 1){
					$('input[name="name2_2_2"]').val(ret.data.file);
				}else{
					layer.msg('文件上传失败');
				}
			}); 
	});
	
	
	var now = new Date();
	var now2 = moment(now).add(24,"hours");
	if( $('#datepicker1').length>0 && typeof(picker1)!="object" ){
		var picker1 = new Pikaday({
			field: document.getElementById('datepicker1'),
			firstDay: 1,
			format: "YYYY-MM-DD",
			minDate: now,
			maxDate: new Date(moment(now).add(7,"days")),
			yearRange: [2000,2020]
		});
	}
	if( $('#datepicker2').length>0 && typeof(picker2)!="object" ){
		var picker2 = new Pikaday({
			field: document.getElementById('datepicker2'),
			firstDay: 1,
			format: "YYYY-MM-DD",
			minDate: new Date(now2),
			maxDate: new Date(moment(now).add(14,"days")),
			yearRange: [2000,2020]
		});
	}
	$('#datepicker1').val(moment().add(30,"minutes").format('YYYY-MM-DD'));
	
	/*	底部提交按钮	*/
	var form5data = [];
	$("#btn_sub").click(function(){
		form5data['id'] = [];
		$("#select_media tr[rst_id!=0]").each(function(){			//已选媒体ID 数组
			var id = $(this).attr("rst_id");
			form5data['id'].push(id);
		});
		form5data['name1'] = $("input[name=name1]").val();				//活动标题
		form5data['name2'] = $("input[name=name2]:checked").val();		//稿件内容		1 外部连接 		2 上传文档		3 内部编辑
		form5data['name2_1'] = $("input[name=name2_1]").val();			//稿件内容》外部连接
		form5data['Manuscripts'] = $("input[name=name2_2]").val();		//稿件内容》上传文档	稿件导入
		
		form5data['content'] = ue.getContent();							//稿件内容》内部编辑	内容编辑		获取编辑器的内容
			
		form5data['name3'] = $("input[name=name3]").val();				//关键字
		
		form5data['name4'] = $("input[name=name4]").val();				//开始时间
		form5data['name4'] += " " + $("select[name=name4_1]").val() + ":" + $("select[name=name4_2]").val() + ":00";
		form5data['name5'] = $("input[name=name5]").val();				//截止时间
		form5data['name5'] += " " + $("select[name=name5_1]").val() + ":" + $("select[name=name5_2]").val() + ":00";
		console.log(moment(form5data['name4']).format("YYYY-MM-DD HH:mm:ss"));
		
		form5data['name6'] = $("textarea[name=name6]").val();			//新闻备注
		if( $("input[name=agree]").is(":checked") ){				//我已经阅读并同意云媒体交易平台习家规则
			form5data['agree'] = $("input[name=agree]").val();
		}else{
			form5data['agree'] = "0";
		}
		
//		console.log("click:");
//		console.log(form5data);
	});
	
	$("input[name=agree]").change(function(){
		if( $("input[name=agree]").is(":checked") ){
			$("#btn_sub").removeClass("notagree");
		}else{
			$("#btn_sub").addClass("notagree");
		}
	});
	
$.validator.setDefaults({
	submitHandler: function() {
		console.log("表单提交");
		platform_type = $("input[name=name7]").val();
		if ($.trim(platform_type) =='') {
			flag = 1;
			layer.msg("合作形式不能为空");
			return false;

		};

		content = ue.getContent();
		sale_file = $("input[name=name2_2_2]").val();
		if ($.trim(content) == '') {
			if (!sale_file) {
				flag = 1;
				layer.msg("直播内容不能为空");
				return false;
			}
		};
		
		if ($.trim(sale_file) == '') {
			if (!content) {
				flag = 1;
				layer.msg("请上传附件");
				return false;
			}
		};

		var flag = 0;
		if( form5data['id'] == "" ){
			flag = 1;
			layer.msg("还要选择媒体哦");
			return false;
		}
		// console.log("表单提交1");
		// console.log(form5data);
		
		var key = "test1";
		var doc_type = $("input[name=name2]:checked").val();
		var mydate = new Date();
		var seconds = mydate.getSeconds();
		// if (doc_type==1) {
		// 	content = $("input[name=name2_1]").val();
		// }else if(doc_type == 2){
		// 	content = $("input[name=name2_2]").val();
		// }else{
		// 	content = ue.getContent();
		// }

		start_at = $("input[name=name4]").val()+' '+$("select[name=name4_1]").val()+':'+$("select[name=name4_2]").val()+':'+seconds;
		over_at = $("input[name=name5]").val()+' '+$("select[name=name5_1]").val()+':'+$("select[name=name5_2]").val()+':'+seconds;

        var category_arr = [];
        var id_arr = [];
        $('#attr_val ul[set_name="network"] a.cur').each(function(){
            id_arr.push($(this).attr('data_id'));
            category_arr.push($(this).attr('category_id'));
        })
        category_id = id_arr.toString();
        user_arr = [];
//        $('#select_media tr').each(function(){
        $('#select_media tr .choose_media').each(function(){
			if( $(this).is(":checked") ){
//				user_arr.push($(this).attr('rst_id'));
				user_arr.push( $(this).val() );
			}
        })
        user_ids = user_arr.toString();

  		remark = $("#name6").val();

		$.ajax({
			url: '/cart/post_cart',
            data: {
            	'id':id,
            	'category_id':category_id,
            	'media_id':{{$media['id']}},
            	'user_ids':user_ids,
                'title':$("input[name=name1]").val(),
                'cooperation_mode':platform_type,
                'doc_type':doc_type,
                'content':content,
                'cooperation_place':$("input[name=name3]").val(),
                'sale_file': sale_file,
                'start_at':start_at,
                'over_at':over_at,
                'remark':remark,
                '_token' : _token
            },
			type: 'post',
			dataType: "json",
			stopAllStart: true,
			success: function (data) {
				if (data.status == '1') {
					layer.msg(data.msg || '提交成功');
					window.location.href="/cart/cart_list"; 
				} else {
					layer.msg(data.msg || '提交失败');
				}
			},
			error: function (data) {
				console.log(data);
				layer.msg(data.msg || '网络发生错误');
				return false;
			}
		});
	}
});

	$("#form5").validate({
		// onfocusout: false,
		// onkeyup: false,
		// onclick: false,
		ignore: "",
		rules: {
			name1: { required: true, minlength: 2, maxlength: 25 }
			,name2: "required"
				,name2_1: { required: function(){ return $("input[name=name2]:checked").val() == 1 }, url: true }
				,name2_2: { required: function(){ return $("input[name=name2]:checked").val() == 2 } }
				,content: { required: function(){ return $("input[name=name2]:checked").val() == 3 } }
			,name3: { required: false, maxlength: 100 }
			,name4: { required: true, dateISO: true, comparetime1: true }
			,name5: { required: true, dateISO: true, comparetime2: true }
			,name6: { required: true, maxlength: 500 }
			,agree: "required"
		},
		errorElement: "em",
		messages: {
			name1: { required: "请输入标题", minlength: "标题不能小于两个字" }
			,name4: { required: "请选择开始时间" }
			,name5: { required: "请选择截止时间" }
			,name6: { required: "备注不能为空" }
			,agree: "先同意才能提交"
		}
	});
	
	jQuery.validator.addMethod("comparetime1", function(value, element) {
		var flag = 0;
		var time1 = $("input[name=name4]").val();				//开始时间
		var time2 = moment();									//当前时间
		time1 += " " + $("select[name=name4_1]").val() + ":" + $("select[name=name4_2]").val() + ":00";
		time3 = moment(time2).add(0,"minutes").format("YYYY-MM-DD HH:mm:ss");		//当前时间 +0分钟
		time4 = moment(time2).add(7,"days").format("YYYY-MM-DD HH:mm:ss");			//当前时间 +7天
//		if( moment(time1).isAfter(time3) && moment(time1).isBefore(time4) ){
		if( moment(time1).isBefore(time4) ){
			$("#time1-error").removeClass("time1-error");
			flag = 1;
		}else{
			$("#time1-error").addClass("time1-error");
		}
		return flag;
	}, "请选择当前时间后，7天之内的时间");
	
	jQuery.validator.addMethod("comparetime2", function(value, element) {
		var flag = 0;
		var time1 = $("input[name=name4]").val();				//开始时间
		var time2 = $("input[name=name5]").val();				//截止时间
		time1 += " " + $("select[name=name4_1]").val() + ":" + $("select[name=name4_2]").val() + ":00";
		time2 += " " + $("select[name=name5_1]").val() + ":" + $("select[name=name5_2]").val() + ":00";
		time3 = moment(time1).add(24,"hours").format("YYYY-MM-DD HH:mm:ss");		//开始时间 +24小时
		time4 = moment(time1).add(7,"days").format("YYYY-MM-DD HH:mm:ss");			//开始时间 +7天
		if( moment(time2).isAfter(time3) && moment(time2).isBefore(time4) ){
			$("#time2-error").removeClass("time2-error");
			flag = 1;
		}else{
			$("#time2-error").addClass("time2-error");
		}
		return flag;
	}, "请选择开始时间24小时后，7天之内的时间");
	
/*	将ele1定位到ele2	*/
function setOffset(ele1,ele2){
	var top = $(ele2).offset().top;
	var left = $(ele2).offset().left;
	$(ele1).show().offset({"left":left,"top":top});
	console.log(left)
	console.log(top)
}	
setOffset("#Manuscripts","#upload_file");
	
	
var hours = moment().format("HH");
var minutes = moment().format("mm");
$("[name='name4_1']").val(hours);
$("[name='name4_2']").val(minutes);
	
$(".checkall").click(function(){			//全选
	if( $(this).is(":checked") ) {
		$("#wrapper_i tr").each(function(){
			if( $(this).hasClass("choose") ){
			}else{
				$(this).click();
			}
		});
	}else{
		$("#wrapper_i tr").each(function(){
			if( $(this).hasClass("choose") ){
				$(this).click();
			}else{
			}
		});
	}
});
	
</script>
</body>
</html>
