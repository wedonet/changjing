<?php

if( array_key_exists('list', $j) ){
	$list =& $j['list'];
}else {
    $list[] = null;
}


if( array_key_exists('currentcontroller', $j) ){
	$currentcontroller =& $j['currentcontroller'];
}else {
    $currentcontroller = '';
}
?>

@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>活动类型管理</li>
	<li> - 添加活动类型</li>
</ol>





<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">添加活动类型</div>
    </div>

    <div class="panel-body" >
        <form method="POST" action="{{ $currentcontroller }}" class="form-horizontal  bizerRegister"  role="form">
            {!! csrf_field() !!}


            <div class="form-group">
                <label class="col-md-4 control-label" for="title">名称</label>
                <div class="col-md-3">
                    <input type="text" placeholder="名称" required="required" class="form-control" name="title" id="title" value="">
                </div>
                <span class="red">*</span><span>(类型限制:数字、字母和中文，长度不限)</span>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="title">排序</label>
                <div class="col-md-3">
                    <input type="text" placeholder="名称" required="required" class="form-control" name="title" id="title" value="100">
                </div>
                <span class="red">*</span><span>(类型限制:整数)</span>
            </div>

   
            <div class="form-group">
                <label class="col-md-4 control-label" for="title">是否使用</label>
                <div class="col-md-3">
                    <select>
						<option>是</option>
						<option>否</option>
					</select>
                </div>               
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