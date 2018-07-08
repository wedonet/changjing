<?php

require(base_path().'/resources/views/init.blade.php');

?>

@extends('manage.layout')


@section('content')

<ol class="crumb clearfix">
    <li>履职修业管理</li>
	<li> - 选择学生</li>
</ol>





<div class="panel panel-info">
    <div class="panel-body" >
        <form method="get" action="{{ $cc . '/select_' }}" class="form-horizontal"  role="form">
            {!! csrf_field() !!}

            <div class="form-group">
                <label class="col-md-4 control-label" for="title">请输入学号支持模糊搜索</label>
                <div class="col-md-3">
                    <input type="text" placeholder="学号 3-10 位" required="required" class="form-control" name="ucode" value="{{$oj->search->ucode Or ''}}">
                </div>
                <input type="submit" class="btn btn-info j_slowsubmit" value=" 搜 索 " disabled="disabled" />
            </div>  
        </form>
    </div>
</div>



@if( isset($oj->list) )

	<table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="10%">学号</th>
                <th width="10%">姓名</th>
              
                <th width="10%">班级</th>
                <th width="10%">院系</th>
	
                <th width="8%">操作</th>
            </tr>
        </thead>
   
		@foreach($list as $v)
        <tr>
            <td>{{$v->id}}</td>
            <td>{{$v->mycode}}</td>
            <td>{{$v->realname}}</td>
            <td>{{$v->classname}}</td>
            <td>{{$v->dname}}</td>
   
            <td>
                <a href="{{$cc.'/create?ucode='.$v->mycode.'&amp;realname='.urlencode($v->realname)}}" >选择
                    
                </a> 
            </td>
        </tr>
		@endforeach
    </table>

	 <center>{!! $list->render() !!}</center>
@endif



@stop

@section('scripts')
<script>

</script>
@endsection