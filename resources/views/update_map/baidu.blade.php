@extends('layouts.master')

@section('title')

@stop

@section('content')
<form id="myForm">

		<div class="form-group">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<label for="sn">&nbsp;SN&nbsp;</label>
						<input type="text" name="key"  value="{{{ $input['key'] or ''}}}" >              
					<label for="city">&nbsp;城市&nbsp;</label>
						<input type="text" name="city"  value="{{{ $input['city'] or ''}}}" >
					
					<input name="submit" type="button" title="" value=" 搜索 " class="btn btn-primary btn-sm" onclick="return form_submit();"/>
					<input name="clear" type="button" title="" value=" 清除 " class="btn btn-danger btn-sm" onclick="window.location='/update_map'"/>
					
		 </div>
		 
</form>
<body style="height: 100%; margin: 0">
      <div id="container" style="height:650px;width:100%"></div>
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
        text: '上元信安在线设备地域分布图',
        //subtext: 'data from PM25.in',
        //sublink: 'http://www.pm25.in',
        left: 'center',
        textStyle: {
            color: '#F0F7FC'
        }
    },
    tooltip : {
        trigger: 'item',
		formatter: function (params) {
			//console.log(params);
			return [
				'省份: '+ params.value[4] + ' 城市: ' + params.name + '<hr size=1 style="margin: 3px 0">',
				'SN: ' + params.value[3] + '<br/>',
				'厂商: ' + params.value[6] + '<br/>',
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
        data:['设备分布'],
        textStyle: {
            color: '#fff'
        }
    },
    bmap: {
        center: [104.114129, 37.550339],
        zoom: 5,
        roam: true,
	
	mapStyle: {
            styleJson: [{
                'featureType': 'water',
                'elementType': 'all',
                'stylers': {
                    'color': '#3367AB'
                }
            }, {
                'featureType': 'land',
                'elementType': 'all',
                'stylers': {
                    'color': '#2C496F'
                }
            },/* {
                'featureType': 'railway',
                'elementType': 'all',
                'stylers': {
                    'visibility': 'off'
                }
            }, {
                'featureType': 'highway',
                'elementType': 'all',
                'stylers': {
                    'color': '#fdfdfd'
                }
            }, {
                'featureType': 'highway',
                'elementType': 'labels',
                'stylers': {
                    'visibility': 'off'
                }
            }, {
                'featureType': 'arterial',
                'elementType': 'geometry',
                'stylers': {
                    'color': '#fefefe'
                }
            }, {
                'featureType': 'arterial',
                'elementType': 'geometry.fill',
                'stylers': {
                    'color': '#fefefe'
                }
            }, {
                'featureType': 'poi',
                'elementType': 'all',
                'stylers': {
                    'visibility': 'off'
                }
            }, {
                'featureType': 'green',
                'elementType': 'all',
                'stylers': {
                    'visibility': 'off'
                }
            }, {
                'featureType': 'subway',
                'elementType': 'all',
                'stylers': {
                    'visibility': 'off'
                }
            }, {
                'featureType': 'manmade',
                'elementType': 'all',
                'stylers': {
                    'color': '#d1d1d1'
                }
            }, {
                'featureType': 'local',
                'elementType': 'all',
                'stylers': {
                    'color': '#d1d1d1'
                }
            }, {
                'featureType': 'arterial',
                'elementType': 'labels',
                'stylers': {
                    'visibility': 'off'
                }
            }, */{
                'featureType': 'boundary',
                'elementType': 'all',
                'stylers': {
                    'color': '#C0E3FA'
                }
            },/* {
                'featureType': 'building',
                'elementType': 'all',
                'stylers': {
                    'color': '#d1d1d1'
                }
            }, */{
		'featureType': 'label',     
		'elementType': 'labels.text.stroke',
		'stylers': {
		'color': '#2C496F'
		}
	    },{
                'featureType': 'label',
                'elementType': 'labels.text.fill',
                'stylers': {				
                    'color': '#BDD7FD'
                }
            }]
	}
	
    },/*
    dataRange: {
        min: 0,
        max: 100,
        calculable: true,
        color: ['#d94e5d','#eac736','#50a3ba'],
        textStyle: {
            color: '#fff'
        }
    },*/
    series : [
        {
            name: '设备分布',
            type: 'effectScatter',
            coordinateSystem: 'bmap',
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
                    color: '#FFFF6C'
                }
				
            }
        }
    ]
};

var dom = document.getElementById("container");
var myChart = echarts.init(dom);
var app = {};
form_submit();
/*
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
					obj_arr = [value.longitude, value.latitude, value.dev_ip, value.sn,value.province,value.updated_at, value.oem];
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
*/
function form_submit(){
	$.ajax({
		url:"/update_map/jsondata",
		type:"post",
		data:$("#myForm").serializeArray(),
		dataType: 'json',
		success:function(data){	 							
							 
				var sdata = [];			 
				
				$.each(data,function(index,value){

					var obj = {};
					var obj_arr = [];

					obj.name = value.city;
					obj_arr = [value.longitude, value.latitude, value.dev_ip, value.sn,value.province,value.updated_at, value.oem];
					obj.value = obj_arr;
					sdata.push(obj);
					
				})
			
				option.series[0].data = sdata;

				// 使用刚指定的配置项和数据显示图表。
				myChart.setOption(option);	
				
		},
		error:function(e){
			alert("错误！！");
			
		}
	});        
	return false;
}	

@stop
