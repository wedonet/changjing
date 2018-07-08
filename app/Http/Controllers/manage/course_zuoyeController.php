<?php

namespace App\Http\Controllers\manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use App\Repositories\course as courseRepository;

class course_zuoyeController extends Controller {
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct(courseRepository $cr) {
        $this->oj = (object) [];

        $this->cr = $cr;

        $this->currentcontroller = '/manage/course_zuoye'; //控制器
        $this->viewfolder = 'manage.course.zuoye'; //视图路径
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

        $olist = $this->cr->listhomework($request, $this->oj->course->ic);

        if($olist->validator->fails()){
            return redirect()->back()->withInput()->withErrors(($olist->validator->errors()->toArray()));
        }
        
        $this->oj->search = $olist->search;
        $this->oj->list = $olist->list;
        $this->oj->yingjiao = $olist->yingjiao;
        $this->oj->shijiao = $olist->shijiao;

        return view($this->viewfolder . '.index', ['oj' => $this->oj]);
    }

    public function daochu($ic) {
        require_once(base_path() . '/resources/views/init.blade.php');

        $data = DB::table($this->dbname)
                ->where('auditstatus', 'pass')
                ->where('courseic', $ic)
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

            /**/
            $re['mobile'] = $student->mobile;
            $re['homeworkisdone'] = showyes($data[$i]->homeworkisdone);
            $re['homeworkisok'] = yorn($data[$i]->homeworkisok);

            $cellData[$j] = $re;
        }

        Excel::create('学生作业记录表', function($excel) use ($cellData) {
            $excel->sheet('score', function($sheet) use ($cellData) {
                $sheet->setAutoSize(true);
                $sheet->rows($cellData);
            });
        })->export('xls');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->j['courses_type'] = app('main')->getactivitytypelist();

        return view($this->viewfolder . '.create', ['j' => $this->j]);
    }

    /* Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function dopass($id, Request $request) {
        $signup = app('main')->getcoursesignupbyid($id);

        if (1 == $signup->auditstatus) {
            return redirect()->back()->withInput()->withErrors('已经是通过状态了， 请不要重复执行通过操作！');
        }

        $rs['homeworkisok'] = 1;

        DB::table($this->dbname)
                ->where('id', $id)
                ->update($rs);

        return redirect()->back()->withInput()->with('sucinfo', '操作成功！');
    }

    public function unpass($id) {
        $signup = app('main')->getcoursesignupbyid($id);
        $student = app('main')->getstudentbycode($signup->ucode);

        $this->j['signup'] = $signup;
        $this->j['student'] = $student;

        return view($this->viewfolder . '.unpass', ['j' => $this->j]);
    }

    /* 审核学生是否能参加活动 */

    public function dounpass($id, Request $request) {
        $arr['suc'] = 'n';

        $rules = array(
            'homeworkexplain' => 'required|string|between:1,255'
        );

        $attributes = array(
            'homeworkexplain' => '原因'
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

        if (2 == $signup->homeworkisok) {
            $arr['err'] = '已经是未通过状态了，请不要重复操作';

            echo json_encode($arr, 320);
            return;
        }

        /* 生成未通过原因 */
        $text['text'] = $request->homeworkexplain;
        $text['time'] = time();
        $text['tcode'] = ''; //教师号

        $rs['homeworkisok'] = 2;
        $rs['homeworkexplain'] = json_encode($text, 320);
        DB::table($this->dbname)
                ->where('id', $id)
                ->update($rs);

        $arr['suc'] = 'y';
        $arr['reload'] = 'y';


        echo json_encode($arr, 320);
        return;
    }

    private function init($request) {
        /* 接收课程名称 */
        $this->oj->course = $request->oj->course;
        $this->oj->courseid = $request->oj->course->id;
    }

}
