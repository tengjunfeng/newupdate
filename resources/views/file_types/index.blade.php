@extends('layouts.master')

@section('title')

@stop

@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
	      <a href="{{ url('/file_types/create/') }}" class="btn btn-primary">新增库类型</a>
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
				  <th>ID</th>
                  <th>系统ID</th>
                  <th>库文件名</th>
				  <th>文件后缀</th>
				  <th>创建时间</th>
                  <th>修改时间</th>
				  <th>说明</th>
                  <th>操作人</th>
				  <th>操作</th>
                </tr>
                </thead>
                <tbody>
		@foreach ($fts as $ft)
                <tr>
		  <td>{{ $ft->id }}</td>
		  <td>{{ $ft->code }}</td>		  
		  <td>{{ $ft->type }}</td>
		  <td>{{ $ft->postfix }}</td>
		  <td>{{ $ft->created_at }}</td>
		  <td>{{ $ft->updated_at }}</td>
		  <td>{{ $ft->description }}</td>
		  <td>{{ $ft->user }}</td>
		  <td>
		  <a href="{{URL('/file_types/edit/'.$ft->id )}} " class="btn btn-success btn-sm">编辑</a>
		  </td>
		</tr>
		@endforeach
	     </table>
	  </div>
	</div>
     </div>
</div>
@stop
