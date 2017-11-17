@if(in_array($info['order_type'],[4,6,7,8,10]))  <!--接受任务、反馈阶段-->
    <div class="item_f" id="success_url"><p><i class="LGntas"></i>完成链接：</p>
        <div class="r"><input type="text" name="success_url" id="success_url_v" class="txt_f1" style="width:75%;"  value=""></div>
    </div>
    <div class="item_f" id="success_pic">
        <p><i class="LGntas"></i>完成截图：</p>
        <div class="r" style="position:relative;">
            <div class="img_show">
                <img src="/console/images/z_add2.png" id="img_upload" style="cursor:pointer;float:left;margin-right:8px; width:130px; height:130px;" />
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
<div class="item_f"><p><i class="LGntas" ></i>申诉进展：</p>
    <div class="r">
        <input type="text" class="txt_f1" readonly="true" style="width:16%;" value="重新执行任务">
    </div>
</div>
<div class="item_f"><p><i class="LGntas"></i>订单状态：</p>
    <div class="r">
        @if(in_array($info['order_type'],[4]))
            <select class="sel_f1" name="order_type" id="order_type">
                <option value="0">请选择</option>
                <option value="5">
                   完成
                </option>
            </select>
            <script type="text/javascript">
                
            </script>
        @endif
    </div>
</div>
    <div class="item_f item_f_2" style="margin-top:50px; margin-left:0">
        <div class="r">
            <input type="submit" value="确 认" class="sub5">
        </div>
    </div>
<script type="text/javascript">
    function subform() {
        var order_type = $("#order_type").val();
        var flag = 0;
        if (order_type == 5) {
            var success_url_v = $("#success_url_v").val();
            var success_pic_v = $("#success_pic_v").val();
            if (!success_url_v) {
                flag++;
            }
            if (!success_pic_v) {
                flag++;
            }
        } else {
            layer.msg('请选择订单完成状态');return false;
        }
        if (flag >= 2) {
            flag = 0;
            layer.msg('请重新上传完成链接或完成截图');return false;
        }
        return true;
    }
</script>
