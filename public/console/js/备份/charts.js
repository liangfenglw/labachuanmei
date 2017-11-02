var color1 = [ '#037EF3', '#FFCE55', '#a0d468', '#fb6e52', '#48cfae', '#60d8e3', '#606fe3', '#eb943f', '#ed597f' ];

/*	投放分布切换	*/
$(".tb1_tab .sp1 a").click(function(){
	$(this).addClass("cur").closest(".tb1_tab").find("ul li a").removeClass("cur");
	option1.series[0].name = opt1[0].name;
	option1.series[0].data = opt1[0].data;
	option1.color[0] = color1[0];
	myChart1.setOption(option1);
	myChart1.resize();
	return false;
});
$(".tb1_tab ul li a").click(function(){
	$(this).addClass("cur").parent().siblings("li").find("a").removeClass("cur");
	$(this).closest(".tb1_tab").find(".sp1 a").removeClass("cur");
	var index = $(this).parent().index();
	option1.series[0].name = opt1[index+1].name;
	option1.series[0].data = opt1[index+1].data;
	option1.color[0] = color1[index+1];
	myChart1.setOption(option1);
	myChart1.resize();
	return false;
});





// 普通会员首页 投放分布
//	['总投放','网络媒体','户外媒体','平面媒体','电视媒体','广播媒体','记者报料','内容代写','宣传定制']
if( $("#pti_1").length>0 ){

	/*	数据	*/
	var opt1 = [
		{ name:'总投放',   type:'line', data:[300, 600, 500, 800, 1100, 1500, 2500,2000,2600,3100,3700,4500] },
		{ name:'网络媒体', type:'line', data:[200, 400, 300, 500, 100, 1500, 2500,2000,2600,2100,2700,3500] },
		{ name:'户外媒体', type:'line', data:[150, 232, 201, 154, 190, 330, 410, 10, 550, 600,1888 ,2999 ] },
		{ name:'平面媒体', type:'line', data:[100,200,300,400,600,1200,1500,2100,2230,1555,3300,3100] },
		{ name:'电视媒体', type:'line', data:[820, 932, 901, 934, 934, 934, 934, 934, 934, 1290, 1330, 1320] },
		{ name:'广播媒体', type:'line', data:[820, 932, 901, 901, 901, 901, 901, 901, 934, 1290, 1330, 1320] },
		{ name:'记者报料', type:'line', data:[820,820,820,820,820,820, 932, 901, 934, 1290, 1330, 1320] },
		{ name:'内容代写', type:'line', data:[820, 932, 901, 934, 1290, 1330,1330,1330,1330,1330,1330, 1320] },
		{ name:'宣传定制', type:'line', data:[820, 932, 901, 934, 1290, 1330, 2320, 2320, 2320, 2320, 2320, 2320] }
	];

	var myChart1 = echarts.init(document.getElementById('pti_1'));
	var option1 = {
		tooltip: {
			trigger: 'axis',
			axisPointer: { type: 'line' }
		},
		color: [ '#037EF3', '#FFCE55', '#a0d468', '#fb6e52', '#48cfae', '#60d8e3', '#606fe3', '#eb943f', '#ed597f' ],
		legend: { show: false },
		grid: {
			left: '5%',
			right: '5%',
			bottom: '8%',
			containLabel: true
		},
		toolbox: {
			top: '2%',
			right: '5%',
			feature: {
				saveAsImage: {}
			}
		},
		tooltip: {
			trigger: 'item',
//			formatter: "{a} <br/>{b}: {c} ({d}%)"
			formatter: "<div style='padding:10px 30px;'><p style='font-size:18px;text-align:center;line-height:24px;'>{b}份 {a}</p><p style='font-size:28px;text-align:center;line-height:36px;'>{c}</p></div>"
			},
		xAxis: {
			type: 'category',
			boundaryGap: false,
			data: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
		},
		yAxis: {
			type: 'value'
//			,splitNumber: 10
			,interval: 500
			,max: 5000
		},
		series: [
			{ name:'',   type:'line', data:[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0] }
//			{ name:'总投放',   type:'line', data:[300, 600, 500, 800, 1100, 1500, 2500,2000,2600,3100,3700,4500] }
		]
	};
	option1.series[0].name = opt1[0].name;
	option1.series[0].data = opt1[0].data;
	option1.color[0] = color1[0];
	myChart1.setOption(option1);
}

// 普通会员首页 订单统计 本月
if( $('#pti_2').length > 0 ){
	var myChart2 = echarts.init(document.getElementById('pti_2'));
	var option2 = {
			title: {
				text: '本月订单',
				subtext: '3520',
				left: 'center',
				top: '36%',
				textStyle:{ fontSize: '30' },
				subtextStyle:{ fontSize: '30', color: '#000', fontWeight: 'bold' },
				itemGap: 10
			},
			tooltip: {
				trigger: 'item',
//				formatter: "{a} <br/>{b}: {c} ({d}%)"
				formatter: "<div style='padding:10px 30px;'><p style='font-size:18px;text-align:center;line-height:24px;'>{b}</p><p style='font-size:28px;text-align:center;line-height:36px;'>{c}</p></div>"
			},
			color:['#5d9cec', '#fb6e52','#ffce55','#a0d468','#e2e2e2'],
			legend: {
				show: true,
				orient: 'horizontal',
				x: 'center',
				y: 'bottom',
				itemGap: 45,
				itemWidth: 20,
				itemHeight: 22,
				textStyle:{ fontSize: '22' },
				data:['已完成','流单','退还','预约','未完成']
			},
			grid: {
				containLabel: true
			},
			series: [
				{
					name:'余额',
					type:'pie',
					radius: ['60%', '80%'],
					center: ['50%', '42%'],
					avoidLabelOverlap: false,
					label: {
						normal: {
							show: false,
							position: 'center'
						},
						emphasis: {
							show: false,
							textStyle: {
								fontSize: '20',
								fontWeight: 'bold'
							}
						}
					},
					labelLine: {
						normal: {
							show: false
						}
					},
					data:[
						{value:1126, name:'已完成'},
						{value:986, name:'流单'},
						{value:352, name:'退还'},
						{value:700, name:'预约'},
						{value:706, name:'未完成'}
					]
				}
			]
	};
	myChart2.setOption(option2);
}

