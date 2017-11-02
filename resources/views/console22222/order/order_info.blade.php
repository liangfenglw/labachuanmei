<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>任—订单详情 - 亚媒社</title>
    @include('console.share.cssjs')
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')
<div class="content"><div class="Invoice">
    <div class="place">
        当前位置：<a href="/console/index">首页</a> > <a href="/order/order_list">订单管理</a> > 订单详情
    </div>
    <div class="main_o">
        <h3 class="title5 clearfix"><strong>我的订单</strong></h3>
        <div class="clearfix wrap_f" style="padding-bottom:50px;">
            <form action="" method="post">
        {{ csrf_field() }} 
            @if($order_count_all>1)
                <div class="item_f"><p><i class="LGntas"></i>子订单列表：</p>
                    <div class="r">
                        <select  id="order_id"  class="sel_f1" onchange="skip_order()"  style="float:left;margin-right:8px;">
                        @foreach($info['parent_order']['son_order'] as $key =>$value)
                            <option value="{{$value['id']}}" @if($info['id'] == $value['id']) selected @endif>{{$value['media_name']['media_name']}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                @else
                <div class="item_f"><p><i class="LGntas"></i>供应商：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" disabled="disabled" class="txt_f1" value="{{ $info['parent_order']['son_order'][0]['media_name']['media_name'] }}"></div>
                </div>
                @endif
                <input type="hidden" name="order_id" value="{{$info['id']}}">
                <div class="item_f"><p><i class="LGntas"></i>订单号：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" disabled="disabled" class="txt_f1" value="{{ $info['id'] }}"></div>
                </div>
                @if($user['level_id'] == 2 && $is_parent)
                <div class="item_f"><p><i class="LGntas"></i>所属用户：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" style="" value="{{$info['parent_order']['user']['name']}}" disabled="disabled"></div>
                </div>
                @endif
                <div class="item_f"><p><i class="LGntas"></i>订单状态：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" disabled="disabled" class="txt_f1" value="{{ getOrderType($info['order_type']) }}"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>活动类型：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" disabled="disabled" class="txt_f1" value="{{ $info['type_name'] }}"></div>
                </div>
                @if($info['parent_order']['cooperation_mode'])
                <div class="item_f"><p><i class="LGntas"></i>合作方式：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" disabled="disabled" class="txt_f1" value="{{ $info['parent_order']['cooperation_mode'] }}"></div>
                </div>
                @endif
                <div class="item_f"><p><i class="LGntas"></i>@if($info['type_id'] == 10) 直播标题@else 活动名称@endif：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" disabled="disabled" class="txt_f1" value="{{ $info['parent_order']['title'] }}"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>订单总价：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" style="width:16%;" value="{{$info['parent_order']['user_money']}}" disabled /><span class="color1" style="padding-left:10px;">元</span></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>开始时间：</p>
                    <div class="r"><input type="text" name="textfield" id="datepicker1" disabled="disabled" class="txt_f1" value="{{ $info['parent_order']['start_at'] }}"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>结束时间：</p>
                    <div class="r"><input type="text" name="textfield" id="datepicker2" disabled="disabled" class="txt_f1" value="{{ $info['parent_order']['over_at'] }}"></div>
                </div>
                @if($info['type_id'] == 10) 
                <div class="item_f"><p><i class="LGntas"></i>具体形式：</p>
                    <div class="r radio_w">
                        <label><input type="radio" name="edit_type" class="radio_f" @if($info['parent_order']['doc_type'] ==1) checked="checked" @endif value="1" disabled />活动现场直播</label>
                        <label><input type="radio" name="edit_type" class="radio_f" @if($info['parent_order']['doc_type'] ==2) checked="checked" @endif  value="2" disabled />产品使用</label>
                        <label><input type="radio" name="edit_type" class="radio_f" @if($info['parent_order']['doc_type'] ==3) checked="checked" @endif  value="3" disabled />店铺体验</label>
                        <label><input type="radio" name="edit_type" class="radio_f" @if($info['parent_order']['doc_type'] ==4) checked="checked" @endif  value="3" disabled />游戏直播</label>
                    </div>
                </div>
                 <div class="item_f" style=""><p><i class="LGntas"></i>直播内容：</p>
                        <div class="r">
                            <!--    在订单详情页中，”订单内容项“ 根据编辑方式不同所显示的界面不同，具体排版与会员下单页界页一样 -->
                           
                            <div>{!! $info['parent_order']['content'] !!}</div>
                        </div>
                    </div>

                <div class="item_f"><p><i class="LGntas"></i>直播地点：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" disabled="disabled" class="txt_f1" value="{{ $info['parent_order']['cooperation_place'] }}"></div>
                </div>
                @if($info['parent_order']['sale_file'])
                    <div class="item_f" style=""><p><i class="LGntas"></i>上传附件：</p>
                        <div class="r">
                           <a href="/{{$info['parent_order']['sale_file']}}" target="view_window">{{$info['parent_order']['sale_file']}}</a>
                        </div>
                    </div>
                @endif
                @else
                <div class="item_f"><p><i class="LGntas"></i>编辑方式：</p>
                    <div class="r radio_w">
                        <label><input type="radio" name="edit_type" class="radio_f" @if($info['parent_order']['doc_type'] ==1) checked="checked" @endif value="1" disabled />外部连接</label>
                        <label><input type="radio" name="edit_type" class="radio_f" @if($info['parent_order']['doc_type'] ==2) checked="checked" @endif  value="2" disabled />上传文档</label>
                        <label><input type="radio" name="edit_type" class="radio_f" @if($info['parent_order']['doc_type'] ==3) checked="checked" @endif  value="3" disabled />内部编辑</label>
                    </div>
                </div>

                
                <div id="body_edit_type">
                    @if($info['parent_order']['doc_type'] ==1)
                    <div class="item_f" style=""><p><i class="LGntas"></i>外部链接：</p>
                        <div class="r">
                            <input disabled type="text" name="textfield" id="textfield" value="{{$info['parent_order']['content']}}" class="txt_f1" style="width:75%;" />
                        </div>
                    </div>
                    @elseif($info['parent_order']['doc_type'] ==2)
                    <div class="item_f" style=""><p><i class="LGntas"></i>文档导入：</p>
                        <div class="r">
                           <a href="/{{ $info['parent_order']['sale_file'] }}" target="view_window">{{$info['parent_order']['sale_file']}}</a>
                        </div>
                    </div>
                    @elseif($info['parent_order']['doc_type'] ==3)
                    <div class="item_f" style=""><p><i class="LGntas"></i>活动需求：</p>
                        <div class="r">
                            <!--    在订单详情页中，”订单内容项“ 根据编辑方式不同所显示的界面不同，具体排版与会员下单页界页一样 -->
                            <!-- <textarea class="txt_ft1" disabled>{{$info['parent_order']['content']}}</textarea> -->
                            <div>{!! $info['parent_order']['content'] !!}</div>
                        </div>
                    </div>
                    @endif
                </div>
                @endif
                
                <div class="item_f"><p><i class="LGntas"></i>订单备注：</p>
                    <div class="r">
                        <textarea class="txt_ft1" style="height:90px;" disabled>{{$info['parent_order']['remark']}}</textarea>
                    </div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>平台价：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" style="width:16%;" value="{{$info['user_money']}}" disabled /><span class="color1" style="padding-left:10px;">元</span></div>
                </div>

                @if($info['order_type'] == 5 && $is_parent == 0)
                <div class="item_f"><p><i class="LGntas"></i>质量反馈：</p>
                    <div class="r">
                        <select name="qa_feedback" class="sel_f1">
                            <option value="1">优</option>
                            <option value="2">中</option>
                            <option value="3">差</option>
                        </select>
                    </div>
                </div>
                @endif
                <div class="item_f"><p><i class="LGntas"></i>完成链接：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" disabled value="{{$info['success_url']}}"  class="txt_f1" style="width:75%;" /></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>完成截图：</p>
                    <div class="r" style="position:relative;">
                    @if($info['success_pic'])
                        <img src="{{$info['success_pic']}}" id="img_upload" style="cursor:pointer;float:left;margin-right:8px;width:50%;" />
                        @endif
                    </div>
                </div>
                @if(($info['order_type'] ==1 || $info['order_type'] ==6 || $info['order_type'] ==5)  && $is_parent == 0)
                <div class="item_f"><p><i class="LGntas"></i>确认订单：</p>
                    <div class="r">
                        <select class="sel_f1" name="order_status" style="float:left;margin-right:8px;">
                            @if($info['order_type'] == 1)
                            <option value="1">取消订单</option>
                            @endif

                            @if($info['order_type'] == 6)
                            <option value="6">订单反馈</option>
                            @endif
                            @if($info['order_type'] == 5)
                            <option value="5">质量反馈</option>
                            @endif
                            @if($info['order_type'] == 5)
                            <option value="4">完成订单</option>
                            @endif
                        </select>
                    </div>
                </div>
                @endif
                @if(($info['order_type'] == 6 || $info['order_type'] == 5) && $is_parent == 0)
                <div class="item_f"><p><i class="LGntas"></i>订单反馈：</p>
                    <div class="r">
                        <!--    确认订单项为：确认完成后面两项为隐藏，否则为显示    -->
                        <textarea class="txt_ft1" style="height:100px;" name="order_feedback"></textarea>
                    </div>
                </div>
                @endif
                @if($is_parent == 1)
                <div class="item_f"><p><i class="LGntas"></i>订单反馈：</p>
                    <div class="r">
                        <!--    确认订单项为：确认完成后面两项为隐藏，否则为显示    -->
                        <textarea class="txt_ft1" style="height:100px;" name="order_feedback" disabled>{{$info['supp_feedback']}}</textarea>
                    </div>
                </div>
                @endif
                @if($info['supp_feedback'])
                <div class="item_f"><p><i class="LGntas"></i>供应商反馈：</p>
                    <div class="r">
                        <textarea class="txt_ft1" style="height:100px;" disabled>{{$info['supp_feedback']}}</textarea>
                    </div>
                </div>
                @endif
                @if($info['qa_change'])
                <div class="item_f"><p><i class="LGntas"></i>质检扣款：</p>
                    <div class="r"><input type="text" name="textfield" disabled value="{{$info['qa_change']}}" id="textfield" class="txt_f1" style="width:16%;" /><span class="color1" style="padding-left:10px;">元</span></div>
                </div>
                @endif
                @if(($info['order_type'] ==1 || $info['order_type'] ==6 || $info['order_type'] ==5) && $is_parent == 0)
                <div class="item_f item_f_2" style="margin-top:50px;">
                    <div class="r"><input type="submit" value="确 认" class="sub_f1"></div>
                </div>
                @endif
                @if($info['order_type'] ==8 && $is_parent == 0)
                <div class="item_f item_f_2" style="margin-top:50px;">
                    <div class="r"><input type="button" value="订单申诉" onclick="window.location.href='/order/order_appeal?id={{$info['id']}}'" class="sub_f1"></div>
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

    function skip_order () {
        var order_id = $("#order_id").val();
        location.href = "/order/order_detail/"+order_id;
    }
    
$(function(){

});


</script>

</body>
</html>
