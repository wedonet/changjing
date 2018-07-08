<?php

if( array_key_exists('list', $j) ){
	$list =& $j['list'];
}else {
    $list[] = null;
}


if( array_key_exists('currentcontroller', $j) ){
	$currentcontroller =& $j['currentcontroller'];
}else {
    $currentcontroller = '';
}




?>

@extends('student.layout')


@section('content')

<ol class="crumb clearfix">
    <li>活动管理</li>	
</ol>

<div class="row page-title-row" >
    <div class="col-md-6">
		
    </div>
    <div class="col-md-6 text-right" >
        <a href="{{ $currentcontroller }}/create" class="btn btn-success btn-md" type="button">
            申请活动
        </a>
		      
    </div>

	
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="10%">名称</th>		
				<th width="10%">类型</th>	
                <th width="7%">活动时间</th>
				<th width="7%">活动地点</th>
				<th width="7%">参加人数</th>
				<th width="7%">待审人数</th>
				<th width="7%">签到人数</th>
				<th width="10%">审核状态</th>
				<th width="10%">当前状态</th>
				<th width="15%">操作</th>
            </tr>
        </thead>
   
        <tr>
            <td>4</td>
            <td>活动名称1</td>  
			<td>类型名</td> 
			<td>2017-11-1</td> 
			<td>会议室</td> 
			<td>1</td> 
			<td>2</td> 
			<td>1</td> 
			<td>已通过</td> 
			<td>已开始</td> 
            <td>
			    <a href="huodong/{{$v->signid}}" class="btn btn-xs btn-link ">
                    <i class="glyphicon "></i>详情
                </a>

				审核
            </td>
        </tr>
     


	
    </table>
</div>







@include('admin.partials._modals')


@stop


