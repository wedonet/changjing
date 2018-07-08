<?php

require_once(base_path().'/resources/views/init.blade.php');

$tab = 'tab_xuefen';

$activity = $oj->activity;
$aid = $activity->id;

/*下面注入每个选项卡的操作*/
?>
@section('operate')
	    <a href="javascript:;" class="btn btn-default btn-md  hidden" type="button">批量评分</a>
		<a href="javascript:;" class="btn btn-default btn-md  hidden" type="button">批量未通过</a>
        <a href="/adminconsole/huodong_xuefen/{{$aid}}/export" class="btn btn-default btn-md " type="button">导出学分记录</a>
@endsection


@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>活动管理</li>
	<li> - {{$activity->title}}</li>	
</ol>





@include('admin.huodong.tab')




<div class="toptip clearfix margintop1" >
	<div class="floatleft"> &nbsp; 总人数:{{$oj->statistics->all}} 人 &nbsp; 已评:{{$oj->statistics->yiping}} 人 通过：{{$oj->statistics->pass}} 人 未通过：{{$oj->statistics->unpass}} 人</div>
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
				<th width="2%">#</th>
   
                <th width="10%">姓名</th>		
				<th width="7%">学号</th>	
                <th width="7%">学院</th>
				<th width="7%">性别</th>
			
				<th width="7%" class="hidden">手机号码</th>
				<th width="7%">作业通过</th>
				<th width="7%">活动通过</th>
				<th width="7%">学分</th>
				<th width="7%">等级</th>
	
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
			<td class="hidden"></td>

			<td class="j_pass_{{$v->homeworkisok}}">{{ homeworkokyorn(yorn($v->homeworkisok), $activity->homework) }}</td>


			<td class="j_pass_{{$v->activityisok}}"><span data-toggle="tooltip" data-placement="top" title="{{$v->creditexplain}}">{{yorn($v->activityisok)}}</span></td>
			<td>{{$v->actualcreidt/1000}}</td>
			<td>{{showlevel($v->mylevel)}}</td>
            <td class="hidden">
				<a href="{{$cc.'/'.$aid.'/pass/'.$v->id}}" class="j_open">
                    评分 
                </a>&nbsp;

				

				<a href="{{$cc.'/'.$aid.'/unpass/'.$v->id}}" class="j_open">
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