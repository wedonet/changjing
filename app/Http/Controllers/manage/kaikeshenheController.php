<?php

/* 牵头部门对课程的审核 */

namespace App\Http\Controllers\manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class kaikeshenheController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->oj = (object) [];

        $this->currentcontroller = '/manage/kaikeshenhe'; //控制器
        $this->viewfolder = 'manage.kaikeshenhe'; //视图路径
        $this->dbname = 'courses';

        $this->oj->nav = 'kaikeshenhe';
        $this->oj->currentcontroller = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $search = (object) [];

        $rules = array(
            'title' => 'string|between:1,20',
            'auditstatus' => 'nullable|string|between:1,20'
        );

        $attributes = array(
            "title" => '名称'
        );

        $message = array(
        );

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        $search->title = $request->title;
        $search->currentstatus = $request->currentstatus;
        $search->auditstatus = $request->auditstatus;


        /* 1. 查出哪些二级分类是我这个部门的 */
        /* 2. 查这个二级分类的活动 */
        $arr_MyactivityTypeList = app('main')->getMyactivityTypeList($_ENV['user']['dic']);


        $list = DB::table($this->dbname)
                ->where('isdel', 0)
                ->whereIn('type_twoic', $arr_MyactivityTypeList)
                ->where(function($query) use($search) {
//                    if ('' != $search['title']) {
//                        $query->where('title', 'like', '%' . $search['title'] . '%');
//                    }
                    if ('' != $search->auditstatus) {
                        $query->where('auditstatus', $search->auditstatus);
                    }
                })
                ->orderby('id', 'desc')
                ->get();


        $this->oj->search = $search;
        $this->oj->list = $list;

        return view($this->viewfolder . '.index', ['oj' => $this->oj]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view($this->viewfolder . '.create', ['j' => $this->j]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        return redirect($this->currentcontroller);
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
                ->where('isdel', 0)
                ->first();

        $this->oj->data = $data;

        /* get未通过审核的原因 */
        $o_audit = DB::table('audit')
                ->where('itemic', $data->ic)
                ->where('mytype', 'course')
                //->where('isdel', 0)
                ->orderby('id', 'desc')
                ->first();
        $this->oj->o_audit = $o_audit;


        /* get未通过审核的原因列表 */
        $audit = DB::table('audit')
                ->where('itemic', $data->ic)
                ->where('mytype', 'course')
                //->where('isdel', 0)
                ->orderby('id', 'asc')
                ->get();
        $this->oj->audit = $audit;


        /* 提取开课时间 */
        $courses_hour = DB::table('courses_hour')
                ->where('courseic', $data->ic)
                ->get();

        $this->oj->courses_hour = & $courses_hour;
        //$this->j['activity_type'] = app('main')->getactivitytypelist();

        /* 提取所有部门，以ic为索引 */
        $this->oj->departmentofic = app('main')->getdepartlistindexic();

        return view($this->viewfolder . '.detail', ['oj' => $this->oj]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->first();

        $this->j['data'] = $data;

        return view($this->viewfolder . '.edit', ['j' => $this->j]);
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
            'title' => 'alpha_num|between:1,20',
            'readme' => 'alpha_num|between:1,255',
            'cls' => 'integer'
        );

        $attributes = array(
            "title" => '名称',
            'readme' => '简介',
            'cls' => '排序'
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        /**/

        $rs['title'] = $request->title;
        $rs['readme'] = $request->readme;
        $rs['cls'] = $request->cls;



        DB::table($this->dbname)->where('id', $id)->update($rs);

        $suctip[] = '<a href="' . $this->currentcontroller . '">返回部门管理</a>';
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

    public function dopass($id) {
        /* 检测当前状态 */
        $m_course = app('main')->getcoursebyid($id);

        if ('pass' == $m_course->auditstatus) {
            return redirect()->back()->withInput()->withErrors('已经是审核通过状态了，请不要重复操作！');
        }

        $time = time();

        /* 更新状态 */
        $rs['auditstatus'] = 'pass';
        $rs['aucode'] = '';
        $rs['auname'] = '';
        $rs['audittime'] = time();

        DB::table($this->dbname)->where('id', $id)->update($rs);

        /* 添加审核记录 */

        $rs = null;
        $rs['itemic'] = $m_course->ic;
        $rs['mytype'] = 'course';
        $rs['myeventv'] = 'pass';
        $rs['aucode'] = '';
        $rs['auname'] = '';
        $rs['dic'] = $_ENV['user']['dic'];
        $rs['ctime'] = $time;

        DB::table('audit')->insert($rs);

        return redirect()->back()->withInput()->with('sucinfo', '操作成功！');
    }

    public function formunpass($id) {
        $signup = app('main')->getactivitysignupbyid($id);

        //$this->j['signup'] = $signup;

        return view($this->viewfolder . '.formunpass', ['j' => $this->j]);
    }

    public function dounpass($id, Request $request) {
        $rules = array(
            'myexplain' => 'required|string|between:1,255',
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



        /* 检测当前状态 */
        $course = app('main')->getcoursebyid($id);

        if ('unpass' == $course->auditstatus) {
            return redirect()->back()->withInput()->withErrors('已经是未通过状态了，请不要重复操作！');
        }

        $time = time();


        DB::beginTransaction();
        try {
            /* 更新状态 */
            $rs['auditstatus'] = 'unpass';
            $rs['aucode'] = '';
            $rs['auname'] = '';
            $rs['audittime'] = time();

            DB::table($this->dbname)->where('id', $id)->update($rs);

            /* 添加审核记录 */

            $rs = null;

            $rs['itemic'] = $course->ic;
            $rs['mytype'] = 'course';
            $rs['myeventv'] = 'unpass';
            $rs['myexplain'] = $request->myexplain;
            $rs['aucode'] = $_ENV['user']['ic'];
            $rs['auname'] = '';
            $rs['dic'] = $_ENV['user']['dic'];
            $rs['ctime'] = $time;

            DB::table('audit')->insert($rs);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }


        return redirect()->back()->withInput()->with('sucinfo', '操作成功！');
    }

}
