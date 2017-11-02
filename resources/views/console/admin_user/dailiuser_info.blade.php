<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>会员详情</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    @include('console.share.cssjs')
    
    <style>

    </style>
</head>
<body class="fold">         <!--    class="fold" 左导航收缩  -->

@include('console.share.admin_head')
@include('console.share.admin_menu')          <!--    左弹菜单 普通会员首页 -->


<div class="content"><div class="Invoice">

    <div class="place">
         <div class="place_ant"><a href="/console/index">首页</a><a >用户管理 </a><a  class="cur">会员详情 </a></div>
    </div>
    
    <div class="main_o clearfix" style="padding-bottom:20px;">
		
		<div class="tab2">
			<ul class="clearfix" style="float:left;">
				<li class=""><a href="">会员管理</a></li>
				<li class="cur"><a href="javascript:void(0);">代理会员</a></li>
			</ul>
		</div>

        <div class="safe_1 clearfix">
            <div class="wrap_fl clearfix" style="width:35%;">
			
		
                <form action="/user/ad_user/update" method="post">
                    {!! csrf_field() !!}
                    <input type="hidden" name="user_id" value="{{ $info['user_id'] }}">
                    <div class="item_f"><p><i class="LGntas"></i>用户名：</p>
                        <div class="r">
                        <input type="text" name="nickname" id="textfield" class="txt_f1" style="width:75%;" value="{{ $info['nickname'] }}"></div>
                    </div>
<!--
                    <div class="item_f"><p><i class="LGntas"></i>所属会员：</p>
                        <div class="r"><input type="text" name="textfield" id="textfield" value="@if($info['parent_user']) @endif" readonly="readonly" class="txt_f1" style="width:75%;"></div>
                    </div>
