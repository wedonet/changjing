<?php
/* 课时 */
require_once(base_path() . '/resources/views/init.blade.php');

$oj->courseid = $oj->course->id;
?>

@extends('manage.layout')


@section('content')

<ol class="crumb clearfix">
    <li><a href="/manage/course">课程管理</a></li>	
    <li> - {{$oj->course->title}}</li>	
    <li> - 课时</li>
</ol>

<div class="row page-title-row" >
    <div class="col-md-6">

    </div>
    <div class="col-md-6 text-right" >
        <a href="{{$cc}}/create?courseid={{$oj->courseid}}" class="btn btn-success btn-md" type="button">
            添加课时
        </a>

    </div>


</div>

<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="12%"></th>
                <th width="30%">时间</th>
                <th width="*">地点</th>
                <th width="15%">操作</th>
            </tr>
        </thead>


        @foreach($list as $v)
        <tr>
            <td>{{$v->id}}</td>
            <td>第{{$loop->index+1}}课</td>
            <td>{{formattime2($v->start_time) . ' 至 ' . formattime2($v->finish_time)}}</td> 
            <td>{{$v->myplace}}</td> 			
            <td>

                <a href="{{$cc . '/' . $v->id . '/edit?courseid=' . $oj->courseid}}" class="btn btn-xs btn-primary" title="">
                    编辑
                </a>			

                <a href="{{$cc . '/' . $v->id . '?courseid=' . $oj->courseid}}" class="btn btn-xs btn-danger glyphicon glyphicon-trash j_del" title="删除第{{$loop->index+1}}课" data-title1="名称" data-title2="第{{$loop->index+1}}课" data-title3="课时">
                    删除
                </a>

            </td>
        </tr>

        @endforeach


    </table>
</div>







@include('admin.partials._modals')


@stop


