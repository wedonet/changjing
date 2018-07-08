<?php

$title = '重置密码';

?>

@extends('layoutlogin')


@section('content')
<form action="{{$_SERVER['REQUEST_URI'] }}" method="post" class="j_form">

	{!! csrf_field() !!}

	<div class="form-group">
		<div class="col-xs-12  ">
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
				<input type="text" name="realname" required="required" class="form-control col-xs-10" value="{{$oj->realname}}" placeholder="姓名">
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-xs-12  ">
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-th-large"></span></span>
				<input type="text" name="upass" required="required" class="form-control col-xs-10" value="" placeholder="新密码">
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-xs-12  ">
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-th-large"></span></span>
				<input type="text" name="upass_confirmation"  required="required" class="form-control col-xs-10" value="" placeholder="确认新密码">
			</div>
		</div>
	</div>


	<div class="form-group">
		<div class="col-xs-8 ">
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-th-large"></span></span>
				<input type="text" required="required" name="captcha" class="form-control" autocomplete="off" value="{{old('captcha')}}" placeholder="请输入右侧验证码">
			</div>
		</div>

		<div class="col-xs-4 " id="captcha"><a href="javascript:void(0)" title="看不清,换一张">{!!captcha_img()!!}</a></DIV>
	</div>




	<div class="form-group loginBtn">
		<button type="submit" class="btn btn-sm btn-info loginButton2 col-xs-12 col-md-12">提交</button>
	

	</div>
</form>
@endsection