<?php

require_once(base_path().'/resources/views/init.blade.php');

?>

@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li><a href="huodongleixing">活动类型</a></li>	
	<li> - {{$j['ptype']->title}}</li>
</ol>

<div class="row page-title-row" >
    <div class="col-md-6">
		
    </div>
    <div class="col-md-6 text-right" >
        <a href="{{$currentcontroller.'/create?pic='.$j['ptype']->ic}}" class="btn btn-success btn-md" type="button">
            添加二级类型
        </a>
		      
    </div>

	
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
                <th width="5%">#</th>
				<th width="7%">编码</th>
                <th width="*">类型名称</th>			
				<th width="20%">牵头部门</th>	
				<th width="15%">目标学分</th>	
				<th width="8%">必修</th>
                <th width="20%">操作</th>
            </tr>
        </thead>
   
		@foreach($list as $v)
        <tr>
            <td>{{$v->id}}</td>
			<td>{{$v->ic}}</td>
            <td>{{$v->title}}</td>
			<td>{{$v->qiantouname}}</td>
			<td>{{$v->target}}</td>
			<td>{{showyes($v->ismust)}}</td>
            <td>
                <a href="{{$currentcontroller}}/{{$v->id}}/edit?pic={{$j['ptype']->ic}}" class="" title="">
                    修改
                </a>

				<a href="{{$currentcontroller}}/{{$v->id}}?pic={{$j['ptype']->ic}}" class="j_del hidden" title="删除" data-title1="名称" data-title2="{{$v->title}}" data-title3="类型">
                    删除
                </a>
            </td>
        </tr>
		@endforeach     
	
    </table>
</div>







@include('admin.partials._modals')


@stop


