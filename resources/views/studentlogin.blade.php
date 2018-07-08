<?php

$title = '学生登录';


?>

@extends('layoutlogin')

@section('content')
 <form action="/login" method="post" class="j_form">
	{!! csrf_field() !!}
	<div class="form-group">
		<div class="col-xs-12  ">
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
				<input type="text" name="mycode" required="required" class="form-control col-xs-10" placeholder="学号"  value="">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-xs-12  ">
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
				<input type="password" onfocus="this.type='password'"  required="required" name="upass" class="form-control" autocomplete="off" placeholder="密码">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-xs-12">
			<input type="submit" class="btn btn-sm btn-success  col-xs-12 j_slowsubmit" disabled="disabled" value="登 录" />
		</div>
	</div>	

	<div class="form-group">
		<div class="col-xs-12 text-right findpass">
			<a href="/login/studentfindpass">忘记密码? &nbsp; -&gt;点击这里找回</a>
		</div>
	</div>	
</form>


@endsection


