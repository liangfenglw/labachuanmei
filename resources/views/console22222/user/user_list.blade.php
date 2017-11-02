<!DOCTYPE html>
<html>


<!-- Mirrored from www.zi-han.net/theme/hplus/table_bootstrap.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:20:03 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>H+ 后台主题UI框架 - Bootstrap Table</title>
    <meta name="keywords" content="H+后台主题,后台bootstrap框架,会员中心主题,后台HTML,响应式后台">
    <meta name="description" content="H+是一个完全响应式，基于Bootstrap3最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术">
    <link rel="shortcut icon" href="favicon.ico"> <link href="/console/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/console/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/console/css/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
    <link href="/console/css/animate.min.css" rel="stylesheet">
    <link href="/console/css/style.min862f.css?v=4.1.0" rel="stylesheet">
</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>基本</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#">选项1</a>
                        </li>
                        <li><a href="#">选项2</a>
                        </li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row row-lg">
                    <div class="col-sm-12">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="row">
                                        <form class="form-inline">
                                            <div class="form-group">
                                                <label for="exampleInputName2">昵称</label>
                                                <input type="text" class="form-control" id="exampleInputName2" placeholder="昵称" name="realname">
                                            </div>
                                            &nbsp;
                                            <div class="form-group">
                                                <label for="exampleInputEmail2">手机号</label>
                                                <input type="email" class="form-control" id="exampleInputEmail2" placeholder="手机号" name="mobile">
                                            </div>
                                            &nbsp;
                                            <label for="exampleInputEmail2">性别</label>
                                            <select class="form-control" name="sex">
                                                <option value="">请选择</option>
                                                <option value="0">未知</option>
                                                <option value="1">男</option>
                                                <option value="2">女</option>
                                            </select>
                                            &nbsp;
                                            <label for="exampleInputEmail2">是否认证</label>
                                            <select class="form-control" name="is_check">
                                                <option value="">请选择</option>
                                                <option value="1">已认证</option>
                                                <option value="2">未认证</option>
                                            </select>
                                            &nbsp;
                                            &nbsp;
                                            <button type="submit" class="btn btn-default">搜索</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clients-list">
                            <ul class="nav nav-tabs">
                                <span class="pull-right small text-muted">1406 个客户</span>
                            </ul>
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="slimScrollDiv" style="position: relative; width: auto; height: 100%;"><div class="full-height-scroll" style="width: auto; height: 100%;">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <th>id</th>
                                                    <th>头像</th>
                                                    <th>昵称</th>
                                                    <th>手机号</th>
                                                    <th>认证</th>
                                                    <th>创建时间</th>
                                                    <th>操作</th>
                                                </thead>
                                                <tbody>
                                                    @foreach($customerList as $customer)
                                                        <tr>
                                                            <td>{{ $customer->id }}</td>
                                                            <td class="client-avatar">
                                                                <img alt="image" src="img/a2.jpg">
                                                            </td>
                                                            <td>
                                                                <a data-toggle="tab" href="#contact-1" class="client-link">{{ $customer->realname }}</a>
                                                            </td>
                                                            <td>{{ $customer->mobile }}</td>
                                                            <td class="client-status">
                                                                <span class="label label-primary">已验证</span>
                                                            </td>
                                                            <td>{{ $customer->created_at }}</td>
                                                            <td>查看 | 删除</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                  <!--   <div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 4px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;"></div><div class="slimScrollRail" style="width: 4px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div> -->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Panel Basic -->
    </div>
    <script src="/console/js/jquery.min.js?v=2.1.4"></script>
    <script src="/console/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/console/js/content.min.js?v=1.0.0"></script>
    <script src="/console/js/plugins/bootstrap-table/bootstrap-table.min.js"></script>
    <script src="/console/js/plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script>
    <script src="/console/js/plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>
    <script src="/console/js/demo/bootstrap-table-demo.min.js"></script>
</body>


<!-- Mirrored from www.zi-han.net/theme/hplus/table_bootstrap.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:20:06 GMT -->
</html>
