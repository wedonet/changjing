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
	<li>活动详情</li>

</ol>




<div class="panel panel-info">


    <div class="panel-body" >


		<div class="panel-body" >

			<table class="table1">
				<tr>
					<td width="20%">名称</td>
					<td>活动名称</td>
				</tr>

				<tr>
					<td>类型</td>
					<td>类型1/类型2</td>
				</tr>

				<tr>
					<td>开始时间</td>
					<td>2017-11-1 10:00</td>
				</tr>
				<tr>
					<td>结束时间</td>
					<td>2017-11-3 10:00</td>
				</tr>

				<tr>
					<td>地点</td>
					<td>会议室</td>
				</tr>

				<tr>
					<td>活动级别</td>
					<td>校级</td>
				</tr>
				<tr>
					<td>活动介绍</td>
					<td>这是活动介绍！这是活动介绍！这是活动介绍！这是活动介绍！这是活动介绍！这是活动介绍！这是活动介绍！这是活动介绍！这是活动介绍！这是活动介绍！这是活动介绍！</td>
				</tr>
			</table>
		</div>



</div>
</div>

@stop

@section('scripts')

@endsection