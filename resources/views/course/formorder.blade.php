<?php

require_once(base_path().'/resources/views/init.blade.php');

?>

@extends('layout')

@section('content')

<div class="container" style="padding:0">
<ol class="crumb clearfix">
	<li><a href="/">首页</a></li>
	<li><a href="/"> - 课程</a></li>
	<li> - 报名</li>
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
				
			</div>			
		</div>


		@include('course.myinfo')
	

	
		

		<hr />

		<div class="title1">报名参加	 请填写报名申请陈述</div>

		<form method="post" action="/course/save" class="j_form">
			<input type="hidden" name="pid" value="{{$data->id}}" />
				{!! csrf_field() !!}
				<div class="form-group">		
						<textarea name="myexplain" rows="4"  class="form-control"></textarea>	
						
				</div>
				<div class="form-group">
					<input type="submit" value="提交" class="btn btn-info j_slowsubmit" disabled="disabled" />
				</div>
			
		</form>


	</div>
</div>




	
	





		
@stop