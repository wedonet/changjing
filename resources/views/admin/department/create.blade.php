<?php

require_once(base_path().'/resources/views/init.blade.php');


if($j['isedit']){
	$date = $j['data'];
}else{
	$date = null;
}


?>

@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>部门管理</li>
    <li> - {{$j['mynav']}}</li>
</ol>




<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">{{$j['mynav']}}</div>
    </div>

    <div class="panel-body" >
        <form method="POST" action="{{ $j['action'] }}" class="form-horizontal j_form"  role="form">
			{!! csrf_field() !!}
			@if($j['isedit'])
			<input type="hidden" name="_method" value="put" />
			@endif
			
            <div class="form-group">
                <label class="col-md-4 control-label" for="title">部门名称</label>
                <div class="col-md-3">
                    <input type="text" placeholder="名称" required="required" class="form-control" name="title" id="j_title" value="{{$data->title or ''}}">
                </div>
                
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">部门编号</label>
                <div class="col-md-3">
                    <input type="text" placeholder="编号" required="required" class="form-control" name="ic" id="ic" value="{{$data->ic or ''}}">
                </div>
				<div class="col-md-3 gray">添加后禁止修改</div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="readme">部门类型</label>
                <div class="col-md-3">
                    <select name="mytype" id="mytype" class="form-control">
                        <option>选择部门类型</option>
                        <option value="zhineng">职能部门</option>
                        <option value="yewu">业务部门</option>
                    </select>
                </div>				
            </div>

			<div class="form-group">
                <label class="col-md-4 control-label" for="readme">排序</label>
                <div class="col-md-3">
                    <input type="text" placeholder="" class="form-control" id="readme" name="cls" value="{{$data->cls or 100}}" />
                </div>
            </div>






            <div class="form-group j_zhineng hidden">
                <label class="col-md-4 control-label" for="readme">发起人用户名</label>
                <div class="col-md-3">
                    <input type="text" placeholder="" class="form-control"  name="userfq" id="userfq" value="{{$data->userfq or ''}}" />
                </div>  
				
            </div>

			<div class="form-group j_zhineng hidden">
                <label class="col-md-4 control-label" for="readme">发起人密码</label>
                <div class="col-md-3">
                    <input type="text" placeholder="" class="form-control" name="passfq" value="{{$data->passfq or '123456'}}" />
                </div>                
            </div>

            <div class="form-group j_zhineng hidden" >
                <label class="col-md-4 control-label" for="readme">审核人用户名</label>
                <div class="col-md-3">
                    <input type="text" placeholder="" class="form-control"  name="usersh" id="usersh" value="{{$data->usersh or ''}}" />
                </div>                
				
            </div>
            <div class="form-group j_zhineng hidden" >
                <label class="col-md-4 control-label" for="readme">审核人密码</label>
                <div class="col-md-3">
                    <input type="text" placeholder="" class="form-control" name="passsh" value="{{$data->usersh or '123456'}}" />
                </div> 
            </div>





            <div class="form-group j_yewu hidden">
                <label class="col-md-4 control-label" for="readme">是否是学院</label>
                <div class="col-md-3">
                    <select name="isxueyuan" id="isxueyuan" class="form-control">
                        <option>选择是否学院</option>
                        <option value="1">是</option>
                        <option value="0">否</option>
                    </select>
                </div>
			
            </div>


            <div class="form-group">
                <label class="col-md-4 control-label" for="submit"></label>
                <div class="col-md-3">
                    <input type="submit" name="submit" class="btn btn-info j_slowsubmit" value=" 提 交 " disabled="disabled" />
                </div>
            </div>


        </form>
    </div>
</div>

@stop

@section('scripts')
<script>
$(document).ready(function(){
	$('#ic').on('change', function(){
		var name = $(this).val();
		$('#userfq').val(name + '_fq');
		$('#usersh').val(name + '_sh');
	})


	/*跟据部门类型显示不同输入框*/
	$('#mytype').on('change', function(){
		if( 'zhineng' == $(this).val() ) {
		
			$('.j_zhineng').removeClass('hidden');
			$('.j_yewu').addClass('hidden');

			$('#isxueyuan').val('0');
		}else if( 'yewu' == $(this).val() ){
	
			$('.j_zhineng').addClass('hidden');
			$('.j_yewu').removeClass('hidden');
		}
	})


	{{--编辑时的功能--}}
	//编辑
	@if($j['isedit'])
		$('#mytype').val('{{$data->mytype}}');
		$('#isxueyuan').val('{{$data->isxueyuan}}');

		if( 'zhineng' == '{{$data->mytype}}' ){

			$('.j_yewu').addClass('hidden');
		}	

		if( 'yewu' == '{{$data->mytype}}' ){

			$('.j_yewu').removeClass('hidden');
		}	

		$('#mytype').attr('disabled', 'disabled');

		/*编辑时禁止修改部门编号*/
		$('#ic').attr('readonly', 'readonly');
		
	@endif
	
})
</script>
@endsection