<?php

namespace App\Repositories;

/* 课程类 */

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of activity
 *
 * @author Administrator
 */
class course {

    public $dbname;

    function __construct() {
        $this->dbname = 'courses';
    }

    public function index($request) {
        $a = (object) [];

        $a->rules = array(
            'title' => 'string|between:1,20',
            'currentstatus' => 'string|between:1,20',
            'auditstatus' => 'string|between:1,20'
        );

        $a->attributes = array(
            "title" => '名称',
            'currentstatus' => '当前状态',
            'auditstatus' => '审核状态'
        );

        $a->message = array(
        );


        $search = (object) [];

        $search->title = $request->title;
        $search->currentstatus = $request->currentstatus;
        $search->auditstatus = $request->auditstatus;

        $a->search = $search;

        return $a;
    }

    /* 列表 */

    public function getlist($request, $user) {
        $a = (object) [];
        $search = (object) [];
        $p = (object) [];


        $rules = array(
            'title' => 'string|between:1,20'
        );

        $attributes = array(
            "title" => '名称'
        );

        $message = array(
        );

        $a->validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        $search->title = $request->title;
        $search->currentstatus = $request->currentstatus;
        $a->search = $search;
        if ($a->validator->fails()) {
            return ( $a );
        }

        $p = $search;


        /* 把身份传给搜索条件 */
        $p->user = $user;
        $list = DB::table($this->dbname)
                ->where('isdel', 0)
                ->where(function($query) use($p) {
                    if ('' != $p->title) {
                        $query->where('title', 'like', '%' . $p->title . '%');
                    }
                    if ('' != $p->currentstatus) {
                        switch ($p->currentstatus) {
                            case 'new':
                                $query->where('plantime_one', '>', time());
                                break;
                            case 'doing':
                                $query->where('plantime_one', '<', time());
                                $query->where('plantime_two', '>', time());
                                break;
                            case 'done':
                                $query->where('plantime_two', '<', time());
                                break;
                            default:
                                break;
                        }

                        //$query->where('currentstatus', '=', $search['currentstatus']);
                    }

                    if ('sh' == $p->user['role']) {
                        
                    }
                })
                ->orderby('id', 'desc')
                ->paginate(18);


        $a->list = $list;


        return $a;
    }

    /*
     * 跟据request返回签到列表
     * 
     *  */

    public function getlistqiandao($request, $courseic) {
        $o = (object) [];
        $search = (object) [];


        $o->list = DB::table('courses_hour')
                ->where('courseic', $courseic) //是这个课程的
                ->where(function($query) use($search) {
//                    if ('' != $search['title']) {
//                        $query->where('title', 'like', '%' . $search['title'] . '%');
//                    }
//                    if ('' != $search['currentstatus']) {
//                        $query->where('currentstatus', '=', $search['currentstatus']);
//                    }
                })
                ->orderby('id', 'asc')
                ->paginate(200);

        return $o;
    }

    /* 每节课的签到列表

     *      */

    public function classqiandao($request, $classic) {
        $o = (object) [];
        $search = (object) [];

        $rules = array(
            'classid' => 'required|integer'
        );

        $attributes = array(
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            $o->validator = $validator;
            return $o;
        }


        /* 这节课时的信息 */
        $o_hour = DB::table('courses_hour')
                ->where('id', $request->classid)
                ->first();
        if (!$o_hour) {
            return redirect('/showerr')->with('errmessage', '没找到这个课时，无法签到');
        }

        /* 提取这节课的签到信息，按学号做索引 */
        $signinlist = DB::table('courses_signin')
                ->where('coursenumic', $o_hour->coursenum)
                ->get();

        $studentsignin = (object) [];
        foreach ($signinlist as $v) {
            $key = $v->ucode;
            $studentsignin->$key = $v;
        }


        $list = DB::table('courses_signup')
                ->where('itemic', $classic) //是这个课程的
                ->where('auditstatus', 'pass')
                //->where('isdel', 0)
                ->where(function($query) use($search) {
//                    if ('' != $search['title']) {
//                        $query->where('title', 'like', '%' . $search['title'] . '%');
//                    }
//                    if ('' != $search['currentstatus']) {
//                        $query->where('currentstatus', '=', $search['currentstatus']);
//                    }
                })
                ->leftjoin('students', 'courses_signup.ucode', '=', 'students.mycode')
                ->select('courses_signup.*', 'students.realname', 'students.dname as dname', 'students.gender', 'students.mobile', 'students.classname')
                ->orderby('id', 'asc')
                ->paginate(200);

        $o->classid = $request->classid;
        $o->list = & $list;
        $o->studentsignin = & $studentsignin; //提取这节课的签到信息，按学号做索引
        return $o;
    }

