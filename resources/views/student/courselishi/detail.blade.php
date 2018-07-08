<?php

require_once(base_path().'/resources/views/init.blade.php');

?>

@extends('student.layout')


@section('content')

<ol class="crumb clearfix">
    <li><a href="/student/huodonglishi">活动管理</a></li>
	<li> - 当前活动名称 签到人数:20 评价:100(查看)</li>
	<li> - &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  签到:20人 评价:100(查看)</li>

	
</ol>



<div class="panel panel-info">


    <div class="panel-body" >

		<table class="table1">

			<tr>
				<td width="30%">活动名称：</td>
				<td width="70%">春季慰问军属</td>
			</tr>

			<tr>
				<td>开通状态</td>
				<td>开通</td>
			</tr>

			<tr>
				<td>活动学年</td>
				<td>2017-2018学年</td>
			</tr>

			<tr>
				<td>一级活动类型</td>
				<td>德</td>
			</tr>
			<tr>
				<td>二级活动类型</td>
				<td>思想道德</td>
			</tr>

			<tr>
				<td>活动级别</td>
				<td>校级</td>
			</tr>

			<tr>
				<td>活动时长</td>
				<td>2学时</td>
			</tr>

			<tr>
				<td>活动学分</td>
				<td>1/4学分</td>
			</tr>

			<tr>
				<td>活动开始时间</td>
				<td>2018-12-10 00:00:00</td>
			</tr>

			<tr>
				<td>活动结束时间</td>
				<td>2018-12-10 10:00:00</td>
			</tr>

			<tr>
				<td>活动报名开始时间</td>
				<td>2018-12-11 10:00:00</td>
			</tr>

			<tr>
				<td>活动报名结束时间</td>
				<td>2018-12-11 10:00:00</td>
			</tr>

			<tr>
				<td>主办单位</td>
				<td>学生处</td>
			</tr>

			<tr>
				<td>活动地点</td>
				<td>一区理堂</td>
			</tr>

			<tr>
				<td>是否需要提交作业</td>
				<td>是</td>
			</tr>

			<tr>
				<td>提交作业开始时间</td>
				<td>2018-12-11 10:00:00</td>
			</tr>

			<tr>
				<td>提交作业结止时间</td>
				<td>2018-12-11 10:00:00</td>
			</tr>

			<tr>
				<td>报名方式</td>
				<td>直接报名</td>
			</tr>

			<tr>
				<td>报名人数限制</td>
				<td>2</td>
			</tr>

			<tr>
				<td>活动介绍</td>
				<td>活动介绍内容</td>
			</tr>

			<tr>
				<td>备注</td>
				<td>备注内容</td>
			</tr>

			<tr>
				<td>附件</td>
				<td>附件下载</td>
			</tr>

		</table>








    </div>
</div>

@stop

@section('scripts')

@endsection