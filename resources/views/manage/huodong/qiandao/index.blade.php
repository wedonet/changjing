<?php
require_once(base_path().'/resources/views/init.blade.php');

$tab = 'tab_qiandao';

$aid = $j['activity']->id ;

$actionbatchsignin = $cc . '/batchsignin_?activityid='. $j['activity']->id ; //批量签到地址

/*下面注入每个选项卡的操作*/
?>
@section('operate')
	    <a href="javascript:void(0);" id="batchsignin" class="btn btn-default btn-sm" type="button">批量签到</a>
        <a href="javascript:;" class="btn btn-default btn-sm  hidden" type="button">批量签退</a> 
        <a href="/manage/huodong_qiandao/export_?activityid={{$j['activity']->id}}" class="btn btn-default btn-sm " type="button">导出签到人员</a>
		<a class="btn btn-success btn-sm" href="/manage/qiandao/{{$j['activity']->ic}}?activityid={{$aid}}" role="button">签到码</a>
		<a class="btn btn-warning btn-sm" href="/manage/qiantui/{{$j['activity']->ic}}?activityid={{$aid}}" role="button">签退码</a>
		<a class="btn btn-default btn-sm" href="{{$cc.'/count?activityid='.$aid }}" role="button">更新签到统计</a>
@endsection


@extends('manage.layout')


@section('content')



<ol class="crumb clearfix">
    <li><a href="/manage/huodong">活动管理</a></li>
	<li> - {{$j['activity']->title}}</li>	
</ol>





@include('manage.huodong.tab')




<div class="toptip clearfix margintop1" >
	<div class="floatleft"><strong>当前状态</strong> &nbsp; 应到:{{$j['statistics']['yingdao']}} 人 &nbsp; 实到:{{$j['statistics']['shidao']}} 人 </div>
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


	<form action="" method="post" id="myform">
	{!! csrf_field() !!}
    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
				<th width="2%"> <input type="checkbox" name="radio" id="contrasel" class="blankCheckbox" value="option1" aria-label="..."></th>
    
                <th width="7%">姓名</th>		
				<th width="7%">学号</th>	
                <th width="7%">学院</th>
				<th width="7%">性别</th>
			
				<th width="7%" class="hidden">手机号码</th>
		
				<th width="4%">签到</th>
				<th width="4%">签退</th>

				<th width="7%">入场时间</th>
				<th width="7%">退场时间</th>
	
				<th width="10%">操作</th>	
            </tr>
        </thead>
   
		@foreach($list as $v)
        <tr>
			<td><input type="checkbox" class="blankCheckbox"  name="ids[]" value="{{$v->id}}" aria-label="..."></td>           
            <td>{{$v->realname}}</td>  
			<td>{{$v->ucode}}</td> 
			<td>{{$v->dname}}</td> 
			<td>{{$v->gender}}</td> 
			<td class="hidden">150226653323</td>
			<td>{{issign($v->issignined)}}</td>
			<td>{{issign($v->issignoffed)}}</td>
			<td>{{ formattime2($v->signintime) }}</td> 
		
			<td>{{ formattime2($v->signoffedime) }}</td>
            <td>
				
				<a href="{{$cc.'/'.$v->id.'/signin?activityid='.$j['aid'] }}">
                    签到
                </a>
		
				<a href="{{$cc.'/'.$v->id.'/signout?activityid='.$j['aid'] }}">
                    签退
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
<script type="text/javascript">
<!--
	$(document).ready(function(){
		/*批量签到*/
		$('#batchsignin').on('click', function(){
			$('#myform').attr('action', '{{$actionbatchsignin}}').submit();
		})
	})
//-->
</script>
@endsection