<?php
require_once(base_path().'/resources/views/init.blade.php');
$ids = $j['ids'];
$activity =& $j['activity'];
?>

<div class="modal" id="modal-info" >
    <div class="modal-dialog" role="document">
        <a href="formunpass.blade.php"></a>
        <a href="index.blade.php"></a>
        <div class="modal-content">
            <div class="modal-header">
                <a href="formpass.blade.php"></a>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">未通过原因</h4>
            </div>

            <form method="post" action="{{$cc . '/0/allunpass?activityid='.$activity->id}}">
				{{ csrf_field() }}
				{!!displayids($ids)!!}
                <div class="modal-body">

                    <textarea name="creditexplain" rows="4" cols="30"></textarea>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <input type="submit" class="btn btn-primary" value="提交" />
                </div>
            </form>
        </div>
    </div>
</div>