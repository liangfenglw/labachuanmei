<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('console.share.cssjs')
    <title>用户信息_喇叭传媒</title>
</head>
<body class="fold">
@include('console.share.admin_head')
@include('console.share.admin_menu')
<div class="content"><div class="Invoice">
    @include('console.share.user_menu')
    <div class="place">
         <div class="place_ant"><a href="/console/index">首页</a><a href="/supp/supp_edit" class="cur">用户信息 </a></div>
    </div>
    <div class="main_o clearfix" style="padding-bottom:20px;">
        <h3 class="title4 clearfix"><strong><a>用户资料</a></strong></h3>
        <form action="/supp/updateInfo" method="post" enctype="multipart/form-data" id="user_form" onsubmit="return sub_form();">
            {{ csrf_field() }}
            <div class="safe_1 clearfix">
                <div class="wrap_fl clearfix" style="width:35%;">   
                        <div class="item_f"><p><i class="LGntas"></i>用户名：</p>
                            <div class="r"><input type="text" name="name" id="textfield" value="{{ $info['supp_user']['name'] }}" class="txt_f1" style="width:75%;" disabled="disabled"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>供应商名称：</p>
                            <div class="r"><input type="text" name="media_name" value="{{ $info['supp_user']['media_name'] }}" id="textfield" class="txt_f1" disabled="disabled" style="width:75%;"></div>
                        </div>
                        <div class="item_f"><p style="padding-top:25px;"><i class="LGntas"></i>供应商LOGO：</p>
                            <div class="r" style="position:relative;">
<div class="img_show">
	<img  width="50%" src="{{ $info['supp_user']['media_logo'] }}" id="img_upload" name="" style="cursor:pointer;float:left;margin-right:8px; width:130px; height:130px;" />
	<input type="file" name="media_logo" id="documents_upload_button" placeholder="未选择任何文件" accept="image/jpg,image/jpeg,image/png" class="txt6 txt6_up upfile upload_f1" style="width:130px;height:130px;display:none;opacity:0;" />
</div>
                                
                                <span class="info1_f valign_m" style="height:95px;padding:0;">
                                    <i>*</i> 请点击选择图片，仅支持JPG、JPEG、GIF、PNG格式的图片文件，文件不能大于2MB。
                                </span>
                            </div>
                        </div>
                        <div class="item_f"><p style="padding-top:25px;"><i class="LGntas"></i>入口示意图：</p>
                            <div class="r" style="position:relative;">
<div class="img_show">
	<img src="{{ $info['supp_user']['index_logo'] }}" id="img_upload2" style="cursor:pointer;float:left;margin-right:8px; width:130px; height:130px;" />
	<input type="file" name="index_logo" id="documents_upload_button2" placeholder="未选择任何文件" accept="image/jpg,image/jpeg,image/png" class="txt6 txt6_up upfile upload_f1" style="width:130px;height:130px;display:none;opacity:0;" />
