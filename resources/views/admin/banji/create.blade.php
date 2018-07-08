<?php
/*添加班级*/
require_once(base_path().'/resources/views/init.blade.php');

?>

@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>班级管理</li>
	<li> - 添加班级</li>
</ol>





<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">添加班级</div>
    </div>

    <div class="panel-body" >
        <form method="POST" action="{{ $currentcontroller }}" class="form-horizontal j_form bizerRegister"  role="form">
            {!! csrf_field() !!}


            <div class="form-group">
                <label class="col-md-4 control-label" for="title">班级名称</label>
                <div class="col-md-3">
                    <input type="text" placeholder="名称" required="required" class="form-control" name="title"  value="">
                </div>
                <span class="red">*</span>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="title">班级号</label>
                <div class="col-md-3">
                    <input type="text" placeholder="班级号,提交后不可修改" required="required" class="form-control" name="mycode" id="title" value="">
                </div>
                <span class="red">*</span>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="readme">所属学院</label>
                <div class="col-md-3">
                    <select name="dic"  class="form-control">
                        <option value="">选择所属学院</option>
						@foreach($j['departmentlist'] as $v)
							@if(1==$v->isxueyuan)
							<option value="{{$v->ic}}">{{$v->title}}</option>
							@endif
						@endforeach
                        
                    </select>
                </div>
				<span class="red">*</span>
            </div>
            <div class="form-group hidden">
                <label class="col-md-4 control-label" for="readme">所属系别</label>
                <div class="col-md-3">
                    <select>
                        <option>翻译系</option>
                        <option>英语语言文化与文学系</option>
                        <option>英语国际商务系</option>
                        <option>英语传媒系</option>

                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="readme">负责教师工号</label>
                <div class="col-md-3">
                    <input type="text" placeholder="负责教师" required="required" class="form-control" id="readme" name="masteric" value="">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="readme">负责教师姓名</label>
                <div class="col-md-3">
                    <input type="text" placeholder="负责教师" required="required" class="form-control" id="readme" name="mastername" value="" />
                </div>
            </div>

			<div class="form-group">
                <label class="col-md-4 control-label" for="readme">排序</label>
                <div class="col-md-3">
                    <input type="text" placeholder="负责教师" required="required" class="form-control" name="cls" value="100" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="readme">班级说明</label>
                <div class="col-md-3">
					<textarea name="readme" rows="4" class="form-control"></textarea>                   
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