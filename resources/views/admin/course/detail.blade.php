<?php
require_once(base_path() . '/resources/views/init.blade.php');

/* 课程详情 */
$tab = 'tab_detail';
$courseid = $oj->courseid;

/* 下面注入每个选项卡的操作 */
?>
@section('operate')

@endsection


@extends('admin.layout')


@section('content')
<ol class="crumb clearfix">
    <li>课程管理</li>
    <li> - {{$oj->course->title}}</li>	
</ol>

@include('admin.course.tab')




<div class="toptip clearfix margintop1" >
    <div class="floatleft"><strong>开通状态</strong> &nbsp; <span class="j_open_{{$data->isopen}}">{{openstatus($data->isopen)}}</span>  </div>
</div>


<div class="panel panel-info">
        @include('pub.coursedetail')
</div>


@stop

@section('scripts')

@endsection

