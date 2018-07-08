<?php

require(base_path().'/resources/views/init.blade.php');

?>

@extends('student.layout')


@section('content')

<ol class="crumb clearfix">
    <li>我的校内荣誉</li>
</ol>

<div class="row page-title-row" >
    <div class="col-md-6">
		
    </div>	
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list">
        <thead>
        <tr>
            <th width="5%">#</th>
            <th width="10%">名称</th>
            <th width="10%">学分</th>
        </tr>
        </thead>
		@foreach($list as $v)
        
            <tr>
                <td>{{$v->id}}</td>
                <td>{{$v->title}}</td>
                <td>{{$v->actualcredit/1000}}</td>
            </tr>
       @endforeach


	
    </table>
</div>







@include('admin.partials._modals')


@stop


