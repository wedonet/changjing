<div class="modal" id="modal-info" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">课程 评价</h4>
      </div>
	   <form method="post" action="{{$_SERVER['REQUEST_URI'] }}" class="j_repost">
		{!! csrf_field() !!}
		  <div class="modal-body">
		   
				<input type="radio" name="mylevel" value="1" />1星 &nbsp;
				<input type="radio" name="mylevel" value="2" />2星 &nbsp;
				<input type="radio" name="mylevel" value="3" />3星 &nbsp;
				<input type="radio" name="mylevel" value="4" />4星 &nbsp;
				<input type="radio" name="mylevel" value="5" checked="checked" />5星 &nbsp;
				
			
		  </div>
		  <div class="modal-footer">
	
			<input type="submit" class="btn btn-primary" value="提交" />
		  </div>
	  </form>
    </div>
  </div>
</div>