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
    <li>履职修业审核</li>	
</ol>

<div class="row page-title-row" >
    <div class="col-md-6">
		
    </div>
    <div class="col-md-6 text-right" >
        {{--<a href="{{ $currentcontroller }}/create" class="btn btn-success btn-md" type="button">--}}
            {{--申请活动--}}
        {{--</a>--}}
		      
    </div>

	
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
                <th width="5%">#</th>
                <th>学号</th>
                <th>姓名</th>
                <th>聘职学年</th>
                <th>职务全称</th>
                <th>一级活动类型</th>
                <th>二级活动类型</th>
                <th>聘任部门</th>
                {{--<th width="10%">履职修业名称</th>          --}}
                <th width="15%">操作</th>            </tr>
        </thead>
   
        <tr>
            <td></td>
            <td>001</td>
            <td>张三</td>
            <td>4学年</td>
            <td>部长</td>
            <td>一级活动类型名称</td>
            <td>二级活动类型名称</td>
            <td>学生会</td>
            {{--<td>校外荣誉名称</td>--}}
            <td>
                <a href="javascript:;" class="btn btn-xs btn-link ">
                    <i class="glyphicon "></i>详情
                </a>
                <a href="javascript:;" class="btn btn-xs btn-link ">
                    <i class="glyphicon "></i>审核
                </a>
            </td>
        </tr>


    
    </table>
</div>







@include('admin.partials._modals')


@stop


