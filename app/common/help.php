<?php

use Illuminate\Support\Facades\DB;

function testhelp() {

    die;
}

/* 检测有没有权限，rolelist 有权限的角色，以逗号分隔 */

function haspower($rolelist, $myrole) {
    $a = explode(',', $rolelist);

    if (in_array($myrole, $a)) {
        return true;
    } else {
        return false;
    }
}

// end func


/* 履职修业 */
/* 我能添加履职修业吗 */

function cancreatperform() {

    if ('fq' == $_ENV['user']['role']) {
        return false;
    }





    return true;
}

/**
 * 返回可读性更好的文件尺寸
 */
function human_filesize($bytes, $decimals = 2) {
    $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];
    $factor = floor((strlen($bytes) - 1) / 3);

    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}

/**
 * 判断文件的MIME类型是否为图片
 */
function is_image($mimeType) {
    return starts_with($mimeType, 'image/');
}

/* 没有cls时默认显示为100 */

function cls($x) {
    if ('' == $x) {
        return 100;
    } else {
        return $x;
    }
}

/**
 * 数组 转 对象
 *
 * @param array $arr 数组
 * @return object
 */
function array_to_object($arr) {
    if (gettype($arr) != 'array') {
        return;
    }
    foreach ($arr as $k => $v) {
        if (gettype($v) == 'array' || getType($v) == 'object') {
            $arr[$k] = (object) array_to_object($v);
        }
    }

    return (object) $arr;
}

/**
 * 对象 转 数组
 *
 * @param object $obj 对象
 * @return array
 */
function object_to_array($obj) {
    $obj = (array) $obj;
    foreach ($obj as $k => $v) {
        if (gettype($v) == 'resource') {
            return;
        }
        if (gettype($v) == 'object' || gettype($v) == 'array') {
            $obj[$k] = (array) object_to_array($v);
        }
    }

    return $obj;
}

/* 我能看见联系方式吗

 * 我发的可以看见，审核机构也可以看见
 * createcode = 发部人账号
 *  */

function icanseetel($createcode) {
    /*管理员可见*/
    if ('admin' == $_ENV['user']['gic']) {
        return true;
    }
	/*审核部门可见*/
    if ('sh' == $_ENV['user']['role']) {
        return true;
    }
	/*自已可见*/
    if ($_ENV['user']['mycode'] == $createcode) {
        return true;
    }

	/*辅导员可见自已系的*/
//	if ($_ENV['user']['role'] == 'counsellor') {
//
//		if($_ENV['user']['dic']
//        return true;
//    }
//
//	counsellor
	

    return false;
}
