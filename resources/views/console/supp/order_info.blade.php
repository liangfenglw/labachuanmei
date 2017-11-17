<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>订单管理_喇叭传媒</title>
    @include('console.share.cssjs')
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')
<div class="content"><div class="Invoice">
    <div class="place" data-order_type="{{$info['order_type']}}">
         <div class="place_ant"><a href="/console/index">首页</a><a href="/supp/order" class="cur">订单管理 </a></div>
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
            <div class="item_f"><p><i class="LGntas"></i>稿件类型：</p>
                <div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" readonly="readonly" value="{{ $info['type_name'] }}"></div>
            </div>
            <div class="item_f"><p><i class="LGntas"></i>稿件名称：</p>
                <div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" style="width:52%;" readonly="readonly" value="{{ $info['parent_order']['title'] }}"></div>
            </div>
            <div class="item_f"><p><i class="LGntas"></i>订单总价：</p>
                <div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" style="width:16%;" value="{{$info['parent_order']['user_money']}}" disabled /><span class="color1" style="padding-left:10px;">元</span></div>
            </div>
                    @if($info['parent_order']['cooperation_mode'])
        <div class="item_f"><p><i class="LGntas"></i>合作方式：</p>
            <div class="r"><input type="text" name="textfield" id="textfield" disabled="disabled" class="txt_f1" value="{{ $info['parent_order']['cooperation_mode'] }}"></div>
        </div>
    @endif
    <div class="item_f"><p><i class="LGntas"></i>@if($info['type_id'] == 10) 直播标题@else 稿件名称@endif：</p>
        <div class="r"><input type="text" readonly="readonly" value="{{ $info['parent_order']['title'] }}" id="textfield" class="txt_f1" style="width:52%;"></div>
    </div>
    <div class="item_f"><p><i class="LGntas"></i>开始时间：</p>
        <div class="r"><input type="text" readonly="readonly" id="datepicker1" class="txt_f1" value="{{ $info['parent_order']['start_at'] }}"></div>
    </div>
    <div class="item_f"><p><i class="LGntas"></i>结束时间：</p>
        <div class="r"><input type="text" readonly="readonly" id="datepicker2" class="txt_f1" value="{{ $info['parent_order']['over_at'] }}"></div>
    </div>
            {{-- kaishi --}}
    @if($info['type_id'] == 10) 
        <div class="item_f"><p><i class="LGntas"></i>具体形式：</p>
            <div class="r radio_w">
                <label class="rd1 @if($info['parent_order']['doc_type'] ==1) css_cur @endif"><input type="radio" name="edit_type" class="radio_f" @if($info['parent_order']['doc_type'] ==1) checked="checked" @endif value="1" disabled />活动现场直播</label>
                <label class="rd1 @if($info['parent_order']['doc_type'] ==2) css_cur @endif"><input type="radio" name="edit_type" class="radio_f" @if($info['parent_order']['doc_type'] ==2) checked="checked" @endif  value="2" disabled />产品使用</label>
                <label class="rd1 @if($info['parent_order']['doc_type'] ==3) css_cur @endif"><input type="radio" name="edit_type" class="radio_f" @if($info['parent_order']['doc_type'] ==3) checked="checked" @endif  value="3" disabled />店铺体验</label>
                <label class="rd1 @if($info['parent_order']['doc_type'] ==4) css_cur @endif"><input type="radio" name="edit_type" class="radio_f" @if($info['parent_order']['doc_type'] ==4) checked="checked" @endif  value="3" disabled />游戏直播</label>
            </div>
        </div>
        <div class="item_f" style=""><p><i class="LGntas"></i>直播内容：</p>
            <div class="r">
                <div class="dnts">{!! $info['parent_order']['content'] !!}</div>
            </div>
        </div>
        <div class="item_f"><p><i class="LGntas"></i>直播地点：</p>
            <div class="r"><input type="text" name="textfield" id="textfield" disabled="disabled" class="txt_f1" value="{{ $info['parent_order']['cooperation_place'] }}"  style="width:52%;"></div>
        </div>
        @if($info['parent_order']['sale_file'])
            <div class="item_f" style=""><p><i class="LGntas"></i>上传附件：</p>
                <div class="r">
                   <a href="/{{$info['parent_order']['sale_file']}}" target="view_window" class="txt_f1" style="line-height:45px; width:75%; float:left;">{{$info['parent_order']['sale_file']}}</a>
                </div>
            </div>
        @endif
    @else
        <div class="item_f"><p><i class="LGntas"></i>编辑方式{{ $info['parent_order']['doc_type'] }}：</p>
            <div class="r radio_w disabled_rd">
                <label class="rd1 @if($info['parent_order']['doc_type'] == 1) css_cur  @endif"><input type="radio" disabled="disabled" class="radio_f" value="1" @if($info['parent_order']['doc_type'] == 1) checked  @endif />外部链接</label>
                <label class="rd1 @if($info['parent_order']['doc_type'] == 2) css_cur  @endif"><input type="radio" disabled="disabled" class="radio_f" value="2" @if($info['parent_order']['doc_type'] == 2) checked  @endif />上传文档</label>
                <label class="rd1 @if($info['parent_order']['doc_type'] == 3) css_cur  @endif"><input type="radio" disabled="disabled" class="radio_f" value="3" @if($info['parent_order']['doc_type'] == 3) checked  @endif/>内部编辑</label>
            </div>
        </div>

        <div id="body_edit_type">
            <div id="body_edit_type">
                <div class="item_f" @if($info['parent_order']['doc_type'] == 1) style="display:block;" @else style="display: none" @endif>
                    <p><i class="LGntas"></i>外部链接：</p>
                    <div class="r">
                        <input type="text" class="txt_f1" style="width:75%;" value="{{ $info['parent_order']['content'] }}" />
                    </div>
                </div>
                <div class="item_f" @if($info['parent_order']['doc_type'] == 2) style="display:block;" @else style="display: none" @endif>
                    <p><i class="LGntas"></i>文档导入：</p>
                    <div class="r">
                        <a href="/{{ $info['parent_order']['content'] }}" target="view_window" class="txt_f1" style="line-height:45px; width:75%; float:left;">{{$info['parent_order']['content']}}</a >
                    </div>
                </div>
                <div class="item_f" @if($info['parent_order']['doc_type'] == 3) style="display:block;" @else style="display: none" @endif>
                    <p><i class="LGntas"></i>稿件需求：</p>
                    <div class="r">
                        <div class="txt_ft1">{!! $info['parent_order']['content'] !!}</div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="item_f"><p><i class="LGntas"></i>平台价：</p>
        <div class="r"><input type="text" name="user_money" id="textfield" class="txt_f1" style="width:16%;" readonly="readonly" value="{{ $info['supp_money'] }}" /><span class="color1" style="padding-left:10px;">元</span></div>
    </div>
    <div class="item_f"><p><i class="LGntas"></i>关键字：</p>
        <div class="r"><input type="text" name="keywords" id="textfield" class="txt_f1" style="width:75%;" readonly="readonly"  value="{{ $info['parent_order']['keywords'] }}" /></div>
    </div>
    <div class="item_f"><p><i class="LGntas"></i>订单备注：</p>
        <div class="r">
            <textarea class="txt_ft1" style="height:90px;" name="remark" readonly="readonly">{{ $info['parent_order']['remark'] }}</textarea>
        </div>
    </div>
    @if($info['order_type'] == 1)
        @include('console.supp.order_1')
    @elseif($info['order_type'] == 2)
        @include('console.supp.order_2') {{-- 拒单--}}
    @elseif($info['order_type'] == 3)
        {{-- 流单 --}}
        @include('console.supp.order_pub')
    @elseif($info['order_type'] == 4 && $info['deal_with_status'] != 2)
        @include('console.supp.order_pub')
    @elseif($info['order_type'] == 4 && $info['deal_with_status'] == 2)
        @include('console.supp.order_redoing')
    @elseif($info['order_type'] == 5) {{-- 供应商确认完成，等待广告主 --}}
        @include('console.supp.order_5')
    @elseif($info['order_type'] == 6) {{-- 供应商订单反馈回复，等待质量反馈或者确认完成--}}
        @include('console.supp.order_6')
    @elseif($info['order_type'] == 7) {{-- 广告主订单反馈，供应商回复 --}}
        @include('console.supp.order_7')
    @elseif($info['order_type'] == 8) 
        @include('console.supp.order_pub')
    @elseif($info['order_type'] == 9) 
        @include('console.supp.order_pub')
    @elseif($info['order_type'] == 10) {{-- 完成 --}}
        @include('console.supp.order_10')
    @elseif($info['order_type'] == 12 && $info['supp_status'] == 1)
        @include('console.supp.order_12_1') {{-- 广告主申请退款 供应商未接单 还未做响应 --}}
    @elseif($info['order_type'] == 12 && $info['supp_status'] == 2)
        @include('console.supp.order_12') {{-- 广告主申请退款 供应商未接单 还未做响应 --}}
    @elseif($info['order_type'] == 13 && $info['deal_with_status'] == 1){{-- 后台同意退款给广告主，关闭订单   --}}
        @include('console.supp.order_13') 
    @elseif($info['order_type'] == 13 && $info['deal_with_status'] == 3){{-- 后台同意退款给广告主，关闭订单   --}}
        @include('console.supp.order_13_3') 
    @elseif($info['order_type'] == 14) {{-- 不同意退款 --}}
        @include('console.supp.order_14')
    @elseif($info['order_type'] == 15) {{-- 同意退款 --}}
        @include('console.supp.order_14')
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
        $("#body_edit_type .item_f").eq(index).css("display","block").siblings().css("display","none");     
    });
    
function checkform() {
    var order_type = {{ $info['order_type'] }};
    if ( order_type == 4) {
        var success_url = $("#success_url_v").val();
        var success_pic = $("#success_pic_v").val();
        var count_msg = 0;

        if (!success_url) {
            ++count_msg;
            // layer.msg('必须填写完成链接');return false;
        }
        if (!success_pic) {
            ++count_msg;
            // layer.msg('必须上传完成截图');return false;
        }
        if (count_msg > 1) {
            layer.msg('完成链接或完成截图不得少于一项');return false;
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
