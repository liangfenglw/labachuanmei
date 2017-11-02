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
                    @if($info['parent_order']['content'])
                        <div class="item_f" style=""><p><i class="LGntas"></i>上传附件：</p>
                            <div class="r">
                               <a href="/{{$info['parent_order']['content']}}" target="view_window" class="txt_f1" style="line-height:45px; width:75%; float:left;">{{$info['parent_order']['content']}}</a>
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
                           <a href="/{{ $info['parent_order']['sale_file'] }}" target="view_window" class="txt_f1" style="line-height:45px; width:75%; float:left;">{{$info['parent_order']['sale_file']}}</a>
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
                @if($info['success_url'])
                <div class="item_f"><p><i class="LGntas"></i>完成链接：</p>
                    <div class="r"><input type="text" name="success_url" id="success_url" class="txt_f1" style="width:75%;" value="{{$info['success_url']}}" /></div>
                </div>
                @endif
                @if($info['success_pic'])
                <div class="item_f" id="success_pic">
                        <p><i class="LGntas"></i>完成截图：</p>
                        <div class="r" style="position:relative;">
                            <div class="img_show">
                                <img src="{{ $info['success_pic'] or '/console/images/z_add2.png' }}" id="img_upload" style="cursor:pointer;float:left;margin-right:8px; width:130px; height:130px;" />
                               {{--  <input type="file" id="success_pic_v" name="success_pic" id="documents_upload_button" placeholder="未选择任何文件" accept="image/jpg,image/jpeg,image/png" class="txt6 txt6_up upfile upload_f1" style="width:130px;height:130px;display:none;opacity:0;"  /> --}}
                            </div>
                            <span class="info1_f valign_m" style="height:95px;padding:0;">
                                <i>*</i> 请点击选择图片，仅支持 JPG、JPEG、GIF、<br/>PNG 格式的图片文件，文件不能大于 2MB。
                            </span>
                        </div>
                    </div>
                @endif
                @if(in_array($info['order_type'], ['5'])) {{-- 供应商确认完成 --}}
                    <div class="item_f"><p><i class="LGntas"></i>确认订单：</p>
                        <div class="r">
                            <select onchange="selectDeal(this)" name="order_status" class="sel_f1" style="float:left;margin-right:8px;">
                                <option value="10">确认完成</option>
                                <option value="9">申诉</option>
                            </select>
                        </div>
                    </div>
                    <div class="item_f" id="ddfk2" style="display: none;">
                    <p><i class="LGntas"></i>申诉原因：</p>      <!--    当会员需要对订单有异议时    -->
                        <div class="r">
                            <textarea class="txt_ft1" name="order_feedback" style="height:100px;"></textarea>
                        </div>
                    </div>
                    <script type="text/javascript">
                        function selectDeal(obj) {
                            var val = $(obj).val();
                            if (val == 9) {
                                $("#ddfk2").show();
                            } else {
                                $("#ddfk2").hide();
                            }
                        }
                    </script>
                @elseif(in_array($info['order_type'], ['9'])) {{-- 申诉中 --}}
                    <div class="item_f"><p><i class="LGntas"></i>确认订单：</p>
                        <div class="r">
                            <select id="qrdd" name="order_status" class="sel_f1" style="float:left;margin-right:8px;">
                                {{-- 供应商确认完成 --}}
                                <option value="1">申诉中</option>
                            </select>
                        </div>
                    </div>
                @elseif(in_array($info['order_type'], [4,11]))
                    <div class="item_f"><p><i class="LGntas"></i>确认订单：</p>
                        <div class="r">
                            <select name="order_status" class="sel_f1" onchange="selectDeal(this)" style="float:left;margin-right:8px;">
                                {{-- 供应商确认完成 --}}
                                
                                @if($info['order_type'] == 4 && $info['deal_with_status'] == 2)
                                    <option value="12">正在重做</option>
                                @else
                                    <option value="0">请选择</option>
                                    <option value="12">申请退款</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    
                    <script type="text/javascript">
                        function selectDeal(obj) {
                            var val = $(obj).val();
                            if (val == 12) {
                                $("#refund").show();
                            } else {
                                $("#refund").hide();
                            }
                        }
                    </script>
                    <div class="item_f" id="refund" style="display:none;"><p><i class="LGntas"></i>退款原因：</p>          
                        <!--    当会员需要对订单有异议时    -->
                        <div class="r">
                            <textarea class="txt_ft1" name="refund_reason" style="height:100px;"></textarea>
                        </div>
                    </div>
                @elseif(in_array($info['order_type'], [1]))
                    <div class="item_f" id="refund" style="display:none;"><p><i class="LGntas"></i>退款原因：</p>          
                        <!--    当会员需要对订单有异议时    -->
                        <div class="r">
                            <textarea class="txt_ft1" name="refund_reason" style="height:100px;"></textarea>
                        </div>
                    </div>
                @endif
                @if($info['order_feedback'])
                    <div class="item_f" id="" style="display: block;">
                    <p><i class="LGntas"></i>申诉原因：</p>      <!--    当会员需要对订单有异议时    -->
                        <div class="r">
                            <textarea class="txt_ft1" name="" style="height:100px;">{{ $info['order_feedback'] }}</textarea>
                        </div>
                    </div>
                @endif
                @if($info['refund_reason'])

                <div class="item_f" id="refund"><p><i class="LGntas"></i>退款原因：</p>          
                    <!--    当会员需要对订单有异议时    -->
                    <div class="r">
                        <textarea class="txt_ft1" name="refund_reason" style="height:100px;">{{ $info['refund_reason'] }}</textarea>
                    </div>
                </div>
                @endif

               
                
                {{-- 按钮的显示控制 --}}
                <div class="item_f item_f_2" style="margin-left:-157px;">
                    @if($info['order_type'] == 9)
                        <div class="r"><input type="button" value="申诉中" onclick="layer.msg('申诉中，暂不可操作')" class="sub5"></div>
                    @elseif($info['order_type'] == 12)
                        <div class="r"><input type="button" value="申请退款中" onclick="layer.msg('申请退款，暂不可操作')" class="sub5"></div>
                    @elseif($info['order_type'] == 10)
                         <div class="r"><input type="button" value="交易完成" onclick="layer.msg('订单已完成，暂不可操作')" class="sub5"></div>
                    @elseif($info['order_type'] == 13 && $info['deal_with_status'] != 1)
                         <div class="r"><input type="button" value="对方取消订单" onclick="layer.msg('对方取消订单，暂不可操作')" class="sub5"></div>
                    @elseif($info['order_type'] == 13 && $info['deal_with_status'] == 1)
                        <div class="r"><input type="button" value="退款完成" onclick="layer.msg('退款完成')" class="sub5"></div>
                    @elseif($info['order_type'] == 4 && $info['deal_with_status'] == 2)
                        <div class="r"><input id="sub" type="button" onclick="layer.msg('对方正在重做')" value="重做中" class="sub5"></div>
                    @elseif($info['order_type'] == 1)
                        <div class="r"><input id="sub" type="button" onclick="layer.msg('等待对方接受')" value="等待接受" class="sub5"></div>
                    @else
                        <div class="r"><input id="sub" type="submit" value="确 认" class="sub5"></div>
                    @endif
                </div>
                <script>
                    $("#qrdd").change(function(){
                        if($(this).val()=='9'){
                            $('#ddfk').show();
                        }else{
                            $('#ddfk').hide();
                        }
                    });
                    if( $("#qrdd").val()=='1' ){
                        $('#ddfk').show();
                    }else{
                        $('#ddfk').hide();
                    }
                </script>               

            </form>
            
        </div>

    </div>  