<?php
$title = '管理员登录';
?>

@extends('layoutlogin')
@section('content')
<form action="{{ $_SERVER['REQUEST_URI']  }}" method="post" class="j_form">
	{!! csrf_field() !!}
	<div class="form-group">
		<div class="col-xs-12  ">
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
				<input type="text" id="uname" name="uname" required="required" class="form-control col-xs-10" placeholder="管理员登录名"  value="{{ old('uname') }}">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-xs-12  ">
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
				<input type="text" onfocus="this.type='password'" required="required" name="upass" class="form-control" autocomplete="off" placeholder="管理员密码">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-xs-12">
			<input type="submit" id="submit" class="btn btn-sm btn-success  col-xs-12 j_slowsubmit" disabled="disabled" value="登 录" />
		</div>
	</div>
</form>
@endsection