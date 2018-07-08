<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use App\Repositories\activity as activityRepository;

class huodong_qiandaoController extends Controller {

    private $parent;
    private $viewfolder;
    private $dbname;
    private $activityid; //活动id

    function __construct(activityRepository $cr) {
        $this->oj = (object) [];
        $this->cr = $cr;

        $this->currentcontroller = '/admin/huodong_qiandao'; //控制器
        $this->viewfolder = 'admin.huodong.qiandao'; //视图路径
        $this->dbname = 'activity_signup';

        $this->oj->nav = 'huodong';
        $this->oj->currentcontroller = $this->currentcontroller;

        $this->activity = & $this->j['activity'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $this->oj->activity = $request->j['activity'];

        $o = $this->cr->signinlist($request, $this->oj->activity);

        if ($o->validator->fails()) {
            return redirect()->back()->withInput()->withErrors(($validator->errors()->toArray()));
        }

        $this->oj->search = $o->search;
        $this->oj->list = $o->list;
        $this->oj->statistics = $o->statistics;


        return view($this->viewfolder . '.index', ['oj' => $this->oj]);
    }

    public function export($aid, Request $request) {
        $activity = $request->j['activity'];

 
        $this->cr->signinexport($activity);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->j['activity_type'] = app('main')->getactivitytypelist();

        return view($this->viewfolder . '.create', ['j' => $this->j]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

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

        $this->j['id'] = $id;

        //$this->j['activity_type'] = app('main')->getactivitytypelist();

        $this->j['activityid'] = $id;
        $this->j['activity'] = & $data;

        return view($this->viewfolder . '.detail', ['j' => $this->j]);
        //
    }

    public function qiandao($ic) {

        return view($this->viewfolder . '.detail', ['j' => $this->j]);
        //
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

        $this->j['activity_type'] = app('main')->getactivitytypelist();

        return view($this->viewfolder . '.edit', ['j' => $this->j]);
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

    public function manage($id) {
        return view($this->viewfolder . '.detail', ['j' => $this->j]);
    }

//    public function shenhe($id) {
//        $this->j['id'] = $id;
//
//        $search = [];
//
//        $list = DB::table('activity_signup')
//                //->where('isdel', 0)
//                ->where(function($query) use($search) {
////                    if ('' != $search['title']) {
////                        $query->where('title', 'like', '%' . $search['title'] . '%');
////                    }
////                    if ('' != $search['currentstatus']) {
////                        $query->where('currentstatus', '=', $search['currentstatus']);
////                    }
//                })
//                ->leftjoin('students', 'activity_signup.ucode', '=', 'students.mycode')
//                ->select('activity_signup.*', 'students.realname', 'students.dname as dname', 'students.gender', 'students.mobile')
//                ->orderby('activity_signup.id', 'desc')
//                ->get();
//
//        $this->j['list'] = $list;
//
//
//        return view($this->viewfolder . '.shenhe', ['j' => $this->j]);
//    }

    public function dosignin($aid, $id) {
        $rs['issignined'] = 1;
        $rs['signintime'] = time();


        $updatedcount = DB::table($this->dbname)
                ->where('id', $id)
                ->update($rs);



        if ($updatedcount > 0) {

            return redirect()->back()->withInput()->with('sucinfo', '签到成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('签到失败, 请不要重复签到！');
        }
    }

    public function dosignout($aid, $id) {
        $rs['issignoffed'] = 1;
        $rs['signoffedime'] = time();

        $updatedcount = DB::table($this->dbname)
                ->where('id', $id)
                ->update($rs);

        if ($updatedcount > 0) {
            return redirect()->back()->withInput()->withSuccess('签退成功');
        } else {
            return redirect()->back()->withInput()->withErrors('签退失败, 请不要重复签退！');
        }
    }

}
