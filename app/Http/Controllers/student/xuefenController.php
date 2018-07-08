<?php

namespace App\Http\Controllers\student;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;


class xuefenController extends Controller {

    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->oj = (object) [];

        $this->currentcontroller = '/student/xuefen'; //控制器
        $this->viewfolder = 'student.xuefen'; //视图路径
        $this->dbname = 'students';

        $this->oj->nav = 'xuefen';
        $this->oj->currentcontroller = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($media = 'screen') {

        $this->getxuefen();

        $this->oj->isprint = false;
        return view($this->viewfolder . '.index', ['oj' => $this->oj]);
    }

    public function printxuefen() {
        $this->getxuefen();

        $this->oj->isprint = true;

        $html = view($this->viewfolder . '.index', ['oj' => $this->oj]);

        return view($this->viewfolder . '.index', ['oj' => $this->oj]);
    }

    function getxuefen() {
        /* 提取类型 */
        $type = DB::table('activity_type')
                ->where('isdel', 0)
                ->orderby('cls', 'asc')
                ->orderby('id', 'asc')
                ->get();
        $this->oj->type = $type;

        /* 提取活动报名,联查活动名称 */
        $activity_signup = DB::table('activity_signup')
                ->where('activityisok', 1)
                ->where('ucode', $_ENV['user']['mycode'])
                ->leftjoin('activity', 'activity_signup.activityic', '=', 'activity.ic')
                ->select('activity_signup.*', 'activity.type_oneic', 'activity.type_twoic', 'activity.title', 'activity.activity_year')
                ->orderby('activity_signup.id', 'asc')
                ->get();
        $this->oj->activity_signup = $activity_signup;


        /* 提取课程报名， 联查课程名称 */
        $course_signup = DB::table('courses_signup')
                ->where('itemisok', 1)
                ->where('ucode', $_ENV['user']['mycode'])
                ->leftjoin('courses', 'courses_signup.itemic', '=', 'courses.ic')
                ->select('courses_signup.*', 'courses.type_oneic', 'courses.type_twoic', 'courses.title', 'courses.activity_year')
                ->orderby('courses_signup.id', 'asc')
                ->get();
        $this->oj->courses_signup = $course_signup;


        /* 提取校外荣誉 */
        $outerhonor = DB::table('outerhonor')
                ->where('isok2', 1)
                ->where('ucode', $_ENV['user']['mycode'])
                ->orderby('id', 'asc')
                ->get();
        $this->oj->outerhonor = $outerhonor;

        /* 提取校内荣誉 */
        $innerhonor = DB::table('innerhonor_signup')
                ->where('innerhonor_signup.ucode', $_ENV['user']['mycode'] . '')
                ->where('innerhonor_signup.isok', 1)
                ->leftjoin('innerhonor', 'innerhonor_signup.itemic', '=', 'innerhonor.id')
                ->select('innerhonor_signup.*', 'innerhonor.title', 'innerhonor.type_oneic', 'innerhonor.type_twoic', 'innerhonor.mydate')
                ->orderby('id', 'asc')
                ->get();

        $this->oj->innerhonor = $innerhonor;


        /* 提取履职修业 */
        $perform = DB::table('perform')
                ->where('perform.ucode', $_ENV['user']['mycode'] . '')
                ->where('perform.isok', 1)
                ->orderby('id', 'asc')
                ->get();

        $this->oj->perform = $perform;


        /* 提取个人信息 */
        /* 提取活动 */
        $students = DB::table('students')
                ->where('mycode', $_ENV['user']['mycode'])
                ->first();
        $this->oj->students = $students;

        /* 提取活动总学分 */
        $allxuefen = DB::table('activity_signup')
                ->where('ucode', $_ENV['user']['mycode'])
                ->sum('actualcreidt');

        /* 提取课程总学分 */
        $coursexuefen = DB::table('courses_signup')
                ->where('ucode', $_ENV['user']['mycode'])
                ->sum('actualcreidt');

        /* 提取校外荣誉学分 */
        $outerhonorxuefen = DB::table('outerhonor')
                ->where('ucode', $_ENV['user']['mycode'])
                ->where('isok2', 1)
                ->sum('actualcredit');

        /* 提取校内荣誉学分 */
        $innerhonorxuefen = DB::table('innerhonor_signup')
                ->where('ucode', $_ENV['user']['mycode'])
                ->where('isok', 1)
                ->sum('actualcredit');


        /* 提取履职修业总学分 */
        $perform = DB::table('perform')
                ->where('ucode', $_ENV['user']['mycode'])
                ->where('isok', 1)
                ->sum('actualcredit');

        $this->oj->allxuefen = $allxuefen + $coursexuefen + $outerhonorxuefen + $innerhonorxuefen + $perform;
    }

}
