<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>内—添加分类栏目 - 亚媒社</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    @include('console.share.cssjs')
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')
<!--    左弹菜单 普通会员首页 -->
<div class="content"><div class="Invoice">
    <div class="place">
        当前位置：<a href="/console/index">首页</a> > 添加分类栏目
    </div>
    <div class="main_o" style="padding-bottom:50px;">
        <h3 class="title4"><strong><a href="javascript:;">添加分类栏目</a></strong></h3>
        <div class="clearfix wrap_f" style="padding:70px 10px 100px;width:30%;min-width:400px;">
            <form action="" method="post" onsubmit="return checkForm();">
                {!! csrf_field() !!}
                <div class="item_f"><p><i class="LGntas"></i>栏目类型：</p>
                    <div class="r">
                        <select class="sel_f1" style="min-width:150px;width:50%;" name="pid" id="pid">
                            @foreach($category_type as $key => $val)
                                <option value="{{$key}}">{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>分类名称：</p>
                    <div class="r"><input type="text" name="category_name" id="category_name" class="txt_f1" style="width:75%;" /></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>分类排序：</p>
                    <div class="r"><input type="text" name="sortorder" id="sortorder" class="txt_f1" style="width:75%;" placeholder="默认99，降序" /></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>状态：</p>
                    <div class="r radio_w">
                        <label><input type="radio" name="status" class="radio_f" checked value="1" />在线</label>
                        <label><input type="radio" name="status" class="radio_f" value="2" />下架</label>
                    </div>
                </div>
                <div class="item_f item_f_2" style="margin-top:120px;">
                    <div class="r"><input type="submit" value="确 认" class="sub_f1" style="margin-left:10%;" ></div>
                </div>
            </form>
            <script type="text/javascript">
                function checkForm() {
                    var pid = $("#pid").val();
                    var category_name = $("#category_name").val();
                    var sortorder = $("#sortorder").val();
                    if (pid && category_name) {
                        return true;
                    }
                    layer.msg('栏目类型、分类排序必须填写');
                    return false;
                }
            </script>
        </div>
        
    </div>
    

</div></div>

@include('console.share.admin_foot') 

<script type="text/javascript">

</script>

</body>
</html>
