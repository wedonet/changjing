@extends('layoutmobile')


@section('content')
	

<div class="container-fluid top1">
	<h2 class="text-center" style="margin:0 0 50px 0">请输入学号和密码签到</h3>



	<form class="form-horizontal" action="/coursedosignin" method="post" >
		{!! csrf_field() !!}
		<input type="hidden" name="signcode" value="{{$oj->signcode}}" >



		<div class="form-group">
			<label class="col-xs-3 control-label">学 号:</label>
			<div class="col-xs-9">
				 <input type="text" name="code"  placeholder="学号" class="form-control" value="{{old('code')}}" required="required"  />
			</div>
		</div>


		<div class="form-group">
			<label class="col-xs-3 control-label">密 码: </label>
			<div class="col-xs-9">
				<input type="password" name="upass"  placeholder="密码" class="form-control" required="required" />
			</div>
		</div>



		<div class="form-group">
			<div class="col-xs-offset-3 col-sm-10">
				<input type="submit" class="btn btn-default" value=" 提 交 "></button>
			</div>
		</div>
		

	</form>
</div>
@stop