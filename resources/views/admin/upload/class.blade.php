<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>上传</title>

        <!-- Bootstrap core CSS -->
        <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="/css/base.css" rel="stylesheet">
        <link href="/css/index.css" rel="stylesheet">


        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Bootstrap core JavaScript ================================================== -->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="/js/jquery-1.12.4.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="/bootstrap/js/bootstrap.min.js"></script>

        <script src="/js/main.js"></script>
        <script src="/js/app.js"></script>

        <base target="main" />
    </head>
    <body>	


        <div class="uploadClass">
            <ul class="fileclass" id="fileclass">

                <li><a href="/adminconsole/upload/list?act=list&amp;ftype=1&amp;classid=0">默认分类</a></li>

                <li><a href="/adminconsole/upload/list?act=list&amp;ftype=1&amp;classid=-1">所有分类的记录</a></li>


            </ul>
        </div>
        <script>
            $('#fileclass li:first a').addClass('on');

            $('#fileclass a').bind('click', function () {
                $('#fileclass a.on').removeClass('on');
                $(this).addClass('on');
            })
        </script>
    </body>
</html>
