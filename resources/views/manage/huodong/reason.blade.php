<?php

require_once(base_path().'/resources/views/init.blade.php');

$data =& $j['data'];
$activity_audit =& $j['activity_audit'];

?>
<div class="modal" id="modal-info" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"> 由于以下原因未通过</h4>
      </div>

		  <div class="modal-body">
		  
				<div>{{$activity_audit->myexplain}}</div>
				<br />
				<br />
		
				<p class="text-warning">请修改后重新等待审核</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>	
		  </div>

    </div>
  </div>
</div>