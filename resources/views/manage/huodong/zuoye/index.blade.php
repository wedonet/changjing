<?php

require_once(base_path().'/resources/views/init.blade.php');

$tab = 'tab_zuoye';

$aid = $j['activity']->id;
$homeworkisdone = $j['search']->homeworkisdone;
$homeworkisok = $j['search']->homeworkisok;



/*下面注入每个选项卡的操作*/
?>
@section('operate')
	    <a href="{{$cc.'/0/allpass?activityid='.$aid}}" class="btn btn-default btn-md j_batch" rel="myform" type="button">批量通过</a>
        <a href="{{$cc.'/0/allunpass?activityid='.$aid}}" class="btn btn-default btn-md j_open"  type="button">批量未通过</a> 		
        <a href="{{$cc.'/0/export?activityid='.$aid}}" class="btn btn-default btn-md " type="button">导出作业上交记录</a>	
@endsection


@extends('manage.layout')


@section('content')

<ol class="crumb clearfix">
    <li><a href="/manage/huodong">活动管理</a></li>
	<li> - {{$j['activity']->title}}</li>	
</ol>





@include('manage.huodong.tab')




@if(1==$j['activity']->homework)


<div class="toptip clearfix margintop1" >
	<div class="floatleft">应交:{{$j['statistics']['yingjiao']}} 份 &nbsp; 实交:{{$j['statistics']['shijiao']}} 份 </div>
</div>



<div class="row page-title-row margintop2 " >

    <div class="col-md-12 ">

        <form action="{{$cc}}" method="get" class="search j_search">
            {!! csrf_field() !!}
            <input type="hidden" name="activityid" value="{{$aid}}" />
			<input type="hidden" name="homeworkisdone" value="{{$homeworkisdone}}" />
			<input type="hidden" name="homeworkisok" value="{{$homeworkisok}}" />
			
           
		   	<strong>上交情况:</strong>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" rel="homeworkisdone" data="">全部</a> 
					&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" rel="homeworkisdone" data="1">已交</a> 
					&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" rel="homeworkisdone" data="0">未交</a> 
					&nbsp;&nbsp;&nbsp;&nbsp;

             <strong>通过情况:</strong>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" rel="homeworkisok" data="">全部</a> 
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" rel="homeworkisok" data="0">待判</a> 
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" rel="homeworkisok" data="1">已通过</a> 
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" rel="homeworkisok" data="2">未通过</a> 
        </form>
    </div>

</div>











<div class="panel panel-info ">	


	<div class="table-responsive">

	<form action="" method="post" id="myform">
	{!! csrf_field() !!}
	<input type="hidden" name="homeworkexplain" value="" />
    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
				<th width="2%"> <input id="contrasel"  type="checkbox" class="blankCheckbox" value="option1" aria-label="..."></th>
 
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
         <input type="checkbox" class="blankCheckbox"  name="ids[]" value="{{$v->id}}" aria-label="...">
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

			<a href="/download?id={{$v->id}}&amp;p={{ base64_encode($v->homeworkurl)}}">下载</a>
			@endif
			</td>
			<th>{{yorn($v->homeworkisok)}}</th>
            <td>
	

					@if($v->homeworkisok == 0)
					<a href="{{$cc.'/'.$v->id.'/dopass_?activityid='.$aid}}">
						通过
					</a><a href="{{$cc.'/'.$v->id.'/unpass_?activityid='.$aid}}" class="j_open">
							未通过
						</a>
					@elseif($v->homeworkisok == 1)
					<a href="{{$cc.'/'.$v->id.'/unpass_?activityid='.$aid}}" class="j_open">
						未通过
					</a>
					@elseif($v->homeworkisok == 2)

						<a href="{{$cc.'/'.$v->id.'/dopass_?activityid='.$aid}}">
							通过
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

@else
<div class="panel panel-info margintop3">	没有作业</div>
@endif





@stop

@section('scripts')

@endsection