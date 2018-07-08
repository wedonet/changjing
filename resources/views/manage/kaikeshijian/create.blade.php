<?php
require_once(base_path() . '/resources/views/init.blade.php');

$oj->courseid = $oj->course->id; 

if ($oj->isedit) {
    $action = $cc . '/' . $data->id . '?courseid=' . $oj->courseid;
} else {
    $action = $cc . '?courseid=' . $oj->courseid;
}
?>

@extends('manage.layout')


@section('content')

<ol class="crumb clearfix">
    <li>课程管理</li>
    <li> - {{$oj->course->title}}</li>
    <li> - {{$oj->mynav}}</li>
</ol>




<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">{{$oj->mynav}}</div>
    </div>

    <div class="panel-body" >
        <form method="post" action="{{ $action }}" class="form-horizontal  j_form"  role="form">
            {!! csrf_field() !!}

            @if($oj->isedit)
            <input type="hidden" name="_method" value="put">
            @endif

            <div class="form-group">
                <label class="col-md-4 control-label" for="title">开始时间</label>
                <div class="col-md-3">
                    <input type="text"  required="required" class="form-control datepicker" name="start_time" value="{{ isset($data) ? formattime2($data->start_time) : '' }}">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="title">结束时间</label>
                <div class="col-md-3">
                    <input type="text"  required="required" class="form-control datepicker" name="finish_time" value="{{ isset($data) ? formattime2($data->finish_time) : '' }}">
                </div>
            </div>


            <div class="form-group">
                <label class="col-md-4 control-label" for="title">地点</label>
                <div class="col-md-6">
                    <input type="text" placeholder="地点" required="required" class="form-control" name="myplace" value="{{ isset($data) ? ($data->myplace) : '' }}">
                </div>               
            </div>


            <div class="form-group">
                <label class="col-md-4 control-label" for="submit"> </label>
                <div class="col-md-3">
                    <input type="submit" class="btn btn-info j_slowsubmit" value=" 提 交 " disabled="disabled" />
                </div>
            </div>


        </form>
    </div>
</div>

@stop

@section('scripts')
<script>
    $(function () {
        /*日期时间选择*/
        $('.datepicker').datetimepicker({
            language: 'zh-CN',
            autoclose: true,
            minuteStep: 30,
            format: 'yyyy-mm-dd hh:ii'
        });
    })
</script>
@endsection