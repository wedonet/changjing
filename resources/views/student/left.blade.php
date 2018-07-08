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

    <li class="list-unstyled" >
        <a class="btn btn-default" role="button" style="text-align:left;padding-left:10px;" >
            <i class="glyphicon glyphicon glyphicon-cog"></i>
            我的报名

        </a>
        <div class="dianji" >
            <ul class="list-unstyled" >
                <li class="<?php if('huodong'==$nav){echo ' hover';} ?>"><a  href="/student">我的活动报名</a></li>
				<li class="<?php if('coursesignup'==$nav){echo ' hover';} ?>"><a  href="/student/coursesignup">我的课程报名</a></li> 
            </ul>
        </div>
    </li>

    <li class="list-unstyled" >
        <a class="btn btn-default" role="button" style="text-align:left;padding-left:10px;" >
            <i class="glyphicon glyphicon-list"></i>
            我的学分

        </a>
        <div class="dianji" >
            <ul class="list-unstyled" >
                <li class="<?php if('huodonglishi'==$nav){echo ' hover';} ?>"><a  href="/student/huodonglishi">我的活动</a></li>                
                <li class="<?php if('kechenglishi'==$nav){echo ' hover';} ?>"><a  href="/student/kechenglishi">我的课程</a></li>

				<li class="<?php if('myinnerhonor'==$nav){echo ' hover';} ?>"><a  href="/student/myinnerhonor">我的校内荣誉</a></li>
                <li class="<?php if('xiaowairongyu'==$nav){echo ' hover';} ?>"><a  href="/student/xwrongyu">我的校外荣誉</a></li>
				<li class="<?php if('myperform'==$nav){echo ' hover';} ?>"><a  href="/student/myperform">我的履职修业</a></li>

				
            </ul>
        </div>
    </li>

    <li class="list-unstyled" >
        <a class="btn btn-default" role="button"  style="text-align:left;padding-left:10px;">
            <i class="glyphicon glyphicon-pawn" ></i>
            我的信息
            <i class="glyphicon"></i>
        </a>
        <div class="dianji" >
            <ul class="list-unstyled" >

                <li class="<?php if('xinxi'==$nav){echo ' hover';} ?>"><a  href="/student/xinxi" >我的信息</a></li>
                <li class="<?php if('xuefen'==$nav){echo ' hover';} ?>"><a  href="/student/xuefen">我的实践学分</a></li>
				<li class="<?php if('pass'==$nav){echo ' hover';} ?>"><a  href="/student/pass">修改密码</a></li>
            </ul>
        </div>
    </li>

</ul>

