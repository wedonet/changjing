<?php

namespace App\Http\Controllers\student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class myinnerhonorController extends Controller {
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->oj = (object)[];
        
        $this->currentcontroller = '/student/myinnerhonor'; //控制器
        $this->viewfolder = 'student.myinnerhonor.'; //视图路径
        $this->dbname = 'innerhonor_signup';

        $this->oj->nav = 'myinnerhonor';
        $this->oj->currentcontroller = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $list = DB::table($this->dbname)
                ->where('innerhonor_signup.ucode', $_ENV['user']['mycode'].'')
                ->where('innerhonor_signup.isok', 1)
                ->leftjoin('innerhonor', 'innerhonor_signup.itemic', '=', 'innerhonor.id')
                ->select('innerhonor_signup.*', 'innerhonor.title')
                ->get();
        $this->oj->list = $list;
                
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
        //return view('student.index', ['j' => $this->j]);
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
