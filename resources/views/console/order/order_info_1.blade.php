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
                <div class="item_f" style="display:none;"><p><i class="LGntas"></i>供应商：</p>
                    <div class="r">
                    <input type="text" name="textfield" id="textfield" disabled="disabled" class="txt_f1" value="{{ $info['parent_order']['son_order']['0']['media_name']['media_name'] }}"></div>

                </div>
                @endif
                <input type="hidden" name="order_id" value="{{$info['id']}}">
                
                <div class="item_f"><p><i class="LGntas"></i>订单号：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" disabled="disabled" class="txt_f1" value="{{ $info['id'] }}"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>媒体名称：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" disabled="disabled" class="txt_f1" value="{{ $info['parent_order']['son_order']['0']['media_name']['media_name'] }}"></div>
                </div>
            <!--            @if($user['level_id'] == 2 && $is_parent)
                            <div class="item_f"><p><i class="LGntas"></i>所属用户：</p>
                                <div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" style="" value="{{$info['parent_order']['user']['name']}}" disabled="disabled"></div>
                            </div>
                            @endif
            -->
                <div class="item_f"><p><i class="LGntas"></i>订单状态：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" disabled="disabled" class="txt_f1" value="{{ getOrderType($info['order_type']) }}"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>稿件类型：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" disabled="disabled" class="txt_f1"  value="{{ $info['type_name'] }}"></div>
                </div>
                @if($info['parent_order']['cooperation_mode'])
                <div class="item_f"><p><i class="LGntas"></i>合作方式：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" disabled="disabled" class="txt_f1" value="{{ $info['parent_order']['cooperation_mode'] }}"></div>
                </div>
                @endif
                <div class="item_f"><p><i class="LGntas"></i>@if($info['type_id'] == 10) 直播标题@else 稿件名称@endif：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" disabled="disabled" class="txt_f1"  value="{{ $info['parent_order']['title'] }}" style="width:52%;"></div>
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
                        <label class="rd1 @if($info['parent_order']['doc_type'] ==1) css_cur @endif"><input type="radio" name="edit_type" class="radio_f" @if($info['parent_order']['doc_type'] ==1) checked="checked" @endif value="1" disabled />活动现场直播</label>
                        <label class="rd1 @if($info['parent_order']['doc_type'] ==2) css_cur @endif"><input type="radio" name="edit_type" class="radio_f" @if($info['parent_order']['doc_type'] ==2) checked="checked" @endif  value="2" disabled />产品使用</label>
                        <label class="rd1 @if($info['parent_order']['doc_type'] ==3) css_cur @endif"><input type="radio" name="edit_type" class="radio_f" @if($info['parent_order']['doc_type'] ==3) checked="checked" @endif  value="3" disabled />店铺体验</label>
                        <label class="rd1 @if($info['parent_order']['doc_type'] ==4) css_cur @endif"><input type="radio" name="edit_type" class="radio_f" @if($info['parent_order']['doc_type'] ==4) checked="checked" @endif  value="3" disabled />游戏直播</label>
                    </div>
                </div>
                <div class="item_f" style=""><p><i class="LGntas"></i>直播内容：</p>
                        <div class="r">
                            <!--    在订单详情页中，”订单内容项“ 根据编辑方式不同所显示的界面不同，具体排版与会员下单页界页一样 -->
                           
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
                <div class="item_f"><p><i class="LGntas"></i>编辑方式：</p>
                    <div class="r radio_w">
                        <label class="rd1 @if($info['parent_order']['doc_type'] ==1) css_cur @endif"><input type="radio" name="edit_type" class="radio_f" @if($info['parent_order']['doc_type'] ==1) checked="checked" @endif value="1" disabled />外部链接</label>
                        <label class="rd1 @if($info['parent_order']['doc_type'] ==2) css_cur @endif"><input type="radio" name="edit_type" class="radio_f" @if($info['parent_order']['doc_type'] ==2) checked="checked" @endif  value="2" disabled />上传文档</label>
                        <label class="rd1 @if($info['parent_order']['doc_type'] ==3) css_cur @endif"><input type="radio" name="edit_type" class="radio_f" @if($info['parent_order']['doc_type'] ==3) checked="checked" @endif  value="3" disabled />内部编辑</label>
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
                           <a href="/{{ $info['parent_order']['content'] }}" target="view_window" class="txt_f1" style="line-height:45px; width:75%; float:left;">{{$info['parent_order']['content']}}</a>
                        </div>
                    </div>
                    @elseif($info['parent_order']['doc_type'] ==3)
                    <div class="item_f" style=""><p><i class="LGntas"></i>稿件需求：</p>
                        <div class="r">
                            <!--    在订单详情页中，”订单内容项“ 根据编辑方式不同所显示的界面不同，具体排版与会员下单页界页一样 -->
                            <!-- <textarea class="txt_ft1" disabled>{{$info['parent_order']['content']}}</textarea> -->
                            <div class="dnts">{!! $info['parent_order']['content'] !!}</div>
                        </div>
                    </div>
                    @endif
                </div>
                @endif
                
                <div class="item_f"><p><i class="LGntas"></i>关键字：</p>
                    <div class="r"><input type="text" name="keyword" id="" class="txt_f1" style="width:75%;" disabled value="{{ $info['parent_order']['keywords'] }}"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>订单备注：</p>
                    <div class="r">
                        <textarea class="txt_ft1" style="height:90px;" disabled>{{$info['parent_order']['remark']}}</textarea>
                    </div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>确认订单：</p>
                    <div class="r">
                        <select id="order_status" name="order_status" class="sel_f1" style="float:left;margin-right:8px;" onchange="selectDeal(this)">
                            {{-- 供应商确认完成 --}}
                            <option value="-1">等待预约</option>
                            <option value="12">申诉退款</option>
                        </select>
                    </div>
                </div>
                <div class="item_f" id="refund" style="display:none;"><p><i class="LGntas"></i>退款原因：</p>          
                    <!--    当会员需要对订单有异议时    -->
                    <div class="r">
                        <textarea class="txt_ft1" name="refund_reason" style="height:100px;"></textarea>
                    </div>
                </div>
                {{-- 按钮的显示控制 --}}
                <div class="item_f item_f_2" style="margin-left:-157px;">
                    <div class="r"><input id="sub" type="button" value="等待预约" class="sub5"></div>
                </div>             

            </form>
            
        </div>

    </div>  
    <script type="text/javascript">
        function selectDeal(obj) {
            var val = $(obj).val();
            if (val == '-1') {
                $("#sub").val('等待预约');
                $("#sub").attr('type','button');
                $("#refund").hide();
            } else {
                $("#sub").val('提交');
                $("#refund").show();
                $("#sub").attr('type','submit');
            }
        }
    </script>