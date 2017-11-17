    <div class="item_f"><p><i class="LGntas"></i>完成链接：</p>
        <div class="r"><input type="text" readonly="readonly" name="textfield" id="textfield" class="txt_f1" style="width:75%;" value="{{$info['success_url']}}" /></div>
    </div>
    <div class="item_f"><p><i class="LGntas"></i>完成截图：</p>
        <div class="r" style="position:relative;">
            <div class="img_show">
                <img @if($info['success_pic']) src="{{ $info['success_pic'] }}" @else src="/console/images/z_add2.png" @endif id="img_upload" style="cursor:pointer;float:left;margin-right:8px; width:130px; height:130px;" />
                <input type="file" id="success_pic_v" name="success_pic" id="documents_upload_button" placeholder="未选择任何文件" accept="image/jpg,image/jpeg,image/png" class="txt6 txt6_up upfile upload_f1" style="width:130px;height:130px;display:none;opacity:0;"  />
            </div>
            <span class="info1_f valign_m" style="height:95px;padding:0;">
                <i>*</i> 请点击选择图片，仅支持 JPG、JPEG、GIF、<br/>PNG 格式的图片文件，文件不能大于 2MB。
            </span>
        </div>
    </div>
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

   
    @if(in_array($info['order_type'], [0,2,3,10]))
        <div class="item_f item_f_2" style="margin-top:50px; margin-left:-157px;">
            <div class="r">
                <input type="button" onclick="layer.msg('不能进行操作')" value="{{ getOrderType($info['order_type']) }}" class="sub5" style="font-size: 18px" />
            </div>
        </div>
    @endif
    @if(in_array($info['order_type'], [9]))
        <div class="item_f item_f_2" style="margin-top:50px; margin-left:-157px;">
            <div class="r">
                <input type="submit" value="确认" class="sub5" style="font-size: 18px" />
            </div>
        </div>
    @endif
    @if(in_array($info['order_type'], [12,14,15]) ) {{-- 申请退款 --}}
        <div class="item_f item_f_2" style="margin-top:20px;">
            <div class="r"><input type="submit" value="确 认" class="sub5" style="margin-left:0;"></div>
        </div>
    @endif
</form>

</div>