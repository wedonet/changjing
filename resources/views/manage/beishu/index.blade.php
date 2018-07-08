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
    <li>备述管理</li>	
</ol>

<div>调试中...</div>


<div class="table-responsive hidden">
    <table class="table table-striped table-hover" id="j_list">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="*">姓名</th>
				 <th width="10%">操作</th>
            </tr>
        </thead>
   
        <tr>
            <td>1</td>
            <td>张三</td>  
			
            <td>


			    备述
            </td>
        </tr>
     


	
    </table>
</div>







@include('admin.partials._modals')


@stop


