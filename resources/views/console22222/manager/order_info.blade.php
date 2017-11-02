<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>任—订单详情 - 喇叭传媒</title>
    @include('console.share.cssjs')
</head>
<body class="fold">
@include('console.share.admin_head')
@include('console.share.admin_menu')
<div class="content"><div class="Invoice">
    <div class="place">
        当前位置：<a href="/console/index">首页</a> > 订单管理 > 订单详情
    </div>
    <div class="main_o">
        <h3 class="title5 clearfix"><strong>我的订单</strong></h3>
        <div class="clearfix wrap_f" style="padding-bottom:50px;">
            <form action="" method="post">
                <div class="item_f"><p><i class="LGntas"></i>订单号：</p>
                    <div class="r"><input type="text" name="id" id="textfield" class="txt_f1" value="{{ $info['id'] }}" readonly="readonly"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>所属用户：</p>
                    <div class="r"><input type="text" name="ads_user_id" id="textfield" class="txt_f1" value="{{ $info['ad_user_name'] }}" readonly="readonly"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>所属媒体商：</p>
                    <div class="r">
                        <input type="text" readonly="readonly" name="supp_user_id" id="textfield" class="txt_f1" value="{{$info['media_name']}}">
                    </div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>订单状态：</p>
                    <div class="r">
                    <input type="text" name="order_type" id="textfield" class="txt_f1" value="{{ getOrderType($info['order_type']) }}" readonly="readonly"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>活动类型：</p>
                    <div class="r"><input type="text" readonly="readonly" name="type_id" value="{{ $info['type_name'] }}" id="textfield" class="txt_f1"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>活动名称：</p>
                    <div class="r"><input type="text" readonly="readonly" name="type_name" value="{{ $info['title'] }}" id="textfield" class="txt_f1"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>开始时间：</p>
                    <div class="r"><input type="text" readonly="readonly" name="textfield" id="datepicker1" class="txt_f1" value="{{ $info['start_at'] }}"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>结束时间：</p>
                    <div class="r"><input type="text" readonly="readonly" name="textfield" id="datepicker2" class="txt_f1" value="{{ $info['over_at'] }}"></div>
                </div>
                
                <div class="item_f"><p><i class="LGntas"></i>编辑方式：</p>
                    <div class="r radio_w">
                        <label><input type="radio" disabled="disabled" name="edit_type" class="radio_f" value="1" @if($info['doc_type'] == 1) checked  @endif />外部连接</label>
                        <label><input type="radio" disabled="disabled" name="edit_type" class="radio_f" value="2" @if($info['doc_type'] == 2) checked  @endif />上传文档</label>
                        <label><input type="radio" disabled="disabled" name="edit_type" class="radio_f" value="3" @if($info['doc_type'] == 3) checked  @endif/>内部编辑</label>
                    </div>
                </div>
                
                <div id="body_edit_type">
                    <div class="item_f" @if($info['doc_type'] == 1) style="display:block;" @else style="display: none" @endif><p><i class="LGntas"></i>外部链接：</p>
                        <div class="r">
                            <input type="text" name="textfield" id="textfield" class="txt_f1" style="width:75%;" value="{{ $info['content'] }}" />
                        </div>
                    </div>
                    <div class="item_f" @if($info['doc_type'] == 2) style="display:block;" @else style="display: none" @endif><p><i class="LGntas"></i>文档导入：</p>
                        <div class="r">
                            <a href="/{{ $info['sale_file'] }}" target="view_window">{{$info['sale_file']}}</a >
                        </div>
                    </div>
                    <div class="item_f" @if($info['doc_type'] == 3) style="display:block;" @else style="display: none" @endif><p><i class="LGntas"></i>活动需求：</p>
                        <div class="r">
                            <!--    在订单详情页中，”订单内容项“ 根据编辑方式不同所显示的界面不同，具体排版与会员下单页界页一样 -->
                            <textarea class="txt_ft1">{{ $info['content'] }}</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="item_f"><p><i class="LGntas"></i>订单备注：</p>
                    <div class="r">
                        <textarea class="txt_ft1" style="height:90px;">{{ $info['remark'] }}</textarea>
                    </div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>平台价：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" style="width:16%;" value="{{ $info['platform'] }}" readonly="readonly" /><span class="color1" style="padding-left:10px;">元</span></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>供应商价：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" style="width:16%;" value="{{ $info['supp_money'] }}" readonly="readonly" /><span class="color1" style="padding-left:10px;">元</span></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>返利：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" style="width:16%;" value="{{ $info['commission'] }}" readonly="readonly" /><span class="color1" style="padding-left:10px;">元</span></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>订单总金额：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" style="width:16%;" value="{{ $info['user_money'] }}" readonly="readonly" /><span class="color1" style="padding-left:10px;">元</span></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>质量反馈：</p>
                    <div class="r">
                        <select class="sel_f1">
                        @foreach($qa_desc as $key => $val)
                            <option @if($key == $info['qa_feedback']) selected="selected" @endif >{{$val}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>完成链接：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" style="width:75%;" value="{{$info['success_url']}}" /></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>完成截图：</p>
                    <div class="r" style="position:relative;">
                        @if($info['success_pic'])
                            <img src="{{ $info['success_pic'] }}" id="img_upload" style="cursor:pointer;float:left;margin-right:8px;width: 50%" />
                        @else
                            <img src="/console/images/z_add2.png" id="img_upload" style="cursor:pointer;float:left;margin-right:8px;" />
                            <!-- <input type="file" name="Documents" id="documents_upload_button" placeholder="未选择任何文件" class="upload_f1" accept="image/*" style="" />
                            <span class="info1_f valign_m" style="height:95px;padding:0;">
                                <i>*</i> 请点击选择图片，仅支持 JPG、JPEG、GIF、<br/>PNG 格式的图片文件，文件不能大于 2MB。
                            </span> -->
                        @endif
                        
                    </div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>确认订单：</p>
                    <div class="r">
                        <select class="sel_f1" style="float:left;margin-right:8px;">
                            <option value="1">{{getOrderType($info['order_type'])}}</option>
                        </select>
                    </div>
                </div>
                @if($info['order_feedback'])
                <div class="item_f"><p><i class="LGntas"></i>订单反馈：</p>
                    <div class="r">
                        <!--    确认订单项为：确认完成后面两项为隐藏，否则为显示    -->
                        <textarea class="txt_ft1" style="height:100px;">{{ $info['order_feedback'] }}</textarea>
                    </div>
                </div>
                @endif
                @if($info['supp_feedback'])
                <div class="item_f"><p><i class="LGntas"></i>供应商反馈：</p>
                    <div class="r">
                        <textarea class="txt_ft1" style="height:100px;" readonly="readonly">{{ $info['supp_feedback'] }}</textarea>
                    </div>
                </div>
                @endif
                @if($info['qa_change'])
                <div class="item_f"><p><i class="LGntas"></i>质检扣款：</p>
                    <div class="r">
                        <input type="text" name="qa_change" id="textfield" class="txt_f1" style="width:16%;" value="{{ $info['qa_change'] }}" />
                        <span class="color1" style="padding-left:10px;">元</span></div>
                </div>
                @endif
               <!--  <div class="item_f item_f_2" style="margin-top:50px;">
                    <div class="r"><input type="submit" value="确 认" class="sub_f1"></div>
                </div> -->
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
    
$(function(){

});


</script>

</body>
</html>
