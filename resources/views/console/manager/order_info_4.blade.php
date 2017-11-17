
                @if($info['refund_reason'])
                    <div class="item_f"><p><i class="LGntas"></i>退款原因：</p>      <!--    退款订单详情显示    -->
                        <div class="r">
                            <textarea class="txt_ft1" style="height:90px;">{{ $info['refund_reason'] }}</textarea>
                        </div>
                    </div>
                @endif
                <div class="item_f"><p><i class="LGntas"></i>供应商退款状态：</p>   
                <!--   当供应商选择同意退款时只显示同意，当供应商选择不同意时，显示同意、不同意两个单选项   -->
                    <div class="r radio_w">
                        供应商暂未接单,无需经过供应商
                    </div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>平台方：</p>   
                <!--   当供应商选择同意退款时只显示同意，当供应商选择不同意时，显示同意、不同意两个单选项   -->
                    <div class="r radio_w">
                        允许取消订单
                    </div>
                </div>
               
                <div class="item_f item_f_2" style="margin-top:20px;">
                    <div class="r"><input type="button" value="订单已取消" class="sub5" style="margin-left:0;"></div>
                </div>
            </form>
            
        </div>