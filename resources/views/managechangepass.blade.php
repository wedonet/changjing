<!DOCTYPE html>
<html>
<head>
    <title>首次登录修改密码</title>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no"/>
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/index.css" rel="stylesheet">
    <link href="/css/city.css" rel="stylesheet">
    <link href="/css/city-picker.css" rel="stylesheet">
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
		<div style="text-align:center;font-weight:bold;">修改密码</div>

        <div class="login-content ">
            <div class="form">

				@include('common.errorsLogin')

                <form action="managechangepass" method="post" class="j_form">
					{!! csrf_field() !!}
					<input type="hidden" name="oldpass" value="{{$j['user']->oldpass}}" />

                    <div class="form-group">
                        <div class="col-xs-12  ">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                <input type="text" name="uname" required="required" class="form-control col-xs-10" value="{{ $j['user']->uname }}">
                            </div>
                        </div>
                    </div>

					<div class="form-group">
                        <div class="col-xs-12  ">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                <input type="password" onfocus="this.type='password'" required="required" name="upass" class="form-control" autocomplete="off" placeholder="请输入新密码">
                            </div>
                        </div>
                    </div>

					<div class="form-group">
                        <div class="col-xs-12  ">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                <input type="password" onfocus="this.type='password'" required="required" name="upass_confirmation" class="form-control" autocomplete="off" placeholder="请再次输入新密码">
                            </div>
                        </div>
                    </div>


                    <div class="form-group loginBtn">
                        <button type="submit" class="btn btn-sm btn-info loginButton2 col-xs-12 col-md-7"> 提 交 </button>
                        <button type="reset" class="btn btn-sm btn-danger loginButton1 col-xs-12 col-md-3">重 置</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
