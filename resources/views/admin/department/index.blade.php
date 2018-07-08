<?php

require_once(base_path().'/resources/views/init.blade.php');


$search = $j['search'];

?>

@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>部门管理</li>	
</ol>

<div class="row page-title-row margintop2" >
    <div class="col-md-8 ">

        <form action="{{$cc}}" method="get" class="form-inline">
            {!! csrf_field() !!}           
			<input type="text" placeholder="名称" autocomplete="off" class=" form-control" name="title" 
				   value="{{ $search->title }}" />

			<select id="mytype" name="mytype" class=" form-control">
					<option value="">部门类型</option>
					<option value="zhineng">职能部门</option>
					<option value="yewu">业务部门</option>
			</select>
			<input type="submit" value="查询" class="btn btn-info" />
        </form>
    </div>

	<div class="col-md-4 text-right">

			<a href="{{ $currentcontroller }}/create" class="btn btn-success btn-md" type="button">
				新建部门
			</a>

			<a href="{{ $currentcontroller }}_createfq" class="btn btn-success btn-md loadinglink" type="button">
				添加默认发起账户
			</a>
	</div>
</div>



<div class="table-responsive">
    <table class="table table-striped table-hover" class="j_list" >
        <thead>
            <tr>
                <th width="5%">#</th>
				<th width="7%">编码</th>	
                <th width="*">部门名称</th>	
				
				<th width="10%">部门类型</td>
				<th width="7%">是否学院</th>
				<th width="10%">发起用户名</th>
				<th width="10%">审核用户名</th>
				<th width="7%">排序</th>
                <th width="20%">操作</th>
            </tr>
        </thead>        

		@foreach($list as $v)
			<tr>
				<td>{{$v->id}}</td>
				<td>{{$v->ic}}</td>
				<td>{{$v->title}}</td>				
				<td>{{ 'zhineng'==$v->mytype ? '职能' : '业务'}}</td>
				<td>{{ '1'==$v->isxueyuan ? '是':''}}</td>
				<td><a href="department_fq/{{$v->id}}" class="j_open" title="{{$v->title}} 修改" rel="{{$v->ic}}">{{$v->userfq}}</a></td>
				<td><a href="department_sh/{{$v->id}}" class="j_open" title="{{$v->title}} 修改" rel="{{$v->ic}}">{{$v->usersh}}</a></td>
				<td>{{$v->cls}}</td>
				<td>
				<a href="department/{{$v->id}}/edit" class="btn btn-xs btn-primary" title="">
				 编辑
				</a>


			

				<a href="department/{{$v->id}}" class="btn btn-xs btn-danger glyphicon glyphicon-trash j_del" title="删除{{$v->title}}" data-title1="名称" data-title2="{{$v->title}}" data-title3="部门">
				 删除
				</a>

				</td>
			</tr>
		@endforeach
     

    </table>
</div>


<script>
<!--
	$(document).ready(function(){

		$('#mytype').val('{{$search->mytype}}');
		
		/*调出设置负责人表单*/
//		$('a.j_master').on('click', function(){
//			$('#mastername').text($(this).attr('title'));
//			$('#dic').val($(this).attr('rel'));
//			$("#j_modalmaster").modal("show");
//			
//			
//
//			return false;
//		});
		
        //var title1=this.getAttribute('data-title1');
        //var title2=this.getAttribute('data-title2');
       // var title3=this.getAttribute('data-title3');
        //$("#modal_title1").html(title1);
        //$("#modal_title2").html(title2);
        //$("#modal_title3").html(title3);
        //$("#delaction").attr('action', ($(this).attr('href')));
      
	   
	   /*提交负责人表单的处理*/
	   //$('#j_modalmaster').on('submit', function(){

		//toastr.warning('只能选择一行进行编辑');
		//return false;
	   //})


	
		

	})
//-->
</script>








@include('admin.partials._modals')


@stop


