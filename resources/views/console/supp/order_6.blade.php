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
                <div class="item_f"><p><i class="LGntas"></i>开始时间：</p>
                    <div class="r"><input type="text" name="textfield" id="datepicker1" class="txt_f1" disabled="disabled" value="{{ $info['parent_order']['start_at'] }}"></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>结束时间：</p>
                    <div class="r"><input type="text" name="textfield" id="datepicker2" class="txt_f1" disabled="disabled" value="{{ $info['parent_order']['over_at'] }}"></div>
                </div>
                
                <div class="item_f"><p><i class="LGntas"></i>编辑方式：</p>
                    <div class="r radio_w">
                        <label class="rd1 @if($info['parent_order']['doc_type'] == 1) css_cur @endif"><input type="radio" name="edit_type" class="radio_f" value="1" @if($info['parent_order']['doc_type'] == 1) checked @endif  disabled="disabled" />外部连接</label>
                        <label class="rd1 @if($info['parent_order']['doc_type'] == 2) css_cur @endif"><input type="radio" name="edit_type" class="radio_f" value="2" @if($info['parent_order']['doc_type'] == 2) checked @endif disabled="disabled" />上传文档</label>
                        <label class="rd1 @if($info['parent_order']['doc_type'] == 3) css_cur @endif"><input type="radio" name="edit_type" class="radio_f" value="3" @if($info['parent_order']['doc_type'] == 3) checked @endif disabled="disabled"/>内部编辑</label>
                    </div>
                </div>
                <div id="body_edit_type">
                    <div class="item_f" @if($info['parent_order']['doc_type'] == 1) style="display:block;" @else style="display:none;" @endif ><p><i class="LGntas"></i>外部链接：</p>
                        <div class="r"><input type="text" name="textfield" id="textfield" readonly="readonly" class="txt_f1" style="width:75%;" value="{{ $info['parent_order']['content'] }}" /></div>
                    </div>
                    <div class="item_f" @if($info['parent_order']['doc_type'] == 2) style="display:block;" @else style="display:none;" @endif><p><i class="LGntas"></i>文档导入：</p>
                        <div class="r">
                            <a href="/{{ $info['parent_order']['content'] }}" target="view_window" class="txt_f1" style="line-height:45px; width:75%; float:left;">{{$info['parent_order']['content']}}</a >
                        </div>
                     
                    </div>
                    <div class="item_f" @if($info['parent_order']['doc_type'] == 3) style="display:block;" @else style="display:none;" @endif><p><i class="LGntas"></i>订单内容：</p>
                        <div class="r">
                            <!--    在订单详情页中，”订单内容项“ 根据编辑方式不同所显示的界面不同，具体排版与会员下单页界页一样     -->
<!--						<textarea class="txt_ft1" readonly="readonly">{{ $info['parent_order']['content'] }}</textarea>		-->
							<div class="txt_ft1">{!! $info['parent_order']['content'] !!}</div>
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

                @if(in_array($info['order_type'],[4,6,7,8,10]))  <!--接受任务、反馈阶段-->
                    <div class="item_f" id="success_url"><p><i class="LGntas"></i>完成链接：</p>
                        <div class="r"><input type="text" name="success_url" id="success_url_v" class="txt_f1" style="width:75%;" / value="{{ $info['success_url'] }}"></div>
                    </div>
                    <div class="item_f" id="success_pic">
                        <p><i class="LGntas"></i>完成截图：</p>
                        <div class="r" style="position:relative;">
                            <div class="img_show">
                                <img @if($info['success_pic']) src="{{ $info['success_pic'] }}" @else src="/console/images/z_add2.png" @endif id="img_upload" style="cursor:pointer;float:left;margin-right:8px; width:130px; height:130px;" />
                            </div>
                            <span class="info1_f valign_m" style="height:95px;padding:0;">
                                <i>*</i> 请点击选择图片，仅支持 JPG、JPEG、GIF、<br/>PNG 格式的图片文件，文件不能大于 2MB。
                            </span>
                        </div>
                    </div>
                @endif
                @if($info['order_feedback'])  <!--存在反馈-->
                    <div class="item_f"><p><i class="LGntas" ></i>用户反馈：</p>
                        <div class="r">
                            <textarea class="txt_ft1" readonly="readonly" style="height:100px;">{{ $info['order_feedback'] }}</textarea>
                        </div>
                    </div>
                @endif
                @if($info['supp_feedback'])
                    <div class="item_f"><p><i class="LGntas"></i>供应商反馈：</p>
                        <div class="r">
                            <textarea class="txt_ft1" style="height:100px;" readonly="readonly" name="supp_feedback" id="supp_feedback" placeholder="{{ $info['supp_feedback'] }}"></textarea>
                        </div>
                    </div>
                @endif
                @if(in_array($info['order_type'], [6])) <!--处于供应商确认完成后的操作,供应商不能操作-->
                    <div class="item_f item_f_2" style="margin-top:50px; margin-left:0">
                        <div class="r"><input type="button" onclick="layer.msg('等待对方确认')" value="等待对方确认" class="sub5"></div>
                    </div>
                @endif
            </form>
        </div>
    </div>  