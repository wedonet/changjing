<?php

require(base_path().'/resources/views/init.blade.php');


?>

@extends('manage.layout')


@section('content')

<ol class="crumb clearfix">
    <li>校外荣誉审核</li>	
</ol>

<div class="row page-title-row" >
    <div class="col-md-6">
		
    </div>
    <div class="col-md-6 text-right" >        
    </div>	
</div>

<div class="table-responsive">
    
<table class="table table-striped table-hover" id="j_list" >
        <thead>
        <tr>

            <th width="5%">#</th>
            <th>荣誉名称</th>
            <th>类型</th>
            <th>牵头部门</th>     
			<th width="10%">辅导员审核</th>
            <th width="10%">牵头部门审核</th>
			<th>申请时间</th>
            <th width="15%">操作</th>
        </tr>
        </thead>

		@foreach($list as $v)
        <tr>
            <td>{{$v->id}}</td>
            <td>{{$v->title}}</td>
            <td>{{$v->type_onename.'/'.$v->type_twoname}}</td>
            <td>{{$v->dname}}</td>
            <td class="j_pass_{{$v->isok1}}">{{checkstatus($v->isok1)}}</td>
            <td class="j_pass_{{$v->isok2}}">{{checkstatus($v->isok2)}}</td>
    
			<td>{{$v->created_at}}</td>
       
            <td class="tdoperate">
				<a href="{{$cc}}/{{$v->id}}" title="">
				 详情&amp;管理
				</a>				
            </td>
        </tr>
		@endforeach
    </table>

	<center>{!! $list->render() !!}</center>
</div>







@include('admin.partials._modals')


@stop


