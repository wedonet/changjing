<?php

require_once(base_path().'/resources/views/init.blade.php');

if($oj->isedit){
	$date = $oj->data;
}else{
	$date = null;
}


$activity_type =  json_encode($oj->activity_type, true) ;


?>

@extends('manage.layout')


@section('content')

<ol class="crumb clearfix">
    <li>课程管理</li>
	<li> - {{$oj->mynav}}</li>
</ol>





<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">{{$oj->mynav}}</div>
    </div>

    <div class="panel-body" >
        <form method="post" action="{{ $oj->action }}" class="form-horizontal j_form">
            {!! csrf_field() !!}
			@if($oj->isedit)
			<input type="hidden" name="_method" value="put">
			@endif

            <div class="form-group">
                <label class="col-md-4 control-label">名称</label>
                <div class="col-md-3">
                    <input type="text" placeholder="名称" required="required" class="form-control" name="title"  value="{{$data->title or ''}}">
                </div>                
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" >课程学年</label>
                <div class="col-md-3">
                    <select name="activity_year" id="activity_year" class="form-control">
							<option value="">选择学年</option>
						@for($i=2016; $i<2028; $i++)
							<option value="{{$i}}-{{$i+1}} 学年 第一学期">{{$i}}-{{$i+1}}学年 第一学期</option>	
							<option value="{{$i}}-{{$i+1}} 学年 第二学期"">{{$i}}-{{$i+1}}学年 第二学期</option>
						@endfor
					</select>
                </div>                
            </div>

            <div class="form-group hidden">
                <label class="col-md-4 control-label" >课程类型</label>
                <div class="col-md-3">
                    <input type="text" placeholder="课程类型" required="required" class="form-control" name="typeic"  value="无">
                </div>
            </div>
           <div class="form-group">
                <label class="col-md-4 control-label" >一级课程类型</label>
                <div class="col-md-3">
                     <select name="type_oneic" id="type_oneic" class="form-control">
						<option value="">选择一级类型</option>
						@foreach($oj->activity_type as $v)
						@if(0 == $v->mydepth)
						<option value="{{$v->ic}}">{{$v->title}}</option>
						@endif
						@endforeach
					</select>
                </div>               
            </div>

           <div class="form-group">
                <label class="col-md-4 control-label" >二级课程类型</label>
                <div class="col-md-3">
                     <select name="type_twoic" id="type_twoic" class="form-control">
						
								
					</select>
                </div>               
            </div>

            <div class="form-group hidden">
                <label class="col-md-4 control-label">牵头部门</label>
                <div class="col-md-3">
                    <select name="department" class="form-control">
                        <option  value="1">学生处</option>
                        <option  value="2">校团委</option>
                        <option  value="3">思政处</option>
                        <option  value="4">思政处</option>
                        <option  value="5">宣传部</option>
                        <option  value="6">各大院系</option>

                    </select>
                </div>
                <span class="red">*</span><span></span>
            </div>
            <div class="form-group hidden">
                <label class="col-md-4 control-label" >课程级别</label>
                <div class="col-md-3">
                    <select name="mylevel" id="mylevel" class="form-control">
                        <option value="">选择课程级别</option>
                        <option value="school">校级</option>
                        <option value="college">院级</option>

                    </select>
                </div>
            </div>

            <div class="form-group hidden">
                <label class="col-md-4 control-label" >课程时长</label>
                <div class="col-md-3">
                    <select name="mytimelong" id="mytimelong" class="form-control">
                        <option value="">选择课程时长</option>
                        <option value="2">2学时</option>
                        <option value="4">4学时</option>
                        <option value="6">6学时</option>
                        <option value="8">8学时</option>
                        <option value="16">16学时</option>
                        <option value="32">32学时</option>
                        <option value="64">64学时</option>
                    </select>
                </div>
                <span id="j_xuefen" class="text-warning"></span>
            </div>
            <div class="form-group hidden">
                <label class="col-md-4 control-label" >课程学分</label>
                <div class="col-md-3">
                    <select name="mycredit" id="mycredit"  class="form-control">
                        <option>1/8学分</option>
                        <option>1/4学分</option>
                        <option>3/8学分</option>
                        <option>1/2学分</option>
                        <option>1学分</option>
                        <option>2学分</option>
                        <option>4学分</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" >课程开始时间</label>
                <div class="col-md-3">
                    <div class="input-group ">
						<input type="text"  class="form-control datepicker" name="plantime_one"
							value="{{ isset($data) ? formattime2($data->plantime_one) : '' }}" required="required">
						<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <label class="col-md-4 control-label" >课程结束时间</label>
                <div class="col-md-3">
                    <div class="input-group ">
						<input type="text"  class="form-control datepicker" name="plantime_two"
							value="{{ isset($data) ? formattime2($data->plantime_two) : '' }}" required="required">
						<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <label class="col-md-4 control-label" >课程报名开始时间</label>
                <div class="col-md-3">
                    <div class="input-group ">
						<input type="text" class="form-control datepicker" name="signuptime_one" 
							value="{{ isset($data) ? formattime2($data->signuptime_one) : '' }}"  required="required">
						<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" >课程报名结束时间</label>
                <div class="col-md-3">
                    <div class="input-group ">
						<input type="text" class="form-control datepicker" name="signuptime_two" 
							value="{{ isset($data) ? formattime2($data->signuptime_two) : '' }}" required="required">
						<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">开课地点</label>
                <div class="col-md-3">
                     <input type="text" placeholder="开课地点" required="required" class="form-control" name="myplace"  value="{{$data->myplace or ''}}">
                </div>               
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">报名方式</label>
                <div class="col-md-3">
				    <label class="radio-inline">
						<input type="radio" name="mywayic" id="j_myvwayic_direct" value="direct" /> 直接报名 &nbsp;
					</label>
					<label class="radio-inline">
						<input type="radio" name="mywayic" id="j_myvwayic_audit" value="audit" /> 审核报名    
					</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">人数限制</label>
                <div class="col-md-3">
                    <input type="text" name="signlimit" value="{{$data->signlimit or ''}}" /> 人 
                </div>
            </div>
           
            <div class="form-group ">
                <label class="col-md-4 control-label" >是否需要提交作业</label>
                <div class="col-md-3 ">
                    <label class="radio-inline">
						<input type="radio" name="homework" id="j_homework_y" value="1" /> 是 &nbsp;
					</label>
					<label class="radio-inline">
						<input type="radio" name="homework" id="j_homework_n" value="0" /> 否    
					</label>
				</div>					
			</div>

            <div class="form-group hidden" id="j_divhomework">
                <label class="col-md-4 control-label" >提交作业时间段</label>
                <div class="col-md-7">
					<div class="col-md-4" style="padding-left:0">
						<input type="text" readonly id="d4311" class="startdata form-control datepicker" size="6"  name="homeworktime_one"			
							value="{{ isset($data) ? formattime2($data->homeworktime_one) : '' }}" placeholder="开始日期"/> 
					</div>

					<div class="col-md-1">至</div>
					<div class="col-md-4">
						<input type="text" readonly id="d4312" class="enddata form-control datepicker" name="homeworktime_two"
							value="{{ isset($data) ? formattime2($data->homeworktime_two) : '' }}" placeholder="结束日期"/>
					</div>
				
                </div>               
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">主办单位</label>
                <div class="col-md-3">
                    <input type="text" placeholder="主办单位" required="required" class="form-control" name="sponsor" id="date1" value="{{$data->sponsor or ''}}">
                </div>
            </div>
            <div class="form-group hidden">
                <label class="col-md-4 control-label">主办单位类型</label>
                <div class="col-md-3">
                    <input type="text" placeholder="主办单位类型" class="form-control" name="sponsortype" id="date1" value="{{$data->sponsortype or ''}}">
                </div>
            </div>


            <div class="form-group">
                <label class="col-md-4 control-label" >备注</label>
                <div class="col-md-3">

                    <textarea name="other" rows="5" class="form-control" cols="30">{{$data->other or ''}}</textarea>
                </div>
            </div>

           <div class="form-group">
                <label class="col-md-4 control-label" id="date1" >附件路径</label>
                <div class="col-md-3">				
					<input type="text" class="form-control" id="originname" name="originname" value="{{$data->originname or ''}}" /> 
                    <input type="hidden" class="form-control" id="attachmentsurl" name="attachmentsurl" value="{{$data->attachmentsurl or ''}}"   /> 
                </div>   
				

				<div class="col-md-4">				
					<input type="file" id="attachupload" name="attachupload" class="pull-left"  style="width:200px;"/>
					<span id="uploadstatus_file1"></span>
                </div>  
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" id="date1" >预览图</label>
                <div class="col-md-3">				
                    <input type="text" class="form-control" id="preimg" name="preimg" value="{{$data->preimg or ''}}"  /> 
                </div>   
				

				<div class="col-md-4">				
					<input type="file" id="preimgupload" name="preimgupload" class="pull-left"  style="width:200px;"/>
					<span id="uploadstatus_preimgupload"></span>
                </div>  
            </div>

			<div class="form-group">
                <label class="col-md-4 control-label" >简介</label>
                <div class="col-md-3">
                
                     <textarea name="readme" rows="5" class="form-control" cols="30">{{$data->readme or ''}}</textarea>
                </div>               
            </div>

			<div class="form-group">
                <label class="col-md-4 control-label" >联系人姓名</label>
                <div class="col-md-3">
					<input type="text" name="conname" class="form-control" value="{{$data->conname or ''}}" />                     
                </div>               
            </div>

			<div class="form-group">
                <label class="col-md-4 control-label" >联系电话</label>
                <div class="col-md-3">
					<input type="text" name="contel" class="form-control"  value="{{$data->contel or '' }}" />
                     
                </div>               
            </div>
			<div class="form-group">
				<div><strong>课程详情 ↓↓</strong></div>				
                <textarea name="content" id="content" class="form-control"  rows="5" cols="30">{!! $data->content or '' !!}</textarea>              
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="submit"> </label>
                <div class="col-md-3">
                    <input type="submit" class="btn btn-info j_slowsubmit" value=" 提 交 "  />
                </div>
            </div>


        </form>
    </div>
