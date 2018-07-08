<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class innerhonorController extends Controller {

    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->oj = (object) [];
        $this->currentcontroller = '/adminconsole/innerhonor'; //控制器
        $this->viewfolder = 'admin.innerhonor.'; //视图路径
        $this->dbname = 'innerhonor';

        $this->oj->nav = 'innerhonor';
        $this->oj->currentcontroller = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $list = DB::table($this->dbname)
                ->orderby('id', 'desc')
                ->leftjoin('activity_type', 'innerhonor.type_twoic', '=', 'activity_type.ic')
                ->select('innerhonor.*', 'activity_type.qiantouname as qiantouname')
                ->paginate(18);

        $this->oj->list = $list;

        return view($this->viewfolder . 'index', ['oj' => $this->oj]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->oj->activity_type = app('main')->getactivitytypelist();
        $this->oj->isedit = false;

        $this->oj->mynav = '申请校内荣誉';
        $this->oj->action = $this->currentcontroller;

        $this->oj->departlistindexic = app('main')->getdepartlistindexic();
        $this->oj->xueyuanlist = app('main')->getxueyuanlist();

        return view($this->viewfolder . 'create', ['oj' => $this->oj]);
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
        if (!$data) {
            return redirect('/showerr')->with('errmessage', '1022');
        }

        /* 提取牵头部门 */
        $data->tiantouname = app('main')->getdnamebytype($data->type_twoic);

        $this->oj->data = $data;

        return view($this->viewfolder . 'detail', ['oj' => $this->oj]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $this->oj->activity_type = app('main')->getactivitytypelist();
        $this->oj->isedit = true;

        $this->oj->mynav = '编辑校内荣誉';
        $this->oj->action = $this->currentcontroller . '/' . $id;

        $this->oj->departlistindexic = app('main')->getdepartlistindexic();
        $this->oj->xueyuanlist = app('main')->getxueyuanlist();

        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->first();

        $this->oj->data = $data;

        return view($this->viewfolder . 'create', ['oj' => $this->oj]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $deleteic = DB::table($this->dbname)
                ->where('id', $id)
                ->where('isok', '<', '1') //审核通过没通过都不能删除了
                ->delete();

        /* 删除 这个荣誉的报名 */
        if ($deleteic > 0) {
            $result = DB::table('innerhonor_signup')
                    ->where('itemic', $id)
                    ->delete();
        }



        return redirect()->back()->withInput()->withSuccess('删除成功！');
    }

    public function getbase(&$request) {
        $base = (object) [];

        $base->rules = array(
            'title' => 'required|string|between:1,50',
            'sponsor' => 'required|string|between:1,50',
            'mydate' => 'required|date|between:1,50',
            'myvalue' => 'required|integer|max:1000000',
            'readme' => 'required|string|between:1,500',
            'attachmentsurl' => 'nullable|string|between:1,255',
            'mycredit' => 'required|regex:/^0?+(.[0-9]{1})?$/',
            'dic' => 'required|string',
            'type_oneic' => 'required|string|between:1,50',
            'type_twoic' => 'required|string|between:1,50',
            /**/
            'contel' => 'required|string|between:8,13',
			'conname' => 'required|string|between:2,20'
        );

        $base->attributes = array(
            'title' => '名称',
            'sponsor' => '奖励单位',
            'mydate' => '奖励日期',
            'myvalue' => '奖励金额',
            'readme' => '奖励说明',
            'attachmentsurl' => '支撑材料',
            'mycredit' => '申请学分',
            'dic' => '所在学院',
            'type_oneic' => '一级活动类型',
            'type_twoic' => '二级活动类型',
        );
        $base->message = array(
            'mycredit.regex' => '学分请输入0.1至1之间的小数'
        );

        return $base;
    }

    function basemdb(&$request) {
        $mdb = (object) [];

        /* rs */
        /**/
        $time = time();
        $date = date("Y-m-d H:i:s", $time);

        /* 生成活动名称 */
        $the_activity = app('main')->getactivitytypebyic($request->type_oneic);
        $type_onename = $the_activity->title;

        $the_activity = app('main')->getactivitytypebyic($request->type_twoic);
        $type_twoname = $the_activity->title;

        /* 生成学院名称 */
        $department = app('main')->getdepartmentdatabyic($request->dic);
        $dname = $department->title;

        $rs['title'] = $request->title;
        $rs['sponsor'] = $request->sponsor;
        $rs['mydate'] = strtotime($request->mydate);
        $rs['myvalue'] = $request->myvalue;
        $rs['readme'] = $request->readme;

        $rs['attachmentsurl'] = $request->attachmentsurl.'';
        $rs['mycredit'] = $request->mycredit * 1000;
        $rs['dic'] = $request->dic;
        $rs['dname'] = $dname;
        $rs['type_oneic'] = $request->type_oneic;

        $rs['type_onename'] = $type_onename;
        $rs['type_twoic'] = $request->type_twoic;
        $rs['type_twoname'] = $type_twoname;

        $rs['contel'] = $request->contel;
		$rs['conname'] = $request->conname;

        $mdb->date = $date;
        $mdb->rs = $rs;

        return $mdb;
    }

    public function store(Request $request) {
        $base = $this->getbase($request);

        $rules = array(
        );
        $attributes = array(
        );
        $message = array(
        );

        $rules = array_merge($base->rules, $rules);
        $attributes = array_merge($base->attributes, $attributes);
        $message = array_merge($base->message, $message);



        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        $mdb = $this->basemdb($request);
        if (isset($mdb->err)) {
            $validator->errors()->add('error2', $mdb->err);
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }


        /**/
        $rs = $mdb->rs;

        $rs['ucode'] = $_ENV['user']['mycode'];
        $rs['created_at'] = $mdb->date;
        $rs['isok'] = -1;
        $rs['notokreason'] = '';
        $rs['created_at'] = $mdb->date;



        $id = DB::table($this->dbname)->insertGetId($rs);

        if ($id > 0) {

            $href = $this->currentcontroller . '/' . $id . '/student';
            $suctip[] = '请添加人员';
            return ( app('main')->jssuccess('保存成功,2秒后自动跳转到人员管理', $suctip, $href));
        } else {

            $validator->errors()->add('error', '保存失败');
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }
    }

    public function update(Request $request, $id) {
        $base = $this->getbase($request);

        $rules = array(
        );

        $attributes = array(
        );

        $message = array(
        );

        $rules = array_merge($base->rules, $rules);
        $attributes = array_merge($base->attributes, $attributes);
        $message = array_merge($base->message, $message);

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        $mdb = $this->basemdb($request);
        $rs = $mdb->rs;
        $rs['isok'] = -1;
        $rs['updated_at'] = $mdb->date;

        DB::table($this->dbname)
                ->where('id', $id)
                ->update($rs);

        $suctip[] = '提交后请等待牵头部门审核';
        $suctip[] = '<a href = "' . $this->currentcontroller . '">返回</a>';
        return ( app('main')->jssuccess('操作成功', $suctip));
    }

    function student($id, Request $request) {
        $list = DB::table('innerhonor_signup')
                ->where('mytype', 'innerhonor')
                ->where('itemic', $id)
                ->leftjoin('students', 'innerhonor_signup.ucode', '=', 'students.mycode')
                ->select('innerhonor_signup.*', 'students.realname', 'students.classname', 'students.dname')
                ->orderby('id', 'desc')
                //->leftjoin('activity_type', 'innerhonor.type_twoic', '=', 'activity_type.ic')
                //->select('innerhonor.*', 'activity_type.qiantouname as qiantouname')
                ->paginate(200);

        $this->oj->innerhonor = $this->getinnerhonorbyid($id);
        $this->oj->list = $list;

        return view($this->viewfolder . 'student', ['oj' => $this->oj]);
    }

    function savestudent($id, Request $request) {


        $rules = array(
            'codes' => 'required|string|max:500',
        );

        $attributes = array(
            'codes' => '学号'
        );

        $message = array(
        );

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors(($validator->errors()->toArray()));
        }

        /* 检测学号正确性 */
        $a = explode(',', $request->codes);

        $student = DB::table('students')
                ->whereIn('mycode', $a)
                ->pluck('mycode')
                ->toArray();



        /* 循环a, 如果不在结果列表 里则提示学号不正确 */
        $aerrucode = [];
        foreach ($a as $v) {
            if (!in_array($v, $student)) {
                $aerrucode[] = ($v);
            }
        }

        if (count($aerrucode) > 0) {
            $str = join(',', $aerrucode) . '学号错误，请重新填写';
            return redirect()->back()->withInput()->withErrors($str);
        }


        /* 取出已经添加完的学号 */
        $ucode = DB::table('innerhonor_signup')
                ->where('itemic', $id)
                ->pluck('ucode')
                ->toArray();
        ;

        DB::beginTransaction();
        try {
            /* 哪个学号没加进去，就加 */
            foreach ($a as $v) {
                $rs = [];
                if (!in_array($v, $ucode)) {
                    $rs['mytype'] = 'innerhonor';
                    $rs['itemic'] = $id;
                    $rs['ucode'] = $v;
                    $rs['signup_time'] = time();
                    $rs['isok'] = 0;
                    //$rs['plancredit'] 

                    DB::table('innerhonor_signup')
                            ->insert($rs);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }




        return redirect()->back()->withInput()->with('sucinfo', '添加成功！');
    }

    /* 这个id是校内荣誉id */

    function studentdestory($id, Request $request) {
        $rules = array(
            'myid' => 'integer|max:999999',
        );

        $attributes = array(
            "myid" => 'ID号',
        );

        $message = array(
        );

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors(($validator->errors()->toArray()));
        }

        DB::beginTransaction();
        try {
            $deleteic = DB::table('innerhonor_signup')
                    ->where('id', $request->myid)
                    ->where('itemic', $id)
                    ->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

        return redirect()->back()->withInput()->withSuccess('删除成功！');
    }

    function submit($id, Request $request) {


        $rs = [];
        $rs['isok'] = 0;
        DB::table($this->dbname)->where('id', $id)->update($rs);
        return redirect()->back()->withInput()->withSuccess('提交成功！');
    }

    function getinnerhonorbyid($id) {
        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->first();
        if (!$data) {
            return redirect('/showerr')->with('errmessage', '没找到这条记录!');
        }
        
        return $data;
    }

}
