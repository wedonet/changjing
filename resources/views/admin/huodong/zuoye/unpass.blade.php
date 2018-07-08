<?php

require_once(base_path().'/resources/views/init.blade.php');

$signup =& $j['signup'];

?>

<div class="modal" id="modal-info" >
    <div class="modal-dialog" style="width:600px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
                <h4 class="modal-title">作业未通过</h4>
            </div>
			<form method="post" action="{{$_SERVER['REQUEST_URI'] }}" class="j_repost">
				{!! csrf_field() !!}
				<div class="modal-body">					
				   <table class="table1">

					<tr>
						<td width="30%">姓名：学号：{{$signup->ucode}}</td>
					</tr>
					<tr>
						
						<td>请填写未通过原因:
						<textarea name="homeworkexplain" rows="3" cols="" class="form-control"></textarea>
						</td>
					</tr>
					</table>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">
						关闭
					</button>

					<input type="submit" class="btn btn-info success"  value="提交" />
				</div>

			</form>
        </div>
    </div>
</div>