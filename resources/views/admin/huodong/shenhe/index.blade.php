<?php

require_once(base_path().'/resources/views/init.blade.php');





$tab = 'tab_shenhe';
$auditstatus = $oj->search->auditstatus;
$activity = $oj->activity;
$search = $oj->search;
$aid = $oj->activity->id;


/*下面注入每个选项卡的操作*/
?>
@section('operate')
        <a href="javascript:;" class="btn btn-default btn-md hidden" type="button">新增</a>
	    <a href="javascript:;" class="btn btn-default btn-md hidden" type="button" id="allpass">批量审核</a>
	    <a href="/adminconsole/huodong_shenhe/export?aid={{$activity->id}}" class="btn btn-default btn-md " type="button">导出</a>
        <a href="javascript:;" class="btn btn-default btn-md hidden" type="button">参与人员删除</a>
        <a href="javascript:;" class="btn btn-default btn-md hidden" type="button">导入参与名单</a> 
        <a href="javascript:;" class="btn btn-default btn-md hidden" type="button">导出</a> 
@endsection


@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>活动管理</li>
	<li> - {{$activity->title}}</li>	
</ol>





@include('admin.huodong.tab')




<div class="toptip clearfix margintop1" >
	<div class="floatleft">
		人数限制：{{personlimit($activity->signlimit)}} &nbsp; 
		报名:{{$activity->signcount}}  &nbsp; 
		审核通过:{{$activity->checkcount}} 
	</div>
</div>



<div class="row page-title-row margintop2" >
	<div class="col-md-12 ">
		<form action="{{$cc}}" method="get">
			
			{!! csrf_field() !!}
			<input type="hidden" name="aid" value="{{$activity->id}}" />
			<div class="form-group input-group" style="float:left;width:26%;margin-right:5px;">
				
				<input type="text" placeholder="请输入学号/姓名" autocomplete="off" class=" form-control" name="ucode" value="{{$search->ucode}}"/>
				<ul class="vagueSearchBox"></ul>
			</div>
				
			<input type="submit" value="查询" class="btn btn-info" />
		</form>
	</div>            
 </div>








<div class="panel panel-info margintop3">	


	<div class="table-responsive">


	<form action="" method="post" id="myform" class="j_form">
	{!! csrf_field() !!}
    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
				<th width="2%">#ID
					<input type="checkbox" class="blankCheckbox hidden" value="option1" id="contrasel" aria-label="...">
				</th>
   
                <th width="7%">姓名</th>		
				<th width="7%">学号</th>	
                <th width="6%">学院</th>
				<th width="3%">性别</th>
			
	
				<th width="7%">报名时间</th>
				<th width="10%">申请陈述</th>
	
				<th width="6%">审核状态</th>
				<th width="12%" class="hidden">操作</th>	
            </tr>
        </thead>

		@foreach($list as $v)
   
        <tr>
        <td><input type="checkbox" class="blankCheckbox hidden"  name="ids[]" value="{{$v->id}}" aria-label="...">{{$v->id}}</td>
       
            <td>{{$v->realname}}</td>  
			<td>{{$v->ucode}}</td> 
			<td>{{$v->dname}}</td> 
			<td>{{$v->gender}}</td> 
	
			<td>{{$v->created_at}}</td>
			<td>{{$v->mystate}}</td> 
			<td class="auditstatus_{{$v->auditstatus}}">{{checkstatus($v->auditstatus)}}</td> 
            <td class="hidden">
				<a href="{{$currentcontroller}}/{{$aid}}/show/{{$v->id}}" class="j_open hidden">
		            查看
		        </a>&nbsp; 

				
				@if( 'pass' != $v->auditstatus)
				<a href="{{$currentcontroller}}/{{$aid}}/dopass/{{$v->id}}" class="j_confirm" title="审核通过">
                    通过
                </a>&nbsp;
				@endif

				@if( 'unpass' != $v->auditstatus)
		 		<a href="{{$currentcontroller}}/{{$aid}}/unpass/{{$v->id}}" class="j_open">
		            未通过
		        </a> 	
				@endif
				


            </td>
        </tr>
		@endforeach
     
        
    </table>
	</form>

	<center>{!! $list->render() !!}</center>
</div>
</div>

@stop

@section('scripts')
<script>
<!--

//-->
</script>
@endsection