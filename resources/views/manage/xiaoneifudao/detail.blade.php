<?php

require(base_path().'/resources/views/init.blade.php');

?>

@extends('manage.layout')


@section('content')

<ol class="crumb clearfix">
    <li>校内荣誉管理</li>	
	<li> - 详情</li>
</ol>




<div class="panel panel-info">

    <div class="panel-body" >
		@include('pub.innerhonordetail')
    </div>
</div>

@stop

@section('scripts')

@endsection