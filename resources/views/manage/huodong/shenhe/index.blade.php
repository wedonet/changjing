<?php
require_once(base_path() . '/resources/views/init.blade.php');





$tab = 'tab_shenhe';
$auditstatus = $j['search']['auditstatus'];
$aid = $j['aid'];
$activity = $j['activity'];
$myurl = $cc.'?activityid='.$aid;


$para['activityid'] = $aid;

/* 下面注入每个选项卡的操作 */
?>
@section('operate')
<a href="javascript:;" class="btn btn-default btn-md hidden" type="button">新增</a>
<a href="javascript:void(0);" class="btn btn-default btn-md " type="button" id="allpass">批量审核</a>
<a href="{{$cc}}/import?activityid={{$aid}}" class="btn btn-default btn-md " type="button">导入报名</a>
<a href="{{$cc}}/export?activityid={{$aid}}" class="btn btn-default btn-md " type="button">导出报名</a>
<a href="javascript:;" class="btn btn-default btn-md hidden" type="button">参与人员删除</a>
<a href="javascript:;" class="btn btn-default btn-md hidden" type="button">导入参与名单</a> 
<a href="javascript:;" class="btn btn-default btn-md hidden" type="button">导出</a> 
@endsection


@extends('manage.layout')


@section('content')



<ol class="crumb clearfix">
    <li><a href="/manage/huodong">活动管理</a></li>
    <li> - {{$activity->title}}</li>	
</ol>





@include('manage.huodong.tab')




<div class="toptip clearfix margintop1" >
    <div class="floatleft">
        人数限制：{{personlimit($activity->signlimit)}} &nbsp; 
        报名:{{$activity->signcount}}  &nbsp; 
        审核通过:{{$activity->checkcount}} 
    </div>
</div>



<div class="row page-title-row margintop2" >
    <div class="col-md-8 ">

        <form action="{{$cc}}" method="get">
            {!! csrf_field() !!}
            <input type="hidden" name="activityid" value="{{$aid}}" />
            <div class="form-group input-group" style="float:left;width:26%;margin-right:5px;">

                <input type="text" placeholder="请输入学号/姓名" autocomplete="off" class=" form-control" name="ucode" 
                       value="{{ $j['search']['ucode'] }}" />
                <ul class="vagueSearchBox"></ul>
            </div>

            <input type="submit" value="查询" class="btn btn-info" />
        </form>
    </div>

	<div class="col-md-4 ">

	</div>
</div>


<div>
	<div class="pull-left">
    <a href="{{$cc . '?aid=' . $aid }}" class="" id="j_auditstatus_">全部</a>
    &nbsp;&nbsp;&nbsp;&nbsp;<a href="{{$currentcontroller . '?aid=' . $aid . '&amp;auditstatus=new' }}" id="j_auditstatus_new">待审核</a> 
    &nbsp;&nbsp;&nbsp;&nbsp;<a href="{{$currentcontroller . '?aid=' . $aid . '&amp;auditstatus=pass' }}" id="j_auditstatus_pass">审核通过</a> 
    &nbsp;&nbsp;&nbsp;&nbsp;<a href="{{$currentcontroller . '?aid=' . $aid . '&amp;auditstatus=unpass' }} " id="j_auditstatus_unpass">未通过</a> 
	</div>

</div>






<div class="panel panel-info margintop3">	


    <div class="table-responsive">


        <form action="{{$myurl}}" method="post" id="myform">
            {!! csrf_field() !!}
            <table class="table table-striped table-hover" id="j_list" >
                <thead>
                    <tr>
                        <th width="2%">
                            <input type="checkbox" class="blankCheckbox" value="option1" id="contrasel" aria-label="...">
                        </th>

                        <th width="7%">姓名</th>		
                        <th width="7%">学号</th>	
                        <th width="6%">学院</th>
                        <th width="3%">性别</th>

                    
                        <th width="7%">报名时间</th>
                        <th width="10%">申请陈述</th>

                        <th width="6%">审核状态</th>
                        <th width="12%">操作</th>	
                    </tr>
                </thead>

                @foreach($list as $v)

                <tr>
                    <td>
                        <input type="checkbox" class="blankCheckbox"  name="ids[]" value="{{$v->id}}" aria-label="...">
                    </td>

                    <td>{{$v->realname}}</td>  
                    <td>{{$v->ucode}}</td> 
                    <td>{{$v->dname}}</td> 
                    <td>{{$v->gender}}</td> 
             
                    <td>{{$v->created_at}}</td>
                    <td>
						{{$v->mystate}}
						@if('unpass' == $v->auditstatus)
						<div style="border-top:1px solid #ddd"><span class="alarm">{{$v->myexplain}}</span>
						@endif
					</td> 
                    <td class="auditstatus_{{$v->auditstatus}}">{{checkstatus($v->auditstatus)}}</td> 
                    <td>
                        <a href="{{$currentcontroller}}/{{$aid}}/show/{{$v->id}}" class="j_open hidden">
                            查看
                        </a>&nbsp; 


                        @if( 'pass' != $v->auditstatus)
                        <a href="{{$currentcontroller}}/{{$v->id}}/dopass?activityid={{$aid}}" class="j_confirmpost" title="审核通过">
                            通过
                        </a>&nbsp;
                        @endif

                        @if( 'unpass' != $v->auditstatus)
                        <a href="{{$currentcontroller}}/{{$v->id}}/unpass?activityid={{$aid}}" class="j_open">
                            未通过
                        </a> 	
                        @endif



                    </td>
                </tr>
                @endforeach


            </table>
        </form>
    </div>
	
    <center>{!! $list->render() !!}</center>
</div>

@stop

@section('scripts')
<script>
<!--
    $(document).ready(function () {
        $('#j_auditstatus_{{$auditstatus}}').addClass('btn').addClass('btn-success');

        /*批量审核*/
        $('#allpass').on('click', function () {
            $('#myform').attr('action', '{{$cc}}/allpass?activityid={{$aid}}').submit();
        })
    })
//-->
</script>
@endsection