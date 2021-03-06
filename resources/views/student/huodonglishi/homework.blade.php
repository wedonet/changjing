<?php

require_once(base_path().'/resources/views/init.blade.php');

$activity =& $j['activity'];





?>

@extends('student.layout')

@section('content')

<ol class="crumb clearfix">
    <li><a href="/student/huodonglishi">我的活动</a></li>
	<li> - {{$j['activity']->title}}</li>
</ol>



<div class="panel panel-info">


    <div class="panel-body" >
		<form method="post" action="{{$_SERVER['REQUEST_URI'] }} " class="form-horizontal j_form">
		{!! csrf_field() !!}
		<table class="table1">

			<tr>
				<td width="30%">是否需要交作业</td>
				<td width="70%">
				@if(1==$activity->homework)
					需要 &nbsp; (交作业时间 {{formattime2($activity->homeworktime_one)}} - {{formattime2($activity->homeworktime_two)}})
				@else
					不需要
				@endif
				
				
				</td>
			</tr>

			{{--有作业时才显示上交情况--}}
			@if(1 == $activity->homework)
			<tr>
				<td>上交情况</td>
				<td>@if(1 == $activity->homeworkisdone) 
				已交  <a href="{{$activity->homeworkurl}}">下载作业</a>


				@else
				未交
				@endif</td>
			</tr>
			@endif


			@if(1 == $activity->homeworkisdone) 
			<tr>
				<td>作业是否通过</td>
				<td>
				@if(1==$activity->homeworkisok)
				通过
				@elseif(2==$activity->homeworkisok)
				未通过 原因({{showexplain($activity->homeworkexplain)}})
				@else
				判作业队列中
				@endif
				</td>
			</tr>
			@endif


			
			{{--何时能上交作业--}}
			@if(1 == $activity->homework )
				@if( 1 == $activity->homeworkisok )
					<tr>
						<td>上交作业</td>
						<td>作业已通过</td>
					</tr>	
				@elseif( (time()>$activity->homeworktime_one) && (time() < $activity->homeworktime_two) )
					<tr>
						<td>上交作业</td>
						<td>            
							<input type="text"  class="form-control pull-left" id="attachmentsurl" value="" name="attachmentsurl" readonly="readonly" style="width:300px" /> 					

							<input type="file" id="attachupload" name="attachupload" class="pull-left"  style="width:200px;"/>
							<span id="uploadstatus_attachupload"></span>
					 

						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type="submit" class="btn btn-info j_slowsubmit"  disabled="disabled" value=" 提 交 作 业" /> </td>
					</tr>
				@else
					<tr>
						<td>上交作业</td>
						<td>没到或已超过交作业时间</td>
					</tr>			 
				@endif
			@endif


		</table>






		</form>




    </div>
</div>

@stop

@section('scripts')
<script>
<!--
$(document).ready(function(){
	/*file输入框选择文件后的处理*/
	myupload('attachupload', '', 'attachmentsurl');
})





//-->
</script>
@endsection