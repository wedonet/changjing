<?php

require_once(base_path().'/resources/views/init.blade.php');

$tab = 'tab_pingjia';
$activity = $j['activity'];
$aid = $activity->id;
$search = $j['search'];


/*下面注入每个选项卡的操作*/
?>
@section('operate')

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
	<strong>评价统计</strong> &nbsp; 
	五星: {{(  array_key_exists(5,$j['statistics']))  ?  $j['statistics'][5] : 0  }} &nbsp; 
	四星：{{(  array_key_exists(4,$j['statistics']))  ?  $j['statistics'][4] : 0  }} &nbsp; 
	三星：{{(  array_key_exists(3,$j['statistics']))  ?  $j['statistics'][3] : 0  }} &nbsp; 
	二星：{{(  array_key_exists(2,$j['statistics']))  ?  $j['statistics'][2] : 0  }} &nbsp; 
	一星：{{(  array_key_exists(1,$j['statistics']))  ?  $j['statistics'][1] : 0  }} &nbsp;  
	</div>
</div>



<div class="row page-title-row margintop2 ">
    <div class="col-md-12 ">
		<form action="{{$cc}}" method="get" class="search j_search">


			<input type="hidden" name="aid" value="{{$aid}}" />
			<input type="hidden" name="appraise" value="{{$search['appraise']}}" />

			

			<a href="javascript:void(0)" rel="appraise" data="">全部</a>
			&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" rel="appraise" data="5">五星</a> 
			&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" rel="appraise" data="4">四星</a> 
			&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" rel="appraise" data="3">三星</a> 
			&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" rel="appraise" data="2">二星</a> 
			&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" rel="appraise" data="1">一星</a> 

           

        </form>
    </div>

</div>











<div class="panel panel-info margintop3">	


	<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
				
    
                <th width="10%">姓名</th>		
				<th width="7%">学号</th>	
                <th width="7%">学院</th>
				<th width="7%">性别</th>
			
	
				<th width="7%">评价(星)</th>
				<th width="7%">时间</th>
	
            </tr>
        </thead>
   
		@foreach($list as $v)
        <tr>
      
            <td>{{$v->realname}}</td>  
			<td>{{$v->ucode}}</td> 
			<td>{{$v->dname}}</td> 
			<td>{{$v->gender}}</td> 
	

            <td>{{$v->appraise}}</td>
			<td>{{formattime2($v->appraisetime)}}</td>
           
        </tr>
		@endforeach
       
    </table>

	<center>{!! $list->render() !!}</center>
</div>
</div>

@stop

@section('scripts')

@endsection