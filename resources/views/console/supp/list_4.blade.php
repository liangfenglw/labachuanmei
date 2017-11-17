<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<title>媒体详情页_喇叭传媒</title>
        @include('console.share.cssjs')
    </head>
 <style>
.tab2 ul li a {
    font-size: 24px;
    color: #2f4050;
}

.list_3{		}
.list_3 ul{		margin-left:8%;	padding:25px 0;	}
.list_3 ul li{		float:left;	width:300px;	font-size:16px;	line-height:36px;	}
.list_3 ul li strong{	font-weight:400;	}
.list_3 ul li span{		}

</style>

<body class="fold">
@include('console.share.admin_head')
@include('console.share.admin_menu')
<div class="content"><div class="Invoice">
    
	<div class="place">
        <div class="place_ant"><a href="/console/index">首页</a> <a class="cur">媒体管理</a> </div>
        
    </div>
	
    <div class="main_o clearfix" style="padding-bottom:20px;">
		<h3 class="title4 clearfix"><strong><a>媒体详情</a></strong></h3>
			
        <form action="/supp/updateInfo" method="post" enctype="multipart/form-data" id="user_form" onsubmit="return sub_form();">
            {{ csrf_field() }}
            <div class="safe_1 clearfix">
                <div class="wrap_fl clearfix" style="width:35%;">
				
                        <div class="item_f"><p><i class="LGntas"></i>供应商：</p>
                            <div class="r"><input type="text" name="belong" value="" id="textfield" class="txt_f1" style="width:75%;" ></div>
                        </div>
						
                        <div class="item_f"><p style="padding-top:25px;"><i class="LGntas"></i>媒体LOGO：</p>
                            <div class="r" style="position:relative;">
<div class="img_show">
	<img  width="50%" src="/console/images/z_add2.png" id="img_upload" name="" style="cursor:pointer;float:left;margin-right:8px; width:130px; height:130px;" />
	<input type="file" name="ziyuan_logo" id="documents_upload_button" placeholder="未选择任何文件" accept="image/jpg,image/jpeg,image/png" class="txt6 txt6_up upfile upload_f1" style="width:130px;height:130px;display:none;opacity:0;" />
</div>
                                <span class="info1_f valign_m" style="height:95px;padding:0;">
                                    <i>*</i> 请点击选择图片，仅支持JPG、JPEG、GIF、PNG格式的图片文件，文件不能大于2MB。
                                </span>
                            </div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>媒体名称：</p>
                            <div class="r"><input type="text" name="ziyuan_name" value="" id="textfield" class="txt_f1"  style="width:75%;"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>媒体类型：</p>
                            <div class="r">
                                <select class="sel_f1" style="width:70%;"  name="plate_tid" id="plate_tid" onchange="select_child(this);">
                                    <option value="0">请选择</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                </select>
                            </div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>媒体分类：</p>
                            <div class="r">
                                <select class="sel_f1" style="width:70%;"  id="child_class" name="plate_id" onchange="select_attr(this)">
                                    <option value="0">请选择</option>
                                </select>
                            </div>
                        </div>

                        <div class="item_f"><p style="padding-top:25px;"><i class="LGntas"></i>入口示意图：</p>
                            <div class="r" style="position:relative;">
<div class="img_show">
	<img src="/console/images/z_add2.png" id="img_upload2" style="cursor:pointer;float:left;margin-right:8px; width:130px; height:130px;" />
	<input type="file" name="index_logo" id="documents_upload_button2" placeholder="未选择任何文件" accept="image/jpg,image/jpeg,image/png" class="txt6 txt6_up upfile upload_f1" style="width:130px;height:130px;display:none;opacity:0;" />
