                <div class="item_f"><p><i class="LGntas"></i>完成链接：</p>
                    <div class="r"><input type="text" name="success_url" id="success_url" class="txt_f1" style="width:75%;" value="{{$info['success_url']}}" /></div>
                </div>
                <div class="item_f" id="success_pic">
                        <p><i class="LGntas"></i>完成截图：</p>
                        <div class="r" style="position:relative;">
                            <div class="img_show">
                                <img src="/console/images/z_add2.png" id="img_upload" style="cursor:pointer;float:left;margin-right:8px; width:130px; height:130px;" />
                                <input type="file" id="success_pic_v" name="success_pic" placeholder="未选择任何文件" accept="image/jpg,image/jpeg,image/png" class="txt6 txt6_up upfile upload_f1" style="width:130px;height:130px;display:none;opacity:0;"  />
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
                        <label class="rd1"><input type="radio" name="order_type" id="order_type" class="radio_f" value="15" />同意</label>
                        <label class="rd1 css_cur"><input type="radio" checked="checked" name="order_type" id="order_type" class="radio_f" value="14" />不同意</label>
                    </div>
                </div>


                <div class="item_f"><p><i class="LGntas"></i>订单状态：</p>
                    <div class="r">
                        <select class="sel_f1" name="">
                            <option value="15">对方申请退款中</option>
                        </select>
                    </div>
                </div>

                <div class="item_f item_f_2" style="amargin-top:50px; margin-left:0">
                    <div class="r"><input type="submit" value="确 认" class="sub5"></div>
                </div>
            <script type="text/javascript">
                function subform() {
                    var select_v = $("input[name='order_type']:checked").val();
                    var count_msg = 0;
                    if (select_v == 14) {
                        if (!$("#success_pic_v").val()) {
                            count_msg++;
                        }
                        if (!$("#success_url").val()) {
                            count_msg++;
                        }
                        if (count_msg == 2) {
                            layer.msg('完成链接或完成截图必须填写一个');
                            count_msg=0;
                            return false;
                        }
                        return true;
                    } else {
                        return true;
                    }
                    return false;
                }
            </script>