-->
                    <div class="item_f"><p><i class="LGntas"></i>创建时间：</p>
                        <div class="r"><input type="text" name="textfield" id="datepicker3" class="txt_f1" style="width:75%;" value="{{ $info['created_at'] }}" readonly="readonly"></div>
                    </div>
                    <div class="item_f"><p style="padding-top:25px;"><i class="LGntas"></i>会员头像：</p>
                        <div class="r" style="position:relative;">
                            <div class="img_show">
                                <img src="{{$info['user']['head_pic']}}" style="cursor:pointer;float:left;margin-right:8px;width:130px; height:130px;" />
                                <input type="file" name="Documents" id="documents_upload_button" class="txt6 txt6_up upfile upload_f1" accept="image/jpg,image/jpeg,image/png" style="width:130px;height:130px;display:none;opacity:0;"	/>
                            </div>
                            <span class="info1_f valign_m" style="height:95px;padding:0;">
                                <i>*</i> 请点击选择图片，仅支持JPG、JPEG、GIF、PNG格式的图片文件，文件不能大于2MB。
                            </span>
                            <!-- <input type="file" name="Documents" id="documents_upload_button" placeholder="未选择任何文件" class="upload_f1" accept="image/jpg,image/jpeg,image/png" style="" />
                             -->
                        </div>
                    </div>
                    <div class="item_f"><p><i class="LGntas"></i>昵称：</p>
                        <div class="r"><input type="text" value="{{ $info['nickname'] }}" name="nickname" id="textfield" class="txt_f1" style="width:75%;"></div>
                    </div>
                    <div class="item_f"><p><i class="LGntas"></i>联系电话：</p>
                        <div class="r"><input type="text" value="{{ $info['mobile'] }}" name="mobile" id="textfield" class="txt_f1" style="width:75%;"></div>
                    </div>
                    <div class="item_f"><p><i class="LGntas"></i>联系QQ：</p>
                        <div class="r"><input type="text" value="{{ $info['qq'] }}" name="qq" id="textfield" class="txt_f1" style="width:75%;"></div>
                    </div>
                    <div class="item_f"><p><i class="LGntas"></i>邮箱：</p>
                        <div class="r"><input type="text" value="{{ $info['email'] }}" name="email" id="textfield" class="txt_f1" style="width:75%;"></div>
                    </div>
                    <div class="item_f"><p><i class="LGntas"></i>联系地址：</p>
                        <div class="r"><input type="text" name="address" value="{{ $info['address'] }}" id="textfield" class="txt_f1" style="width:75%;"></div>
                    </div>
                    @if(in_array($info['check_status'], [2]))
                        <div class="item_f"><p><i class="LGntas"></i>状态：</p>
                            <div class="r radio_w">
                                <label class="rd1"><input type="radio" name="check_status" class="radio_f" value="4" />通过</label>
                                <label class="rd1"><input type="radio" name="check_status" class="radio_f" value="3" />不通过</label>
                            </div>
                        </div>
                    @endif
                    <div class="item_f item_f_2" style="margin-top:20px;">
                        <div class="r"><input type="submit" value="提 交" class="sub5" style="margin-left:0;" /></div>
                    </div>
                </form>
            </div>
            
            <div class="wrap_fr" style="width:47%;margin-right:2%;">
                <div class="wrap_fr3">
                    <h3 style="padding-bottom:0;">一周订单统计数据表</h3>
               		 <!--    柱状图
                    <div class="" id="tb_hv1"></div> -->
					<div class="tb_box3" id="tb_av1"></div>
                    
                    <h3 style="color:#747474;margin-top:60px; text-align:left;">盈利状况</h3>
                    <div class="clearfix">
                        <div class="l row3_22">
                        {{--高级会员 --}}
                            @if($info['level_id'] == 2)
                                <ul>
                                    <li class="li1"><p>帐户总金额<br/><b>￥{{$info['user_money']}}</b></p></li>
                                    <li class="li2"><p>平台纯收益<br/><b>￥1100.00</b></p></li>
                                    <li class="li3"><p>所属会员总金额<br/><b>￥1100.00</b></p></li>
                                </ul>
                            @elseif($info['level_id'] == 1)
                                <ul style="padding-top:18px;">
                                    <li class="li1"><p>帐户总金额<br/><b>￥{{$info['user_money']}}</b></p></li>
                                    <li class="li2"><p>消费总金额<br/><b>￥{{ $used_money }}</b></p></li>
                                </ul>
                            @endif

                            
                        
                        </div>
                    	<!--    饼状图 
                        <div class="r " id="tb_hv2"></div>-->
                        <div class="r tb_box4" id="tb_av2"></div>
                    </div>
                    
                </div>
            </div>
                
        </div>
        
    </div>
    
    
    
    <div class="main_o clearfix" style="padding-bottom:0;">
    
        <h3 class="title3" style="padding:20px 30px 0 20px;"><strong>订单明细</strong>
             <a class="sub4_2" href="#" style="float:right; margin:5px 0 0 0;background: #7db6eb;">导出列表</a>
        </h3>


        <h3 class="title4 clearfix">
            <div class="search_1" style="float:none;margin-left:55px;margin-right:30px;">
<!--
                <form action="" method="" name="">
