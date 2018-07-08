<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">

<meta http-equiv="X-UA-Compatible" content="webkit,IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="/favicon.ico">
<title>天津外国语大学综合素质教育实践学分系统</title>

<!-- Bootstrap core CSS -->
<link rel="stylesheet" href="/css/reset.css"/>
<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" href="/css/main.css">
<link rel="stylesheet" href="/css/theme1.css"/>

<script src="/js/jquery-1.12.4.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script src="/js/main.js"></script>
<script src="/plus/toastr/toastr.min.js"></script>
<link rel="stylesheet" href="/plus/toastr/toastr.min.css">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>

<body class="bgbody">

<div class="container main" style="padding-left:0;padding-right:0;">
  <div class="header" style="position:relative">
    <div class="logo">
      <img src="/images/w/logo.png" width="100%" alt="" />	  
    </div>
	<div class="userstatus">
		@if( 'guest' != $_ENV['user']['gic'] )
			@if( 'student' == $_ENV['user']['gic'] )
			<span class="glyphicon glyphicon-user"></span> {{$_ENV['user']['realname']}} &nbsp;
			<span class="glyphicon glyphicon-log-out"></span> <a href="/loginout">退出</a>
			@endif

			@if( 'manager' == $_ENV['user']['gic'] )
			<span class="glyphicon glyphicon-user"></span> {{$_ENV['user']['rolename']}} &nbsp;
			<span class="glyphicon glyphicon-log-out"></span> <a href="/loginout">退出</a>
			@endif

			@if( 'admin' == $_ENV['user']['gic'] )
			<span class="glyphicon glyphicon-user"></span> 管理员 &nbsp;
			<span class="glyphicon glyphicon-log-out"></span> <a href="/loginout">退出</a>
			@endif
		@else
			<span class="glyphicon glyphicon-user"></span> 游客 &nbsp;       
			<span class="glyphicon glyphicon-time"></span> {{formattime2(time())}} &nbsp;  
		@endif
	 
	</div>
  </div>
</div>

<div class="container main">
  <div class="nav">
    <div class="row">
      <div class="col-sm-2">
        <a href="{{$basedir}}?type1=d" class="thum1"> <img src="/images/w/img1.png" alt=""> </a>
        <div class="caption">
          <a href="{{$basedir}}?type2=ds" class="f btn btn-info ds">思想道德</a> 
		  <a href="{{$basedir}}?type2=dz" class="r btn btn-info dz">责任担当</a>
        </div>
      </div>
      <div class="col-sm-2">
        <a href="{{$basedir}}?type1=y" class="thum1"> <img src="/images/w/img2.png" alt=""> </a>
        <div class="caption">
          <a href="{{$basedir}}?type2=yx" class="f btn btn-info">学业能力</a>
		  <a href="{{$basedir}}?type2=yz" class="r btn btn-info">职业能力</a>
        </div>
      </div>
      <div class="col-sm-2">
        <a href="{{$basedir}}?type1=z" class="thum1"> <img src="/images/w/img3.png" alt=""> </a>
        <div class="caption">
          <a href="{{$basedir}}?type2=zc" class="f btn btn-info">传承中国</a>
		  <a href="{{$basedir}}?type2=zz" class="r btn btn-info">中国情怀</a>
        </div>
      </div>
      <div class="col-sm-2">
        <a href="{{$basedir}}?type1=w" class="thum1"> <img src="/images/w/img4.png" alt=""> </a>
        <div class="caption">
          <a href="{{$basedir}}?type2=wg" class="f btn btn-info">国际视野</a>
		  <a href="{{$basedir}}?type2=wt" class="r btn btn-info">天外气质</a>
        </div>
      </div>
      <div class="col-sm-2">
        <a href="{{$basedir}}?type1=q" class="thum1"> <img src="/images/w/img5.png" alt=""> </a>
        <div class="caption">
          <a href="{{$basedir}}?type2=qcxcy" class="f btn btn-info">创新创业</a>
		  <a href="{{$basedir}}?type2=qcxsy" class="r btn btn-info">科学素养</a>
        </div>
      </div>
      <div class="col-sm-2">
        <a href="{{$basedir}}?type1=j" class="thum1"> <img src="/images/w/img6.png" alt=""> </a>
        <div class="caption">
          <a href="{{$basedir}}?type2=jy" class="f btn btn-info">艺术修养</a>
		  <a href="{{$basedir}}?type2=js" class="r btn btn-info">身心素质</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container main margintop1">
  <div class="row">
    <div class="col-md-9" style="overflow:hidden">
		@yield('content')
	  
		

    </div>
    <div class="col-md-3 side">
      <div class="panel sidebar enter">
        <div class="panel-body">
          <div class="nav">
            <strong>登录平台 Login</strong>
          </div>
          <a href="/student" class="btn btn-primary btn-block"><img src="/images/w/b1.png" alt="" height="20" /></a>
          <a href="/manage" class="btn btn-warning btn-block"><img src="/images/w/b2.png" alt="" height="20" /></a> 
          <a href="/adminconsole" class="btn btn-info btn-block" style="padding-left:74px;"><img src="/images/w/b3.png" alt="" height="20" /></a>
        </div>
      </div>
      
		<!---->
		@if(array_key_exists('listgood', $j))
		<div class="panel sidebar">
		<div class="panel-body">
		  <div class="nav">
			<strong>推荐活动</strong>
		  </div>
		  <div class="list1">
			<ul>
			@foreach($j['listgood'] as $v)
				<li><a href="/activity/detail/{{$v->id}}">{{$v->title}}</a></li>
			@endforeach
			</ul>
		  </div>
		</div>
		</div>
		@endif

		@if(array_key_exists('listgoodcourse', $j))
		<div class="panel sidebar">
		<div class="panel-body">
		  <div class="nav">
			<strong>推荐课程</strong>
		  </div>
		  <div class="list1">
			<ul>
			@foreach($j['listgoodcourse'] as $v)
				<li><a href="/course/detail/{{$v->id}}">{{$v->title}}</a></li>
			@endforeach
			</ul>
		  </div>
		</div>
		</div>
		@endif

		<div class="filedown">
			<div><span class="glyphicon glyphicon-file"></span> <a href="/files/activity.docx" >如何获得活动学分</a></div>
			<div><span class="glyphicon glyphicon-file"></span> <a href="/files/course.docx">如何获得课程学分</a></div>
			<div><span class="glyphicon glyphicon-file"></span> <a href="/files/innerhonor.docx">如何获得校内荣誉学分</a></div>
			<div><span class="glyphicon glyphicon-file"></span> <a href="/files/outerhonor.docx">如何获得校外荣誉学分</a></div>
			<div><span class="glyphicon glyphicon-file"></span> <a href="/files/perform.docx">如何获得履职修业学分</a></div>			
		</div>
    </div>
  </div>
</div>


<div class="mainfooter">
	<br />
	<div>马场道校区：天津市河西区马场道117号 邮编：300204</div>
	<div>滨海校区：天津市滨海新区大港学府路60号 邮编：300270</div>
	
</div>


<div style="margin:10px 0;text-align:center;">

<a href="http://webscan.360.cn/index/checkwebsite/url/wy.1suyuan.com"><img border="0" src="http://webscan.360.cn/status/pai/hash/7b4cbeab44f3fbdf62a4a751df560cd4"/></a></a>

&nbsp; &nbsp; &nbsp;
<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1273383643'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s19.cnzz.com/z_stat.php%3Fid%3D1273383643%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script>


</div>


</body>
</html>