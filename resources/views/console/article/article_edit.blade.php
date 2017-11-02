<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>文章管理</title>
    @include('console.share.cssjs')
	<style>
		.item_f .r{	margin-left:162px;	}
	</style>
</head>
<body class="fold">
<!--    class="fold" 左导航收缩  -->
    @include('console.share.admin_head')
    @include('console.share.admin_menu')
<!--    左弹菜单 普通会员首页 -->
<div class="content"><div class="Invoice">

    <div class="place">
         <div class="place_ant"><a href="/console/index">首页</a><a href="/console/article/manager" class="cur">文章管理 </a></div>
    </div>
    
    <div class="main_o" style="padding-bottom:50px;">
        
        <h3 class="title4"><strong><a href="javascript:;">文章详情</a></strong></h3>
        
        <div class="clearfix wrap_f" style="padding:50px 10px 30px;width:70%;min-width:400px;">
        
            <form action="/console/article/update" method="post">
                {!! csrf_field() !!}
                <input type="hidden" name="article_id" value="{{ $article['id'] }}">
                <div class="item_f"><p><i class="LGntas"></i>标题：</p>
                    <div class="r"><input type="text" name="title" id="textfield" class="txt_f1" style="width:75%;" value="{{ $article['article_name'] }}" /></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>来源：</p>
                    <div class="r"><input type="text" name="origin" id="textfield" class="txt_f1" style="min-width:176px;width:10%;" value="{{ $article['origin'] }}" /></div>
                </div>
                <div class="item_f"><p><i class="LGntas"></i>栏目类型：</p>
                    <div class="r">
                        <select class="sel_f1" style="min-width:200px;width:auto;" name="type_id" onchange="select_type(this);">
                            @foreach($category_type as $key => $val)
                                <option value="{{ $key }}" @if($key == $article['category']['type_id']) selected="selected" @endif>{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="item_f" style="display: block;" id="child_div"><p><i class="LGntas"></i>发布栏目：</p>
                    <div class="r">
                        <select class="sel_f1" style="min-width:200px;width:auto;" name="category_id" id="child_category">
                            @foreach($category as $key => $val)
                                <option value="{{ $val['id'] }}" @if($val['id'] == $article['category_id']) selected="selected" @endif>{{ $val['category_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <script type="text/javascript">
                    function select_type(obj) {
                        var category_type = $(obj).val();
                        if (category_type > 0) {
                            $.ajax({
                                data:{"type":category_type,"_token":$('meta[name="csrf-token"]').attr('content')},
                                type:"post",
                                dataType:"json",
                                async:"false",
                                url:"/console/article/add",
                                success:function(msg) {
                                    if (msg['status_code'] == 200) {
                                        var html = "";
                                        for (var i in msg['data']) {
                                            html += "<option value=\""+msg['data'][i]['id']+"\">"+msg['data'][i]['category_name']+"</option>";
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
                    <div class="item_f"><p><i class="LGntas"></i>内容编辑：</p>
                        <div class="r">
                            <script id="editor" name="content" type="text/plain" style="min-height:300px;" value=""></script>
                        </div>
                    </div>
                    <div class="item_f item_f_2" style="margin-top:30px;">
                        <div class="r"><input type="submit" value="确 认" class="sub5" style="margin-left:0;" ></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    @include('console.share.admin_foot')

<script type="text/javascript">
    var ue = UE.getEditor('editor');        //  UEditor API 文档  http://ueditor.baidu.com/doc/#UE.Editor:focus
    setTimeout(function () {
        ue.execCommand('drafts');
        ue.setContent('{!! $article["content"] !!}');
    }, 1000);
</script>

</body>
</html>
