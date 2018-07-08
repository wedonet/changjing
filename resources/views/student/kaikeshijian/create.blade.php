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

@extends('student.layout')


@section('content')

<ol class="crumb clearfix">
    <li>课程管理</li>
	<li> 添加课程</li>
</ol>





<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">添加课程</div>
    </div>

    <div class="panel-body" >
        <form method="POST" action="{{ $currentcontroller }}" class="form-horizontal  bizerRegister"  role="form">
            {!! csrf_field() !!}


            <div class="form-group">
                <label class="col-md-4 control-label" for="title">课程名称</label>
                <div class="col-md-3">
                    <input type="text" placeholder="名称" required="required" class="form-control" name="title" id="title" value="">
                </div>
                <span class="red">*</span><span>(类型限制:数字、字母和中文，长度不限)</span>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="title">开课学年</label>
                <div class="col-md-3">
                    <select>
						<option>2016-2017学年</option>
						<option>2017-2018学年</option>
					</select>
                </div>
                <span class="red">*</span><span>(类型限制:数字、字母和中文，长度不限)</span>
            </div>

           <div class="form-group">
                <label class="col-md-4 control-label" for="title">一级课程类型</label>
                <div class="col-md-3">
                     <select>
						<option>1级类型名称1</option>
						<option>1级类型名称1</option>
						<option>1级类型名称1</option>
						<option>1级类型名称1</option>
					</select>
                </div>               
            </div>

           <div class="form-group">
                <label class="col-md-4 control-label" for="title">二级课程类型</label>
                <div class="col-md-3">
                     <select>
						<option>2级类型名称1</option>
						<option>2级类型名称1</option>
						<option>2级类型名称1</option>
						<option>2级类型名称1</option>
					</select>
                </div>               
            </div>


           <div class="form-group">
                <label class="col-md-4 control-label" for="title">课程时长</label>
                <div class="col-md-3">
                     <select>
						<option>1学时</option>
						<option>2学时</option>
						<option>3学时</option>
					</select>
                </div>               
            </div>

           <div class="form-group">
                <label class="col-md-4 control-label" for="title">课程开始时间</label>
                <div class="col-md-3">
                     <input type="text" placeholder="名称" required="required" class="form-control" name="title" id="date1" value="">
                </div>               
            </div>
   
                      <div class="form-group">
                <label class="col-md-4 control-label" for="title">课程结束时间</label>
                <div class="col-md-3">
                     <input type="text" placeholder="名称" required="required" class="form-control" name="title" id="date1" value="">
                </div>               
            </div>

           <div class="form-group">
                <label class="col-md-4 control-label" for="title">课程报名开始时间</label>
                <div class="col-md-3">
                     <input type="text" placeholder="名称" required="required" class="form-control" name="title" id="date1" value="">
                </div>               
            </div>
   
                      <div class="form-group">
                <label class="col-md-4 control-label" for="title">课程报名结束时间</label>
                <div class="col-md-3">
                     <input type="text" placeholder="名称" required="required" class="form-control" name="title" id="date1" value="">
                </div>               
            </div>


   

            <div class="form-group">
                <label class="col-md-4 control-label" for="title">开课地点</label>
                <div class="col-md-3">
                     <input type="text" placeholder="名称" required="required" class="form-control" name="title" id="date1" value="">
                </div>               
            </div>


            <div class="form-group">
                <label class="col-md-4 control-label" for="title">课程介绍</label>
                <div class="col-md-3">
				
                     <textarea rows="5" cols="30"></textarea>
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
            $("#date1").on("click",function(e){
                e.stopPropagation();
                $(this).lqdatetimepicker({
                    css : 'datetime-day',
                    dateType : 'D',
                    selectback : function(){

                    }
                });
            });
})
</script>
@endsection