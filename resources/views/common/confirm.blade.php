{{-- confirm Folder Modal --}}
<div class="modal fade" id="modal-info">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          &times;
        </button>
        <h4 class="modal-title">确认</h4>
      </div>
      <div class="modal-body">
        <p class="lead" id="confirmtext">
          Loading
        </p>
      </div>
      <div class="modal-footer">
        <form method="post" action="" id="confirmaction">
          {!! csrf_field() !!}

          <button type="button" class="btn btn-default" data-dismiss="modal">
            取消
          </button>
          <button type="submit" class="btn btn-success">
            确认
          </button>
        </form>
      </div>
    </div>
  </div>
</div>