// 普通会员首页 订单统计 上月
if( $('#pti_3').length > 0 ){
		var myChart3 = echarts.init(document.getElementById('pti_3'));
		var option3 = {
			title: {
				text: '上月订单',
				subtext: '3520',
				left: 'center',
				top: '36%',
				textStyle:{ fontSize: '30' },
				subtextStyle:{ fontSize: '30', color: '#000', fontWeight: 'bold' },
				itemGap: 10
			},
			tooltip: {
				trigger: 'item',
//				formatter: "{a} <br/>{b}: {c} ({d}%)"
				formatter: "<div style='padding:10px 30px;'><p style='font-size:18px;text-align:center;line-height:24px;'>{b}</p><p style='font-size:28px;text-align:center;line-height:36px;'>{c}</p></div>"
			},
			color:['#5d9cec', '#fb6e52','#ffce55','#a0d468','#e2e2e2'],
			legend: {
				show: true,
				orient: 'horizontal',
				x: 'center',
				y: 'bottom',
				itemGap: 45,
				itemWidth: 20,
				itemHeight: 22,
				textStyle:{ fontSize: '22' },
				data:['已完成','流单','退还','预约','未完成']
			},
			grid: {
				containLabel: true
			},
			series: [
				{
					name:'余额',
					type:'pie',
					radius: ['60%', '80%'],
					center: ['50%', '42%'],
					avoidLabelOverlap: false,
					label: {
						normal: {
							show: false,
							position: 'center'
						},
						emphasis: {
							show: false,
							textStyle: {
								fontSize: '20',
								fontWeight: 'bold'
							}
						}
					},
					labelLine: {
						normal: {
							show: false
						}
					},
					data:[
						{value:1126, name:'已完成'},
						{value:2986, name:'流单'},
						{value:352, name:'退还'},
						{value:700, name:'预约'},
						{value:706, name:'未完成'}
					]
				}
			]
		};
		myChart3.setOption(option3);
}

// 普通会员首页 订单统计 全年
if( $('#pti_4').length > 0 ){
		var myChart4 = echarts.init(document.getElementById('pti_4'));
		var option4 = {
			title: {
				text: '今年订单',
				subtext: '3520',
				left: 'center',
				top: '36%',
				textStyle:{ fontSize: '30' },
				subtextStyle:{ fontSize: '30', color: '#000', fontWeight: 'bold' },
				itemGap: 10
			},
			tooltip: {
				trigger: 'item',
//				formatter: "{a} <br/>{b}: {c} ({d}%)"
				formatter: "<div style='padding:10px 30px;'><p style='font-size:18px;text-align:center;line-height:24px;'>{b}</p><p style='font-size:28px;text-align:center;line-height:36px;'>{c}</p></div>"
			},
			color:['#5d9cec', '#fb6e52','#ffce55','#a0d468','#e2e2e2'],
			legend: {
				show: true,
				orient: 'horizontal',
				x: 'center',
				y: 'bottom',
				itemGap: 45,
				itemWidth: 20,
				itemHeight: 22,
				textStyle:{ fontSize: '22' },
				data:['已完成','流单','退还','预约','未完成']
			},
			grid: {
				containLabel: true
			},
			series: [
				{
					name:'余额',
					type:'pie',
					radius: ['60%', '80%'],
					center: ['50%', '42%'],
					avoidLabelOverlap: false,
					label: {
						normal: {
							show: false,
							position: 'center'
						},
						emphasis: {
							show: false,
							textStyle: {
								fontSize: '20',
								fontWeight: 'bold'
							}
						}
					},
					labelLine: {
						normal: {
							show: false
						}
					},
					data:[
						{value:11126, name:'已完成'},
						{value:986, name:'流单'},
						{value:352, name:'退还'},
						{value:700, name:'预约'},
						{value:706, name:'未完成'}
					]
				}
			]
		};
		myChart4.setOption(option4);
}





/*	管理员首页 投放分布 */
if( $("#gli_1").length>0 ){
	
	/*	数据	*/
	var opt1 = [
		{ name:'总投放',   type:'line', data:[500, 700, 500, 800, 1100, 3500, 2500,2000,2600,3100,3700,4500] },
		{ name:'网络媒体', type:'line', data:[200, 400, 300, 500, 100, 1500, 2500,2000,2600,2100,2700,3500] },
		{ name:'户外媒体', type:'line', data:[150, 232, 201, 154, 190, 330, 410, 10, 550, 600,1888 ,2999 ] },
		{ name:'平面媒体', type:'line', data:[100,200,300,400,600,1200,1500,2100,2230,1555,3300,3100] },
		{ name:'电视媒体', type:'line', data:[820, 932, 901, 934, 934, 934, 934, 934, 934, 1290, 1330, 1320] },
		{ name:'广播媒体', type:'line', data:[820, 932, 901, 901, 901, 901, 901, 901, 934, 1290, 1330, 1320] },
		{ name:'记者报料', type:'line', data:[820,820,820,820,820,820, 932, 901, 934, 1290, 1330, 1320] },
		{ name:'内容代写', type:'line', data:[820, 932, 901, 934, 1290, 1330,1330,1330,1330,1330,1330, 1320] },
		{ name:'宣传定制', type:'line', data:[820, 932, 901, 934, 1290, 1330, 2320, 2320, 2320, 2320, 2320, 2320] }
	];

	var myChart1 = echarts.init(document.getElementById('gli_1'));
	var option1 = {
		tooltip: {
			trigger: 'axis',
			axisPointer: { type: 'line' }
		},
		color: [ '#037EF3', '#FFCE55', '#a0d468', '#fb6e52', '#48cfae', '#60d8e3', '#606fe3', '#eb943f', '#ed597f' ],
		legend: { show: false },
		grid: {
			left: '5%',
			right: '5%',
			bottom: '8%',
			containLabel: true
		},
		toolbox: {
			top: '2%',
			right: '5%',
			feature: {
				saveAsImage: {}
			}
		},
		tooltip: {
			trigger: 'item',
//			formatter: "{a} <br/>{b}: {c} ({d}%)"
			formatter: "<div style='padding:10px 30px;'><p style='font-size:18px;text-align:center;line-height:24px;'>{b}份 {a}</p><p style='font-size:28px;text-align:center;line-height:36px;'>{c}</p></div>"
			},
		xAxis: {
			type: 'category',
			boundaryGap: false,
			data: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
		},
		yAxis: {
			type: 'value'
//			,splitNumber: 10
			,interval: 500
			,max: 5000
		},
		series: [
			{ name:'',   type:'line', data:[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0] }
//			{ name:'总投放',   type:'line', data:[300, 600, 500, 800, 1100, 1500, 2500,2000,2600,3100,3700,4500] }
		]
	};
	option1.series[0].name = opt1[0].name;
	option1.series[0].data = opt1[0].data;
	option1.color[0] = color1[0];
	myChart1.setOption(option1);
}





