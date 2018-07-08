<?php

/*活动审核*/
require_once(base_path().'/resources/views/init.blade.php');



?>

@extends('manage.layout')


@section('content')

<ol class="crumb clearfix">
    <li>活动审核</li>
	<li> - {{$data->title}}</li>
</ol>



<div class="row page-title-row" >
    <div class="col-md-6">
		
    </div>
    <div class="col-md-6 text-right" >

		@if('pass' <> $data->auditstatus)
        <a href="{{$currentcontroller}}/{{$data->id}}/dopass" class="btn btn-success btn-md j_confirmpost" title="{{$data->title}} 通过审核" type="button" rel="">
            审核通过
        </a>
		@endif

		@if('unpass' <> $data->auditstatus)
		<a href="{{$currentcontroller}}/{{$data->id}}/unpass"  class="btn btn-warning btn-md j_open" type="button">
            未通过
        </a>  
		@endif
    </div>	
</div>


<div class="toptip clearfix margintop1" >
	<div class="floatleft"><strong>审核状态：</strong> 
		&nbsp; <span class="j_audit_{{ ($data->auditstatus) }}">{{ checkstatus($data->auditstatus) }}</span> 

		{{--未通过审核的显示原因--}}
		@if('unpass' == $data->auditstatus)
		<span class="text-warning">{{ ($oj->o_audit==true) ? '('.$oj->o_audit->myexplain.')' : ''}}</span>
		@endif
	</div>
</div>



<div class="panel panel-info">
    <div class="panel panel-info">

		@include('pub.huodongdetail')

    </div>
</div>
</div>




@stop

@section('scripts')
<script>
$(function () {


})
</script>
@endsection