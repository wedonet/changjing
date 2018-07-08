<?php

if(!isset($j)){
	$j=[];
}
if( array_key_exists('list', $j) ){
	$list =& $j['list'];
}else {
    $list[] = null;
}


if( array_key_exists('currentcontroller', $j) ){
	$currentcontroller =& $j['currentcontroller'];
}else {
    $currentcontroller = '';
}



if( array_key_exists('data', $j) ){
	$data =& $j['data'];
}


if( array_key_exists('basedir', $j) ){
	$basedir = $j['basedir'];
}else {
    $basedir = '';
}


if( array_key_exists('courseid', $j) ){
	$courseid = $j['courseid'];
}else {
    $courseid = '';
}

/*===========================================================*/
if(!isset($oj)){
	$oj=(object)[];
}else{
	/*用oj时*/
	if( array_key_exists('list', $oj) ){
		$list =& $oj->list;
	}else {
	    $list = null;
	}	

	if( array_key_exists('currentcontroller', $oj) ){
		$currentcontroller =& $oj->currentcontroller;
	}else {
	    $currentcontroller = '';
	}

	if( array_key_exists('data', $oj) ){
		$data =& $oj->data;
	}else {
	    $data = null;
	}

	if( array_key_exists('basedir', $oj) ){
		$basedir = $oj->basedir;
	}else {
	    $basedir = '';
	}
	
	
	if( array_key_exists('courseid', $oj) ){
		$courseid = $oj->courseid;
	}else {
	    $courseid = '';
	}
}





/*=====================================================*/
$cc =& $currentcontroller;

/*活动级别*/
function activitylevel($s)
{
	switch ($s) {
	    case 'school' :
			return '校级';
			break;
	    case 'college' :
			return '院级';
			break;
		
	}
} 


/*格式化审核状态*/
function checkstatus($s)
{

	if( is_int($s)){
		switch($s){
			case '-1':
				$a = 'unsubmit';
			    break;
			case 0:
				$a = '';
				break;
			case 1:
				$a = 'pass';
				break;
			case 2:
				$a = 'unpass';
				break;
			default :
				$a = $s;
				break;
		}
	}
	else{
		$a = $s;
	}


	switch ($a) {
		case 'unsubmit':
			return '未提交';
		    break;
	    case 'pass' :
			return '已通过';
			break;		
	    case 'unpass' :
			return '未通过';
			break;	
		default :
			return '待审核';
			break;
	}

} 

/*格式化开通状态*/
function openstatus($s)
{
	switch ($s) {
	    case 0 :
			return '关闭';
			break;
		case 1:
			return '开通';
		    break;
		
	}

} 


/*格式化当前状态，未开始，已开始，已结束*/
function currentstatus($s)
{
	switch ($s) {
	    case 'new' :
			return '未开始';
			break;
	    case 'doing' :
			return '进行中';
			break;
		case 'done' :
			return '已结束';
			break;
	}
} 



/*格式化当前状态，未开始，已开始，已结束*/
/*
time1 : 开始时间
time2 : 结止时间
*/

function timetocurrentstatus($time1, $time2)
{
	if(time()>$time2){
		return '已结束';
	}elseif(time()<$time1){
		return '未开始';
	}else{
		return '进行中';
	}
	
} 



function signupmethod($s)
{
	switch ($s) {
	    case 'direct' :
			return '直接报名';
			break;
	    case 'audit' :
			return '审核报名';
			break;
	}
} 


/*格式化是否签到签退*/
function issign($s)
{
	switch ($s) {
	    case 1 :
			return '是';
			break;
	   
	}
} 



/*只当选1的时候显示*/
function showyes($s)
{
	if(1 == $s){
		return "是";
	}
} 


/**/
function yorn($s)
{
	if( 1 == $s){
		return "是";
	}
	elseif( 2 == $s ){
		return '否';
	}else{
		return '';
	}
} 

/*作业是否通过
$hashomework
*/
function homeworkokyorn($s, $hashomework=1)
{
	if(1 != $hashomework ){
		return '--';
	}else{
		if( 1 == $s){
			return "是";
		}
		elseif( 2 == $s ){
			return '否';
		}else{
			return '';
		}
	}
} 

function y01($s)
{
	if( 0 == $s){
		return "否";
	}
	elseif( 1 == $s ){
		return '是';
	}
} 

/*显示学分等级*/
function showlevel($s)
{	
	switch ($s) {
	    case 1:
			return "A";
			break;
	    case 2:
			return "B";
			break;
	    case 3:
			return "C";
			break;
	    case 4:
			return "D";
			break;
	}
	
}



function homeworkisdone($s)
{
	if( 1 == $s){
		return "已交";
	}
	elseif( 2 == $s ){
		return '未交';
	}
} 

/*按年月日显示整型时间*/
function formattime1($s){
	if($s>0){
		return date('Y-m-d', $s);
	}else{
		return '';
	}
} 

function formattime2($s){
	if($s>0){
		return date('Y-m-d H:i', $s);
	}else{
		return '';
	}	
} 


/*格式化人数限制*/
function personlimit($s)
{
	if(0 == $s){
		return '无';
	}else{
		return $s .' 人';
	}

} 


/*格式化开放格式*/
function formatopen($s)
{
	if(0 == $s){
		return '<span class="plustip">[暂停]</span>';
	}else{
		return '';
	}

} 



/*按开始时间和时长，显示当前状态*/
function cstatus($plantime_one, $plantime_two)
{
	$time = time();//当前时间

	/*未开始，进行中，已结束*/
	if($time < $plantime_one){
		return '未开始';
	}elseif($time>$plantime_two){
		return '已结束';

	}else{
		return '进行中';
	}
	
} // end func



function showstar($x)
{


	$a = '';
	for($i=0; $i<($x/1000); $i++){
		$a .= '<img src="/images/star1.png" />';
	}
	return $a;
} 


/*显示学分*/
function fmcredit($level, $s)
{
	if('' == $level){
		return '';
	}
	else{
		return $s/1000;
	}
	
}

function formatlimit($x)
{
	if(0 == $x ){
		return '无';
	}else{
		return $x;
	}
} // end func


/*显示未通过原因*/
function showexplain($json)
{
	$a = json_decode($json);

	return $a->text;
} // end func


/*
signuptime_two : int 报名结止时间
*/
function formatisover($signuptime_two)
{
	if($signuptime_two < time() ){
		return ' <span class="plustip">[结止报名]</span>';
	}
} // end func




/*部门ic转换为部门名称*/
function showdepartment(&$departmentlist, $dic)
{
	if('' == $dic){
		return '';
	}

	if( array_key_exists($dic, $departmentlist ) ) {
		return $departmentlist[$dic]->title;
	}
	else{
		return '';
	}
} // end func


/*活动或课程类型转为牵头部门名称*/
function typetodepartment(&$typeindexic, $type_twoic)
{
	if( property_exists($typeindexic, $type_twoic)  ){
		return $typeindexic->$type_twoic->qiantouname;		
	}else{
		return '';
	}
} // end func




function displayids($a)
{
	$array=[];
	foreach($a as $v){
		$array[] = '<input type="hidden" name="ids[]" value="'.$v.'" />';
	}

	return join('', $array);
} // end func


/*按角色编码显示教师角色 */
function showteacherrole($mytype)
{
	switch($mytype){
		case 'fq':
			return '发起账号';
		    break;
		case 'sh':
			return '审核账号';
		    break;
		case 'counsellor':
			return '辅导员';
		    break;
		default :
			break;
	}
} // end func




?>