// 高级会员首页 投放分布
if( $("#gji_1").length>0 ){
	
	/*	数据	*/
	var opt1 = [
		{ name:'总投放',   type:'line', data:[2500, 700, 500, 800, 1100, 3500, 2500,2000,2600,3100,3700,4500] },
		{ name:'网络媒体', type:'line', data:[200, 400, 300, 500, 100, 1500, 2500,2000,2600,2100,2700,3500] },
		{ name:'户外媒体', type:'line', data:[150, 232, 201, 154, 190, 330, 410, 10, 550, 600,1888 ,2999 ] },
		{ name:'平面媒体', type:'line', data:[100,200,300,400,600,1200,1500,2100,2230,1555,3300,3100] },
		{ name:'电视媒体', type:'line', data:[820, 932, 901, 934, 934, 934, 934, 934, 934, 1290, 1330, 1320] },
		{ name:'广播媒体', type:'line', data:[820, 932, 901, 901, 901, 901, 901, 901, 934, 1290, 1330, 1320] },
		{ name:'记者报料', type:'line', data:[820,820,820,820,820,820, 932, 901, 934, 1290, 1330, 1320] },
		{ name:'内容代写', type:'line', data:[820, 932, 901, 934, 1290, 1330,1330,1330,1330,1330,1330, 1320] },
		{ name:'宣传定制', type:'line', data:[820, 932, 901, 934, 1290, 1330, 2320, 2320, 2320, 2320, 2320, 2320] }
	];

	var myChart1 = echarts.init(document.getElementById('gji_1'));
	var option1 = {
		tooltip: {
			trigger: 'axis',
			axisPointer: { type: 'line' }
		},
		color: [ '#037EF3', '#FFCE55', '#a0d468', '#fb6e52', '#48cfae', '#60d8e3', '#606fe3', '#eb943f', '#ed597f' ],
		legend: { show: false },
		grid: {
			left: '5%',
			right: '5%',
			bottom: '8%',
			containLabel: true
		},
		toolbox: {
			top: '2%',
			right: '5%',
			feature: {
				saveAsImage: {}
			}
		},
		tooltip: {
			trigger: 'item',
//			formatter: "{a} <br/>{b}: {c} ({d}%)"
			formatter: "<div style='padding:10px 30px;'><p style='font-size:18px;text-align:center;line-height:24px;'>{b}份 {a}</p><p style='font-size:28px;text-align:center;line-height:36px;'>{c}</p></div>"
			},
		xAxis: {
			type: 'category',
			boundaryGap: false,
			data: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
		},
		yAxis: {
			type: 'value'
//			,splitNumber: 10
			,interval: 500
			,max: 5000
		},
		series: [
			{ name:'',   type:'line', data:[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0] }
//			{ name:'总投放',   type:'line', data:[300, 600, 500, 800, 1100, 1500, 2500,2000,2600,3100,3700,4500] }
		]
	};
	option1.series[0].name = opt1[0].name;
	option1.series[0].data = opt1[0].data;
	option1.color[0] = color1[0];
	myChart1.setOption(option1);
}

// 高级会员首页 订单统计 本月
if( $('#gji_2').length > 0 ){
	var myChart2 = echarts.init(document.getElementById('gji_2'));
	var option2 = {
			title: {
				text: '本月订单',
				subtext: '3520',
				left: 'center',
				top: '36%',
				textStyle:{ fontSize: '30' },
				subtextStyle:{ fontSize: '30', color: '#000', fontWeight: 'bold' },
				itemGap: 10
			},
			tooltip: {
				trigger: 'item',
//				formatter: "{a} <br/>{b}: {c} ({d}%)"
				formatter: "<div style='padding:10px 30px;'><p style='font-size:18px;text-align:center;line-height:24px;'>{b}</p><p style='font-size:28px;text-align:center;line-height:36px;'>{c}</p></div>"
			},
			color:['#5d9cec', '#fb6e52','#ffce55','#a0d468','#e2e2e2'],
			legend: {
				show: true,
				orient: 'horizontal',
				x: 'center',
				y: 'bottom',
				itemGap: 45,
				itemWidth: 20,
				itemHeight: 22,
				textStyle:{ fontSize: '22' },
				data:['已完成','流单','退还','预约','未完成']
			},
			grid: {
				containLabel: true
			},
			series: [
				{
					name:'余额',
					type:'pie',
					radius: ['60%', '80%'],
					center: ['50%', '42%'],
					avoidLabelOverlap: false,
					label: {
						normal: {
							show: false,
							position: 'center'
						},
						emphasis: {
							show: false,
							textStyle: {
								fontSize: '20',
								fontWeight: 'bold'
							}
						}
					},
					labelLine: {
						normal: {
							show: false
						}
					},
					data:[
						{value:1126, name:'已完成'},
						{value:986, name:'流单'},
						{value:352, name:'退还'},
						{value:700, name:'预约'},
						{value:706, name:'未完成'}
					]
				}
			]
	};
	myChart2.setOption(option2);
}

