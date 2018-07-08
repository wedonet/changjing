<?php

$title = '首次登录修改密码';

?>

@extends('layoutlogin')


@section('content')
<form action="{{$_SERVER['REQUEST_URI'] }}" method="post" class="j_form">
	{!! csrf_field() !!}
	<input type="hidden" name="oldpass" value="{{$j['user']->oldpass}}" />

	<div class="form-group">
		<div class="col-xs-12  ">
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
				<input type="text" name="uname" required="required" class="form-control col-xs-10" value="{{ $j['user']->uname }}" readonly="readonly">
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-xs-12  ">
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
				<input type="password" onfocus="this.type='password'" required="required" name="upass" class="form-control" autocomplete="off" placeholder="请输入新密码">
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-xs-12  ">
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
				<input type="password" onfocus="this.type='password'" required="required" name="upass_confirmation" class="form-control" autocomplete="off" placeholder="请再次输入新密码">
			</div>
		</div>
	</div>


	<div class="form-group loginBtn">
		<button type="submit" class="btn btn-sm btn-info loginButton2 col-xs-12 col-md-12">提交</button>
	

	</div>
</form>
@endsection