-->
                <div style="float:left;">
                    <div class="l">
                        <span>起始时间</span>
                    </div>
                    <div class="l">
                        <input type="text" class="txt2" id="datepicker1" />-<input type="text" class="txt2" id="datepicker2" />
                    </div>
                    <div class="l">
                        <select name="plate_name" class="sel1" id="mediatype">
                            @foreach($media as $key => $val)
                                <option value="{{ $val['id'] }}">{{ $val['plate_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="l">
                        <input type="text" name="keyword" id="keyword" class="txt5" placeholder="订单号" />
                        <input type="submit" name="submit" class="sub4_3" id="searchnews" value="查询" />
                    </div>
                </div>
               
            </div>
            <div class="clr"></div>
        </h3>
    
        <div class="dhorder_m">
            <div class="tab1_body">
                <table class="table_in1 cur" id="datatable1">
                    <thead>
                        <tr>
                            <th>订单号</th>
                            <th>稿件名称</th>
                            <th>稿件类型</th>
                            <th>开始时间</th>
                            <th>结束时间</th>
                            <th>平台价格</th>
                            <th>订单状态</th>
                            <th>完成链接/截图</th>
                        </tr>
                    </thead>
                    <tbody id="listcontent">
                    </tbody>
                </table>
            </div>
        </div>

                            
    </div>  

</div></div>
@include('console.share.admin_foot') 
<script>
/*  日历  */
    if( $('#datepicker1').length>0 && typeof(picker1)!="object" ){
        var picker1 = new Pikaday({
            field: document.getElementById('datepicker1'),
            firstDay: 1,
            format: "YYYY-MM-DD",
            minDate: new Date('2000-01-01'),
            maxDate: new Date('2020-12-31'),
            yearRange: [2000,2020]
        });
    }
    if( $('#datepicker2').length>0 && typeof(picker2)!="object" ){
        var picker2 = new Pikaday({
            field: document.getElementById('datepicker2'),
            firstDay: 1,
            format: "YYYY-MM-DD",
            minDate: new Date('2000-01-01'),
            maxDate: new Date('2020-12-31'),
            yearRange: [2000,2020]
        });
    }
    if( $('#datepicker3').length>0 && typeof(picker3)!="object" ){
        var picker3 = new Pikaday({
            field: document.getElementById('datepicker3'),
            firstDay: 1,
            format: "YYYY-MM-DD",
            minDate: new Date('2000-01-01'),
            maxDate: new Date('2020-12-31'),
            yearRange: [2000,2020]
        });
    }

    var datatable;
    $(function () {
            get_ajax_list();
            var dt_option = {
                "searching" : false,        //是否允许Datatables开启本地搜索
                "paging" : true,            //是否开启本地分页
                "pageLength" : 5,           //每页显示记录数
                "lengthChange" : false,     //是否允许用户改变表格每页显示的记录数 
                "lengthMenu": [ 5, 10, 100 ],       //用户可选择的 每页显示记录数
                "info" : true,
                "columnDefs" : [{
                    "targets": 'nosort',
                    "orderable": false
                }],
                "pagingType": "simple_numbers",
                "language": {
                    "search": "搜索",
                    sZeroRecords : "没有查询到数据",
                    "info": "显示第 _PAGE_/_PAGES_ 页，共_TOTAL_条",
                    "infoFiltered": "(筛选自_MAX_条数据)",
                    "infoEmpty": "没有符合条件的数据",
                    oPaginate: {    
                        "sFirst" : "首页",
                        "sPrevious" : "上一页",
                        "sNext" : "下一页",
                        "sLast" : "尾页"    
                    },
                    searchPlaceholder: "过滤..."
                },
                "order" : [[3,"desc"]]
            };
            datatable =  $('#datatable1').DataTable(dt_option);
            
//          var _token = $('input[name="_token"]').val();
            $("#searchnews").click(function () {
                get_ajax_list();
            })
    });
function get_ajax_list() {
    $.ajax({
        type:"get",
        url:"/user/get_ads_orderlist",
        dataType: 'html',
        data:{
            'start':$("#datepicker1").val(),
            'end':$("#datepicker2").val(),
            'mediatype':$("#mediatype").val(),
            'orderid':$("#keyword").val(),
            'user_id':"{{ $info['user_id'] }}",
        },
        success:function (msg) {
            console.log("msg:" + msg);
            if (msg) {
                if( $.fn.dataTable.isDataTable(" #datatable1 ") ){
                    datatable.destroy();
                }
                $('#listcontent').html(msg);
                datatable =  $('#datatable1').DataTable(dt_option);
            } else {
                if( $.fn.dataTable.isDataTable(" #datatable1 ") ){
                    datatable.destroy();
                }
                $('#listcontent').html("<tr><td colspan='10'>没有查询到数据！</td></tr>");          //7 表格列数
            }
        }
    })
}  
// 普通会员
@if($info['level_id'] == 1)
/*  柱状图 */
if( $('#tb_hv1').length > 0 ){
    var myChart_hv1 = echarts.init(document.getElementById('tb_hv1'));
    option_hv1 = {
        color: ['#3398DB'],
        tooltip : {
            trigger: 'axis',
            axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis : [
            {
                type : 'category',
                data : ["{{$plate_data['35']['plate_name']}}", "{{$plate_data['37']['plate_name']}}", "{{$plate_data['38']['plate_name']}}", "{{$plate_data['39']['plate_name']}}", "{{$plate_data['40']['plate_name']}}", "{{$plate_data['41']['plate_name']}}", "{{$plate_data['42']['plate_name']}}","{{$plate_data['43']['plate_name']}}"],
                axisTick: {
                    alignWithLabel: true
                }
            }
        ],
        yAxis : [
            {
                type : 'value'
            }
        ],
        series : [
            {
                name:'直接访问',
                type:'bar',
                barWidth: '60%',
                data:[{{$plate_data['35']['order_count']}}, {{$plate_data['37']['order_count']}}, {{$plate_data['38']['order_count']}}, {{$plate_data['39']['order_count']}}, {{$plate_data['40']['order_count']}}, {{$plate_data['41']['order_count']}}, {{$plate_data['42']['order_count']}},{{$plate_data['43']['order_count']}}]
            }
        ]
    };
    myChart_hv1.setOption(option_hv1);
}

/*  饼状图 */
if( $('#tb_hv2').length > 0 ){
    var myChart_hv2 = echarts.init(document.getElementById('tb_hv2'));
    option_hv2 = {
        title : {
            text: '会员账户金额分布统计图',
            subtext: '今天天气',
            x:'75',
            y:'bottom',
            textStyle:{
                fontSize: '14',
                color: '#c23531',
                fontWeight: 'normal'
            }
        },
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            orient: 'vertical',
            left: 'left',
            data: ['充值金额','提现金额','订单消费金额']
        },
        series : [
            {
                name: '访问来源',
                type: 'pie',
                radius : '55%',
                center: ['60%', '55%'],
                data:[
                    {value:{{ $rechange }}, name:'充值金额'},
                    {value:{{ $get_cash }}, name:'提现金额'},
                    {value:{{ $used_money }}, name:'订单消费金额'}
                ],
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };
    myChart_hv2.setOption(option_hv2);
}
@elseif($info['level_id'] == 2)
/*  柱状图 */
if( $('#tb_hv1').length > 0 ){
    var myChart_hv1 = echarts.init(document.getElementById('tb_hv1'));
    option_hv1 = {
        color: ['#3398DB'],
        tooltip : {
            trigger: 'axis',
            axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis : [
            {
                type : 'category',
                data : ["{{$plate_data['35']['plate_name']}}", "{{$plate_data['37']['plate_name']}}", "{{$plate_data['38']['plate_name']}}", "{{$plate_data['39']['plate_name']}}", "{{$plate_data['40']['plate_name']}}", "{{$plate_data['41']['plate_name']}}", "{{$plate_data['42']['plate_name']}}","{{$plate_data['43']['plate_name']}}"],
                axisTick: {
                    alignWithLabel: true
                }
            }
        ],
        yAxis : [
            {
                type : 'value'
            }
        ],
        series : [
            {
                name:'直接访问',
                type:'bar',
                barWidth: '60%',
                data:[{{$plate_data['35']['order_count']}}, {{$plate_data['37']['order_count']}}, {{$plate_data['38']['order_count']}}, {{$plate_data['39']['order_count']}}, {{$plate_data['40']['order_count']}}, {{$plate_data['41']['order_count']}}, {{$plate_data['42']['order_count']}},{{$plate_data['43']['order_count']}}]
            }
        ]
    };
    myChart_hv1.setOption(option_hv1);
}

/*  饼状图 */
if( $('#tb_hv2').length > 0 ){
    var myChart_hv2 = echarts.init(document.getElementById('tb_hv2'));
    option_hv2 = {
        title : {
            text: '会员账户金额分布统计图',
            subtext: '今天天气',
            x:'75',
            y:'bottom',
            textStyle:{
                fontSize: '14',
                color: '#c23531',
                fontWeight: 'normal'
            }
        },
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            orient: 'vertical',
            left: 'left',
            data: ['平台纯收益','充值金额','提现金额','订单消费金额']
        },
        series : [
            {
                name: '访问来源',
                type: 'pie',
                radius : '55%',
                center: ['60%', '55%'],
                data:[
                    {value:0, name:'平台纯收益'},
                    {value:{{ $rechange }}, name:'充值金额'},
                    {value:{{ $get_cash }}, name:'提现金额'},
                    {value:{{ $used_money }}, name:'订单消费金额'}
                ],
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };
    myChart_hv2.setOption(option_hv2);
}
@endif

</script>

</body>
</html>
