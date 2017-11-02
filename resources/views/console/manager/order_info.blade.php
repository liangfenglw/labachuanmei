<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>订单详情</title>
    @include('console.share.cssjs')
<style>
.tab2 ul li a {
    font-size: 24px;
    color: #2f4050;
}
</style>
</head>
<body class="fold">
@include('console.share.admin_head')
@include('console.share.admin_menu')
<div class="content"><div class="Invoice">
    <div class="place">
        <div class="place_ant">
            <a href="/console/index">首页</a>
            <a href="/console/manager/order/35">订单管理 </a>
            <a  class="cur">订单详情 </a>
        </div>
    </div>
    <div class="main_o">
        <h3 class="title4 clearfix">
			<div class="tab2" style="float:left;">
				<ul class="clearfix" style="float:left;">
					<li class="cur"><a href="javascript:void(0);">我的订单</a></li>
					<li class=""><a href="/console/managerOrder/selectMedia?order_id={{ $info['id'] }}">媒体选择</a></li>
				</ul>
			</div>
		</h3>
        @if($info['order_type'] == 12 && $info['deal_with_status'] == 0 && $info['supp_status'] != 1) {{-- 广告主申请退款 供应商暂未同意 --}}
            @include('console.manager.order_info_1')
        @elseif($info['order_type'] == 13 && $info['deal_with_status'] == 1 && $info['supp_status'] != 1) {{-- 后台允许退款 完单 --}}
            @include('console.manager.order_info_2')
        @elseif($info['order_type'] == 12 && $info['supp_status'] == 1)
            @include('console.manager.order_info_3')
        @elseif($info['order_type'] == 13 && $info['supp_status'] == 1)
            {{-- 关闭订单，供应商还未接受订单，广告主取消 --}}
            @include('console.manager.order_info_4')
        @else
            @include('console.manager.order_info_pub')
        @endif

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
        // console.log(index);
        // console.log(value);
        $("#body_edit_type .item_f").eq(index).css("display","block").siblings().css("display","none");     
    });
    
$(function(){

});


</script>

</body>
</html>
