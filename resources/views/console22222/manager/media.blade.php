<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>用—筛选分类管理 - 亚媒社</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    @include('console.share.cssjs')
    <style>
    </style>
</head>
<body class="fold">
<!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')
<!--    左弹菜单 普通会员首页 -->
<div class="content"><div class="Invoice">
    <div class="place">
        当前位置：<a href="">首页</a> > 订单管理
    </div>
    <form action="/console/manager/media" method="post" id="attr_form">
        {!! csrf_field() !!}
        <input type="hidden" name="val" value="" id="val">
        <input type="hidden" name="attr_id" value="" id="attr_id">
    </form>
    <div class="main_o clearfix" style="padding-bottom:0;">
        <h3 class="title4 clearfix"><strong><a>媒体筛选分类管理</a></strong></h3>
        <div class="dhorder_m">
            <div class="tab1">
                <ul>
                    @foreach($plate_list as $key => $val)
                        <li class="cur"><a href="">{{$val['plate_name']}}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="tab1_body" style="padding-bottom:35px;">
                <div class="tab1_body_m" style="display:block;">
                @foreach($lists as $key => $val)
                    <div class="list_cm">
                        <h3 class="h_list_cm"><strong>{{ $val['plate_name'] }}</strong></h3>
                        <div class="m_list_cm">
                                    @forelse($val['plate_vs_attr'] as $kk => $vv)
                                        <div class="item_list_cm clearfix" >
                                            <span class="sp1">{{ $vv['attr_name'] }}：</span>
                                            <ul>
                                                <li><a href="">不限</a></li>
                                                 @forelse($vv['attr_vs_val'] as $kkk => $vvv)
                                                <li><a href="">{{ $vvv['attr_value'] }}</a></li>
                                                @empty
                                                @endforelse
                                            </ul>
                                            <span class="sp2" title="按回车添加分类">
                                                <input  data-attr-id="{{$vv['id']}}" type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" />
                                            </span>
                                        </div>
                                    @empty
                                    @endforelse
                        </div>
                    </div>
                @endforeach
                    <div class="list_cm">
                        <h3 class="h_list_cm"><strong>视频营销</strong></h3>
                        <div class="m_list_cm">
                            <div class="item_list_cm clearfix">
                                <span class="sp1">平台：</span>
                                <ul>
                                    <li><a href="">不限    直播    美拍     秒拍    快手    哔哩哔哩动画    优酷    YY    爱奇艺    腾讯视频    小咖秀</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                            <div class="item_list_cm clearfix">
                                <span class="sp1">视频类型：</span>
                                <ul>
                                    <li><a href="">不限   美容美妆    搞笑/段子   游戏动漫   运动健身   娱乐八卦   音乐   美食   母婴/宝宝   生活日常   舞蹈   宠物   健康/养生   旅游     服饰搭配   绘画   汽车   科技/数码   情感心理   新闻资讯   摄影   科普   教育/培训   手工/DIY   军事   体育/赛事   财经股市          
                                      家居    星座命理</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                            <div class="item_list_cm clearfix">
                                <span class="sp1">覆盖区域：</span>
                                <ul>
                                    <li><a href="">不限  全国  北京  上海  广州  深圳  重庆  天津  江苏  浙江  福建  湖南  湖北  广东   广西  云南  贵州  四川  安徽  江西  河南  河北   山东  山西  辽宁  吉林  黑龙江  内蒙古  陕西  宁夏  甘肃  青海  新疆  西藏</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                            <div class="item_list_cm clearfix">
                                <span class="sp1">粉丝数：</span>
                                <ul>
                                    <li><a href="">不限  1000-5000  5000-1万  1-2万  2-5万  5-10万  10万以上</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                            <div class="item_list_cm clearfix">
                                <span class="sp1">名人性别：</span>
                                <ul>
                                    <li><a href="">男</a></li>
                                    <li><a href="">女</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                            <div class="item_list_cm clearfix">
                                <span class="sp1">参考报价：</span>
                                <ul>
                                    <li><a href="">不限  500元以下  500-1000元  1000-5000元  5000-1万元  1-5万元  5万元以上</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                        </div>
                    </div>

                    <div class="list_cm">
                        <h3 class="h_list_cm"><strong>论坛营销</strong></h3>
                        <div class="m_list_cm">
                            <div class="item_list_cm clearfix">
                                <span class="sp1">发布类型：</span>
                                <ul>
                                    <li><a href="">文字帖</a></li>
                                    <li><a href="">图文帖</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                            <div class="item_list_cm clearfix">
                                <span class="sp1">指定效果：</span>
                                <ul>
                                    <li><a href="">不限帖子加精（周数）  帖子置顶（天数）  版主发帖</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                            <div class="item_list_cm clearfix">
                                <span class="sp1">覆盖区域：</span>
                                <ul>
                                    <li><a href="">不限  全国  北京  上海  广州  深圳  重庆  天津  江苏  浙江  福建  湖南  湖北  广东   广西  云南  贵州  四川  安徽  江西  河南  河北    山东  山西  辽宁  吉林  黑龙江  内蒙古  陕西  宁夏  甘肃  青海  新疆  西藏</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                            <div class="item_list_cm clearfix">
                                <span class="sp1">频道类型：</span>
                                <ul>
                                    <li><a href="">不限  新闻资讯  时尚  美容  购物  搞笑娱乐  旅游  摄影  数码  母婴育儿  美食  互联网  财经   汽车  家居  情感心理  星座命理    教育培训   职场/管理  营销  游戏动漫  运动健身  体育  健康  养生  宠物  生活  文艺  两性  军事  综合媒体  地域  影视/音乐  微商  其它</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                            <div class="item_list_cm clearfix">
                                <span class="sp1">阅读数：</span>
                                <ul>
                                    <li><a href="">不限    5万以下  5-10万  10-20万  20-50万  50-100万  100-150万  150-200万  200-500万  500万以上</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                            <div class="item_list_cm clearfix">
                                <span class="sp1">推荐套餐：</span>
                                <ul>
                                    <li><a href="">全网覆盖  行业覆盖  地方覆盖</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                            <div class="item_list_cm clearfix">
                                <span class="sp1">参考报价：</span>
                                <ul>
                                    <li><a href="">不限  500元以下   500-1000元  1000-3000元  3000-5000元  5000-10000元  10000元以上</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                        </div>
                    </div>

                    <div class="list_cm">
                        <h3 class="h_list_cm"><strong>微博营销</strong></h3>
                        <div class="m_list_cm">
                            <div class="item_list_cm clearfix">
                                <span class="sp1">平台：</span>
                                <ul>
                                    <li><a href="">微博公众号</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                            <div class="item_list_cm clearfix">
                                <span class="sp1">频道类型：</span>
                                <ul>
                                    <li><a href="">不限  新闻资讯  时尚  美容  购物  搞笑娱乐  旅游  摄影  数码  母婴育儿  美食  互联网  财经   汽车  家居  情感心理  星座命理    教育培训   职场/管理  营销  游戏动漫  运动健身  体育  健康  养生  宠物  生活  文艺  两性  军事  综合媒体  地域  影视/音乐  微商  
                                     其它</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                            <div class="item_list_cm clearfix">
                                <span class="sp1">覆盖区域：</span>
                                <ul>
                                    <li><a href="">不限  全国  北京  上海  广州  深圳  重庆  天津  江苏  浙江  福建  湖南  湖北  广东   广西  云南  贵州  四川  安徽  江西  河南  河北   山东  山西  辽宁  吉林  黑龙江  内蒙古  陕西  宁夏  甘肃  青海  新疆  西藏</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                            <div class="item_list_cm clearfix">
                                <span class="sp1">粉丝数：</span>
                                <ul>
                                    <li><a href="">不限    5万以下  5-10万  10-20万  20-50万  50-100万  100-150万  150-200万  200-500万  500万以上</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                            <div class="item_list_cm clearfix">
                                <span class="sp1">参考报价：</span>
                                <ul>
                                    <li><a href="">不限  500元以下   500-1000元  1000-3000元  3000-5000元  5000-10000元  10000元以上</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                        </div>
                    </div>

                    <div class="list_cm">
                        <h3 class="h_list_cm"><strong>微信营销</strong></h3>
                        <div class="m_list_cm">
                            <div class="item_list_cm clearfix">
                                <span class="sp1">平台：</span>
                                <ul>
                                    <li><a href="">公众号</a></li>
                                    <li><a href="">朋友圈</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                            <div class="item_list_cm clearfix">
                                <span class="sp1">频道类型：</span>
                                <ul>
                                    <li><a href="">不限  新闻资讯  时尚  美容  购物  搞笑娱乐  旅游  摄影  数码  母婴育儿  美食  互联网  财经   汽车  家居  情感心理  星座命理     教育培训   职场/管理  营销  游戏动漫  运动健身  体育  健康  养生  宠物  生活  文艺  两性  军事  综合媒体  地域  影视/音乐  微商  
                                     其它</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                            <div class="item_list_cm clearfix">
                                <span class="sp1">覆盖区域：</span>
                                <ul>
                                    <li><a href="">不限  全国  北京  上海  广州  深圳  重庆  天津  江苏  浙江  福建  湖南  湖北  广东   广西  云南  贵州  四川  安徽  江西  河南  河北    山东  山西  辽宁  吉林  黑龙江  内蒙古  陕西  宁夏  甘肃  青海  新疆  西藏</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                            <div class="item_list_cm clearfix">
                                <span class="sp1">阅读数：</span>
                                <ul>
                                    <li><a href="">不限    5万以下  5-10万  10-20万  20-50万  50-100万  100-150万  150-200万  200-500万  500万以上</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                            <div class="item_list_cm clearfix">
                                <span class="sp1">广告位置：</span>
                                <ul>
                                    <li><a href="">单图文  多图文第二条  多图文第一条</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                            <div class="item_list_cm clearfix">
                                <span class="sp1">粉丝数：</span>
                                <ul>
                                    <li><a href="">不限    5万以下  5-10万  10-20万  20-50万  50-100万  100-150万  150-200万  200-500万  500万以上</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                            <div class="item_list_cm clearfix">
                                <span class="sp1">参考报价：</span>
                                <ul>
                                    <li><a href="">不限  500元以下   500-1000元  1000-3000元  3000-5000元  5000-10000元  10000元以上</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                        </div>
                    </div>

                    <div class="list_cm">
                        <h3 class="h_list_cm"><strong>问答营销</strong></h3>
                        <div class="m_list_cm">
                            <div class="item_list_cm clearfix">
                                <span class="sp1">特点：</span>
                                <ul>
                                    <li><a href="">一问一答</a></li>
                                    <li><a href="">一问两答</a></li>
                                </ul>
                                <span class="sp2" title="按回车添加分类"><input type="text" value="" placeholder="分类名称 +" class="txt_cm" name="" /></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab1_body_m" style="display:none;">
                    2       
                </div>
                <div class="tab1_body_m" style="display:none;">
                    3   
                </div>
                <div class="tab1_body_m" style="display:none;">
                    4   
                </div>
                <div class="tab1_body_m" style="display:none;">
                    5   
                </div>
                <div class="tab1_body_m" style="display:none;">
            6   
                </div>
                <div class="tab1_body_m" style="display:none;">
            7   
                </div>
                <div class="tab1_body_m" style="display:none;">
            8   
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>

