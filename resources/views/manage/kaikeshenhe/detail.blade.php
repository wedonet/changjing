<?php
/* 课程审核 详情 */
require_once(base_path() . '/resources/views/init.blade.php');
?>

@extends('manage.layout')           

@section('content')

<ol class="crumb clearfix">
    <li>课程审核</li>
    <li>/ {{$data->title}}</li>
</ol>


<div class="row page-title-row" >


    <div class="col-md-6">

    </div>
    <div class="col-md-6 text-right" >
        @if('pass' <> $data->auditstatus)
        <a href="{{$currentcontroller}}/{{$data->id}}/dopass" class="btn btn-success btn-md j_confirmpost" title="{{$data->title}} 通过审核" type="button">
            审核通过
        </a>
        @endif

        @if('unpass' <> $data->auditstatus)
        <a href="{{$currentcontroller}}/{{$data->id}}/unpass"  class="btn btn-warning btn-md j_open" type="button">
            未通过
        </a>  
        @endif
    </div>	
</div>


<ul class="nav nav-tabs j_nav navmanage">
    <li role="presentation" class="active"><a href="javascript:void(0)" rel="block_detail">详细信息</a></li>
    <li role="presentation"><a href="javascript:void(0)" rel="block_hour">开课时间</a></li>
    <li role="presentation"><a href="javascript:void(0)" rel="block_audit">审核记录</a></li>
</ul>


{{--详细信息--}}
<div class="panel panel-info navblock" id="block_detail">
    <div class="toptip clearfix margintop1" >
        <div class="floatleft"><strong>开通状态</strong> &nbsp; <span class="j_open_{{$data->isopen}}">{{openstatus($data->isopen)}}</span>  </div>
    </div>
    <div class="panel panel-info">
        @include('pub.coursedetail')
    </div>
</div>

{{--开课时间--}}
<div class="panel panel-info navblock hidden" id="block_hour">
    <div class="panel panel-info">
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="j_list">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="12%"></th>
                        <th width="30%">时间</th>
                        <th width="*">地点</th>
                        <th width="15%">操作</th>
                    </tr>
                </thead>


                @foreach($oj->courses_hour as $v)
                <tr>
                    <td>{{$v->id}}</td>
                    <td>第{{$loop->index+1}}课</td>
                    <td>{{formattime2($v->start_time) . ' 至 ' . formattime2($v->finish_time)}}</td> 
                    <td>{{$v->myplace}}</td> 
                </tr>
                @endforeach			
            </table>
        </div>
    </div>
</div>



{{--审核记录--}}
<div class="panel panel-info navblock hidden" id="block_audit">
    <div class="panel panel-info">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="12%">审核部门</th>
                        <th width="30%">审核结果</th>
                        <th width="*">说明</th>
                        <th width="*">时间</th>
                    </tr>
                </thead>


                @foreach($oj->audit as $v)
                <tr>
                    <td>{{$v->id}}</td>
                    <td>{{ showdepartment($oj->departmentofic,$v->dic) }}</td> 
                    <td>{{checkstatus($v->myeventv)}}</td>			
                    <td>{{$v->myexplain}}</td> 
                    <td>{{formattime2($v->ctime)}}</td> 
                </tr>
                @endforeach			
            </table>
        </div>		
    </div>
</div>







<div class="modal fade" id="modalunpass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">请填写审核未通过原因</h4>
            </div>
            <div class="modal-body">
                <form>
                    {!! csrf_field() !!}
                    <textarea id="" rows="4" cols="30"></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>






@stop






















@section('scripts')
<script>
    $(function () {
        $(document).ready(function () {
            $('#unpass').on('click', function () {
                $('#modalunpass').modal('show');

            })
        })
    })
</script>
@endsection