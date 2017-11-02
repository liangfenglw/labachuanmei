<!-- 供应商 -->
@if($user_type == 3)

<!-- 广告主 -->
@elseif($user_type == 2)
    <div class="sidebar clearfix">
        <ul class="sidebar-panel nav">
            <li>
                <div class="header">
                <span class="label" id="sd_0"><a href="/console/index">会员首页</a></span></div>
            </li>
            <li><div class="header inactive">
                    <span class="label" id="sd1_1">网络媒体</span></div>
                    <ul class="menu">
                        <li><a href="/media/sale_media/1"><div class="sd1_1_1">新闻约稿</div></a></li>
                        <li><a href="/media/sale_media/10"><div class="sd1_1_2">视频营销</div></a></li>
                        <li><a href="/media/sale_media/17"><div class="sd1_1_3">论坛营销</div></a></li>
                        <li><a href="/media/sale_media/25"><div class="sd1_1_4">微博营销</div></a></li>
                        <li><a href="/media/sale_media/36"><div class="sd1_1_5">微信营销</div></a></li>
                    </ul>
            </li>
        </ul>
</div>
<!-- 后台 -->
@elseif($user_type == 1)
<!--    左弹菜单 管理员首页  -->
<div class="sidebar clearfix">
    <ul class="sidebar-panel nav">
        <li>
        <div class="header">
            <span class="label" id="sd_0"><a href="/console/index">会员首页</a></span></div>
        </li>
        @foreach($menuList as $k => $v)
            <li>
                @if($v['route'])  <!-- 存在路由，则是只有一级了 -->
                    <div class="header"><span class="label" id="{{ $v['ico'] }}"><a href="$v[">{{ $v['menu'] }}</a></span></div>
                @else <!-- 存在下级菜单 -->
                    <div class="header inactive">
                        <span class="label" id="{{ $v['ico'] }}">{{ $v['menu'] }}</span>
                    </div>
                    @if($v['admin_menu'])
                        <ul class="menu">
                            @foreach($v['admin_menu'] as $k => $vv)
                                <li><a href="{{ $vv['route'] }}"><div class="sd_1_1">{{ $vv['menu'] }}</div></a></li>
                            @endforeach
                        </ul>
                    @endif
                @endif 
            </li>
        @endforeach
       <!--  -->
    </ul>
</div>
@endif

