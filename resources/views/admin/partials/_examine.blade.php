{{-- ajaxerr Modal 错误提示框 --}}
<div class="modal fade" id="modal-info" >
    <div class="modal-dialog" style="width:600px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
                <h4 class="modal-title">
                    <p>请填写审核未通过原因:</p>
                    <span class="alert alert-warning" style="opacity:0;color:#c70505;display:inline-block;width:100%;margin-bottom:0;padding:0;">字数不满足要求！</span>
                </h4>
            </div>
            <div class="modal-body">
                <textarea name="content" placeholder="(不少于20个字符)" id="examineReason"  rows="10" class="form-control" value="" style="resize: none"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="examineSubmit()">
                   提交
                </button>
            </div>
        </div>
    </div>
</div>


