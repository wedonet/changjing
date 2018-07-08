<?php
require_once(base_path() . '/resources/views/init.blade.php');





$tab = 'tab_shenhe';


$course = $oj->course;
$courseid = $oj->courseid;

$myurl = $cc.'?courseid='.$courseid;


/* 下面注入每个选项卡的操作 */
?>
@section('operate')
@endsection


@extends('manage.layout')


@section('content')



<ol class="crumb clearfix">
    <li><a href="/manage/course">课程管理</a></li>
    <li> - {{$course->title}}</li>	
</ol>

@include('manage.course.tab')

<div class="row page-title-row margintop2" >


        <form method="post" action="{{$_SERVER['REQUEST_URI'] }} " class="form-horizontal">
            {!! csrf_field() !!}
            <table class="table1">
	
				<tr>
					<td width="300">审核模板</td>
					<td><a href="{{$cc}}/exporttemplate?courseid={{$courseid}}" >点击这里下载模板</a></td>
				</tr>	

				<tr>
					<td>上传审核表</td>
					<td>            
						<input type="text"  class="form-control pull-left" id="attachmentsurl" value="" name="attachmentsurl" readonly="readonly" style="width:300px" /> 					

						&nbsp; <input type="file" id="attachupload" name="attachupload" class="pull-left"  style="width:200px;"/>
						<span id="uploadstatus_attachupload"></span>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input type="submit" class="btn btn-info j_slowsubmit"  disabled="disabled" value=" 执行导入" /> </td>
				</tr>
				
		</table>


 
        </form>



</div>







@stop

@section('scripts')
<script>
<!--
    $(document).ready(function () {
		myupload('attachupload', 'originname', 'attachmentsurl');
    })
//-->
</script>
@endsection