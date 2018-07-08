<?php
if( array_key_exists('nav', $j) ){
	$nav =& $j['nav'];
}else {
    $nav = '';
}

if('' == $nav){
	if( array_key_exists('nav', $oj) ){
		$nav =& $oj->nav;
	}
}


?>
<ul class="nav nav-sidebar nav-pills nav-stacked" id="sideContorl">
	@if('fq' == $_ENV['user']['role'] Or '' == $_ENV['user']['role'] Or 'counsellor' == $_ENV['user']['role'])
    <li class="list-unstyled" >
        <a class="btn btn-default" role="button" style="text-align:left;padding-left:10px;" >
            <i class="glyphicon glyphicon glyphicon-cog"></i>
            管理中心          
        </a>

		
        <div class="dianji" >
            <ul class="list-unstyled" >
				@if( 'fq' == $_ENV['user']['role'] )
                <li class="<?php if('huodong'==$nav){echo ' hover';} ?>"><a  href="/manage/huodong">活动管理</a></li>
				@endif

				@if( '' == $_ENV['user']['role'] or 'counsellor' == $_ENV['user']['role'])
                <li class="<?php if('course'==$nav){echo ' hover';} ?>"><a  href="/manage/course">课程管理</a></li>
				@endif
		
				{{--除了牵头和审核部门其它教师都可以发起--}}
				@if( 'fq' != $_ENV['user']['role']  AND 'sh' != $_ENV['user']['role'])
				<li class="<?php if('xiaoneifudao'==$nav){echo ' hover';} ?>"><a  href="/manage/xiaoneifudao">校内荣誉管理</a></li>
				@endif


				{{--辅导员， 团委，牵头部门可以管理履职修业--}}
				@if(cancreatperform())
				<li class="<?php if('perform'==$nav){echo ' hover';} ?>"><a  href="/manage/perform">履职修业管理</a></li>  
				@endif

			
				<li class="<?php if('xuefen'==$nav){echo ' hover';} ?> hidden"><a  href="/manage/xuefen" >实践学分查看[暂未开放]</a></li>  
	

				
				<li class="<?php if('beishu'==$nav){echo ' hover';} ?> hidden"><a  href="/manage/beishu">学生备述管理</a></li>  
				
            </ul>
        </div>
		
    </li>
	@endif

	@if('sh' == $_ENV['user']['role'] Or 'counsellor' == $_ENV['user']['role'])
    <li class="list-unstyled" >
        <a class="btn btn-default" role="button"  style="text-align:left;padding-left:10px;">
            <i class="glyphicon glyphicon-pawn" ></i>
            审核中心
            <i class="glyphicon"></i>
        </a>
		<div class="dianji" >
            <ul class="list-unstyled" >
				{{--审核部门的权限--}}
				@if( 'sh' == $_ENV['user']['role'] )
				<li class="<?php if('qiantou'==$nav){echo ' hover';} ?>"><a  href="/manage/qiantou">活动审核</a></li>
				<li class="<?php if('kaikeshenhe'==$nav){echo ' hover';} ?>"><a  href="/manage/kaikeshenhe">课程审核</a></li>

				<li class="<?php if('xiaonei'==$nav){echo ' hover';} ?>"><a  href="/manage/xiaonei">校内荣誉审核</a></li>
				<li class="<?php if('sh_perform'==$nav){echo ' hover';} ?>"><a  href="/manage/sh_perform">履职修业审核</a></li>
				@endif
				
				<li class="<?php if('xiaowaifudao'==$nav){echo ' hover';} ?>"><a  href="/manage/xiaowaifudao">校外荣誉审核</a></li>




				
				
	
   
            </ul>
        </div>
    </li>
	@endif
</ul>

