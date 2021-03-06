<?php

require_once(base_path().'/resources/views/init.blade.php');

$tab = 'tab_pingjia';

$activity = $oj->activity;
$aid = $activity->id;


/*下面注入每个选项卡的操作*/
?>
@section('operate')

@endsection


@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>活动管理</li>
	<li> - {{$oj->activity->title}}</li>	
</ol>





@include('admin.huodong.tab')




<div class="toptip clearfix margintop1" >
	<div class="floatleft"><strong>评价统计</strong> &nbsp; 
	五星: {{(  array_key_exists(5,$oj->statistics))  ?  $oj->statistics[5] : 0  }} &nbsp; 
	四星：{{(  array_key_exists(4,$oj->statistics))  ?  $oj->statistics[4] : 0  }} &nbsp; 
	三星：{{(  array_key_exists(3,$oj->statistics))  ?  $oj->statistics[3] : 0  }} &nbsp; 
	二星：{{(  array_key_exists(2,$oj->statistics))  ?  $oj->statistics[2] : 0  }} &nbsp; 
	一星：{{(  array_key_exists(1,$oj->statistics))  ?  $oj->statistics[1] : 0  }} &nbsp;  
	</div>
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
	当前状态： <a href="#" class="btn btn-success hidden">全部</a>
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">五星</a> 
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">四星</a> 
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">三星</a> 
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">二星</a> 
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">一星</a> 
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