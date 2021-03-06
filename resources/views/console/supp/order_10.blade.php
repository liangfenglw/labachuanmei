@if(in_array($info['order_type'],[4,6,7,8,10]))  <!--接受任务、反馈阶段-->
    <div class="item_f" id="success_url"><p><i class="LGntas"></i>完成链接：</p>
        <div class="r"><input type="text" name="success_url" id="success_url_v" class="txt_f1" style="width:75%;" / value="{{ $info['success_url'] }}"></div>
    </div>
    <div class="item_f" id="success_pic">
        <p><i class="LGntas"></i>完成截图：</p>
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
<div class="item_f"><p><i class="LGntas"></i>订单状态：</p>
    <div class="r">
        @if(in_array($info['order_type'], [5,8,9,10,2])) <!--处于供应商确认完成后的操作-->
            <select class="sel_f1" name="order_type" id="order_type" disabled="disabled">
                <option>{{ $order_status[$info['order_type']] }}</option>
            </select>
        @endif
    </div>
</div>
<div class="item_f item_f_2" style="margin-top:50px; margin-left:0">
    <div class="r"><input type="button" onclick="layer.msg('此订单已经完成')" value="完成" class="sub5"></div>
</div>
