@if($user_type == 2)
<div class="s1_tab">
    <ul class="clearfix">
        @if($level_id == 2)
        <li class="@if($active == 'user_manage')cur @endif"><a href="/userpersonal/user_manage">代理会员管理</a></li>
        @endif
        <li class="@if($active == 'order_manage')cur @endif"><a href="/order/order_list">订单管理</a></li>
        <li class="@if($active == 'account_query')cur @endif"><a href="/userpersonal/account_query">账户查询</a></li>
        <li class="@if($active == 'Onlnetop_up')cur @endif"><a href="/userpersonal/onlnetop_up">账户充值</a></li>
        <li class="@if($active == 'person_edit')cur @endif"><a href="{{url('userpersonal/person_edit')}}">用户信息</a></li>
        @if($level_id == 2)
            <li class="@if($active == 'user_add')cur @endif"><a href="/userpersonal/user_add">新增会员</a></li>
        @else
            <li class="" onclick="apply_vip()"><a href="javascript:;">申请会员</a></li>
        @endif
    </ul>
</div>
@else
<div class="s1_tab">
    <ul class="clearfix">
        <li class="@if($active == 'order_list')cur @endif"><a href="/supp/order">订单管理</a></li>
        <li class="@if($active == 'account_query')cur @endif"><a href="/supp/accout_query">账户查询</a></li>
        <li class="@if($active == 'person_safe')cur @endif"><a href="/userpersonal/person_safe">安全设置</a></li>
        <li class="@if($active == 'supp_edit')cur @endif"><a href="{{url('supp/supp_edit')}}">用户信息</a></li>
        <li class="@if($active == 'resource')cur @endif"><a href="{{url('supp/resource')}}">资源管理</a></li>
    </ul>
</div>
@endif
