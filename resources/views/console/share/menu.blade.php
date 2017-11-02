<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="nav-close"><i class="fa fa-times-circle"></i>
    </div>
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span><img alt="image" class="img-circle" src="img/profile_small.jpg" /></span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs"><strong class="font-bold">{{ $adminName }}</strong></span>
                            <span class="text-muted text-xs block">{{ $leveName }}<b class="caret"></b></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="J_menuItem" href="form_avatar.html">修改头像</a>
                        </li>
                        <li><a class="J_menuItem" href="profile.html">用户资料</a>
                        </li>
                        <li><a class="J_menuItem" href="contacts.html">联系我们</a>
                        </li>
                        <li><a class="J_menuItem" href="mailbox.html">信箱</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="login.html">安全退出</a>
                        </li>
                    </ul>
                </div>
                <div class="logo-element">H+
                </div>
            </li>
            <li>
                <a href="/console/index">
                    <i class="fa fa-home"></i>
                    <span class="nav-label">主页</span>
                    <span class="fa arrow"></span>
                </a>

            </li>
            @foreach ($menuList as $menu)
                <li>
                @if($menu['type'] == 1) <!-- 下拉类型 -->
                    <a href="#">    
                        <i class="fa fa-edit {{ $menu['ico'] }}"></i>
                        <span class="nav-label">{{ $menu['menu'] }}</span>
                        <span class="fa arrow"></span>
                    </a>

                    <ul class="nav nav-second-level">
                        @foreach ($menu['admin_menu'] as $childMenu)
                            <li>
                                <a class="J_menuItem" href="{{ $childMenu['route'] }}">{{ $childMenu['menu'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                @elseif($menu['type'] == 2) <!--2 菜单-->
                    <a class="J_menuItem" href="{{ $menu['route'] }}"><i class="fa fa-columns"></i> <span class="nav-label">{{ $menu['menu'] }}</span></a>
                @endif
                </li>
            @endforeach

        </ul>
    </div>
</nav>