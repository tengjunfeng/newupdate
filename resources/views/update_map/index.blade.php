@extends('layouts.master')

@section('title')

@stop

@section('content')
<body style="height: 100%; margin: 0">
      <div id="container" style="height:500px;width:100%"></div>
	  <!--<div id="container2" style="height:500px;width:100%"></div>-->
</body>
@stop
@section('js-end')


var convertData = function (data) {
    var res = [];
    for (var i = 0; i < data.length; i++) {
        var geoCoord = geoCoordMap[data[i].name];
        if (geoCoord) {
            res.push({
                name: data[i].name,
                value: geoCoord.concat(data[i].value)
            });
        }
    }
    return res;
};

option = {
    backgroundColor: '#404a59',
    title: {
        text: '在线设备地域分布图',
        //subtext: 'data from PM25.in',
        //sublink: 'http://www.pm25.in',
        left: 'center',
        textStyle: {
            color: '#fff'
        }
    },
    tooltip : {
        trigger: 'item',
		formatter: function (params) {
			//console.log(params);
			return [
				'省份: '+ params.value[4] + ' 城市: ' + params.name + '<hr size=1 style="margin: 3px 0">',
				'SN: ' + params.value[3] + '<br/>',
				'IP: ' + params.value[2] + '<br/>',
				'纬度: ' + params.value[1] + '<br/>',
				'经度: ' + params.value[0] + '<br/>',
				'最后升级时间: ' + params.value[5] + '<br/>'
				].join('');
            //return params.name + ' : ' + params.value[2];
        }
    },
    legend: {
        orient: 'vertical',
        y: 'bottom',
        x:'right',
        data:['设备数量'],
        textStyle: {
            color: '#fff'
        }
    },
	dataRange: {
        min: 0,
        max: 100,
        calculable: true,
        color: ['#d94e5d','#eac736','#50a3ba'],
        textStyle: {
            color: '#fff'
        }
    },
    geo: {
        map: 'china',
        label: {
            emphasis: {
                show: false
            }
        },
        roam: true,
        itemStyle: {
            normal: {
                areaColor: '#323c48',
                borderColor: '#111'
            },
            emphasis: {
                areaColor: '#2a333d'
            }
        }
    },
    series : [
        {
            name: '设备数量',
            type: 'effectScatter',
            coordinateSystem: 'geo',
            data: [],
			/*
            symbolSize: function (val) {
                return val[2] / 2;
            },*/
			symbolSize: 5,
			rippleEffect: {
                brushType: 'stroke'
            },
            hoverAnimation: true,
            label: {
                normal: {
                    formatter: '{b}',
                    position: 'right',
                    show: false
                },
                emphasis: {
                    show: false
                }
            },
            itemStyle: {
                normal: {
                    color: '#7B9EF6'
                }
				
            }
        }
    ]
};

var dom = document.getElementById("container");
var myChart = echarts.init(dom);
var app = {};

$.ajax({ 					
			type:"get", 					
			url: "/update_map/jsondata", 					
			async:false, 	
			dataType: 'json',
			success:function(data){	 							
							 
				 var sdata = [];			 
				
				$.each(data,function(index,value){
					//console.log(value);
					
				    //ldata.push(value.city);
					var obj = {};
					var obj_arr = [];
					//obj.value = value.total;
					obj.name = value.city;
					obj_arr = [value.longitude, value.latitude, value.dev_ip, value.sn,value.province,value.updated_at];
					obj.value = obj_arr;
					sdata.push(obj);
					
				})
				
				//console.log(ldata);
				//console.log(sdata);
				
				option.series[0].data = sdata;
				//option.series[0].data = convertData(sdata);
				//option.tooltip.formatter = sdata;
				
				// 使用刚指定的配置项和数据显示图表。
				myChart.setOption(option);	
				
			} 				
	});


@stop
