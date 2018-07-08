<?php

require_once(base_path().'/resources/views/init.blade.php');

$data=$j['data'];

?>

@extends('student.layout')


@section('content')

<ol class="crumb clearfix">
    <li>我的信息</li>
</ol>

<div class="row page-title-row" >
    <div class="col-md-6">
		
    </div>	
</div>




<div class="table-responsive">
    <table class="table1 table table-striped table-hover">
        <thead>
        <tr>
            <td width="10%">学号</td>
			<td>{{$data->mycode}}</td>
		</tr>

        <tr>
            <td width="10%">姓名</td>
			<td>{{$data->realname}}</td>
		</tr>

        <tr>
            <td width="10%">英文姓名</td>
			<td>{{$data->english_name}}</td>
		</tr>


        <tr>
            <td width="10%">所属学院</td>
			<td>{{$data->dname}}</td>
		</tr>


        <tr>
            <td width="10%">班级</td>
			<td>{{$data->classname}}</td>
		</tr>

        <tr>
            <td width="10%">培养层次</td>
			<td>{{$data->culture_level}}</td>
		</tr>


        <tr>
            <td width="10%">学制</td>
			<td>{{$data->educational_length}} 年</td>
		</tr>


        <tr>
            <td width="10%">入学时间</td>
			<td>{{$data->entrance_time}}</td>
		</tr>

        <tr>
            <td width="10%">专业</td>
			<td>{{$data->major}}</td>
		</tr>



			
   
    </table>
</div>







@include('admin.partials._modals')


@stop


