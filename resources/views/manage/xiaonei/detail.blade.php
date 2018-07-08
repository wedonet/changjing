<?php

require(base_path().'/resources/views/init.blade.php');

?>

@extends('manage.layout')


@section('content')

<ol class="crumb clearfix">
    <li>校内荣誉审核</li>
	<li> - 详情</li>
</ol>

<div class="row page-title-row" >


    <div class="col-md-6">

    </div>
    <div class="col-md-6 text-right" >
        @if(1 <> $data->isok)
        <a href="{{$currentcontroller}}/{{$data->id}}/dopass" class="btn btn-success btn-md j_confirmpost" title="{{$data->title}} 通过审核" type="button">
            审核通过
        </a>
        @endif

        @if(2 <> $data->isok)
        <a href="{{$currentcontroller}}/{{$data->id}}/unpass"  class="btn btn-warning btn-md j_open" type="button">
            未通过
        </a>  
        @endif
    </div>	
</div>


<ul class="nav nav-tabs j_nav navmanage">
    <li role="presentation" class="active"><a href="javascript:void(0)" rel="block_detail">详细信息</a></li>
    <li role="presentation"><a href="javascript:void(0)" rel="block_student">人员</a></li>
</ul>

{{--详细信息--}}
<div class="panel panel-info navblock" id="block_detail">
    <div class="panel-body" >
		@include('pub.innerhonordetail')
    </div>
</div>


{{--人员--}}
<div class="panel panel-info navblock hidden" id="block_student">
    <div class="panel panel-info">
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="j_list">
               <thead>
					<tr>
						<th width="5%">#</th>
						<th width="10%">学号</th>
						<th width="10%">姓名</th>
					  
						<th width="10%">班级</th>
						<th width="10%">院系</th>
					
			
					</tr>
				</thead>
		   
				@foreach($oj->innerhonor_signup as $v)
				<tr>
					<td>{{$v->id}}</td>
					<td>{{$v->ucode}}</td>
					<td>{{$v->realname}}</td>
					<td>{{$v->classname}}</td>
					<td>{{$v->dname}}</td>

				</tr>
				@endforeach
            </table>
        </div>
    </div>
</div>
@stop

@section('scripts')

@endsection