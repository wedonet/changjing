<?php
/* 开课审核 */
require_once(base_path() . '/resources/views/init.blade.php');
$auditstatus = $oj->search->auditstatus;
?>

@extends('manage.layout')

@section('content')

<ol class="crumb clearfix">
    <li><a href="kecheng">课程审核</a></li>		
</ol>


<div class="page-title-row" >
    <form action="{{$cc}}" method="get" class="form-inline search j_search">
        {!! csrf_field() !!}
        <input type="hidden" name="auditstatus" value="{{$auditstatus}}" /> 
        
        <a href="javascript:void(0)" rel="auditstatus" data="" >全部</a>
        <a href="javascript:void(0)" rel="auditstatus" data="new">待审核</a> 
        <a href="javascript:void(0)" rel="auditstatus" data="pass">已通过</a> 
        <a href="javascript:void(0)" rel="auditstatus" data="unpass">未通过</a>                
    </form>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list">
        <thead>
            <tr>
                <th width="2%">#</th>
                <th width="14%">名称</th>		
                <th width="6%">类型</th>	
                <th width="6%">发起部门</th>	
                <th width="8%">开课时间</th>

                <th width="5%">人数限制</th>
                <th width="6%">审核状态</th>
                <th width="6%">当前状态</th>
                <th width="12%">操作</th>
            </tr>
        </thead>

        @foreach($list as $v)
        <tr>
            <td><input type="checkbox" id="" /></td>
            <td>{{$v->title}}</td>  
            <td>{{$v->type_onename}}/{{$v->type_twoname}}</td>
            <td>{{$v->suname}}</td>	
            <td>{{formattime1($v->plantime_one)}}</td>			

            <td>{{(0==$v->signlimit)? '无' : $v->signlimit}}</td> 
            <td class="j_audit_{{ ($v->auditstatus) }}">{{ checkstatus($v->auditstatus) }}</td> 

            <td class="">{{ timetocurrentstatus($v->plantime_one, $v->plantime_two) }}</td> 

            <td>
                <a href="{{$currentcontroller .'/'. $v->id }}">
                    详情&amp;审核
                </a>
            </td>
        </tr>
        @endforeach



    </table>
</div>







@include('admin.partials._modals')


@stop