// 高级会员首页 订单统计 上月
if( $('#gji_3').length > 0 ){
		var myChart3 = echarts.init(document.getElementById('gji_3'));
		var option3 = {
			title: {
				text: '上月订单',
				subtext: '3520',
				left: 'center',
				top: '36%',
				textStyle:{ fontSize: '30' },
				subtextStyle:{ fontSize: '30', color: '#000', fontWeight: 'bold' },
				itemGap: 10
			},
			tooltip: {
				trigger: 'item',
//				formatter: "{a} <br/>{b}: {c} ({d}%)"
				formatter: "<div style='padding:10px 30px;'><p style='font-size:18px;text-align:center;line-height:24px;'>{b}</p><p style='font-size:28px;text-align:center;line-height:36px;'>{c}</p></div>"
			},
			color:['#5d9cec', '#fb6e52','#ffce55','#a0d468','#e2e2e2'],
			legend: {
				show: true,
				orient: 'horizontal',
				x: 'center',
				y: 'bottom',
				itemGap: 45,
				itemWidth: 20,
				itemHeight: 22,
				textStyle:{ fontSize: '22' },
				data:['已完成','流单','退还','预约','未完成']
			},
			grid: {
				containLabel: true
			},
			series: [
				{
					name:'余额',
					type:'pie',
					radius: ['60%', '80%'],
					center: ['50%', '42%'],
					avoidLabelOverlap: false,
					label: {
						normal: {
							show: false,
							position: 'center'
						},
						emphasis: {
							show: false,
							textStyle: {
								fontSize: '20',
								fontWeight: 'bold'
							}
						}
					},
					labelLine: {
						normal: {
							show: false
						}
					},
					data:[
						{value:1126, name:'已完成'},
						{value:2986, name:'流单'},
						{value:352, name:'退还'},
						{value:700, name:'预约'},
						{value:706, name:'未完成'}
					]
				}
			]
		};
		myChart3.setOption(option3);
}

// 高级会员首页 订单统计 全年
if( $('#gji_4').length > 0 ){
		var myChart4 = echarts.init(document.getElementById('gji_4'));
		var option4 = {
			title: {
				text: '今年订单',
				subtext: '3520',
				left: 'center',
				top: '36%',
				textStyle:{ fontSize: '30' },
				subtextStyle:{ fontSize: '30', color: '#000', fontWeight: 'bold' },
				itemGap: 10
			},
			tooltip: {
				trigger: 'item',
//				formatter: "{a} <br/>{b}: {c} ({d}%)"
				formatter: "<div style='padding:10px 30px;'><p style='font-size:18px;text-align:center;line-height:24px;'>{b}</p><p style='font-size:28px;text-align:center;line-height:36px;'>{c}</p></div>"
			},
			color:['#5d9cec', '#fb6e52','#ffce55','#a0d468','#e2e2e2'],
			legend: {
				show: true,
				orient: 'horizontal',
				x: 'center',
				y: 'bottom',
				itemGap: 45,
				itemWidth: 20,
				itemHeight: 22,
				textStyle:{ fontSize: '22' },
				data:['已完成','流单','退还','预约','未完成']
			},
			grid: {
				containLabel: true
			},
			series: [
				{
					name:'余额',
					type:'pie',
					radius: ['60%', '80%'],
					center: ['50%', '42%'],
					avoidLabelOverlap: false,
					label: {
						normal: {
							show: false,
							position: 'center'
						},
						emphasis: {
							show: false,
							textStyle: {
								fontSize: '20',
								fontWeight: 'bold'
							}
						}
					},
					labelLine: {
						normal: {
							show: false
						}
					},
					data:[
						{value:11126, name:'已完成'},
						{value:986, name:'流单'},
						{value:352, name:'退还'},
						{value:700, name:'预约'},
						{value:706, name:'未完成'}
					]
				}
			]
		};
		myChart4.setOption(option4);
}




// 供应商首页 投放分布
if( $("#gyi_1").length>0 ){
	
	/*	数据	*/
	var opt1 = [
		{ name:'总投放',   type:'line', data:[200, 600, 1500, 300, 1200, 3500, 2500,2000,1600,3500,3700,5000] },
		{ name:'网络媒体', type:'line', data:[200, 400, 300, 500, 100, 1500, 2500,2000,2600,2100,2700,3500] },
		{ name:'户外媒体', type:'line', data:[150, 232, 201, 154, 190, 330, 410, 10, 550, 600,1888 ,2999 ] },
		{ name:'平面媒体', type:'line', data:[100,200,300,400,600,1200,1500,2100,2230,1555,3300,3100] },
		{ name:'电视媒体', type:'line', data:[820, 932, 901, 934, 934, 934, 934, 934, 934, 1290, 1330, 1320] },
		{ name:'广播媒体', type:'line', data:[820, 932, 901, 901, 901, 901, 901, 901, 934, 1290, 1330, 1320] },
		{ name:'记者报料', type:'line', data:[820,820,820,820,820,820, 932, 901, 934, 1290, 1330, 1320] },
		{ name:'内容代写', type:'line', data:[820, 932, 901, 934, 1290, 1330,1330,1330,1330,1330,1330, 1320] },
		{ name:'宣传定制', type:'line', data:[820, 932, 901, 934, 1290, 1330, 2320, 2320, 2320, 2320, 2320, 2320] }
	];

	var myChart1 = echarts.init(document.getElementById('gyi_1'));
	var option1 = {
		tooltip: {
			trigger: 'axis',
			axisPointer: { type: 'line' }
		},
		color: [ '#037EF3', '#FFCE55', '#a0d468', '#fb6e52', '#48cfae', '#60d8e3', '#606fe3', '#eb943f', '#ed597f' ],
		legend: { show: false },
		grid: {
			left: '5%',
			right: '5%',
			bottom: '8%',
			containLabel: true
		},
		toolbox: {
			top: '2%',
			right: '5%',
			feature: {
				saveAsImage: {}
			}
		},
		tooltip: {
			trigger: 'item',
//			formatter: "{a} <br/>{b}: {c} ({d}%)"
			formatter: "<div style='padding:10px 30px;'><p style='font-size:18px;text-align:center;line-height:24px;'>{b}份 {a}</p><p style='font-size:28px;text-align:center;line-height:36px;'>{c}</p></div>"
			},
		xAxis: {
			type: 'category',
			boundaryGap: false,
			data: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
		},
		yAxis: {
			type: 'value'
//			,splitNumber: 10
			,interval: 500
			,max: 5000
		},
		series: [
			{ name:'',   type:'line', data:[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0] }
//			{ name:'总投放',   type:'line', data:[300, 600, 500, 800, 1100, 1500, 2500,2000,2600,3100,3700,4500] }
		]
	};
	option1.series[0].name = opt1[0].name;
	option1.series[0].data = opt1[0].data;
	option1.color[0] = color1[0];
	myChart1.setOption(option1);
}

