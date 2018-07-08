<?php

namespace App\Repositories;

/* 活动 */

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use Maatwebsite\Excel\Facades\Excel;

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
class activity {

    public $dbname;

    function __construct() {
        $this->dbname = 'activity';
    }

    public function index($request) {
        $a = (object) [];

        $a->rules = array(
            'title' => 'string|between:1,20',
            'currentstatus' => 'string|between:1,20',
            'auditstatus' => 'string|between:1,20'
        );

        $a->attributes = array(
            "title" => '活动名称',
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

    /* $p 参数 $p->type fq sh admin
     * $p->uic 用户ic
     *  */

    public function getlist($db, $search, $p) {
        $list = DB::table($db)
                ->where('isdel', 0)
                ->where(function($query) use($search) {
                    if ('' != $search->title) {
                        $query->where('title', 'like', '%' . $search->title . '%');
                    }
                    if ('' != $search->currentstatus) {
                        switch ($search->currentstatus) {
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
                    }

                    if ('' != $search->auditstatus) {
                        switch ($search->auditstatus) {
                            case 'new':
                                $query->where('auditstatus', 'new');
                                break;
                            case 'pass':
                                $query->where('auditstatus', 'pass');
                                break;
                            case 'unpass':
                                $query->where('auditstatus', 'unpass');
                                break;
                            default:
                                break;
                        }
                    }
                })
                ->where(function($query) use($p) {
                    if ('fq' == $p->type) {
                        $query->where('sucode', $p->uic);
                    }
                    if ('sh' == $p->type) {
                        /* 1. 查出哪些二级分类是我这个部门的 */
                        /* 2. 查这个二级分类的活动 */
                        $arr_MyactivityTypeList = $this->getMyactivityTypeList($p->dic);
                        $query->whereIn('type_twoic', $arr_MyactivityTypeList);
                    }
                })
                ->orderby('id', 'desc')
                ->paginate(20);

        return $list;
    }

    /* 活动的各种管理操作 */

    function init_activity($request) {
        /* 取活动信息 */
        $aid = $request->aid;

        //有可能用aid或activityid传过来的
        if ('' == $aid) {
            $aid = $request->activityid;
        }


        /* 提取活动 */
        $j['activity'] = app('main')->getactivitybyid($aid);
        $j['aid'] = $aid;

        return $j;
    }

    function activity_audit_index() {
        
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

    /* 报名审核列表 */

    function shenhelist($request, $activity) {
        $a = (object) [];
        $search = (object) [];
        $p = (object) [];

        $activityic = $activity->ic;
        $activityid = $activity->id;

        $rules = array(
            'ucode' => 'nullable|string|between:1,20'
        );

        $attributes = array(
            "ucode" => '学号或姓名'
        );

        $message = array(
        );

        $a->validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($a->validator->fails()) {
            return ( $a );
        }

        $search->ucode = $request->ucode;
        $search->auditstatus = $request->auditstatus;

        $a->search = $search;

        /* 处理查询条件 */
        /* 输入姓名时，按姓名查找出学号 */
        if (!preg_match('/^\d*$/', $search->ucode)) {
            $p->nameucode = app('main')->getstudentcodebyname($search->ucode); //从姓名搜索来的ucode数组
        } else {
            $p->ucode = $search->ucode;
        }
        /**/
        $p->auditstatus = $search->auditstatus;


        $list = DB::table('activity_signup')
                ->where('activityic', $activityic) //是这个活动的
                ->where(function($query) use($p) {
                    if (isset($p->ucode)) {
                        $query->where('ucode', 'like', '%' . $p->ucode . '%');
                    }
                    /* 按姓名转成的学号数组搜索 */
                    if (isset($p->nameucode)) {
                        $query->whereIn('ucode', $p->nameucode);
                    }
                    if (isset($p->auditstatus)) {
                        if ('new' == $p->auditstatus) {
                            $query->where('auditstatus', '=', '');
                        } else {
                            $query->where('auditstatus', '=', $p->auditstatus);
                        }
                    }
                })
                ->leftjoin('students', 'activity_signup.ucode', '=', 'students.mycode')
                ->select('activity_signup.*', 'students.realname', 'students.dname as dname', 'students.gender', 'students.mobile')
                ->orderby('activity_signup.id', 'desc')
                ->paginate(18);

        $list->appends(['aid' => $activityid])
                ->appends(object_to_array($search))
                ->links();

        $a->list = $list;

        return $a;
    }

    /* 导出审核表 */

    function shenheexport($activity) {
        require_once(base_path() . '/resources/views/init.blade.php');

        $ic = $activity->ic;

        $data = DB::table('activity_signup')
                ->where('activityic', $ic)
                ->get();
//        dd($data);
        $n = count($data);
        $keshi[] = '学号';
        $keshi[] = '姓名';
        $keshi[] = '性别';
        $keshi[] = '班级';
        $keshi[] = '学院';
        $keshi[] = '手机号';
        $keshi[] = '报名时间';
        $keshi[] = '申请陈述';
        $keshi[] = '审核状态';
        $cellData[0] = $keshi;
//        $cellData[1]=$data[0];

        for ($i = 0; $i < $n; $i++) {
            $j = $i + 1;
            $re['code'] = $data[$i]->ucode;
            $student = DB::table('students')->where('mycode', $data[$i]->ucode)->first();

            /* 如果已经被删除了 */
            if (!$student) {
                $student = (object) [];
                $student->realname = '已删除';
                $student->gender = '-';
                $student->classname = '-';
                $student->dname = '-';
                $student->mobile = '-';
            }

            $re['name'] = $student->realname;
            $re['gender'] = $student->gender;
            $re['classname'] = $student->classname;
            $re['dname'] = $student->dname;
            $re['mobile'] = $student->mobile;
            $re['created_at'] = $data[$i]->created_at;
            $re['mystate'] = $data[$i]->mystate;

            $re['activityisok'] = checkstatus($data[$i]->auditstatus);

            $cellData[$j] = $re;
        }

        Excel::create('学生审核报名表', function($excel) use ($cellData) {
            $excel->sheet('score', function($sheet) use ($cellData) {
                $sheet->rows($cellData);
            });
        })->export('xls');
    }

    function signinlist($request, $activity) {
        $a = (object) [];
        $search = (object) [];
        $statistics = (object) [];


        $rules = array(
            'ucode' => 'nullable|string|between:1,20'
        );

        $attributes = array(
            "ucode" => '学号或姓名'
        );

        $message = array(
        );

        $a->validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($a->validator->fails()) {
            return ( $a );
        }


        $search->title = $request->title;

        $list = DB::table('activity_signup')
                ->where('activityic', $activity->ic) //是这个活动的
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
                ->leftjoin('students', 'activity_signup.ucode', '=', 'students.mycode')
                ->select('activity_signup.*', 'students.realname', 'students.dname as dname', 'students.gender', 'students.mobile')
                ->orderby('id', 'asc')
                ->paginate(18);

        $a->list = $list;




        /* 提取签到统计 */
        $l = DB::table('activity_signup')
                ->where('activityic', $activity->ic) //是这个活动的
                ->where('auditstatus', 'pass')
                ->count();


        $statistics->yingdao = $l; //     


        $l = DB::table('activity_signup')
                ->where('activityic', $activity->ic) //是这个活动的
                ->where('issignined', 1)
                ->count();


        $statistics->shidao = $l; //    

        $a->search = $search;
        $a->statistics = $statistics;

        return $a;
    }

    /* 导出签到表 */

    function signinexport($activity) {
        require_once(base_path() . '/resources/views/init.blade.php');

        $ic = $activity->ic;
        $data = DB::table('activity_signup')
                ->where('auditstatus', 'pass')
                ->where('activityic', $activity->ic)
                ->get();

//        dd($data);
        $n = count($data);
        $keshi[] = '学号';
        $keshi[] = '姓名';
        $keshi[] = '性别';
        $keshi[] = '班级';
        $keshi[] = '学院';
        $keshi[] = '手机号';
        $keshi[] = '是否签到';
        $keshi[] = '入场时间';
        $keshi[] = '是否签退';
        $keshi[] = '退场时间';
        $cellData[0] = $keshi;
//        $cellData[1]=$data[0];

        for ($i = 0; $i < $n; $i++) {
            $j = $i + 1;
            $re['code'] = $data[$i]->ucode;
            $student = DB::table('students')->where('mycode', $data[$i]->ucode)->first();
            $re['name'] = $student->realname;
            $re['gender'] = $student->gender;
            $re['classname'] = $student->classname;
            $re['dname'] = $student->dname;
            $re['mobile'] = $student->mobile;
            if ($data[$i]->issignined == 1) {
                $re['issignined'] = '是';
            } elseif ($data[$i]->issignined == 0) {
                $re['issignined'] = '否';
            }
            if ($data[$i]->issignined == 1) {
                $re['issignined'] = '是';
            } elseif ($data[$i]->issignined == 0) {
                $re['issignined'] = '否';
            }
            $re['signintime'] = formattime2($data[$i]->signintime);
            if ($data[$i]->issignoffed == 1) {
                $re['issignoffed'] = '是';
            } elseif ($data[$i]->issignoffed == 0) {
                $re['issignoffed'] = '否';
            }
            $re['signoffedime'] = formattime2($data[$i]->signoffedime);
            $cellData[$j] = $re;
        }

        Excel::create('学生签到表', function($excel) use ($cellData) {
            $excel->sheet('score', function($sheet) use ($cellData) {
                $sheet->rows($cellData);
            });
        })->export('xls');
    }

    function homeworklist($activity, Request $request) {
        $a = (object) [];
        $search = (object) [];
        $statistics = (object) [];

        $rules = array(
            'title' => 'string|between:1,20'
        );

        $attributes = array(
            "title" => '活动名称'
        );

        $message = array(
        );

        $a->validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($a->validator->fails()) {
            return $a;
        }

        $search->title = $request->title;
        $search->currentstatus = $request->currentstatus;

        $a->search = $search;

        $p = $search;


        $list = DB::table('activity_signup')
                ->where('activityic', $activity->ic) //是这个活动的
                ->where('auditstatus', 'pass')
                //->where('isdel', 0)
                ->where(function($query) use($p) {
                    if ('' != $p->title) {
                        $query->where('title', 'like', '%' . $p->title . '%');
                    }
                    if ('' != $p->currentstatus) {
                        $query->where('currentstatus', '=', $p->currentstatus);
                    }
                })
                ->leftjoin('students', 'activity_signup.ucode', '=', 'students.mycode')
                ->select('activity_signup.*', 'students.realname', 'students.dname as dname', 'students.gender', 'students.mobile')
                ->orderby('id', 'desc')
                ->get();

        $a->list = $list;


        /* 提取作业统计 */
        $l = DB::table('activity_signup')
                ->where('activityic', $activity->ic) //是这个活动的
                ->where('auditstatus', 'pass')
                ->count();


        $statistics->yingjiao = $l; //     


        $l = DB::table('activity_signup')
                ->where('activityic', $activity->ic) //是这个活动的
                ->where('homeworkisdone', 1)
                ->count();


        $statistics->shijiao = $l; //    

        $a->statistics = $statistics;

        return $a;
    }

    function homeworkexport($activity) {
        require_once(base_path() . '/resources/views/init.blade.php');

        $ic = $activity->ic;

        $data = DB::table('activity_signup')
                ->where('auditstatus', 'pass')
                ->where('activityic', $ic)
                ->get();
//        dd($data);
        $n = count($data);
        $keshi[] = '学号';
        $keshi[] = '姓名';
        $keshi[] = '性别';
        $keshi[] = '班级';
        $keshi[] = '学院';
        $keshi[] = '手机号';
        $keshi[] = '是否完成作业';
        $keshi[] = '是否通过';
        $cellData[0] = $keshi;
//        $cellData[1]=$data[0];

        for ($i = 0; $i < $n; $i++) {
            $j = $i + 1;
            $re['code'] = $data[$i]->ucode;
            $student = DB::table('students')->where('mycode', $data[$i]->ucode)->first();
            $re['name'] = $student->realname;
            $re['gender'] = $student->gender;
            $re['classname'] = $student->classname;
            $re['dname'] = $student->dname;
            $re['mobile'] = $student->mobile;
            /**/
            $re['homeworkisok'] = yorn($data[$i]->homeworkisok);


            $re['homeworkisok'] = yorn($data[$i]->homeworkisok);

            $cellData[$j] = $re;
        }

        Excel::create($activity->title . '学生作业记录表', function($excel) use ($cellData) {
            $excel->sheet('score', function($sheet) use ($cellData) {
                $sheet->rows($cellData);
            });
        })->export('xls');
    }

    function creditlist($activity, Request $request) {
        $a = (object) [];
        $search = (object) [];
        $statistics = (object) [];


        $rules = array(
            'title' => 'string|between:1,20'
        );

        $attributes = array(
            "title" => '活动名称'
        );

        $message = array(
        );

        $a->validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($a->validator->fails()) {
            return $a;
        }

        $search->title = $request->title;
        $search->currentstatus = $request->currentstatus;
        $p = $search;

        $a->search = $search;




        $list = DB::table('activity_signup')
                ->where('activityic', $activity->ic) //是这个活动的
                ->where('auditstatus', 'pass')
                //->where('isdel', 0)
                ->where(function($query) use($p) {
                    if ('' != $p->title) {
                        $query->where('title', 'like', '%' . $p->title . '%');
                    }
                    if ('' != $p->currentstatus) {
                        $query->where('currentstatus', '=', $p->currentstatus);
                    }
                })
                ->leftjoin('students', 'activity_signup.ucode', '=', 'students.mycode')
                ->select('activity_signup.*', 'students.realname', 'students.dname as dname', 'students.gender', 'students.mobile')
                ->orderby('id', 'desc')
                ->paginate(18);

        $a->list = $list;


        /* 提取签到统计 */
        /* 总数 */
        $l = DB::table('activity_signup')
                ->where('activityic', $activity->ic) //是这个活动的
                ->where('auditstatus', 'pass')
                ->count();
        $statistics->all = $l; //     

        /* 已评价数 */
        $l = DB::table('activity_signup')
                ->where('activityic', $activity->ic) //是这个活动的
                ->where('auditstatus', 'pass')
                ->where('activityisok', '>', 0)
                ->count();
        $statistics->yiping = $l; //    

        /* 通过 */
        $l = DB::table('activity_signup')
                ->where('activityic', $activity->ic) //是这个活动的
                ->where('auditstatus', 'pass')
                ->where('activityisok', 1)
                ->count();
        $statistics->pass = $l; //   

        /* 未通过 */
        $l = DB::table('activity_signup')
                ->where('activityic', $activity->ic) //是这个活动的
                ->where('auditstatus', 'pass')
                ->where('activityisok', 2)
                ->count();
        $statistics->unpass = $l; //   

        $a->statistics = $statistics;

        return $a;
    }

    function creditexport($activity) {
        require_once(base_path() . '/resources/views/init.blade.php');
        $ic = $activity->ic;

        $data = DB::table('activity_signup')
                ->where('auditstatus', 'pass')
                ->where('activityic', $ic)
                ->orderby('id', 'desc')
                ->get();
//        dd($data);
        $n = count($data);
        $keshi[] = '学号';
        $keshi[] = '姓名';
        $keshi[] = '性别';
        $keshi[] = '班级';
        $keshi[] = '学院';
        /**/
        $keshi[] = '手机号';
        $keshi[] = '作业是否通过';
        $keshi[] = '活动是否通过';
        $keshi[] = '学分';
        $keshi[] = '等级';
        $cellData[0] = $keshi;
//        $cellData[1]=$data[0];

        for ($i = 0; $i < $n; $i++) {
            $j = $i + 1;
            $re['code'] = $data[$i]->ucode;
            $student = DB::table('students')->where('mycode', $data[$i]->ucode)->first();
            $re['name'] = $student->realname;
            $re['gender'] = $student->gender;
            $re['classname'] = $student->classname;
            $re['dname'] = $student->dname;
            /**/
            $re['mobile'] = $student->mobile;
            $re['homeworkisok'] = homeworkokyorn(yorn($data[$i]->homeworkisok), $activity->homework);
            $re['activityisok'] = yorn($data[$i]->activityisok);



            $re['actualcreidt'] = $data[$i]->actualcreidt / 1000;
            if ($data[$i]->mylevel == 1) {
                $re['mylevel'] = 'A';
            } elseif ($data[$i]->mylevel == 2) {
                $re['mylevel'] = 'B';
            } elseif ($data[$i]->mylevel == 3) {
                $re['mylevel'] = 'C';
            } elseif ($data[$i]->mylevel == 4) {
                $re['mylevel'] = 'D';
            } elseif ($data[$i]->mylevel == 0) {
                $re['mylevel'] = '未评分';
            }
            $cellData[$j] = $re;
        }

        Excel::create('学生学分记录表', function($excel) use ($cellData) {
            $excel->sheet('score', function($sheet) use ($cellData) {
                $sheet->rows($cellData);
            });
        })->export('xls');
    }

    function appraiselist($activity, $request) {
        $a = (object) [];
        $search = (object) [];
        $p = (object) [];
        $statistics = (object) [];


        $rules = array(
            'title' => 'string|between:1,20'
        );

        $attributes = array(
            "title" => '活动名称'
        );

        $message = array(
        );

        $a->validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($a->validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        $search->title = $request->title;

        $search->currentstatus = $request->currentstatus;

        $a->search = $search;
        $p = $search;




        $list = DB::table('activity_signup')
                ->where('activityic', $activity->ic)
                ->where('auditstatus', 'pass')
                ->where('appraise', '>', 0)
                //->where('isdel', 0)
//                ->where(function($query) use($search) {
//                    if ('' != $search['title']) {
//                        $query->where('title', 'like', '%' . $search['title'] . '%');
//                    }
//                    if ('' != $search['currentstatus']) {
//                        $query->where('currentstatus', '=', $search['currentstatus']);
//                    }
//                })
                ->leftjoin('students', 'activity_signup.ucode', '=', 'students.mycode')
                ->select('activity_signup.*', 'students.realname', 'students.dname as dname', 'students.gender', 'students.mobile')
                // ->leftjoin('students', 'activity_signup.ucode', '=', 'students.mycode')
                // ->select('activity_signup.*', 'students.realname', 'students.dname as dname', 'students.gender', 'students.mobile')
                ->orderby('activity_signup.id', 'desc')
                ->paginate(18);

        $a->list = $list;


        /* 评价统计 */
        $l = DB::table('activity_signup')
                ->select(DB::raw('count(*) as count'), 'appraise')
                ->where('activityic', $activity->ic)
                ->where('auditstatus', 'pass')
                ->groupBy('appraise')
                ->get();
        $array = [];
        if (count($l) > 0) {
            foreach ($l as $v) {
                $array[$v->appraise] = $v->count;
            }
        }

        $a->statistics = $array;

        return $a;
    }

}
