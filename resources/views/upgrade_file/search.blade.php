@extends('layouts.master')

@section('title')

@stop

@section('content')

<div id="search">
<form action="/upgrade_file/search" method="post">

		<div class="form-group">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<label for="key">&nbsp;库文件名&nbsp;</label>
						<input type="text" name="key"  value="{{{ $input['key'] or ''}}}" >              

					<label for="code">&emsp;库类型&nbsp;</label>
						<select id="code" name="code" class="controls" value="{{{ $input['code'] or ''}}}" >
							<option value=""></option>
							@foreach ($fts as $ft)
							@if(Auth::user()->level != '2')
								<option value="{{ $ft->code }}">{{ $ft->type }}</option>
							@else
								@if($ft->show_status==1)
								<option value="{{ $ft->code }}">{{ $ft->type }}</option>
								@endif
							@endif
							@endforeach
						</select>
					<label for="date">&emsp;起始版本&emsp;</label>
						<input class="Wdate" type="text" id="start_version" name="start_version" value="{{{ $input['start_version'] or ''}}}"  >
					<label for="date">&emsp;结束版本&nbsp;</label>
						<input class="Wdate" type="text" id="end_version" name="end_version" value="{{{ $input['end_version'] or ''}}}" >
					&nbsp;&nbsp;<button type="submit" class="btn btn-primary btn-sm " >搜&emsp;索</button>&nbsp;
					&nbsp;<button type="button" onclick="javascript:window.location.href='/upgrade_file/search';" class="btn btn-danger btn-sm">清&emsp;除</button>	
		 </div>
		 
</form>

</div>
<div class="table">
<div id="search_results" class="widget-content nopadding">
    <table id="example2" class="table table-bordered data-table" backgroud>
                <thead>
                <tr class="info">
				  <th>ID</th>
                  <th>系统ID</th>
                  <th>库文件名</th>
				  <!--<th>MD5</th>-->
				  <th>文件大小(bytes)</th>
				  <th>起始版本</th>
				  <th>结束版本</th>
                  <th>修改时间</th>
		@if(Auth::user()->level != '2')
                  <th>操作人</th>
		@endif
				  <th>操作</th>
                </tr>

                </thead>
                <tbody>
		@foreach ($ugfs as $ugf)
 @if(Auth::user()->level != '2')
                <tr>
		  <td>{{ $ugf->id }}</td>
		  <td>{{ $ugf->file_type_obj->type }}</td>
		  <td>{{ $ugf->name }}</td>
		  <!--<td>{{ $ugf->T_FILE_MD5 }}</td>-->
		  <td>{{ $ugf->size }}</td>
		  <td>{{ $ugf->start_version }}</td>
		  <td>{{ $ugf->end_version }}</td>
		  <td>{{ $ugf->updated_at }}</td>
		  <td>{{ $ugf->user }}</td>		  
		  <td>
		  <a href="{{URL('/upgrade_file/edit/'.$ugf->id )}} " class="btn btn-success btn-sm">编辑</a>
		  <a href="{{URL('/upgrade_file/download/'.$ugf->id )}} " class="btn btn-info btn-sm">下载</a>
		  </td>
		</tr>
@else
	@if($ugf->file_type_obj->show_status==1)
		<tr>
                  <td>{{ $ugf->id }}</td>
                  <td>{{ $ugf->file_type_obj->type }}</td>
                  <td>{{ $ugf->name }}</td>
                  <!--<td>{{ $ugf->T_FILE_MD5 }}</td>-->
                  <td>{{ $ugf->size }}</td>
                  <td>{{ $ugf->start_version }}</td>
                  <td>{{ $ugf->end_version }}</td>
                  <td>{{ $ugf->updated_at }}</td>            
                  <td>
                  <a href="{{URL('/upgrade_file/download/'.$ugf->id )}} " class="btn btn-info btn-sm">下载</a>
                  </td>
                </tr>
	@endif
@endif
		@endforeach
		</table>
	</div>
</div>
{!!  $ugfs->appends(['key' => (isset($input['key'])?$input['key']:''), 'code' => (isset($input['code']) ? $input['code'] : ''), 'start_version' => (isset($input['start_version']) ? $input['start_version'] : ''), 'end_version' => (isset($input['end_version']) ? $input['end_version'] : '') ])->render() !!}

@stop
