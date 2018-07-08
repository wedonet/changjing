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
        <link rel="stylesheet" href="/css/index.css"/>



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
        <script src="/js/app.js"></script>
        <script src="/js/main.js"></script>
        

    </head>
    <body>
    <p>@include('common.errors')</p>
    <div class="listfilter">

        <div style="display:inline;float:left;display:none;">{$classname} &nbsp;</div>

        <form method="post" action="/adminconsole/upload" enctype="multipart/form-data" id="up" style="display:inline;">
			{!! csrf_field() !!}
            <input type="file" size="20" name="file1" value="浏览" style='width:180px' />
            <span style="color:red;">(格式：jpeg,jpg,png)</span>
            <input type="submit" value="提交" class="submit" id="submitimage" />
        </form>

    </div>
    <p>点击选择需要的图片</p>
    <ul class="picture">
         @foreach($list as $v)
            <li>
                <div class="imgborder"><a href="{{ $v->urlfile }}" target="_blank" class="url" rel="{{ $v->preimg }}"><img src="{{ $v->preimg }}" alt="" class="fileimg" /></a></div>
                <div class="center" style="width:100%;overflow:hidden">
                    <span class="j_filesize">尺寸:{{ $v->imgwidth }}*{{ $v->imgheight }}</span>
                    <br/>
                    <span id="title_{$id}">大小:{{ $v->filesize }}K</span>
                </div>
            </li>
        @endforeach

    </ul>
    <div class="clear"></div>
    <div class="line2"></div>
    <div class="page">
        {!! $list->appends(['batchid' => 2])->render() !!}
    </div>
    <p></p>
    @include('admin.partials._modals')
    <script>
        $(document).ready(function () {

            //$(".fileimg").LoadImage(120, 90);

            formatfilelink();
        })
    </script>
    </body>
</html>