@include('console.share.admin_foot')
<script>
$(function(){
    $(".tab1>ul>li>a").unbind("click");     /*  取消原切换事件，改成下面的新切换事件  */
    $(".tab1>ul>li>a").click(function(){
        var index=$(this).parent("li").index();
        $(this).parent("li").addClass("cur").siblings("li").removeClass("cur");
        $(this).parents(".tab1").next(".tab1_body").find(".tab1_body_m").css("display","none").eq(index).css("display","block");
        return false;
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:"post",
    });
/*  按回车添加分类 */  
    $('input.txt_cm').on('keypress',function(event){
        if(event.keyCode == 13){        //按回车
            var str = $.trim($(this).val());
            var att_id = $.trim($(this).attr('data-attr-id'));
            if( str == "" ){
                layer.msg("分类名称不能为空");
            }else{
                var flag = 0;
                $(this).closest(".item_list_cm").find("ul li a").each(function(){
                    var str2 = $(this).html();
                    if( str == str2 ){          //分类已存在
                        flag = 1;
                        return false;
                    }
                });
                if ( flag == 1) {
                    layer.msg("分类名称 "+str+" 已经存在");
                } else {
                    var obj = $(this);

                    $.ajax({
                        url:"/console/manager/media",
                        type:'post',
                        data:{"val":str,"attr_id":att_id},
                        dataType:"json",
                        async:"false",
                        success:function(msg){
                            if (msg.status_code == 200) {
                                var newli = '<li><a href="#">' + str + '</a></li>';
                                obj.closest(".item_list_cm").find("ul").append(newli);
                                layer.msg("成功添加分类 " + str);
                                obj.val("");
                            } else {
                                layer.msg(msg.msg);
                                obj.val("");
                            }
                        },error:function(){

                        }
                    })
                    
                }
            }
        }
    }); 
});
</script>
</body>
</html>
