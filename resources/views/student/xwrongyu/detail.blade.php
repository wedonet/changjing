<?php

require_once(base_path().'/resources/views/init.blade.php');

?>

@extends('student.layout')


@section('content')

<ol class="crumb clearfix">
    <li>校外荣誉申请</li>
	<li> - 详情</li>
</ol>

<div class="panel panel-info">
<div class="panel-body" >
@include('pub/outerhonordetail')
</div>
</div>		

@endsection