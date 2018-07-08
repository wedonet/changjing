<?php

require(base_path().'/resources/views/init.blade.php');

?>

@extends('manage.layout')


@section('content')

<ol class="crumb clearfix">
    <li>校内荣誉管理</li>	
</ol>

<div class="row page-title-row" >
    <div class="col-md-6">

    </div>
    <div class="col-md-6 text-right" >
        <a href="{{ $currentcontroller }}/create" class="btn btn-success btn-md" type="button">
            申请校内荣誉
        </a>

    </div>	
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
        
                <th width="5%">#</th>
                <th width="*">名称</th>
				<th>类型</th>
                <th>牵头部门</th>        
       
         
                <th>提交时间</th>
                <th width="10%">状态</th>
                <th width="20%">操作</th>
            </tr>
        </thead>
   
		@foreach($list as $v)
        <tr>
        
            <td>{{$v->id}}</td>
            <td>{{$v->title}}</td>
			<td>{{$v->type_onename.'/'.$v->type_twoname}}</td>
            <td>{{$v->qiantouname}}</td>
      
            <td>{{$v->created_at}}</td>
     
            <td class="j_pass_{{$v->isok}}">{{checkstatus($v->isok)}}</td>

            <td class="tdoperate">
				@if(-1 == $v->isok)
				<a href="{{$cc}}/{{$v->id}}/submit" title="提交后将不能修改和添加学生" class="j_confirmpost">
				 提交
				</a>	
				@endif

 				<a href="{{$cc}}/{{$v->id}}" title="">
				 详情
				</a>	

				
 				<a href="{{$cc}}/{{$v->id}}/student" title="">
				 人员
				</a>	

				@if(-1 == $v->isok Or 2 == $v->isok)
				<a href="{{$cc}}/{{$v->id}}/edit" title="">
				 编辑
				</a>
				@endif

				@if($v->isok<1)
				<a href="{{$cc}}/{{$v->id}}" class="j_del alarm" title="删除{{$v->title}}" data-title1="名称" data-title2="{{$v->title}}" data-title3="记录">
				 删除
				</a>
				@endif
            </td>
        </tr>
		@endforeach

    
    </table>

	 <center>{!! $list->render() !!}</center>
</div>
@include('admin.partials._modals')









@stop


