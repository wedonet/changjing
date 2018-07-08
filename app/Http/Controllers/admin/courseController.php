<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use App\Repositories\course as courseRepository;

class courseController extends Controller {

    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct(courseRepository $cr) {
        $this->oj = (object) [];
        $this->cr = $cr;

        $this->currentcontroller = '/adminconsole/course'; //控制器
        $this->viewfolder = 'admin.course'; //视图路径
        $this->dbname = 'courses';

        $this->oj->nav = 'course';
        $this->oj->currentcontroller = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $o = $this->cr->getlist($request, $_ENV['user']);

        if ($o->validator->fails()) {
            return redirect()->back()->withInput()->withErrors(($validator->errors()->toArray()));
        }

        $this->oj->search = $o->search;
        $this->oj->list = $o->list;

        /* 提取所有部门，以ic为索引 */
        $this->oj->ActivityIndexIc = app('main')->getActivityIndexIc();

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
        $o = $this->cr->show($id, $_ENV['user']);

        $this->oj->id = $id;
        $this->oj->courseid = $id;
        $this->oj->course = & $o->data;
        $this->oj->data = & $o->data;
        $this->oj->hour = & $o->hour;


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

    /* 导出课程 */

    public function export() {
        require_once(base_path() . '/resources/views/init.blade.php');

        $data = DB::table($this->dbname)
                ->get();

        $head = array(
            '名称',
            '学年',
            '一级类型',
            '二级类型',
            /**/
            '活动开始时间',
            '活动结束时间',
            '活动报名开始时间',
            '活动报名结束时间',
            /**/
            '主办单位',
            '活动地点',
            '活动介绍',
            '是否需要提交作业',
            '提交作业开始时间',
            /**/
            '提交作业结止时间',
            '报名方式',
            '报名人数限制',
            '备注',
            /**/
            '联系人姓名',
            '联系电话'
        );

        $list[0] = $head;

        foreach ($data as $v) {
            unset($rs);
            $rs['title'] = $v->title;
            $rs['activity_year'] = $v->activity_year;
            $rs['type_onename'] = $v->type_onename;
            $rs['type_twoname'] = $v->type_twoname;

            /**/
            $rs['plantime_one'] = formattime2($v->plantime_one);
            $rs['plantime_two'] = formattime2($v->plantime_two);
            $rs['signuptime_one'] = formattime2($v->signuptime_one);
            $rs['signuptime_two'] = formattime2($v->signuptime_two);
            /**/
            $rs['sponsor'] = $v->sponsor;
            $rs['myplace'] = $v->myplace;
            $rs['readme'] = $v->readme;
            $rs['homework'] = y01($v->homework);
            $rs['homeworktime_one'] = formattime2($v->homeworktime_one);
            /**/
            $rs['homeworktime_two'] = formattime2($v->homeworktime_two);
            $rs['mywayic'] = signupmethod($v->mywayic);
            $rs['signlimit'] = $v->signlimit;
            $rs['other'] = $v->other;

            $rs['conname'] = $v->conname;
            $rs['contel'] = $v->contel;

            $list[] = $rs;
        }


        Excel::create('课程表', function($excel) use ($list) {
            $excel->sheet('score', function($sheet) use ($list) {
                $sheet->rows($list);
            });
        })->export('xls');
    }

}
