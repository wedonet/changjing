<?php

require_once(base_path().'/resources/views/init.blade.php');

?>

@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>活动类型</li>	
</ol>

<div class="row page-title-row text-right" >
	<a href="{{ $currentcontroller }}/create" class="btn btn-success btn-md disabled" type="button">
		添加活动类型
	</a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
                <th width="5%">#</th>
				<th width="7%">编码</th>
                <th width="20%">名称</th>		
				<th width="*">说明</th>
				<th width="7%">排序</th>
                <th width="20%">操作</th>
            </tr>
        </thead>
   
		@foreach($list as $v)
        <tr>
            <td>{{$v->id}}</td>
			<td>{{$v->ic}}</td>
            <td>{{$v->title}}</td>
			<td>{{$v->readme}}</td>
			<td>{{$v->cls}}</td>
            <td>
			    <a href="huodongleixing_2?pic={{$v->ic}}" class="btn btn-xs btn-link ">
                    二级类型
                </a>
                <a href="{{$currentcontroller}}/{{$v->id}}/edit" class="" title="">
                    修改
                </a>

				<a href="{{$currentcontroller}}/{{$v->id}}" class="j_del hidden" title="删除" data-title1="名称" data-title2="{{$v->title}}" data-title3="类型">
                    删除
                </a>
            </td>
        </tr>
       @endforeach
    </table>
</div>







@include('admin.partials._modals')


@stop


