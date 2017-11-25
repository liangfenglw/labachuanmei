<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>新闻中心</title>
    @include('console.share.cssjs')
	<style>
	.XTxiaoxi .vip_notice{	padding-top:1px;	clear:both;	}
	.XTxiaoxi .vip_notice h3{	font-size:20px;	margin:20px 0 10px;		line-height:30px;	}
	.XTxiaoxi .vip_notice h4{	font-size:18px;	text-indent:2em;	margin:10px 0;	line-height:30px;	}
	.XTxiaoxi .vip_notice p{	text-indent:4em;	margin:0px 0;	line-height:30px;	}
	.XTxiaoxi .vip_notice p.img{	text-align:center;	text-indent:0;	}
	.XTxiaoxi .vip_notice p.img img{	max-width:100%;	}
	</style>
</head>
<body class="fold">
@include('console.share.admin_head')
@include('console.share.admin_menu')
<!--    左弹菜单 普通会员首页 -->
<div class="content"><div class="Invoice">
    <div class="banner2">
        <img src="/console/images/banner_news.jpg" width="100%">
    </div>
    
    <div class="place">
        <div class="place_ant"><a href="/console/index">首页</a><a href="/news/" class="cur">新闻中心 </a></div>
    </div>
    <div class="main_o">
        <h3 class="title5 clearfix"><strong>最新消息</strong></h3>
        <div class="dhorder_m clearfix">
            <div class="XTread">
                <div class="XTxiaoxi">
                    <h1>恭喜您升级为高级会员</h1>
                    <span>发布时间：xxxx-xx-xx xx:xx:xx  &nbsp; &nbsp;  作者：yyy</span>
                    
					<div class="vip_notice">
						
<h3>恭喜你升级为 <b>高级会员</b>，请 <b>重新登陆</b> 进入高级会员账号。</h3>

<h3><b>高级会员权限</b> 说明</h3>

<h4><b>1.</b>申请高级会员成功后，可以代理（增加）下级会员。</h4>

<p>新增会员步骤：</p>
<p>a.新增会员按钮进入；</p>
<p class="img"><img src="/console/images/vip_notice_1.png" /></p>
<br/>

<p>b.根据表格填好会员资料，<b>系统默认密码为：123456</b>，第一次登陆后请 <b>尽快修改密码</b>。</p>
<p class="img"><img src="/console/images/vip_notice_2.png" /></p>
<p class="img"><img src="/console/images/vip_notice_3.png" /></p>
<br/>

<h4><b>2.</b>下级会员提交的订单进入完成状态后，将根据本订单金额按照百分比获取收益，促进平台与高级会员的合作关系。</h4>
<p><br/></p>
<br/>
					
					</div>
					
                    <div class="sxiap">
                        <p><a href="">上一篇：xxxxxxxxxxxxx </a></p>
                        <p style="text-align:right;"><a href="">下一篇：yyyyyyyyyyyyyyyy </a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div></div>


@include('console.share.admin_foot')

</body>
</html>
