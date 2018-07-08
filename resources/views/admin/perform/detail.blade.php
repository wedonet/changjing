<?php

require(base_path().'/resources/views/init.blade.php');

?>

@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>履职修业</li>	
	<li> - 详情</li>

	
</ol>



<div class="panel panel-info">
    <div class="panel-body" >

		@include('pub.performdetail')

    </div>
</div>

@stop

@section('scripts')

@endsection