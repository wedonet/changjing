{{-- Delete Folder Modal --}}
<div class="modal fade" id="modal-delete">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          &times;
        </button>
        <h4 class="modal-title">温馨提示</h4>
      </div>
      <div class="modal-body">
        <p class="lead">
          <h4>确定要删除<span id="modal_title1"></span>为</h4>
          <h4>"<span id="modal_title2" style="color:red;"></span>"</h4>
          <h4>的<span id="modal_title3"></span>吗？</h4>

        </p>
      </div>
      <div class="modal-footer">
        <form method="POST" action="" id="delaction">
          {!! csrf_field() !!}
          <input type="hidden" name="_method" value="DELETE">   
          <button type="button" class="btn btn-default" data-dismiss="modal">
            取消
          </button>
          <button type="submit" class="btn btn-danger">
            删除
          </button>
        </form>
      </div>
    </div>
  </div>
</div>