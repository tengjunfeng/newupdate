@extends('layouts.master')

@section('title')

@stop

@section('content')
<table>
<tr>
<th>所有升级次数</th><th>近一周升级次数</th>
</tr>
<tr>

<td><div id="main1" style="width: 550px;height:300px;"></div></td>
<td><div id="main2" style="width: 550px;height:300px;"></div></td>
</tr>

<tr>
<th>近一月升级次数</th><th>近一年升级次数</th>
</tr>
<tr>
<td><div id="main3" style="width: 550px;height:300px;"></div></td>
<td><div id="main4" style="width: 550px;height:300px;"></div></td>
</tr>
 </table>  

@stop

 @section('js-end')
// 指定图表的配置项和数据
	option = {
		/*
		title : {
			//text: '升级厂商分布图',
			//subtext: '所有升级次数',
			x:'center'
		},*/
		tooltip : {
			trigger: 'item',
			formatter: "{a} <br/>{b} : {c} ({d}%)"
		},
		legend: {
			orient: 'vertical',
			left: 'left',
			data:[]
		},
		series : [
			{
				name: '升级厂商',
				type: 'pie',
				radius : '65%',
				center: ['50%', '60%'],
				 
				data:[
					/*
					//{value:datas["中兴"], name:'中兴'},
					//{value:datas["东华"], name:'东华'},
					
					{value:25, name:'中兴'},
					{value:15, name:'神州数码'},
					{value:35, name:'鼎普'},
					{value:40, name:'百卓'},
					{value:45, name:'东华'},
					{value:50, name:'安天'},
					{value:55, name:'安信华'},
					{value:70, name:'太一'}
					*/
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
	
	
	option2 = {
		
		tooltip : {
			trigger: 'item',
			formatter: "{a} <br/>{b} : {c} ({d}%)"
		},
		legend: {
			orient: 'vertical',
			left: 'left',
			data:[]
		},
		series : [
			{
				name: '升级厂商',
				type: 'pie',
				radius : '65%',
				center: ['50%', '60%'],
				 
				data:[],
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

	option3 = {	
		tooltip : {
			trigger: 'item',
			formatter: "{a} <br/>{b} : {c} ({d}%)"
		},
		legend: {
			orient: 'vertical',
			left: 'left',
			data:[]
		},
		series : [
			{
				name: '升级厂商',
				type: 'pie',
				radius : '65%',
				center: ['50%', '60%'],
				 
				data:[],
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

	option4 = {
		tooltip : {
			trigger: 'item',
			formatter: "{a} <br/>{b} : {c} ({d}%)"
		},
		legend: {
			orient: 'vertical',
			left: 'left',
			data:[]
		},
		series : [
			{
				name: '升级厂商',
				type: 'pie',
				radius : '65%',
				center: ['50%', '60%'],
				 
				data:[],
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
	
	var myChart = echarts.init(document.getElementById('main1'), 'shine');
	
	var myChart2 = echarts.init(document.getElementById('main2'), 'macarons');
	var myChart3 = echarts.init(document.getElementById('main3'), 'roma');
	var myChart4 = echarts.init(document.getElementById('main4'), 'infographic');

	$.ajax({ 					
			type:"get", 					
			url: "/company_update/jsondata", 					
			async:false, 	
			dataType: 'json',
			success:function(data){	 							
				 var ldata1 = [];
				 
				 var sdata1 = [];			 
				 var sdata2 = [];
				 var sdata3 = [];
				 var sdata4 = [];

				$.each(data,function(index,value){
					//console.log(value);
					
					ldata1.push(value.name);
					var obj1 = {};
					obj1.value = value.num_all;
					obj1.name = value.name;
					sdata1.push(obj1);
					
					
					
					//ldata2.push(value.name);
					var obj2 = {};
					obj2.value = value.num_week;
					obj2.name = value.name;
					sdata2.push(obj2);
					
					//ldata3.push(value.name);
					var obj3 = {};
					obj3.value = value.num_month;
					obj3.name = value.name;
					sdata3.push(obj3);
					
					//ldata4.push(value.name);
					var obj4 = {};
					obj4.value = value.num_year;
					obj4.name = value.name;
					sdata4.push(obj4);
					
				})
				
				//console.log(ldata);
				//console.log(sdata);
				
				//option.legend.data = ldata1;
				option.series[0].data = sdata1;
				
				//option2.legend.data = ldata1;
				option2.series[0].data = sdata2;
				
				//option3.legend.data = ldata1;
				option3.series[0].data = sdata3;
				
				//option4.legend.data = ldata1;
				option4.series[0].data = sdata4;
				
				// 使用刚指定的配置项和数据显示图表。
				myChart.setOption(option);	
				myChart2.setOption(option2);
				myChart3.setOption(option3);
				myChart4.setOption(option4);
			} 				
	});
	@stop
