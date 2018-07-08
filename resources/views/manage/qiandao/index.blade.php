
@extends('layoutmobile')

@section('content')




<div style="width:500px; margin:0 auto;text-align:center;">
	<h1>{{$oj->title}}</h1>
	<div><a href="javascript:window.history.back();">返回上一页</a></div>

	

	<div>
		<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(500)->generate($oj->url)) !!} ">
	</div>
	<div style="color:#bbb">
	{{$oj->url}}
	</div>
</div>

@endsection















</body>
</html>
