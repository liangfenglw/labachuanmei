  <div class="clearfix wrap_f" style="padding-bottom:50px;">
            <form action="" method="post">
                {{ csrf_field() }}
                <div class="item_f"><p><i class="LGntas"></i>订单号：</p>
                    <div class="r"><input type="text" name="id" class="txt_f1" value="{{ $info['id'] }}" readonly="readonly"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>所属用户：</p>
                    <div class="r"><input type="text"  class="txt_f1" value="{{ $info['ad_user']['nickname'] or '' }}" readonly="readonly"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>供应商：</p>
                    <div class="r">
                        <input type="text" readonly="readonly" class="txt_f1" value="{{$info['supp_user']['parent_user']['user']['name'] or ''}}">
                    </div>
                </div>
               {{--  <div class="item_f"><p><i class="LGntas"></i>接单媒体：</p>
                    <div class="r">
                        <input type="text" readonly="readonly" class="txt_f1" value="{{$info['supp_user']['name'] or ''}}">
                    </div>
                </div> --}}
                

                <div class="item_f"><p><i class="LGntas"></i>媒体名称：</p>
                    <div class="r">
                        <input type="text" readonly="readonly" class="txt_f1" value="{{$info['supp_user']['media_name']}}">
                    </div>
                </div>              
                <div class="item_f"><p><i class="LGntas"></i>订单状态：</p>
                    <div class="r">
                    <input type="text" class="txt_f1" value="{{ getOrderType($info['order_type']) }}" readonly="readonly"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>稿件类型：</p>
                    <div class="r"><input type="text" readonly="readonly"  value="{{ $info['type_name'] }}" id="textfield" class="txt_f1"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>稿件名称：</p>
                    <div class="r"><input type="text" readonly="readonly" value="{{ $info['parent_order']['title'] }}" id="textfield" class="txt_f1" style="width:52%;"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>开始时间：</p>
                    <div class="r"><input type="text" readonly="readonly" id="datepicker1" class="txt_f1" value="{{ $info['parent_order']['start_at'] }}"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>结束时间：</p>
                    <div class="r"><input type="text" readonly="readonly" id="datepicker2" class="txt_f1" value="{{ $info['parent_order']['over_at'] }}"></div>
                </div>
                
                <div class="item_f"><p><i class="LGntas"></i>编辑方式：</p>
                    <div class="r radio_w">
                        <label class="rd1 @if($info['parent_order']['doc_type'] == 1) css_cur  @endif"><input type="radio" disabled="disabled" class="radio_f" value="1" @if($info['parent_order']['doc_type'] == 1) checked  @endif />外部链接</label>
                        <label class="rd1 @if($info['parent_order']['doc_type'] == 2) css_cur  @endif"><input type="radio" disabled="disabled" class="radio_f" value="2" @if($info['parent_order']['doc_type'] == 2) checked  @endif />上传文档</label>
                        <label class="rd1 @if($info['parent_order']['doc_type'] == 3) css_cur  @endif"><input type="radio" disabled="disabled" class="radio_f" value="3" @if($info['parent_order']['doc_type'] == 3) checked  @endif/>内部编辑</label>
                    </div>
                </div>
                <div id="body_edit_type">
                    <div class="item_f" @if($info['parent_order']['doc_type'] == 1) style="display:block;" @else style="display: none" @endif><p><i class="LGntas"></i>外部链接：</p>
                        <div class="r">
                            <input type="text" class="txt_f1" style="width:75%;" value="{{ $info['parent_order']['content'] }}" />
                        </div>
                    </div>
                    <div class="item_f" @if($info['parent_order']['doc_type'] == 2) style="display:block;" @else style="display: none" @endif><p><i class="LGntas"></i>文档导入：</p>
                        <div class="r">
                            <a href="/{{ $info['parent_order']['content'] }}" target="view_window" class="txt_f1" style="line-height:45px; width:75%; float:left;">{{$info['parent_order']['content']}}</a >
                        </div>
                    </div>
                    <div class="item_f" @if($info['parent_order']['doc_type'] == 3) style="display:block;" @else style="display: none" @endif><p><i class="LGntas"></i>稿件需求：</p>
                        <div class="r">
                            <!--    在订单详情页中，”订单内容项“ 根据编辑方式不同所显示的界面不同，具体排版与会员下单页界页一样 -->
                            <textarea class="txt_ft1">{{ $info['parent_order']['content'] }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="item_f"><p><i class="LGntas"></i>关键字：</p>
                    <div class="r"><input type="text" name="keyword" id="" class="txt_f1" style="width:75%;" value="{{ $info['parent_order']['keywords'] }}"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>订单备注：</p>
                    <div class="r">
                        <textarea class="txt_ft1" style="height:90px;">{{ $info['parent_order']['remark'] }}</textarea>
                    </div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>媒体价格：</p>
                    <div class="r"><input type="text" class="txt_f1" style="width:16%;" value="{{ $info['supp_user']['proxy_price'] }}" readonly="readonly" /><span class="color1" style="padding-left:10px;">元</span></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>平台价：</p>
                    <div class="r">
                        <input type="text" name="textfield" id="textfield" class="txt_f1" style="width:16%;" value="{{ $info['self_user']['plate_price'] }}" readonly="readonly" /><span class="color1" style="padding-left:10px;">元</span>
                        <span class="info2_f" style="line-height:24px;">
                            <i>*</i> 普通会员价格
                        </span>
                    </div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>会员价：</p>
                    <div class="r">
                        <input type="text" name="textfield" id="textfield" class="txt_f1" style="width:16%;" value="{{ $info['self_user']['vip_price'] }}" readonly="readonly" /><span class="color1" style="padding-left:10px;">元</span>
                        <span class="info2_f" style="line-height:24px;">
                            <i>*</i> 高级会员价格
                        </span>
                    </div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>会员佣金：</p>
                    <div class="r">
                        <input type="text" name="textfield" id="textfield" class="txt_f1" style="width:16%;" value="{{ $info['commission'] }}" readonly="readonly" /><span class="color1" style="padding-left:10px;">元</span>
                        <span class="info2_f" style="line-height:24px;">
                            <i>*</i> 高级会员赚取的佣金
                        </span>
                    </div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>平台获利：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" style="width:16%;" value="{{ $info['platform'] }}" readonly="readonly" /><span class="color1" style="padding-left:10px;">元</span>
                        <span class="info2_f" style="line-height:24px;">
                            <i>*</i> 平台赚取的盈利
                        </span>
                    </div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>完成链接：</p>
                    <div class="r"><input type="text" readonly="readonly" name="textfield" id="textfield" class="txt_f1" style="width:75%;" value="{{$info['success_url']}}" /></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>完成截图：</p>
                    <div class="r" style="position:relative;">
                        @if($info['success_pic'])
                            <img src="{{ $info['success_pic'] }}" id="img_upload" style="cursor:pointer;float:left;margin-right:8px;width: 50%" />
                        @else
                            <img src="/console/images/z_add2.png" id="img_upload" style="cursor:pointer;float:left;margin-right:8px;" />
                        @endif
                        
                    </div>
                </div>
<!--            <div class="item_f"><p><i class="LGntas"></i>订单总金额：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" style="width:16%;" value="{{ $info['user_money'] }}" readonly="readonly" /><span class="color1" style="padding-left:10px;">元</span></div>
                </div>
-->
              {{--   <div class="item_f"><p><i class="LGntas"></i>质量反馈：</p>
                    <div class="r">
                        <select class="sel_f1">
                        @foreach($qa_desc as $key => $val)
                            <option @if($key == $info['qa_feedback']) selected="selected" @endif >{{$val}}</option>
                        @endforeach
                        </select>
                    </div>
                </div> --}}
<!--            <div class="item_f"><p><i class="LGntas"></i>确认订单：</p>
                    <div class="r">
                        <select class="sel_f1" style="float:left;margin-right:8px;">
                            <option value="1">{{getOrderType($info['order_type'])}}</option>
                        </select>
                    </div>
                </div>
-->

                @if($info['order_feedback'])
                    <div class="item_f"><p><i class="LGntas"></i>申诉原因：</p>      
                    <!--    当会员需要对订单有异议时    -->
                        <div class="r">
                            <textarea class="txt_ft1" style="height:100px;">{{ $info['order_feedback'] }}</textarea>
                        </div>
                    </div>
                @endif
                @if($info['refund_reason'])
                    <div class="item_f"><p><i class="LGntas"></i>退款原因：</p>      <!--    退款订单详情显示    -->
                        <div class="r">
                            <textarea class="txt_ft1" style="height:90px;">{{ $info['refund_reason'] }}</textarea>
                        </div>
                    </div>
                @endif
                @if(in_array($info['order_type'], [13,14,15]))
                <div class="item_f"><p><i class="LGntas"></i>供应商退款状态：</p>   
                <!--   当供应商选择同意退款时只显示同意，当供应商选择不同意时，显示同意、不同意两个单选项   -->
                    <div class="r radio_w">
                        @if($info['order_type'] == 15)
                            <label class="rd1 css_cur"><input type="radio" class="radio_f"/>同意</label>
                        @elseif($info['order_type'] == 14)
                             <label class="rd1 css_cur"><input type="radio" class="radio_f"/>不同意</label>
                        @elseif($info['supp_refund_status'] == 1)
                            <label class="rd1 css_cur"><input type="radio" class="radio_f"/>同意</label>
                        @endif
                    </div>
                </div>
                @elseif($info['order_type'] == 12)
                    <div class="item_f"><p><i class="LGntas"></i>供应商退款状态：</p>   
                        <div class="r radio_w">
                            等待供应商反馈暂不可操作
                        </div>
                    </div>
                @endif
                @if($info['deal_with_status'] > 0)
                    <div class="item_f"><p><i class="LGntas"></i>平台退款状态：</p>     
                    <!--    当供应商选择同意退款时只显示同意，当供应商选择不同意时，显示同意、不同意两个单选项   -->
                        <div class="r radio_w">
                            @if($info['deal_with_status'] == 1)
                                <label class="rd1 css_cur"><input type="radio" class="radio_f" value="" />同意</label>
                            @elseif($info['deal_with_status'] == 3)
                                <label class="rd1 css_cur"><input type="radio" class="radio_f" value="" />不同意</label>
                            @endif
                        </div>
                    </div>
                @endif

                @if(in_array($info['order_type'], [9])) {{-- 申诉 --}}
                    <!--    管理员选择重做，那该条订单的完成链接，完成截图重新开放填写、状态改为正执行   -->
                    <div class="item_f">
                        <p><i class="LGntas"></i>处理方式：</p>
                        <div class="r">
                            <select class="sel_f1" name="deal_with">
                                <option selected="selected" value="1">退款</option>
                                <option value="2">重做</option>
                                <option value="3">不同意，并结款</option>
                            </select>
                        </div>
                    </div>
                @elseif(in_array($info['order_type'], [14,15]))
                    <div class="item_f">
                        <p><i class="LGntas"></i>处理方式：</p>
                        <div class="r">
                            <select class="sel_f1" name="deal_with">
                                <option selected="selected" value="1">同意退款</option>
                                <option value="3">不同意，并结款</option>
                            </select>
                        </div>
                    </div>
                @elseif(in_array($info['order_type'], [12]) && empty($info['supp_user_id'])) {{-- 取消订单 --}}
                    <div class="item_f">
                        <p><i class="LGntas"></i>处理方式：</p>
                        <div class="r">
                            <select class="sel_f1" name="deal_with">
                                <option selected="selected" value="1">同意退款</option>
                                {{-- <option value="3">不同意，并结款</option> --}}
                            </select>
                        </div>
                    </div>
                @endif
                
                
                    <div class="item_f item_f_2" style="margin-top:20px;">
                        <div class="r"><input type="button" value="完结" class="sub5" style="margin-left:0;"></div>
                    </div>
            </form>
            
        </div>