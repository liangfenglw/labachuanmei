<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>媒体管理_喇叭传媒</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    @include('console.share.cssjs') 
</head>
<body class="fhide">         <!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')        <!--    左弹菜单 供应商首页  -->

<div class="content"><div class="Invoice">
    @include('console.share.user_menu')
    
    <div class="place">
        <div class="place_ant"><a href="/console/index">首页</a><a href="/supp/resource" class="cur">媒体管理 </a></div>
    </div>
    <div class="main_o">
        <h3 class="title4"><strong><a href="#">媒体管理</a></strong>
           
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
                                    <img  width="50%" src="{{ $info['media_logo'] }}" id="img_upload" name="" style="cursor:pointer;float:left;margin-right:8px; width:130px; height:130px;" />
                                    <input type="file" name="ziyuan_logo" id="documents_upload_button" placeholder="未选择任何文件" accept="image/jpg,image/jpeg,image/png" class="txt6 txt6_up upfile upload_f1" style="width:130px;height:130px;display:none;opacity:0;" />
                                </div>
                                <span class="info1_f valign_m" style="height:95px;padding:0;">
                                    <i>*</i> 请点击选择图片，仅支持JPG、JPEG、GIF、PNG格式的图片文件，文件不能大于2MB。
                                </span>
                            </div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>媒体名称：</p>
                            <div class="r">
                                <span>{{ $info['media_name'] }}</span>
                            </div>
                        </div>
                        
                        <div class="item_f"><p><i class="LGntas"></i>媒体分类：</p>
                            <div class="r">
                                <span>{{ $child_plate_name }}</span>
                            </div>
                        </div>

                        <div class="item_f"><p style="padding-top:25px;"><i class="LGntas"></i>入口示意图：</p>
                            <div class="r" style="position:relative;">
<div class="img_show">
    <img src="{{ $info['index_logo'] }}" id="img_upload2" style="cursor:pointer;float:left;margin-right:8px; width:130px; height:130px;" />
    <input type="file" name="index_logo" id="documents_upload_button2" placeholder="未选择任何文件" accept="image/jpg,image/jpeg,image/png" class="txt6 txt6_up upfile upload_f1" style="width:130px;height:130px;display:none;opacity:0;" />
</div>
                                <span class="info1_f valign_m" style="height:95px;padding:0;">
                                    <i>*</i> 请点击选择图片，仅支持JPG、JPEG、GIF、PNG格式的图片文件，文件不能大于2MB。
                                </span>
                            </div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>价格：</p>
                            <div class="r">
                                <input type="text" name="proxy_price" id="proxy_price" class="txt_f1" style="width:55%;" value="{{ $info['proxy_price'] }}">
                                <span class="color1" style="padding-left:10px;">元</span>
                            </div>
                        </div>          
                </div>
                <div class="wrap_fr" style="width:47%;margin-right:2%;">
                   <div class="wrap_fr3">
                        <div class="item_f"><p><i class="LGntas"></i>负责人：</p>
                            <div class="r"><input type="text" name="media_contact" id="media_contact"  class="txt_f1" style="width:75%;" value="{{ $info['media_contact'] }}"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>联系电话：</p>
                            <div class="r"><input type="text" name="contact_phone" id="contact_phone" class="txt_f1" style="width:75%;" value="{{ $info['contact_phone'] }}"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>电子邮箱：</p>
                            <div class="r"><input type="text" name="email" id="email" class="txt_f1" style="width:75%;" value="{{ $info['email'] }}"></div>
                        </div>
                        <div class="item_f">
                            <p><i class="LGntas"></i>联系QQ：</p>
                            <div class="r">
                                <input type="text" name="qq" id="qq" class="txt_f1" style="width:75%;" value="{{ $info['qq'] }}"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>联系地址：</p>
                            <div class="r"><input type="text" name="address" id="address" class="txt_f1" style="width:75%;" value="{{ $info['address'] }}"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>邮编：</p>
                            <div class="r"><input type="text" name="zip_code" id="textfield" class="txt_f1" style="width:75%;" value="{{ $info['zip_code'] }}"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>网站/微博：</p>
                            <div class="r"><input type="text" name="web_contact" id="web_contact" class="txt_f1" style="width:75%;" value="{{ $info['web_contact'] }}"></div>
                        </div>
                    </div>
                
                </div>
                <div class="clr"></div>
                {{-- <div class="clearfix"> --}}
                <div class="main_o clearfix" style="padding-bottom:0;width:90%;border:none;box-shadow: 0px 0px 0px #fff;">
                    <div class="sbox_1_w sbox_1_w2 sel_box">
                        @foreach($spec as $key => $val)
                            <div class="sbox_1_item clearfix">
                                <span class="l" data="option_4">
                                    <strong>{{ $val['value']['attr_name'] }}：</strong>
                                </span>
                                <div class="m">
                                      {{ $val['value']['attr_value'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="spec" id="spec" value="">
                    <div class="clearfix">
                        <div class="item_f"><p style="height:128px;line-height:128px;"><i class="LGntas"></i>媒体优势：</p>
                            <div class="r">
                                <textarea class="txt_ft1" name="remark" id="remark" style="width:70%;height:128px;" >{{ $info['remark'] }}</textarea>
                            </div>
                        </div>
                        
                        <div class="item_f"><p><i class="LGntas"></i>状态：</p>
                            <div class="r">
                                <span>{{ $state_status[$info['is_state']] }}</span>
                            </div>
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
