<?php
require_once(base_path() . '/resources/views/init.blade.php');

/* 课程详情 */
$tab = 'tab_detail';
$courseid = $oj->courseid;

/* 下面注入每个选项卡的操作 */
?>
@section('operate')

@endsection


@extends('manage.layout')


@section('content')
<ol class="crumb clearfix">
    <li><a href="/manage/course">课程管理</a></li>
    <li> - {{$oj->course->title}}</li>	
</ol>

@include('manage.course.tab')




<div class="toptip clearfix margintop1" >
    <div class="floatleft"><strong>开通状态</strong> &nbsp; <span class="j_open_{{$data->isopen}}">{{openstatus($data->isopen)}}</span>  </div>
</div>


<div class="panel panel-info">
    <div class="panel-body" >
        @include('pub.coursedetail')


    </div>
</div>


@stop

@section('scripts')

@endsection

