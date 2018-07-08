<?php

require_once(base_path().'/resources/views/init.blade.php');




/*活动详情*/
$tab = 'tab_detail';
$j['aid'] = $oj->data->id;
$j['activity'] =& $data;

$activity =& $oj->data;

$oj->activity =& $activity;
$aid = $activity->id;

?>

@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>活动管理</li>
	<li>-> {{$j['activity']->title}}</li>
</ol>

@include('admin.huodong.tab')




<div class="panel panel-info">
	@include('pub.huodongdetail')
</div>

@stop

@section('scripts')
<script>
$(function () {
            $("#date1").on("click",function(e){
                e.stopPropagation();
                $(this).lqdatetimepicker({
                    css : 'datetime-day',
                    dateType : 'D',
                    selectback : function(){

                    }
                });
            });
})
</script>
@endsection