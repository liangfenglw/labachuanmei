<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>新闻中心</title>
    @include('console.share.cssjs')
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')
<!--    左弹菜单 普通会员首页 -->


<div class="content"><div class="Invoice">

    <div class="banner2">
        <img src="/console/images/banner_news.jpg" width="100%">
    </div>
    
    <div class="place">
        <div class="place_ant"><a href="/console/index">首页</a><a class="cur">新闻中心 </a></div>
    </div>
    
    <div class="main_o">
        
        <h3 class="title5 clearfix"><strong>最新消息</strong></h3>
        
        <div class="dhorder_m">
            <div class="tab1">
                <ul>       
                    <li class="cur"><a href="javascript:;">未读消息</a></li>
                    <li><a href="javascript:;">已读消息</a></li>
                </ul>
            </div>
            <div class="tab1_body">
            
                <div class="tab1_body_m" style="display:block;">
                    <table class="table_in1 cur" id="datatable1">
                        <thead style="display:none;">
                            <tr><th class="nosort"></th></tr>
                        </thead>
                        <tbody>
                            @if(Auth::user()->user_type == 2)
                                @foreach($news as $key => $val)
                                <tr>
                                    <td><a href="@if(!empty($val['article_name'])) /news/{{ $val['id'] }} @else /order/order_detail/{{ $val['order_id'] }} @endif"><div class="XTnews_list">{{$val['article_name'] or $val['content']}}</div><div class="XTRnews_list">{{$val['created_at']}}</div></a></td>
                                </tr> 
                            @endforeach
                            @else
                                @foreach($news as $key => $val)
                                    <tr>
                                        <td><a href="@if(!empty($val['article_name'])) /news/{{ $val['id'] }} @else /supp/order/info/{{ $val['order_id'] }} @endif"><div class="XTnews_list">{{$val['article_name'] or $val['content']}}</div><div class="XTRnews_list">{{$val['created_at']}}</div></a></td>
                                    </tr> 
                                @endforeach
                            @endif
                            
                        </tbody>
                    </table>
                </div>
                
                <div class="tab1_body_m" style="display:none;">
                    <table class="table_in1 cur" id="datatable2">
                        <thead style="display:none;">
                            <tr><th class="nosort"></th></tr>
                        </thead>
                        <tbody>
                           
                            @if(Auth::user()->user_type == 2)
                                 @foreach($read_news as $key => $val)
                                    <tr>
                                        <td><a href="@if(!empty($val['article_name'])) /news/{{ $val['id'] }} @else /order/order_detail/{{ $val['order_id'] }} @endif"><div class="XTnews_list">{{$val['article_name'] or $val['content']}}</div><div class="XTRnews_list">{{$val['created_at']}}</div></a></td>
                                    </tr> 
                                @endforeach
                            @else
                                 @foreach($read_news as $key => $val)
                                    <tr>
                                        <td><a href="@if(!empty($val['article_name'])) /news/{{ $val['id'] }} @else /supp/order/info/{{ $val['order_id'] }} @endif"><div class="XTnews_list">{{$val['article_name'] or $val['content']}}</div><div class="XTRnews_list">{{$val['created_at']}}</div></a></td>
                                    </tr> 
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                
            </div>
                    
        </div>
    

    </div>  

</div></div>


@include('console.share.admin_foot')
<script>
    var datatable;
    var datatable2;
    $(function () {
            var dt_option = {
                "searching" : false,        //是否允许Datatables开启本地搜索
                "paging" : true,            //是否开启本地分页
                "pageLength" : 8,           //每页显示记录数
                "lengthChange" : false,     //是否允许用户改变表格每页显示的记录数 
                "lengthMenu": [ 5, 10, 100 ],       //用户可选择的 每页显示记录数
                "info" : true,
                "columnDefs" : [{
                    "targets": 'nosort',
                    "orderable": false
                }],
                "pagingType": "simple_numbers",
                "language": {
                    "search": "搜索",
                    sZeroRecords : "没有查询到数据",
                    "info": "显示第 _PAGE_/_PAGES_ 页，共_TOTAL_条",
                    "infoFiltered": "(筛选自_MAX_条数据)",
                    "infoEmpty": "没有符合条件的数据",
                    oPaginate: {    
                        "sFirst" : "首页",
                        "sPrevious" : "上一页",
                        "sNext" : "下一页",
                        "sLast" : "尾页"    
                    },
                    searchPlaceholder: "过滤..."
                }
                ,"order" : [[1,"desc"]]
            };
            datatable =  $('#datatable1').DataTable(dt_option);
            datatable2 =  $('#datatable2').DataTable(dt_option);
        
        
        $(".tab1 ul li a").unbind("click");     /*  取消原切换事件，改成下面的新切换事件  */
        $(".tab1>ul>li>a").click(function(){
            var index=$(this).parent("li").index();
            $(this).parent("li").addClass("cur").siblings("li").removeClass("cur");
            $(this).parents(".tab1").next(".tab1_body").find(".tab1_body_m").css("display","none").eq(index).css("display","block");
            return false;
        });
        
    });
    
    
</script>

</body>
</html>