    function studentsignin($coursehouric) {
        /* 提取这节课的签到信息，按学号做索引 */
        $signinlist = DB::table('courses_signin')
                ->where('coursenumic', $coursehouric)
                ->get();

        $studentsignin = (object) [];
        foreach ($signinlist as $v) {
            $key = $v->ucode;
            $studentsignin->$key = $v;
        }
        return $studentsignin;
    }

    /* 应到统计 */

    function countyingdao($courseic) {
        /* 提取签到统计 */
        $count = DB::table('courses_signup')
                ->where('itemic', $courseic) //是这个课程的
                ->where('auditstatus', 'pass')
                ->count();
        return $count;
    }

    /* 实到数 */

    function countshidao($courseic, $classic) {
        $count = DB::table('courses_signin')
                ->where('courseic', $courseic) //是这个课程的
                ->where('coursenumic', $classic) //是这节课的
                ->where('issignined', 1)
                ->count();
        return $count;
    }

    function getclass_hour($classid) {
        $data = DB::table('courses_hour')
                ->where('id', $classid)
                ->first();
        return $data;
    }

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

    /* 交作业列表 */

    function listhomework(Request $request, $courseic) {
        $o = (object) [];
        $search = (object) [];

        $rules = array(
            'title' => 'nullable|string|between:1,20'
        );

        $attributes = array(
            "title" => '名称'
        );

        $message = array(
        );

        $o->validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($o->validator->fails()) {
            return $o;
        }

        $search->title = $request->title;
        $search->currentstatus = $request->currentstatus;

        $o->list = DB::table('courses_signup')
                ->where('itemic', $courseic) //是这个活动的
                ->where('auditstatus', 'pass')
                //->where('isdel', 0)
                ->where(function($query) use($search) {
                    if ('' != $search->title) {
                        $query->where('title', 'like', '%' . $search->title . '%');
                    }
                    if ('' != $search->currentstatus) {
                        $query->where('currentstatus', '=', $search->currentstatus);
                    }
                })
                ->leftjoin('students', 'courses_signup.ucode', '=', 'students.mycode')
                ->select('courses_signup.*', 'students.realname', 'students.dname as dname', 'students.gender', 'students.mobile')
                ->orderby('id', 'desc')
                ->paginate(200);


        /* 提取作业统计 */
        $o->yingjiao = DB::table('courses_signup')
                ->where('itemic', $courseic) //是这个课程的
                ->where('auditstatus', 'pass')
                ->count();





        $o->shijiao = DB::table('courses_signup')
                ->where('itemic', $courseic) //是这个活动的
                ->where('homeworkisdone', 1)
                ->count();

        $o->search = $search;
        return $o;
    }

    public function show($id, $user) {
        $a = (object) [];

        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->first();

        $a->data = $data;


        if (!$data) {
            $a->hour = false;
        } else {
            /* 课时 */
            $a->hour = DB::table('courses_hour')
                    ->where('courseic', $data->ic)
                    ->orderby('id', 'asc')
                    ->get();
        }


        return $a;
    }

}
