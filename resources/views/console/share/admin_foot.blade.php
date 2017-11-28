
<div id="current_url" style="display:none;">{{Request::getRequestUri()}}</div>
<div class="foot">
    <p>© 1997-2017 版权所有</p>
    <div class="" id="go_top"><a title="返回顶部" href="javascript:;"></a></div>
</div>

<div class="float_serv">
    <ul>
        <li class="serv_1"><a title="xxxx1" href=""></a></li>
        <li class="serv_2"><a title="xxxx2" href=""></a></li>
        <li class="serv_3"><a title="xxxx3" href=""></a></li>
        <li class="serv_4"><a title="电话：135 0000 0000" href=""></a></li>
        <li class="serv_5"><a title="xxxx5" href=""></a></li>
    </ul>
</div>
@include('console.share.nav')
<script type="text/javascript" src="/console/js/echarts.min.js"></script>
<!-- <script type="text/javascript" src="/console/js/jquery.min.js"></script> -->
<script>
function check_notice() {
    $.ajax({
        type:"post",
        url:"/api/check_notice",
        async:"false",
        success:function(msg){
            if (msg.status_code == 200) {
                $("#notice_count").text(msg['msg']);
                setTimeout("check_notice()","5000");
            }
        }
    })
}
function apply_vip() {
	
 //   window.location.href="/userpersonal/apply_vip";
	// layer.closeAll('page'); 

    $.ajax({
        url:"/userpersonal/apply_vip",
        type:'get',
        success:function(msg){
            if (msg.status_code == 200) {
                layer.msg(msg.msg,{time:5000});
                
            }
            if (msg.status_code == 201) {
                layer.msg(msg.msg,{time:5000});
            }
            layer.closeAll('page'); 

        }
    })
}
$(function(){
    @if($user_type == 2 || $user_type == 3)
        check_notice();
    @endif
})
$(function(){
    @if (session('status'))
        layer.msg("{{ session('status') }}");
    @endif
})
$(function(){
    @if (session('error'))
        layer.msg("{{ session('error') }}");
    @endif
})
        
/*  右弹购物车滚动条    */
var t1=TouchScroll('apDiv1',{vOffset:0,mouseWheel:true,keyPress:false,color:'#999'})
$(function(){
    
    /*  右边会员中心入口弹窗  */
    $(".ITuser").click(function(){
        $(".HYrukou").toggle();
    });
    // 电话工单的提交
    $("#phone_order_sub").click(function(){
        var phone_num = $("#phone_order_num").val();
        if (phone_num) {
            $.ajax({
                data:{"_token":$('meta[name="csrf-token"]').attr('content'),"phone_num":phone_num},
                type:"post",
                dataType:"json",
                url:"/phone/add",
                async:false,
                success:function(msg) {
                    if (msg.status_code == 200) {
                        layer.msg(msg['msg']);
                    } else {
                        layer.msg(msg['msg']);
                    }
                    $("#phone_order_num").val('');
                }
            })
        }
    })
    /*  顶部购物车提交 */
    countPrice_tcar();
    $("#button").click(function(){
        var id = "";
        if( $("#apDiv1 li input[name=checkItem_tcar]:checked").length>0 ){
            $("#apDiv1 li input[name=checkItem_tcar]:checked").each(function(){
                var data_id = $(this).attr("data_id");
                if( id == "" ){
                    id += data_id;
                }else{
                    id += "," + data_id;
                }
            });
            $("input[name='order_tcar']").val(id);
            $("#form_tcar").submit();
        }else{
            layer.msg('已选商品不能为空');
            return false;
        }
    });
	$(".chk_2").click(function(){
		if( $(this).find("input")[0].checked == true ){
			$(this).addClass("on");
		}else{
			$(this).removeClass("on");
		}
	});
    $("#apDiv1 li input[name=checkItem_tcar]").change(function(){
        countPrice_tcar();
    });
    function countPrice_tcar(){         /*  计算总金额   */
        var totalprice = 0;
        $("#apDiv1 li input[name=checkItem_tcar]:checked").each(function(){
            var price = $(this).attr("data-price");
            totalprice = ( parseFloat(totalprice) + parseFloat(price) ).toFixed(2);
        });
        $("input[name='totalprice_tcar']").val(totalprice);
        $("#price_tcar").html(totalprice);
    }


	$(".rd1").click(function(){
		$(this).addClass("css_cur").siblings("label").removeClass("css_cur");
//		$(this).find("input")[0].checked == true;
	});
	$(".disabled_rd .rd1").unbind("click");


    /*  返回顶部    */
    $(window).scroll(function(){
        if($(window).scrollTop()>=1){
            $("#go_top").show();
        }else{
            $("#go_top").hide();
        }
    }); 
    $("#go_top a").click(function(){
        $("body,html").animate({scrollTop:0},500);
        return false;
    });

    
    
    var winh = $(window).height(),
        minh = winh - 63 - 50,
        Invh = $(".Invoice").height();
//  $(".Invoice").css("min-height",minh);
    $(".sidebar").css("min-height",minh);
    
	
//	当前导航高亮
	var current_url = $.trim($("#current_url").html());
	if( current_url != "" && current_url != "#" ){
//		console.log("current_url:",current_url);;
		$(".sidebar ul li a").each(function(){
			var url = $.trim( $(this).attr("href") );
//			console.log("url:",url);;
			if( url == current_url ){
				$("body").removeClass("fold");
				if( $(this).closest("div.header").length > 0 ){
					$(this).closest("div.header").addClass("inactives");
				}else{
					$(this).closest("li").addClass("cur")
						.closest("ul").show()
							.prev(".header").addClass("inactives");
//					$(this).addClass("cur");
				}
			}
		});
	}
	
	//上传图片
	$(".img_show img").click(function(){
		$(this).closest(".img_show").find(".upfile").click();
	});
	$('.img_show').each(function(){
		var $this = $(this),
		btn = $this.find('.upfile'),
		img = $this.find('img');
		btn.on('change',function(){
			var file = $(this)[0].files[0];
//			console.log(typeof(file));
			if( typeof(file) == 'undefined' ){
				console.log("no file");
				if( typeof(img.attr("data-src")) != 'undefined' ){
					img.attr('src',img.attr("data-src"));
				}
				return false;
			}
			var imgSrc = $(this)[0].value;
			var url = URL.createObjectURL(file);
			if (!/\.(jpg|jpeg|png|JPG|gif|GIF|PNG|JPEG)$/.test(imgSrc)){
				alert("请上传jpg或png格式的图片！");
				return false;
			}else{
				img.attr('src',url);
				img.css({'opacity':'1'});
			}
		});
	});

	//媒体选择隐藏右边的 更多
	if( $(".sbox_1_item div.m").length > 0 ){
		$(".sbox_1_item div.m").each(function(){
			var width_w = $(this).width();
			var width = $(this).find("ul").width();
		//	console.log("width_w",width_w);
		//	console.log("width",width);
			if( width_w > width +1 ){
				$(this).siblings("span.r").hide();
			}else{
				$(this).siblings("span.r").show();
			}		
		});
	}
});

</script>
<script type="text/javascript" src="/console/js/charts.js"></script>