<?php
require_once(base_path() . '/resources/views/init.blade.php');



?>
@section('operate')
@endsection


@extends('admin.layout')


@section('content')



<ol class="crumb clearfix">
    <li>教师管理</li>
    <li> - 导入教师</li>	
</ol>



<div class="panel panel-default margintop2">

        <form method="post" action="{{$_SERVER['REQUEST_URI'] }} " class="form-horizontal longsubmit">
            {!! csrf_field() !!}
            <table class="table1">
	
				<tr>
					<td width="300">教师数据模板</td>
					<td><a href="/files/teacher_inport.xlsx" >点击这里下载模板</a></td>
				</tr>	

				<tr>
					<td>上传教师表</td>
					<td>            
						<input type="text"  class="form-control pull-left" id="attachmentsurl" value="" name="attachmentsurl" readonly="readonly" style="width:300px" /> 					

						&nbsp; <input type="file" id="attachupload" name="attachupload" class="pull-left"  style="width:200px;"/>
						<span id="uploadstatus_attachupload"></span>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input type="submit" class="btn btn-info j_slowsubmit longsubmit"  disabled="disabled" value=" 执行导入教师" /> </td>
				</tr>
				
		</table>


 
        </form>
		
		<div style="margin:50px 0;border-top:1px dashed #bbb;"></div>

		<ol class="crumb clearfix">	
			<li> 导入辅导员</li>	
		</ol>


        <form method="post" action="/adminconsole/fudao_import" class="form-horizontal longsubmit">
            {!! csrf_field() !!}
            <table class="table1">
	
				<tr>
					<td width="300">辅导员数据模板</td>
					<td><a href="/files/fudao_import.xls" >点击这里下载模板</a></td>
				</tr>	

				<tr>
					<td>上传辅导员表</td>
					<td>            
						<input type="text"  class="form-control pull-left" id="attachmentsurl2" value="" name="attachmentsurl2" readonly="readonly" style="width:300px" /> 					

						&nbsp; <input type="file" id="attachupload2" name="attachupload2" class="pull-left"  style="width:200px;"/>
						<span id="uploadstatus_attachupload2"></span>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input type="submit" class="btn btn-info j_slowsubmit"  disabled="disabled" value=" 执行导入辅导员" /> </td>
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
		myupload('attachupload2', 'originname2', 'attachmentsurl2');
    })
//-->
</script>
@endsection