<?php
if( array_key_exists('nav', $j) ){
	$nav =& $j['nav'];
}else {
    $nav = '';
}
?>
<ul class="nav nav-sidebar nav-pills nav-stacked" id="sideContorl">
    <li class="list-unstyled" >
        <a class="btn btn-default" role="button"  >
            <i class="glyphicon glyphicon-cog"></i>
            参数设置
            <i class="glyphicon glyphicon-chevron-down"></i>
        </a>
        <div class="collapse dianji" >
            <ul class="list-unstyled" >
                <li class="<?php if('department'==$nav){echo ' hover';} ?>"><a  href="/adminconsole/department">部门管理</a></li>
				<li class="<?php if('department'==$nav){echo ' hover';} ?>"><a  href="/adminconsole/department">班级管理</a></li>
                <li class="<?php if('teacher'==$nav){echo ' hover';} ?>"><a  href="/adminconsole/teacher">教师管理</a></li>
				<li class="<?php if('student'==$nav){echo ' hover';} ?>"><a  href="/adminconsole/student">学生管理</a></li>  
				<li class="<?php if('qiantou'==$nav){echo ' hover';} ?>"><a  href="/adminconsole/qiantou">牵头部门设置？</a></li>  
				<li class="<?php if('guanli'==$nav){echo ' hover';} ?>"><a  href="/adminconsole/guanli">管理部门设置？</a></li>
				
            </ul>
        </div>
    </li>

    <li class="list-unstyled" >
        <a class="btn btn-default" role="button"  >
            <i class="glyphicon glyphicon-user"></i>
            活动管理
            <i class="glyphicon glyphicon-chevron-down"></i>
        </a>
        <div class="collapse dianji" >
            <ul class="list-unstyled" >
                <li class="<?php if('huodongleixing'==$nav){echo ' hover';} ?>"><a  href="/adminconsole/huodongleixing">活动类型</a></li>  
				 <li class="<?php if('huodong'==$nav){echo ' hover';} ?>"><a  href="/adminconsole/huodong">活动管理</a></li>  
               
            </ul>
        </div>
    </li>
   
</ul>

