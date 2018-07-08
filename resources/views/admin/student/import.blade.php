<?php

require_once(base_path().'/resources/views/init.blade.php');

?>

@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>学生管理</li>
	<li> - 批量导入</li>
</ol>





<div class="panel panel-info noborder">

		<form method="post" action="{{$_SERVER['REQUEST_URI'] }}" class="form-horizontal longsubmit">

		<table class="table0">
            {!! csrf_field() !!}
           	<tr>
				<td>上传文件</td>
				<td>            
					<input type="text"  class="form-control pull-left" id="attachmentsurl" value="" name="attachmentsurl" readonly="readonly" style="width:300px" /> 


					<input type="file" id="file1" name="file1" class="pull-left  fileinput-button" style="margin-left:10px;" />  &nbsp;
			 

                </td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" class="btn btn-info j_slowsubmit"  disabled="disabled" value=" 导 入" /> </td>
			</tr>
		</table>
        </form>

</div>

@stop

@section('scripts')
<script>
<!--
$(document).ready(function(){
	
	myupload('file1', '', 'attachmentsurl');



})





//-->


</script>
@endsection