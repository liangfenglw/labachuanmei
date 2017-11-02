<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>订单详情_供应商 - 亚媒社</title>
    @include('console.share.cssjs')
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')

<div class="content"><div class="Invoice">

    <div class="place">
        当前位置：<a href="/console/index">首页</a> > <a href="/supp/order">订单管理</a> > 订单详情
    </div>
    
    <div class="main_o">
        <h3 class="title5 clearfix"><strong>我的订单</strong></h3>
        <div class="clearfix wrap_f" style="padding-bottom:50px;">
            <form action="/supp/order/opera" method="post" enctype="multipart/form-data" onsubmit="return checkform();">
                {{ csrf_field() }}
                <div class="item_f"><p><i class="LGntas"></i>订单号：</p>
                     <div class="r"><input type="text" name="textfield" id="textfield" readonly="readonly" class="txt_f1" value="{{ $info['id'] }}"></div>
                </div>
                <input type="hidden" name="order_id" value="{{ $info['id'] }}">
                <div class="item_f"><p><i class="LGntas"></i>活动类型：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" readonly="readonly" value="{{ $info['type_name'] }}"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>活动名称：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" readonly="readonly" value="{{ $info['parent_order']['title'] }}"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>开始时间：</p>
                    <div class="r"><input type="text" name="textfield" id="datepicker1" class="txt_f1" disabled="disabled" value="{{ $info['parent_order']['start_at'] }}"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>结束时间：</p>
                    <div class="r"><input type="text" name="textfield" id="datepicker2" class="txt_f1" disabled="disabled" value="{{ $info['parent_order']['over_at'] }}"></div>
                </div>
                
                <div class="item_f"><p><i class="LGntas"></i>编辑方式：</p>
                    <div class="r radio_w">
                        <label><input type="radio" name="edit_type" class="radio_f" value="1" @if($info['parent_order']['doc_type'] == 1) checked @endif  disabled="disabled" />外部连接</label>
                        <label><input type="radio" name="edit_type" class="radio_f" value="2" @if($info['parent_order']['doc_type'] == 2) checked @endif disabled="disabled" />上传文档</label>
                        <label><input type="radio" name="edit_type" class="radio_f" value="3" @if($info['parent_order']['doc_type'] == 3) checked @endif disabled="disabled"/>内部编辑</label>
                    </div>
                </div>
                <div id="body_edit_type">
                    <div class="item_f" @if($info['parent_order']['doc_type'] == 1) style="display:block;" @else style="display:none;" @endif ><p><i class="LGntas"></i>外部链接：</p>
                        <div class="r"><input type="text" name="textfield" id="textfield" readonly="readonly" class="txt_f1" style="width:75%;" value="{{ $info['parent_order']['content'] }}" /></div>
                    </div>
                    <div class="item_f" @if($info['parent_order']['doc_type'] == 2) style="display:block;" @else style="display:none;" @endif><p><i class="LGntas"></i>文档导入：</p>
                        <div class="r">
                            <a href="/{{ $info['parent_order']['sale_file'] }}" target="view_window">{{$info['parent_order']['sale_file']}}</a >
                        </div>
                     
                    </div>
                    <div class="item_f" @if($info['parent_order']['doc_type'] == 3) style="display:block;" @else style="display:none;" @endif><p><i class="LGntas"></i>订单内容：</p>
                        <div class="r">
                            <!--    在订单详情页中，”订单内容项“ 根据编辑方式不同所显示的界面不同，具体排版与会员下单页界页一样     -->
                            <textarea class="txt_ft1" readonly="readonly">{{ $info['parent_order']['content'] }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="item_f"><p><i class="LGntas"></i>关键字：</p>
                    <div class="r"><input type="text" name="keywords" id="textfield" class="txt_f1" style="width:75%;" readonly="readonly"  value="{{ $info['parent_order']['keywords'] }}" /></div>
                </div>
                
                <div class="item_f"><p><i class="LGntas"></i>订单备注：</p>
                    <div class="r">
                        <textarea class="txt_ft1" style="height:90px;" name="remark" readonly="readonly">{{ $info['parent_order']['remark'] }}</textarea>
                    </div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>平台价：</p>
                    <div class="r"><input type="text" name="user_money" id="textfield" class="txt_f1" style="width:16%;" readonly="readonly" value="{{ $info['supp_money'] }}" /><span class="color1" style="padding-left:10px;">元</span></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>订单状态：</p>
                    <div class="r">
                        @if($info['order_type'] == 1)
                            <select class="sel_f1" name="order_type" id="order_type">
                                <option value="4">接受</option>
                                <option value="2">拒单</option>
                            </select>
                        @endif
                        @if(in_array($info['order_type'],[4,6,7]))
                            <select class="sel_f1" name="order_type" id="order_type" onchange="console_show(this);">
                                <option value="5">完成</option>
                                <option value="6">订单反馈</option>
                            </select>
                            <script type="text/javascript">
                                function console_show(obj) {
                                    var type = $(obj).val();
                                    if (type == 6) {
                                        $("#success_url").hide();
                                        $("#success_pic").hide();
                                    } else if(type == 5) {
                                        $("#success_url").show();
                                        $("#success_pic").show();
                                    }
                                }
                            </script>
                        @endif
                        @if(in_array($info['order_type'], [5,8,9,10,2])) <!--处于供应商确认完成后的操作-->
                            <select class="sel_f1" name="order_type" id="order_type" disabled="disabled">
                                <option>{{ $order_status[$info['order_type']] }}</option>
                            </select>
                        @endif
                        @if(in_array($info['order_type'], [0]))
                            <select class="sel_f1" name="order_type" id="order_type"  disabled="disabled">
                                <option>取消</option>
                            </select>
                        @endif
                    </div>
                </div>
                <!-- 质量反馈 -->
                @if($info['qa_feedback'])
                    <div class="item_f"><p><i class="LGntas"></i>质量反馈：</p>
                        <div class="r">
                            <select class="sel_f1" disabled="disabled">
                                @foreach($qa_desc as $key => $val)
                                    <option value="{{ $key }}" @if($key == $info['qa_feedback']) selected="selected"  @endif>{{ $val }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif
                <!-- 质检扣款 -->
                @if($info['qa_change'] > 0)
                    <div class="item_f"><p><i class="LGntas"></i>质检扣款：</p>
                        <div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" style="width:16%;" value="{{ $info['qa_change'] }}"><span class="color1" style="padding-left:10px;">元</span></div>
                    </div>
                @endif

                @if(in_array($info['order_type'],[4,5,6,7,8,10]))  <!--接受任务、反馈阶段-->
                    <div class="item_f" id="success_url"><p><i class="LGntas"></i>完成链接：</p>
                        <div class="r"><input type="text" name="success_url" id="success_url_v" class="txt_f1" style="width:75%;" / value="{{ $info['success_url'] }}"></div>
                    </div>
                    <div class="item_f" id="success_pic"><p><i class="LGntas"></i>完成截图：</p>
                        <div class="r" style="position:relative;">
                            <img @if($info['success_url']) src="{{ $info['success_pic'] }}" @else src="/console/images/z_add2.png" @endif id="img_upload" style="cursor:pointer;float:left;margin-right:8px;" />
                            <input type="file" id="success_pic_v" name="success_pic" id="documents_upload_button" placeholder="未选择任何文件" class="upload_f1" accept="image/*" style="" />
                            <span class="info1_f valign_m" style="height:95px;padding:0;">
                                <i>*</i> 请点击选择图片，仅支持 JPG、JPEG、GIF、<br/>PNG 格式的图片文件，文件不能大于 2MB。
                            </span>
                        </div>
                    </div>
                        <!--    质量反馈下的三项，当该订单状态选择“完成”下次再打开订单详情显示，   -->             
                    
                    <div class="item_f"><p><i class="LGntas"></i>供应商反馈：</p>
                        <div class="r">
                            <textarea class="txt_ft1" style="height:100px;" name="supp_feedback" id="supp_feedback" placeholder="{{ $info['supp_feedback'] }}"></textarea>
                        </div>
                    </div>
                @endif
                @if($info['order_feedback'])  <!--存在反馈-->
                    <div class="item_f"><p><i class="LGntas"></i>用户反馈：</p>
                        <div class="r">
                            <textarea class="txt_ft1" readonly="readonly" style="height:100px;">{{ $info['order_feedback'] }}</textarea>
                        </div>
                    </div>
                @endif

                @if(!in_array($info['order_type'], [2,5,8,9,10,0])) <!--处于供应商确认完成后的操作,供应商不能操作-->
                <div class="item_f item_f_2" style="margin-top:50px;">
                    <div class="r"><input type="submit" value="确 认" class="sub_f1"></div>
                </div>
                @endif
            </form>
        </div>

    </div>  

</div></div>
@include('console.share.admin_foot')
<script type="text/javascript">
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
    if( $('#datepicker2').length>0 && typeof(picker2)!="object" ){
        var picker2 = new Pikaday({
            field: document.getElementById('datepicker2'),
            firstDay: 1,
            format: "YYYY-MM-DD",
            minDate: new Date('2000-01-01'),
            maxDate: new Date('2020-12-31'),
            yearRange: [2000,2020]
        });
    }
    
    $("input[name=edit_type]").click(function(){
        var value = $(this).val();
        var index = $(this).index("input[name=edit_type]");
        console.log(index);
        console.log(value);
        $("#body_edit_type .item_f").eq(index).css("display","block").siblings().css("display","none");     
    });
    
function checkform() {
    if ($("#order_type").val() == 5) {
        var success_url = $("#success_url_v").val();
        var success_pic = $("#success_pic_v").val();
        if (!success_url) {
            layer.msg('必须填写完成链接');return false;
        }
        if (!success_pic) {
            layer.msg('必须上传完成截图');return false;
        }
    }
    if ($("#order_type").val() == 6) {
        var supp_feedback = $("#supp_feedback").val();
        if (supp_feedback.length > 10) {
            layer.msg('订单反馈内容必须大于10个字');return false;
        }
    }
    return true;
}


</script>

</body>
</html>
