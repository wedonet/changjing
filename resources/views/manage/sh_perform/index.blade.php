<?php

require(base_path().'/resources/views/init.blade.php');

?>

@extends('manage.layout')


@section('content')

<ol class="crumb clearfix">
    <li>履职修业审核</li>	
</ol>


<div class="row page-title-row" >
    <div class="col-md-6">
		
    </div>
    <div class="col-md-6 text-right" >
		{{--辅导员，团委，牵头部门可添加--}}

        <a href="{{ $cc }}/select_" class="btn btn-success btn-md hidden" type="button">
            添加
        </a>		     

    </div>	
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
                <th width="5%">#</th>
                <th>学号</th>
                <th>姓名</th>
                <th>聘职学年</th>
                <th>职务全称</th>
                <th>类型</th>
				<th>学分</th>
                <th>聘任部门</th>
				<th>状态</th>
				<th width="12%">操作</th>
            </tr>
        </thead>
   
		@foreach($list as $v)
        <tr>
            <td>{{$v->id}}</td>
            <td>{{$v->ucode}}</td>
            <td>{{$v->realname}}</td>
            <td>{{$v->myyear}}</td>
            <td>{{$v->title}}</td>
            <td>{{$v->type_onename.'/'.$v->type_twoname}}</td>
			<td>{{$v->mycredit/1000}}</td>
            <td>{{$v->mydname}}</td>
			<td class="j_pass_{{$v->isok}}">{{checkstatus($v->isok)}}</td>
            <td class="tdoperate">
			    <a href="{{$cc.'/'.$v->id}}" class="">
                   详情&amp;审核
                </a>

			    <a href="{{$cc.'/'.$v->id.'/edit'}}" class="">
                    修改
                </a>


            </td>
        </tr>
		@endforeach

	
    </table>

	<center>{!! $list->render() !!}</center>
</div>







@include('admin.partials._modals')


@stop


