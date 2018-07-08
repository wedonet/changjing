{{-- ajaxerr Modal 错误提示框 --}}<html>
<head>
</head>
<body>
<div class="modal" id="modal-info" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
                <h4 class="modal-title">错误提示1</h4>
            </div>
            <div class="modal-body">
                <p class="lead">
                <ul>


                    @foreach($err as $v)
                    <li>{{ $v }}</li>
                    @endforeach


                </ul>

            </div>
            <div class="modal-footer">
				<?php 
					if (isset($_SERVER['HTTP_REFERER'])) {
						echo '<a href="'. $_SERVER['HTTP_REFERER']. '">返回上一页</a>';
					}
				?>
               
                    
            


            </div>
        </div>
    </div>
</div>


@if( isset($href))
<javacript>
    $(document).ready(function () {
        windows.location = {{ href }};
    });
    
</javacript>
@endif

</body>
</html>