// 供应商首页 订单统计 本月
if( $('#gyi_2').length > 0 ){
	var myChart2 = echarts.init(document.getElementById('gyi_2'));
	var option2 = {
			title: {
				text: '本月订单',
				subtext: '3520',
				left: 'center',
				top: '36%',
				textStyle:{ fontSize: '30' },
				subtextStyle:{ fontSize: '30', color: '#000', fontWeight: 'bold' },
				itemGap: 10
			},
			tooltip: {
				trigger: 'item',
//				formatter: "{a} <br/>{b}: {c} ({d}%)"
				formatter: "<div style='padding:10px 30px;'><p style='font-size:18px;text-align:center;line-height:24px;'>{b}</p><p style='font-size:28px;text-align:center;line-height:36px;'>{c}</p></div>"
			},
			color:['#5d9cec', '#fb6e52','#ffce55','#a0d468','#e2e2e2'],
			legend: {
				show: true,
				orient: 'horizontal',
				x: 'center',
				y: 'bottom',
				itemGap: 45,
				itemWidth: 20,
				itemHeight: 22,
				textStyle:{ fontSize: '22' },
				data:['已完成','流单','退还','预约','未完成']
			},
			grid: {
				containLabel: true
			},
			series: [
				{
					name:'余额',
					type:'pie',
					radius: ['60%', '80%'],
					center: ['50%', '42%'],
					avoidLabelOverlap: false,
					label: {
						normal: {
							show: false,
							position: 'center'
						},
						emphasis: {
							show: false,
							textStyle: {
								fontSize: '20',
								fontWeight: 'bold'
							}
						}
					},
					labelLine: {
						normal: {
							show: false
						}
					},
					data:[
						{value:1126, name:'已完成'},
						{value:986, name:'流单'},
						{value:352, name:'退还'},
						{value:700, name:'预约'},
						{value:706, name:'未完成'}
					]
				}
			]
	};
	myChart2.setOption(option2);
}

// 供应商首页 订单统计 上月
if( $('#gyi_3').length > 0 ){
		var myChart3 = echarts.init(document.getElementById('gyi_3'));
		var option3 = {
			title: {
				text: '上月订单',
				subtext: '3520',
				left: 'center',
				top: '36%',
				textStyle:{ fontSize: '30' },
				subtextStyle:{ fontSize: '30', color: '#000', fontWeight: 'bold' },
				itemGap: 10
			},
			tooltip: {
				trigger: 'item',
//				formatter: "{a} <br/>{b}: {c} ({d}%)"
				formatter: "<div style='padding:10px 30px;'><p style='font-size:18px;text-align:center;line-height:24px;'>{b}</p><p style='font-size:28px;text-align:center;line-height:36px;'>{c}</p></div>"
			},
			color:['#5d9cec', '#fb6e52','#ffce55','#a0d468','#e2e2e2'],
			legend: {
				show: true,
				orient: 'horizontal',
				x: 'center',
				y: 'bottom',
				itemGap: 45,
				itemWidth: 20,
				itemHeight: 22,
				textStyle:{ fontSize: '22' },
				data:['已完成','流单','退还','预约','未完成']
			},
			grid: {
				containLabel: true
			},
			series: [
				{
					name:'余额',
					type:'pie',
					radius: ['60%', '80%'],
					center: ['50%', '42%'],
					avoidLabelOverlap: false,
					label: {
						normal: {
							show: false,
							position: 'center'
						},
						emphasis: {
							show: false,
							textStyle: {
								fontSize: '20',
								fontWeight: 'bold'
							}
						}
					},
					labelLine: {
						normal: {
							show: false
						}
					},
					data:[
						{value:1126, name:'已完成'},
						{value:2986, name:'流单'},
						{value:352, name:'退还'},
						{value:700, name:'预约'},
						{value:706, name:'未完成'}
					]
				}
			]
		};
		myChart3.setOption(option3);
}

