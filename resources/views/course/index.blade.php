<?php

/*课程*/
require_once(base_path().'/resources/views/init.blade.php');


/**/
$para  = '';
if( '' != $j['search']['type1'] ){
	$para =  'type1='.$j['search']['type1'];
}
if( '' != $j['search']['type2'] ){
	if(strlen($para)>0){
		$para .= '&amp;' ;
	} 
	$para .= 'type2='.$j['search']['type2'];	
}
if(strlen($para)>0){
	$para = '?'. $para;
}

?>

@extends('layout')

@section('content')


<ol class="crumb clearfix">
	<li><a href="/">首页</a></li>

	@foreach($j['scrumb'] as $v)
		<li> - {{$v}}</li>
	@endforeach
</ol>



<div>
	<!-- Nav tabs -->
	<ul class="nav nav-tabs tabcolor2" role="tablist">
		<li role="presentation" id="tab_activity">
			<a href="/{{$para}}"  aria-controls="home" role="tab" >活动</a>
		</li>
		<li role="presentation" id="tab_class" class="active">
			<a href="/course{{$para}}"   aria-controls="profile" role="tab">课程</a>
		</li>
	</ul>
</div>

		@foreach($list as $v)
		<div class="panel panel-default list2">
			<div class="panel-body">

			<div class="f" style="width:160px;margin-right:14px;">
				<div class="">
				<a href="/course/detail/{{$v->id}}">
				@if( '' == $v->preimg)
					<img src="/images/nopic.jpg" alt="" class="carousel-inner img-responsive img-rounded" />
				@else
					<img src="{{$v->preimg}}" alt="" class="carousel-inner img-responsive img-rounded" />
				@endif
				</a>
				</div>
			</div>

			<div class="f" style="width:80%">

				<div class="title"><a href="/course/detail/{{$v->id}}">{{$v->title}} {!! 
					formatopen($v->isopen) 
					. formatisover($v->signuptime_two)
					!!}</a></div>
				<div class="info">{{activitylevel($v->mylevel)}} / {{formattime2($v->plantime_one)}} 在{{$v->myplace}}进行</div>
				<div class="text">{!!$v->readme!!}</div>
				
			</div>
		
			</div>
		</div>
		@endforeach
		<center>{!! $list->appends(($j['search']))->render() !!}</center>
@stop
@section('style')
<style>

</style>


@if( '' != $j['search']['type2'] )
	<script type="text/javascript">
	<!--
		$(document).ready(function(){
			var buttonclass = '{{ $j['search']['type2'] }}';

			$('.' + buttonclass ).button('toggle');
		})
	//-->
	</script>
@endif

@stop