<?php

require(base_path().'/resources/views/init.blade.php');

$ih = $oj->innerhonor;


$icaneditstudent = false;

if(-1 == $ih->isok Or 2==$ih->isok){
	$icaneditstudent = true;
}

?>

@extends('manage.layout')


@section('content')

<ol class="crumb clearfix">
    <li>校内荣誉管理</li>	
	<li> -{{$ih->title}}</li>
	<li> -添加学生</li>
</ol>


@if( $icaneditstudent )
<div class="row page-title-row" >
	<div class="col-md-11"><p>请输入学号，可以批量输入，以英文逗号分隔</p></div>
	<div class="col-md-11">
	<form method="post" action="{{$cc .'/'. $ih->id. '/student'}}"  class="form-horizontal">
		{{ csrf_field() }}
		<textarea name="codes" rows="2" cols="form" class="form-control">{{old('codes')}}</textarea>
	</div>
	<div class="col-md-1">
		<input type="submit" value="保存" class="form-control" />
	</div>
	</form>
</div>
@endif


<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="10%">学号</th>
                <th width="10%">姓名</th>
              
                <th width="10%">班级</th>
                <th width="10%">院系</th>
			
                <th width="20%">操作</th>
            </tr>
        </thead>
   
		@foreach($list as $v)
        <tr>
            <td>{{$v->id}}</td>
            <td>{{$v->ucode}}</td>
            <td>{{$v->realname}}</td>
            <td>{{$v->classname}}</td>
            <td>{{$v->dname}}</td>
         
            <td>
				@if($icaneditstudent)
                <a href="{{ $cc .'/'.$ih->id.'/studentdestory?myid='.$v->id }}" class=" j_del" title="删除" data-title1="姓名" data-title2="{{$v->realname}}" data-title3="学生">
                    <i class="glyphicon "></i>删除
                </a>
				@endif
            </td>
        </tr>
		@endforeach
    </table>
</div>



<center>{!! $list->render() !!}</center>

</div>
@include('admin.partials._modals')









@stop


