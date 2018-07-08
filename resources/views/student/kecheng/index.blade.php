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
</ol>

<div class="row page-title-row" >
    <div class="col-md-6">
		
    </div>


	
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list">
        <thead>
        <tr>
            <th width="5%">#</th>
            <th width="10%">名称</th>
            <th width="10%">类型</th>
            <th width="7%">开课学年</th>
            <th width="10%">上课地点</th>

            <th width="10%">审核状态</th>
            <th width="10%">当前状态</th>
            <th width="15%">操作</th>
        </tr>
        </thead>

        @for($i=1;$i<10;$i++)
            <tr>
                <td>{{$i}}</td>
                <td>我们一起读马克思</td>
                <td>德/思想道德</td>
                <td>2016-2017</td>
                <td>会议室</td>

                <td>已通过</td>
                <td>已开始</td>
                <td>
                    <a href="/kecheng/2" class="btn btn-xs btn-warning" title="">
                        详情
                    </a>
                    <a href="javascript:alert('报名成功，等待审核')" class="btn btn-xs btn-warning" title="">
                        报名
                    </a>

                </td>
            </tr>
        @endfor


	
    </table>
</div>







@include('admin.partials._modals')


@stop


