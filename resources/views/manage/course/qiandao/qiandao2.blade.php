<?php
require_once(base_path() . '/resources/views/init.blade.php');

$tab = 'tab_qiandao';


$studentsignin = & $oj->studentsignin;

function issignin(&$studentsignin, $ucode) {
    if (isset($studentsignin->$ucode)) {
        return '是';
    } else {
        return '';
    }
}

// end func

function signintime(&$studentsignin, $ucode) {
    if (isset($studentsignin->$ucode)) {
        return formattime2($studentsignin->$ucode->signintime);
    } else {
        return '';
    }
}

// end func

/* 下面注入每个选项卡的操作 */
?>
@section('operate')
<a href="{{ $cc.'/'.$oj->classid.'/allsignin?courseid='.$oj->course->id }}" rel="myform" class="btn btn-default btn-sm j_batch" type="button">批量签到</a>
<a href="{{ $cc.'/'.$oj->classid.'/export?courseid='.$oj->course->id.'&amp;classorder='.$oj->classorder.'&amp;classid='.$oj->classid }}" class="btn btn-default btn-sm" type="button">导出签到人员</a>
<a class="btn btn-default btn-sm" href="{{ $cc.'/'.$oj->classid.'/signincode?courseid='.$oj->course->id }}" role="button">签到码</a>
<a class="btn btn-warning btn-sm hidden" href="/manage/coursesignoffcode/?course={{$oj->course->id }}" role="button">签退码</a>
@endsection


@extends('manage.layout')


@section('content')



<ol class="crumb clearfix">
    <li><a href="/manage/course">课程管理</a></li>
    <li> - {{$oj->course->title}}</li>	
    <li> - 第{{$oj->classorder}}课</li>	
</ol>

@include('manage.course.tab')

<div class="toptip clearfix margintop1" >
    <div class="floatleft">应到:{{$oj->yingdao}} 人 &nbsp; 实到:{{$oj->shidao}} 人 </div>
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

        <form action="" method="post" id="myform">
            {!! csrf_field() !!}
            <table class="table table-striped table-hover" id="j_list" >
                <thead>
                    <tr>
                        <th width="2%"> <input type="checkbox" id="contrasel" class="blankCheckbox" aria-label="..." /></th>

                        <th width="7%">姓名</th>		
                        <th width="7%">学号</th>	
                        <th width="7%">学院</th>
                        <th width="7%">性别</th>



                        <th width="4%">签到</th>      
                        <th width="7%">入场时间</th>
                        <th width="7%" class="hidden">退场时间</th>
                        <th width="10%">操作</th>	
                    </tr>
                </thead>

                @foreach($list as $v)
                <tr>
                    <td>
                        <input type="checkbox" name="ids[]" class="blankCheckbox" value="{{$v->ucode}}" aria-label="..." />
                    </td>

                    <td>{{$v->realname}}</td>  
                    <td>{{$v->ucode}}</td> 
                    <td>{{$v->dname}}</td> 
                    <td>{{$v->gender}}</td> 


                    <td>{{issignin($studentsignin, $v->ucode)}}</td>
                    <td>{{signintime($studentsignin, $v->ucode)}}</td>

                    <td>
                        @if(strlen( issignin($studentsignin, $v->ucode) )<1 )
                        <a href="{{$cc . '/'.$v->ucode.'/signin?courseid='.$oj->course->id.'&amp;classid='.$oj->classid}}">
                            签到
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach

            </table>
        </form>
        <center>{!! $list->render() !!}</center>
    </div>
</div>

@stop

@section('scripts')

@endsection