<?php

/* 校内荣誉审核 */

namespace App\Http\Controllers\manage;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class xiaoneiController extends Controller {

    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->oj = (object) [];

        $this->currentcontroller = '/manage/xiaonei'; //控制器
        $this->viewfolder = 'manage.xiaonei'; //视图路径
        $this->dbname = 'innerhonor';

        $this->oj->nav = 'xiaonei';
        $this->oj->currentcontroller = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $arr_MyactivityTypeList = app('main')->getMyactivityTypeList($_ENV['user']['dic']);

        $list = DB::table($this->dbname)
                ->where('isok', '>', '-1')
                ->whereIn('type_twoic', $arr_MyactivityTypeList)
                ->leftjoin('activity_type', 'innerhonor.type_twoic', '=', 'activity_type.ic')
                ->select('innerhonor.*', 'activity_type.qiantouname as qiantouname')
                ->orderby('id', 'desc')
                ->paginate(18);

        $this->oj->list = $list;
        return view($this->viewfolder . '.index', ['oj' => $this->oj]);
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
        $this->oj->data = $data;


        /* 提取人员时间 */
        $innerhonor_signup = DB::table('innerhonor_signup')
                ->where('mytype', 'innerhonor')
                ->where('itemic', $id)
                ->leftjoin('students', 'innerhonor_signup.ucode', '=', 'students.mycode')
                ->select('innerhonor_signup.*', 'students.realname', 'students.classname', 'students.dname')
                ->orderby('id', 'desc')
                //->leftjoin('activity_type', 'innerhonor.type_twoic', '=', 'activity_type.ic')
                //->select('innerhonor.*', 'activity_type.qiantouname as qiantouname')
                ->paginate(200);

        $this->oj->innerhonor_signup = & $innerhonor_signup;


        /* 提取所有部门，以ic为索引 */
        $this->oj->departmentofic = app('main')->getdepartlistindexic();


        return view($this->viewfolder . '.detail', ['oj' => $this->oj]);
        //
    }

    function dopass($id) {
        /* 检测当前状态 */
        $innerhonor = app('main')->getinnerhonorbyid($id);

        if (1 == $innerhonor->isok) {
            return redirect()->back()->withInput()->withErrors('已经是审核通过状态了，请不要重复操作！');
        }

        $time = time();

        DB::beginTransaction();
        try {
            /* 更新状态 */
            $rs['isok'] = 1;
            $rs['isokucode'] = $_ENV['user']['mycode'];
            $rs['isoktime'] = $time;

            DB::table($this->dbname)->where('id', $id)->update($rs);

            /* 添加审核记录 */
            unset($rs);
            $rs['itemic'] = $id;
            $rs['mytype'] = 'innerhonor';
            $rs['myeventv'] = 'pass';
            $rs['myexplain'] = '';
            $rs['aucode'] = $_ENV['user']['ic'];
            $rs['auname'] = '';
            $rs['dic'] = $_ENV['user']['dic'];
            $rs['ctime'] = $time;

            DB::table('audit')->insert($rs);

            /* 更新学生的学分情况 */
            unset($rs);
            $rs['audited'] = $time;
            $rs['isok'] = 1;
            $rs['plancredit'] = $innerhonor->mycredit;
            $rs['actualcredit'] = $innerhonor->mycredit;
            DB::table('innerhonor_signup')
                    ->where('mytype', 'innerhonor')
                    ->where('itemic', $id)
                    ->update($rs);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }




        return redirect()->back()->withInput()->with('sucinfo', '操作成功！');
    }

    function formunpass($id) {
        $signup = app('main')->getinnerhonorsignupbyid($id);

        return view($this->viewfolder . '.formunpass', ['oj' => $this->oj]);
    }

    function dounpass($id, Request $request) {
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
        $innerhonor = app('main')->getinnerhonorbyid($id);

        if (2 == $innerhonor->isok) {
            return redirect()->back()->withInput()->withErrors('已经是未通过状态了，请不要重复操作！');
        }

        $time = time();


        DB::beginTransaction();
        try {
            /* 更新状态 */
            $rs['isok'] = 2;
            $rs['isokucode'] = $_ENV['user']['mycode'];
            $rs['isoktime'] = $time;
            $rs['notokreason'] = $request->myexplain;

            DB::table($this->dbname)->where('id', $id)->update($rs);

            /* 添加审核记录 */

            $rs = null;

            $rs['itemic'] = $id;
            $rs['mytype'] = 'innerhonor';
            $rs['myeventv'] = 'unpass';
            $rs['myexplain'] = $request->myexplain;
            $rs['aucode'] = $_ENV['user']['ic'];
            $rs['auname'] = '';
            $rs['dic'] = $_ENV['user']['dic'];
            $rs['ctime'] = $time;

            DB::table('audit')->insert($rs);


            /* 更新学生的学分情况 */
            unset($rs);
            $rs['audited'] = $time;
            $rs['isok'] = 2;
            $rs['plancredit'] = $innerhonor->mycredit;
            $rs['actualcredit'] = $innerhonor->mycredit;
            DB::table('innerhonor_signup')
                    ->where('mytype', 'innerhonor')
                    ->where('itemic', $id)
                    ->update($rs);


            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }


        return redirect()->back()->withInput()->with('sucinfo', '操作成功！');
    }

}
