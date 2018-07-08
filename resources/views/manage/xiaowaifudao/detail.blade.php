<?php

require(base_path().'/resources/views/init.blade.php');

$showcontact = true;

?>

@extends('manage.layout')


@section('content')

<ol class="crumb clearfix">
    <li>校外荣誉审核</li>
	<li> - 详情</li>	
</ol>


<div class="row page-title-row" >
    <div class="col-md-6">
		
    </div>
    <div class="col-md-6 text-right" >

		@if('counsellor'==$_ENV['user']['role'] And 0 == $data->isok2)

		@if(1 != $data->isok1  )
        <a href="{{$cc}}/{{$data->id}}/dopass" class="btn btn-success btn-md j_confirmpost" title="{{$data->title}} 初审通过" type="button" rel="">
            初审通过
        </a>
		@endif

		@if(2 != $data->isok1  )
		<a href="{{$cc}}/{{$data->id}}/unpass"  class="btn btn-warning btn-md j_open" type="button">
            初审未通过
        </a>  
		@endif

		@endif




		@if('sh'==$_ENV['user']['role'])
		@if(1 != $data->isok2  )


		{{--初审通过后才能复审--}}
		@if(1 != $data->isok1) 
		<button class="btn btn-success btn-md" value="" disabled="disabled">复审通过</button>  
		@else
		<a href="{{$cc}}/{{$data->id}}/dopass2" class="btn btn-success btn-md j_confirmpost operate2" title="{{$data->title}} 复审通过" type="button" rel="">
            复审通过
        </a>
		@endif
		@endif

		@if(2 != $data->isok2  )
		@if(1 != $data->isok1) 
		<button class="btn btn-success btn-md" value="" disabled="disabled" />复审未通过</button>
		@else
		<a href="{{$cc}}/{{$data->id}}/unpass2" class="btn btn-success btn-md operate2 j_open" type="button" rel="">
            复审未通过
        </a>
		@endif
		@endif
		@endif
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