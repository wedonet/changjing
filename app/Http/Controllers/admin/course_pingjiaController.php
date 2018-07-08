<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class course_pingjiaController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;


    function __construct(Request $request) {
        $this->oj = (object) [];
        $this->currentcontroller = '/adminconsole/kecheng_appraise'; //控制器
        $this->viewfolder = 'admin.course.pingjia'; //视图路径
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
        
        $search = (object)[];
        
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
                ->where('itemic',  $this->oj->course->ic)
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
                ->leftjoin('students', 'courses_signup.ucode', '=', 'students.mycode')
                ->select('courses_signup.*', 'students.realname', 'students.dname as dname', 'students.gender', 'students.mobile')
                ->orderby('courses_signup.id', 'desc')
                ->paginate(200);

        $this->oj->list = $list;
        
 
        /*评价统计*/
        $l = DB::table($this->dbname)
                ->select(DB::raw( 'count(*) as count' ), 'appraise')
                ->where('itemic',  $this->oj->course->ic)
                ->where('auditstatus', 'pass')
                ->groupBy('appraise')
                ->get();
        $a = (object)[];
        if(count($l)>0){
            foreach($l as $v){
                $key = $v->appraise;
                $a->$key = $v->count;
            }
        }

        $this->oj->statistics = $a;

        return view($this->viewfolder . '.index', ['oj' => $this->oj]);
    }

    private function init($request) {
        /* 接收课程名称 */
        $this->oj->course = $request->oj->course;
        $this->oj->courseid = $request->oj->course->id;
    }
}
