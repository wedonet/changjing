<?php
if( array_key_exists('nav', $j) ){
	$nav =& $j['nav'];
}else {
    $nav = '';
}
if('' == $nav){
	if(isset($oj->nav)){
		$nav =& $oj->nav;
	}
}
?>
<ul class="nav nav-sidebar nav-pills nav-stacked" id="sideContorl">
    <li class="list-unstyled" >
        <a class="btn btn-default" role="button"  >
            <i class="glyphicon glyphicon-cog"></i>
            参数设置
           
        </a>
        <div class="dianji" >
            <ul class="list-unstyled" >
                <li class="<?php if('department'==$nav){echo ' hover';} ?>"><a  href="/adminconsole/department">部门管理</a></li>
                <li class="<?php if('teacher'==$nav){echo ' hover';} ?>"><a  href="/adminconsole/teacher">教师管理</a></li>
				<li class="<?php if('banji'==$nav){echo ' hover';} ?>"><a  href="/adminconsole/banji">班级管理</a></li>
				<li class="<?php if('student'==$nav){echo ' hover';} ?>"><a  href="/adminconsole/student">学生管理</a></li>
				<li class="<?php if('yujing'==$nav){echo ' hover';} ?>"><a  href="/adminconsole/yujing">预警信息设置</a></li>
				<li class="<?php if('huodongleixing'==$nav){echo ' hover';} ?>"><a  href="/adminconsole/huodongleixing">活动类型</a></li>  
            </ul>
        </div>
    </li>

    <li class="list-unstyled" >
        <a class="btn btn-default" role="button"  >
            <i class="glyphicon glyphicon-list-alt"></i>
            业务查看
          
        </a>
        <div class="dianji" >
            <ul class="list-unstyled" >
                
				<li class="<?php if('huodong'==$nav){echo ' hover';} ?>"><a  href="/adminconsole/huodong">活动管理</a></li>
				<li class="<?php if('course'==$nav){echo ' hover';} ?>"><a  href="/adminconsole/course">课程管理</a></li>
				<li class="<?php if('perform'==$nav){echo ' hover';} ?>"><a  href="/adminconsole/perform">履职修业</a></li>
				<li class="<?php if('innerhonor'==$nav){echo ' hover';} ?>"><a  href="/adminconsole/innerhonor">校内荣誉</a></li>
				<li class="<?php if('outerhonor'==$nav){echo ' hover';} ?>"><a  href="/adminconsole/outerhonor">校外荣誉</a></li>
            </ul>
        </div>
    </li>
   
    <li class="list-unstyled" >
        <a class="btn btn-default" role="button"  >
            <i class="glyphicon glyphicon-user"></i>
            个人资料
          
        </a>
        <div class="dianji" >
            <ul class="list-unstyled" >
                
				<li class="<?php if('pass'==$nav){echo ' hover';} ?>"><a  href="/adminconsole/pass">修改密码</a></li>
				
            </ul>
        </div>
    </li>
   
</ul>

