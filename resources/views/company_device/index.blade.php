@extends('layouts.master')

@section('title')

@stop

@section('content')

<div id="main" style="width: 900px;height:400px;"></div>
   

@stop

 @section('js-end')
	var myChart = echarts.init(document.getElementById('main'), 'shine');

        // 指定图表的配置项和数据
        option = {
			title : {
				text: '在线设备厂商分布图',
				//subtext: '纯属虚构',
				x:'center'
			},
			tooltip : {
				trigger: 'item',
				formatter: "{a} <br/>{b} : {c} ({d}%)"
			},
			legend: {
				x : 'center',
				y : 'bottom',
				data:['上元信安','中兴','神州数码','鼎普','百卓','东华','安天','太一','安信华']
			},
			toolbox: {
				show : true,
				feature : {
					mark : {show: true},
					dataView : {show: true, readOnly: false},
					magicType : {
						show: true,
						type: ['pie', 'funnel']
					},
					restore : {show: true},
					saveAsImage : {show: true}
				}
			},
			calculable : true,
			series : [
				{
					name:'半径模式',
					type:'pie',
					radius : [20, 110],
					center : ['25%', 200],
					roseType : 'radius',
					label: {
						normal: {
							show: false
						},
						emphasis: {
							show: true
						}
					},
					lableLine: {
						normal: {
							show: false
						},
						emphasis: {
							show: true
						}
					},
					data:[
						{value:10, name:'上元信安'},
						{value:5, name:'中兴'},
						{value:15, name:'神州数码'},
						{value:25, name:'鼎普'},
						{value:20, name:'百卓'},
						{value:35, name:'东华'},
						{value:30, name:'安天'},
						{value:30, name:'安信华'},
						{value:40, name:'太一'}
					]
				},
				{
					name:'在线设备升级',
					type:'pie',
					radius : [30, 110],
					center : ['75%', 200],
					roseType : 'area',
					data:[
						{value:10, name:'上元信安'},
						{value:5, name:'中兴2'},
						{value:15, name:'神州数码'},
						{value:25, name:'鼎普'},
						{value:20, name:'百卓'},
						{value:35, name:'东华'},
						{value:30, name:'安天'},
						{value:30, name:'安信华'},
						{value:40, name:'太一'}
					]
				}
			]
		};


        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
	@stop
