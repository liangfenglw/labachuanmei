<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>订单详情_喇叭传媒</title>
    @include('console.share.cssjs')
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')
<div class="content">
    <div class="Invoice">
    <div class="place">
        <div class="place_ant"><a href="/console/index">首页</a><a href="/order/order_list" class="cur">订单管理 </a></div>
    </div>
    {{-- {{dd($info)}} --}}
    @if(in_array($info['order_type'], [1,11]) == 13) {{-- 供应商未接受 --}}
        @include('console.order.order_info_1')
    @elseif(in_array($info['order_type'], [4]) && $info['deal_with_status'] == 0) {{-- 供应商接单 --}}
        @include('console.order.order_info_2')
    @elseif($info['order_type'] == 12 && $info['supp_status'] == 1) {{-- 供应商未接单，取消订单 --}}
        @include('console.order.order_info_3')
    @elseif($info['order_type'] == 14 && $info['supp_refund_status'] == 2) {{--- 申请退款，供应商不同意 等待平台发落 --}}
        @include('console.order.order_info_4')
    @elseif($info['order_type'] == 13 && $info['deal_with_status'] == 3) {{--- 不同意申诉，退款失败 --}}
        @include('console.order.order_info_5')
    @else
        @include('console.order.order_pub')
    @endif

    </div>
</div>

@include('console.share.admin_foot')
<script type="text/javascript">
/*  日历  */
    function sel_order_type(obj)
    {
        var order_type = $(obj).val();
        alert(order_type);
        if (order_type == 5) {
            $("#qa_feedback").show();
            $("#order_feedback").hide();
        } else {
            $("#qa_feedback").hide();
            $("#order_feedback").show();
        }
    }

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

    function skip_order () {
        var order_id = $("#order_id").val();
        location.href = "/order/order_detail/"+order_id;
    }
    


</script>

</body>
</html>
