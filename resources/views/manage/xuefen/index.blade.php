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

<ol class="breadcrumb">
    <li>实践学分</li>
</ol>

<!-- <div class="row page-title-row" >
    <div class="col-md-6">
		
    </div>
    <div class="col-md-6 text-right" >
        <a href="{{ $currentcontroller }}/create" class="btn btn-success btn-md" type="button">
            申请活动
        </a>
		      
    </div>

	
</div> -->

<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="10%">姓名</th>		
				<th width="10%">学分</th>
				<th width="15%">操作</th>
            </tr>
        </thead>
   
        <tr>
            <td>1</td>
            <td>张三</td>  
			<td>10</td> 			
            <td>
			    <a href="xuefen/2" class="btn btn-xs btn-link ">
                    <i class="glyphicon "></i>查看
                </a>
                <a href="dayin/2" class="btn btn-xs btn-link ">
                    <i class="glyphicon "></i>打印
                </a>

            </td>
        </tr>
     
        <tr>
            <td>1</td>
            <td>张三</td>  
			<td>10</td> 			
            <td>
			    <a href="xuefen/2" class="btn btn-xs btn-link ">
                    <i class="glyphicon "></i>查看
                </a>
                <a href="dayin/2" class="btn btn-xs btn-link ">
                    <i class="glyphicon "></i>打印
                </a>
            </td>
        </tr>

		        <tr>
            <td>1</td>
            <td>张三</td>  
			<td>10</td> 			
            <td>
			    <a href="xuefen/2" class="btn btn-xs btn-link ">
                    <i class="glyphicon "></i>查看
                </a>
                <a href="dayin/2" class="btn btn-xs btn-link ">
                    <i class="glyphicon "></i>打印
                </a>
            </td>
        </tr>

		        <tr>
            <td>1</td>
            <td>张三</td>  
			<td>10</td> 			
            <td>
			    <a href="xuefen/2" class="btn btn-xs btn-link ">
                    <i class="glyphicon "></i>查看
                </a>
                <a href="dayin/2" class="btn btn-xs btn-link ">
                    <i class="glyphicon "></i>打印
                </a>
            </td>
        </tr>

	
    </table>
</div>







@include('admin.partials._modals')


@stop


