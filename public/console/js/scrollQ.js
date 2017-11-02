/*
 *   
 * jQuery scrollQ plugin li���¹������ 
 * numline ÿ����ʾli����  
 * animateTime	�����ٶ�	ÿ�ι���һ�ж�������ʱ��	��λ���� 
 * scrollTime	�����ٶ�	���ι������ʱ��			��λ���� 
 * direction	��������	���������					Ĭ������
	������� ul��ȴ��	��	10000px
	���Ϲ��� ul���С��	��	900px
 * clickloop	ѭ�����������ʱ ����/�Ϲ�������һҳ�������������һҳ......
 * autorun		yes Ϊ�Զ���������������ƿ�ʱ�������ſ�ʱ�������� no ���Զ�����
	$("#scroll_1").scrollQ2({
		numline:4,
		animateTime:150,
		scrollTime:2500,
		direction:"top",
		leftbutton:".l_box_41",
		rightbutton:".r_box_41",
		clickloop:"yes",
		autorun:"yes"
	});
	�� id�� �����ã�������������⣬��������������Ҳ����Ҫ�� ul ����id��
	��Ҫע�� li �� margin-left �� margin-top �� border ����ö���Ҫ�ӣ�������λ��Ҫ�ٸ�
 */ 
(function($){    
    $.fn.scrollQ2 = function(options){    
        var defaults = {    
            numline:6,
            animateTime:300,
            scrollTime:2000,
			direction:"left",
			leftbutton:".l_box_scroll",
			rightbutton:".r_box_scroll",
			clickloop:"yes",
			autorun:"yes"
        }  
        var options=jQuery.extend(defaults,options);  
        var _self = this;  
		var num=$("li",_self).length;
		var line=Math.ceil(num/options.numline);
		var marginBottom=parseInt($("li",_self).css("margin-bottom"));
		var marginRight=parseInt($("li",_self).css("margin-right"));
		var height=parseInt($("li",_self).css("height"));
			height+=marginBottom;
			height=height*options.numline;
		var width=parseInt($("li",_self).css("width"));
			width+=marginRight;
			width=width*options.numline;
		var id=$(_self).attr("id");
//		alert(" num:"+num+";\r\n line:"+line+";\r\n height:"+width);
//		alert(defaults.direction);
		function scroll_2(){
			if( options.direction=="top" ){
				var top=parseInt($("li",_self).css("top"));
				top-=height;
				if( top < -(line-1)*height ){	top=0;	}
				var data=$("#"+id).attr("data");
				if( isNaN(data) ){	data=1;	}
				data=data-(-1);
				if( data>line ){	data=1;	}
				$("#"+id).attr("data",data);
				$("li",_self).stop(true).animate({"top":top},options.animateTime);
				if( $("#"+id).next("ol").length>0 ){
					$("#"+id).next("ol").find("li:eq("+(data-1)+")").addClass("on").siblings("li").removeClass("on");
				}
			}else{
				var left=parseInt($("li",_self).css("left"));
				left-=width;
				if( left < -(line-1)*width ){	left=0;	}
				var data=$("#"+id).attr("data");
				if( isNaN(data) ){	data=1;	}
				data=data-(-1);
				if( data>line ){	data=1;	}
				$("#"+id).attr("data",data);
				$("li",_self).stop(true).animate({"left":left},options.animateTime);
				if( $("#"+id).next("ol").length>0 ){
					$("#"+id).next("ol").find("li:eq("+(data-1)+")").addClass("on").siblings("li").removeClass("on");
				}
			}
		}
		
		$("#"+id).next("ol").find("a").bind("click",function(){
			if( options.direction=="top" ){
				var cur=$(this).parent("li").index();			
				var top=parseInt($("li",_self).css("top"));
				top=-cur*height;
				$("#"+id).attr("data",cur-(-1));
				$(this).parent("li").addClass("on").siblings("li").removeClass("on");
				$("li",_self).stop(true).animate({"top":top},options.animateTime);
			}else{
				var cur=$(this).parent("li").index();			
				var top=parseInt($("li",_self).css("left"));
				left=-cur*width;
				$("#"+id).attr("data",cur-(-1));
				$(this).parent("li").addClass("on").siblings("li").removeClass("on");
				$("li",_self).stop(true).animate({"left":left},options.animateTime);			
			}
			return false;
		});
		
		if( $(options.leftbutton).length>0 ){
			$(options.leftbutton).bind("click",function(){
				var data=$("#"+id).attr("data");
				if( isNaN(data) ){	data=1;	}
				data=data-1;
				if( options.clickloop=="yes" ){
					if( data<1 ){	data=line;	}
				}else{
					if( data<1 ){	data=1;	}
				}
				$("#"+id).attr("data",data);
				var left=-(data-1)*width;
				var top=-(data-1)*height;
//				if( left < -(line-1)*width ){	left=0;	}
//				if( top < -(line-1)*height ){	top=0;	}
				if( options.direction=="top" ){
					$("li",_self).stop(true).animate({"top":top},options.animateTime);
					if( $("#"+id).next("ol").length>0 ){
						$("#"+id).next("ol").find("li:eq("+(data-1)+")").addClass("on").siblings("li").removeClass("on");
					}
				}else{
					$("li",_self).stop(true).animate({"left":left},options.animateTime);
					if( $("#"+id).next("ol").length>0 ){
						$("#"+id).next("ol").find("li:eq("+(data-1)+")").addClass("on").siblings("li").removeClass("on");
					}
				}
				return false;
			});
			$(options.leftbutton).bind("mouseover",function(){  
				clearInterval(timer);  
			});  
			$(options.leftbutton).bind("mouseout",function(){  
				if( options.autorun=="yes" ){
					timer = setInterval(scroll_2,options.scrollTime);  
				}
			});
		}
		
		if( $(options.rightbutton).length>0 ){
			$(options.rightbutton).bind("click",function(){
				var data=$("#"+id).attr("data");
				if( isNaN(data) ){	data=1;	}
				data=data-(-1);
				if( options.clickloop=="yes" ){
					if( data>line ){	data=1;	}
				}else{
					if( data>line ){	data=line;	}
				}
				$("#"+id).attr("data",data);
				var left=-(data-1)*width;
				var top=-(data-1)*height;
//				if( left < -(line-1)*width ){	left=0;	}
//				if( top < -(line-1)*height ){	top=0;	}
				if( options.direction=="top" ){
					$("li",_self).stop(true).animate({"top":top},options.animateTime);
					if( $("#"+id).next("ol").length>0 ){
						$("#"+id).next("ol").find("li:eq("+(data-1)+")").addClass("on").siblings("li").removeClass("on");
					}
				}else{
					$("li",_self).stop(true).animate({"left":left},options.animateTime);
					if( $("#"+id).next("ol").length>0 ){
						$("#"+id).next("ol").find("li:eq("+(data-1)+")").addClass("on").siblings("li").removeClass("on");
					}
				}
				return false;
			});
			
			$(options.rightbutton).bind("mouseover",function(){  
				clearInterval(timer);  
			});  
			$(options.rightbutton).bind("mouseout",function(){  
				if( options.autorun=="yes" ){
					timer = setInterval(scroll_2,options.scrollTime);  
				}
			});
		}
		
		
		
		var timer;
		if( options.autorun=="yes" ){
			timer = setInterval(scroll_2,options.scrollTime);  
		}
		_self.bind("mouseover",function(){  
			clearInterval(timer);  
		});  
		_self.bind("mouseout",function(){  
			if( options.autorun=="yes" ){
				timer = setInterval(scroll_2,options.scrollTime);  
			}
		});  
				
		_self.next("ol").bind("mouseover",function(){  
			clearInterval(timer);  
		});  
		_self.next("ol").bind("mouseout",function(){  
			if( options.autorun=="yes" ){
				timer = setInterval(scroll_2,options.scrollTime);  
			}
		});  
    }  
})(jQuery);