<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>H+ 后台主题UI框架 - 登录</title>
    <meta name="keywords" content="广州黑蜂科技有限公司">
    <meta name="description" content="广州黑蜂科技有限公司">
    <link rel="shortcut icon" href="favicon.ico">
    <link href="/console/css/bootstrap.min14ed.css?v=7.8" rel="stylesheet">
    <link href="/console/css/font-awesome.min93e3.css?v=7.8" rel="stylesheet">
    <link href="/console/css/animate.min.css?v=7.8" rel="stylesheet">
    <link href="/console/css/style.min862f.css?v=7.8" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="gray-bg">
    <div class="row  border-bottom white-bg dashboard-header">
        <div class="col-sm-12">
            <blockquote class="text-warning" style="font-size:14px">欢迎回来…
                <!-- <br>您是否一直在苦苦寻找一款适合自己的后台主题… -->
                <!-- <br>您是否想做一款自己的web应用程序… -->
                <!-- <br>………… -->
                <h4 class="text-danger">小黑蜂 为你服务</h4>
            </blockquote>

            <hr>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-success pull-right">月</span>
                        <h5>收入</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">40 886,200</h1>
                        <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i>
                        </div>
                        <small>总收入</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-info pull-right">全年</span>
                        <h5>订单</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">275,800</h1>
                        <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i>
                        </div>
                        <small>新订单</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-primary pull-right">今天</span>
                        <h5>访客</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">106,120</h1>
                        <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i>
                        </div>
                        <small>新访客</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-danger pull-right">最近一个月</span>
                        <h5>活跃用户</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">80,600</h1>
                        <div class="stat-percent font-bold text-danger">38% <i class="fa fa-level-down"></i>
                        </div>
                        <small>12月</small>
                    </div>
                </div>
            </div>
        </div>
       
        <!-- <div class="col-sm-5">
            <h2>
                            H+ 后台主题UI框架
                        </h2>
            <p>H+是一个完全响应式，基于Bootstrap3.3.6最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术，她提供了诸多的强大的可以重新组合的UI组件，并集成了最新的jQuery版本(v2.1.4)，当然，也集成了很多功能强大，用途广泛的jQuery插件，她可以用于所有的Web应用程序，如<b>网站管理后台</b>，<b>网站会员中心</b>，<b>CMS</b>，<b>CRM</b>，<b>OA</b>等等，当然，您也可以对她进行深度定制，以做出更强系统。</p>
            <p>
                <b>当前版本：</b>v4.1.0
            </p>
            <p>
                <b>定价：</b><span class="label label-warning">&yen;988（不开发票，不议价）</span>
            </p>
            <br>
            <p>
                <a class="btn btn-success btn-outline" href="http://wpa.qq.com/msgrd?v=3&amp;uin=516477188&amp;site=qq&amp;menu=yes" target="_blank">
                    <i class="fa fa-qq"> </i> 联系我
                </a>
                <a class="btn btn-white btn-bitbucket" href="http://www.zi-han.net/" target="_blank">
                    <i class="fa fa-home"></i> 访问博客
                </a>
            </p>
        </div> -->
        <!-- <div class="col-sm-4">
            <h4>H+具有以下特点：</h4>
            <ol>
                <li>完全响应式布局（支持电脑、平板、手机等所有主流设备）</li>
                <li>基于最新版本的Bootstrap 3.3.6</li>
                <li>提供3套不同风格的皮肤</li>
                <li>支持多种布局方式</li>
                <li>使用最流行的的扁平化设计</li>
                <li>提供了诸多的UI组件</li>
                <li>集成多款国内优秀插件，诚意奉献</li>
                <li>提供盒型、全宽、响应式视图模式</li>
                <li>采用HTML5 & CSS3</li>
                <li>拥有良好的代码结构</li>
                <li>更多……</li>
            </ol>
        </div> -->

    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-sm-4">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>优质服务</h5>
                    </div>
                    <div class="ibox-content">
                        <p>我们提供专业程序开发服务。</p>
                        <ol>
                            <li>定制网站开发、CRM、OA系统开发</li>
                            <li>微信公众号、小程序、网站维护</li>
                            <li>Android、ios App开发</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>联系信息</h5>
                    </div>
                    <div class="ibox-content">
                        <p><i class="fa fa-send-o"></i> 官网：<a href="" target="_blank">http://www.xxx.net</a>
                        </p>
                        <p><i class="fa fa-qq"></i> 客服QQ：<a href="http://wpa.qq.com/msgrd?v=3&amp;uin=978060266&amp;site=qq&amp;menu=yes" target="_blank">978060266</a>
                        </p>
                        <p><i class="fa fa-weixin"></i> 客服微信：<a href="javascript:;">For_Apply</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>系统说明</h5>
                    </div>
                    <div class="ibox-content">
                        <ol>
                            <li>laravel5.4 + mysql5.7；</li>
                            <li>MacOs</li>
                            <li>php7.1</li>
                            <li>……</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script id="welcome-template" type="text/x-handlebars-template">
    </script>
    <script src="/console/js/jquery.min.js?v=2.1.4"></script>
    <script src="/console/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/console/js/plugins/layer/layer.min.js"></script>
    <script src="/console/js/content.min.js"></script>
    <script src="/console/js/welcome.min.js"></script>
</body>


<!-- Mirrored from www.zi-han.net/theme/hplus/index_v1.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:18:30 GMT -->
</html>
