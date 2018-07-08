<?php

/*我的报名*/

require_once(base_path().'/resources/views/init.blade.php');

$auditstatus = $j['search']['auditstatus'];

$i = 0;
?>


@extends('student.layout')


@section('content')

<ol class="crumb clearfix">
    <li>我的报名</li>	
</ol>

<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
                <th width="3%">#</th>
                <th width="10%">名称</th>		
				<th width="10%">类型</th>	
                <th width="7%">活动时间</th>
		
				<th width="7%">限制人数</th>

				<th width="7%">审核状态</th>
				<th width="7%" class="hidden">活动状态</th>
				<th width="15%">操作</th>
            </tr>
        </thead>
   
		@foreach($list as $v)

        <tr>
            <td>{{$v->signid}}</td>
            <td><a href="/activity/detail/{{$v->id}}" class="" title="" target="_blank">{{$v->title}}</a></td>  
			<td>{{$v->type_onename}}/{{$v->type_twoname}}</td> 
			<td>{{formattime1($v->plantime_one)}}</td> 

			<td>{{$v->signlimit}}</td> 

			<td>{{checkstatus($v->signupstatus)}}</td> 
			<td class="hidden">{{currentstatus($v->currentstatus)}}</td> 
            <td>


				<a href="/student/signup/{{$v->signid}}" class="" title="">
					报名详情
				</a>

            </td>
        </tr>
		@endforeach


	
    </table>
</div>
 <center>{!! $list->render() !!}</center>
@stop