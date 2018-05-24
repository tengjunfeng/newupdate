@extends('layouts.master')

@section('title')

@stop

@section('content')

<div id="search">
<form action="/device_info" method="post">
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
	<label for="version">设备版本</label>
	<input type="text" name="version" class="controls" value="{{{ $input['version'] or ''}}}" />
	&nbsp;&nbsp;<button type="submit" class="btn btn-primary btn-sm " >搜&emsp;索</button>&nbsp;
	&nbsp;<button type="button" onclick="javascript:window.location.href='/device_info';" class="btn btn-danger btn-sm">清&emsp;除</button>	
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
				  <th>ID</th>
                  <th>设备IP</th>
                  <th>设备SN</th>
				  <th>设备版本</th>
				  <th>厂商</th>
				  <th>所在国家</th>
				  <th>所在省份</th>
                  <th>所在城市</th>
                  <th>最后升级时间</th>
                </tr>
                </thead>
                <tbody>
		@foreach ($ip_info as $ip)
                <tr>
		  <td>{{ $ip->id }}</td>
		  <td>{{ $ip->dev_ip }}</td>
		  <td>{{ $ip->sn }}</td>
		  <td>{{ $ip->version }}</td>
		  <td>{{ $ip->oem }}</td>
		  <td>{{ $ip->country }}</td>
		  <td>{{ $ip->province }}</td>
		  <td>{{ $ip->city }}</td>
		  <td>{{ $ip->updated_at }}</td>
		</tr>
		@endforeach
	     </table>
	  </div>
	</div>
     </div>
</div>
{!!  $ip_info->appends(['key' => (isset($input['key'])?$input['key']:''), 'company' => (isset($input['company']) ? $input['company'] : ''), 'ip' => (isset($input['ip']) ? $input['ip'] : ''), 'version' => (isset($input['version']) ? $input['version'] : '')])->render() !!}
@stop
