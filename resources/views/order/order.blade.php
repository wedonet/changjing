<?php

require_once(base_path().'/resources/views/init.blade.php');

$title = $j['title'];

?>

@extends('common._modals')

@section('content')
{{$j['info']}}

@stop
@section('style')
<style>

</style>

@stop