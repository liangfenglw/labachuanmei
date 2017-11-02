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