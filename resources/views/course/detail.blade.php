<?php

require_once(base_path().'/resources/views/init.blade.php');

?>

@extends('layout')

@section('content')

<div class="container" style="padding:0">
<ol class="crumb clearfix">
	<li><a href="/">首页</a></li>
	<li><a href="/course"> - 课程</a></li>
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
						<a href="{{'/course/'. $data->id . '/order'}}" class="btn btn-warning">报名参加</a>
					@endif	
				</div>
			</div>			
		</div>


		@include('course.myinfo')


		<hr />

		<div class="text j_content" style="font-size:14px" id="j_content">
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{!!$data->content!!}</p>		
		</div>

		<br />


		{{--课时--}}
		@if(array_key_exists('hour',$j))
		<div class="title1">课时</div>	
				@foreach($j['hour'] as $v)
					<div style="padding-bottom:5px;">第{{$loop->index+1}}课 :
						 {{formattime2($v->start_time) . ' 至 ' . formattime2($v->finish_time)}}
					地点： {{$v->myplace}}
					</div>
				@endforeach
		@endif

		<div class="hidden">
		<div class="title1"><a name="signup">报名参加	 请填写申请陈述</a></div>


		@if(0 == $data->isopen)
				<div class="panel panel-default">
					<div class="panel-body text text-warning" style="height:100px;line-height:80px;">
						暂时停止报名
					</div>
					
				</div>
		@else
			@if(null == $_ENV['user'])
				<div class="panel panel-default">
					<div class="panel-body" style="height:100px;line-height:80px;">
						请登录后提交报名申请
					</div>
					
				</div>

			@else
				{{--判断报名时间--}}

				@if( time()<$data->signuptime_one )
				<div class="panel panel-default">
					<div class="panel-body" style="height:100px;line-height:80px;">
						还没到报名时间
					</div>
					
				</div>
				@elseif(time()>$data->signuptime_two )
				<div class="panel panel-default">
					<div class="panel-body" style="height:100px;line-height:80px;">
						报名时间已过
					</div>
					
				</div>				
				@else

				<form method="post" action="/activity/save" class="j_form">
					{!! csrf_field() !!}
				<input type="hidden" name="pid" value="{{$data->id}}" />
				<div class="container-fluid">
				<div class="row">
					<div class="col-md-9">
						<textarea name="myexplain" rows="4"  class="form-control"></textarea>
					</div>
					<div class="col-md-3">
						<input type="submit" value="提交" class="btn btn-info j_slowsubmit" disabled="disabled" />
					</div>
				</div>
				</div>
				</form>
		

				@endif
			@endif
		@endif

		</div>
		
		<br />


		


	</div>
</div>




	





		
@stop