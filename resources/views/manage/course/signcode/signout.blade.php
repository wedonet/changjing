<!DOCTYPE html>
<html>
<head>
	<meta charset='UTF-8'>
	<title>活动签退</title>
	<link rel="stylesheet" type="text/css" href="/css/qiandao.css">
	<script type="text/javascript" src="/js/jquery-3.1.1.js"></script>
	<script type="text/javascript" src="/js/YuxiSlider.jQuery.min.js"></script>
	<script type="text/javascript" src="/js/main.js"></script>
	<style>
		body{ color:#333; font-family:"Microsoft Yahei","微软雅黑","Tahoma","Arial"; font-size:12px; margin:0; padding:0; line-height: 1.6;}
		ul,h1,h2,h3,h4,h5,h6,p,li,dl,dt,dd{margin:0;padding:0;list-style:none;}
		form{margin:0;padding:0;}
		img{border:0;}
		a{text-decoration:none;/*去掉下划线*/ color: #333; }
		a:hover{transition:0.3s;}
		.clear{  clear: both;}
		.w1200{width: 1200px;margin:0 auto;position: relative;}/*板块div样式*/

		body{
			background-image: url(/qiandao/background.jpg);
			background-size:100%;
		}
		.text{
			position: absolute;/*绝对定位*/
			width: 700px;
			height: 400px;
			/*border: 1px solid red;*/
			text-align: center;/*(让div中的内容居中)*/
			top: 60%;
			left: 50%;
			margin-top: -280px;
			margin-left: -350px;
			font-size: 36px;
			color:#73848a;
		}
		input{
			background:transparent;border:1px solid #b5b5b5;
			padding: 10px 10px;
			font-size: 36px;
			border-radius:10px;
			margin-bottom:20px;
			background: -webkit-linear-gradient(#e4e4e4, #eeeeee); /* Safari 5.1 - 6.0 */
			background: -o-linear-gradient(#e4e4e4, #eeeeee); /* Opera 11.1 - 12.0 */
			background: -moz-linear-gradient(#e4e4e4, #eeeeee); /* Firefox 3.6 - 15 */
			background: linear-gradient(#e4e4e4, #eeeeee); /* 标准的语法 */

		}
		.button1{
			width: 600px;
			height: 140px;
			background-image:url(/qiandao/buttom3.png);
			background-size: 100% 100%;
			border: #eee;
			background-color:#eeeeee;
		}

	</style>


</head>
{{--<img src="/qiandao/background.jpg" width="100%" alt="" />--}}
<body>
	<form class="text" action="/dosignout" method="post" >
		{!! csrf_field() !!}
		<input type="hidden" name="ic" value="{{$j}}" >


学 号: <input type="text" name="code"  placeholder="学号"><br>
密 码: <input type="password" name="upass"  placeholder="密码"><br><br>
<button class="button1"></button>
</form>
</body>
</html>