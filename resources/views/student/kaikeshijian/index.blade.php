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
    <li><a href="kecheng">课程管理</a></li>	
	<li> - 当前课程名称</li>
</ol>

<div class="row page-title-row" >
    <div class="col-md-6">
		
    </div>
    <div class="col-md-6 text-right" >
        <a href="" class="btn btn-success btn-md" type="button">
            添加时间
        </a>
		      
    </div>

	
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="*">时间</th>
				<th width="10%">活动地点</th>
				<th width="15%">操作</th>
            </tr>
        </thead>
   
        <tr>
            <td>1</td>
            
			<td>2017-11-1 10:00 至 2017-11-1 12:00</td> 
			<td>会议室</td> 

			
            <td>

			    修改  删除
              
            </td>
        </tr>
     
        <tr>
            <td>1</td>
            
			<td>2017-11-2 10:00 至 2017-11-1 12:00</td> 
			<td>会议室</td> 

			
            <td>

			    修改  删除
              
            </td>
        </tr>

		<tr>
            <td>1</td>
            
			<td>2017-11-3 10:00 至 2017-11-1 12:00</td> 
			<td>会议室</td> 

			
            <td>

			    修改  删除
              
            </td>
        </tr>

	
    </table>
</div>







@include('admin.partials._modals')


@stop


