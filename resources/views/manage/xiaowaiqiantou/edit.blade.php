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

$data =& $j['data'];
?>


@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>部门管理</li>
</ol>




<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">编辑部门</div>
    </div>

    <div class="panel-body" >
        <form method="POST" action="{{ $currentcontroller . '/' . $data->id }}" class="form-horizontal j_form bizerRegister"  role="form">
            {!! csrf_field() !!}
			<input type="hidden" name="_method" value="put">



            <div class="form-group">
                <label class="col-md-4 control-label" for="title">部门名称</label>
                <div class="col-md-3">
                    <input type="text" placeholder="名称" required="required" class="form-control" name="title" id="title" value="{{ $data->title }}">
                </div>
                <span class="red">*</span><span>(类型限制:数字、字母和中文，长度不限)</span>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="readme">部门说明</label>
                <div class="col-md-3">
                    <input type="text" placeholder="说明" required="required" class="form-control" id="readme" name="readme" value="{{ $data->readme }}">
                </div>
                
            </div>


            <div class="form-group">
                <label class="col-md-4 control-label" for="name">排序( 数字 )</label>
                <div class="col-md-3">
                    <input type="text" placeholder="数字" required="required" class="numSort form-control" name="cls" value="{{ $data->cls }}" />
                </div>
                <span class="red">*</span><span>(大于0的整数)</span>
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


<script type="text/javascript">
<!--

//-->
</script>
{{--帮助中心--}}
@stop

@section('scripts')
<script>

</script>
@endsection