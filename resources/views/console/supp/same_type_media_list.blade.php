<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>同类资源列表_喇叭传媒</title>
        @include('console.share.cssjs')
    </head>
 <style>
.tab2 ul li a {
    font-size: 24px;
    color: #2f4050;
}
</style>

<body class="fold">
@include('console.share.admin_head')
@include('console.share.admin_menu')
{{ csrf_field() }}
<div class="content"><div class="Invoice">
    <div class="place">
        <div class="place_ant"><a href="/console/index">首页</a> <a class="cur">同类资源</a> </div>
        
    </div>
    <div class="main_o clearfix" style="padding-bottom:0;">
        <h3 class="title4 clearfix">
            <strong><a href="#">同类资源</a></strong>

            <div class="search_1">
                <form method="get" name="">
                <div style="float:right;">
                    <div class="l">
                        <span>起始时间</span>
                    </div>
                    <div class="l">
                        <input type="hidden" name="id" value="{{ Request::input('id') }}">
                        <input type="text" name="start" class="txt2" id="datepicker1" value="{{ Request::input('start') }}" />-<input type="text" name="end" class="txt2" id="datepicker2" value="{{ Request::input('end') }}" />
                    </div>
                    <!-- <div class="l">
                        <select name="plate_id" class="sel1" id="mediatype">
                            {{-- @foreach($media_list as $key => $val)
                                 <option value="{{ $val['id'] }}">{{ $val['plate_name'] }}</option>
                            @endforeach --}}
                        </select>
                    </div> -->
                    <div class="l">
                        <input type="text" name="keyword" id="keyword" class="txt5" placeholder="媒体名称"  value="{{ Request::input('keyword') }}" />
                        <input type="submit" name="submit" class="sub4_3" id="searchnews" value="查询" />
                    </div>
                    <div class="l">
                        <a class="sub4_2" href="javascript:;" onclick="get_excel();" target="_blank" style="background:#7db6eb">导出明细</a>
                    </div>
                    <div class="l" style="display:none;">
                        <a class="sub4_2" href="/usermanager/add_ads" style="background:#7db6eb">创建</a>
                    </div>
                </div>
                </form>
            </div>
            <div class="clr"></div>
        </h3>
    
        <div class="dhorder_m">
            <div class="tab1_body">
<table class="table_in1 cur" id="datatable1">
    <thead>
        <tr>
            <th>序号</th>
            <th>媒体名称</th>
            <th>媒体类型</th>
            <th>供应商</th>
            <th>创建时间</th>
            <th>订单数</th>
            <th>价格</th>
            <th>状态</th>
            <th class="nosort">操作</th>
        </tr>
    </thead>
<tbody id="">
    <tr style="">
        <td>{{ $user_info['user_id'] }}</td>
        <td>{{ $user_info['media_name'] }}</td>
        <td>{{ $user_info['childPlate']['plate_name'] }}</td>
        <td>{{ $user_info['parentUser']['name'] }}</td>
        <td>{{ $user_info['created_at'] }}</td>
        <td>{{ $user_info['order_count'] }}</td>
        <td class="color1">￥{{ $user_info['proxy_price'] }}</td>
        <td>{{ getSuppUserType($user_info['is_state']) }}</td>
        <td><a class="color2" href="/usermanager/suppResourceInfo?id={{ $user_info['user_id'] }}">查看</a> &nbsp;  &nbsp; 
    @if(!empty($user_info['parent_id']))
        <label class="color2">
            <input type="checkbox" name="yunxu_jiedan" value="@if($user_info['success_order'] == 1) 2 @else 1 @endif" @if($user_info['success_order'] == 1) checked="true" @endif onclick="update_set(this);" data_id="{{ $user_info['user_id'] }}" /> 允许接单</label>
    @else
        <label class="color2">
            自营媒体
        </label>
    @endif
    </td>
    </tr>
 </tbody>
             <tbody id="listcontent">
            @foreach($lists as $key => $val)
                <tr>
                    <td>{{ $val['user_id'] }}</td>
                    <td>{{ $val['media_name'] }}</td>
                    <td>{{ $val['child_plate']['plate_name'] }}</td>
                    <td>{{ $val['parent_user']['name'] }}</td>
                    <td>{{ $val['created_at'] }}</td>
                    <td>{{ $val['order_count'] }}</td>
                    <td class="color1">￥{{ $val['proxy_price'] }}</td>
                    <td>{{ getSuppUserType($val['is_state']) }}</td>
                    <td>
                     @if(!empty($val['parent_id']))
                        <a class="color2" href="/usermanager/suppResourceInfo?id={{ $val['user_id'] }}">查看</a> &nbsp;  &nbsp; 
                     @else
                        <a class="color2" href="/usermanager/selfMedia?id={{ $val['user_id'] }}">查看</a> &nbsp;  &nbsp; 
                        
                     @endif
                    
                    @if(!empty($val['parent_id']))
                    <label class="color2">
                        <input type="checkbox" name="yunxu_jiedan" value="
                        @if($val['success_order'] == 1) 2 @else 1 @endif" onclick="update_set(this);"  
                        @if($val['success_order'] == 1) checked="true" @endif  data_id="{{ $val['user_id'] }}"/> 允许接单</label>

                    @endif
            </td>
                 </tr>
                <!-- <td>{{ $val['proxy_price'] }}</td> -->
            @endforeach
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
    var _token = $('input[name="_token"]').val();
    
    function update_set(obj)
    {
        var user_id = $(obj).attr('data_id');
        var val = $(obj).val();
        // alert(user_id);
        $.ajax({
            data:{"user_id":user_id,"val":val,'_token': _token},
            url:"/usermanager/updateSet",
            type:'post',
            dataType:'json',
            success:function(msg){
                if (msg.status_code == 200) {
                    window.location.href = window.location.href;
                } else {
                    layer.msg(msg.msg);
                }
            }
        })
    }
    function get_excel()
    {
        var hrefs = '/usermanager/resources_list?get_excel=1';
        hrefs += '&start='+$("#datepicker1").val();
        hrefs += '&end='+$("#datepicker2").val();
        hrefs += '&mediatype='+$("#mediatype").val();
        hrefs += '&username='+$("#keyword").val();
        hrefs += "&pid={{ Request::input('pid') }}";
        $("#get_excel").attr('href',hrefs);
        // alert(hre)
        window.open(hrefs);
    }
    var datatable;
    $(function () {
            var dt_option = {
                "searching" : false,        //是否允许Datatables开启本地搜索
                "paging" : true,            //是否开启本地分页
                "pageLength" : 8,           //每页显示记录数
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
                "order" : [[0,"desc"]]
            };
            datatable =  $('#datatable1').DataTable(dt_option);
            
            $("#searchnews").click(function () {
                // default_ajax();
            })
    });
 
</script>

</body>
</html>
