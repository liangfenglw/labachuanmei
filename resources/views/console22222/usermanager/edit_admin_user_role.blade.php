<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>菜单管理 - 权限 - 亚媒社</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    @include('console.share.cssjs')
</head>
<body class="fold t_css"><!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')<!--    左弹菜单 普通会员首页 -->
<div class="content"><div class="Invoice">
    <div class="place">
        当前位置：<a href="/console/index">首页</a> > 用户管理
    </div>
    <div class="main_o" style="padding-bottom:0;">
        <h3 class="title4"><strong><a href="#">管理员用户权限</a></strong>
            <div class="search_1">
                <div style="float:right;">
                    <div class="l">
                    </div>
                </div>

            </div>
            <div class="clr"></div>
        </h3>
        <div class="dhorder_m">
            <form method="post"  action="/usermanager/adminuser/edit">
                {!! csrf_field() !!}
                <input type="hidden" name="user_id" value="{{$id}}">
                <div class="tab1_body">
                    <table class="table_in1 cur" id="datatable1">
                        @foreach($role_list as $key => $val)
                            <thead>
                                <tr>
                                    <th style="text-align:left;width:20%;">{{ $val['menu'] }} </th>
                                    <th style="width:20%"></th>
                                    <th style="width:20%"></th>
                                    <th style="width:20%"></th>
                                    <th style="width:20%"></th>
                                </tr>
                            </thead>
                            <tbody id="listcontent">
                                <tr>
                                    <?php $i = 1; ?>
                                    @foreach($val['admin_menu'] as $kk => $vv)
                                    <?php ++$i; ?>
                                        <td style="text-align:left;width:20%;">
                                            <input type="checkbox" name="cate_id[]" @if(in_array($vv['id'],$role_mes)) checked="checked" @endif value="{{ $vv['id'] }}">{{ $vv['menu'] }}
                                            【栏目】
                                        </td>
                                @if($i > 5)
                                </tr>
                                <tr>
                                <?php $i = 1; ?>
                                @endif
                                    @foreach($vv['admin_menu'] as $k => $v)
                                        <?php ++$i; ?>
                                        <td style="text-align:left;width:20%;">
                                            <input type="checkbox" name="cate_id[]" @if(in_array($v['id'],$role_mes)) checked="checked" @endif value="{{ $v['id'] }}">
                                                {{ $v['menu'] }}
                                        </td>
                                        @if($i > 5)
                                        </tr>
                                        <tr>
                                        <?php $i = 1; ?>
                                        @endif
                                    @endforeach
                                    @endforeach
                                </tr>
                            </tbody>
                        @endforeach
                        <tbody id="listcontent">
                                <tr>
                                    <td><input type="submit" name="" class="sub4_3" id="" value="添加" /></td>
                                </tr>
                        </tbody>
                    </table>
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
