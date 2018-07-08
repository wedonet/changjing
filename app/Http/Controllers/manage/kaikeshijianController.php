<?php

namespace App\Http\Controllers\manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class kaikeshijianController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct(Request $request) {
        $this->oj = (object) [];

        $this->currentcontroller = '/manage/kaikeshijian'; //控制器
        $this->viewfolder = 'manage.kaikeshijian'; //视图路径
        $this->dbname = 'courses_hour';

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

        $list = DB::table($this->dbname)
                ->where('courseic', $this->oj->course->ic)
                ->orderby('id', 'asc')
                ->get();

        $this->oj->list = $list;

        return view($this->viewfolder . '.index', ['oj' => $this->oj]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $this->init($request);

        
        $this->oj->mynav = '添加课时';
        $this->oj->isedit = false;
        
        return view($this->viewfolder . '.create', ['oj' => $this->oj]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return view($this->viewfolder . '.detail', ['j' => $this->j]);
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request) {
        $this->oj->course = $request->oj->course;
        
        $this->oj->mynav = '修改课时';
        $this->oj->isedit = true;
        
        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->first();

        $this->oj->data = $data;

        return view($this->viewfolder . '.create', ['oj' => $this->oj]);
    }

    public function getbase(&$request) {
        $base = (object) [];

        $base->rules = array(
            'start_time' => 'required|date',
            'finish_time' => 'required|date',
            'myplace' => 'required|string|between:2, 255',
        );

        $base->attributes = array(
            'start_time' => '开始时间',
            'finish_time' => '结束时间',
        );

        return $base;
    }

    function basemdb(&$request) {
        $mdb = (object) [];

        /* rs */
        /**/
        $time = time();
        $date = date("Y-m-d H:i:s", $time);

        
        $rs['start_time'] = strtotime($request->start_time);
        $rs['finish_time'] = strtotime($request->finish_time);
        $rs['myplace'] = $request->myplace;



        $date = date("Y-m-d H:i:s", time());

        $mdb->date = $date;
        $mdb->rs = $rs;

        return $mdb;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->init($request);      
        
        $base = $this->getbase($request);

        $myrules = array(
        );
        $myattributes = array(
        );

        $rules = array_merge($base->rules, $myrules);
        $attributes = array_merge($base->attributes, $myattributes);

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        $mdb = $this->basemdb($request);

        /**/
        $rs = $mdb->rs;
        $rs['courseic'] = $this->oj->course->ic;
        $rs['coursenum'] = app('main')->getfirstic();
        $rs['signcode'] = app('main')->generate_randchar(8, 'num');

        DB::table($this->dbname)->insert($rs);

  
        $suctip[] = '2秒后返回课时管理.';
        return ( app('main')->jssuccess('保存成功', $suctip, $this->currentcontroller.'?courseid='.$this->oj->courseid));


        //return redirect($this->currentcontroller);
    }

    public function update(Request $request, $id) {
        $this->init($request);
        
        $base = $this->getbase($request);

        $myrules = array();
        $myattributes = array();

        $rules = array_merge($base->rules, $myrules);
        $attributes = array_merge($base->attributes, $myattributes);

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }


        $mdb = $this->basemdb($request);
        $rs = $mdb->rs;

    

        DB::table($this->dbname)
                ->where('id', $id)
                ->update($rs);

        $suctip[] = '2秒后返回课时管理.';
        return ( app('main')->jssuccess('保存成功', $suctip, $this->currentcontroller.'?courseid='.$this->oj->course->id));
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
    
    private function init( $request){
         $this->oj->course = $request->oj->course;
         $this->oj->courseid = $request->oj->course->id;
    }

}
