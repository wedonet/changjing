<?php

namespace App\Http\Controllers\student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class kechenglishiController extends Controller {
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->oj = (object)[];
        
        $this->currentcontroller = '/student/kechenglishi'; //控制器
        $this->viewfolder = 'student.kechenglishi.'; //视图路径
        $this->dbname = 'courses_signup';

        $this->oj->nav = 'kechenglishi';
        $this->oj->currentcontroller = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view($this->viewfolder . 'index', ['oj' => $this->oj]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        dd(11);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        return view('student.kecheng.detail', ['j' => $this->j]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        return view('student.index', ['j' => $this->j]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    public function homework($id) {
        $data = DB::table($this->dbname)
                ->where('courses_signup.id', $id)
                ->leftjoin('courses', 'courses_signup.courseic', '=', 'courses.ic')
                //->select('courses.*', 'courses_signup.homeworkisdone', 'courses_signup.homeworkurl', 'courses_signup.homeworkisok', 'courses_signup.homeworkexplain')
                ->first();

        $this->j['course'] = $data;

        return view($this->viewfolder . 'homework', ['j' => $this->j]);
    }

    public function dohomework($id, Request $request) {
        $rules = array(
            'attachmentsurl' => 'required|string|between:1,255'
        );

        $attributes = array(
            'attachmentsurl' => '作业'
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        /* 检测班级负责人是否存在 */




        $date = date("Y-m-d H:i:s", time());

        $rs['homeworkurl'] = $request->attachmentsurl;
        $rs['homeworkisdone'] = 1;


        DB::table($this->dbname)
                ->where('id', $id)
                ->update($rs);



        $suctip[] = '请等待老师审核';
        $suctip[] = '<a href="' . $this->currentcontroller . '">返回我的课程</a>';
        return ( app('main')->jssuccess('保存成功', $suctip));
    }

    public function appraise($id) {


        return view($this->viewfolder . '.formappraise', ['j' => $this->j]);
    }

    public function doappraise($id, Request $request) {
        $arr['suc'] = 'n';

        $rules = array(
            'mylevel' => 'required|integer|between:1,5'
        );

        $attributes = array(
            'mylevel' => '评价'
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            $arr['err'] = $validator->errors()->toArray();

            echo json_encode($arr, 320);
            return;
        }


        $signup = app('main')->getcoursesignupbyid($id);
        $course = app('main')->getcoursebyic($signup->courseic);



        /* 检测是否评价过，是否是我参加的 */


        $rs['appraise'] = $request->mylevel;
        $rs['appraisetime'] = time();
        DB::table($this->dbname)->where('id', $id)->update($rs);


        /* 更新总评价 */
        $appraise = DB::table($this->dbname)
                ->where('appraise', '>', 0)
                ->where('courseic', $course->ic)
                ->avg('appraise');

        unset($rs);


        $rs['appraise'] = $appraise * 1000;
        DB::table('courses')->where('id', $course->id)->update($rs);



        $arr['suc'] = 'y';
        $arr['reload'] = 'y';


        echo json_encode($arr, 320);
        return;
    }

}
