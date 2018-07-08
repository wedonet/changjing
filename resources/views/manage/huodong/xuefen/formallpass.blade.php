<?php
require_once(base_path().'/resources/views/init.blade.php');
$ids = $j['ids'];
$activity =& $j['activity'];
?>

<div class="modal" id="modal-info" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">批量学分评定</h4>
            </div>
            <form method="post" action="{{$cc . '/0/allpass?activityid='.$activity->id}}">
				{{ csrf_field() }}
				{!!displayids($ids)!!}

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