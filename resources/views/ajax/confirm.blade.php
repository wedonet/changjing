{{-- confirm Folder Modal --}}
<div class="modal fade" id="modal-info">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          &times;
        </button>
        <h4 class="modal-title">确认?</h4>
      </div>
      <div class="modal-body">
        <p class="lead" id="confirmtext">
          {{$oj->title}}
        </p>
      </div>
      <div class="modal-footer">
        <form method="post" action="{{$oj->action}}" id="confirmaction">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <button type="button" class="btn btn-default" data-dismiss="modal">
            取消
          </button>
          <input type="submit" class="btn btn-success" value="确认" />
        </form>
      </div>
    </div>
  </div>
</div>