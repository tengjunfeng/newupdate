@extends('layouts.master')

@section('title')

@stop

@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
	@if(Auth::user()->level != '2')
	      <a href="{{ url('/upgrade_file/create/') }}" class="btn btn-primary">新增升级库</a>
        @endif
		<table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
				  <th>ID</th>
                  <th>系统ID</th>
                  <th>库文件名</th>
				  <!--<th>MD5</th>-->
				  <th>文件大小(bytes)</th>
				  <th>起始版本</th>
				  <th>结束版本</th>
                  <th>修改时间</th>
                  <th>操作人</th>
				  <th>操作</th>
                </tr>
                </thead>
                <tbody>
		@foreach ($ugfs as $ugf)
                <tr>
		  <td>{{ $ugf->id }}</td>
		  <td>{{ $ugf->code }}</td>
		  <td>{{ $ugf->name }}</td>
		  <!--<td>{{ $ugf->T_FILE_MD5 }}</td>-->
		  <td>{{ $ugf->size }}</td>
		  <td>{{ $ugf->start_version }}</td>
		  <td>{{ $ugf->end_version }}</td>
		  <td>{{ $ugf->updated_at }}</td>
		  <td>{{ $ugf->user }}</td>		  
		  <td>
		@if(Auth::user()->level != '2')
		  <a href="{{URL('/upgrade_file/edit/'.$ugf->id )}} " class="btn btn-success btn-sm">编辑</a>
		@endif
		  <a href="{{URL('/upgrade_file/download/'.$ugf->id )}} " class="btn btn-info btn-sm">下载</a>
		  </td>
		</tr>
		@endforeach
	     </table>
	  </div>
	</div>
     </div>
</div>
{!! $ugfs->render() !!}
@stop
