<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    @include('console.share.cssjs')
</head>
<body class="fold">
<!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')
<!--    左弹菜单 普通会员首页 -->


<div class="content">
    <div class="Invoice">
    <div class="place">
        当前位置：<a href="/console/index">首页</a> > 添加菜单、方法
    </div>
    <div class="main_o" style="padding-bottom:50px;">
        <h3 class="title4"><strong><a href="#">添加菜单、方法</a></strong></h3>
        <div class="clearfix wrap_f" style="padding:70px 10px 100px;width:30%;min-width:400px;">
            <form action="/manager/updateCategory" method="post" id="myform">
                {!! csrf_field() !!}
                <div class="item_f">
                    <p><i class="LGntas"></i>顶级菜单：</p>
                    <div class="r">
                        <select class="sel_f1" style="min-width:150px;width:50%;" name="cate_id" onchange="getCategory(this);">
                            <option value="">请选择</option>
                            <option value="-1">顶级菜单</option>
                            @foreach($category_list as $key => $lists)
                                <option value="{{ $lists['id'] }}">{{ $lists['menu'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="item_f" id="child_div" style="display:none;">
                    <p><i class="LGntas"></i>二级菜单：</p>
                    <div class="r">
                        <select class="sel_f1" id="child_category" style="min-width:150px;width:50%;" name="child_id">
                            <option value="">请选择</option>
                            <option value="-1">顶级菜单</option>
                        </select>
                    </div>
                </div>
                <script type="text/javascript">
                    function getCategory(obj) {
                        var currentToken = $('meta[name="csrf-token"]').attr('content');
                        var val = $(obj).val();
                        if (val > 0) {
                            $.ajax({
                                data:{"_token":currentToken,"catid":val},
                                url:"/public/getCategory",
                                type:"post",
                                dataType:"json",
                                success:function(mes) {
                                    if (mes.status_code == 200) {
                                        var html = "<option value=\"\">请选择</option>";
                                        for (value in mes.data) {
                                            html += '<option value="'+mes['data'][value]['id']+'">'+mes['data'][value]['menu']+'</option>';
                                        }
                                        $("#child_category").html(html);
                                        $("#child_div").show();
                                    }
                                }
                            })
                        } else {
                            $("#child_div").hide();
                        }
                    }
                </script>
                <div class="item_f">
                    <p><i class="LGntas"></i>类型：</p>
                    <div class="r">
                        <select class="sel_f1" style="min-width:150px;width:50%;" name="type">
                            <option value="1">菜单</option>
                            <option value="2">带连接的菜单</option>
                            <option value="3">方法</option>
                        </select>
                    </div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>是否显示：</p>
                    <div class="r radio_w">
                        <label><input type="radio" name="is_show" class="radio_f" value="1" />显示</label>
                        <label><input type="radio" name="is_show" class="radio_f" value="2" />隐藏</label>
                    </div>
                </div>

                <div class="item_f"><p><i class="LGntas"></i>名称：</p>
                    <div class="r"><input type="text" name="menu" id="textfield" class="txt_f1" style="width:75%;" /></div>
                </div>

                <div class="item_f"><p><i class="LGntas"></i>ico图标：</p>
                    <div class="r"><input type="text" name="ico" id="textfield" class="txt_f1" style="width:75%;" /></div>
                </div>

                <div class="item_f"><p><i class="LGntas"></i>路由：</p>
                    <div class="r"><input type="text" name="route" id="textfield" class="txt_f1" style="width:75%;" /></div>
                </div>
                
                <div class="item_f item_f_2" style="margin-top:120px;">
                    <div class="r"><input type="button" onclick="submitForm()" value="添 加" class="sub_f1" style="margin-left:10%;" ></div>
                </div>
            </form>
            <script type="text/javascript">
                function submitForm() {
                    var form_data = $("#myform");
                    $.ajax({
                        url:"/manager/updateCategory",
                        data:form_data.serialize(),
                        dataType:'json',
                        type:'post',
                        success:function(mes) {
                            if (mes.status_code == 200) {
                                layer.msg("成功");
                            } else {
                                layer.msg(mes.error);
                            }
                        },
                        error:function() {

                        }
                    });
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
