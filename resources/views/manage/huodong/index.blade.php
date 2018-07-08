<?php

require_once(base_path().'/resources/views/init.blade.php');


$currentstatus = $j['search']->currentstatus;

$ActivityIndexIc = $j['ActivityIndexIc'];




?>

@extends('manage.layout')


@section('content')

<ol class="crumb clearfix">
    <li>活动管理</li>	
</ol>

<div class="page-title-row" >
	<form action="" method="get" class="form-inline">
		{!! csrf_field() !!}
		<div class="form-group input-group">                        
			<input type="text" placeholder="活动名称" autocomplete="off" class=" form-control" name="title" value="{{$j['search']->title}}"/>
			<ul class="vagueSearchBox"></ul>
		</div> 
		<button type="submit" class="btn btn-info btnsearch">查询</button>
	</form> 
</div>



<div class="row page-title-row" >
    <div class="col-md-6">
		<div>
			<a href="{{$currentcontroller}}" class="{{ (''==$currentstatus) ? 'btn btn-success' : '' }}" >全部</a>
			&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{$currentcontroller}}?currentstatus=doing" class="{{ ('doing'==$currentstatus) ? 'btn btn-success' : '' }}">进行中</a> 
			&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{$currentcontroller}}?currentstatus=new" class="{{ ('new'==$currentstatus) ? 'btn btn-success' : '' }}">未开始</a> 
			&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{$currentcontroller}}?currentstatus=done" class="{{ ('done'==$currentstatus) ? 'btn btn-success' : '' }}">已结束</a>
		</div>
    </div>
    <div class="col-md-6 text-right" >
        <a href="/manage/huodong/create" class="btn btn-success btn-md" type="button">
            申请活动
        </a>
		<a href="/manage/huodong?act=export" class="btn btn-info btn-md hidden" type="button">
            导出
        </a>  
    </div>	
</div>





<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="12%">名称</th>
                <th width="7%">活动类型</th>
                <th width="7%">活动时间</th>
				
				<th width="5%">审核</th>
				<th width="5%">签到</th>
				<th width="7%" >牵头部门</th>
				<th width="7%" >审核状态</th>
				<th width="6%">开通状态</th>
				
				<th width="12%">操作</th>
            </tr>
        </thead>
   
		@foreach($list as $v)
        <tr>
            <td>{{$v->id}}</td>
            <td><a href="/activity/detail/{{$v->id}}" target="_blank">{{$v->title}}</a></td>  
			<td>{{$v->type_onename}}/{{$v->type_twoname}}</td> 

			<td>{{formattime1($v->plantime_one)}}</td> 
		
			<td>{{$v->checkcount}}/{{$v->signcount}}</td> 
			<td>{{$v->herecount}}/{{$v->checkcount}}</td> 
			<td>{{typetodepartment($ActivityIndexIc, $v->type_twoic) }}</td>

			<td class="auditstatus_{{$v->auditstatus}}">
				{{checkstatus($v->auditstatus)}}

				@if('unpass'==$v->auditstatus)
					[<a href="{{$currentcontroller .'/'. $v->id . '/reason' }}" class="j_open">原因</a>]
				@endif
				
			</td> 
			<td class="j_open_{{$v->isopen}}">{{openstatus($v->isopen)}}</td> 

			<td class="hidden">{{currentstatus($v->currentstatus)}}</td> 

            <td>
				@if(( time()< $v->plantime_two) )
					@if(0==$v->isopen)
						<a href="{{ $cc .'/' . $v->id .'/isopen' }}" class="btn btn-xs btn-link j_confirmpost" title="开通{{$v->title}}">
							<i class="glyphicon "></i>开通
						</a>
					@endif

					@if(1==$v->isopen)
						<a href="{{ $cc .'/' . $v->id .'/unopen' }}" class="btn btn-xs btn-link j_confirmpost"  title="关闭{{$v->title}}">
							<i class="glyphicon "></i>关闭
						</a>
					@endif
				@endif

				<a href="{{$currentcontroller .'/'. $v->id }}" class="btn btn-xs btn-link ">
                    <i class="glyphicon "></i>详情
                </a>
                
      
				@if('pass' != $v->auditstatus)
                <a href="{{$currentcontroller .'/'. $v->id . '/edit' }}" class="btn btn-xs btn-link ">
                    <i class="glyphicon "></i>编辑
                </a>
				@endif


				@if(!'pass' == $v->auditstatus)
                <a href="{{ $currentcontroller .'/'.$v->id }}" class="btn btn-xs btn-link j_del alarm" title="删除" data-title1="名称" data-title2="{{$v->title}}" data-title3="活动">
                    <i class="glyphicon "></i>删除
                </a>					
				@endif
            </td>
        </tr>
		@endforeach


	
    </table>
</div>





<center>{!! $list->render() !!}</center>

@include('admin.partials._modals')


@stop


