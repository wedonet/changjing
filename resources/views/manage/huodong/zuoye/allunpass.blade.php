<?php

require_once(base_path().'/resources/views/init.blade.php');

$signup =& $j['signup'];

$posturl =$_SERVER['REQUEST_URI'] ;



?>

<div class="modal" id="modal-info" >
    <div class="modal-dialog" style="width:600px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
                <h4 class="modal-title">批量作业未通过</h4>
            </div>
			<form method="post" action="{{$_SERVER['REQUEST_URI'] }}" id="mybatchform">
				{!! csrf_field() !!}
				<div class="modal-body">					
				   <table class="table1">

					<tr>
						
						<td>请填写未通过原因:
						<textarea name="explain" id="explain" rows="3" cols="" class="form-control" required="required">{{old('homeworkexplain')}}</textarea>
						</td>
					</tr>
					</table>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">
						关闭
					</button>

					<input type="submit" value="提交" class="btn btn-info success" />

				</div>

			</form>
        </div>
    </div>
</div>

<script type="text/javascript">
<!--
$(document).ready(function(){
	$('#mybatchform').on('submit', function(){
		var url = "{{$posturl }}";
		var myexplain = $('#explain').val();



		/*把值传回去再提交*/
		$('#myform').find('input[name="homeworkexplain"]').val(myexplain);
		$('#myform').attr('action', url);
		$('#myform').submit();

		return false;

	})
})
//-->
</script>