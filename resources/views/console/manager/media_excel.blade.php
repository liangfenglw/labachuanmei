<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>导入资源</title>
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
        <div class="place_ant"><a href="/console/index">首页</a> <a class="cur">导入资源</a> </div>
        
    </div>
    
    <div class="main_o clearfix" style="padding-bottom:20px;">
        <h3 class="title4 clearfix"><strong><a>导入资源</a></strong></h3>
            
        <form action="/usermanager/uploadSelfExcel" method="post" enctype="multipart/form-data" id="user_form">
        {{ csrf_field() }}
            <input type="hidden" name="user_id" value="$info['id'] }}">
            <div class="safe_1 clearfix">
                <div class="wrap_fl clearfix" style="">
                    <div class="item_f"><p><i class="LGntas"></i>上传类型：</p>
                        <div class="r">
                            <select name="upload_type" onchange="sel_show(this)">
                                <option value="0">请选择</option>
                                <option value="1">媒体</option>
                                <option value="2">供应商账号</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="wrap_fl clearfix" id="media_s" style="display: none;">
                    <div class="item_f"><p><i class="LGntas"></i>媒体分类：</p>
                        <div class="r">
                            <select name="plate_tid" onchange="select_platetid(this);">
                                <option value="0">请选择</option>
                                @foreach($list as $key => $val)
                                    <option value="{{ $val['id'] }}">{{ $val['plate_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="item_f"><p><i class="LGntas"></i>媒体类型：</p>
                        <div class="r">
                            @foreach($list as $key => $val)
                                <select name="media_type[{{ $val['id'] }}]" id="spec_{{ $val['id'] }}" style="display: none">
                                    @foreach($val['child_plate'] as $kk => $vv)
                                        <option value="{{ $vv['id'] }}">{{ $vv['plate_name'] }}</option>
                                    @endforeach
                                </select>
                            @endforeach
                        </div>
                    </div>
                    <div class="item_f"><p><i class="LGntas"></i>分类：</p>
                        <div class="r">
                            <select name="media_ref" >
                                <option value="1">自营媒体</option>
                                <option value="2">供应商媒体</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="wrap_fl clearfix" style="">
                        <div class="item_f">
                            <p><i class="LGntas"></i>文件：</p>
                            <div class="r">
                                <input type="file" name="file">
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="wrap_fl clearfix" style="">
                        <div class="item_f">
                            <p><i class="LGntas"></i></p>
                            <div class="r">
                                <input type="submit" name="file">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="category_id" id="category_id" value="">
            <input type="hidden" name="data_id" id="data_id" value="">
        </form>
        
    </div>
<script type="text/javascript">
    function sel_show(obj)
    {
        if ($(obj).val() == 1) {
            $("#media_s").show();
        } else {
            $("#media_s").hide();
        }
    }
</script>

</div></div>
@include('console.share.admin_foot')
<script>
    function select_platetid(obj) {
        var ids = $(obj).val();
        $("[id^=spec_]").hide();
        $("#spec_"+ids).show();
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
