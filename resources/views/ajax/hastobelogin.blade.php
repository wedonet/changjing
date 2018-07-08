<?php

/*要求登录提示*/

//require_once(base_path().'/resources/views/init.blade.php');

$title = '操作提示';

?>




@extends('common._modals')

@section('content')
	<ul>
		<li>请登录后报名</li>
		<li><a href="/login">点击这里登录</a></li>
	</ul>

@stop
@section('style')
<style>

</style>

@stop