<?php

require_once(base_path().'/resources/views/init.blade.php');

?>

@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>活动类型</li>
	<li> - 添加类型</li>
</ol>





<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">添加类型</div>
    </div>

    <div class="panel-body" >
        <form method="post" action="{{ $currentcontroller }}" class="form-horizontal j_form" role="form">
            {!! csrf_field() !!}


            <div class="form-group">
                <label class="col-md-4 control-label" for="title">名称</label>
                <div class="col-md-3">
                    <input type="text" placeholder="类型名称" required="required" class="form-control" name="title" value="">
                </div>
                <span class="red">*</span>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="title">说明</label>
                <div class="col-md-3">
                    <input type="text" placeholder="类型说明" required="required" class="form-control" name="readme" value="">
                </div>
                <span class="red">*</span>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="title">排序</label>
                <div class="col-md-3">
                    <input type="text" required="required" class="form-control" name="cls" value="100">
                </div>
                <span class="red">*</span>
            </div>


            <div class="form-group">
                <label class="col-md-4 control-label" for="submit"></label>
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

</script>
@endsection