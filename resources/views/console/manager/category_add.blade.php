<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>分类管理_喇叭传媒</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    @include('console.share.cssjs')
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')        <!--    左弹菜单 普通会员首页 -->


<div class="content"><div class="Invoice">

    <div class="place">
        <div class="place_ant"><a href="/">首页</a><a  class="cur">分类管理 </a></div>
    </div>
    
    <div class="main_o" style="padding-bottom:50px;">
        
        <h3 class="title4"><strong><a href="javascript:;">添加分类栏目</a></strong></h3>
        
        <div class="clearfix wrap_f" style="">
        
            <form action="" method="post">
                <div class="item_f"><p><i class="LGntas"></i>栏目类型：</p>
                    <div class="r">
                        <select class="sel_f1" style="min-width:150px;">
                            <option value="">广告主</option>
                            <option value="">媒体主</option>
                            <option value="">质检标准</option>
                            <option value="">最新消息</option>
                        </select>
                    </div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>分类名称：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" style="width:52%;" /></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>分类排序：</p>
                    <div class="r"><input type="text" name="textfield" id="textfield" class="txt_f1" style="width:16%;" /></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>状态：</p>
                    <div class="r radio_w">
                        <label class="rd1"><input type="radio" name="status" class="radio_f" value="1" />在线</label>
                        <label class="rd1"><input type="radio" name="status" class="radio_f" value="2" />下架</label>
                    </div>
                </div>
                <div class="item_f item_f_2" style="margin-top:50px;">
                    <div class="r"><input type="submit" value="确 认" class="sub5" style="margin-left:0;" ></div>
                </div>
            </form>
            
        </div>
        
    </div>
    

</div></div>

@include('console.share.admin_foot') 

<script type="text/javascript">

</script>

</body>
</html>
