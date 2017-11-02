<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>订单管理</title>
    @include('console.share.cssjs')
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')

<div class="content"><div class="Invoice">

    <div class="place" data-order_type="{{$info['order_type']}}">
         <div class="place_ant"><a href="/console/index">首页</a><a href="/supp/order" class="cur">订单管理 </a></div>
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
{{--  --}}

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
