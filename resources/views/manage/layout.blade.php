<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/images/s-logo.ico">

    <title>实践学分管理</title>

    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">



    <!-- Custom styles for this template -->
    <link href="/css/base.css" rel="stylesheet">
	<link href="/css/main.css" rel="stylesheet">
	<link href="/css/admin.css" rel="stylesheet">
    <link href="/css/index.css" rel="stylesheet">

	
	<link href="/bootstrap/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


    <script src="/js/jquery-1.12.4.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>

	<script type="text/javascript" src="/bootstrap/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
	<script type="text/javascript" src="/bootstrap/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>

	@yield('scripts')


    <script src="/js/main.js"></script>
	<script src="/js/app.js"></script>

	<script src="/ajaxfileupload/ajaxfileupload.js"></script>

	<script src="/plus/toastr/toastr.min.js"></script>
	<link rel="stylesheet" href="/plus/toastr/toastr.min.css">
</head>

<body>
@include('common.info')
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header col-md-2">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#userLogin" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

                <a class="navbar-brand topLogoBox topCenter" href="/manage" style="color:#fff;">
                   <img src="/images/1.png" height="50" />
                </a>


        </div>
        <div  id="userLogin" class="collapse navbar-collapse hidden">
            <ul class="nav navbar-nav navbar-right ">

                <li class="ader "><span>
				@if( 'counsellor' == $_ENV['user']['role'] )
				{{$_ENV['user']['dname'] .' 辅导员 ' . $_ENV['user']['realname']}}
				@else
				{{$_ENV['user']['dname'] .' ' . $_ENV['user']['rolename']}}
				@endif
				</span></li>
                <li class="zhuxiao "><a href="/loginout" class="btn btn-warning">注销</a></li>
				<li class="zhuxiao "><a href="/" class="btn btn-warning">首页</a></li>
            </ul>
            <div class=" col-sm-3 col-md-2 col-xs-12 sidebar open" >
                @include('manage.left')
                <b class="clickHide hidden-xs"></b>
            </div>

        </div>
    </div>

</nav>

<div class="container-fluid">
    <div class="row">

        <div class="col-sm-offset-3   col-md-10 col-md-offset-2 main">
			<div></div>
            @yield('content')
           
            <div class="footer" style="border-top:1px solid #eee;margin:20px 0 20px 0;text-align:center;padding-top:20px;"> <span class="getTime"></span>Runtime <?php echo round(microtime(true) - LARAVEL_START, 4); ?> Second</div>
            <p class="getTimeBox"></p>
        </div>
    </div>

</div>
<a href="javascript:;" id="goTop"  >返回顶部</a>



















</body>
</html>
