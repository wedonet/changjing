<?php

require_once(base_path().'/resources/views/init.blade.php');

?>

@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>学生管理</li>	
</ol>



<div>
	<form action="{{ $currentcontroller }}" method="get" class="form-inline">
		{!! csrf_field() !!}
		<div class="form-group">
			<input type="text" placeholder="学生姓名" autocomplete="off" class=" form-control" name="realname" 
			value="{{$j['search']['realname'] or old('realname')}}"/>
			<input type="text" placeholder="学号" autocomplete="off" class=" form-control" name="mycode" 
			value="{{$j['search']['mycode'] or old('mycode')}}"/>
		</div>
		
		<button type="submit" class="btn btn-info">查询</button>
	</form>
</div>

<div class="row page-title-row text-right" >
        <a href="{{ $currentcontroller }}/create" class="btn btn-success btn-md" type="button">
            添加学生
        </a>
		<a href="/adminconsole/student_import" class="btn btn-success btn-md" type="button">
            批量导入
        </a>
</div>


<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="10%">学号</th>
                <th width="10%">姓名</th>
              
                <th width="10%">班级</th>
                <th width="10%">院系</th>
				<th width="*">手机号</th>
                <th width="20%">操作</th>
            </tr>
        </thead>
   
		@foreach($list as $v)
        <tr>
            <td>{{$v->id}}</td>
            <td>{{$v->mycode}}</td>
            <td>{{$v->realname}}</td>
            <td>{{$v->classname}}</td>
            <td>{{$v->dname}}</td>
            <td>{{$v->mobile}}</td>
            <td>
                <a href="student/{{$v->id}}/edit" >
                    <i class="glyphicon "></i>修改
                </a> &nbsp;

                <a href="{{ $currentcontroller .'/'.$v->id }}" class=" j_del" title="删除" data-title1="姓名" data-title2="{{$v->realname}}" data-title3="学生">
                    <i class="glyphicon "></i>删除
                </a>
            </td>
        </tr>
		@endforeach
    </table>
</div>



<center>{!! $list->appends($j['search'])->render() !!}</center>



@include('admin.partials._modals')


@stop