// 供应商首页 订单统计 全年
if( $('#gyi_4').length > 0 ){
		var myChart4 = echarts.init(document.getElementById('gyi_4'));
		var option4 = {
			title: {
				text: '今年订单',
				subtext: '3520',
				left: 'center',
				top: '36%',
				textStyle:{ fontSize: '30' },
				subtextStyle:{ fontSize: '30', color: '#000', fontWeight: 'bold' },
				itemGap: 10
			},
			tooltip: {
				trigger: 'item',
//				formatter: "{a} <br/>{b}: {c} ({d}%)"
				formatter: "<div style='padding:10px 30px;'><p style='font-size:18px;text-align:center;line-height:24px;'>{b}</p><p style='font-size:28px;text-align:center;line-height:36px;'>{c}</p></div>"
			},
			color:['#5d9cec', '#fb6e52','#ffce55','#a0d468','#e2e2e2'],
			legend: {
				show: true,
				orient: 'horizontal',
				x: 'center',
				y: 'bottom',
				itemGap: 45,
				itemWidth: 20,
				itemHeight: 22,
				textStyle:{ fontSize: '22' },
				data:['已完成','流单','退还','预约','未完成']
			},
			grid: {
				containLabel: true
			},
			series: [
				{
					name:'余额',
					type:'pie',
					radius: ['60%', '80%'],
					center: ['50%', '42%'],
					avoidLabelOverlap: false,
					label: {
						normal: {
							show: false,
							position: 'center'
						},
						emphasis: {
							show: false,
							textStyle: {
								fontSize: '20',
								fontWeight: 'bold'
							}
						}
					},
					labelLine: {
						normal: {
							show: false
						}
					},
					data:[
						{value:11126, name:'已完成'},
						{value:986, name:'流单'},
						{value:352, name:'退还'},
						{value:700, name:'预约'},
						{value:706, name:'未完成'}
					]
				}
			]
		};
		myChart4.setOption(option4);
}





//	用-高级会员详情 柱状图
if( $('#tb_hv1').length > 0 ){
	var myChart1 = echarts.init(document.getElementById('tb_hv1'));
	option1 = {
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
//				data : ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
				data : ['网络媒体', '户外媒体', '平面媒体', '电视媒体', '广播媒体', '内容代写', '记者报料'],
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
				data:[10, 52, 200, 334, 390, 330, 220]
			}
		]
	};
	myChart1.setOption(option1);
}

//	用-高级会员详情 环状图
if( $('#tb_hv2').length > 0 ){
	var myChart2 = echarts.init(document.getElementById('tb_hv2'));
	option2 = {
			title: {
				text: '用户账户金额\n分布统计图',
				textAlign: 'center',
				left: '29%',
				top: '45px',
				textStyle:{ fontSize: '20', color: '#505050', fontFamily: 'SimHei', fontWeight: 'normal' },
			},
			tooltip: {
				trigger: 'item',
//				formatter: "<div style='padding:10px 30px;'><p style='font-size:18px;text-align:center;line-height:24px;'>{b}</p><p style='font-size:28px;text-align:center;line-height:36px;'>{c}</p></div>"
				formatter: "<div style='font-size:16px;line-height:30px;padding:5px;'>{b} <br/> {c} ({d}%)</div>"
			},
			color:['#5d9cec', '#fb6e52','#ffce55','#a0d468','#e2e2e2'],
			legend: {
				show: true,
				orient: 'vertical',
				left: '57%',
				top: '50px',
				itemGap: 50,
				itemWidth: 20,
				itemHeight: 22,
				textStyle:{ fontSize: '20' },
				data:['订单消费金额','平台纯收益','充值金额','提现金额']
			},
			grid: {
				containLabel: true
			},
			series: [
				{
//					name:'余额',
					type:'pie',
					radius: ['40%', '55%'],
					center: ['30%', '62%'],
					avoidLabelOverlap: false,
					label: {
						normal: {
							show: false,
							position: 'center'
						},
						emphasis: {
							show: false,
							textStyle: { fontSize: '20', fontWeight: 'bold' }
						}
					},
					labelLine: {
						normal: { show: false }
					},
					data:[
						{value:1126, name:'订单消费金额'},
						{value:986, name:'平台纯收益'},
						{value:352, name:'充值金额'},
						{value:700, name:'提现金额'}
					]
				}
			]
	};
	myChart2.setOption(option2);
}





//	用-会员详情 柱状图
if( $('#tb_av1').length > 0 ){
	var myChart1 = echarts.init(document.getElementById('tb_av1'));
	option1 = {
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
//				data : ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
				data : ['网络媒体', '户外媒体', '平面媒体', '电视媒体', '广播媒体', '内容代写', '记者报料'],
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
				data:[10, 52, 200, 334, 390, 330, 220]
			}
		]
	};
	myChart1.setOption(option1);
}

//	用-会员详情 环状图
if( $('#tb_av2').length > 0 ){
	var myChart2 = echarts.init(document.getElementById('tb_av2'));
	option2 = {
			title: {
				text: '用户账户金额\n分布统计图',
				textAlign: 'center',
				left: '29%',
				top: '45px',
				textStyle:{ fontSize: '20', color: '#505050', fontFamily: 'SimHei', fontWeight: 'normal' },
			},
			tooltip: {
				trigger: 'item',
//				formatter: "<div style='padding:10px 30px;'><p style='font-size:18px;text-align:center;line-height:24px;'>{b}</p><p style='font-size:28px;text-align:center;line-height:36px;'>{c}</p></div>"
				formatter: "<div style='font-size:16px;line-height:30px;padding:5px;'>{b} <br/> {c} ({d}%)</div>"
			},
			color:['#5d9cec', '#fb6e52','#ffce55','#a0d468','#e2e2e2'],
			legend: {
				show: true,
				orient: 'vertical',
				left: '57%',
				top: '50px',
				itemGap: 50,
				itemWidth: 20,
				itemHeight: 22,
				textStyle:{ fontSize: '20' },
				data:['订单消费金额','平台纯收益','充值金额','提现金额']
			},
			grid: {
				containLabel: true
			},
			series: [
				{
//					name:'余额',
					type:'pie',
					radius: ['40%', '55%'],
					center: ['30%', '62%'],
					avoidLabelOverlap: false,
					label: {
						normal: {
							show: false,
							position: 'center'
						},
						emphasis: {
							show: false,
							textStyle: { fontSize: '20', fontWeight: 'bold' }
						}
					},
					labelLine: {
						normal: { show: false }
					},
					data:[
						{value:1126, name:'订单消费金额'},
						{value:986, name:'平台纯收益'},
						{value:352, name:'充值金额'},
						{value:700, name:'提现金额'}
					]
				}
			]
	};
	myChart2.setOption(option2);
}





