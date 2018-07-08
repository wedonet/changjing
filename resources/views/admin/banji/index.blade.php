<?php

require_once(base_path().'/resources/views/init.blade.php');

?>

@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>班级管理</li>	
</ol>

<div>
	<form action="{{ $currentcontroller }}" method="get" class="form-inline">
		{!! csrf_field() !!}
		<div class="form-group">
			<input type="text" placeholder="班级名称" autocomplete="off" class="form-control" name="title" value="{{$j['search']['title']}}"/>
			<input type="text" placeholder="班级号" autocomplete="off" class=" form-control" name="mycode" value="{{$j['search']['mycode']}}"/>
		</div>

		<button type="submit" class="btn btn-info">查询</button>
	</form>
</div>

<div class="row page-title-row" >
    <div class=" text-right" >
		<a href="{{ $currentcontroller }}/create" class="btn btn-success btn-md" type="button">
			添加班级
		</a>
	</div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="16%">名称</th>
                <th width="10%">班级号</th>
                <th width="14%">所属学院</th>
      
				<th width="*">负责教师</th>
				<th width="5%">排序</th>
                <th width="20%">操作</th>
            </tr>
        </thead>
        @foreach($list as $v)
        <tr>
            <td>{{$v->id}}</td>
            <td>{{$v->title}}</td>
            <td>{{$v->mycode}}</td>
            <td>{{$v->dname}}</td>
            <td>{{$v->mastername}}</td>
			<td>{{$v->cls}}</td>
  
            <td>
                <a href="banji/{{$v->id}}/edit" class="btn btn-xs btn-link ">
                    <i class="glyphicon "></i>修改
                </a>

                <a href="{{ $currentcontroller .'/'.$v->id }}" class=" j_del" title="删除" data-title1="名称" data-title2="{{$v->title}}" data-title3="班级">
                    <i class="glyphicon "></i>删除
                </a>
            </td>
        </tr>
        @endforeach

    </table>

	 <center>{!! $list->render() !!}</center>
</div>







@include('admin.partials._modals')


@stop


