    <link href="/console/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/console/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="/console/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/console/css/style2.css" rel="stylesheet" type="text/css" />
    
    <script type="text/javascript" src="/console/js/jquery.min.js"></script>
    <script type="text/javascript" src="/console/js/layer/layer.js"></script>
    <script type="text/javascript" src="/console/js/plugins.js"></script>
    <script type="text/javascript" src="/console/js/jquery.touchslider.min.js"  type="text/javascript"></script>
    <script type="text/javascript" src="/console/js/jquery.SuperSlide.2.1.1.js"></script>
    <script type="text/javascript" src="/console/js/moment.min.js"></script>
    <script type="text/javascript" src="/console/js/date.js"></script>
    <script type="text/javascript" src="/console/js/main2.js"></script>
    <script type="text/javascript" src="/console/js/jquery.tools.min.js"></script>
    <script type="text/javascript" src="/console/js/jquery.dataTables.min.js"></script>
    
    <script type="text/javascript" src="/console/js/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" src="/console/js/ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" src="/console/js/zh-cn.js"></script>

    <link rel="stylesheet" href="/console/js/layui/css/layui.css" />
    <script type="text/javascript" src="/console/js/layui/layui.js"></script>
    <script type="text/javascript" src="/console/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/console/js/messages_zh.min.js"></script>
    <script type="text/javascript" src="/console/js/jquery.form.min.js"></script>
    <!-- 公共自定义js -->
    <script type="text/javascript" src="/console/js/public.js"></script>    
    <style type="text/css">
    /*供应商*/
    @if($user_type == 3)
        body.fold {
            background: url(/images/bg1_body.gif) repeat-y 0 0 #F3F3F4;
        }
        .INa1dd{
            width: 100%
        }
        body.fold .content {
            margin-left: 20px;
        }
    @endif
	
	.t_css table.table_in1 tbody td, table.table_in1 thead th, table.table_in1 thead td{	padding:0 0 0 15px;	}
	.t_css #listcontent td input{	margin-right:3px;	}
    </style>
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>">
    