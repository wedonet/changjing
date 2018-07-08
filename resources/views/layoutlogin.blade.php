<!DOCTYPE html>
<html>
<head>
    <title>{{$title}}</title>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no"/>
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link href="/css/base.css" rel="stylesheet">
	<link href="/css/main.css" rel="stylesheet">
    <link href="/css/index.css" rel="stylesheet">

    <link rel="icon" href="/images/s-logo.ico">
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="/js/jquery-1.12.4.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>

    <script src="/js/main.js"></script>
    <script src="/js/app.js"></script>
    <style>
        html,body {
            height: 100%;
        }
    </style>

</head>

<body>

 @include('common.info')

<div class="box">
    <div class="center-block login-box">

		<div style="text-align:center;font-weight:bold;">{{$title}}</div>
        <div class="login-content ">
            <div class="form">

               
                @yield('content')
            </div>
        </div>
    </div>
</div>

</body>
</html>
