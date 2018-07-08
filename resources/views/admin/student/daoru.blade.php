<?php

require_once(base_path().'/resources/views/init.blade.php');

?>

@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li>学生管理</li>
	<li> - 添加学生</li>
</ol>





<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">批量导入</div>
    </div>

    <div class="panel-body" >
        <form method="POST" action="/adminconsole/student/daoru" enctype="multipart/form-data" >
            {!! csrf_field() !!}
            <h3>导入Excel表：</h3><input  type="file" name="photo" />

            <input type="submit"  value="导入" />
        </form>
    </div>

</div>

@stop

@section('scripts')
<script>



</script>
@endsection