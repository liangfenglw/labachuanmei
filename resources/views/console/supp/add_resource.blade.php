<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>媒体管理</title>
    @include('console.share.cssjs') 
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')        <!--    左弹菜单 供应商首页  -->

<div class="content"><div class="Invoice">
    @include('console.share.user_menu')
    
    <div class="place">
        <div class="place_ant"><a href="/console/index">首页</a><a href="/supp/resource" class="cur">媒体管理 </a></div>
    </div>
    
    <div class="main_o">
        
        <h3 class="title4"><strong><a href="#">媒体管理</a></strong>
            <ul class="add_resource2">
                <li class="cur"><a href="">添加{{ $plate_name }}</a></li>
            </ul>
            <!--    显示添加资源的分类名称，当查看资源详情页，添加资源的分类名称隐藏，   -->
        </h3>
        
		<form action="/supp/resource/save" method="post" enctype="multipart/form-data" onsubmit="return check_form();">
			{{ csrf_field() }}
				
			<div class="safe_1 clearfix">
				<div class="wrap_fl clearfix" style="width:35%;">
			
                        <div class="item_f"><p><i class="LGntas"></i>供应商：</p>
                            <div class="r">
                                <span> {{ $supp_name }} </span>
                            </div>
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
                            <div class="r"><input type="text" name="media_name" id="media_name" class="txt_f1" style="width:75%;"></div>
                        </div>
                        
                        <div class="item_f"><p><i class="LGntas"></i>媒体分类：</p>
                            <div class="r">
                                <select class="sel_f1" style="width:70%;" id="plate_id" name="plate_id" onchange="select_attr(this)">
                                    <option value="0">请选择</option>
                                    @foreach($child_plate as $key => $val)
                                        <option value="{{ $val['id'] }}">{{ $val['plate_name'] }}</option>
                                    @endforeach
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
                                <input type="text" name="proxy_price" id="proxy_price" class="txt_f1" style="width:55%;">
                                <span class="color1" style="padding-left:10px;">元</span>
                            </div>
                        </div>			
                </div>
                <div class="wrap_fr" style="width:47%;margin-right:2%;">
                   <div class="wrap_fr3">
                        <div class="item_f"><p><i class="LGntas"></i>负责人：</p>
                            <div class="r"><input type="text" name="media_contact" id="media_contact"  class="txt_f1" style="width:75%;" value=""></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>联系电话：</p>
                            <div class="r"><input type="text" name="contact_phone" id="contact_phone" class="txt_f1" style="width:75%;" value=""></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>电子邮箱：</p>
                            <div class="r"><input type="text" name="email" id="email" class="txt_f1" style="width:75%;"  value=""></div>
                        </div>
                        <div class="item_f">
                            <p><i class="LGntas"></i>联系QQ：</p>
                            <div class="r">
                                <input type="text" name="qq" id="qq" class="txt_f1" style="width:75%;" value=""></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>联系地址：</p>
                            <div class="r"><input type="text" name="address" id="address" class="txt_f1" style="width:75%;" value=""></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>邮编：</p>
                            <div class="r"><input type="text" name="zip_code" id="textfield" class="txt_f1" style="width:75%;" value=""></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>网站/微博：</p>
                            <div class="r"><input type="text" name="web_contact" id="web_contact" class="txt_f1" style="width:75%;"></div>
                        </div>

                    </div>
				
				</div>
				<div class="clr"></div>
                <div class="main_o clearfix" style="padding-bottom:0;width:90%;border:none;box-shadow: 0px 0px 0px #fff;">
                    <div class="sbox_1_w sbox_1_w2 sel_box" id="attr_val">
                        @foreach($child_plate as $key => $val) {{-- 新闻约稿 --}}
                            <div id="spec_show_{{ $val['id'] }}" style="display:none">
                            @foreach($val['plate_vs_attr'] as $kk => $vv)
                                <div class="sbox_1_item clearfix">
                                    <span class="l" data="option_4">
                                        <strong>{{ $vv['attr_name'] }}：</strong>
                                    </span>
                                    <div class="m">
                                        <select class="sel_f1 spec_{{ $val['id'] }}" id="" set_name="network">
                                            @foreach($vv['attr_vs_val'] as $kkk => $vvv)
                                                <option value="{{ $vv['id'] }}_{{ $vvv['id'] }}">{{ $vvv['attr_value'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="plate_tid" value="{{ $plate_tid }}">
					<input type="hidden" name="spec" id="spec" value="">
                    <div class="clearfix">
                        <div class="item_f"><p style="height:128px;line-height:128px;"><i class="LGntas"></i>媒体优势：</p>
                            <div class="r">
                                <textarea class="txt_ft1" name="remark" id="remark" style="width:70%;height:128px;" ></textarea>
                            </div>
                        </div>
						
						<div class="item_f"><p><i class="LGntas"></i>服务协议：</p>
							<div class="r">
								<div class="txt_xieyi" style="width:60%;">
								
		<h1>喇叭传媒平台服务协议</h1>
		<p>一、总则</p>
		<p>1、为使用亚媒社平台服务（下简称“本服务”），您应当阅读并遵守《亚媒社平台服务协议》（以下简称“本协议”），以及《亚媒社服务协议》、《亚媒社网站保护隐私权之声明》等内容。</p>
		<p>2、本协议系您与广州安腾网络科技有限公司（以下简称“亚媒社公司”）之间就亚媒社平台注册、登录及使用等事宜所订立的权利义务规范。</p>
		<p>3、请您仔细阅读以下全部内容，您点选“同意”键并完成注册、登录，即视为已完全同意并接受本协议，并愿受其约束；若不同意本协议的任何条款，请不要点选“同意”，也不要使用亚媒社平台的任何服务。如您是未成年人，您还应要求您的监护人仔细阅读本协议，并取得他/他们的同意。</p>
		<p>4、本协议视为《亚媒社服务协议》的补充协议，是其不可分割的组成部分，本协议与《亚媒社服务协议》不一致的，以本协议为准。</p>
		<p>……</p>

								</div>
							</div>
						</div>
						<div class="item_f"><p><i class="LGntas"></i></p>
							<div class="r radio_w">
								<label class="rd1"><input type="radio" name="agree" id="agree" class="radio_f" value="1" />同意</label>
								<label class="rd1 css_cur"><input type="radio" name="agree" checked id="agree" class="radio_f" value="2" />不同意</label>
							</div>
						</div>
						
                        <div class="item_f item_f_2" style="margin-top:20px;">
                            <div class="r"><input type="submit" value="确 认" class="sub5" style="margin-left:0;" /></div>
                        </div>
                    </div>
                </div>
			
			</div>
         
		</form>

    </div>  

</div></div>

@include('console.share.admin_foot')

<script type="text/javascript">
function select_attr(obj) {
    var ids = $(obj).val();
    $("div[id^=spec_show]").hide();
    $("#spec_show_"+ids).show();
}
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

    

	function check_form() {
        var media_logo = $("#documents_upload_button").val();
        var index_logo = $("#documents_upload_button2").val();
        var address = $("#address").val();
        var media_contact = $("#media_contact").val();
        var contact_phone = $("#contact_phone").val();
        var email = $("#email").val();
        var remark = $("#remark").val();
        var agree = $('input[name=agree]:checked').val();
        var plate_id = $("#plate_id").val();
        var sel = $(".sel_f1.spec_"+plate_id);
        var spec = new Array;
        sel.each(function(){
            spec.push($(this).val());
        });
        $("#spec").val(spec);
        if (plate_id == 0) {
			layer.msg('请选择资源类型');
			return false;
        }
        if (!media_logo) {
            layer.msg("媒体logo需要添加");
            return false;
        }
        if (!index_logo) {
            layer.msg("媒体logo需要添加");
            return false;
        }
        if (!address) {
			layer.msg("联系地址需要填写");
            return false;
        }
        if (!media_contact) {
			layer.msg("媒体负责人需要填写");
			return false;
        }
        if (!contact_phone) {
            layer.msg("联系电话需要填写");
            return false;
        }
        if (!email) {
            layer.msg("联系邮箱需要填写");
            return false;
        }

        if (agree == 2) {
            layer.msg("服务协议请同意");
            return false;
        }
        return true;
    }

    
    // $("input[name=edit_type]").click(function(){
    //     var value = $(this).val();
    //     var index = $(this).index("input[name=edit_type]");
    //     console.log(index);
    //     console.log(value);
    //     $("#body_edit_type .item_f").eq(index).css("display","block").siblings().css("display","none");     
    // });
    
    
</script>

</body>
</html>
