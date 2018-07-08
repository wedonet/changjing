<?php

require_once(base_path().'/resources/views/init.blade.php');


if($j['isedit']){
	$date = $j['data'];
	$j['action'] = $cc . '/' . $data->id .'?pic='.$j['ptype']->ic;
}else{
	$date = null;
	$j['action'] = $cc.'?pic='.$j['ptype']->ic;
}


?>

@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>活动类型</li>
	<li> - {{$j['ptype']->title}}</li>
</ol>





<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">添加二级活动类型</div>
    </div>

    <div class="panel-body" >
        <form method="post" action="{{ $j['action'] }}" class="form-horizontal j_form"  role="form">
            {!! csrf_field() !!}
			@if($j['isedit'])
			<input type="hidden" name="_method" value="put">
			@endif
			
            <div class="form-group">
                <label class="col-md-4 control-label" for="title">名称</label>
                <div class="col-md-3">
                    <input type="text" placeholder="二级活动名称" required="required" class="form-control" name="title"  value="{{$data->title or ''}}">
                </div>
               
            </div>


            <div class="form-group">
                <label class="col-md-4 control-label" for="title">牵头部门</label>
                <div class="col-md-3">
                    <select name="qiantouic" id="qiantouic" class="form-control">
						<option value="">选择牵头部门</option>
                        @foreach($j['deparmentlist'] as $v)
						@if(0==$v->isxueyuan)
						<option value="{{$v->ic}}">{{$v->title}}</option>
						@endif
						@endforeach
                    </select>
                </div>
               
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="title">目标学分</label>
                <div class="col-md-3">
                    <input type="text" placeholder="整数" required="required" class="form-control" name="target"  value="{{$data->target or ''}}">
                </div>               
            </div>


            <div class="form-group">
                <label class="col-md-4 control-label" for="title">必修</label>
                <div class="col-md-3">
                    <select name="ismust" id="ismust" class="form-control">
						<option value="">是否必修</option>                      
						<option value="1">是</option>
						<option value="0">否</option>
                    </select>
                </div>               
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="title">排序</label>
                <div class="col-md-3">
                    <input type="text" placeholder="二级活动名称" required="required" class="form-control" name="cls"  value="{{$data->cls or '100'}}">
                </div>
               
            </div>



            <div class="form-group">
                <label class="col-md-4 control-label" for="title">说明</label>
                <div class="col-md-3">
					<textarea name="readme" rows="5"  class="form-control" required="required">{{$data->readme or '说明文字'}}</textarea>
                </div>
               
            </div>


            <div class="form-group">
                <label class="col-md-4 control-label" for="submit"></label>
                <div class="col-md-3">
                    <input type="submit" class="btn btn-info j_slowsubmit" value=" 提 交 " disabled="disabled"/>
                </div>
            </div>


        </form>
    </div>
</div>

@stop

@section('scripts')
<script>
$(document).ready(function(){
	@if($j['isedit'])

		$('#qiantouic').val('{{$data->qiantouic}}');
		$('#ismust').val('{{$data->ismust}}');
	@endif
})
</script>
@endsection