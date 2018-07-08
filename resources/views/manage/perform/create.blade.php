<?php

require(base_path().'/resources/views/init.blade.php');

$activity_type =  json_encode($oj->activity_type, true) ;
$departlistindexic =  json_encode($oj->departlistindexic, true) ;

?>

@extends('manage.layout')


@section('content')

<ol class="crumb clearfix">
    <li>履职修业管理</li>
	<li> - {{$oj->mynav}}</li>
</ol>





<div class="panel panel-info">

    <div class="panel-body" >
        <form method="POST" action="{{ $oj->action }}" class="form-horizontal j_form"  role="form">
            {!! csrf_field() !!}
            @if($oj->isedit)
            <input type="hidden" name="_method" value="put">
            @endif

            <div class="form-group">
                <label class="col-md-4 control-label" for="title">学号</label>
                <div class="col-md-3">
                    <input type="text" placeholder="学号" required="required" class="form-control" name="ucode" value="{{$data->ucode Or ''}}" readonly="readonly">
                </div>
             
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="title">姓名</label>
                <div class="col-md-3">
                    <input type="text" placeholder="姓名" required="required" class="form-control" name="realname"  value="{{$data->realname Or ''}}" readonly="readonly">
                </div>
               
            </div>
             <div class="form-group">
                <label class="col-md-4 control-label">聘职学年</label>
                <div class="col-md-3">
                    <select name="myyear" id="myyear" class="form-control">
						<option value="">选择学年</option>
						@for($i=2016; $i<2028; $i++)
							<option value="{{$i}}-{{$i+1}} 学年 第一学期">{{$i}}-{{$i+1}}学年 第一学期</option>	
							<option value="{{$i}}-{{$i+1}} 学年 第二学期"">{{$i}}-{{$i+1}}学年 第二学期</option>
						@endfor
					</select>
                </div>
              
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="title">职务全称</label>
                <div class="col-md-3">
                    <input type="text" placeholder="" required="required" class="form-control" name="title" value="{{$data->title or ''}}">
                </div>
              
            </div>
           

            <div class="form-group">
                <label class="col-md-4 control-label" >一级类型</label>
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
                <label class="col-md-4 control-label" >二级类型</label>
                <div class="col-md-3">
                    <select name="type_twoic" id="type_twoic" class="form-control">
                    </select>

                </div>               
				<div class="col-md-3" id="leaddepartment"></div>
            </div>    


            <div class="form-group">
                <label class="col-md-4 control-label" for="title">聘任部门</label>
                <div class="col-md-3">
                    <select name="mydic" id="mydic" class="form-control">
						<option value="">选择聘任部门</option>
						@foreach($oj->departlistindexic as $v)
							<option value="{{$v->ic}}">{{$v->title}}</option>
                        
						@endforeach
                    </select>
                </div>
      
            </div>
            
          
            <div class="form-group">
                <label class="col-md-4 control-label" for="title">学分</label>
                <div class="col-md-3">
                    <select name="mycredit" id="mycredit"  class="form-control">
                        <option value="125">1/8学分</option>
                        <option value="250">1/4学分</option>
                        <option value="375">3/8学分</option>
                        <option value="500">1/2学分</option>
                        <option value="1000">1学分</option>
                        <option value="2000">2学分</option>
                        <option value="4000">4学分</option>
                    </select>
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
    var activity_type = eval(eval({!! $activity_type !!}));
	var departlistindexic = eval(eval({!! $departlistindexic !!}));
	$(function () {
		myupload('attachupload', 'originname', 'attachmentsurl');

		/*日期时间选择*/
		$('.datepicker').datetimepicker({
			language: 'zh-CN',
			autoclose: true,
			minuteStep: 30,
			format: 'yyyy-mm-dd hh:ii'
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
			$('#myyear').val('{{$data->myyear}}');//学年
			$('#mydic').val('{{$data->mydic}}');//聘任部门


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