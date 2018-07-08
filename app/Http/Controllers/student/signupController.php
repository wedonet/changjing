<?php

/* 学生报名 */

namespace App\Http\Controllers\student;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class signupController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->currentcontroller = '/student'; //控制器
        $this->viewfolder = 'student.mysignup'; //视图路径
        $this->dbname = 'activity_signup';

        $this->j['nav'] = 'huodong';
        $this->j['currentcontroller'] = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $rules = array(
            'title' => 'alpha_num|between:1,20',
            'mycode' => 'alpha_num|between:1,20'
        );

        $attributes = array(
            "title" => '班级名称',
            'mycode' => '班级号'
        );

        $message = array(
        );

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        $search['title'] = $request->title;
        $search['mycode'] = $request->mycode;
        $search['auditstatus'] = $request->auditstatus;



        $this->j['search'] = $search;



        $list = DB::table($this->dbname)
                ->where(function($query) use($search) {
                    if ('' != $search['title']) {
                        $query->where('title', 'like', '%' . $search['title'] . '%');
                    }
                    if ('' != $search['mycode']) {
                        $query->where('mycode', 'like', '%' . $search['mycode'] . '%');
                    }
                })
                ->where('ucode', $_ENV['user']['mycode'])
                ->leftjoin('activity', 'activity_signup.activityic', '=', 'activity.ic')
                ->select('activity.*', 'activity_signup.id as signid', 'activity_signup.created_at as signupcreatetime', 'activity_signup.auditstatus as signupstatus')
                ->orderby('activity_signup.id', 'desc')
                ->paginate(20);

        $this->j['list'] = $list;

        return view($this->viewfolder . '.index', ['j' => $this->j]);
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
        //
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

        $o_activity = DB::table('activity')
                ->where('ic', $data->activityic)
                ->first();
        $this->j['o_activity'] = $o_activity;

        return view($this->viewfolder . '.detail', ['j' => $this->j]);
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
