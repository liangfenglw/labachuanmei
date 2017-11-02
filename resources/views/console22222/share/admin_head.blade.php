{{-- 用户类型显示对应的头部 --}}
@if($user_type == 1) <!--管理员-->
	<div class="frame" id="top">
		<div class="logo">
			<a href="/console/index"><img src="{{url('console/images/logo.png')}}" alt="喇叭传媒" /></a>
		</div>
		<a href="javascript:;" class="sidebar-open-button"></a>
	   {{--  <a href="/order/order_feedback" class="new-message"><img src="{{url('console/images/new-message.png')}}" /><i  id="notice_count">0</i></a> --}}
	   {{--  <a href="/console/phone_order" class="new-message"><img src="{{url('console/images/new-phone.png')}}" /><i>{{ $phone_order_count }}</i></a> --}}
		<ul class="ul_top">
			<li><a href="/help/">帮助中心&nbsp; &nbsp;|&nbsp;&nbsp; 反馈</a></li>
		</ul>
		
		<div class="ITuser" style="width:280px;">
			<div class="Hlogo"><img src="@if($head_pic){{url($head_pic)}}@else{{url('console/img/bn66.png')}}@endif" /><div class="Hltext">5</div></div>
			<div class="IName">
				<p class="name">{{ $adminName }}</p>
				<p class="account">&nbsp;&nbsp;
				管理员
				&nbsp;&nbsp;
				</p>
				{{$leveName}}
				<a href="/console/logout" class="logout">退出</a>
			</div>
			<!--<div class="sidepanel-open-button"></div>-->
		</div>
		<a href="/console/phone_order" class="new-message"><img src="{{url('console/images/new-phone.png')}}" /><i>{{ $phone_order_count }}</i></a>
		<a href="/order/order_feedback" class="new-message"><img src="{{url('console/images/new-message.png')}}" /><i id="notice_count">0</i></a>

	</div>
@elseif ($user_type == 2) <!--广告主-->
    <div class="frame" id="top">
        <div class="logo">
            <a href="/console/index"><img src="{{url('console/images/logo.png')}}" alt="亚媒社" /></a>
        </div>
        <a href="javascript:;" class="sidebar-open-button"></a>
		
		<ul class="ul_top">
			<li><a href="/help/">帮助中心&nbsp; &nbsp;|&nbsp;&nbsp; 反馈</a></li>
		</ul>
		<div class="sidepanel-open-button"></div>
		<div class="ITuser">
			<div class="Hlogo"><img src="@if($head_pic){{url($head_pic)}}@else{{url('console/img/bn66.png')}}@endif" /><div class="Hltext">5</div></div>
			<div class="IName">
				<p class="name">{{ $adminName }}</p>
				<p class="account">&nbsp;&nbsp;
                 @if($user_info['certificate_status'] == 1)<!--已经认证的-->
                    已验证
                 @else <!--未认证-->
                    认证用户
                 @endif
                &nbsp;&nbsp;
                </p>
				@if($user_info['certificate_status'] == 1 && isset($user_info['certificate_status'])) <!--已经认证的-->
                    <img src="{{url('console/images/v.png')}}" />
                @else
                    <br>
                @endif
                <a href="/console/logout" class="logout">退出</a>			   
			</div>
		   
		</div>
		<a href="/order/order_feedback" class="new-message"><img src="/images/new-message.png" /><i>2</i></a>
		<div class="search_top">
			<form id="form_top" method="post" action="/search">
				<label class="w_key_ftop">
					<input type="text" name="keyword" value="{{ Request::input('keyword') }}" class="key_ftop" placeholder="搜索" /></label>
				<input type="submit" name="submit" class="sub_ftop" value="" />
			</form>
		</div>

	</div>
	
	<!--右边会员中心入口弹窗-->
    <div class="HYrukou">
        <ul>
            <li><a href="{{url('userpersonal/person_edit')}}" class="">会员资料</a></li>
            <li><a href="{{url('userpersonal/account_query')}}" class="">账户查询</a></li>
            <li><a href="{{url('userpersonal/onlnetop_up')}}" class="">账户充值</a></li>
            <li><a href="{{url('order/order_list')}}" class="">订单管理</a></li>
            <li><a href="{{url('userpersonal/person_safe')}}" class="">安全设置</a></li>
            @if($user_type == 2)
                <li><a href="/order/apply_invoice">申请发票</a></li>
            @endif
            @if($level_id == 2)
                <li><a href="/userpersonal/user_manage">代理会员管理</a></li>
                <li><a href="/userpersonal/user_add">新增会员</a></li>
            @endif
            <!-- <li><a href="{{url('cart/cart_list')}}" class="">购物车</a></li> -->
        </ul>
    </div>
	
    <!--右弹购物车-->
    <div role="tabpanel" class="sidepanel" style="display:none;">
		<div class="sidepanel-open-button" style="z-index:5; position:relative;"><img src="{{url('console/img/menu4.png')}}" /></div>
		
		<div  class="right_yingcang">
			<form action="/cart/cart_list" method="post" id="form_tcar">       <!--    car.php -->
            {{ csrf_field() }}
                <div class="IIO_nt">购物车共：<span>{{$cart_count}}</span>件</div>
				<div class="IIO_line"></div>
				<ul class="ITorder"  id="apDiv1">
					@foreach($cart_list as $key=>$value)
                    <li><a href="javascript:void(0);">
                        <div class="GWxuanxiang">
							<label class="chk_2"><input type="checkbox" name="checkItem_tcar" data_id="{{$value['order_sn']}}" data-price="{{$value['user_money']}}" /></label>
						</div>
                        <div class="IOimg"><img src="{{url('console/images/avatar.png')}}" />
                            </div>
                        <div class="IOtext">
                            <h3>{{$value['title']}}</h3>
                            <p>￥{{$value['user_money']}}</p>
                        </div>
                    </a></li>
                    @endforeach
				</ul>
				<div class="IObu">
					<p>合计 <span id="price_tcar" style="color:#f00;">0</span> 元</p>
					<input type="hidden" name="order_tcar" value="" />
					<input type="hidden" name="totalprice_tcar" value="0" />
					<input type="submit" name="button" id="button" value="提交支付" class="TOUbutton"/>
				</div>
			</form>
        </div>

    </div>
