<!DOCTYPE html>
<html>
<head>
    <title>教师登录</title>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no"/>
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="/css/main.css" rel="stylesheet">
    <link href="/css/index.css" rel="stylesheet">

    <link rel="icon" href="/images/s-logo.ico">
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="/js/jquery-1.12.4.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
    <script src="/js/main.js"></script>
    <script src="/js/app.js"></script>


    <style>
        html,body {
            height: 100%;
        }
    </style>

</head>

<body>
<div class="box">
    <div class="center-block login-box">
		<div style="text-align:center;font-weight:bold;">教师登录</div>

        <div class="login-content ">
            <div class="form">

                @include('common.errorsLogin')

                <form action="managelogin" method="post" class="j_form">
					{{ csrf_field() }}

                    <div class="form-group">
                        <div class="col-xs-12  ">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                <input type="text" name="uname" required="required" class="form-control col-xs-10" placeholder="请输入教师登录名"  value="{{ old('username') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12  ">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                <input type="password" onfocus="this.type='password'" required="required" name="upass" class="form-control" autocomplete="off" placeholder="请输入教师密码">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
						<div class="col-xs-12">
							<input type="submit" class="btn btn-sm btn-success  col-xs-12 j_slowsubmit" disabled="disabled" value="登 录" />
						</div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
