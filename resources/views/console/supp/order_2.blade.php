<div class="item_f"><p><i class="LGntas"></i>订单状态：</p>
    <div class="r">
        <select class="sel_f1" name="order_type" id="order_type" disabled="disabled">
            <option>{{ $order_status[$info['order_type']] }}</option>
        </select>
    </div>
</div>
<div class="item_f item_f_2" style="margin-top:50px; margin-left:0">
    <div class="r"><input type="button" onclick="layer.msg('此订单已拒绝')" value="拒绝" class="sub5"></div>
</div>         
          