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

@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>活动管理</li>
	<li> - 添加详情</li>
</ol>





<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">添加详情</div>
    </div>

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
				<td>活动状态</td>
				<td>未审核 &nbsp; <a href="javascript:void(0)">审核通过</a>(在未审核时显示) <a href="javascript:void(0)">审核未通过</a></td>
			</tr>

			<tr>
				<td>当前状态</td>
				<td>未开始</td>
			</tr>
		</table>
       








        </form>
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