//	代理会员详情 柱状图
if( $('#tb_dl1').length > 0 ){
	var myChart1 = echarts.init(document.getElementById('tb_dl1'));
	option1 = {
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
//				data : ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
				data : ['网络媒体', '户外媒体', '平面媒体', '电视媒体', '广播媒体', '内容代写', '记者报料'],
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
				data:[10, 52, 200, 334, 390, 330, 220]
			}
		]
	};
	myChart1.setOption(option1);
}

//	代理会员详情 环状图
if( $('#tb_dl2').length > 0 ){
	var myChart2 = echarts.init(document.getElementById('tb_dl2'));
	option2 = {
			title: {
				text: '用户账户金额分布统计图',
				left: 'center',
				top: '45px',
				textStyle:{ fontSize: '20', color: '#505050', fontFamily: 'SimHei', fontWeight: 'normal' },
			},
			tooltip: {
				trigger: 'item',
//				formatter: "<div style='padding:10px 30px;'><p style='font-size:18px;text-align:center;line-height:24px;'>{b}</p><p style='font-size:28px;text-align:center;line-height:36px;'>{c}</p></div>"
				formatter: "<div style='font-size:16px;line-height:30px;padding:5px;'>{b} <br/> {c} ({d}%)</div>"
			},
			color:['#5d9cec', '#fb6e52','#ffce55','#a0d468','#e2e2e2'],
			legend: {
				show: true,
				orient: 'vertical',
				left: '57%',
				top: '150px',
				itemGap: 50,
				itemWidth: 20,
				itemHeight: 22,
				textStyle:{ fontSize: '20' },
				data:['下属会员金额','帐户总金额']
			},
			grid: {
				containLabel: true
			},
			series: [
				{
//					name:'余额',
					type:'pie',
					radius: ['40%', '50%'],
					center: ['30%', '60%'],
					avoidLabelOverlap: false,
					label: {
						normal: {
							show: false,
							position: 'center'
						},
						emphasis: {
							show: false,
							textStyle: { fontSize: '20', fontWeight: 'bold' }
						}
					},
					labelLine: {
						normal: { show: false }
					},
					data:[
						{value:1126, name:'下属会员金额'},
						{value:986, name:'帐户总金额'}
					]
				}
			]
	};
	myChart2.setOption(option2);
}





//	帐—申请高级会员详情 柱状图
if( $('#tb_sq1').length > 0 ){
	var myChart1 = echarts.init(document.getElementById('tb_sq1'));
	option1 = {
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
//				data : ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
				data : ['网络媒体', '户外媒体', '平面媒体', '电视媒体', '广播媒体', '内容代写', '记者报料'],
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
				data:[10, 52, 200, 334, 390, 330, 220]
			}
		]
	};
	myChart1.setOption(option1);
}

//	帐—申请高级会员详情 环状图
if( $('#tb_sq2').length > 0 ){
	var myChart2 = echarts.init(document.getElementById('tb_sq2'));
	option2 = {
			title: {
				text: '用户账户金额分布统计图',
				left: 'center',
				top: '45px',
				textStyle:{ fontSize: '20', color: '#505050', fontFamily: 'SimHei', fontWeight: 'normal' },
			},
			tooltip: {
				trigger: 'item',
//				formatter: "<div style='padding:10px 30px;'><p style='font-size:18px;text-align:center;line-height:24px;'>{b}</p><p style='font-size:28px;text-align:center;line-height:36px;'>{c}</p></div>"
				formatter: "<div style='font-size:16px;line-height:30px;padding:5px;'>{b} <br/> {c} ({d}%)</div>"
			},
			color:['#5d9cec', '#fb6e52','#ffce55','#a0d468','#e2e2e2'],
			legend: {
				show: true,
				orient: 'vertical',
				left: '57%',
				top: '150px',
				itemGap: 50,
				itemWidth: 20,
				itemHeight: 22,
				textStyle:{ fontSize: '20' },
				data:['下属会员金额','帐户总金额']
			},
			grid: {
				containLabel: true
			},
			series: [
				{
//					name:'余额',
					type:'pie',
					radius: ['40%', '50%'],
					center: ['30%', '60%'],
					avoidLabelOverlap: false,
					label: {
						normal: {
							show: false,
							position: 'center'
						},
						emphasis: {
							show: false,
							textStyle: { fontSize: '20', fontWeight: 'bold' }
						}
					},
					labelLine: {
						normal: { show: false }
					},
					data:[
						{value:1126, name:'下属会员金额'},
						{value:986, name:'帐户总金额'}
					]
				}
			]
	};
	myChart2.setOption(option2);
}






