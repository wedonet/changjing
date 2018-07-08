<?php
require_once(base_path() . '/resources/views/init.blade.php');

$tab = 'tab_qiandao';

/* 下面注入每个选项卡的操作 */
?>
@section('operate')
<a href="javascript:;" class="btn btn-default btn-sm hidden" type="button">批量签到</a>
<a href="javascript:;" class="btn btn-default btn-sm  hidden" type="button">批量签退</a> 
<a href="/manage/qiandao_daochu" class="btn btn-default btn-sm hidden" type="button">导出签到人员</a>
<a class="btn btn-success btn-sm hidden" href="/manage/qiandao/" role="button">签到码</a>
<a class="btn btn-warning btn-sm hidden" href="/manage/qiantui/" role="button">签退码</a>
@endsection


@extends('manage.layout')


@section('content')



<ol class="crumb clearfix">
    <li><a href="/manage/course">课程管理</a></li>
    <li> - {{$oj->course->title}}</li>	
</ol>





@include('manage.course.tab')




<div class="toptip clearfix margintop1" >
    <div class="floatleft">&nbsp;</div>
</div>




<div class="row page-title-row margintop2 hidden" >
    <div class="col-md-12 ">
        <form action="" method="POST">
            {!! csrf_field() !!}
            <div class="form-group input-group" style="float:left;width:26%;margin-right:5px;">

                <input type="text" placeholder="请输入学号/姓名" autocomplete="off" class=" form-control" name="product_name" value=""/>
                <ul class="vagueSearchBox"></ul>
            </div>

            <input type="text" value="查询" class="btn btn-info" />
        </form>
    </div>
</div>


<div class="hidden">
    当前状态： <a href="#" class="btn btn-success">全部</a>
    &nbsp;&nbsp;&nbsp;&nbsp;<a href="#">已签到</a> 
    &nbsp;&nbsp;&nbsp;&nbsp;<a href="#">未签到</a> 
</div>






<div class="panel panel-info margintop3">	


    <div class="table-responsive">


        <table class="table table-striped table-hover" id="j_list" >
            <thead>
                <tr>

                    <th width="5%">#</th>
                    <th width="10%">课时</th>		
                    <th width="7%">开始时间</th>	
                    <th width="7%">结止时间</th>


                    <th width="10%">操作</th>	
                </tr>
            </thead>

            @foreach($list as $v)
            <tr>
     
                <td>{{$loop->index+1}}</td>
                <td>第{{$loop->index+1}}课</td>  
                <td>{{formattime2($v->start_time)}}</td>
                <td>{{formattime2($v->finish_time)}}</td> 
                <td>
                    <a href="/manage/course_qiandao2?classid={{$v->id}}&amp;courseid={{$oj->course->id . '&amp;classorder=' . ($loop->index+1) }}">
                        进入
                    </a>
                </td>
            </tr>         
            @endforeach

        </table>

    </div>
</div>

@stop

@section('scripts')

@endsection