@else <!-- 供应商 -->
    <div class="frame" id="top">
		<div class="logo1">
            <a href="/console/index"><img src="{{url('console/img/supplier_headlogo.png')}}" alt="喇叭传媒" /></a>
		</div>

        <a href="javascript:;" class="sidebar-open-button"></a>
		
		<ul class="ul_top">
			<li><a href="/help/">帮助中心&nbsp; &nbsp;|&nbsp;&nbsp; 反馈</a></li>
		</ul>

		<div class="ITuser" style="width:280px;">
			<div class="Hlogo"><img src="@if($head_pic){{url($head_pic)}}@else{{url('console/img/bn66.png')}}@endif" /><div class="Hltext">5</div></div>
			<div class="IName">
				<p class="name">{{ $adminName }}</p>
				<p class="account">&nbsp;&nbsp;
                 @if($user_info['certificate_status'] == 1)<!--已经认证的-->
                    已验证
                 @else <!--未认证-->
                    认证用户
                 @endif
                &nbsp;&nbsp;
                </p>
				@if($user_info['certificate_status'] == 1 && isset($user_info['certificate_status'])) <!--已经认证的-->
                    <img src="{{url('console/images/v.png')}}" />
                @else
                    <br>
                @endif
                <a href="/console/logout" class="logout">退出</a>
			</div>
			<!--<div class="sidepanel-open-button"></div>-->
		</div>
		
		<a href="" class="new-message"><img src="{{url('console/images/new-phone.png')}}" /><i>2</i></a>
        <a href="/order/order_feedback" class="new-message"><img src="{{url('console/images/new-message.png')}}" /><i  id="notice_count">0</i></a>

    </div>
    <div class="HYrukou">
        <ul>
            <li><a href="{{url('supp/supp_edit')}}" class="">会员资料</a></li>
            <li><a href="/supp/accout_query" class="">账户查询</a></li>
            <li><a href="/supp/order" class="">订单管理</a></li>
            <li><a href="/userpersonal/person_safe" class="">安全设置</a></li>
			<li><a href="" class="">资源管理</a></li>
			<li><a href="/console/logout" class="">退出</a></li>

        </ul>
    </div>
@endif



    



