<?php

require_once(base_path().'/resources/views/init.blade.php');

$data =& $oj->data;
$course =& $oj->course;



/*活动详情*/
$tab = 'tab_detail';


/*下面注入每个选项卡的操作*/
?>



@extends('student.layout')


@section('content')



<ol class="crumb clearfix" >
    <li><a href="/student">我的报名</a></li>
	<li class="active"> - {{$course->title}}</li>
</ol>






<div class="panel panel-info">


    <div class="panel-body" >
		
		<table class="table1 table table-striped table-hover">

			<tr>
				<td width="30%">报名时间：</td>
				<td width="30%">{{$data->created_at}}</td>				
			</tr>

			<tr>
				<td width="30%">申请陈述：</td>
				<td width="30%">{{$data->mystate}}</td>				
			</tr>

			<tr>
				<td width="30%">审核状态：</td>
				<td width="30%">{{checkstatus($data->auditstatus)}}</td>				
			</tr>

			@if('unpass' == $data->auditstatus)
			<tr>
				<td width="30%">未审核通过原因：</td>
				<td width="30%">{{$data->myexplain}}</td>				
			</tr>
			@endif
		</table>

    </div>
</div>
@stop

@section('scripts')

@endsection

