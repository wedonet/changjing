<?php
require_once(base_path() . '/resources/views/init.blade.php');



$tab = 'tab_shenhe';
$auditstatus = $oj->search->auditstatus;
$course = $oj->course;
$courseid = $oj->course->id;


/* 下面注入每个选项卡的操作 */
?>
@section('operate')

@endsection


@extends('admin.layout')


@section('content')



<ol class="crumb clearfix">
    <li>课程管理</li>
    <li> - {{$course->title}}</li>	
</ol>





@include('admin.course.tab')

<div class="toptip clearfix margintop1" >
    <div class="floatleft">
        人数限制：{{personlimit($course->signlimit)}} &nbsp; 
        报名:{{$course->signcount}}  &nbsp; 
        审核通过:{{$course->checkcount}} 
    </div>
</div>


<div class="row page-title-row margintop2 hidden" >
    <div class="col-md-12 ">
        <form action="{{$cc}}" method="get" class="form-inline search j_search">
            {!! csrf_field() !!}
            <input type="hidden" name="courseid" value="{{$courseid}}" />
            <input type="hidden" name="auditstatus" value="{{$auditstatus}}" />

            <a href="javascript:void(0)" rel="auditstatus" data="">全部</a>
            <a href="javascript:void(0)" rel="auditstatus" data="new">待审核</a> 
            <a href="javascript:void(0)" rel="auditstatus" data="pass">审核通过</a> 
            <a href="javascript:void(0)" rel="auditstatus" data="unpass">未通过</a> 


            <input type="text" placeholder="请输入学号/姓名" autocomplete="off" class=" form-control hidden" name="product_name" value=""/>

            <input type="submit" value="查询" class="btn btn-info hidden" />
        </form>
    </div>
</div>

<div class="panel panel-info margintop3">	


    <div class="table-responsive">
        <form action="" method="post" id="myform">
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
                    <td>{{$v->mystate}}</td> 
                    <td class="auditstatus_{{$v->auditstatus}}">{{checkstatus($v->auditstatus)}}</td> 
                    <td>
                        <a href="{{$currentcontroller}}/{{$courseid}}/show/{{$v->id}}" class="j_open hidden">
                            查看
                        </a>&nbsp; 

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
        //$('#j_auditstatus_{{$auditstatus}}').addClass('btn').addClass('btn-success');

        /*批量审核*/
        //$('#allpass').on('click', function () {
        //    $('#myform').attr('action', '{{$currentcontroller}}/{{$course->id}}/allpass').submit();
        //})
    })
//-->
</script>
@endsection