</div>
                                <span class="info1_f valign_m" style="height:95px;padding:0;">
                                    <i>*</i> 请点击选择图片，仅支持JPG、JPEG、GIF、PNG格式的图片文件，文件不能大于2MB。
                                </span>
                            </div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>价格：</p>
                            <div class="r">
                                <input  type="text" name="proxy_price" id="textfield" value=""class="txt_f1" style="width:40%;"><span class="color1" style="padding-left:10px;">元</span>
                            </div>
                        </div>
                         <!--自营资源详情显示-->
                        <div class="item_f"><p><i class="LGntas"></i>会员价率：</p>
                            <div class="r">
                               <input type="text" name="vip_rate" id="vip_price" value=""class="txt_f1" style="width:40%;"><span class="color1" style="padding-left:10px;">%</span>
                            </div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>平台价率：</p>
                            <div class="r">
                                <input type="text" name="plate_rate" id="plate_price" value=""class="txt_f1" style="width:40%;"><span class="color1" style="padding-left:10px;">%</span>
                            </div>
                        </div> <!--自营资源详情显示-->
                </div>
                
                <div class="wrap_fr" style="width:47%;margin-right:2%;">
                    <div class="wrap_fr3">
					
                        <div class="item_f"><p><i class="LGntas"></i>负责人：</p>
                            <div class="r"><input type="text" name="ziyuan_contact" id="textfield" class="txt_f1" style="width:75%;" value=""></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>联系电话：</p>
                            <div class="r"><input type="text" name="contact_phone" id="textfield" class="txt_f1" style="width:75%;" value=""></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>电子邮箱：</p>
                            <div class="r"><input type="text" name="email" id="textfield" class="txt_f1" style="width:75%;"  value=""></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>联系QQ：</p>
                            <div class="r"><input type="text" name="qq" id="textfield" class="txt_f1" style="width:75%;" value=""></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>联系地址：</p>
                            <div class="r"><input type="text" name="address" id="textfield" class="txt_f1" style="width:75%;" value=""></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>邮编：</p>
                            <div class="r"><input type="text" name="zip_code" id="textfield" class="txt_f1" style="width:75%;" value=""></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>网站/微博：</p>
                            <div class="r"><input type="text" name="" id="textfield" class="txt_f1" style="width:75%;" value=""></div>
                        </div>
                        <!--自营资源详情显示-->
                        <div class="item_f"><p><i class="LGntas"></i></p></div>
                        <div class="item_f"><p><i class="LGntas"></i></p></div>
                        <div class="item_f"><p><i class="LGntas"></i>会员价：</p>
                            <div class="r">
                                <input type="text" name="vip_price" id="vips_price" value=""class="txt_f1" style="width:40%;"><span class="color1" style="padding-left:10px;">元</span>
                            </div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>平台价：</p>
                            <div class="r">
                                <input type="text" name="plate_price" id="plates_price" value=""class="txt_f1" style="width:40%;"><span class="color1" style="padding-left:10px;">元</span>
                            </div>
                        </div> <!--自营资源详情显示-->
                    </div>
                </div>
                <div class="clr"></div>
				
                <div class="main_o clearfix" style="padding-bottom:0;width:90%;border:none;box-shadow: 0px 0px 0px #fff;">
				
					<div class="sbox_1_w sbox_1_w2 sel_box" id="attr_val" style="">

						<div class="sbox_1_item clearfix">
							<span class="l" data="option_4" style="">
								<strong>网站类型：</strong>
							</span>
							<div class="m">
								<select class="sel_f1" category_id="0" set_name="network">
									<option value="0">不限</option>
									<option value="1">全国门户</option>
									<option value="7">垂直行业</option>
									<option value="16">地方门户</option>
								</select>
							</div>
						</div>
						
						<div class="sbox_1_item clearfix">
							<span class="l" data="option_4" style="">
								<strong>入口形式：</strong>
							</span>
							<div class="m">
								<select class="sel_f1" category_id="0" set_name="Entrance_form">
									<option value="0">不限</option>
									<option value="3">文字标题</option>
									<option value="4">焦点图片</option>
									<option value="5">图文混排</option>
								</select>
							</div>
						</div>
						
						<div class="sbox_1_item clearfix">
							<span class="l" data="option_4" style="">
								<strong>入口级别：</strong>
							</span>
							<div class="m">
								<select class="sel_f1" category_id="1" set_name="Entrance_level">
									<option value="0">不限</option>
									<option value="2">网站首页</option>
									<option value="9">频道首页</option>
									<option value="10">二级频道首页</option>
									<option value="12">三级频道首页</option>
								</select>
							</div>
						</div>
						
						<div class="sbox_1_item clearfix">
							<span class="l" data="option_4" style="">
								<strong>覆盖区域：</strong>
							</span>
							<div class="m">
								<select class="sel_f1" category_id="0" set_name="coverage">
									<option value="0">不限</option>
									<option value="1">北京市</option>
									<option value="20">天津市</option>
									<option value="39">河北省</option>
									<option value="233">山西省</option>
									<option value="375">内蒙古自治区</option>
									<option value="499">辽宁省</option>
									<option value="628">吉林省</option>
									<option value="706">黑龙江省</option>
									<option value="860">上海市</option>
									<option value="880">江苏省</option>
									<option value="1006">浙江省</option>
									<option value="1119">安徽省</option>
									<option value="1257">福建省</option>
									<option value="1361">江西省</option>
									<option value="1484">山东省</option>
									<option value="1656">河南省</option>
									<option value="1851">湖北省</option>
									<option value="1981">湖南省</option>
									<option value="2131">广东省</option>
									<option value="2292">广西壮族自治区</option>
									<option value="2431">海南省</option>
									<option value="2462">重庆市</option>
									<option value="2503">四川省</option>
									<option value="2726">贵州省</option>
									<option value="2829">云南省</option>
									<option value="2983">西藏自治区</option>
									<option value="3066">陕西省</option>
									<option value="3194">甘肃省</option>
									<option value="3307">青海省</option>
									<option value="3360">宁夏回族自治区</option>
									<option value="3393">新疆维吾尔自治区</option>
									<option value="3510">台湾省</option>
									<option value="3511">香港特别行政区</option>
									<option value="3512">澳门特别行政区</option>
								</select>
							</div>
						</div>
						
						<div class="sbox_1_item clearfix">
							<span class="l" data="option_4" style="">
								<strong>频道类型：</strong>
							</span>
							<div class="m">
								<select class="sel_f1" category_id="0" set_name="channel">
									<option value="0">不限</option>
									<option value="13">新闻</option>
									<option value="14">财经</option>
								</select>
							</div>
						</div>
						
						<div class="sbox_1_item clearfix">
							<span class="l" data="option_4" style="">
								<strong>正文带链接：</strong>
							</span>
							<div class="m">
								<select class="sel_f1" category_id="0" set_name="standard">
									<option value="0">不限</option>
									<option value="23">不能带图片</option>
									<option value="24">不能带二维码</option>
									<option value="25">不能带链接</option>
								</select>
							</div>
						</div>
						
						<div class="sbox_1_item clearfix">
							<span class="l" data="option_4" style="">
								<strong>收录参考：</strong>
							</span>
							<div class="m">
								<select class="sel_f1" category_id="0" set_name="standard">
									<option value="0">不限</option>
									<option value="23">新闻源</option>
									<option value="24">网页收录</option>
								</select>
							</div>
						</div>
						
                    </div>
					
                    <div class="clearfix">
                        <div class="item_f"><p style="height:128px;line-height:128px;"><i class="LGntas"></i>媒体优势：</p>
                            <div class="r">
                                <textarea class="txt_ft1"  name="" style="width:70%;height:128px;" ></textarea>
                            </div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>状态：</p>
                            <div class="r radio_w">
                                <label class="rd1 css_cur"><input type="radio" name="is_state" class="radio_f" value="1" checked />在线</label>
                                <label class="rd1"><input type="radio" name="is_state" class="radio_f" value="2" />下架</label>
                                <label class="rd1"><input type="radio" name="is_state" class="radio_f" value="3" />审核</label>
                            </div>
                        </div>
                       
                        <div class="item_f item_f_2" style="margin-top:20px;">
                            <div class="r"><input type="submit" value="确 认" class="sub5" style="margin-left:0;" /></div>
                        </div>
                    </div>
                </div>  
            </div>
            <input type="hidden" name="category_id" id="category_id" value="">
            <input type="hidden" name="data_id" id="data_id" value="">
        </form>
		
	</div>
	


