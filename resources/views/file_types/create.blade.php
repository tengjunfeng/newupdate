@extends('layouts.master')

@section('title')

@stop

@section('content')
<div class="row">
<!-- general form elements -->
<div class="box box-primary">
<div class="box-header with-border">
  <h3 class="box-title">新建库类型</h3>
</div><!-- /.box-header -->
<!-- form start -->
<form role="form" action="{{ url('/file_types/store') }}" method="POST" name="form1" enctype="multipart/form-data">
  <div class="box-body">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
	
    <div class="form-group">
      <label for="type">库类型名称</label>
      <input type="text" name="type" class="form-control" id="type" placeholder="eg:APP应用库">
    </div>

	<div class="form-group">
      <label for="code">库类型编码</label>
      <input type="text" name="code" class="form-control" id="code" placeholder="eg:1536">
    </div>
	
	<div class="form-group">
      <label for="postfix">库类型后缀</label>
      <input type="text" name="postfix" class="form-control" id="postfix" placeholder="eg:sig">
    </div>
	
	<div class="form-group">
      <label for="folder">存储文件夹名称</label>
      <input type="text" name="folder" class="form-control" id="folder" placeholder="eg:APP">
    </div>
	
	<div class="form-group">
      <label for="description">自定义说明</label>
      <input type="text" name="description" class="form-control" id="description" placeholder="eg:用于升级通用APP库...">
    </div>
	
	
  </div><!-- /.box-body -->

  <div class="box-footer">
    <button type="submit" class="btn btn-primary">提交</button>
	<button type="button" onclick="javascript:history.go(-1);" class="btn btn-danger">取消</button>
  </div>
</form>
</div><!-- /.box -->
</div>
@stop
