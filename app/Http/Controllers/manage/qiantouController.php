<?php

/* 活动审核，由牵头部门进行审核 */

namespace App\Http\Controllers\manage;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use App\Repositories\activity as activityRepository;

class qiantouController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;
    private $classactivity;

    function __construct(activityRepository $activity) {
        $this->classactivity = $activity;
        $this->oj = (object)[];
        
        $this->currentcontroller = '/manage/qiantou'; //控制器
        $this->viewfolder = 'manage.qiantou'; //视图路径
        $this->dbname = 'activity';

        $this->oj->nav = 'qiantou';
        $this->oj->currentcontroller = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $base = $this->classactivity->index($request);

        $rules = array(
        );

        $attributes = array(
        );

        $message = array(
        );

        $rules = array_merge($base->rules, $rules);
        $attributes = array_merge($base->attributes, $attributes);

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors(($validator->errors()->toArray()));
        }

        $search = $base->search;

        $p = (object)[];
        $p->type = 'sh';
        $p->dic = $_ENV['user']['dic'];
        $list = $this->classactivity->getlist($this->dbname, $search, $p);

        $this->oj->search = $search;
        $this->oj->list = $list;        
        


        return view($this->viewfolder . '.index', ['oj' => $this->oj]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view($this->viewfolder . '.create', ['j' => $this->j]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        return redirect($this->currentcontroller);
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
                ->where('isdel', 0)
                ->first();

        $this->oj->data = $data;

        /* get未通过审核的原因 */
        $o_audit = DB::table('activity_audit')
                ->where('activityic', $data->ic)
                //->where('isdel', 0)
                ->orderby('id', 'desc')
                ->first();
        $this->oj->o_audit = $o_audit;
        //$this->j['activity_type'] = app('main')->getactivitytypelist();
  
        return view($this->viewfolder . '.detail', ['oj' => $this->oj]);
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

        return view($this->viewfolder . '.edit', ['j' => $this->j]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $rules = array(
            'title' => 'alpha_num|between:1,20',
            'readme' => 'alpha_num|between:1,255',
            'cls' => 'integer'
        );

        $attributes = array(
            "title" => '名称',
            'readme' => '简介',
            'cls' => '排序'
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        /**/

        $rs['title'] = $request->title;
        $rs['readme'] = $request->readme;
        $rs['cls'] = $request->cls;



        DB::table($this->dbname)->where('id', $id)->update($rs);

        $suctip[] = '<a href="' . $this->currentcontroller . '">返回部门管理</a>';
        return ( app('main')->jssuccess('操作成功', $suctip));
    }

    public function dopass($id) {
        /* 检测当前状态 */
        $m_activity = app('main')->getactivitybyid($id);

        if ('pass' == $m_activity->auditstatus) {
            return redirect()->back()->withErrors('已经是审核通过状态了，请不要重复操作！');
        }

        $time = time();

        /* 更新状态 */
        $rs['auditstatus'] = 'pass';
        $rs['aucode'] = '';
        $rs['auname'] = '';
        $rs['audittime'] = time();

        DB::table($this->dbname)->where('id', $id)->update($rs);

        /* 添加审核记录 */

        $rs = null;

        $rs['myeventv'] = 'pass';
        $rs['aucode'] = '';
        $rs['auname'] = '';
        $rs['created_at'] = date("Y-m-d H:i:s", $time);

        DB::table('activity_audit')->insert($rs);

        $arr['suc'] = 'y';
        $arr['reload'] = 'y';


        return redirect()->back()->withInput()->with('sucinfo', '操作成功！');
    }

    public function formunpass($id) {
        $signup = app('main')->getactivitysignupbyid($id);

        //$this->j['signup'] = $signup;

        return view($this->viewfolder . '.formunpass', ['j' => $this->j]);
    }

    public function dounpass($id, Request $request) {
        $arr['suc'] = 'n';

        $rules = array(
            'myexplain' => 'required|string|between:1,255',           
        );

        $attributes = array(
            'myexplain' => '原因'          
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            $arr['err'] = $validator->errors()->toArray();
            echo json_encode($arr, 320);
            return;
        }
        
 
        
        /* 检测当前状态 */
        $m_activity = app('main')->getactivitybyid($id);

        if ('unpass' == $m_activity->auditstatus) {
            $arr['err'] = '这个活动已经是未通过状态了，请不要重复操作！';
            echo json_encode($arr, 320);
            return;
        }

        $time = time();

        /* 更新状态 */
        $rs['auditstatus'] = 'unpass';
        $rs['aucode'] = '';
        $rs['auname'] = '';
        $rs['audittime'] = time();

        DB::table($this->dbname)->where('id', $id)->update($rs);

        /* 添加审核记录 */

        $rs = null;

        $rs['activityic'] = $m_activity->ic;
        $rs['myeventv'] = 'unpass';
        $rs['myexplain'] = $request->myexplain;
        $rs['aucode'] = '';
        $rs['auname'] = '';
        $rs['created_at'] = date("Y-m-d H:i:s", $time);

        DB::table('activity_audit')->insert($rs);

        $arr['suc'] = 'y';
        $arr['reload'] = 'y';


        echo json_encode($arr, 320);
        
        return;
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

}