</div></div>
@include('console.share.admin_foot')
<script>

    // $(".sbox_1_item .m ul li a").click(function () {
    $('body').on('click','.sbox_1_item .m ul li a',function(){
        var data_id = $(this).parent().attr("data_id");
        if( data_id == "0" ){
            $(this).addClass("cur").parent().siblings("li").find("a").removeClass("cur");
        }else{
            if( $(this).hasClass("cur") ){
                $(this).removeClass("cur");
                if( $(this).closest("ul").find("a.cur").length < 1 ){
                    $(this).parent().siblings("li").eq(0).find("a").addClass("cur");
                }
            }else{
                $(this).addClass("cur").parent().siblings("li").eq(0).find("a").removeClass("cur");
            }
        }
        return false;
    });

    function sub_form() {
        var category_arr = [];
        var id_arr = [];
        $('#attr_val ul[set_name="network"] a.cur').each(function(){
            id_arr.push($(this).attr('data_id'));
            category_arr.push($(this).attr('category_id'));
        })
        $("#data_id").val(category_arr.toString());
        $("#category_id").val(id_arr.toString());
        //表单校验
        if (!$("#supp_name").val()) {
            layer.msg("用户名必须填写");
            return false;
        }
        if ($("#plate_tid").val() == 0) {
            layer.msg("请选择媒体类型");
            return false;
        }
        if ($("#child_class").val() == 0) {
            layer.msg("请选择媒体分类");
            return false;
        }
        if (!$("#media_name").val()) {
            layer.msg("媒体名称必须填写");
            return false;
        }

        if (!$("#documents_upload_button2").val() && !$("#img_upload2").attr('src')) {
            layer.msg("入口示意图必须添加");
            return false;
        }
        if (!$("#documents_upload_button3").val() && !$("#img_upload3").attr('src')) {
            layer.msg("媒体认证图必须添加");
            return false;
        }
/*
        if (!$("#proxy_price").val()) {
            layer.msg("代理价必须填写");
            return false;
        }
*/
        if (!$("#media_contact").val()) {
            layer.msg("媒体负责人必须填写");
            return false;
        }
        if (!$("#contact_phone").val()) {
            layer.msg("联系电话必须填写");
            return false;
        }
        if (!$("#email").val()) {
            layer.msg("邮箱必须填写");
            return false;
        }
        if (!$("#qq").val()) {
            layer.msg("qq必须填写");
            return false;
        }
        if (!$("#address").val()) {
            layer.msg("地址必须填写");
            return false;
        }
        if (!$("#zip_code").val()) {
            layer.msg("邮编必须填写");
            return false;
        }
        if (!$("#category_id").val()) {
            layer.msg("媒体属性信息必须选择，将不可再更改");
            return false;
        }
        return true;
    }	
	
</script>

</body>
</html>
