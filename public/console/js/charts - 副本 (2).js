
// 普通会员首页 投放分布
if( $("#pti_1").length>0 ){
	var myChart1 = echarts.init(document.getElementById('pti_1'));
	var option1 = {
//		title: { text: '折线图' },
		tooltip: {
			trigger: 'axis',
			axisPointer: { type: 'line' }
		},
		color: [ '#037EF3', '#FFCE55', '#a0d468', '#fb6e52', '#48cfae', '#60d8e3', '#606fe3', '#eb943f', '#ed597f' ],
		legend: {
//			orient: 'vertical',
			left: 'center',
			bottom: '3%',
			itemGap: 22,
			itemHeight: 14,
			textStyle:{ fontSize: '18' },
			data:['总投放','网络媒体','户外媒体','平面媒体','电视媒体','广播媒体','记者报料','内容代写','宣传定制']
		},
		grid: {
			left: '5%',
			right: '5%',
			bottom: '18%',
			containLabel: true
		},
		toolbox: {
			feature: {
//				saveAsImage: {}
//				,bottom: '3%'
			}
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
		},
		series: [
			{ name:'总投放',   type:'line', data:[300, 600, 500, 800, 1100, 1500, 2500,2000,2600,3100,3700,4500] },
			{ name:'网络媒体', type:'line', data:[200, 400, 300, 500, 100, 1500, 2500,2000,2600,2100,2700,3500] },
			{ name:'户外媒体', type:'line', data:[150, 232, 201, 154, 190, 330, 410, 10, 550, 600,1888 ,2999 ] },
			{ name:'平面媒体', type:'line', data:[100,200,300,400,600,1200,1500,2100,2230,1555,3300,3100] },
			{ name:'电视媒体', type:'line', data:[820, 932, 901, 934, 934, 934, 934, 934, 934, 1290, 1330, 1320] },
			{ name:'广播媒体', type:'line', data:[820, 932, 901, 901, 901, 901, 901, 901, 934, 1290, 1330, 1320] },
			{ name:'记者报料', type:'line', data:[820,820,820,820,820,820, 932, 901, 934, 1290, 1330, 1320] },
			{ name:'内容代写', type:'line', data:[820, 932, 901, 934, 1290, 1330,1330,1330,1330,1330,1330, 1320] },
			{ name:'宣传定制', type:'line', data:[820, 932, 901, 934, 1290, 1330, 2320, 2320, 2320, 2320, 2320, 2320] }
		]
	};
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



