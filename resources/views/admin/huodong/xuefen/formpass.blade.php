<div class="modal" id="modal-info" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{{$j['signup']->ucode}} 学分评定</h4>
      </div>
	   <form method="post" action="{{$_SERVER['REQUEST_URI'] }}" class="j_repost">
		{!! csrf_field() !!}
		  <div class="modal-body">
		   
				<input type="radio" name="mylevel" value="1" />A级 &nbsp;
				<input type="radio" name="mylevel" value="2" />B级 &nbsp;
				<input type="radio" name="mylevel" value="3" />C级 &nbsp;
				
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			<input type="submit" class="btn btn-primary" value="提交" />
		  </div>
	  </form>
    </div>
  </div>
</div>