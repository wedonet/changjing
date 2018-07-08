<?php

/*修改发起人用户名和密码*/

require_once(base_path().'/resources/views/init.blade.php');

$data =& $j['data'];


$title = '部门负责人';
?>



<div class="modal fade" tabindex="-1" role="dialog" id="modal-info" >
	<form method="post" action="{{ $_SERVER['REQUEST_URI'] }}_savemaster"  class="j_formmodal j_repost">
	{!! csrf_field() !!}
	  <input type="hidden" id="dic" name="dic" value="" />
	  <div class="modal-dialog" role="document"  style="width:400px">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">部门发起</h4>
		  </div>
		  <div class="modal-body clearfix">       

				<div class="form-group clearfix">
					<label class="col-md-4 control-label" for="readme">发起人用户名</label>
					<div class="col-md-8">
						<input type="text" placeholder="" required="required" class="form-control"  name="userfq" value="{{$data->userfq}}" readonly="readonly" />
					</div>                
				</div>

				<div class="form-group clearfix" >
					<label class="col-md-4 control-label" for="readme">密码</label>
					<div class="col-md-8">
						<input type="text" placeholder="" required="required" class="form-control" name="passfq" value=""  /><a href="/papi?act=getteachername" id="j_findteacher" class="hidden">点这里按编号查教师</a>
					</div>   
				</div>	

		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			<button type="submit" class="btn btn-primary">保存</button>
		  </div>
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->

  </form>
</div>