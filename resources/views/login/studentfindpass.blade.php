<?php

$title = '找回密码';

?>

@extends('layoutlogin')


@section('content')
<form action="{{$_SERVER['REQUEST_URI'] }}" method="post">

	{!! csrf_field() !!}

	<div class="form-group">
		<div class="col-xs-12  ">
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
				<input type="text" name="realname" required="required" class="form-control col-xs-10" value="{{old('realname')}}" placeholder="姓名">
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-xs-12  ">
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-th-large"></span></span>
				<input type="text" name="mycode" required="required" class="form-control col-xs-10" value="{{old('mycode')}}" placeholder="学号">
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-xs-12  ">
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-th-large"></span></span>
				<input type="text"  required="required" name="mynumber" class="form-control" autocomplete="off" value="{{old('mynumber')}}" placeholder="身份证号">
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