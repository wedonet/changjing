
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
    <link href="/css/city.css" rel="stylesheet">
    <link href="/css/city-picker.css" rel="stylesheet">

	
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

	<script type="text/javascript">
	<!--
		$(function(){




			/*file输入框选择文件后的处理*/
			$('#file1').on('change', function(){
				ajaxFileUpload('attachmentsurl', 'upload', 'originname');
			})


			/*上传*/
			$(function () {
				$("#upload").click(function () {
					
					ajaxFileUpload('attachmentsurl', 'upload', 'originname');
			
				})
			})
			
			
		})
	//-->
	</script>




 




    <script src="/js/main.js"></script>

    <script src="/js/app.js"></script>

	<script src="/ajaxfileupload/ajaxfileupload.js"></script>



</head>

<body>




<div class="container-fluid">




        <form method="post" action="/manage/huodong" class="form-horizontal j_form">
            {!! csrf_field() !!}




            <div class="form-group">
                <label class="col-md-4 control-label" id="date1" >附件路径</label>
                <div class="col-md-3">				
					<input type="hidden"  class="form-control" id="originname" name="originname" readonly="readonly" /> 
                    <input type="text"  class="form-control" id="attachmentsurl" name="attachmentsurl" readonly="readonly" /> 
                </div>   
				

				<div class="pull-left">				

					<input type="file" id="file1" name="file1" class="pull-left"  style="width:200px;"/>
                    <input type="button" id="upload" style="width:100px;display:none;" class="form-control pull-left" value="上传" />
                </div>  
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" > </label>
                <div class="col-md-3">
                    <input type="submit" class="btn btn-info j_slowsubmit"  disabled="disabled" value=" 提 交 " />
                </div>
            </div>


        </form>


		<form id="upload-form" action="uploadfile" method="POST" enctype="multipart/form-data" style="margin:15px 0" target="hidden_iframe">
			{!! csrf_field() !!}

        <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="test" />
        <p><input type="file" name="file1" /></p>
        <p><input type="submit" value="Upload" /></p>
		</form>    

		<iframe id="hidden_iframe" name="hidden_iframe" src="about:blank"></iframe>

		<div id="progress" class="progress" style="">
			
			0%
		</div>



		<script type="text/javascript">
		<!--
			function fetch_progress(){
				//$('#progress').show();
				$.get('/getprogress', function(data){
						var progress = parseInt(data);

						$('#progress').html(progress + '%');
						//$('#progress .bar').css('width', progress + '%');

						if(progress < 100){
								setTimeout('fetch_progress()', 100);
						}else{
					//$('#progress .label').html('完成!');
				}
				}, 'html');
			}




		//-->
		</script>
    </div>
</div>

          


















</body>
</html>
