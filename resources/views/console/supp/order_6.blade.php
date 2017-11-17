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