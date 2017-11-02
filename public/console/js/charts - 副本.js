$(function(){
	
// 首页投放分布
if( $("#pti_1").length>0 ){
	var myChart = echarts.init(document.getElementById('pti_1'));
	// 指定图表的配置项和数据
	var dataMap = {};
function dataFormatter(obj) {
    var pList = ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'];
    var temp;
    for (var year = 2002; year <= 2002; year++) {
        var max = 0;
        var sum = 0;
        temp = obj[year];
        for (var i = 0, l = temp.length; i < l; i++) {
            max = Math.max(max, temp[i]);
            sum += temp[i];
            obj[year][i] = {
                name : pList[i],
                value : temp[i]
            }
        }
        obj[year + 'max'] = Math.floor(max / 100) * 100;
        obj[year + 'sum'] = sum;
    }
    return obj;
}

dataMap.dataWL = dataFormatter({
     2002:[1525,211,255,542,12,414,414,201,14,44,41,210] /*网络媒体*/  
});

dataMap.dataHW = dataFormatter({
    2002:[85,14,444,54,41,255,44,51,544,4,21,2] /*户外媒体*/  
});

dataMap.dataBM = dataFormatter({
    2002:[1000,32,255,54,325,365,22,51,544,255,21,2] /*平面媒体*/
});

dataMap.dataDS = dataFormatter({
     2002:[101,20,5,85,84,20,31,156,24,845,45,57] /*电视媒体*/
});

dataMap.dataGB = dataFormatter({
   2002:[62,82,95,15,0,594,84,35,652,154,150,41] /*广播媒体*/
});

dataMap.dataJZ = dataFormatter({
   2002:[54,542,545,21,20,254,2112,21,12,255,24,225] /*记者预约*/
});

dataMap.dataDX = dataFormatter({
    2002:[254,247,254,685,62,521,10,255,4,20,45,211] /*内容代写*/
});

dataMap.dataDZ = dataFormatter({
    2002:[574,1542,524,254,54,11,452,154,21,452,54,125] /*宣传定制*/
});





option22 = {
    baseOption: {
        timeline: {
            // y: 0,
            axisType: 'category',
            // realtime: false,
            // loop: false,
            autoPlay: false,
            // currentIndex: 2,
            playInterval: 1000,
            // controlStyle: {
            //     position: 'left'
            // },
            show:false,
            label: {
                formatter : function(s) {
                    return (new Date(s)).getFullYear();
                }
            }
        },
        title: {
           /* subtext: '数据来自国家统计局'*/
        },
        tooltip: {},
        legend: {
            x: 'center',
            data: ['网络媒体', '户外媒体', '平面媒体', '电视媒体', '广播媒体', '记者预约', '内容代写', '宣传定制']
        },
        calculable : true,
        grid: {
            top: 80,
            bottom: 50
        },
        xAxis: [
            {
                'type':'category',
                'axisLabel':{'interval':0},
                'data':[
                    '1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'
                ],
                splitLine: {show: false}
            }
        ],
        yAxis: [
            {
                type: 'value',
                name: '订单数（条）'
                ,interval: 100
            }
        ],
        series: [
            {name: '网络媒体', type: 'bar'},
            {name: '户外媒体', type: 'bar'},
            {name: '平面媒体', type: 'bar'},
            {name: '电视媒体', type: 'bar'},
            {name: '广播媒体', type: 'bar'},
            {name: '记者预约', type: 'bar'},
            {name: '内容代写', type: 'bar'},
            {name: '宣传定制', type: 'bar'},
            {
                name: '分类订单占比',
                type: 'pie',
                center: ['85%', '35%'],
                radius: '28%'
            }
        ]
    },
    options: [
        {
            /*title: {text: '2002全国宏观经济指标'},*/
            series: [
            	{data: dataMap.dataWL['2002']},
            	{data: dataMap.dataHW['2002']},
                {data: dataMap.dataBM['2002']},
                {data: dataMap.dataDS['2002']},
                {data: dataMap.dataGB['2002']},
                {data: dataMap.dataJZ['2002']},
                {data: dataMap.dataDX['2002']},
                {data: dataMap.dataDZ['2002']},

                {data: [
                    {name: '网络媒体', value: dataMap.dataWL['2002sum']},
                    {name: '户外媒体', value: dataMap.dataHW['2002sum']},
                    {name: '平面媒体', value: dataMap.dataBM['2002sum']},
                    {name: '电视媒体', value: dataMap.dataDS['2002sum']},
                    {name: '广播媒体', value: dataMap.dataGB['2002sum']},
                    {name: '记者预约', value: dataMap.dataJZ['2002sum']},
                    {name: '内容代写', value: dataMap.dataDX['2002sum']},
                    {name: '宣传定制', value: dataMap.dataDZ['2002sum']}
                ]}
            ]
        }
    ]
};

	option = {
		title: {
//			text: '折线图堆叠'
		},
		tooltip: {
			trigger: 'axis'
		},
		legend: {
//			data:['邮件营销','联盟广告','视频广告','直接访问','搜索引擎']
//总投放	网络媒体	户外媒体	平面媒体	电视媒体	广播媒体	记者报料	内容代写	宣传定制
			data:['总投放','网络媒体','户外媒体','平面媒体','电视媒体','广播媒体','记者报料','内容代写','宣传定制']
		},
		grid: {
			left: '3%',
			right: '4%',
			bottom: '3%',
			containLabel: true
		},
		toolbox: {
			feature: {
				saveAsImage: {}
			}
		},
		xAxis: {
			type: 'category',
			boundaryGap: false,
//			data: ['周一','周二','周三','周四','周五','周六','周日']
			data: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
		},
		yAxis: {
			type: 'value'
		},
		series: [
			{
				name:'总投放',
				type:'line',
				stack: '总量',
				data:[5120, 5132, 5101, 5134, 5590, 5230, 5210,5150,5300,5310,5320,5330]
			},
			{
				name:'网络媒体',
				type:'line',
				stack: '总量',
				data:[220, 182, 191, 234, 290, 330, 310]
			},
			{
				name:'户外媒体',
				type:'line',
				stack: '总量',
				data:[150, 232, 201, 154, 190, 330, 410]
			},
			{
				name:'平面媒体',
				type:'line',
				stack: '总量',
				data:[320, 332, 301, 334, 390, 330, 320]
			},
			{
				name:'电视媒体',
				type:'line',
				stack: '总量',
				data:[820, 932, 901, 934, 1290, 1330, 1320]
			},
			{
				name:'广播媒体',
				type:'line',
				stack: '总量',
				data:[820, 932, 901, 934, 1290, 1330, 1320]
			},
			{
				name:'记者报料',
				type:'line',
				stack: '总量',
				data:[820, 932, 901, 934, 1290, 1330, 1320]
			},
			{
				name:'内容代写',
				type:'line',
				stack: '总量',
				data:[820, 932, 901, 934, 1290, 1330, 1320]
			},
			{
				name:'宣传定制',
				type:'line',
				stack: '总量',
				data:[820, 932, 901, 934, 1290, 1330, 1320]
			}
		]
	};
	// 使用刚指定的配置项和数据显示图表。
	myChart.setOption(option);	
}



});

