<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('console.share.cssjs')
</head>
<body class="fold">
@include('console.share.admin_head')
@include('console.share.admin_menu')
<div class="content"><div class="Invoice">
    <div class="place">
        当前位置：<a href="/console/index">首页</a> > 帐户信息
    </div>
    <div class="main_o clearfix" style="padding-bottom:20px;">
        <h3 class="title4 clearfix"><strong><a>供应商详情</a></strong></h3>
        <form action="/usermanager/add_ads" method="post" enctype="multipart/form-data" onsubmit="return sub_form();">
            {{ csrf_field() }}
            <div class="safe_1 clearfix">
                <div class="wrap_fl clearfix" style="width:35%;">   
                        <div class="item_f"><p><i class="LGntas"></i>用户名：</p>
                            <div class="r"><input type="text" name="name" id="name" class="txt_f1" style="width:75%;"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>所属媒体：</p>
                            <div class="r"><input type="text" name="belong" id="belong" class="txt_f1" style="width:75%;"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>媒体类型：</p>
                            <div class="r">
                                <select class="sel_f1" style="width:70%;" name="plate_tid" id="plate_id" onchange="select_child(this);">
                                    <option value="0">请选择</option>
                                    @foreach($plate_list as $key => $val)
                                        <option value="{{ $val->id }}">{{ $val->plate_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>媒体分类：</p>
                            <div class="r">
                                <select class="sel_f1" style="width:70%;" id="child_class" name="plate_id" onchange="select_attr(this)">
                                    <option value="0">请选择</option>
                                </select>
                            </div>
                        </div>
                        <script type="text/javascript">
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
                                                        html += '<option value="'+msg['lists'][i]['id']+'">'+msg['lists'][i]['plate_name']+'</option>';
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
                        </script>
                        <div class="item_f"><p><i class="LGntas"></i>媒体名称：</p>
                            <div class="r"><input type="text" name="media_name" id="media_name" class="txt_f1" style="width:75%;"></div>
                        </div>
                        <div class="item_f"><p style="padding-top:25px;"><i class="LGntas"></i>媒体LOGO：</p>
                            <div class="r" style="position:relative;">
                                <img src="/console/images/z_add2.png" id="img_upload" name="" style="cursor:pointer;float:left;margin-right:8px;" />
                                <input type="file" name="media_logo" id="documents_upload_button" placeholder="未选择任何文件" class="upload_f1" accept="image/*" style="" />
                                <span class="info1_f valign_m" style="height:95px;padding:0;">
                                    <i>*</i> 请点击选择图片，仅支持JPG、JPEG、GIF、PNG格式的图片文件，文件不能大于2MB。
                                </span>
                            </div>
                        </div>
                        <div class="item_f"><p style="padding-top:25px;"><i class="LGntas"></i>入口示意图：</p>
                            <div class="r" style="position:relative;">
                                <img src="/console/images/z_add2.png" id="img_upload2" style="cursor:pointer;float:left;margin-right:8px;" />
                                <input type="file" name="index_logo" id="documents_upload_button2" placeholder="未选择任何文件" class="upload_f1" accept="image/*" style="" />
                                <span class="info1_f valign_m" style="height:95px;padding:0;">
                                    <i>*</i> 请点击选择图片，仅支持JPG、JPEG、GIF、PNG格式的图片文件，文件不能大于2MB。
                                </span>
                            </div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>代理价：</p>
                            <div class="r">
                                <input type="text" name="proxy_price" id="proxy_price" class="txt_f1" style="width:55%;"><span class="color1" style="padding-left:10px;">元</span>
                            </div>
                        </div>
                </div>
                
                <div class="wrap_fr" style="width:47%;margin-right:2%;">
                    <div class="wrap_fr3">
                        
                        <div class="item_f"><p><i class="LGntas"></i>媒体负责人：</p>
                            <div class="r"><input type="text" name="media_contact" id="media_contact" class="txt_f1" style="width:75%;"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>联系电话：</p>
                            <div class="r"><input type="text" name="contact_phone" id="contact_phone" class="txt_f1" style="width:75%;"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>电子邮箱：</p>
                            <div class="r"><input type="email" name="email" id="email" class="txt_f1" style="width:75%;"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>联系QQ：</p>
                            <div class="r"><input type="text" name="qq" id="qq" class="txt_f1" style="width:75%;"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>联系地址：</p>
                            <div class="r"><input type="text" name="address" id="address" class="txt_f1" style="width:75%;"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>邮编：</p>
                            <div class="r"><input type="text" name="zip_code" id="zip_code" class="txt_f1" style="width:75%;"></div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>媒体认证：</p>
                            <div class="r">
                                <select class="sel_f1" style="width:70%;" name="media_check" id="media_check">
                                    <option value="1">媒体认证</option>
                                </select>
                            </div>
                        </div>
                        <div class="item_f"><p style="padding-top:25px;"><i class="LGntas"></i></p>
                            <div class="r" style="position:relative;">
                                <img src="/console/images/z_add2.png" id="img_upload3" style="cursor:pointer;float:left;margin-right:8px;" />
                                <input type="file" name="media_check_file" id="documents_upload_button3" placeholder="未选择任何文件" class="upload_f1" accept="image/*" style="" />
                                <span class="info1_f valign_m" style="height:95px;padding:0;">
                                    <i>*</i> 请点击选择图片，仅支持JPG、JPEG、GIF、PNG格式的图片文件，文件不能大于2MB。
                                </span>
                            </div>
                        </div>


                    </div>
                </div>
                
                <div class="clr"></div>
                    
                    
                <div class="main_o clearfix" style="padding-bottom:0;width:90%;border:none;box-shadow: 0px 0px 0px #fff;">
                    <div class="sbox_1_w sbox_1_w2" id="attr_val">
                    </div>
                    <div class="clearfix">
                        <div class="item_f"><p><i class="LGntas"></i>媒体简介：</p>
                            <div class="r">
                                <textarea class="txt_ft1"  name="breif" style="width:70%;height:128px;"></textarea>
                            </div>
                        </div>
                        <div class="item_f"><p><i class="LGntas"></i>备注：</p>
                            <div class="r">
                                <textarea class="txt_ft1" name="remark" style="width:70%;height:128px;"></textarea>
                            </div>
                        </div>

                        <div class="item_f"><p><i class="LGntas"></i>状态：</p>
                            <div class="r radio_w">
                                <label><input type="radio" checked="checked" name="is_state" class="radio_f" value="1" />在线</label>
                                <label><input type="radio" name="is_state" class="radio_f" value="2" />下架</label>
                                <label><input type="radio" name="is_state" class="radio_f" value="3" />审核</label>
                            </div>
                        </div>
                        <div class="item_f item_f_2" style="margin-top:20px;">
                            <div class="r"><input type="submit" value="确 认" class="sub_f1" style="margin-left:30%;" /></div>
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
        var category_arr = [];
        var id_arr = [];
        $('#attr_val ul[set_name="network"] a.cur').each(function(){
            id_arr.push($(this).attr('data_id'));
            category_arr.push($(this).attr('category_id'));
        })
        $("#data_id").val(category_arr.toString());
        $("#category_id").val(id_arr.toString());
        //表单校验
        if (!$("#name").val()) {
            layer.msg("用户名必须填写");
            return false;
        }
        if (!$("#media_name").val()) {
            layer.msg("媒体名称必须填写");
            return false;
        }
        if (!$("#documents_upload_button").val()) {
             layer.msg("媒体logo必须添加");
            return false;
        }
        if (!$("#documents_upload_button2").val()) {
             layer.msg("入口示意图必须添加");
            return false;
        }
        if (!$("#documents_upload_button3").val()) {
            layer.msg("媒体认证图必须添加");
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
        if (!$("#category_id").val()) {
            layer.msg("媒体属性信息必须选择，将不可再更改");
            return false;
        }
        return true;
    }

</script>

</body>
</html>
