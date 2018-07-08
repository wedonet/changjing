<?php

namespace App\libraries;

use DB;

class main {

    public function ajaxvali($err) {
        return view('admin.partials._errorvali', ['err' => $err]);
    }

    public function ajaxerr($err) {
        return view('admin.partials._err', ['err' => $err]);
    }

    /* 成功提示 
    href :有href时自动跳转
     *      */

    public function jssuccess($title, $info = null, $href = null, $mytimeout = 2000) {
        return view('admin.partials._success', ['title' => $title, 'info' => $info, 'href' => $href, 'mytimeout' => $mytimeout]);
    }

    /* 用新的一页显示错误信息
     * 常用于非法操作
     *  */

    public function showerr($err, $href = null) {
        return view('info.showerr', ['err' => $err, 'href' => $href]);
    }

    /* 接收数字，如果不是数字变成-1 */

    public function rqid($id = 'id', $v = -1) {
        $y = -1;
        if (isset($_GET[$id])) {
            $x = Trim($_GET[$id]);
        } else {
            $x = $v;
        }

        if (strlen($x) > 20) {
            $y = $v;
        }

        if (!is_int($y)) {
            $y = $v;
        } else {
            $y = $x * 1;
        }

        return $y;
    }

    /* 接收get 或 post来的数字 */

    public function rid($id = 'id', $v = -1) {
        $y = -1;
        if (isset($_GET[$id])) {
            $x = Trim($_GET[$id]);
        } elseif (isset($_POST[$id])) {
            $x = Trim($_POST[$id]);
        } else {
            $x = $v;
        }

        if (strlen($x) > 20) {
            $y = $v;
        }

        if (!is_int($y)) {
            $y = $v;
        } else {
            $y = $x * 1;
        }

        return $y;
    }

    public function rstr($id = 'id', $v = '') {
        ;
        if (isset($_GET[$id])) {
            $x = Trim($_GET[$id]);
        } elseif (isset($_POST[$id])) {
            $x = Trim($_POST[$id]);
        } else {
            $x = $v;
        }


        return e($x);
    }

    /* 提取IC 池中第一个未使用的IC
     * 返回 integer
     *      
     */

    public function getfirstic() {
        $ic = DB::table('icpool')
                ->where('isused', 0)
                ->orderBy('id', 'asc')
                ->first();

        /* 没有记录了就插入一条，然后填充100条记录进池 */
        if (FALSE == $ic) {
            $rs['isused'] = 0;
            $rs['created_at'] = date('Y-m-d H:i:s', time());
            $rs['updated_at'] = date('Y-m-d H:i:s', time());

            $id = DB::table('icpool')->insertGetId($rs);

            /* 插入100条记录 */
            $sql = array();
            $time = date('Y-m-d H:i:s', time());

            for ($i = 0; $i < 100; $i++) {
                $sql[] = array('isused' => 0, 'created_at' => $time . '', 'updated_at' => $time . '');
            }

            DB::table('icpool')->insert($sql);


            $id;
        } else {
            $id = $ic->id;
        }

        /* 更新为已使用并返回id */
        $time = DB::table('icpool')
                ->where('id', $id)
                ->update(['isused' => 1, 'updated_at' => date('Y-m-d H:i:s', time())]);

        return $id;
    }

    function optionmenu($list) {
        $a = array();

        foreach ($list as $v) {
            if (0 == $v->pic) {
                $a['key' . $v->ic][] = $v;
            }
        }

        foreach ($list as $v) {
            if ($v->pic > 0) {
                $a['key' . $v->pic][] = $v;
            }
        }


        $pos = '';

        foreach ($a as $b) {
            foreach ($b as $v) {
                if ($v->pic > 0) {
                    $pos = '----';
                } else {
                    $pos = '';
                }

                echo '<option value="' . $v->ic . '">' . $pos . $v->title . '</option>' . PHP_EOL;
            }
        }
    }

    /* 生成随机码
     * $codetype: 什么码 垛码还是什么
     *            stack = 垛码
     *  */

