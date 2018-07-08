<?php

require_once(base_path().'/resources/views/init.blade.php');

$data =& $oj->data;


?>


@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>教师管理</li>
	<li> - 修改教师信息</li>
</ol>





<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">编辑教师信息</div>
    </div>

    <div class="panel-body" >
        <form method="POST" action="{{$currentcontroller}}/{{$data->id}}" class="form-horizontal j_form bizerRegister"  role="form">
            {!! csrf_field() !!}
			<input type="hidden" name="_method" value="put">


            <div class="form-group">
                <label class="col-md-4 control-label" for="readme">教师编号</label>
                <div class="col-md-3">
                    <input type="text"  required="required" class="form-control"  name="mycode" value="{{$data->mycode}}" readonly="readonly">
                </div>                
            </div>


            <div class="form-group">
                <label class="col-md-4 control-label" for="title">教师姓名</label>
                <div class="col-md-3">
                    <input type="text"  required="required" class="form-control" name="realname"  value="{{$data->realname}}">
                </div>

            </div>


            <div class="form-group">
                <label class="col-md-4 control-label" for="readme">所属部门</label>
                <div class="col-md-3">
                    <select name="dic" id="dic" class="form-control">
						<option>选择部门</option>
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
                <label class="col-md-4 control-label" for="submit"></label>
                <div class="col-md-3">
                    <input type="submit" class="btn btn-info j_slowsubmit" value=" 提 交 " disabled="disabled" />
                </div>
            </div>


        </form>
    </div>


    <div class="panel-body" >
        <form method="POST" action="{{$currentcontroller .'_savepass'}}" class="form-horizontal j_form bizerRegister"  role="form">
            {!! csrf_field() !!}

			<input type="hidden" name="id" value="{{$data->id}}" />


            <div class="form-group">
                <label class="col-md-4 control-label" for="title">新密码</label>
                <div class="col-md-3">
                    <input type="text" placeholder="" required="required" class="form-control" name="upass" id="title" value="">
                </div>
                
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="title">确定密码</label>
                <div class="col-md-3">
                    <input type="text" placeholder="" required="required" class="form-control" name="upass2" id="title" value="">
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


<script type="text/javascript">
<!--

//-->
</script>
{{--帮助中心--}}
@stop

@section('scripts')
<script>
	$(document).ready(function(){
		$('#dic').val('{{$data->dic}}');

		var mytype = '{{$data->mytype}}';
		if('counsellor' == mytype){
			checkradio('mytype', '1');
		}
		checkradio('mytype', '{{$data->mytype}}');
	})
</script>
@endsection