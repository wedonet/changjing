<?php

require_once(base_path().'/resources/views/init.blade.php');

$data =& $j['data'];

$isedit = true;

?>


@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>学生管理</li>
</ol>



@include('admin.student.form')

{{--帮助中心--}}
@endsection

@section('scripts')
<script>

</script>
@endsection