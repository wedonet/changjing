<?php

require(base_path().'/resources/views/init.blade.php');

?>

@extends('manage.layout')


@section('content')

<ol class="crumb clearfix">
    <li>履职修业审核</li>	
	<li> - 详情</li>

	
</ol>


<div class="row page-title-row" >


    <div class="col-md-6">

    </div>
    <div class="col-md-6 text-right" >
        @if(1 <> $data->isok)
        <a href="{{$cc}}/{{$data->id}}/dopass" class="btn btn-success btn-md j_confirmpost" title="{{$data->title}} 通过审核" type="button">
            审核通过
        </a>
        @endif

        @if(2 <> $data->isok)
        <a href="{{$cc}}/{{$data->id}}/unpass"  class="btn btn-warning btn-md j_open" type="button">
            未通过
        </a>  
        @endif
    </div>	
</div>


<div class="panel panel-info">
    <div class="panel-body" >

		@include('pub.performdetail')

    </div>
</div>

@stop

@section('scripts')

@endsection