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
    <li> - 选择管理部门</li>	
</ol>

<div class="row page-title-row" >
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-right" >
        <a href="{{ $currentcontroller }}/create" class="btn btn-success btn-md" type="button">
            选择管理部门
        </a>
    </div>
</div>

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
            <td>部门1</td>
            <td>部门1简介</td> 
            <td>
                <a href="{{ $currentcontroller }}" class="btn btn-xs btn-link " >
                    <i class="glyphicon glyphicon-user"></i> 设为管理部门
                </a>
            </td>
        </tr>
        <tr>
            <td>1</td>
            <td>部门2</td>
            <td>部门2简介</td> 
            <td>
                <a href="{{ $currentcontroller }}" class="btn btn-xs btn-link " >
                    <i class="glyphicon glyphicon-user"></i> 设为管理部门
                </a>
            </td>
        </tr>

    </table>
</div>







@include('admin.partials._modals')


@stop


