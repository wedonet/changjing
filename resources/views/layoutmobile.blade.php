<!DOCTYPE html>
<html>
    <head>
        <meta charset='UTF-8'>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title>{{$oj->title}}</title>
		<link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="/css/mobile.css" rel="stylesheet">

        <script type="text/javascript" src="/js/jquery-3.0.0.min.js"></script>
		<script src="/bootstrap/js/bootstrap.min.js"></script>

		<script src="/js/mainmobile.js"></script>
    </head>



    <body>
		@include('commonmobile.info')
		@yield('content')

        
    </body>
</html>