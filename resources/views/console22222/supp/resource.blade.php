<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>资源管理_供应商 - 亚媒社</title>
    @include('console.share.cssjs') 
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->
@include('console.share.admin_head')
@include('console.share.admin_menu')

<div class="content"><div class="Invoice">
    @include('console.share.user_menu')
    <div class="place">
        当前位置：<a href="/console/index">首页</a> > 订单管理
    </div>
    
    <div class="main_o">
        
        <h3 class="title4"><strong><a href="javascript:;">资源推荐</a></strong>
            <ul class="add_resource2">
                @foreach($plate_lists as $key => $val)
                    <li><a href="/supp/resource/{{ $val['id'] }}">添加{{$val['plate_name']}}</a></li>
                @endforeach
            </ul>
        </h3>
        <div class="dhorder_m">
            <div class="tab1 2">
                <strong class="l" style="font-size:24px;font-weight:400;color:#000000;">资源管理</strong>
                <ul>
                    @foreach($child_plate as $key => $val)
                        <li onclick="window.location='/order/order_appeal'" @if($key == 0) class="cur" @endif @if(Request::input('tid') == $val['id']) class="cur" @endif ><a  >{{ $val['plate_name'] }}({{ $val['res_count'] }})</a></li>
                    @endforeach
                </ul>
            </div>
            
            <div class="tab1_body" style="min-height:515px;">
                @foreach($child_plate as $key => $val)
                    <table class="table_in1 @if($key == 0) cur @endif">
                        <thead>
                            <tr>
                                <th style="width:18%;">资源名称</th>
                                <th>资源类型</th>
                                <th>价格</th>
                                <th>订单数</th>
                                <th>审核状态</th>
                                <th>是否上架</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($val['lists'] as $kk => $vv)
                                <tr>
                                    <td class="logo-title"><img src="{{ $vv['media_logo'] }}">{{$vv['name']}}</td>
                                    <td>{{ $val['plate_name'] }}</td>
                                    <td class="color1">￥{{ $vv['proxy_price'] }}</td>
                                    <td>0</td>
                                    <td>{{$state_status[$vv['is_state']]}}</td>
                                    <td class="color1">{{ $media_status[$vv['is_state']] }}</td>
                                    <td><a href="/supp/resource/info/{{ $vv['id'] }}" class="color2">查看</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>
            
            <div style="padding:50px 33px 10px;background:#fff;">
                <div class="info_hdorder clearfix">
                    <strong>资源统计</strong>
                    <ul>
                        <li>资源总数：  {{ $all['res_count'] }}</li>
                        <li>审核通过：   {{ $all['res_success'] }}</li>
                        <li>下架资源：   {{ $all['res_del'] }}</li>
                        <li>待审核：   {{ $all['res_check'] }}</li>
                        <!-- <li>平台数：  0</li> -->
                    </ul>
                </div>
            </div>
            
        </div>

    </div>  

</div></div>
@include('console.share.admin_foot')

<script type="text/javascript">

</script>

</body>
</html>