<div class="modal" id="modal-info" >
    <div class="modal-dialog" style="width:600px">
		<form method="post" action="{{$_SERVER['REQUEST_URI'] }}">
			{!! csrf_field() !!}
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">请填写审核未通过原因</h4>
			  </div>
			  <div class="modal-body">
				
					<textarea name="myexplain" rows="4" cols="30" class="form-control"></textarea>
				
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				<input type="submit" class="btn btn-primary" value="提交" />
			  </div>
			</div>
		</form>
  </div>
</div>