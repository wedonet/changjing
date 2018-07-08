<?php

require_once(base_path().'/resources/views/init.blade.php');

?>

@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>活动管理</li>	
</ol>
<div></div>
<div class="row nav1">
    <div class="col-md-6">&nbsp;
		
    </div>
    <div class="col-md-6 text-right" >
        <a href="{{ $currentcontroller }}/create" class="btn btn-success btn-md hidden" type="button">
            申请活动
        </a>
        <a href="{{ $currentcontroller }}_export" class="btn btn-success btn-md" type="button">
            导出活动
        </a>		      
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
                <th width="4%">#</th>
                <th width="*">名称</th>		
				<th width="11%">类型</th>	
                <th width="10%">活动时间</th>
				<th width="15%">活动地点</th>
				<th width="5%">人数</th>
	

				<th width="7%">审核</th>
				<th width="7%">当前</th>
				<th width="7%">操作</th>
            </tr>
        </thead>
   
		@foreach($list as $v)
        <tr>
            <td>{{$v->id}}</td>
            <td>{{$v->title}}</td>  
			<td>{{$v->type_onename .'/'. $v->type_twoname}}</td> 
			<td>{{formattime1($v->plantime_one)}}</td> 
			<td>{{$v->myplace}}</td> 
			<td>{{$v->signlimit}}</td> 


			<td class="auditstatus_{{$v->auditstatus}}">{{checkstatus($v->auditstatus)}}</td> 
			<td>{{timetocurrentstatus($v->plantime_one, $v->plantime_two)}}</td> 
            <td>
				
			    <a href="huodong/{{$v->id}}" class="btn btn-xs btn-link ">
                    <i class="glyphicon "></i>详情
                </a>
            </td>
        </tr>
		@endforeach
     


	
    </table>
</div>


<center>{!! $list->render() !!}</center>




@include('admin.partials._modals')


@stop


