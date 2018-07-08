<?php

require_once(base_path().'/resources/views/init.blade.php');


$departments = $oj->departments;
?>

@extends('admin.layout')


@section('content')


<ol class="crumb clearfix">
    <li>教师管理</li>
</ol>


<div>
	<form class="form-inline" action="{{ $cc }}" method="get" >
		{!! csrf_field() !!}
        <div class="form-group">
			<input type="text" placeholder="教师姓名" autocomplete="off" class="form-control" name="keywords" value="{{$oj->search->keywords}}"/>
			<select id="department" name="department" class="form-control">
					<option value="">部门</option>
					@foreach($departments as $v)
					<option value="{{$v->ic}}">{{$v->title}}</option>
					@endforeach
				 </select>	 
		</div>
		<button type="submit" class="btn btn-info">查询</button>
	</form>
</div>

<div class="row page-title-row" >
    <div class=" text-right" >
        <a href="{{ $cc }}/create" class="btn btn-success btn-md" type="button">
            添加教师
        </a>

		<a href="{{ $cc }}_import" class="btn btn-success btn-md" type="button">
            导入教师
        </a>
    </div>	
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="*">姓名</th>
                <th width="10%"> 教师编号</th>
				<th width="20%">所属部门</th>
				<th width="20%">角色</th>
                <th width="20%">操作</th>
            </tr>
        </thead>
  
		@foreach($list as $v)
        <tr>
            <td>{{$v->id}}</td>
            <td>{{$v->realname}}</td>
            <td>{{$v->mycode}}</td>
            <td>{{$v->dname}}</td>
			<td>{{showteacherrole($v->mytype)}}</td>
            <td>
                <a href="teacher/{{$v->id}}/edit" class="btn btn-xs btn-primary">
                    <i class="glyphicon "></i>修改
                </a>

                <a href="{{ $currentcontroller.'/'.$v->id }}" class="btn btn-xs btn-danger glyphicon glyphicon-trash j_del" title="删除" data-title1="姓名" data-title2="{{$v->realname}}" data-title3="教师">
                    删除
                </a>
            </td>
        </tr>
        
		@endforeach
    </table>

	<center>{!! $list->appends(object_to_array($oj->search))->render() !!}</center>

	<script type="text/javascript">
	<!--
		$(document).ready(function(){
			$('#department').val('{{$oj->search->department}}');
		})
	//-->
	</script>

</div>
@include('admin.partials._modals')


@stop


