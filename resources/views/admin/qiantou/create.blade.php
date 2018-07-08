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
    <li>选择牵头部门</li>	
</ol>


<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="10%">名称</th>
				<th width="*">简介</th>
                <th width="20%">操作</th>
            </tr>
        </thead>

        <tr>
            <td>1</td>
            <td>部通部门1</td>
            <td>部通部门1的介绍</td>
        
  
            <td>
				<a href="{{ $currentcontroller }}" class="btn btn-xs btn-link">
                    <i class="glyphicon glyphicon-user"></i> 设为牵头部门
                </a>
            </td>
        </tr>
 
        <tr>
            <td>2</td>
            <td>部通部门2</td>
            <td>部通部门2的介绍</td>
        
  
            <td>
				<a href="{{ $currentcontroller }}" class="btn btn-xs btn-link">
                    <i class="glyphicon glyphicon-user"></i> 设为牵头部门
                </a>
            </td>
        </tr>

    </table>
</div>







@include('admin.partials._modals')


@stop


