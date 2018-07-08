<?php

require(base_path().'/resources/views/init.blade.php');

?>

@extends('student.layout')


@section('content')

<ol class="crumb clearfix">
    <li>我的履职修业</li>	
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

                <th>聘职学年</th>
                <th>职务全称</th>
                <th>类型</th>
				<th class="hidden">学分</th>
                <th>聘任部门</th>
	
				<th width="12%">操作</th>
            </tr>
        </thead>
   
		@foreach($list as $v)
        <tr>
            <td>{{$v->id}}</td>

            <td>{{$v->myyear}}</td>
            <td>{{$v->title}}</td>
            <td>{{$v->type_onename.'/'.$v->type_twoname}}</td>
			<td class="hidden">{{$v->mycredit/1000}}</td>
            <td>{{$v->mydname}}</td>

            <td class="tdoperate">
			    <a href="{{$cc.'/'.$v->id}}" class="">
                   详情
                </a>
            </td>
        </tr>
		@endforeach

	
    </table>

	<center>{!! $list->render() !!}</center>
</div>







@include('admin.partials._modals')


@stop


