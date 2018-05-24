@extends('layouts.master')

@section('title')

@stop

@section('content')

<div id="main" style="width: 900px;height:400px;"></div>
   

@stop

 @section('js-end')
	var myChart = echarts.init(document.getElementById('main'));

        // 指定图表的配置项和数据
        option = {
			tooltip: {
				trigger: 'item',
				formatter: "{a} <br/>{b}: {c} ({d}%)"
			},
			legend: {
				orient: 'vertical',
				x: 'left',
				data:['直达','营销广告','搜索引擎','邮件营销','联盟广告','视频广告','百度','谷歌','必应','其他']
			},
			series: [
				{
					name:'访问来源',
					type:'pie',
					selectedMode: 'single',
					radius: [0, '30%'],

					label: {
						normal: {
							position: 'inner'
						}
					},
					labelLine: {
						normal: {
							show: false
						}
					},
					data:[
						{value:335, name:'直达', selected:true},
						{value:679, name:'营销广告'},
						{value:1548, name:'搜索引擎'}
					]
				},
				{
					name:'访问来源',
					type:'pie',
					radius: ['40%', '55%'],

					data:[
						{value:335, name:'直达'},
						{value:310, name:'邮件营销'},
						{value:234, name:'联盟广告'},
						{value:135, name:'视频广告'},
						{value:1048, name:'百度'},
						{value:251, name:'谷歌'},
						{value:147, name:'必应'},
						{value:102, name:'其他'}
					]
				}
			]
		};

        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
	@stop
