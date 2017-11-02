/**
 * 交互框
 * @return {[type]} [description]
 */
function confirm_msg(txt="确认提交?") {
    var flag = confirm(txt);
    if (flag == true) {
        return true;
    } else {
        return false;
    }
}
function isEmail(str) { 
    var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/; 
    return reg.test(str); 
}

function setPrice() {
    var proxy_price = $("#proxy_price").val();
    var vip_price = $("#vip_price").val();
    var plate_price = $('#plate_price').val();
    if (!vip_price) {
        vip_price = 0;
    } else {
         vip_price = vip_price / 100;
    }
    if (!plate_price) {
        plate_price = 0;
    } else {
         plate_price = plate_price / 100;
    }
    var t = parseFloat(proxy_price * vip_price)  + parseFloat(proxy_price);
    var t1 = parseFloat(proxy_price * plate_price) + parseFloat(proxy_price);
    $("#vips_price").val(t);
    $("#plates_price").val(t1);
}