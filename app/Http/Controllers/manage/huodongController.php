<?php

namespace App\Http\Controllers\manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use App\Repositories\activity as activityRepository;

class huodongController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;
    private $activityid; //活动id
    private $classactivity;

    function __construct(activityRepository $activity) {
        $this->classactivity = $activity;

        $this->currentcontroller = '/manage/huodong'; //控制器
        $this->viewfolder = 'manage.huodong'; //视图路径  
        $this->dbname = $this->classactivity->dbname;

        $this->j['nav'] = 'huodong';
        $this->j['currentcontroller'] = $this->currentcontroller;
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

        $p = (object) [];
        $p->type = 'fq';
        $p->uic = $_ENV['user']['ic'];
        $list = $this->classactivity->getlist($this->dbname, $search, $p);

        $this->j['search'] = $search;
        $this->j['list'] = $list;
        /* 提取所有部门，以ic为索引 */
        $this->j['ActivityIndexIc'] = app('main')->getActivityIndexIc();

        return view($this->viewfolder . '.index', ['j' => $this->j]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->j['activity_type'] = app('main')->getactivitytypelist();
        $this->j['isedit'] = false;

        $this->j['mynav'] = '申请活动';
        $this->j['action'] = $this->currentcontroller;
        return view($this->viewfolder . '.create', ['j' => $this->j]);
    }

    /* 取得一些基础规则 */

    public function getbase(&$request) {
        $base = (object) [];

        $base->rules = array(
            'title' => 'required|string|between:1,50',
            'activity_year' => 'required',
            'type_oneic' => 'required|string|between:1,20',
            'type_twoic' => 'required|string|between:1,20',
            'mylevel' => 'required|string|between:1,20',
            /**/
            'mytimelong' => 'required|integer|between:1,64',
            'plantime_one' => 'required|date',
            'plantime_two' => 'required|date|after:plantime_one',
            'signuptime_one' => 'required|date',
            'signuptime_two' => 'required|date|after:signuptime_one',
            /**/
            'sponsor' => 'required|string|between:1,20',
            'myplace' => 'required|string|between:1,50',
            'preimg' => 'required|string|between:1,500',
            'readme' => 'required|string|between:1,500',
            'content' => 'required|string|between:1,255000',
            'homework' => 'required|in:0,1',
            'homeworktime_one' => 'nullable|required_if:homework,1|date',
            /**/
            'homeworktime_two' => 'nullable|required_if:homework,1|date|after:homeworktime_one',
            'mywayic' => 'required|in:direct,audit',
            'signlimit' => 'required|integer|between:1,2000',
            'other' => 'nullable|string|between:1,255',
            'attachmentsurl' => 'nullable|string|between:1,255',
            'originname' => 'nullable|required_with:attachmentsurl|string|between:1,50',
            /**/
            'contel' => 'required|string|between:8,13',
			'conname' => 'required|string|between:2,20'
        );

        $base->attributes = array(
            'title' => '名称',
            'activity_year' => '学年',
            'type_oneic' => '一级活动类型',
            'type_twoic' => '二级活动类型',
            'mylevel' => '活动级别',
            /**/
            'mytimelong' => '活动时长',
            'plantime_one' => '活动开始时间',
            'plantime_two' => '活动结束时间',
            'signuptime_one' => '报名开始时间',
            'signuptime_two' => '报名结束时间',
            /**/
            'sponsor' => '主办单位',
            'myplace' => '活动地点',
            /* 'preimg' => '预览图', */
            'readme' => '活动简介',
            'content' => '活动详情',
            'homework' => '是否需要提交作业',
            'homeworktime_one' => '提交作业开始时间',
            /**/
            'homeworktime_two' => '提交作业结止时间',
            'mywayic' => '报名方式',
            'signlimit' => '报名人数限制',
            'other' => '备注',
            'attachmentsurl' => '附件路径',
            'originname' => '原文件名'
        );



        /* 生成活动名称 */
        $type_onename = '';
        $the_activity = app('main')->getactivitytypebyic($request->type_oneic);  
        if ($the_activity) {
            $type_onename = $the_activity->title;
        }

        $type_twoname = '';
        $the_activity = app('main')->getactivitytypebyic($request->type_twoic);
        if ($the_activity) {
            $type_twoname = $the_activity->title;
        }

        /* 计算学分 * 1000 为了不要小数 */
        $mycredit = $request->mytimelong / 16;

        /* 院级比校级低一些，再乘一个系数 */
        if ('school' != $request->mylevel) {
            $mycredit = $mycredit * $_ENV['Xuefenxiaoji'];
        }
        $mycredit *= 1000;



        /* rs */
        /**/
        $time = time();
        $date = date("Y-m-d H:i:s", $time);



        $rs['title'] = $request->title;
        $rs['activity_year'] = $request->activity_year;
        $rs['type_oneic'] = $request->type_oneic;
        $rs['type_twoic'] = $request->type_twoic;
        $rs['type_onename'] = $type_onename;
        $rs['type_twoname'] = $type_twoname;


        $rs['mylevel'] = $request->mylevel;
        $rs['mytimelong'] = $request->mytimelong;
        $rs['mycredit'] = $mycredit;
        $rs['plantime_one'] = strtotime($request->plantime_one);
        $rs['plantime_two'] = strtotime($request->plantime_two);


        $rs['signuptime_one'] = strtotime($request->signuptime_one);
        $rs['signuptime_two'] = strtotime($request->signuptime_two);
        $rs['sponsor'] = $request->sponsor;
        $rs['myplace'] = $request->myplace;

        $rs['preimg'] = $request->preimg;
        $rs['readme'] = $request->readme;
        $rs['content'] = $request->content;
        $rs['homework'] = $request->homework;
        $rs['homeworktime_one'] = strtotime($request->homeworktime_one);
        $rs['homeworktime_two'] = strtotime($request->homeworktime_two);

        $rs['mywayic'] = $request->mywayic;
        $rs['signlimit'] = $request->signlimit;
        $rs['other'] = $request->other.'';
        $rs['attachmentsurl'] = $request->attachmentsurl.'';
        $rs['originname'] = $request->originname.'';

		$rs['contel'] = $request->contel;
		$rs['conname'] = $request->conname;




        $date = date("Y-m-d H:i:s", time());

        $base->date = $date;
        $base->rs = $rs;

        return $base;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
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



        /**/
        $rs = $base->rs;
        $rs['ic'] = app('main')->getfirstic();


        $rs['isopen'] = 0;
        $rs['sucode'] = '';
        $rs['suname'] = '';
        $rs['auditstatus'] = 'new';
        $rs['signcode'] = app('main')->makecode('stack');

        $rs['appraise'] = 0;
        $rs['isdel'] = 0;

        /* 添加人信息 */
        $rs['sucode'] = $_ENV['user']['ic'];
        $rs['suname'] = $_ENV['user']['dname'];
        $rs['sdic'] = $_ENV['user']['dic'];



        $rs['currentstatus'] = 'new';
        $rs['created_at'] = $base->date;

        if (DB::table($this->dbname)->insert($rs)) {
            $suctip[] = '请等待牵头部门审核通过';
            $suctip[] = '<a href = "' . $this->currentcontroller . '">点击这里返回活动管理</a>';
            return ( app('main')->jssuccess('保存成功', $suctip));
        } else {
            $validator->errors()->add('error', '保存失败');
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        //return redirect($this->currentcontroller);
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

        $this->j['id'] = $id;
        $this->j['aid'] = $id;

        //$this->j['activity_type'] = app('main')->getactivitytypelist();

        $this->j['activityid'] = $id;
        $this->j['activity'] = & $data;



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

        $this->j['isedit'] = true;
        $this->j['mynav'] = '编辑活动';
        $this->j['action'] = $this->currentcontroller . '/' . $id;
        return view($this->viewfolder . '.create', ['j' => $this->j]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
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



        $rs = $base->rs;
        $rs['auditstatus'] = 'new';

        DB::table($this->dbname)
                ->where('id', $id)
                ->update($rs);

        $suctip[] = '请等待牵头部门审核';
        $suctip[] = '<a href = "' . $this->currentcontroller . '">返回活动管理</a>';
        return ( app('main')->jssuccess('操作成功', $suctip));
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
            $rs['isdel'] = 1;
            DB::table($this->dbname)->where('id', $id)->update($rs);
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

    /* 执行开通关闭等各种操作
     * 返回json格式 */

    function saveform($id, $act) {
        //$json['suc'] = 'n';
        //$json['reload'] = 'y';
        //$json['suc'] = 'y';
        switch ($act) {

            case 'isopen':
                $arr = $this->doisopen($id);
                break;
            case 'unopen':
                $arr = $this->dounopen($id);
                break;
        }


        echo json_encode($arr, 320);
        return;
    }

    function doopen($id) {
        $activity = app('main')->getactivitybyid($id);

        if (1 == $activity->isopen) {
            return redirect()->back()->withErrors('已经是通过状态了，请不要重复审核');
        }

        $rs['isopen'] = 1;
        DB::table($this->dbname)
                ->where('id', $id)
                ->update($rs);


        return redirect()->back()->withInput()->with('sucinfo', '操作成功！');
    }

    function dounopen($id) {
        $activity = app('main')->getactivitybyid($id);

        if (0 == $activity->isopen) {
            return redirect()->back()->withErrors('已经是关闭状态了，请不要重复审核');
        }

        $rs['isopen'] = 0;
        DB::table($this->dbname)
                ->where('id', $id)->update($rs);

        return redirect()->back()->withInput()->with('sucinfo', '操作成功！');
    }

    /* 查看审核未通过原因 */

    function reason($id) {
        $activity = DB::table($this->dbname)
                ->where('id', $id)
                ->first();

        $activity_audit = DB::table('activity_audit')
                ->where('activityic', $activity->ic)
                ->orderby('id', 'desc')
                ->first();

        $this->j['activity_audit'] = $activity_audit;

        $this->j['id'] = $id;

        //$this->j['activity_type'] = app('main')->getactivitytypelist();

        $this->j['activityid'] = $id;
        $this->j['activity'] = & $activity;

        return view($this->viewfolder . '.reason', ['j' => $this->j]);
    }

}
