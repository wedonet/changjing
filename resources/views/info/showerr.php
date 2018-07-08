{{-- ajaxerr Modal 错误提示框 --}}<html>
<!DOCTYPE html>
<html lang="zh-CN" ng-app="website">
<head>
    <meta charset="utf-8">
    <meta name=”renderer” content=”webkit”>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no"/>  
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

              
                    <a href="javascript:window.history.back();">返回上一页</a>
               

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