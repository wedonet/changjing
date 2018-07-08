<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/images/s-logo.ico">

    <title>{{$title}}</title>

    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    {{--日期选择器--}}
    <link rel="stylesheet" href="/css/lq.datetimepick.css"/>
    <!-- Custom styles for this template -->
    <link href="/css/base.css" rel="stylesheet">
	<link href="/css/main.css?2" rel="stylesheet">
    <link href="/css/index.css" rel="stylesheet">
    <link href="/css/city.css" rel="stylesheet">
    <link href="/css/city-picker.css" rel="stylesheet">

	<!--[if lt IE 9]><script src="../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
	<script src="/bootstrap/js/ie-emulation-modes-warning.js"></script>



    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


    <script src="/js/jquery-1.12.4.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>


    <script src="/js/main.js"></script>

    <script src="/js/app.js"></script>

    @yield('scripts')

	<style>
		@media print{
			.print {display:none}
		}
	</style>

</head>

<body>

<div>
<div class="container-fluid">
	@yield('content')
</div>
</div>

           




















</body>
</html>
