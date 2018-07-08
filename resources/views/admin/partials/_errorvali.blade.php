{{-- ajaxerr Modal 错误提示框 --}}
<div class="modal" id="modal-info">
    <div class="modal-dialog"  style="width:500px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
                <h4 class="modal-title">错误提示</h4>
            </div>
            <div class="modal-body">
                <p class="lead">
                <ul>

                    @foreach($err as $v)
                    @foreach($v as $w)
                    <li>{{ $w }}</li>
                    @endforeach
                    @endforeach

                </ul>

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">
                    关闭
                </button>


            </div>
        </div>
    </div>
</div>