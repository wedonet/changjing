<?php

require_once(base_path().'/resources/views/init.blade.php');

$tab = 'tab_zuoye';

/*下面注入每个选项卡的操作*/
?>
@section('operate')
	    <a href="javascript:;" class="btn btn-default btn-md  hidden" type="button">批量通过</a>
        <a href="javascript:;" class="btn btn-default btn-md  hidden" type="button">批量未通过</a> 


		{{--没作业时不需要导出--}}
		@if($oj->course->homework > 0)
        <a href="/manage/zuoye_daochu/{{$oj->course->ic}}" class="btn btn-default btn-md hidden" type="button">导出作业上交记录</a>
		@endif

@endsection


@extends('manage.layout')


@section('content')

<ol class="crumb clearfix">
    <li><a href="/manage/course">课程管理</a></li>
	<li> - {{$oj->course->title}}</li>	
</ol>





@include('manage.course.tab')




@if(1==$oj->course->homework)


<div class="toptip clearfix margintop1" >
	<div class="floatleft">应交:{{$oj->yingjiao}} 份 &nbsp; 实交:{{$oj->shijiao}} 份 </div>
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
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">已交</a> 
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">未交</a> 
</div>






<div class="panel panel-info margintop3">	


	<div class="table-responsive">

    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
				<th width="2%"> <input type="checkbox" class="blankCheckbox" value="option1" aria-label="..."></th>
 
                <th width="10%">姓名</th>		
				<th width="7%">学号</th>	
                <th width="7%">学院</th>
				<th width="7%">性别</th>
			
				<th width="7%" class="hidden">手机号码</th>
				<th width="7%">完成作业</th>
				
				<th width="7%">下载</th>
				<th width="7%">是否通过</th>
	
				<th width="10%">操作</th>	
            </tr>
        </thead>

		@foreach($list as $v)
        <tr>
        <td>
         <input type="checkbox" class="blankCheckbox" value="option1" aria-label="...">
         </td>
 
            <td>{{$v->realname}}</td>  
			<td>{{$v->ucode}}</td> 
			<td>{{$v->dname}}</td> 
			<td>{{$v->gender}}</td> 
			<td class="hidden">150226653323</td>
			
			<td>{{showyes($v->homeworkisdone)}}</a></td>
			<td>
			@if('' != $v->homeworkurl)
			<a href="{{$v->homeworkurl}}" class="hidden">{{$v->homeworkurl}}</a>

			<a href="/download?id={{$v->id}}&amp;p={{ base64_encode($v->homeworkurl)}}&amp;mytype=course">下载</a>
			@endif
			</td>
			<th>{{yorn($v->homeworkisok)}}</th>
            <td>
	

			@if($v->homeworkisok == 0)
				<a href="{{$cc.'/'.$v->id.'/dopass?courseid='.$oj->course->id}}">通过</a>
				<a href="{{$cc.'/'.$v->id.'/unpass/?courseid='.$oj->course->id}}" class="j_open">未通过</a>					
			@elseif($v->homeworkisok == 1)
				<a href="{{$cc.'/'.$v->id.'/unpass/?courseid='.$oj->course->id}}" class="j_open">未通过</a>	
			@elseif($v->homeworkisok == 2)
				<a href="{{$cc.'/'.$v->id.'/dopass?courseid='.$oj->course->id}}">通过</a>
			@endif
			
            </td>
        </tr>
		@endforeach
       
    </table>
	<center>{!! $list->render() !!}</center>
</div>
</div>

@else
<div class="panel panel-info margintop3">	没有作业</div>
@endif





@stop

@section('scripts')

@endsection