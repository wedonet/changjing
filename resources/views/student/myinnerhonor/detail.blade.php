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
    <li>课程报名</li>
	<li> - 课程详情</li>
</ol>




<div class="toptip clearfix margintop1" >
	<div class="floatleft"><strong>当前状态</strong> &nbsp; 报名:20 人 通过:20 人 </div>
</div>


<div class="panel panel-info">


	<div class="panel-body" >
		<table class="table1">

			<tr>
				<td width="30%">课程名称：</td>
				<td width="70%">春季慰问军属</td>
			</tr>


			<tr>
				<td>开课学年</td>
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
				<td>牵头部门</td>
				<td>学生处</td>
			</tr>

			<tr>
				<td>课程级别</td>
				<td>校级</td>
			</tr>

			<tr>
				<td>课程时长</td>
				<td>2学时</td>
			</tr>

			<tr>
				<td>课程学分</td>
				<td>1/4学分</td>
			</tr>

			<tr>
				<td>课程开始时间</td>
				<td>2018-12-10</td>
			</tr>

			<tr>
				<td>课程结束时间</td>
				<td>2018-12-10</td>
			</tr>

			<tr>
				<td>课程报名开始时间</td>
				<td>2018-12-11</td>
			</tr>

			<tr>
				<td>课程报名结束时间</td>
				<td>2018-12-11</td>
			</tr>

			<tr>
				<td>开课地点</td>
				<td>一区理堂</td>
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
				<td>主办单位类型</td>
				<td>主办单位类型名称</td>
			</tr>


			<tr>
				<td>主办单位</td>
				<td>主办单位名称</td>
			</tr>


			<tr>
				<td>课程介绍</td>
				<td>课程介绍内容</td>
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
<script>
$(function () {
            $("#date1").on("click",function(e){
                e.stopPropagation();
                $(this).lqdatetimepicker({
                    css : 'datetime-day',
                    dateType : 'D',
                    selectback : function(){

                    }
                });
            });
})
</script>
@endsection