<?php

require(base_path().'/resources/views/init.blade.php');

?>

@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>校外荣誉管理</li>
	<li> - 详情</li>	
</ol>


<div class="row page-title-row" >
    <div class="col-md-6">
		
    </div>
    <div class="col-md-6 text-right" >


    </div>	
</div>



<div class="panel panel-info">
    <div class="panel-body" >
		
       @include('pub/outerhonordetail')

    </div>
</div>

@stop

@section('scripts')

@endsection