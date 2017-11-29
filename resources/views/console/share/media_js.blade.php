<script>
	var tdata;
	var id = {{$media['id']}};
    var limit_start = {{$page['limit_start']}};
    var page_num = {{$page['page_num']}};
	console.log("id:::",id);

	//点击加载更多
	function page_load (argument) {
		page_num_new = $("#page_nums").val();			//每页显示条数
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
//			stopAllStart: true,
			success: function (data) {
				tdata = data;
				var sum = data.data.length;
				var member_price;
				limit_start  = data.page.limit_start;
				page_num  = data.page.page_num;
				// console.log(limit_start);
				result='';
				if (data.status == '1') {
					if ( sum > 0 ) {
					
						//加载更多 新闻 news
						if( id == 1 ){
							for(var i=0; i< sum; i++){
								if (!data.data[i]['web_type'] && isNaN(data.data[i]['web_type'])) {
									data.data[i]['web_type']='不限';
								}
								if (!data.data[i]['channel_type'] && isNaN(data.data[i]['channel_type'])) {
									data.data[i]['channel_type']='不限';
								}
								if (!data.data[i]['channel_level'] && isNaN(data.data[i]['channel_level'])) {
									data.data[i]['channel_level']='不限';
								}
								if (!data.data[i]['included_reference'] && isNaN(data.data[i]['included_reference'])) {
									data.data[i]['included_reference']='不限';
								}
								if (!data.data[i]['text_link'] && isNaN(data.data[i]['text_link'])) {
									data.data[i]['text_link']='不限';
								}
								if (!data.data[i]['index_logo']) {
									data.data[i]['index_logo']='';
								}else{
									data.data[i]['index_logo']='<img src="' + data.data[i]['index_logo'] + '">';
								}
								
								member_price = !data.data[i]['member_price'] ? "" : ( "￥" + data.data[i]['member_price'] );
								
								result += '<tr rst_id="' + data.data[i]['user_id'] + '">'
									+ '<td>&nbsp; &nbsp; <input type="checkbox" name="check_1" value="" /></td>'
									+ '<td class="logo-title">' + '<img src="' + data.data[i]['media_logo'] + '">' + data.data[i]['media_name'] + '</td>'
									+ '<td>' + data.data[i]['web_type'] + '</td>'
									+ '<td>' + data.data[i]['channel_type'] + '</td>'
									+ '<td>' + data.data[i]['channel_level'] + '</td>'
									+ '<td>' + data.data[i]['included_reference'] + '</td>'
									+ '<td>' + data.data[i]['text_link'] + '</td>'
									+ '<td>' + data.data[i]['index_logo'] + '</td>'
									+ '<td class="color1">￥' + data.data[i]['proxy_price'] + '</td>'
									+ '<td class="color1">' + member_price + '</td>'
									+ '<td>' + data.data[i]['remark'] + '</td>'
									+ '</tr>';
							}
						}
						
						//加载更多 视频 video
						if( id == 10 ){
							for(var i=0; i< sum; i++){
								if (!data.data[i]['publish_type']) {
									data.data[i]['publish_type']='不限';
								}
								if (!data.data[i]['video_type']) {
									data.data[i]['video_type']='不限';
								}
								if (!data.data[i]['fans']) {
									data.data[i]['fans']='不限';
								}
								if (!data.data[i]['sex_type']) {
									data.data[i]['sex_type']='不限';
								}
								
								member_price = !data.data[i]['member_price'] ? "" : ( "￥" + data.data[i]['member_price'] );

								result += '<tr rst_id="' + data.data[i]['user_id'] + '">'
									+ '<td>&nbsp; &nbsp; <input type="checkbox" name="check_1" value="" /></td>'
									+ '<td class="logo-title"><img src="' + data.data[i]['media_logo'] + '">' + data.data[i]['media_name'] + '</td>'
									+ '<td>' + data.data[i]['publish_type'] + '</td>'
									+ '<td>' + data.data[i]['video_type'] + '</td>'
									+ '<td>' + data.data[i]['fans'] + '</td>'
									+ '<td>' + data.data[i]['sex_type'] + '</td>'
									+ '<td class="color1">￥' + data.data[i]['proxy_price'] + '</td>'
									+ '<td class="color1">' + member_price + '</td>'
									+ '<td>' + data.data[i]['remark'] + '</td>'
									+ '</tr>';
							}
						}
						
						//加载更多 论坛 bbs
						if( id == 17 ){
							for(var i=0; i< sum; i++){
								if (!data.data[i]['publish_type']) {
									data.data[i]['publish_type']='不限';
								}
								if (!data.data[i]['channel_type']) {
									data.data[i]['channel_type']='不限';
								}
								if (!data.data[i]['appoint_type']) {
									data.data[i]['appoint_type']='不限';
								}
								
								member_price = !data.data[i]['member_price'] ? "" : ( "￥" + data.data[i]['member_price'] );

								result += '<tr rst_id="' + data.data[i]['user_id'] + '">'
									+ '<td>&nbsp; &nbsp; <input type="checkbox" name="check_1" value="" /></td>'
									+ '<td class="logo-title"><img src="' + data.data[i]['media_logo'] + '">' + data.data[i]['media_name'] + '</td>'
									+ '<td>' + data.data[i]['publish_type'] + '</td>'
									+ '<td>' + data.data[i]['channel_type'] + '</td>'
									+ '<td>' + data.data[i]['appoint_type'] + '</td>'
									+ '<td class="color1">￥' + data.data[i]['proxy_price'] + '</td>'
									+ '<td class="color1">' + member_price + '</td>'
									+ '<td>' + data.data[i]['remark'] + '</td>'
									+ '</tr>';
							}
						}
						
						//加载更多 微博 microblog
						if( id == 25 ){
							for(var i=0; i< sum; i++){
								if (!data.data[i]['publish_type']) {
									data.data[i]['publish_type']='不限';
								}
								if (!data.data[i]['fans']) {
									data.data[i]['fans']='不限';
								}

								member_price = !data.data[i]['member_price'] ? "" : ( "￥" + data.data[i]['member_price'] );
								
								result +='<tr rst_id="' + data.data[i]['user_id'] + '" screen_attr_value_ids ="' + data.data[i]['screen_attr_value_ids'] + '" >'
									+ '<td>&nbsp; &nbsp; <input type="checkbox" name="check_1" value="" /></td>'
									+ '<td class="logo-title">' + '<img src="' + data.data[i]['media_logo'] + '">' + data.data[i]['media_name'] + '</td>'
									+ '<td>' + data.data[i]['platform'] + '</td>'
									+ '<td>' + data.data[i]['publish_type'] + '</td>'
									+ '<td>' + data.data[i]['add'] + '</td>'
									+ '<td>' + data.data[i]['fans'] + '</td>'
									+ '<td>' + data.data[i]['cankao'] + '</td>'
									+ '<td class="color1">￥' + data.data[i]['proxy_price'] + '</td>'
									+ '<td class="color1">' + member_price + '</td>'
									+ '<td>' + data.data[i]['remark'] + '</td>'
									+ '</tr>';
							}
						}
						
						//加载更多 微信 wechat
						if( id == 36 ){
							for(var i=0; i< sum; i++){
								if (!data.data[i]['platform_type']) {
									data.data[i]['platform_type']='不限';
								}
								if (!data.data[i]['publish_type']) {
									data.data[i]['publish_type']='不限';
								}
								if (!data.data[i]['fans']) {
									data.data[i]['fans']='不限';
								}
								if (!data.data[i]['appoint_type']) {
									data.data[i]['appoint_type']='不限';
								}

								member_price = !data.data[i]['member_price'] ? "" : ( "￥" + data.data[i]['member_price'] );
								
								result += '<tr rst_id="' + data.data[i]['user_id'] + '">'
									+ '<td>&nbsp; &nbsp; <input type="checkbox" name="check_1" value="" /></td>'
									+ '<td class="logo-title"><img src="/uploads/' + data.data[i]['media_logo'] + '">' + data.data[i]['media_name'] + '</td>'
									+ '<td>' + data.data[i]['platform_type'] + '</td>'
									+ '<td>' + data.data[i]['publish_type'] + '</td>'
									+ '<td>' + data.data[i]['fans'] + '</td>'
									+ '<td>' + data.data[i]['appoint_type'] + '</td>'
									+ '<td class="color1">￥' + data.data[i]['proxy_price'] + '</td>'
									+ '<td class="color1">' + member_price + '</td>'
									+ '<td>' + data.data[i]['remark'] + '</td>'
									+ '</tr>';
							}
						}
						
						$('#wrapper_i').append(result);
						$('#page').html('');
						if (data.page.page_statue>0) {
							$('#page').append('<a href="javascript:void(0);" onclick="page_load()" class="more"  style="adisplay:none;">加载更多</a>');
						}
					}else{
						$('#page').html('');
						layer.msg('抱歉，暂无更多媒体');
					}
				} else {
					layer.msg(data.msg || '请求失败');
				}
			},
			error: function (data) {
				layer.msg(data.msg || '网络发生错误');
			}
		});
	}

	//点击媒体，加入到 已选媒体候选列表里
	$('#wrapper_i').on("click","tr",function(){
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
					
					//加入到已选媒体候选列表里 新闻 news
					if( id == 1 ){
						for(var i=0; i< sum; i++){
							if (!data.data[i]['web_type'] && isNaN(data.data[i]['web_type'])) {
								data.data[i]['web_type']='不限';
							}
							if (!data.data[i]['channel_type'] && isNaN(data.data[i]['channel_type'])) {
								data.data[i]['channel_type']='不限';
							}
							if (!data.data[i]['channel_level'] && isNaN(data.data[i]['channel_level'])) {
								data.data[i]['channel_level']='不限';
							}
							if (!data.data[i]['included_reference'] && isNaN(data.data[i]['included_reference'])) {
								data.data[i]['included_reference']='不限';
							}
							if (!data.data[i]['text_link'] && isNaN(data.data[i]['text_link'])) {
								data.data[i]['text_link']='不限';
							}
							if (!data.data[i]['index_logo']) {
								data.data[i]['index_logo']='';
							}else{
								data.data[i]['index_logo']='<img src="' + data.data[i]['index_logo'] + '">';
							}

							result +='<tr rst_id="' + data.data[i]['user_id'] + '" screen_attr_value_ids ="' + data.data[i]['screen_attr_value_ids'] + '" >'
								+ '<td><label class=""><input type="radio" class="choose_media" name="choose_media" value="' + data.data[i]['user_id'] + '" /></label></td>'
								+ '<td class="logo-title">' + '<img src="' + data.data[i]['media_logo'] + '">' + data.data[i]['media_name'] + '</td>'
								+ '<td>' + data.data[i]['web_type'] + '</td>'
								+ '<td>' + data.data[i]['channel_type'] + '</td>'
								+ '<td>' + data.data[i]['channel_level'] + '</td>'
								+ '<td>' + data.data[i]['included_reference'] + '</td>'
								+ '<td>' + data.data[i]['text_link'] + '</td>'
								+ '<td>' + data.data[i]['index_logo'] + '</td>'
								+ '<td class="color1">￥' + data.data[i]['proxy_price'] + '</td>'
								+ '<td><a href="#" class="del">删除</a><input type="hidden" name="screen_attr_value_ids" value="' + data.data[i]['screen_attr_value_ids'] + '" /></td>'
								+ '</tr>';
						}
					}
					
					//加入到已选媒体候选列表里 视频 video
					if( id == 10 ){
						for(var i=0; i< sum; i++){
							if (!data.data[i]['platform_type']) {
								data.data[i]['platform_type']='不限';
							}
							if (!data.data[i]['video_type']) {
								data.data[i]['video_type']='不限';
							}
							if (!data.data[i]['fans']) {
								data.data[i]['fans']='不限';
							}
							if (!data.data[i]['sex_type']) {
								data.data[i]['sex_type']='不限';
							}

							result += '<tr rst_id="' + data.data[i]['user_id'] + '" screen_attr_value_ids ="' + data.data[i]['screen_attr_value_ids'] + '" >'
								+ '<td><label class=""><input type="radio" class="choose_media" name="choose_media" value="' + data.data[i]['user_id'] + '" /></label></td>'
								+ '<td class="logo-title">' + '<img src="' + data.data[i]['media_logo'] + '">' + data.data[i]['media_name'] + '</td>'
								+ '<td>' + data.data[i]['platform_type'] + '</td>'
								+ '<td>' + data.data[i]['video_type'] + '</td>'
								+ '<td>' + data.data[i]['fans'] + '</td>'
								+ '<td>' + data.data[i]['sex_type'] + '</td>'
								+ '<td class="color1">￥' + data.data[i]['proxy_price'] + '</td>'
								+ '<td><a href="#" class="del">删除</a><input type="hidden" name="screen_attr_value_ids" value="' + data.data[i]['screen_attr_value_ids'] + '" /></td>'
								+ '</tr>';
						}
					}
					
					//加入到已选媒体候选列表里 论坛 bbs
					if( id == 17 ){
						for(var i=0; i< sum; i++){
							if (!data.data[i]['publish_type']) {
								data.data[i]['publish_type']='不限';
							}
							if (!data.data[i]['channel_type']) {
								data.data[i]['channel_type']='不限';
							}
							if (!data.data[i]['appoint_type']) {
								data.data[i]['appoint_type']='不限';
							}

							result += '<tr rst_id="' + data.data[i]['user_id'] + '" screen_attr_value_ids ="' + data.data[i]['screen_attr_value_ids'] + '" >'
								+ '<td><label class=""><input type="radio" class="choose_media" name="choose_media" value="' + data.data[i]['user_id'] + '" /></label></td>'
								+ '<td class="logo-title">' + '<img src="' + data.data[i]['media_logo'] + '">' + data.data[i]['media_name'] + '</td>'
								+ '<td>' + data.data[i]['publish_type'] + '</td>'
								+ '<td>' + data.data[i]['channel_type'] + '</td>'
								+ '<td>' + data.data[i]['appoint_type'] + '</td>'
								+ '<td class="color1">￥' + data.data[i]['proxy_price'] + '</td>'
								+ '<td><a href="#" class="del">删除</a><input type="hidden" name="screen_attr_value_ids" value="' + data.data[i]['screen_attr_value_ids'] + '" /></td>'
								+ '</tr>';
						}
					}
					
					//加入到已选媒体候选列表里 微博 microblog
					if( id == 25 ){
						for(var i=0; i< sum; i++){
							if (!data.data[i]['publish_type']) {
								data.data[i]['publish_type']='不限';
							}
							if (!data.data[i]['fans']) {
								data.data[i]['fans']='不限';
							}
							
							result +='<tr rst_id="' + data.data[i]['user_id'] + '" screen_attr_value_ids ="' + data.data[i]['screen_attr_value_ids'] + '" >'
								+ '<td><label class=""><input type="radio" class="choose_media" name="choose_media" value="' + data.data[i]['user_id'] + '" /></label></td>'
								+ '<td class="logo-title">' + '<img src="' + data.data[i]['media_logo'] + '">' +data.data[i]['media_name'] + '</td>'
								+ '<td>' + data.data[i]['platform'] + '</td>'
								+ '<td>' + data.data[i]['publish_type'] + '</td>'
								+ '<td>' + data.data[i]['add'] + '</td>'
								+ '<td>' + data.data[i]['fans'] + '</td>'
								+ '<td>' + data.data[i]['cankao'] + '</td>'
								+ '<td class="color1">￥' + data.data[i]['proxy_price'] + '</td>'
								+ '<td><a href="#" class="del">删除</a><input type="hidden" name="screen_attr_value_ids" value="' + data.data[i]['screen_attr_value_ids'] + '" /></td>'
								+ '</tr>';
						}
					}
					
					//加入到已选媒体候选列表里 微信 wechat
					if( id == 36 ){
						for(var i=0; i< sum; i++){
							if (!data.data[i]['platform_type']) {
								data.data[i]['platform_type']='不限';
							}
							if (!data.data[i]['publish_type']) {
								data.data[i]['publish_type']='不限';
							}
							if (!data.data[i]['fans']) {
								data.data[i]['fans']='不限';
							}
							if (!data.data[i]['appoint_type']) {
								data.data[i]['appoint_type']='不限';
							}

							result +='<tr rst_id="' + data.data[i]['user_id'] + '" screen_attr_value_ids ="' + data.data[i]['screen_attr_value_ids'] + '" >'
								+ '<td><label class=""><input type="radio" class="choose_media" name="choose_media" value="' + data.data[i]['user_id'] + '" /></label></td>'
								+ '<td class="logo-title">' + '<img src="/uploads/' + data.data[i]['media_logo'] + '">' + data.data[i]['media_name'] + '</td>'
								+ '<td>' + data.data[i]['platform_type'] + '</td>'
								+ '<td>' + data.data[i]['publish_type'] + '</td>'
								+ '<td>' + data.data[i]['fans'] + '</td>'
								+ '<td>' + data.data[i]['appoint_type'] + '</td>'
								+ '<td class="color1">￥' + data.data[i]['proxy_price'] + '</td>'
								+ '<td><a href="#" class="del">删除</a><input type="hidden" name="screen_attr_value_ids" value="' + data.data[i]['screen_attr_value_ids'] + '" /></td>'
								+ '</tr>';
						}
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
	$('#wrapper_i tr.no-data').unbind("click");

	//点击已选媒体的x删除事件
	$("#select_media").on("click","tr td a.del",function(){
		var rst_id = $(this).closest("tr").attr("rst_id");
		$(this).closest("tr").remove();
		$("#wrapper_i tr[rst_id=" + rst_id + "]").removeClass("choose");
		$("#wrapper_i tr[rst_id=" + rst_id + "]").find("input[name='check_1']").prop("checked",false);		//+
		return false;
	});
	
	//筛选媒体
	$(".sbox_1_item .m ul li a").click(function () {
		var option = $(this).parents(".m").siblings("span.l").attr("data");
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
			}else{			//多选
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
		
		//根据筛选获取数据
		ajaxGetChooseData();

		return false;
	});

	//获得筛选分类字符串
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
//		console.log("opt_2:", opt_2);
		return opt_2;
	}

	//已选择项 点击去掉选择
	$(".sbox_2 .m").on("click", "li a", function () {
		var option = $(this).parent("li").attr("data");
		var data_id = $(this).parent("li").attr("data_id");
		var value = $.trim($(this).html());
		$(this).parent("li").remove();
		$(".sbox_1_item span.l[data='" + option + "']").siblings(".m").find("ul li[data_id='" + data_id + "'] a").click();
		return false;
	});
	
	//点击更多 显示全部选项
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

	//全选
	$(".checkall").click(function(){
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

	$('#wrapper_i').on("click","tr td input",function(event){
		if( $(this).closest("tr").hasClass("choose") ) {
			$(this).prop('checked', true);		
		}else{
			$(this).prop('checked', false);
		}
	});


	//根据筛选获取数据
	function ajaxGetChooseData(){
		var choose = getDataArr2();			//选中项字符串
		var category_arr = [];
		var id_arr = [];
		page_num_new = $("#page_nums").val();
		$('#attr_val ul[set_name="network"] li a.cur').each(function(){
			id_arr.push($(this).attr('data_id'));
			category_arr.push($(this).attr('category_id'));
		})
		data_id = category_arr.toString();
		category_id = id_arr.toString();
	//	console.log("data_id:", data_id);
	//	console.log("category_id:", category_id);
		
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
	//		stopAllStart: true,
			success: function (data) {
				// $("#resource_table a").remove();
				console.log("ajax-data:", data);
				var sum = data.data.length;
				var get_data = data.data;
				var member_price;
				limit_start  = data.page.limit_start;
				page_num  = data.page.page_num;
				result='';
				if (data.status == '1') {
					if (sum>0) {
						$('#title_bbs').show();
						
						//根据筛选获取数据 新闻 news
						if( id == 1 ){
							for(var i=0; i< sum; i++){
								var vg=get_data[i].standard;
								var vt=get_data[i].Entrance_form;
								var vb=get_data[i].Entrance_level;
		//						console.log("get_data["+i+"]:", get_data[i]);
								if( !get_data[i].standard || get_data[i].standard==''){
									vg  = "不限";
								}else{
		//							vg= get_data[i].standard[0].name;
									vg= get_data[i].standard;
								}
								if( !get_data[i].Entrance_form || get_data[i].Entrance_form==''){
									vt = "不限";
								}else{
			//						vt= get_data[i].Entrance_form[0].name;
									vt= get_data[i].Entrance_form;
								}
								if( !get_data[i].Entrance_level || get_data[i].Entrance_level==''){
									vb  = "不限";
								}else{
			//						vb= get_data[i].Entrance_level[0].name;
									vb= get_data[i].Entrance_level;
								}
								if (!data.data[i]['web_type'] && isNaN(data.data[i]['web_type'])) {
									data.data[i]['web_type']='不限';
								};
								if (!data.data[i]['channel_type'] && isNaN(data.data[i]['channel_type'])) {
									data.data[i]['channel_type']='不限';
								};
								if (!data.data[i]['channel_level'] && isNaN(data.data[i]['channel_level'])) {
									data.data[i]['channel_level']='不限';
								};
								if (!data.data[i]['included_reference'] && isNaN(data.data[i]['included_reference'])) {
									data.data[i]['included_reference']='不限';
								};
								if (!data.data[i]['text_link'] && isNaN(data.data[i]['text_link'])) {
									data.data[i]['text_link']='不限';
								};
								if (!data.data[i]['index_logo']) {
									data.data[i]['index_logo']='';
								}else{
									data.data[i]['index_logo']='<img src="' + data.data[i]['index_logo'] + '">';
								}
								
								member_price = !data.data[i]['member_price'] ? "" : ( "￥" + data.data[i]['member_price'] );
								
								result += '<tr rst_id="' + data.data[i]['user_id'] + '">'
									+ '<td>&nbsp; &nbsp; <input type="checkbox" name="check_1" value="" /></td>'
									+ '<td class="logo-title"><img src="' + data.data[i]['media_logo'] + '">' + data.data[i]['media_name'] + '</td>'
									+ '<td>' + data.data[i]['web_type'] + '</td>'
									+ '<td>' + data.data[i]['channel_type'] + '</td>'
									+ '<td>' + data.data[i]['channel_level'] + '</td>'
									+ '<td>' + data.data[i]['included_reference'] + '</td>'
									+ '<td>' + data.data[i]['text_link'] + '</td>'
									+ '<td>' + data.data[i]['index_logo'] + '</td>'
									+ '<td class="color1">￥' + data.data[i]['proxy_price'] + '</td>'
									+ '<td class="color1">' + member_price + '</td>'
									+ '<td>' + data.data[i]['remark'] + '</td>'
									+ '</tr>';
							}
						}
						
						//根据筛选获取数据 视频 video
						if( id == 10 ){
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

								member_price = !data.data[i]['member_price'] ? "" : ( "￥" + data.data[i]['member_price'] );
								
								result += '<tr rst_id="' + data.data[i]['user_id'] + '">'
									+ '<td>&nbsp; &nbsp; <input type="checkbox" name="check_1" value="" /></td>'
									+ '<td class="logo-title"><img src="' + data.data[i]['media_logo'] + '">' + data.data[i]['media_name'] + '</td>'
									+ '<td>' + data.data[i]['publish_type'] + '</td>'
									+ '<td>' + data.data[i]['video_type'] + '</td>'
									+ '<td>' + data.data[i]['fans'] + '</td>'
									+ '<td>' + data.data[i]['sex_type'] + '</td>'
									+ '<td class="color1">￥' + data.data[i]['proxy_price'] + '</td>'
									+ '<td class="color1">' + member_price + '</td>'
									+ '<td>' + data.data[i]['remark'] + '</td>'
									+ '</tr>';
							}
						}
						
						//根据筛选获取数据 论坛 bbs
						if( id == 17 ){
							for(var i=0; i< sum; i++){
								var vg=get_data[i].standard;
								var vt=get_data[i].Entrance_form;
								var vb=get_data[i].Entrance_level;
								console.log(get_data[i]);
								if( !get_data[i].standard || get_data[i].standard==''){
									vg  = "不限";
								}else{
		//                            vg= get_data[i].standard[0].name;
									vg= get_data[i].standard;
								}
								if( !get_data[i].Entrance_form || get_data[i].Entrance_form==''){
									vt = "不限";
								}else{
		//							vt= get_data[i].Entrance_form[0].name;
									vt= get_data[i].Entrance_form;
								}
								if( !get_data[i].Entrance_level || get_data[i].Entrance_level==''){
									vb  = "不限";
								}else{
		//							vb= get_data[i].Entrance_level[0].name;
									vb= get_data[i].Entrance_level;
								}
								if (!data.data[i]['publish_type']) {
									data.data[i]['publish_type']='不限';
								};
								if (!data.data[i]['channel_type']) {
									data.data[i]['channel_type']='不限';
								};
								if (!data.data[i]['appoint_type']) {
									data.data[i]['appoint_type']='不限';
								};
								
								member_price = !data.data[i]['member_price'] ? "" : ( "￥" + data.data[i]['member_price'] );
								
								result += '<tr rst_id="' + data.data[i]['user_id'] + '">'
									+ '<td>&nbsp; &nbsp; <input type="checkbox" name="check_1" value="" /></td>'
									+ '<td class="logo-title"><img src="' + data.data[i]['media_logo'] + '">' + data.data[i]['media_name'] + '</td>'
									+ '<td>' + data.data[i]['publish_type'] + '</td>'
									+ '<td>' + data.data[i]['channel_type'] + '</td>'
									+ '<td>' + data.data[i]['appoint_type'] + '</td>'
									+ '<td class="color1">￥' + data.data[i]['proxy_price'] + '</td>'
									+ '<td class="color1">' + member_price + '</td>'
									+ '<td>' + data.data[i]['remark'] + '</td>'
									+ '</tr>';
							}
						}
						
						//根据筛选获取数据 微博 microblog
						if( id == 25 ){
							for(var i=0; i< sum; i++){
								var vg=get_data[i].standard;
								var vt=get_data[i].Entrance_form;
								var vb=get_data[i].Entrance_level;
								console.log(get_data[i]);
								if( !get_data[i].standard || get_data[i].standard==''){
									vg  = "不限";
								}else{
		//                            vg= get_data[i].standard[0].name;
									vg= get_data[i].standard;
								}
								if( !get_data[i].Entrance_form || get_data[i].Entrance_form==''){
									vt = "不限";
								}else{
		//							vt= get_data[i].Entrance_form[0].name;
									vt= get_data[i].Entrance_form;
								}
								if( !get_data[i].Entrance_level || get_data[i].Entrance_level==''){
									vb  = "不限";
								}else{
		//							vb= get_data[i].Entrance_level[0].name;
									vb= get_data[i].Entrance_level;
								}
								if (!data.data[i]['publish_type']) {
									data.data[i]['publish_type']='不限';
								};
								if (!data.data[i]['fans']) {
									data.data[i]['fans']='不限';
								};

								member_price = !data.data[i]['member_price'] ? "" : ( "￥" + data.data[i]['member_price'] );
								
								result +='<tr rst_id="' + data.data[i]['user_id'] + '" screen_attr_value_ids ="' + data.data[i]['screen_attr_value_ids'] + '" >'
									+ '<td>&nbsp; &nbsp; <input type="checkbox" name="check_1" value="" /></td>'
									+ '<td class="logo-title">' + '<img src="' + data.data[i]['media_logo'] + '">' +data.data[i]['media_name'] + '</td>'
									+ '<td>' + data.data[i]['platform'] + '</td>'
									+ '<td>' + data.data[i]['publish_type'] + '</td>'
									+ '<td>' + data.data[i]['add'] + '</td>'
									+ '<td>' + data.data[i]['fans'] + '</td>'
									+ '<td>' + data.data[i]['cankao'] + '</td>'
									+ '<td class="color1">￥' + data.data[i]['proxy_price'] + '</td>'
									+ '<td class="color1">' + member_price + '</td>'
									+ '<td>' + data.data[i]['remark'] + '</td>'
									+ '</tr>';
							}
						}
						
						//根据筛选获取数据 微信 wechat
						if( id == 36 ){
							for(var i=0; i< sum; i++){
								var vg=get_data[i].standard;
								var vt=get_data[i].Entrance_form;
								var vb=get_data[i].Entrance_level;
								console.log(get_data[i]);
								if( !get_data[i].standard || get_data[i].standard==''){
									vg  = "不限";
								}else{
		//                            vg= get_data[i].standard[0].name;
									vg= get_data[i].standard;
								}
								if( !get_data[i].Entrance_form || get_data[i].Entrance_form==''){
									vt = "不限";
								}else{
		//							vt= get_data[i].Entrance_form[0].name;
									vt= get_data[i].Entrance_form;
								}
								if( !get_data[i].Entrance_level || get_data[i].Entrance_level==''){
									vb  = "不限";
								}else{
		//							vb= get_data[i].Entrance_level[0].name;
									vb= get_data[i].Entrance_level;
								}
								if (!data.data[i]['platform_type']) {
									data.data[i]['platform_type']='不限';
								};
								if (!data.data[i]['publish_type']) {
									data.data[i]['publish_type']='不限';
								};
								if (!data.data[i]['fans']) {
									data.data[i]['fans']='不限';
								};
								if (!data.data[i]['appoint_type']) {
									data.data[i]['appoint_type']='不限';
								};
								
								member_price = !data.data[i]['member_price'] ? "" : ( "￥" + data.data[i]['member_price'] );

								result += '<tr rst_id="' + data.data[i]['user_id'] + '">'
									+ '<td>&nbsp; &nbsp; <input type="checkbox" name="check_1" value="" /></td>'
									+ '<td class="logo-title"><img src="' + data.data[i]['media_logo'] + '">' + data.data[i]['media_name'] + '</td>'
									+ '<td>' + data.data[i]['platform_type'] + '</td>'
									+ '<td>' + data.data[i]['publish_type'] + '</td>'
									+ '<td>' + data.data[i]['fans'] + '</td>'
									+ '<td>' + data.data[i]['appoint_type'] + '</td>'
									+ '<td class="color1">￥' + data.data[i]['proxy_price'] + '</td>'
									+ '<td class="color1">' + member_price + '</td>'
									+ '<td>' + data.data[i]['remark'] + '</td>'
									+ '</tr>';
							}
						}


						$('#resource_count').html(' ' + data.resource_count+ ' ');
						$('#wrapper_i').html('');
						$("#error_show a").remove();
						$('#wrapper_i').append(result);
					}else{
						$('#resource_count').html(' 0 ');
						$('#title_bbs').hide();
						$('#wrapper_i').html(result);
						$("#error_show a").remove();
						$('#resource_table').append('<a>抱歉，暂无资源</a>');
					}
					$('#page').html('');
					if (data.page.page_statue>0) {
						$('#page').append('<a href="javascript:void(0);" onclick="page_load()" class="more">加载更多</a>');
					}

				} else {
					layer.msg(data.msg || '请求失败');
				}
			},
			error: function (data) {
				layer.msg(data.msg || '网络发生错误');
			}
		});
		
	}

	//页数改变更新数据
	$("#page_nums").change(function(){
		ajaxGetChooseData();
	});
	
	@if(!empty(Request::input('user_id')))
	$(function(){
		ajaxGetChooseData();
	});
	@endif



</script>