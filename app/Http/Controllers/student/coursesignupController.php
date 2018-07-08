<?php

/* 学生页的报名查看 */

namespace App\Http\Controllers\student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class coursesignupController extends Controller {
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->oj = (object)[];
        
        $this->currentcontroller = '/student/coursesignup'; //控制器
        $this->viewfolder = 'student.coursesignup'; //视图路径
        $this->dbname = 'courses_signup';

        $this->oj->nav = 'coursesignup';
        $this->oj->currentcontroller = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $search = (object)[];
        
        $rules = array(
            'auditstatus' => 'string|between:1,20'
        );

        $attributes = array(
            "auditstatus" => '审核状态'
        );

        $message = array(
        );

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors(($validator->errors()->toArray()));
        }

        $search->auditstatus = $request->auditstatus;

        $this->oj->search = $search;


        $list = DB::table($this->dbname)
                ->where('ucode', $_ENV['user']['mycode'])
                ->leftjoin('courses', 'courses_signup.itemic', '=', 'courses.ic')               
                ->select('courses.*', 'courses_signup.id as signid', 'courses_signup.created_at as signupcreatetime', 'courses_signup.auditstatus as signupstatus', 'courses_signup.mylevel as xuefenlevel')
                ->orderby('courses_signup.id', 'desc')
                ->get();

        $this->oj->list = $list;

        return view($this->viewfolder . '.index', ['oj' => $this->oj]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        return;
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

        $course = DB::table('courses')
                ->where('ic', $data->itemic)
                ->first();
        $this->oj->course = $course;

        return view($this->viewfolder . '.detail', ['oj' => $this->oj]);
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

}
