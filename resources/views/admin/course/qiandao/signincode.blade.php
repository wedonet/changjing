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

    <title>活动签到</title>

    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/base.css" rel="stylesheet">
	<link href="/css/main.css" rel="stylesheet">
    <link href="/css/index.css" rel="stylesheet">




    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


    <script src="/js/jquery-1.12.4.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>

    <script src="/js/main.js"></script>
</head>

<body>




<div style="width:500px; margin:0 auto;text-align:center;">
	<div>
		<a href="javascript:window.history.back();">返回上一页</a>
		<span class="hidden">打印</span>
	</div>

	

	<div>
		<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(500)->generate($oj->url)) !!} ">

	</div>
	<div style="color:#bbb">
	{{$oj->url}}
	</div>
</div>

















</body>
</html>
