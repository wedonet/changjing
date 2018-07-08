<?php

require_once(base_path().'/resources/views/init.blade.php');

$data = $j['data'];

?>

<div class="modal" id="modal-info" >
    <div class="modal-dialog" style="width:600px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
                <h4 class="modal-title">查看报名信息</h4>
            </div>
            <div class="modal-body">
                
			   <table class="table1">

				<tr>
					<td width="30%">姓名：</td>
					<td width="70%">{{$data->realname}}</td>
				</tr>
				<tr>
					<td>学号：</td>
					<td>{{$data->ucode}}</td>
				</tr>
				</table>

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">
                    关闭
                </button>


            </div>
        </div>
    </div>
</div>