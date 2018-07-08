<?php

require_once(base_path().'/resources/views/init.blade.php');

$data =& $j['data'];


$title = '部门负责人';
?>

{{--部门负责人--}}

<div class="modal fade" tabindex="-1" role="dialog" id="modal-info">
	<form method="post" action="{{ $currentcontroller }}_savemaster" id="j_form" class="j_formmodal">
	{!! csrf_field() !!}
	  <input type="hidden" id="dic" name="dic" value="" />
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">部门负责人</h4>
		  </div>
		  <div class="modal-body clearfix">       

				<div class="form-group clearfix">
					<label class="col-md-3 control-label" for="readme">编号</label>
					<div class="col-md-9">
						<input type="text" placeholder="" required="required" class="form-control" id="teachercode" name="mastercode" value="" />
					</div>                
				</div>

				<div class="form-group clearfix" >
					<label class="col-md-3 control-label" for="readme">姓名</label>
					<div class="col-md-9">
						<input type="text" placeholder="" required="required" class="form-control" id="teachername" name="mastername" value=""  /><a href="/papi?act=getteachername" id="j_findteacher" class="hidden">点这里按编号查教师</a>
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