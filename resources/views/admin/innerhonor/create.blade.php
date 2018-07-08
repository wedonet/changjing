<?php

require(base_path().'/resources/views/init.blade.php');


$activity_type =  json_encode($oj->activity_type, true) ;
$departlistindexic =  json_encode($oj->departlistindexic, true) ;

$xueyuanlist = $oj->xueyuanlist;

?>

@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>校内荣誉管理</li>
	<li> - 申请</li>
</ol>





<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">申请校内荣誉</div>
    </div>

    <div class="panel-body" >
        <form method="post" action="{{$oj->action}}" class="form-horizontal j_form"  role="form">
            {!! csrf_field() !!}

            @if($oj->isedit)
            <input type="hidden" name="_method" value="put">
            @endif

            <div class="form-group">
                <label class="col-md-4 control-label" for="title">荣誉名称</label>
                <div class="col-md-3">
                    <input type="text" placeholder="荣誉名称" required="required" class="form-control" name="title"  value="{{$data->title Or ''}}">
                </div>              
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="title">奖励单位</label>
                <div class="col-md-3">
                    <input type="text" placeholder="奖励单位" required="required" class="form-control" name="sponsor"  value="{{$data->sponsor Or ''}}">
                </div>  
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">奖励日期</label>
                <div class="col-md-3">
                    <div class="input-group ">
                        <input type="text" placeholder="奖励日期" required="required" class="form-control datepicker" name="mydate"  value="{{isset($data) ? formattime1($data->mydate) : ''}}">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                    </div>
                </div>               
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="title">奖励金额</label>
                <div class="col-md-3">
                    <input type="text" placeholder="奖励金额" required="required" class="form-control" name="myvalue"  value="{{$data->myvalue Or ''}}"> 
                </div>   
				<div class="col-md-3">
                     元
                </div>  
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">奖励说明</label>
                <div class="col-md-8">
                    <textarea name="readme" required="required" rows="4" class="form-control" cols="30">{{$data->readme or ''}}</textarea>
                </div>             
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" id="date1" >支撑材料</label>
                <div class="col-md-3">				
                    <input type="text" class="form-control" id="originname" name="originname" value="{{$data->originname or ''}}" readonly="readonly" /> 
                    <input type="hidden" class="form-control" id="attachmentsurl" name="attachmentsurl" value="{{$data->attachmentsurl or ''}}"  readonly="readonly" /> 
                </div>   


                <div class="col-md-4">				
                    <input type="file" id="attachupload" name="attachupload" class="pull-left"  style="width:200px;"/>
                    <span id="uploadstatus_file1"></span>
                </div>  
            </div>


            <div class="form-group">
                <label class="col-md-4 control-label" >申请学分</label>
                <div class="col-md-3">
					 <input type="text" placeholder="1位小数" required="required" class="form-control" name="mycredit"  value="{{isset($data->mycredit) ? $data->mycredit/1000 : ''}}"> 
                </div>
				<div class="col-md-3">
                     学分
                </div>  
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" >所在学院</label>
                <div class="col-md-3">
                    <select name="dic" id="dic" class="form-control">
                        <option value="">选择所在学院</option>
                        @foreach($xueyuanlist as $v)                       
                        <option value="{{$v->ic}}">{{$v->title}}</option>                       
                        @endforeach
                    </select>
                </div>               
            </div>


            <div class="form-group">
                <label class="col-md-4 control-label" >一级活动类型</label>
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
                <label class="col-md-4 control-label" >二级活动类型</label>
                <div class="col-md-3">
                    <select name="type_twoic" id="type_twoic" class="form-control">
                    </select>

                </div>               
				<div class="col-md-3" id="leaddepartment"></div>
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
					<input type="text" name="contel" class="form-control" value="{{$data->contel or ''}}" />
                     
                </div>               
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="submit"> </label>
                <div class="col-md-3">
                    <input type="submit" class="btn btn-info j_slowsubmit" value=" 保 存 " disabled="disabled" />
                </div>
            </div>
        </form>
    </div>
</div>

@stop

@section('scripts')
<script>
    var activity_type = eval(eval({!! $activity_type !!}));
	var departlistindexic = eval(eval({!! $departlistindexic !!}));

	$(function () {
		myupload('attachupload', 'originname', 'attachmentsurl');

		/*日期时间选择*/
		$('.datepicker').datetimepicker({
			language: 'zh-CN',
			autoclose: true,
			minView:2,
			format: 'yyyy-mm-dd'
		});

		/*if有一级活动类型 then初始化二级活动类型*/
		if ('' != $('#type_oneic').val()) {
			addoption($('#type_oneic').val(), activity_type);
		}


		/*二级活动类型联动*/
		$('#type_oneic').on('change', function () {
			var one_ic = $(this).val();
			var optionlist = '<option value="">选择二级类型</option>';

			for (var o in activity_type) {
				if (activity_type[o].pic == one_ic) {
					optionlist += ('<option value="' + activity_type[o].ic + '">' + activity_type[o].title + '</option>');
				}
			}

			$('#type_twoic').empty().append(optionlist);
		});

		/*二级活动类型联动牵头部门*/
		$('#type_twoic').on('change', function(){
			$('#leaddepartment').text(showleaddepartment($(this).val()));
		});


		@if ($oj->isedit)
			/*一级活动类型*/
			$('#type_oneic').val('{{$data->type_oneic}}');
			$('#mycredit').val('{{$data->mycredit}}');
			$('#dic').val('{{$data->dic}}');

			/*二级活动类型*/
			var one_ic = '{{$data->type_oneic}}';
			var optionlist = '<option value="">选择二级类型</option>';

			for (var o in activity_type) {
				if (activity_type[o].pic == one_ic) {
					optionlist += ('<option value="' + activity_type[o].ic + '">' + activity_type[o].title + '</option>');
				}
			}

			$('#type_twoic').empty().append(optionlist);

			$('#type_twoic').val('{{$data->type_twoic}}');

		@endif
	})

    function addoption(ic, json) {
        var optionlist = '<option value="">选择二级类型</option>';

        for (var o in json) {
            if (json[o].pic == ic) {
                optionlist += ('<option value="' + json[o].ic + '">' + json[o].title + '</option>');
            }
        }

        $('#type_twoic').empty().append(optionlist);
    }

	function showleaddepartment(typeic){
		var dic = '';

		/*找到这个类型的牵头部门ic*/
		for (var o in activity_type) {
            if (activity_type[o].ic == typeic) {
				dic = activity_type[o].qiantouic;
            }
        }
			
		

		/*再由牵头部门ic,找到部门名称*/
		if(null != departlistindexic[dic]){
			return '牵头部门：' + departlistindexic[dic].title;
		}else{
			return '';
		}
	}

</script>
@endsection