</div>
                                
                                
                                <span class="info1_f valign_m" style="height:95px;padding:0;">
                                    <i>*</i> 请点击选择图片，仅支持JPG、JPEG、GIF、PNG格式的图片文件，文件不能大于2MB。
                                </span>
                            </div>
                        </div>
                        {{-- <div class="item_f"><p><i class="LGntas"></i>价格：</p>
                            <div class="r">
                                <input disabled="disabled" type="text" name="proxy_price" id="textfield" value="{{ $info['supp_user']['proxy_price'] }}"class="txt_f1" style="width:55%;"><span class="color1" style="padding-left:10px;">元</span>
                            </div>
                        </div> --}}
                </div>
                
                <div class="wrap_fr" style="width:47%;margin-right:2%;">
                    <div class="wrap_fr3">
                        <div class="item_f"><p><i class="LGntas"></i>负责人：</p>
                            <div class="r"><input type="text" name="media_contact" id="textfield" class="txt_f1" style="width:75%;" value="{{ $info['supp_user']['media_contact'] }}"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>联系电话：</p>
                            <div class="r"><input type="text" name="contact_phone" id="textfield" class="txt_f1" style="width:75%;" value="{{ $info['supp_user']['contact_phone'] }}"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>电子邮箱：</p>
                            <div class="r"><input type="text" name="email" id="textfield" class="txt_f1" style="width:75%;"  value="{{ $info['supp_user']['email'] }}"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>联系QQ：</p>
                            <div class="r"><input type="text" name="qq" id="textfield" class="txt_f1" style="width:75%;" value="{{ $info['supp_user']['qq'] }}"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>联系地址：</p>
                            <div class="r"><input type="text" name="address" id="textfield" class="txt_f1" style="width:75%;" value="{{ $info['supp_user']['address'] }}"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>邮编：</p>
                            <div class="r"><input type="text" name="zip_code" id="textfield" class="txt_f1" style="width:75%;" value="{{ $info['supp_user']['zip_code'] }}"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>供应商认证：</p>
                            <div class="r">
                                <select class="sel_f1" style="width:70%;" disabled="disabled" name="media_check">
                                    <option value="1">供应商认证</option>
                                </select>
                            </div>
                        </div>
                        <div class="item_f"><p style="padding-top:25px;"><i class="LGntas"></i></p>
                            <div class="r" style="position:relative;">
<div class="img_show">
	<img src="{{ $info['supp_user']['media_check_file'] }}" id="img_upload3" style="cursor:pointer;float:left;margin-right:8px; width:130px; height:130px;" />
	<input type="file" name="media_check_file" id="documents_upload_button3" placeholder="未选择任何文件" accept="image/jpg,image/jpeg,image/png" class="txt6 txt6_up upfile upload_f1" style="width:130px;height:130px;display:none;opacity:0;" />
</div>
                                
                                
                                <span class="info1_f valign_m" style="height:95px;padding:0;">
                                    <i>*</i> 请点击选择图片，仅支持JPG、JPEG、GIF、PNG格式的图片文件，文件不能大于2MB。
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clr"></div>
                <div class="main_o clearfix" style="padding-bottom:0;width:90%;border:none;box-shadow: 0px 0px 0px #fff;">
                    <div class="clearfix">
                        <div class="item_f"><p><i class="LGntas"></i>供应商简介：</p>
                            <div class="r">
                                <textarea class="txt_ft1"  name="breif" style="width:70%;height:128px;" >{{ $info['supp_user']['breif'] }}</textarea>
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
    </div>
</div>
@include('console.share.admin_foot')
<script>
/*  日历  */
    if( $('#datepicker1').length>0 && typeof(picker1)!="object" ){
        var picker1 = new Pikaday({
            field: document.getElementById('datepicker1'),
            firstDay: 1,
            format: "YYYY-MM-DD",
            minDate: new Date('2000-01-01'),
            maxDate: new Date('2020-12-31'),
            yearRange: [2000,2020]
        });
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
    function sub_form() {
        //表单检验
        var name = $("#user_form").find("input[name='name']").val();
        var media_contact = $("#user_form").find("input[name='media_contact']").val();
        var contact_phone = $("#user_form").find("input[name='contact_phone']").val();
        var qq = $("#user_form").find("input[name='qq']").val();
        var email = $("user_form").find("input[name='email']").val();
        if (!is_mobile(contact_phone)) {
            layer.msg('请输入正确的手机号码');
            return false;
        }
        if (!trim(media_contact)) {
            layer.msg('请填写媒体负责人');
            return false;
        }
        if (!trim(qq)) {
            layer.msg('请填写联系QQ');
            return false;
        }
        if (!trim(email)) {
            layer.msg('请填写联系邮箱');
            return false;
        }
        return true;
    }
    function is_mobile(Tel) {
        var re = new RegExp(/^((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)$/);
        var retu = Tel.match(re);
        if (retu) {
            return true;
        } else {
            return false;
        }
    }

</script>

</body>
</html>
