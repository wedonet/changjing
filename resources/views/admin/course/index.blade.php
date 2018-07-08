<?php
/* 课程首页 */
require_once(base_path() . '/resources/views/init.blade.php');

$ActivityIndexIc = $oj->ActivityIndexIc;
?>

@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>课程管理</li>	
</ol>





<div class="row nav1" >
    <div class="col-md-6">

    </div>
    <div class="col-md-6 text-right" >
        <a href="course_export" class="btn btn-success btn-md" type="button">
            导出课程
        </a>

    </div>	
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="10%">名称</th>
                <th width="10%">类型</th>	
                <th width="7%">开课时间</th>
                <th width="10%">上课地点</th>
                <th width="10%">签头部门</th>
                <th width="10%">审核状态</th>

                <th width="15%">操作</th>
            </tr>
        </thead>
        @foreach($list as $v)

        <tr>
            <td>{{$v->id}}</td>
            <td>{{$v->title}}</td>
            <td>{{$v->type_onename}}/{{$v->type_twoname}}</td>
            <td>{{formattime1($v->plantime_one)}}</td> 
            <td>{{$v->myplace}}</td>
            <td>{{typetodepartment($ActivityIndexIc, $v->type_twoic) }}</td>

            <td class="auditstatus_{{$v->auditstatus}}">
                {{checkstatus($v->auditstatus)}}

                @if('unpass'==$v->auditstatus)
                [<a href="{{$currentcontroller .'/'. $v->id . '/reason' }}" class="j_open">原因</a>]
                @endif
            </td> 

            <td>

                <a href="{{$currentcontroller .'/'. $v->id }}" class="btn btn-xs btn-link ">
                    <i class="glyphicon "></i>详情
                </a>

            </td>
        </tr>
        @endforeach
    </table>

	<center>{!! $list->appends(object_to_array($oj->search))->render() !!}</center>
</div>






@include('admin.partials._modals')


@stop


