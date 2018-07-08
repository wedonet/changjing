<?php

/*我的报名*/

require_once(base_path().'/resources/views/init.blade.php');

$auditstatus = $oj->search->auditstatus;

?>


@extends('student.layout')


@section('content')

<ol class="crumb clearfix">
    <li>我的课程报名</li>	
</ol>


<div class="row page-title-row hidden" >
    <div class="col-md-6">
		<div>
			<a href="{{$currentcontroller}}" class="{{ (''==$auditstatus) ? 'btn btn-success' : '' }}" >全部</a>

			&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{$currentcontroller}}?auditstatus=new" class="{{ ('new'==$auditstatus) ? 'btn btn-success' : '' }}">待审核</a> 

			&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{$currentcontroller}}?auditstatus=pass" class="{{ ('pass'==$auditstatus) ? 'btn btn-success' : '' }}">已通过</a> 

			&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{$currentcontroller}}?auditstatus=unpass" class="{{ ('unpass'==$auditstatus) ? 'btn btn-success' : '' }}">未通过</a>
		</div>
    </div>

</div>



<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
                <th width="3%">#</th>
                <th width="10%">名称</th>		
				<th width="10%">类型</th>	
                <th width="7%">时间</th>
		
				<th width="7%">限制人数</th>

				<th width="7%">审核状态</th>
				<th width="7%" class="hidden">活动状态</th>
				<th width="15%">操作</th>
            </tr>
        </thead>
   
		@foreach($list as $v)

        <tr>
            <td>{{$v->signid}}</td>
            <td><a href="/course/detail/{{$v->id}}" class="" title="" target="_blank">{{$v->title}}</a></td>  
			<td>{{$v->type_onename}}/{{$v->type_twoname}}</td> 
			<td>{{formattime1($v->plantime_one)}}</td> 

			<td>{{$v->signlimit}}</td> 

			<td>{{checkstatus($v->signupstatus)}}</td> 
			<td class="hidden">{{currentstatus($v->currentstatus)}}</td> 
            <td>


				<a href="/student/coursesignup/{{$v->signid}}" class="" title="">
					报名详情
				</a>

            </td>
        </tr>
		@endforeach


	
    </table>
</div>

@stop