//	高级会员 帐户查询
if( $('#tb_ghcx1').length > 0 ){
	var myChart1 = echarts.init(document.getElementById('tb_ghcx1'));
	option1 = {
			title: {
				text: '发布订单的类型统计',
				textAlign: 'center',
				left: '20%',
				top: '35px',
				textStyle:{ fontSize: '26', color: '#505050', fontFamily: 'SimHei', fontWeight: 'normal' },
			},
			tooltip: {
				trigger: 'item',
//				formatter: "<div style='padding:10px 30px;'><p style='font-size:18px;text-align:center;line-height:24px;'>{b}</p><p style='font-size:28px;text-align:center;line-height:36px;'>{c}</p></div>"
				formatter: "<div style='font-size:16px;line-height:30px;padding:5px;'>{b} <br/> {c} ({d}%)</div>"
			},
			color:['#5D9CEC', '#FB6E52', '#FFCE55', '#A0D468', '#5F52A0', '#D48265', '#00561F', '#E2E2E2'],
			legend: {
				show: true,
//				orient: 'vertical',
				left: '35%',
				top: '38%',
				itemGap: 55,
				itemWidth: 20,
				itemHeight: 22,
				textStyle:{ fontSize: '24' },
				data:['网络媒体','户外媒体','平面媒体','电视媒体','广播媒体','记者报料','内容代写','宣传定制']
			},
			grid: {
				containLabel: true
			},
			series: [
				{
					type:'pie',
					radius: ['45%', '60%'],
					center: ['20%', '62%'],
					avoidLabelOverlap: false,
					label: {
						normal: {
							show: false,
							position: 'center'
						},
						emphasis: {
							show: false,
							textStyle: { fontSize: '20', fontWeight: 'bold' }
						}
					},
					labelLine: {
						normal: { show: false }
					},
					data:[
						{value:335, name:'网络媒体'},
						{value:100, name:'户外媒体'},
						{value:200, name:'平面媒体'},
						{value:330, name:'电视媒体'},
						{value:444, name:'广播媒体'},
						{value:555, name:'记者报料'},
						{value:666, name:'内容代写'},
						{value:777, name:'宣传定制'}
					]
				}
			]
	};
	myChart1.setOption(option1);
}





//	供应商 帐户查询
if( $('#tb_gyscx1').length > 0 ){
	var myChart1 = echarts.init(document.getElementById('tb_gyscx1'));
	option1 = {
			title: {
				text: '发布订单的类型统计',
				textAlign: 'center',
				left: '20%',
				top: '35px',
				textStyle:{ fontSize: '26', color: '#505050', fontFamily: 'SimHei', fontWeight: 'normal' },
			},
			tooltip: {
				trigger: 'item',
//				formatter: "<div style='padding:10px 30px;'><p style='font-size:18px;text-align:center;line-height:24px;'>{b}</p><p style='font-size:28px;text-align:center;line-height:36px;'>{c}</p></div>"
				formatter: "<div style='font-size:16px;line-height:30px;padding:5px;'>{b} <br/> {c} ({d}%)</div>"
			},
			color:['#5D9CEC', '#FB6E52', '#FFCE55', '#A0D468', '#5F52A0', '#D48265', '#00561F', '#E2E2E2'],
			legend: {
				show: true,
//				orient: 'vertical',
				left: '35%',
				top: '38%',
				itemGap: 55,
				itemWidth: 20,
				itemHeight: 22,
				textStyle:{ fontSize: '24' },
				data:['网络媒体','户外媒体','平面媒体','电视媒体','广播媒体','记者报料','内容代写','宣传定制']
			},
			grid: {
				containLabel: true
			},
			series: [
				{
					type:'pie',
					radius: ['45%', '60%'],
					center: ['20%', '62%'],
					avoidLabelOverlap: false,
					label: {
						normal: {
							show: false,
							position: 'center'
						},
						emphasis: {
							show: false,
							textStyle: { fontSize: '20', fontWeight: 'bold' }
						}
					},
					labelLine: {
						normal: { show: false }
					},
					data:[
						{value:335, name:'网络媒体'},
						{value:100, name:'户外媒体'},
						{value:200, name:'平面媒体'},
						{value:330, name:'电视媒体'},
						{value:444, name:'广播媒体'},
						{value:555, name:'记者报料'},
						{value:666, name:'内容代写'},
						{value:777, name:'宣传定制'}
					]
				}
			]
	};
	myChart1.setOption(option1);
}





//	普通会员_账户查询—提现充值列表明细
if( $('#tb_ptcx1').length > 0 ){
	var myChart1 = echarts.init(document.getElementById('tb_ptcx1'));
	option1 = {
			title: {
				text: '发布订单的类型统计',
//				subtext: '已发布订单数\n3520',
				textAlign: 'center',
				left: '20%',
				top: '40px',
				subTop: 'center',
				textStyle:{ fontSize: '26', color: '#505050', fontFamily: 'SimHei', fontWeight: 'normal' },
			},
			tooltip: {
				trigger: 'item',
//				formatter: "<div style='padding:10px 30px;'><p style='font-size:18px;text-align:center;line-height:24px;'>{b}</p><p style='font-size:28px;text-align:center;line-height:36px;'>{c}</p></div>"
				formatter: "<div style='font-size:16px;line-height:30px;padding:5px;'>{b} <br/> {c} ({d}%)</div>"
			},
			color:['#5D9CEC', '#FB6E52', '#FFCE55', '#A0D468', '#5F52A0', '#D48265', '#00561F', '#E2E2E2'],
			legend: {
				show: true,
//				orient: 'vertical',
				left: '45%',
				top: '20%',
				itemGap: 80,
				itemWidth: 20,
				itemHeight: 22,
				textStyle:{ fontSize: '24' },
				data:['网络媒体','户外媒体','平面媒体','电视媒体','广播媒体','记者报料','内容代写','宣传定制']
			},
			grid: {
				containLabel: true
			},
			series: [
				{
					type:'pie',
					radius: ['45%', '60%'],
					center: ['20%', '58%'],
					avoidLabelOverlap: false,
					label: {
						normal: {
							show: false,
							position: 'center'
						},
						emphasis: {
							show: true,
							formatter: '{b} \n {c} \n {d}%',
							textStyle: { fontSize: '20', fontWeight: 'bold' }
						}
					},
					labelLine: {
						normal: { show: false }
					},
					data:[
						{value:335, name:'网络媒体'
							,markPoint: {
								symbol: 'pin'
							}
						},
						{value:100, name:'户外媒体'},
						{value:200, name:'平面媒体'},
						{value:330, name:'电视媒体'},
						{value:444, name:'广播媒体'},
						{value:555, name:'记者报料'},
						{value:666, name:'内容代写'},
						{value:777, name:'宣传定制'}
					]
				}
			]
	};
	myChart1.setOption(option1);
}


