@extends('layouts.master')

@section('title')

@stop

@section('content')
<div class="row">
<!-- general form elements -->
<div class="box box-primary">
<div class="box-header with-border">
  <h3 class="box-title">修改库文件</h3>
</div><!-- /.box-header -->
<!-- form start -->
<form role="form" action="/upgrade_file/update/{{{ $ugfs->id }}}" method="POST" name="form1" enctype="multipart/form-data">
  <div class="box-body">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
      <label for="name">所属系统</label>
		<select id="code" name="code" class="form-control" required="required" value="{{ $ugfs->code }}" readonly>
		  @foreach ($fts as $ft)
			<option value="{{ $ft->code }}">{{ $ft->type  }}</option>
		  @endforeach
		  </select>
    </div>

	<div class="form-group">
      <label for="name">库文件名称</label>
		<input type="text" id="name" name="name" class="form-control" required="required" value="{{ $ugfs->name }}" readonly>
    </div>
	
	<div class="form-group">
      <label for="name">系统语言</label>
		<select id="language" name="language" class="form-control" required="required" value="{{ $ugfs->language }}">
			<option value="2052">简体中文</option>
			<option value="9999">English</option>
	  </select>
     
    </div>
	
	<div class="form-group">
      <label for="upload_pack">替换升级包(可选项)</label>
      <input type="file" name="upload_pack" class="form-control" id="upload_pack">
    </div>
	
	<div class="form-group">
      <label for="description">自定义说明</label>
      <input type="text" name="description" class="form-control" id="description" value="{{ $ugfs->description }}">
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
@section('js-end')
$("#language").val("{{{ $ugfs->language}}}");
$("#code").val("{{{$ugfs->code}}}");
@stop
