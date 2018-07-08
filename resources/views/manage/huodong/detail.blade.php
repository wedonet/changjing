<?php

require_once(base_path().'/resources/views/init.blade.php');

$data =& $j['data'];

/*活动详情*/
$tab = 'tab_detail';
$aid = $j['aid'];


/*下面注入每个选项卡的操作*/
?>
@section('operate')
	{{--审核通过，且未结束的才能操作--}}
	@if((time()<$data->plantime_two) )
		@if(0==$data->isopen)
		<a href="{{ $cc .'/' . $aid .'/isopen' }}" class="btn btn-info btn-sm j_confirm hidden" title="开通">开通</a>
		@endif

		@if(1==$data->isopen)
			<a href="{{ $cc .'/' . $aid .'/unopen' }}" class="btn btn-warning btn-sm j_confirm hidden" title="关闭">关闭</a> &nbsp; 
		@endif
	@endif

@endsection


@extends('manage.layout')


@section('content')
<ol class="crumb clearfix">
    <li><a href="/manage/huodong">活动管理</a></li>
	<li> - {{$data->title}}</li>	
</ol>

@include('manage.huodong.tab')


<div class="toptip clearfix margintop1" >
	<div class="floatleft"><strong>开通状态</strong> &nbsp; <span class="j_open_{{$data->isopen}}">{{openstatus($data->isopen)}}</span>  </div>
</div>


<div class="panel panel-info">


    <div class="panel-body" >
		@include('pub.huodongdetail')

    </div>
</div>
@stop

@section('scripts')

@endsection

