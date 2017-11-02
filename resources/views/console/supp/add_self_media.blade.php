<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>媒体详情页</title>
        @include('console.share.cssjs')
    </head>
 <style>
.tab2 ul li a {
    font-size: 24px;
    color: #2f4050;
}
.list_3{        }
.list_3 ul{     margin-left:8%; padding:25px 0; }
.list_3 ul li{      float:left; width:300px;    font-size:16px; line-height:36px;   }
.list_3 ul li strong{   font-weight:400;    }
.list_3 ul li span{     }

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
            
        <form action="/usermanager/saveSelfMedia" method="post" enctype="multipart/form-data" id="user_form" onsubmit="return sub_form();">
            {{ csrf_field() }}
            <div class="safe_1 clearfix">
                <div class="wrap_fl clearfix" style="width:35%;">
                <!-- <div class="item_f"><p><i class="LGntas"></i>供应商：</p>
                    <div class="r">
                        <input type="text" name="belong" id="belong" onblur="checkUser(this);" class="txt_f1" style="width:75%;" >
                    </div>

                </div> -->
                <div class="item_f"><p><i class="LGntas"></i>媒体名称：</p>
                    <div class="r"><input type="text" name="media_name" id="media_name" class="txt_f1"  style="width:75%;"></div>
                </div>
                <div class="item_f"><p style="padding-top:25px;"><i class="LGntas"></i>媒体LOGO：</p>
                    <div class="r" style="position:relative;">
                        <div class="img_show">
                            <img width="50%" src="/console/images/z_add2.png" id="img_upload" style="cursor:pointer;float:left;margin-right:8px; width:130px; height:130px;" />
                            <input type="file" name="media_logo" id="documents_upload_button" placeholder="未选择任何文件" accept="image/jpg,image/jpeg,image/png" class="txt6 txt6_up upfile upload_f1" style="width:130px;height:130px;display:none;opacity:0;" />
                        </div>
                        <span class="info1_f valign_m" style="height:95px;padding:0;">
                            <i>*</i> 请点击选择图片，仅支持JPG、JPEG、GIF、PNG格式的图片文件，文件不能大于2MB。
                        </span>
                    </div>
                </div>
            
            <div class="item_f"><p><i class="LGntas"></i>媒体类型：</p>
                <div class="r">
                    <select class="sel_f1" style="width:70%;" id="plate_tid" name="plate_tid" onchange="select_media(this)">
                        <option value="0">请选择</option>
                        @foreach($plate_list as $key => $val)
                            <option value="{{ $val['id'] }}">{{ $val['plate_name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="item_f"><p><i class="LGntas"></i>媒体分类：</p>
                <div class="r">
                    @foreach($plate_list as $key => $media)
                        <select class="sel_f1 media" id="media_{{ $media['id'] }}" name="plate_id[{{ $media['id'] }}]" onchange="select_attr(this)" @if($key > 0) style="display: none;width: 70%" @else style="width: 70%" @endif>
                            <option value="0">请选择</option>
                            @foreach($media['child_plate'] as $kk => $media_v)
                                <option value="{{ $media_v['id'] }}">{{ $media_v['plate_name'] }}</option>
                            @endforeach
                        </select>
                    @endforeach
                    
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
                    <input  type="text" name="proxy_price" id="proxy_price" value=""class="txt_f1" style="width:40%;"><span class="color1" style="padding-left:10px;">元</span>
                </div>
            </div>
            <!--自营资源详情显示-->
            <div class="item_f"><p><i class="LGntas"></i>会员价率：</p>
                <div class="r">
                   <input type="text" name="vip_rate" id="vip_price" onkeyup="setPrice();" class="txt_f1" style="width:40%;"><span class="color1" style="padding-left:10px;">%</span>
                </div>
            </div>
            <div class="item_f"><p><i class="LGntas"></i>平台价率：</p>
                <div class="r">
                    <input type="text" name="plate_rate" id="plate_price" onkeyup="setPrice();" class="txt_f1" style="width:40%;"><span class="color1" style="padding-left:10px;">%</span>
                </div>
            </div> <!--自营资源详情显示-->
        </div>
                
        <div class="wrap_fr" style="width:47%;margin-right:2%;">
            <div class="wrap_fr3">
                <div class="item_f"><p><i class="LGntas"></i>负责人：</p>
                    <div class="r"><input type="text" name="media_contact" id="media_contact" class="txt_f1" style="width:75%;" value=""></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>联系电话：</p>
                    <div class="r"><input type="text" name="contact_phone" id="contact_phone" class="txt_f1" style="width:75%;" value=""></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>电子邮箱：</p>
                    <div class="r"><input type="text" name="email" id="email" class="txt_f1" style="width:75%;"  value=""></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>联系QQ：</p>
                    <div class="r"><input type="text" name="qq" id="qq" class="txt_f1" style="width:75%;" value=""></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>联系地址：</p>
                    <div class="r"><input type="text" name="address" id="address" class="txt_f1" style="width:75%;" value=""></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>邮编：</p>
                    <div class="r"><input type="text" name="zip_code" id="zip_code" class="txt_f1" style="width:75%;" value=""></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>网站/微博：</p>
                    <div class="r"><input type="text" name="web_contact" id="web_contact" class="txt_f1" style="width:75%;" value=""></div>
                </div>
                <!--自营资源详情显示-->
                <div class="item_f"><p><i class="LGntas"></i></p></div>
                <div class="item_f"><p><i class="LGntas"></i></p></div>
                <div class="item_f"><p><i class="LGntas"></i>会员价：</p>
                    <div class="r">
                        <input type="text" name="vip_price" id="vips_price" class="txt_f1" style="width:40%;"><span class="color1" style="padding-left:10px;">元</span>
                    </div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>平台价：</p>
                    <div class="r">
                        <input type="text" name="plate_price" id="plates_price" class="txt_f1" style="width:40%;"><span class="color1" style="padding-left:10px;">元</span>
                    </div>
                </div> <!--自营资源详情显示-->
            </div>
        </div>
        <div class="clr"></div>
        <div class="main_o clearfix" style="padding-bottom:0;width:90%;border:none;box-shadow: 0px 0px 0px #fff;">
        
            <div class="sbox_1_w sbox_1_w2 sel_box" id="attr_val">
                @foreach($plate_list as $key => $child_plate)
                    @foreach($child_plate['child_plate'] as $kk => $val) {{-- 新闻约稿 --}}
                        <div id="spec_show_{{ $val['id'] }}" style="display:none">
                        @foreach($val['plate_vs_attr'] as $kk => $vv)
                            <div class="sbox_1_item clearfix">
                                <span class="l" data="option_4">
                                    <strong>{{ $vv['attr_name'] }}：</strong>
                                </span>
                                <div class="m">
                                    <select class="sel_f1 spec_{{ $val['id'] }}"  set_name="network">
                                        @foreach($vv['attr_vs_val'] as $kkk => $vvv)
                                            <option value="{{ $vv['id'] }}_{{ $vvv['id'] }}">{{ $vvv['attr_value'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    @endforeach
                @endforeach

                
            </div>
            <input type="hidden" name="spec" id="spec" value="">

            
            <div class="clearfix">
                <div class="item_f"><p style="height:128px;line-height:128px;"><i class="LGntas"></i>媒体优势：</p>
                    <div class="r">
                        <textarea class="txt_ft1" id="remark" name="remark" style="width:70%;height:128px;" ></textarea>
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
// 选择媒体类型后调用控制媒体分类
function select_media(obj) {
    var id = $(obj).val();
    $("select[id^=media_]").hide();
    $("#media_"+id).show()
}
// 根据媒体分类 控制对应的规格
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

function sub_form() {
    if (!$("#media_name").val()) {
        layer.msg("媒体名称必须填写");
        return false;
    }
    if ($("#plate_tid").val() == 0) {
        layer.msg("请选择媒体类型");
        return false;
    }
    if (!$(".sel_f1.media").val()) {
        layer.msg("请选择媒体分类");
        return false;
    }
    var sel = $(".sel_f1.spec_"+$(".sel_f1.media").val());
    var spec = new Array;
    sel.each(function(){
        spec.push($(this).val());
    });
    $("#spec").val(spec);

    if (!$("#documents_upload_button2").val() && !$("#img_upload2").attr('src')) {
        layer.msg("入口示意图必须添加");
        return false;
    }
    if (!$("#documents_upload_button").val() && !$("#img_upload3").attr('src')) {
        layer.msg("媒体logo必须添加");
        return false;
    }
    if (!$("#proxy_price").val()) {
        layer.msg("价格必须填写");
        return false;
    }
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
    return true;
}   
    
</script>

</body>
</html>
