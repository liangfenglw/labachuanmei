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
            
        <form action="/usermanager/supps/resource/updateInfo" method="post" enctype="multipart/form-data" id="user_form" onsubmit="return sub_form();">
            {{ csrf_field() }}
            <input type="hidden" name="user_id" value="{{ $info['id'] }}">
            <div class="safe_1 clearfix">
                <div class="wrap_fl clearfix" style="width:35%;">
                        <div class="item_f"><p><i class="LGntas"></i>供应商：</p>
                            <div class="r">
                                <span>{{ $parent_name }}</span>
                                <!-- <input type="text" name="belong" value="{{ $parent_name }}" id="textfield" class="txt_f1" style="width:75%;" > -->
                            </div>
                        </div>
                        
                        <div class="item_f"><p style="padding-top:25px;"><i class="LGntas"></i>媒体LOGO：</p>
                            <div class="r" style="position:relative;">
                                <div class="img_show">
                                    <img src="@if($info['supp_user']['media_logo']) {{$info['supp_user']['media_logo']}} @else /console/images/z_add2.png @endif" id="img_upload" name="" style="cursor:pointer;float:left;margin-right:8px;width:130px; height:130px;" />
                                    <input type="file" name="media_logo" id="documents_upload_button" placeholder="未选择任何文件" accept="image/jpg,image/jpeg,image/png" class="txt6 txt6_up upfile upload_f1" style="width:130px;height:130px;display:none;opacity:0;"  />
                                </div>
                                <span class="info1_f valign_m" style="height:95px;padding:0;">
                                    <i>*</i> 请点击选择图片，仅支持JPG、JPEG、GIF、PNG格式的图片文件，文件不能大于2MB。
                                </span>
                            </div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>媒体名称：</p>
                            <div class="r"><input type="text" name="media_name" id="media_name" value="{{ $info['supp_user']['media_name'] }}" class="txt_f1"  style="width:75%;"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>媒体类型：</p>
                            <div class="r">
                                <span>{{ $plate['plate_name'] }}</span>
                                {{-- <select class="sel_f1" style="width:70%;" name="plate_tid" id="plate_tid" onchange="select_child(this);">
                                    <option value="0">请选择</option>
                                    @foreach($plate_list as $key => $val)
                                        <option value="{{ $val->id }}" @if($info['supp_user']['plate_tid'] == $val->id)selected  @endif>{{ $val->plate_name }}</option>
                                    @endforeach
                                </select> --}}
                            </div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>媒体分类：</p>
                            <div class="r">
                                {{-- <select class="sel_f1" style="width:70%;" id="child_class" name="plate_id" onchange="select_attr(this)"> --}}
                                    <span>{{ $plate['child_plate']['0']['plate_name'] }}</span>
                                {{-- </select> --}}
                            </div>
                        </div>

                        <div class="item_f"><p style="padding-top:25px;"><i class="LGntas"></i>入口示意图：</p>
                            <div class="r" style="position:relative;">
<div class="img_show">
        <img src="@if($info['supp_user']['index_logo']) {{$info['supp_user']['index_logo']}} @else /console/images/z_add2.png @endif" id="img_upload2" style="cursor:pointer;float:left;margin-right:8px;width:130px; height:130px;" />
    <input type="file" name="index_logo" id="documents_upload_button2" placeholder="未选择任何文件"  class="txt6 txt6_up upfile upload_f1" style="width:130px;height:130px;display:none;opacity:0;"     accept="image/jpg,image/jpeg,image/png" />
