<div class="item_f" id="success_url"><p><i class="LGntas"></i>完成链接：</p>
    <div class="r"><input type="text" name="success_url" id="success_url_v" class="txt_f1" style="width:75%;" / value="{{ $info['success_url'] }}"></div>
</div>
<div class="item_f" id="success_pic">
    <p><i class="LGntas"></i>完成截图：</p>
    <div class="r" style="position:relative;">
        <div class="img_show">
            <img @if($info['success_url']) src="{{ $info['success_pic'] }}" @else src="/console/images/z_add2.png" @endif id="img_upload" style="cursor:pointer;float:left;margin-right:8px; width:130px; height:130px;" />
            <input type="file" id="success_pic_v" name="success_pic" id="documents_upload_button" placeholder="未选择任何文件" accept="image/jpg,image/jpeg,image/png" class="txt6 txt6_up upfile upload_f1" style="width:130px;height:130px;display:none;opacity:0;"  />
        </div>
        <span class="info1_f valign_m" style="height:95px;padding:0;">
            <i>*</i> 请点击选择图片，仅支持 JPG、JPEG、GIF、<br/>PNG 格式的图片文件，文件不能大于 2MB。
        </span>
    </div>
</div>
<div class="item_f"><p><i class="LGntas"></i>退款原因：</p>     <!--    退款订单详情显示    -->
    <div class="r">
        <textarea readonly="true" class="txt_ft1" style="height:90px;">{{ $info['refund_reason'] }}</textarea>
    </div>
</div>
<div class="item_f"><p><i class="LGntas"></i>退款处理：</p>
    <div class="r radio_w">
        <label class="rd1 @if($info['order_type'] == 15) css_cur @endif"><input type="radio" name="order_type" id="order_type" class="radio_f" value="15" />同意</label>
        <label class="rd1 @if($info['order_type'] == 14) css_cur @endif"><input type="radio" name="order_type" id="order_type" class="radio_f" value="14" />不同意</label>
    </div>
</div>
<div class="item_f"><p><i class="LGntas"></i>订单状态：</p>
    <div class="r">
        <select class="sel_f1" name="order_type" id="order_type">
            <option value="">申请退款进行中</option>
        </select>
    </div>
</div>
