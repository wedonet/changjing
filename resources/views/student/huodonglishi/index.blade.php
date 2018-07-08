<?php

require_once(base_path().'/resources/views/init.blade.php');

?>

@extends('student.layout')


@section('content')

<ol class="crumb clearfix">
    <li>我的活动</li>
</ol>

<div class="row page-title-row" >
    <div class="col-md-6">
		
    </div>


	
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
      
                <th width="*">名称</th>		
				<th width="10%" class="hidden">类型</th>	
                <th width="12%">活动时间</th>
				<th width="12%">地点</th>
				<th width="5%">学时</th>
				

				<th width="3%" class="hidden">报名</th>
				<th width="3%" class="hidden">参加</th>

				<th width="5%">学分</th>
				<th width="5%">等级</th>
				<th width="5%">实得</th>
	
				<th width="7%">活动状态</th>
				<th width="5%">作业</th>
				<th width="7%">评价(星)</th>
				<th width="7%">操作</th>
            </tr>
        </thead>
   
		@foreach($list as $v)
        <tr>

            <td><a href="/activity/detail/{{$v->id}}" target="_blank">{{$v->title}}</a></td>  
			<td class="hidden">{{$v->type_onename}}/{{$v->type_twoname}}</td> 
			<td>{{formattime2($v->plantime_one)}}</td> 
			<td>{{$v->myplace}}</td> 
			<td>{{$v->mytimelong}}</td> 
			
			<td class="hidden">{{$v->signcount}}</td> 
			<td class="hidden">{{$v->checkcount}}</td> 

			<td>{{$v->mycredit/1000}}</td> 
			<td>{{showlevel($v->xuefenlevel)}}</td> 
			<td>{{$v->actualcreidt>0 ?  $v->actualcreidt/1000 : '' }}</td> 


			<td>{{cstatus($v->plantime_one, $v->plantime_two)}}</td> 
			<td>{{ homeworkisdone($v->homeworkisdone)}}</td>

			<td>
			@if($v->appraise>0)
			{{$v->appraise}}
			@else
				<a href="{{$currentcontroller}}/{{$v->signupid}}/appraise" class="j_open">评价</a>
			@endif
			</td>

			<td>
				@if( 1==$v->homework )
				<a href="{{$currentcontroller}}/{{$v->signupid}}/homework">交作业</a>
				@endif
			</td>

            {{--<td>--}}
			    {{--<a href="huodong/2" class="btn btn-xs btn-link ">--}}
                    {{--<i class="glyphicon "></i>详情--}}
                {{--</a>--}}

				{{--审核--}}
            {{--</td>--}}
        </tr>
		@endforeach
    </table>
</div>

<center>{!! $list->render() !!}</center>





@include('admin.partials._modals')


@stop


