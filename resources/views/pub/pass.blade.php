<?php

/*修改密码*/

require_once(base_path().'/resources/views/init.blade.php');

if('student' == $oj->gic){
	$frame = 'student.layout';
}else{
	$frame = 'admin.layout';
}

?>

@extends($frame);


@section('content')

<ol class="crumb clearfix">
    <li>个人资料</li>
	<li> - 修改密码</li>
</ol>





<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">修改密码 -- 修改成功后将跳转到登录页重新登录</div>
    </div>

    <div class="panel-body" >
        <form method="POST" action="{{ $_SERVER['REQUEST_URI']  }}" class="form-horizontal"  role="form">
            {!! csrf_field() !!}


            <div class="form-group">
                <label class="col-md-4 control-label" for="title">原密码</label>
                <div class="col-md-3">
                    <input type="password"  required="required" class="form-control" name="upass"  value="{{old('upass')}}">
                </div>
        
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="title">新密码</label>
                <div class="col-md-3">
                    <input type="password" required="required" class="form-control" name="newpass" value="">
                </div>
           
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="title">确认新密码</label>
                <div class="col-md-3">
                    <input type="password"  required="required" class="form-control" name="newpass_confirmation" value="">
                </div>        
            </div>


            <div class="form-group">
                <label class="col-md-4 control-label" for="submit"></label>
                <div class="col-md-3">
                    <input type="submit" class="btn btn-info j_slowsubmit" value=" 提 交 " disabled="disabled" />
                </div>
            </div>


        </form>
    </div>
</div>

@stop

@section('scripts')
<script>

</script>
@endsection