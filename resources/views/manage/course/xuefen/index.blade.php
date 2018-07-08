<?php

require_once(base_path().'/resources/views/init.blade.php');

$tab = 'tab_xuefen';

/*下面注入每个选项卡的操作*/
?>
@section('operate')
	    <a href="javascript:;" class="btn btn-default btn-md  hidden" type="button">批量评分</a>
		<a href="javascript:;" class="btn btn-default btn-md  hidden" type="button">批量未通过</a>
        <a href="/manage/course_xuefen/{{$oj->course->id}}/export" class="btn btn-default btn-md hidden" type="button">导出学分记录</a>
@endsection


@extends('manage.layout')


@section('content')

<ol class="crumb clearfix">
    <li><a href="/manage/course">课程管理</a></li>
	<li> - {{$oj->course->title}}</li>	
</ol>





@include('manage.course.tab')




<div class="toptip clearfix margintop1" >
	<div class="floatleft"> &nbsp; 总人数:{{$oj->statistics->all}} 人 &nbsp; 已评:{{$oj->statistics->yiping}} 人 通过：{{$oj->statistics->pass }} 人 未通过：{{$oj->statistics->unpass }} 人</div>
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
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">已评分</a> 
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">未评分</a> 
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">通过</a> 
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">未通过</a> 
</div>






<div class="panel panel-info margintop3">	


	<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
				<th width="2%">
					<input type="checkbox" class="blankCheckbox" value="option1" aria-label="...">
				</th>
   
                <th width="10%">姓名</th>		
				<th width="7%">学号</th>	
                <th width="7%">学院</th>
				<th width="7%">性别</th>
			
				<th width="7%" class="hidden">手机号码</th>
				<th width="7%">作业通过</th>
				<th width="7%">课程通过</th>

				<th width="7%">学分</th>
				<th width="7%">等级</th>
	
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
			<td class="hidden"></td>

			<td class="j_pass_{{$v->homeworkisok}}">{{ homeworkokyorn($v->homeworkisok, $oj->course->homework) }}</td>

			<td class="j_pass_{{$v->itemisok}}"><span data-toggle="tooltip" data-placement="top" title="{{$v->creditexplain}}">{{yorn($v->itemisok)}}</span></td>

			<td>{{ fmcredit($v->mylevel , $v->actualcreidt) }}</td>
			<td>{{showlevel($v->mylevel)}}</td>

            <td>
				<a href="{{$cc.'/'. $v->id .'/pass?courseid=' . $oj->course->id }}" class="j_open">
                    评分 
                </a>&nbsp;

				
				<a href="{{$cc.'/'. $v->id .'/unpass?courseid=' . $oj->course->id }}" class="j_open">			
                    未通过 
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
<script>

</script>

@endsection