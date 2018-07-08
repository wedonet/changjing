<?php

/* 课程审核 */

namespace App\Http\Controllers\manage;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class course_shenheController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;
    private $courseid; //活动id

    function __construct(Request $request) {
        $this->oj = (object) [];

        $this->currentcontroller = '/manage/course_shenhe'; //控制器
        $this->viewfolder = 'manage.course.shenhe'; //视图路径
        $this->dbname = 'courses_signup';

        $this->oj->nav = 'course';
        $this->oj->currentcontroller = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $this->init($request);

        $search = (object) [];

        $rules = array(
            'ucode' => 'string|between:1,20'
        );

        $attributes = array(
            "ucode" => '学号或姓名'
        );

        $message = array(
        );

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        $search->ucode = $request->ucode;

        $search->auditstatus = $request->auditstatus;

        $this->oj->search = $search;



        $list = DB::table($this->dbname)
                ->where('itemic', $this->oj->course->ic) //是这个活动的
                //->where('isdel', 0)
                ->where(function($query) use($search) {
                    if ('' != $search->ucode) {
                        $query->where('ucode', 'like', '%' . $search->ucode . '%');
                    }
                    if ('' != $search->auditstatus) {
                        if ('new' == $search->auditstatus) {
                            $query->where('auditstatus', '=', '');
                        } else {
                            $query->where('auditstatus', '=', $search->auditstatus);
                        }
                    }
                })
                ->leftjoin('students', 'courses_signup.ucode', '=', 'students.mycode')
                ->select('courses_signup.*', 'students.realname', 'students.dname as dname', 'students.gender', 'students.mobile')
                ->orderby('courses_signup.id', 'desc')
                ->paginate(200);

        $this->oj->list = $list;


        return view($this->viewfolder . '.index', ['oj' => $this->oj]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->j['course_type'] = app('main')->getcoursetypelist();

        return view($this->viewfolder . '.create', ['j' => $this->j]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $rules = array(
            'title' => 'required|string|between:1,50',
            'course_year' => 'required',
            'type_oneic' => 'required|string|between:1,20',
            'type_twoic' => 'required|string|between:1,20',
            'mylevel' => 'required|string|between:1,20',
            'mytimelong' => 'required|integer|between:1,64',
            'plantime_one' => 'required|date',
            'plantime_two' => 'required|date',
            'signuptime_one' => 'required|date',
            'signuptime_two' => 'required|date',
            'sponsor' => 'required|string|between:1,20',
            'myplace' => 'required|string|between:1,50',
            'readme' => 'required|string|between:1,255',
            'homework' => 'required|in:0,1',
            'homeworktime_one' => 'required_if:homework,1|date',
            'homeworktime_two' => 'required_if:homework,1|date',
            'mywayic' => 'required|in:direct,audit',
            'signlimit' => 'required_if:mywayic,accept',
            'other' => 'string|between:1,255',
            'attachmentsurl' => 'string|between:1,255'
        );

        $attributes = array(
            'title' => '名称',
            'course_year' => '学年',
            'type_oneic' => '一级活动类型',
            'type_twoic' => '二级活动类型',
            'mylevel' => '活动级别',
            'mytimelong' => '活动时长',
            'plantime_one' => '活动开始时间',
            'plantime_two' => '活动结束时间',
            'signuptime_one' => '报名开始时间',
            'signuptime_two' => '报名结束时间',
            'sponsor' => '主办单位',
            'myplace' => '活动地点',
            'readme' => '活动介绍',
            'homework' => '是否需要提交作业',
            'homeworktime_one' => '提交作业开始时间',
            'homeworktime_two' => '提交作业结止时间',
            'mywayic' => '报名方式',
            'signlimit' => '报名人数限制',
            'other' => '备注',
            'attachmentsurl' => '附件路径'
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        /* 生成活动名称 */
        $the_course = app('main')->getcoursetypebyic($request->type_oneic);
        $type_onename = $the_course->title;

        $the_course = app('main')->getcoursetypebyic($request->type_twoic);
        $type_twoname = $the_course->title;

        /* 计算学分 * 1000 为了不要小数 */
        $mycredit = $request->mytimelong / 16 * 1000;


        /**/
        $time = time();
        $date = date("Y-m-d H:i:s", $time);

        $rs['ic'] = app('main')->getfirstic();

        $rs['title'] = $request->title;
        $rs['course_year'] = $request->avtivity_year;
        $rs['type_oneic'] = $request->type_oneic;
        $rs['type_twoic'] = $request->type_twoic;
        $rs['type_onename'] = $type_onename;
        $rs['type_twoname'] = $type_twoname;


        $rs['mylevel'] = $request->mylevel;
        $rs['mytimelong'] = $request->mytimelong;
        $rs['mycredit'] = $mycredit;
        $rs['plantime_one'] = strtotime($request->plantime_one);
        $rs['plantime_two'] = strtotime($request->plantime_two);


        $rs['signuptime_one'] = strtotime($request->signuptime_one);
        $rs['signuptime_two'] = strtotime($request->signuptime_two);
        $rs['sponsor'] = $request->sponsor;
        $rs['myplace'] = $request->myplace;


        $rs['readme'] = $request->readme;
        $rs['homework'] = $request->homework;
        $rs['homeworktime_one'] = strtotime($request->homeworktime_one);
        $rs['homeworktime_two'] = strtotime($request->homeworktime_two);

        $rs['mywayic'] = $request->mywayic;
        $rs['signlimit'] = $request->signlimit;
        $rs['other'] = $request->other;
        $rs['attachmentsurl'] = $request->attachmentsurl;



        $rs['isopen'] = 0;
        $rs['sucode'] = '';
        $rs['suname'] = '';
        $rs['auditstatus'] = 'new';
        $rs['signcode'] = app('main')->makecode('stack');

        $rs['currentstatus'] = 'new';
        $rs['created_at'] = $date;

        if (DB::table($this->dbname)->insert($rs)) {
            $suctip[] = '<a href = "' . $this->currentcontroller . '">返回活动管理</a>';
            return ( app('main')->jssuccess('保存成功', $suctip));
        } else {
            $validator->errors()->add('error', '保存失败');
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        //return redirect($this->currentcontroller);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->first();

        $this->j['data'] = $data;

        $this->j['id'] = $id;

        //$this->j['course_type'] = app('main')->getcoursetypelist();

        return view($this->viewfolder . '.detail', ['j' => $this->j]);
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function dopass($id, Request $request) {
        $this->init($request);

        $signup = $this->getsignbyid($id);

        if ('pass' == $signup->auditstatus) {
            return redirect()->back()->withInput()->withErrors('已经是通过状态了，请不要重复审核');
        }

        if ($this->oj->course->checkcount >= $this->oj->course->signlimit) {
            return redirect()->back()->withInput()->withErrors('已超过报名人数限制');
        }

        $rs['auditstatus'] = 'pass';


        DB::beginTransaction();
        try {
            DB::table($this->dbname)->where('id', $id)->update($rs);
            /* 更新通过数 */
            $this->updatepassnum($this->oj->course->ic);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

        return redirect()->back()->withInput()->with('sucinfo', '操作成功！');
    }

    public function unpass($id) {
        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->first();

        $user = app('main')->getstudentbycode($data->ucode);
        $this->oj->user = $user;

        $this->oj->data = $data;

        $this->oj->course_type = app('main')->getactivitytypelist();

        return view($this->viewfolder . '.unpass', ['oj' => $this->oj]);
    }

    /* 审核学生是否能参加活动 */

    public function dounpass($id, Request $request) {
        $this->init($request);

        $rules = array(
            'myexplain' => 'required|string|between:1,255'
        );

        $attributes = array(
            'myexplain' => '原因'
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors(($validator->errors()->toArray()));
        }


        $signup = $this->getsignbyid($id);

        if ('unpass' == $signup->auditstatus) {
            return redirect()->back()->withInput()->withErrors('已经是未通过状态了，请不要重复操作');
        }

        $rs['auditstatus'] = 'unpass';
        $rs['myexplain'] = $request->myexplain;


        DB::beginTransaction();
        try {
            DB::table($this->dbname)->where('id', $id)->update($rs);

            /* 更新通过数 */
            $this->updatepassnum($this->oj->course->ic);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

        return redirect()->back()->withInput()->with('sucinfo', '操作成功！');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        $rules = array(
            'title' => 'required|string|between:1,50',
            'course_year' => 'required',
            'type_oneic' => 'required|string|between:1,20',
            'type_twoic' => 'required|string|between:1,20',
            'mylevel' => 'required|string|between:1,20',
            'mytimelong' => 'required|integer|between:1,64',
            'plantime_one' => 'required|date',
            'plantime_two' => 'required|date',
            'signuptime_one' => 'required|date',
            'signuptime_two' => 'required|date',
            'sponsor' => 'required|string|between:1,20',
            'myplace' => 'required|string|between:1,50',
            'readme' => 'required|string|between:1,255',
            'homework' => 'accepted:0,1',
            'homeworktime_one' => 'required_with:homework|date',
            'homeworktime_two' => 'required_with:homework|date',
            'mywayic' => 'required|in:direct,audit',
            'signlimit' => 'required_if:mywayic,accept',
            'other' => 'string|between:1,255',
            'attachmentsurl' => 'string|between:1,255'
        );

        $attributes = array(
            'title' => '名称',
            'course_year' => '学年',
            'type_oneic' => '一级活动类型',
            'type_twoic' => '二级活动类型',
            'mylevel' => '活动级别',
            'mytimelong' => '活动时长',
            'plantime_one' => '活动开始时间',
            'plantime_two' => '活动结束时间',
            'signuptime_one' => '报名开始时间',
            'signuptime_two' => '报名结束时间',
            'sponsor' => '主办单位',
            'myplace' => '活动地点',
            'readme' => '活动介绍',
            'homework' => '是否需要提交作业',
            'homeworktime_one' => '提交作业开始时间',
            'homeworktime_two' => '提交作业结止时间',
            'mywayic' => '报名方式',
            'signlimit' => '报名人数限制',
            'other' => '备注',
            'attachmentsurl' => '附件路径'
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        /* 生成活动名称 */
        $the_course = app('main')->getcoursetypebyic($request->type_oneic);
        $type_onename = $the_course->title;

        $the_course = app('main')->getcoursetypebyic($request->type_twoic);
        $type_twoname = $the_course->title;

        /* 计算学分 * 1000 为了不要小数 */
        $mycredit = $request->mytimelong / 16 * 1000;


        /**/
        $date = date("Y-m-d H:i:s", time());

        $rs['title'] = $request->title;
        $rs['course_year'] = $request->avtivity_year;
        $rs['type_oneic'] = $request->type_oneic;
        $rs['type_twoic'] = $request->type_twoic;
        $rs['type_onename'] = $type_onename;
        $rs['type_twoname'] = $type_twoname;


        $rs['mylevel'] = $request->mylevel;
        $rs['mytimelong'] = $request->mytimelong;
        $rs['mycredit'] = $mycredit;
        $rs['plantime_one'] = $request->plantime_one;
        $rs['plantime_two'] = $request->plantime_two;


        $rs['signuptime_one'] = $request->signuptime_one;
        $rs['signuptime_two'] = $request->signuptime_two;
        $rs['sponsor'] = $request->sponsor;
        $rs['myplace'] = $request->myplace;


        $rs['readme'] = $request->readme;
        $rs['homework'] = $request->homework;
        $rs['homeworktime_one'] = $request->homeworktime_one;
        $rs['homeworktime_two'] = $request->homeworktime_two;

        $rs['mywayic'] = $request->mywayic;
        $rs['signlimit'] = $request->signlimit;
        $rs['other'] = $request->other;
        $rs['attachmentsurl'] = $request->attachmentsurl;



        $rs['isopen'] = 0;
        $rs['sucode'] = '';
        $rs['suname'] = '';
        $rs['auditstatus'] = 'new';
        $rs['signcode'] = app('main')->makecode('stack');

        $rs['created_at'] = $date;


        DB::table($this->dbname)->where('id', $id)->update($rs);



        $suctip[] = '<a href = "' . $this->currentcontroller . '">返回活动管理</a>';
        return ( app('main')->jssuccess('操作成功', $suctip));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        DB::beginTransaction();
        try {
            $deleteic = DB::table($this->dbname)
                    ->where('id', $id)
                    ->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

        return redirect()->back()->withInput()->withSuccess('删除成功！');
    }

    public function manage($id) {
        return view($this->viewfolder . '.detail', ['j' => $this->j]);
    }

    /* 批量导出

     */

    public function daochu($ic) {
        require_once(base_path() . '/resources/views/init.blade.php');

        $data = DB::table($this->dbname)
                ->where('itemic', $ic)
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
            $re['name'] = $student->realname;
            $re['gender'] = $student->gender;
            $re['classname'] = $student->classname;
            $re['dname'] = $student->dname;
            $re['mobile'] = $student->mobile;
            $re['created_at'] = $data[$i]->created_at;
            $re['mystate'] = $data[$i]->mystate;


            $re['auditstatus'] = checkstatus($data[$i]->auditstatus);

            $cellData[$j] = $re;
        }

        Excel::create('学生审核报名表', function($excel) use ($cellData) {
            $excel->sheet('score', function($sheet) use ($cellData) {
                $sheet->setAutoSize(false);
                $sheet->rows($cellData);
            });
        })->export('xls');
    }

    /* 提取活动报名信息 */

    public function getsignbyid($id) {
        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->first();

        return $data;
    }

    /* 更新通过数 */

    private function updatepassnum($aic) {
        /* 计算通过数 */
        $count = DB::table('courses_signup')
                ->where('itemic', $aic)
                ->where('auditstatus', 'pass')
                ->count();
        /* 更新 */
        $rs['checkcount'] = $count;

        /* 计算报名数 */
        $count = DB::table('courses_signup')
                ->where('itemic', $aic)
                ->count();
        $rs['signcount'] = $count;


        DB::table('courses')
                ->where('ic', $aic)
                ->update($rs);
    }

    /* 批量审核通过 */

    public function allpass(Request $request) {
        $this->init($request);

        $rules = array(
            'ids' => 'required|array'
        );

        $attributes = array(
            'ids' => '记录'
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors(($validator->errors()->toArray()));
        }


        if (count($request->ids) < 1) {
            return redirect()->back()->withInput()->withErrors('请选择要操作的记录');
        }


        /* 检测是否超量 */
        if (( $this->oj->course->checkcount + count($request->ids)) > $this->oj->course->signlimit) {
            return redirect()->back()->withInput()->withErrors('总数将超过报名人数限制,请重新选择');
            //$validator->errors()->add('error', '总数将超过报名人数限制，请重新选择');
            //return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        $rs['auditstatus'] = 'pass';
        DB::table($this->dbname)
                ->whereIn('id', $request->ids)
                ->where('itemic', $this->oj->course->ic)
                ->update($rs);

        /* 更新通过数 */
        $this->updatepassnum($this->oj->course->ic);

        return redirect()->back()->withInput()->with('sucinfo', '批量审核完成,页面将自动刷新！');
    }

    public function import(Request $request) {
        $this->init($request);

        return view($this->viewfolder . '.formimport', ['oj' => $this->oj]);
    }

    public function exporttemplate(Request $request) {
        $this->init($request);

        $data = DB::table($this->dbname)
                ->where('itemic', $this->oj->course->ic)
                ->get();

//        dd($data);
        $n = count($data);
        $keshi[] = '学号';
        $keshi[] = '姓名';
        $keshi[] = '性别';
        $keshi[] = '班级';
        $keshi[] = '申请陈述';


        $cellData[0] = $keshi;
//        $cellData[1]=$data[0];



        Excel::create('填报学生课程报名表', function($excel) use ($cellData) {
            $excel->sheet('score', function($sheet) use ($cellData) {
                $sheet->setAutoSize(false);
                $sheet->rows($cellData);
            });
        })->export('xls');
    }

    public function doimport(Request $request) {
        ini_set('max_execution_time', '0');
        ini_set('memory_limit', '1024M');

        $this->init($request);

        $course = $this->oj->course;

        $rules = array(
            'attachmentsurl' => 'required|string|between:1,255',
        );

        $attributes = array(
        );

        $message = array(
        );

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors()->toArray());
        }

        /* 检查活动状态，结束后就不能再导入了 */
        if ($this->oj->course->plantime_two < time()) {
            return redirect()->back()->withInput()->withErrors('导入失败，活动已结束，不能再报名了');
        }

        $filepath = $request->attachmentsurl;

        $filename = 'courses_signup_' . $this->oj->course->id . '.' . $this->getoldext($filepath);

        if (@!copy(public_path($filepath), 'upload/files/' . $filename)) {
            return redirect()->back()->withInput()->withErrors('导入失败，请重新上传');
        }
        unlink(public_path($filepath));
        //echo $filepath;
        //die;
        //$filePath = 'excel/student/201712/2.xlsx';
        $filepath = 'upload/files/' . $filename;

        $results = Excel::load($filepath)->getSheet(0)->toArray();



        $a = array(
            'ucode' => array(
                'title' => '学号'
            ),
            'realname' => array(
                'title' => '姓名'
            ),
            'classname' => array(
                'title' => '班级'
            ),
            'mystate' => array(
                'title' => '申请陈述'
            ),
        );

        foreach ($a as $key => $v) {
            $a[$key]['num'] = $this->getmyorder($results[0], $a[$key]['title']);
        }

        /* 检测有没有需要的字段 */
        foreach ($a as $key => $v) {
            if ($v['num'] < 0) {
                return redirect()->back()->withInput()->withErrors('导入失败，没找到' . $v['title'] . '列!');
            }
        }

        /* 检测学生是不是存在 */
        //$notinlist = $this->getnotinstudent($a);
        //if('' != $notinlist ){
        //    return redirect()->back()->withInput()->withErrors('导入失败，没找到' . $notinlist );
        //}


        /* 准备导入 */
        $arrayrs = [];
        $signstudents = $results;
        for ($i = 1; $i < count($signstudents); $i++) {
            $ucode = $signstudents[$i][$a['ucode']['num']] . '';
            $realname = $signstudents[$i][$a['realname']['num']] . '';

            $student = app('main')->getstudentbycode($ucode);
            /* 检查这个学生在不在 */
            if (!$student) {
                return redirect()->back()->withInput()->withErrors('导入失败，没找到这个学生，学号：' . $ucode . ', 姓名:' . $realname);
            } elseif ($student->realname != $realname) {
                return redirect()->back()->withInput()->withErrors('导入失败，没找到这个学生，学号：' . $ucode . ', 姓名:' . $realname);
            }

            /* 如果报过名了则跳过 */
            if (DB::table('courses_signup')->where('ucode', $ucode)->where('itemic', $this->oj->course->ic)->count() > 0) {
                continue;
            }

            $rs['mytype'] = 'course';
            //$rs['courseic'] = $this->oj->course->ic;
            $rs['itemic'] = $this->oj->course->ic;
            $rs['ucode'] = $ucode;
            $rs['created_at'] = date("Y-m-d H:i:s", time());
            /**/
            $rs['mystate'] = $signstudents[$i][$a['mystate']['num']].'';
            $rs['auditstatus'] = 'pass';
            $rs['audited'] = time();



            $arrayrs[] = $rs;
        }

        if (count($arrayrs) > 0) {
            $num = (count($arrayrs) + $course->checkcount) - $course->signlimit;
            if ($num > 0) {
                return redirect()->back()->withInput()->withErrors('导入失败，超过人数限制' . $num . '人，请修改后重新提交！');
            }

            DB::transaction(function () use ($arrayrs) {
                foreach ($arrayrs as $v) {
                    DB::table('courses_signup')
                            ->insert($v);
                }
            });
        }

        $this->updatepassnum($this->oj->course->ic);

        return redirect()->back()->with('sucinfo', '导入成功！');
    }

    public function export(Request $request) {
        require_once(base_path() . '/resources/views/init.blade.php');

        $this->init($request);

        $data = DB::table($this->dbname)
                ->where('itemic', $this->oj->course->ic)
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


            $re['auditstatus'] = checkstatus($data[$i]->auditstatus);

            $cellData[$j] = $re;
        }

        Excel::create('学生课程报名表', function($excel) use ($cellData) {
            $excel->sheet('score', function($sheet) use ($cellData) {
                $sheet->setAutoSize(true);
                $sheet->rows($cellData);
            });
        })->export('xls');
    }

    private function init($request) {
        $this->oj->course = $request->oj->course;
        $this->oj->courseid = $request->oj->course->id;
    }

    /* 取原始扩展名 */

    public function getoldext($filename) {
        $a = explode('.', $filename);

        return $a[count($a) - 1];
    }

    /* 得到在数组中的次序，没有返回-1 */

    private function getmyorder($a, $keytitle) {
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