    function makecode($codetype) {
        $ver = '1'; //版本

        $mycode = '';

        /* 类型 */
        switch ($codetype) {
            /* 生成共16位的垛码 */
            case 'stack':
                $mytype = '001';  //垛码   

                $randstr = $this->generate_randchar(10, 'num'); //10位随机数

                $codehash = $this->getcodehashnum($randstr); //2位校验,从第五位开始

                $mycode = $ver . $mytype . $randstr . $codehash;

                break;
            default:
                break;
        }

        return $mycode;
    }

    function generate_randchar($length = 10, $type = '') {//生成随机函数
        // 密码字符集，可任意添加你需要的字符
        $chars = 'abcdefghijkmnopqrstuvwxyz0123456789';
        if ($type == 'num')
            $chars = '0123456789';
        if ($type == 'char')
            $chars = 'abcdefghijkmnopqrstuvwxyz';
        $mychar = '';
        for ($i = 0; $i < $length; $i++) {
            $mychar .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $mychar;
    }

    /* 生成校验位
     * 把字符串Md5加密， 再取出数字， 最后取数字后两位                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
     *      */

    function getcodehashnum($str) {
        $j = ''; //准备返回的字符串

        $salt = 'zh2016715qazyhn6Tsla3kxk83xs2saaa3sx26xbHrMesCmVBQf2WvaJEPaerDvUt2YiNK68y';

        $md5code = hash_hmac('md5', $str, $salt);

        for ($i = 0; $i < strlen($md5code) + 1; $i++) {
            $v = substr($md5code, (strlen($md5code) - $i), 1);

            if (is_numeric($v)) {
                $j .= $v;
            }


            if (1 == strlen($j)) {
                return $j;
            }
        }
    }

    /* 获取部门列表 */

    function getdepartmentlist() {
        $list = DB::table('departments')
                ->where('isdel', 0)
                ->orderby('cls', 'asc')
                ->orderby('id', 'asc')
                ->get();

        return $list;
    }

    /* 获取部门名称 */

    function getdepartmentdatabyic($dic) {
        $data = DB::table('departments')
                ->where('isdel', 0)
                ->where('ic', $dic)
                ->first();

        return $data;
    }

    /* 获取学院列表 */

    function getxueyuanlist() {
        $list = DB::table('departments')
                ->where('isdel', 0)
                ->where('isxueyuan', 1)
                ->orderby('cls', 'asc')
                ->orderby('id', 'asc')
                ->get();

        return $list;
    }

    /* 获取班级列表 */

    function getclasslist() {
        $list = DB::table('classes')
                ->where('isdel', 0)
                ->orderby('cls', 'asc')
                ->orderby('id', 'asc')
                ->get();

        return $list;
    }

    /* 获取班级列表 */

    function getclassdatabyic($ic) {
        $data = DB::table('classes')
                ->where('isdel', 0)
                ->where('mycode', $ic)
                ->first();

        return $data;
    }

    /* 获取活动类型 */

    function getactivitytypelist() {
        $list = DB::table('activity_type')
                ->where('isdel', 0)
                ->orderby('cls', 'asc')
                ->orderby('id', 'asc')
                ->get();

        return $list;
    }

    /* 获取活动类型信息 */

    function getactivitytypebyic($ic) {
        $data = DB::table('activity_type')
                ->where('isdel', 0)
                ->where('ic', $ic)
                ->first();

        return $data;
    }

    /* get 活动详情 */

    function getactivitybyid($id) {
        $data = DB::table('activity')
                ->where('isdel', 0)
                ->where('id', $id)
                ->first();

        return $data;
    }

    function getactivitybyic($ic) {
        $data = DB::table('activity')
                ->where('isdel', 0)
                ->where('ic', $ic)
                ->first();

        return $data;
    }

    /* get 活动报名 */

    function getactivitysignupbyid($id) {
        $data = DB::table('activity_signup')
                ->where('id', $id)
                ->first();

        return $data;
    }

    /* get 课程报名 */

    function getcoursesignupbyid($id) {
        $data = DB::table('courses_signup')
                ->where('id', $id)
                ->first();

        return $data;
    }

    /* 课程 */

    function getcoursebyid($courseid) {
        $data = DB::table('courses')
                ->where('isdel', 0)
                ->where('id', $courseid)
                ->first();

        return $data;
    }

    function getcoursebyic($courseic) {
        $data = DB::table('courses')
                ->where('isdel', 0)
                ->where('ic', $courseic)
                ->first();

        return $data;
    }

    /* 判断是否首次登录，
      返回 boolean
     * uname : 登录名
     * gic : 用户组编码
     * roleic : 角色编码
     *      */

    function isfirstlogin($uname, $gic, $roleic = '') {
        $data = DB::table('loginchangepass')
                ->where('uname', $uname)
                ->where('gic', $gic)
                ->where('roleic', $roleic)
                ->first();

        if ($data) {
            return false;
        } else {
            return true;
        }
    }

    /* 通过学号找学生 */

    function getstudentbycode($code) {
        $data = DB::table('students')
                ->where('mycode', $code)
                ->first();

        return $data;
    }

    function getdepartmentbyteacherbycode($code) {

        $data = DB::table('departments')
                ->where('userfq', $code)
                ->orWhere('usersh', $code)
                ->first();


        return $data;
    }

    /* 获取所有部门，并以ic为索引 */

    function getdepartlistindexic() {

        $list = DB::table('departments')
                ->get();
        $d = [];
        foreach ($list as $v) {
            $d[$v->ic] = $v;
        }
        return $d;
    }

    /* 推荐活动 */

    function listgood() {
        $listgood = DB::table('activity')
                ->where('isdel', 0)
                ->where('auditstatus', 'pass') //通过审核的       
                ->where('signuptime_two', '>', time())
                ->orderby('appraise', 'desc')
                ->orderby('id', 'desc')
                ->limit(10)
                ->get();

        return $listgood;
    }

    /* 推荐课程 */

    function listgoodcourses() {
        $list = DB::table('courses')
                ->where('isdel', 0)
                ->where('auditstatus', 'pass') //通过审核的       
                ->where('signuptime_two', '>', time())
                ->orderby('appraise', 'desc')
                ->orderby('id', 'desc')
                ->limit(10)
                ->get();

        return $list;
    }

    /*
     * 取登录错误次数和剩余时间
      返回 errcount, hastime 分钟
     *      */

    function getloginerr($uname, $gic) {
        $a['errcount'] = 0;
        $a['hastime'] = 0;

        $result = DB::table('loginhistory')
                ->where('uname', $uname)
                ->where('gic', $gic)
                ->where('ctime', '>', time() - 3600)
                ->orderby('id', 'desc')
                ->get();

        if (!$result->isEmpty()) {
            $a['errcount'] = count($result);

            $a['hastime'] = ceil((3600 - (time() - $result[0]->ctime) ) / 60);
        }

        return $a;
    }

    /**/

    function getMyactivityTypeList($dic) {
        $list = DB::table('activity_type')
                ->where('qiantouic', $dic)
                ->get();

        if (!$list) {
            return '';
        } else {
            $a = array();
            foreach ($list as $v) {
                $a[] = $v->ic;
            }
            return $a;
        }
    }

    /* get 活动类型，以类型ic为索引 */

    function getActivityIndexIc() {
        $a = (object) [];

        $list = DB::table('activity_type')
                ->get();



        foreach ($list as $v) {
            $t = $v->ic;
            $a->$t = $v;
        }

        return $a;
    }

    function getstudentcodebyname($name) {
        $array = DB::table('students')
                ->where('realname', 'like', '%' . $name . '%')
                ->pluck('mycode');



        return $array;
    }

    /* 跟据二级活动类型，获取牵头部门名称 */

    function getdnamebytype($typeic) {
        /* 获取类型 */
        $result = DB::table('activity_type')
                ->where('ic', $typeic)
                ->first();

        if (!$result) {
            return '没找到牵头部门';
        } else {
            return $result->qiantouname;
        }
    }

    /*get校内荣誉*/
    function getinnerhonorbyid($id) {
        $result = DB::table('innerhonor')
                ->where('id', $id)
                ->first();
        return $result;
    }

    function getinnerhonorsignupbyid($id){
           $result = DB::table('innerhonor_signup')
                ->where('id', $id)
                ->first();
        return $result;     
    }
    
        /* 得到在数组中的次序，没有返回-1 */

    function getmyorder($a, $keytitle) {
        $num = -1;

        $count = count($a);

        for ($i = 0; $i < $count; $i++) {
            if ($keytitle == $a[$i]) {
                $num = $i;
            }
        }


        return $num;
    }
}
