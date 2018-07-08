<?php

/*活动审核*/

require_once(base_path().'/resources/views/init.blade.php');

$auditstatus = $oj->search->auditstatus;
?>

@extends('manage.layout')


@section('content')



<ol class="crumb clearfix">
    <li>活动审核</li>	
</ol>


<div class="page-title-row" >
	<form action="" method="get" class="form-inline">
		{!! csrf_field() !!}
		<div class="form-group input-group">                        
			<input type="text" placeholder="活动名称" autocomplete="off" class=" form-control" name="title" value="{{$oj->search->title}}"/>
			<ul class="vagueSearchBox"></ul>
		</div> 
		<button type="submit" class="btn btn-info btnsearch">查询</button>
	</form> 
</div>


<div class="page-title-row">
	<a href="{{$cc}}" class="{{ (''==$auditstatus) ? 'btn btn-success' : '' }}" >全部</a>
		&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{$cc}}?auditstatus=new" class="{{ ('new'==$auditstatus) ? 'btn btn-success' : '' }}">待审核</a> 
		&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{$cc}}?auditstatus=pass" class="{{ ('pass'==$auditstatus) ? 'btn btn-success' : '' }}">已通过</a> 
		&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{$cc}}?auditstatus=unpass" class="{{ ('unpass'==$auditstatus) ? 'btn btn-success' : '' }}">未通过</a>
                
                
</div>



<div class="row page-title-row hidden" >
    <div class="col-md-6">
		
    </div>
    <div class="col-md-6 text-right" >
        <a href="javascript:void(0)" class="btn btn-success btn-md" type="button">
            批量审核
        </a>
        <a href="javascript:void(0)" class="btn btn-success btn-md" type="button">
            导出活动
        </a>		      
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
                <th width="2%">#</th>
                <th width="*">名称</th>		
				<th width="10%">类型</th>	
				<th width="8%">发起部门</th>	
                <th width="10%">活动时间</th>
				
				<th width="8%">人数限制</th>
				<th width="8%">审核状态</th>
				<th width="8%">当前状态</th>
				<th width="12%">操作</th>
            </tr>
        </thead>
   
		@foreach($list as $v)
        <tr>
            <td><input type="checkbox" id="" /></td>
            <td>{{$v->title}}</td>  
			<td>{{$v->type_onename}}/{{$v->type_twoname}}</td>
			<td>{{$v->suname}}</td>	
			<td>{{formattime1($v->plantime_one)}}</td>			

			<td>{{(0==$v->signlimit)? '无' : $v->signlimit}}</td> 
			<td class="j_audit_{{ ($v->auditstatus) }}">{{ checkstatus($v->auditstatus) }}</td> 

			<td class="">{{ timetocurrentstatus($v->plantime_one, $v->plantime_two) }}</td> 

            <td>
			    <a href="{{$currentcontroller .'/'. $v->id }}">
                   详情&amp;审核
                </a>
            </td>
        </tr>
		@endforeach
    </table>
</div>



<center>{!! $list->appends(object_to_array($oj->search))->render() !!}</center>



@include('admin.partials._modals')


@stop


