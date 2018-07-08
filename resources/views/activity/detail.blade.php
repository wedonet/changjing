<?php

require_once(base_path().'/resources/views/init.blade.php');

?>

@extends('layout')

@section('content')

<div class="container" style="padding:0">
<ol class="crumb clearfix">
	<li><a href="/">首页</a></li>
	<li><a href="/"> - 活动</a></li>
	<li> - 详情</li>
</ol>
</div>


<div class="panel panel-default">
	<div class="panel-body">
	
		<div class="container-fluid ">
			 <div class="row">
				<div class="col-md-9">
					<div class="clearfix">
						<h4 class="pull-left">{{$data->title}}</h4>
						<div class="pull-left " style="margin-left:10px;margin-top:12px;padding:1px 4px;color:#fff;font-size:12px;"> {!! formatopen($data->isopen) !!}</div>
						<div class="pull-left" style="margin-left:10px;margin-top:6px;padding:1px 4px;font-size:12px;">{!!showstar($data->appraise )!!}</div>
					</div>
				</div>
				<div class="col-md-3 text-right">
					@if(0 == $data->isopen)
						<a href="" class="btn btn-warning" disabled="disabled">报名参加 <span class="s">(暂停)</span></a>
					@elseif(time()<$data->signuptime_one )
						<a href="" class="btn btn-warning" disabled="disabled">报名参加 <span class="s">(未开始报名)</span></a>
					@elseif(time()>$data->signuptime_two)

						<a href="" class="btn btn-warning" disabled="disabled">报名参加 <span class="s">(报名已结束)</span></a>
					@else
						<a href="{{'/activity/'. $data->id . '/order'}}" class="btn btn-warning">报名参加</a>
					@endif	
				</div>
			</div>			
		</div>


		@include('activity.myinfo')
		

		<hr />

		<div class="text j_content" style="font-size:14px" id="j_content">
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{!!$data->content!!}</p>		
		</div>


		<br />	

	</div>
</div>




	





		
@stop