</div>

@stop

@section('scripts')
<script>

/*get课程类型，用于二级类型联动*/
var activity_type = eval(eval({!! $activity_type !!}));


$(function(){
	//removereq();	

	wedoneteditor('content', 2, '');

	/*日期时间选择*/
	$('.datepicker').datetimepicker({
		language:  'zh-CN',
		autoclose: true,
		minuteStep:30,
		format: 'yyyy-mm-dd hh:ii'
	});


	$('#j_zhijiebaoming').on('click', function(){
		$('#j_xianzhi').attr("disabled",true);
	});


	$('#j_shenhebaoming').on('click', function(){
		$('#j_xianzhi').removeAttr('disabled');
	});


	/*if有一级课程类型 then初始化二级课程类型*/
	if('' != $('#type_oneic').val()){
		addoption($('#type_oneic').val(), activity_type);
	}
	

	/*二级课程类型联动*/
	$('#type_oneic').on('change', function(){
		var one_ic = $(this).val();
		var optionlist = '<option value="">选择二级类型</option>';
		
		for(var o in activity_type){
			if( activity_type[o].pic == one_ic ){
				optionlist += ('<option value="'+activity_type[o].ic+'">'+activity_type[o].title+'</option>');
			}
		}

		$('#type_twoic').empty().append(optionlist);
	});




	/*学时变学分提示*/
	$('#mylevel').on('change', function(){
		makexuefen('mylevel', 'mytimelong');
	})

	$('#mytimelong').on('change', function(){
		makexuefen('mylevel', 'mytimelong');

	})






	/*提交作业时间段*/
	if($('#j_homework_y').is(':checked')){
		$('#j_divhomework').removeClass('hidden');
	}
	$('#j_homework_y').on('click', function(){		
		$('#j_divhomework').removeClass('hidden');
	});
	$('#j_homework_n').on('click', function(){		
		$('#j_divhomework').addClass('hidden');
	});

	/*报名时间联动*/
	//if($('#j_myvwayic_direct').is(':checked')){
	//	$('#j_divsignlimit').removeClass('hidden');
	//}
	//$('#j_myvwayic_direct').on('click', function(){		
	//	$('#j_divsignlimit').removeClass('hidden');
	//});
	$('#j_myvwayic_audit').on('click', function(){		
		$('#j_divsignlimit').addClass('hidden');
	});

	/*file输入框选择文件后的处理*/
	//$('#file1').on('change', function(){
	//	ajaxFileUpload('attachmentsurl', 'upload', 'originname');
	//})

	/*file输入框选择文件后的处理*/
	myupload('preimgupload', 'preimgname', 'preimg');
	myupload('attachupload', 'originname', 'attachmentsurl');




	@if($oj->isedit)

		/*学年*/
		$('#activity_year').val('{{$data->activity_year}}');

		/*一级课程类型*/
		$('#type_oneic').val('{{$data->type_oneic}}');


		/*二级课程类型*/		
		var one_ic = '{{$data->type_oneic}}';
		var optionlist = '<option value="">选择二级类型</option>';
		
		for(var o in activity_type){
			if( activity_type[o].pic == one_ic ){
				optionlist += ('<option value="'+activity_type[o].ic+'">'+activity_type[o].title+'</option>');
			}
		}

		$('#type_twoic').empty().append(optionlist);

		$('#type_twoic').val('{{$data->type_twoic}}');

		/*课程级别*/
		$('#mylevel').val('{{$data->mylevel}}');

		/*课程时长*/
		$('#mytimelong').val('{{$data->mytimelong}}');

		/*单选按钮*/
		checkradio('homework', '{{$data->homework}}');
		checkradio('mywayic', '{{$data->mywayic}}');

		/*有作业时，显示修业时间段*/
		//alert( $('#j_homework_y').attr('checked') );
		if( $('#j_homework_y').attr('checked') ){
			$('#j_divhomework').removeClass('hidden');
		}
	@endif
})
 






function addoption(ic, json){
	var optionlist = '<option value="">选择二级类型</option>';
	
	for(var o in json){
		if( json[o].pic == ic ){
			optionlist += ('<option value="'+json[o].ic+'">'+json[o].title+'</option>');
		}
	}

	$('#type_twoic').empty().append(optionlist);
}
       

function makexuefen(mylevel, mytimelong){
	var mylevel = $('#' + mylevel).val();			
	var mytimelong = $('#' + mytimelong).val();


	if('' == mylevel | '' == mytimelong ){
		return;
	}
		
	
		
	myxuefen = mytimelong *1000 / 16;

	if('school' != mylevel){
		myxuefen = myxuefen * ({{$_ENV['Xuefenxiaoji']}}*1)/1000;
	}else{
		myxuefen = myxuefen / 1000;
	}
		
	myxuefen += '学分';
		
	$('#j_xuefen').text(myxuefen);
}


</script>
@endsection