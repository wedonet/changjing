<?php

require_once(base_path().'/resources/views/init.blade.php');


?>

@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>教师管理</li>
	<li> - {{$oj->mynav}}</li>
</ol>





<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">添加教师</div>
    </div>

    <div class="panel-body" >
        <form method="POST" action="{{ $currentcontroller }}" class="form-horizontal j_form bizerRegister"  role="form">
            {!! csrf_field() !!}


            <div class="form-group">
                <label class="col-md-4 control-label" for="title">姓名</label>
                <div class="col-md-3">
                    <input type="text" placeholder="姓名" required="required" class="form-control" name="realname" id="title" value="">
                </div>               
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="title">教师编号</label>
                <div class="col-md-3">
                    <input type="text" placeholder="编号" required="required" class="form-control" name="mycode" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="readme">所属部门</label>
                <div class="col-md-3">
                    <select name="dic" id="dic" class="form-control">
						<option value="">选择部门</option>
						@foreach($oj->department as $v)

							<option value="{{$v->ic}}">{{$v->title}}</option>
             
						@endforeach
                    </select>
                </div>

            </div>

			<div class="form-group">
                <label class="col-md-4 control-label" for="title">是否辅导员</label>
                <div class="col-md-3">
					<label class="radio-inline"><input type="radio" name="mytype" value="1" /> 是</label>
					<label class="radio-inline"><input type="radio" name="mytype" value="0" checked="checked" /> 否</label>                    
                </div>
            </div>


            <div class="form-group">
                <label class="col-md-4 control-label" for="title">密码</label>
                <div class="col-md-3">
                    <input type="text" placeholder="请输入密码" required="required" class="form-control" name="upass"  value="">
                </div>               
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="title">确认密码</label>
                <div class="col-md-3">
                    <input type="text" placeholder="请再输一次" required="required" class="form-control" name="upass_confirmation" value="">
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