</div>
                                <span class="info1_f valign_m" style="height:95px;padding:0;">
                                    <i>*</i> 请点击选择图片，仅支持JPG、JPEG、GIF、PNG格式的图片文件，文件不能大于2MB。
                                </span>
                            </div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>价格：</p>
                            <div class="r">
                                <input  type="text" name="proxy_price"  id="proxy_price" value="{{ $info['supp_user']['proxy_price'] }}" class="txt_f1" style="width:40%;" id="proxy_price"><span class="color1" style="padding-left:10px;">元</span>
                            </div>
                        </div>
                        {{-- <div class="item_f">
                        <p><i class="LGntas"></i>会员价率：</p>
                        <div class="r">
                            <input type="text" name="vip_rate" id="vip_price" onkeyup="setPrice();" value="{{ $info['supp_user']['vip_price'] }}" class="txt_f1"><span class="color1" style="padding-left:10px;">%</span>
                        </div>
                    </div> --}}
                    {{-- <div class="item_f">
                        <p><i class="LGntas"></i>平台价率：</p>
                        <div class="r">
                            <input type="text" name="plate_rate" onkeyup="setPrice();"  id="plate_price" value="{{ $info['supp_user']['plate_rate'] }}" class="txt_f1"><span class="color1" style="padding-left:10px;">%</span>
                        </div>
                    </div> --}}
                       {{--  <div class="item_f"><p><i class="LGntas"></i>会员价：</p>
                            <div class="r">
                                <input type="text" name="vip_price" id="vips_price" value="{{ $info['supp_user']['vip_price'] }}" readonly="readonly" class="txt_f1"><span class="color1" style="padding-left:10px;">元</span>
                            </div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>平台价：</p>
                            <div class="r">
                                <input type="text" name="plate_price" value="{{ $info['supp_user']['plate_price'] }}" id="plates_price" readonly="readonly" class="txt_f1"><span class="color1" style="padding-left:10px;">元</span>
                            </div>
                        </div> --}}
                </div>
                <div class="wrap_fr" style="width:47%;margin-right:2%;">
                    <div class="wrap_fr3">
                    
                        <div class="item_f"><p><i class="LGntas"></i>负责人：</p>
                            <div class="r"><input type="text" name="media_contact" id="media_contact" class="txt_f1" style="width:75%;" value="{{ $info['supp_user']['media_contact'] }}"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>联系电话：</p>
                            <div class="r"><input type="text" name="contact_phone" id="contact_phone" class="txt_f1" style="width:75%;" value="{{ $info['supp_user']['contact_phone'] }}"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>电子邮箱：</p>
                            <div class="r"><input type="text" name="email" id="email" class="txt_f1" style="width:75%;"  value="{{ $info['supp_user']['email'] }}"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>联系QQ：</p>
                            <div class="r"><input type="text" name="qq" id="qq" class="txt_f1" style="width:75%;" value="{{ $info['supp_user']['qq'] }}"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>联系地址：</p>
                            <div class="r"><input type="text" name="address" id="address" class="txt_f1" style="width:75%;" value="{{ $info['supp_user']['address'] }}"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>邮编：</p>
                            <div class="r"><input type="text" name="zip_code" id="zip_code" class="txt_f1" style="width:75%;" value="{{ $info['supp_user']['zip_code'] }}"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>网站/微博：</p>
                            <div class="r"><input type="text" name="web_contact" id="web_contact" class="txt_f1" style="width:75%;" value="{{ $info['supp_user']['web_contact'] }}"></div>
                        </div>
                    </div>
                </div>
                <div class="clr"></div>
                
                <div class="main_o clearfix" style="padding-bottom:0;width:90%;border:none;box-shadow: 0px 0px 0px #fff;">

                    <div class="sbox_1_w sbox_1_w2 sel_box" id="attr_val" style="">
                        @foreach($spec_vs_val['plateVsAttr'] as $key => $spec)
                        <div class="sbox_1_item clearfix">
                            <span class="l" data="option_4" style="">
                                <strong>{{ $spec['attr_name'] }}：</strong>
                            </span>
                            <div class="m">
                                <select class="sel_f1" name="spec[{{ $spec['id'] }}]" set_name="network">
                                    @foreach($spec['attrVsVal'] as $spec_v_key => $spec_val)
                                        <option value="{{ $spec_val['id'] }}" @if(in_array($spec_val['id'],$user_vs_attr_ids)) selected="selected" @endif >{{ $spec_val['attr_value'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="clearfix">
                        <div class="item_f"><p style="height:128px;line-height:128px;"><i class="LGntas"></i>媒体优势：</p>
                            <div class="r">
                                <textarea class="txt_ft1"  name="remark" id="remark" style="width:70%;height:128px;" >{{ $info['supp_user']['remark'] }}</textarea>
                            </div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>状态：</p>
                            <div class="r radio_w">
                                 <label class="rd1 @if($info['supp_user']['is_state'] == 1) css_cur @endif"><input type="radio" name="is_state" @if($info['supp_user']['is_state'] == 1) checked @endif class="radio_f" value="1" />在线</label>
                                <label class="rd1 @if($info['supp_user']['is_state'] == 2) css_cur @endif"><input type="radio" name="is_state" @if($info['supp_user']['is_state'] == 2) checked @endif class="radio_f" value="2" />下架</label>
                                <label class="rd1 @if($info['supp_user']['is_state'] == 3) css_cur @endif"><input type="radio" name="is_state" @if($info['supp_user']['is_state'] == 3) checked @endif class="radio_f" value="3" />审核</label>
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
    $(function(){
        select_child($("#plate_tid"));
    })
    function select_child(obj) {
        var pid = $(obj).val();
        if (pid) {
            $.ajax({
                data:{"is_ajax":"get_child",'pid':pid},
                type:"get",
                url:"/usermanager/add_ads",
                success:function(msg) {
                    var html = '<option value="0">请选择</option>';
                    if (msg.status_code == 200) {
                        for (i in msg.lists) {
                            if (msg['lists'][i]['id'] == "{{$info['supp_user']['plate_id']}}") {
                                html += '<option value="'+msg['lists'][i]['id']+'" selected>'+msg['lists'][i]['plate_name']+'</option>';
                            } else {
                                html += '<option value="'+msg['lists'][i]['id']+'">'+msg['lists'][i]['plate_name']+'</option>';   
                            }
                        }
                        $("#child_class").html(html);
                    }
                },
                error:function(){}
            })
        }
    }
    function select_attr(obj) {
        var attr_id = $(obj).val();
        var pid = $("#plate_id").val();
        if (attr_id && pid) {
            $.ajax({
                data:{"is_ajax":"get_attr","attr_id":attr_id,"pid":pid},
                dataType:"html",
                type:"get",
                success:function(msg) {
                    $("#attr_val").html(msg);
                }
            })
        }
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
        //表单校验
        if (!$("#media_name").val()) {
            layer.msg("媒体名称必须填写");
            return false;
        }

        if (!$("#documents_upload_button2").val() && !$("#img_upload2").attr('src')) {
            layer.msg("入口示意图必须添加");
            return false;
        }

        if (!$("#proxy_price").val()) {
            layer.msg("代理价必须填写");
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
        if (!$("#web_contact").val()) {
            layer.msg("网站/微博 必须填写");
            return false;
        }
        return true;
    }   
    
</script>

</body>
</html>
