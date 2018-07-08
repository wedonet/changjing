<?php
if(isset($j['aid'])){
	$aid = $j['aid'];
}

if(isset($oj->aid)){
	$aid = $oj->aid;
}
?>

<div>

	<script>
		$(document).ready(function(){
			$('#{{$tab}}').addClass('active');
		})
	</script>


	<div style="position:relative;margin-bottom:15px;">
	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">
		<li role="presentation" id="tab_detail"><a href="/adminconsole/huodong/{{$aid}}"  aria-controls="home" role="tab" >详情</a></li>
		<li role="presentation" id="tab_shenhe"><a href="/adminconsole/huodong_shenhe?aid={{$aid}}"   aria-controls="profile" role="tab">报名表</a></li>
		<li role="presentation" id="tab_qiandao"><a href="/adminconsole/huodong_qiandao/{{$aid}}"  aria-controls="messages" role="tab">签到表</a></li>
		<li role="presentation" id="tab_zuoye"><a href="/adminconsole/huodong_zuoye/{{$aid}}"  aria-controls="messages" role="tab">作业表</a></li>
		<li role="presentation" id="tab_xuefen"><a href="/adminconsole/huodong_xuefen/{{$aid}}"  aria-controls="messages" role="tab">学分表</a></li>
		<li role="presentation" id="tab_pingjia"><a href="/adminconsole/huodong_pingjia/{{$aid}}"  aria-controls="settings" role="tab">评价 {{round($oj->activity->appraise/1000, 2)}} <span class="glyphicon glyphicon-star" aria-hidden="true" style="color: #cd7f32"></span></a></li>
		
	  </ul>

		<div style="width:500px;position:absolute;top:0;right:0;text-align:right;">@yield('operate')</div>

	</div>

	
</div>