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

@extends('manage.layout')


@section('content')

<ol class="crumb clearfix">
    <li>活动审核</li>	
</ol>


<div class="panel panel-info">


    <div class="panel-body" >

		<table class="table1">
			<tr>
				<td width="20%">名称</td>
				<td>活动名称</td>
			</tr>

			<tr>
				<td>类型</td>
				<td>活动类型</td>
			</tr>

			<tr>
				<td>时间</td>
				<td>2017-11-1 10:00</td>
			</tr>

			<tr>
				<td>地点</td>
				<td>会议室</td>
			</tr>


			<tr>
				<td>当前状态</td>
				<td>未开始</td>
			</tr>

			<tr>
				<td>审核</td>
				<td><a href="javascript:alert('通过')">审核通过</a></td>
			</tr>
		</table>
       








 
    </div>
</div>







@include('admin.partials._modals')


@stop


