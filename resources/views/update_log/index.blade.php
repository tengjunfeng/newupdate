@extends('layouts.master')

@section('title')

@stop

@section('content')

<div id="search">
	<form action="/update_log" method="post">
		<div class="form-group">
			<input type="hidden" name="_token" value="{{ csrf_token() }}"/>				
		<label for="key">设备SN</label>
	<input type="text" name="key"  class="controls" value="{{{ $input['key'] or ''}}}"  style="width:220px" /> 
		<label for="company">厂商</label>
		<select id="company" name="company" class="controls" value="{{{ $input['company'] or ''}}}" />
			<option value=""></option>
			@foreach ($cps as $cp)
			<option value="{{ $cp->name }}">{{ $cp->name }}</option>
			@endforeach
		</select>
		<label for="ip">IP地址</label>
		<input type="text" name="ip" class="controls" value="{{{ $input['ip'] or ''}}}" />
		<label for="sys_id">系统ID</label>
		<select id="sys_id" name="sys_id" class="controls" value="{{{ $input['sys_id'] or ''}}}" />
			<option value=""></option>
			@foreach ($fts as $ft)
			<option value="{{ $ft->code }}">{{ $ft->type }}</option>
			@endforeach
			</select>
		&nbsp;&nbsp;<button type="submit" class="btn btn-primary btn-sm " >搜&emsp;索</button>&nbsp;
		&nbsp;<button type="button" onclick="javascript:window.location.href='/update_log';" class="btn btn-danger btn-sm">清&emsp;除</button>	
	 </div>			 
	</form>
</div>

<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>请求类型</th>
                  <th>系统ID</th>
				  <th>设备IP</th>
				  <th>国家</th>
				  <th>省份</th>
				  <th>城市</th>
				  <th>设备版本</th>
				  <th>厂商</th>
				  <th>设备SN</th>
                  <th>修改时间</th>
                </tr>
                </thead>
                <tbody>
		@foreach ($devs as $dev)
                <tr>
		  <td>{{ $dev->T_REQ_TYPE_ID }}</td>
		  <td>{{ $dev->sys->type }}</td>
		  <td>{{ $dev->T_DEVICE_IP }}</td>
		  <td>{{ $dev->country }}</td>
		  <td>{{ $dev->province }}</td>
		  <td>{{ $dev->city }}</td>
		  <td>{{ $dev->version }}</td>
		  <td>{{ $dev->oem_name }}</td>
		  <td>{{ $dev->T_DEVICE_SN}}</td>
		  <td>{{ $dev->created_at }}</td>
		</tr>
		@endforeach
	     </table>
	  </div>
	</div>
     </div>
</div>
{!!  $devs->appends(['key' => (isset($input['key'])?$input['key']:''), 'company' => (isset($input['company']) ? $input['company'] : ''), 'ip' => (isset($input['ip']) ? $input['ip'] : ''), 'sys_id' => (isset($input['sys_id']) ? $input['sys_id'] : '')])->render() !!}
@stop
