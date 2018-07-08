<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class course_xuefenController extends Controller {

    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct(Request $request) {
        $this->oj = (object) [];
        $this->currentcontroller = '/adminconsole/course_xuefen'; //控制器
        $this->viewfolder = 'admin.course.xuefen'; //视图路径
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
        $statistics = (object)[];

        $rules = array(
            'title' => 'string|between:1,20'
        );

        $attributes = array(
            "title" => '活动名称'
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

        $this->oj->search = $search;




        $list = DB::table($this->dbname)
                ->where('itemic', $this->oj->course->ic) //是这个活动的
                ->where('auditstatus', 'pass')
                //->where('isdel', 0)
                ->where(function($query) use($search) {
                    if ('' != $search->title) {
                        $query->where('title', 'like', '%' . $search['title'] . '%');
                    }
                    if ('' != $search->currentstatus) {
                        $query->where('currentstatus', '=', $search->currentstatus);
                    }
                })
                ->leftjoin('students', 'courses_signup.ucode', '=', 'students.mycode')
                ->select('courses_signup.*', 'students.realname', 'students.dname as dname', 'students.gender', 'students.mobile')
                ->orderby('id', 'desc')
                ->paginate(200);

        $this->oj->list = $list;


        /* 提取签到统计 */
        /* 总数 */
        $l = DB::table($this->dbname)
                ->where('itemic', $this->oj->course->ic) //是这个活动的
                ->where('auditstatus', 'pass')
                ->count();
        $statistics->all = $l; //     

        /* 已评价数 */
        $l = DB::table($this->dbname)
                ->where('itemic', $this->oj->course->ic) //是这个活动的
                ->where('auditstatus', 'pass')
                ->where('itemisok', '>', 0)
                ->count();
        $statistics->yiping = $l; //    

        /* 通过 */
        $l = DB::table($this->dbname)
                ->where('itemic', $this->oj->course->ic) //是这个活动的
                ->where('auditstatus', 'pass')
                ->where('itemisok', 1)
                ->count();
        $statistics->pass = $l; //   

        /* 未通过 */
        $l = DB::table($this->dbname)
                ->where('itemic', $this->oj->course->ic) //是这个活动的
                ->where('auditstatus', 'pass')
                ->where('itemisok', 2)
                ->count();
        $statistics->unpass = $l; //   


        $this->oj->search = $search;
        $this->oj->statistics = $statistics;
        return view($this->viewfolder . '.index', ['oj' => $this->oj]);
    }

    public function export($aid) {
        require_once(base_path() . '/resources/views/init.blade.php');

        $data = DB::table($this->dbname)
                ->where('courseic', $this->j['course']->ic)
                ->where('auditstatus', 'pass')
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
            $re['homeworkisok'] = homeworkokyorn(yorn($data[$i]->homeworkisok), $this->j['course']->homework);
            $re['itemisok'] = yorn($data[$i]->itemisok);


            /* 学分 */
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

    public function formpass($id, Request $request) {
        $signup = app('main')->getcoursesignupbyid($id);

        $this->j['signup'] = $signup;

        return view($this->viewfolder . '.formpass', ['j' => $this->j]);
    }

    public function dopass($id, Request $request) {
        $this->init($request);
        
        $arr['suc'] = 'n';

        $rules = array(
            'mylevel' => 'required|integer|in:1,2,3,4'
        );

        $attributes = array(
            'mylevel' => '等级'
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




        $rs['itemisok'] = 1;
        $rs['mylevel'] = $request->mylevel;
        $rs['actualcreidt'] = $this->oj->course->mycredit;
        DB::table($this->dbname)->where('id', $id)->update($rs);

        $arr['suc'] = 'y';
        $arr['reload'] = 'y';


        echo json_encode($arr, 320);
        return;
    }

    public function formunpass($id, Request $request) {
        $this->init($request);
        
        $signup = app('main')->getcoursesignupbyid($id);

        $this->oj->signup = $signup;

        return view($this->viewfolder . '.formunpass', ['oj' => $this->oj]);
    }

    public function dounpass($id, Request $request) {
        $arr['suc'] = 'n';

        $rules = array(
            'creditexplain' => 'required|string|between:1,255'
        );

        $attributes = array(
            'creditexplain' => '原因'
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

        if (2 == $signup->itemisok) {
            $arr['err'] = '已经是未通过状态了，请不要重复操作';

            echo json_encode($arr, 320);
            return;
        }


        $rs['mylevel'] = '4';
        $rs['itemisok'] = 2;
        $rs['creditexplain'] = $request->creditexplain;
        $rs['actualcreidt'] = 0;
        DB::table($this->dbname)->where('id', $id)->update($rs);

        $arr['suc'] = 'y';
        $arr['reload'] = 'y';


        echo json_encode($arr, 320);
        return;
    }

    private function init($request) {
        $this->oj->course = $request->oj->course;
        $this->oj->courseid = $request->oj->course->id;
    }

}
