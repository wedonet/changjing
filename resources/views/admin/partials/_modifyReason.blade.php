{{-- ajaxerr Modal 错误提示框 --}}
<div class="modal fade" id="modal-info1" >
    <div class="modal-dialog" style="width:600px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close j_form" data-dismiss="modal">
                    &times;
                </button>
                <h4 class="modal-title">
                    <p>修改部分描述及原因:</p>
                    <span class="alert alert-warning" style="opacity:0;color:#c70505;display:inline-block;width:100%;margin-bottom:0;padding:0;">内容不能为空！</span>
                </h4>
            </div>
            <div class="modal-body">
                <textarea name="reason" placeholder="请填写修改原因..." id="examineReason"  rows="10" class="form-control" value="" style="resize: none"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="examineSubmit()">
                   提交
                </button>
            </div>
        </div>
    </div>
</div>


