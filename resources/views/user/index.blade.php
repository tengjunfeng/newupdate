@extends('layouts.master')

@section('title')

@stop

@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
		@if(Auth::user()->level == '1')
			 <a href="{{ url('/user/create') }}" class="btn btn-primary">新增用户</a>
		@endif
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>名称</th>
		  <th>等级</th>
				  <th>邮箱</th>
				  <th>修改时间</th>
				  <th>创建时间</th>
                </tr>
                </thead>
                <tbody>
		@foreach ($users as $user)
                <tr>
		  <td>{{ $user->id }}</td>
		  <td>{{ $user->name }}</td>
		  <td>						
			@if ($user['level'] ==1)
			管理员用户
			@elseif($user['level'] ==0)
			普通用户
			@else
			Guest
			@endif
		  </td>
		  <td>{{ $user->email }}</td>
		  <!--<td>{{ $user->T_FILE_MD5 }}</td>-->
		  <td>{{ $user->updated_at }}</td>
		  <td>{{ $user->created_at}}</td>
		</tr>
		@endforeach
	     </table>
	  </div>
	</div>
     </div>
</div>
{!! $users->render() !!}
@stop
