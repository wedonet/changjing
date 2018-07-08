{{-- Modal --}}
<div class="modal fade" id="modal-info">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          &times;
        </button>
        <h4 class="modal-title">{{ $j['title'] or ''}}</h4>
      </div>
      <div class="modal-body">
        @yield('content')
      </div>
      <div class="modal-footer">

          <button type="button" class="btn btn-default" data-dismiss="modal">
            关闭
          </button>
        </form>
      </div>
    </div>
  </div>
</div>