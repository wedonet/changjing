<?php
require_once(base_path().'/resources/views/init.blade.php');

$tab = 'tab_qiandao';

$activity = $oj->activity;
$aid = $activity->id;

/*下面注入每个选项卡的操作*/
?>
@section('operate')
	    <a href="javascript:;" class="btn btn-default btn-sm hidden" type="button">批量签到</a>
        <a href="javascript:;" class="btn btn-default btn-sm  hidden" type="button">批量签退</a> 
        <a href="/adminconsole/huodong_qiandao/{{$activity->id}}/export?aid={{$aid}}" class="btn btn-default btn-sm " type="button">导出签到表</a>
		<a class="btn btn-success btn-sm hidden" href="/admin/qiandao/{{$activity->ic}}" role="button">签到码</a>
		<a class="btn btn-warning btn-sm hidden" href="/admin/qiantui/{{$activity->ic}}" role="button">签退码</a>
@endsection


@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>活动管理</li>
	<li> - {{$activity->title}}</li>	
</ol>





@include('admin.huodong.tab')




<div class="toptip clearfix margintop1" >
	<div class="floatleft"><strong>当前状态</strong> &nbsp; 应到:{{$oj->statistics->yingdao}} 人 &nbsp; 实到:{{$oj->statistics->shidao}} 人 </div>
</div>



<div class="row page-title-row margintop2 hidden" >
	<div class="col-md-12 ">

		<form action="" method="POST">
			{!! csrf_field() !!}
			<div class="form-group input-group" style="float:left;width:26%;margin-right:5px;">
				
				<input type="text" placeholder="请输入学号/姓名" autocomplete="off" class=" form-control" name="product_name" value=""/>
				<ul class="vagueSearchBox"></ul>
			</div>
				
			<input type="text" value="查询" class="btn btn-info" />
		</form>
	</div>

	
            
 </div>


<div class="hidden">
	当前状态： <a href="#" class="btn btn-success">全部</a>
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">已签到</a> 
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">未签到</a> 
</div>






<div class="panel panel-info margintop3">	


	<div class="table-responsive">


    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
				<th width="2%">#</th>
    
                <th width="7%">姓名</th>		
				<th width="7%">学号</th>	
                <th width="7%">学院</th>
				<th width="7%">性别</th>
			
				<th width="7%" class="hidden">手机号码</th>
		
				<th width="4%">签到</th>
				<th width="4%">签退</th>

				<th width="7%">入场时间</th>
				<th width="7%">退场时间</th>
	
				<th width="10%" class="hidden">操作</th>	
            </tr>
        </thead>
   
		@foreach($list as $v)
        <tr>
        <td>{{$v->id}}</td>
           
            <td>{{$v->realname}}</td>  
			<td>{{$v->ucode}}</td> 
			<td>{{$v->dname}}</td> 
			<td>{{$v->gender}}</td> 
			<td class="hidden">150226653323</td>
			<td>{{issign($v->issignined)}}</td>
			<td>{{issign($v->issignoffed)}}</td>
			<td>{{ formattime2($v->signintime) }}</td> 
		
			<td>{{ formattime2($v->signoffedime) }}</td>
            <td class="hidden">
				<a href="{{$cc.'/'.$aid.'/signin/'.$v->id}}">
                    签到
                </a>
		
				<a href="{{$cc.'/'.$aid.'/signout/'.$v->id}}">
                    签退
                </a>
            </td>
        </tr>
		@endforeach
       
    </table>

	<center>{!! $list->render() !!}</center>
</div>
</div>

@stop

@section('scripts')

@endsection