<?php

require_once(base_path().'/resources/views/init.blade.php');

$tab = 'tab_xuefen';

$aid = $j['activity']->id;
$activityisok = $j['search']['activityisok'];

/*下面注入每个选项卡的操作*/
?>
@section('operate')
	    <a href="{{$cc.'/0/allpass?activityid='.$aid}}" class="btn btn-default btn-md j_submitopen" type="button" rel="myform">批量评分</a>
		<a href="{{$cc.'/0/allunpass?activityid='.$aid}}" class="btn btn-default btn-md j_submitopen" type="button" rel="myform">批量未通过</a>
        <a href="/manage/huodong_xuefen/{{$j['activity']->id}}/export" class="btn btn-default btn-md hidden" type="button">导出学分记录</a>
		<a href="{{$cc.'/0/export?activityid='.$aid}}" class="btn btn-default btn-md" type="button">导出学分记录</a>
@endsection


@extends('manage.layout')


@section('content')

<ol class="crumb clearfix">
    <li><a href="/manage/huodong">活动管理</a></li>
	<li> - {{$j['activity']->title}}</li>	
</ol>





@include('manage.huodong.tab')




<div class="toptip clearfix margintop1" >
	<div class="floatleft"> 
		&nbsp; 总人数:{{$j['statistics']['all']}} 人 
		&nbsp; 已评:{{$j['statistics']['yiping']}} 人 
		&nbsp; 通过：{{$j['statistics']['pass']}} 人 
		&nbsp; 未通过：{{$j['statistics']['unpass']}} 人
	</div>
</div>



<div class="row page-title-row margintop2 ">
    <div class="col-md-12 ">
		<form action="{{$cc}}" method="get" class="search j_search">
			{!! csrf_field() !!}
			<input type="hidden" name="aid" value="{{$aid}}" />
			<input type="hidden" name="activityisok" value="{{$activityisok}}" />

			<a href="javascript:void(0)" rel="activityisok" data="">全部</a>
			&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" rel="activityisok" data="0">待评分</a> 
			&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" rel="activityisok" data="1">通过</a> 
			&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" rel="activityisok" data="2">未通过</a> 

		</form>
	</div>            
</div>









<div class="panel panel-info margintop3">	


	<div class="table-responsive">

	<form action="" method="post" id="myform">
	{{ csrf_field() }}
    <table class="table table-striped table-hover" id="j_list" >

        <thead>
            <tr>
				<th width="2%">
					<input type="checkbox" class="blankCheckbox" value="option1" id="contrasel" aria-label="...">
				</th>
   
                <th width="10%">姓名</th>		
				<th width="7%">学号</th>	
                <th width="7%">学院</th>
				<th width="7%">性别</th>
			
				<th width="7%" class="hidden">手机号码</th>
				<th width="7%">作业通过</th>
				<th width="7%">活动通过</th>

				<th width="7%">学分</th>
				<th width="7%">等级</th>
	
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
			<td class="hidden"></td>

			<td class="j_pass_{{$v->homeworkisok}}">{{ homeworkokyorn($v->homeworkisok, $j['activity']->homework) }}</td>

			<td class="j_pass_{{$v->activityisok}}"><span data-toggle="tooltip" data-placement="top" title="{{$v->creditexplain}}">{{yorn($v->activityisok)}}</span></td>

			<td>{{ fmcredit($v->mylevel , $v->actualcreidt) }}</td>
			<td>{{showlevel($v->mylevel)}}</td>

            <td>
				<a href="{{$cc.'/'.$v->id.'/pass?activityid='.$aid}}" class="j_open">
                    评分 
                </a>&nbsp;

				

				<a href="{{$cc.'/'.$v->id.'/unpass?activityid='.$aid}}" class="j_open">
                    未通过 
                </a>
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

</script>

@endsection