@extends('layouts.master')

@section('content')	

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header with-border">
				<h3 class="box-title">新建用户</h3>
            </div>
            <div class="box-content">
                <form role="form" action="{{ url('/user/store') }}" method="POST">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
					  <label for="name">用户名</label>
					  <input type="text" name="name" class="form-control" id="name" placeholder="用户名">
					</div>

					<div class="form-group">
					  <label for="level">用户等级</label>
						<select name="level" id="level" class="form-control" style="width: 100%;" >
							<option value="0">普通用户</option>
							<option value="1">管理员用户</option>
							<option value="2">Guest</option>
						</select>
					</div>
					
					<div class="form-group">
					  <label for="email">电子邮件</label>
					  <input type="email" name="email" class="form-control" id="email" placeholder="电子邮件地址">
					</div>
					
					<div class="form-group">
					  <label for="password">密码</label>
					  <input type="password" name="password" class="form-control" id="password" placeholder="密码">
					</div>
					
					<div class="form-group">
					  <label for="password_confirmation">重复密码</label>
					  <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="重复密码">
					</div>
					
                    <button type="submit" class="btn btn-primary">提交</button>
					<button type="button" onclick="javascript:history.go(-1);" class="btn btn-danger">取消</button>
                </form>

            </div>
        </div>
    </div>
    

</div>

@stop
