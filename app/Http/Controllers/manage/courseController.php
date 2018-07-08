<?php

namespace App\Http\Controllers\manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class courseController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->oj = (object) [];

        $this->currentcontroller = '/manage/course'; //控制器
        $this->viewfolder = 'manage.course'; //视图路径
        $this->dbname = 'courses';

        $this->oj->nav = 'course';
        $this->oj->currentcontroller = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $search = (object) [];

        $rules = array(
            'title' => 'string|between:1,20'
        );

        $attributes = array(
            "title" => '名称'
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






        $list = DB::table($this->dbname)
                ->where('isdel', 0)
                ->where(function($query) use($search) {
                    if ('' != $search->title) {
                        $query->where('title', 'like', '%' . $search->title . '%');
                    }
                    if ('' != $search->currentstatus) {
                        switch ($search->currentstatus) {
                            case 'new':
                                $query->where('plantime_one', '>', time());
                                break;
                            case 'doing':
                                $query->where('plantime_one', '<', time());
                                $query->where('plantime_two', '>', time());
                                break;
                            case 'done':
                                $query->where('plantime_two', '<', time());
                                break;
                            default:
                                break;
                        }

                        //$query->where('currentstatus', '=', $search['currentstatus']);
                    }
                })
                ->where('sucode', $_ENV['user']['ic'])
                ->orderby('id', 'desc')
                ->get();


        /* 组装view数据 */
        $this->oj->list = & $list;
        $this->oj->search = $search;
        /* 提取所有部门，以ic为索引 */
        $this->oj->ActivityIndexIc = app('main')->getActivityIndexIc();

        return view($this->viewfolder . '.index', ['oj' => $this->oj]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->oj->activity_type = app('main')->getactivitytypelist();
        $this->oj->isedit = false;

        $this->oj->mynav = '申请开课';

        $this->oj->action = $this->currentcontroller;
        return view($this->viewfolder . '.create', ['oj' => $this->oj]);
    }

    /* 取得一些基础规则 */

    public function getbase(&$request) {
        $base = (object) [];

        $base->rules = array(
            'title' => 'required|string|between:1,50',
            'activity_year' => 'required|between:1,20',
            'type_oneic' => 'required|string|between:1,20',
            'type_twoic' => 'required|string|between:1,20',
            //'mylevel' => 'required|string|between:1,20',
            /**/
            //'mytimelong' => 'required|integer|between:1,64',
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
            'originname' => 'nullable|string|between:1,50',
            /**/
            'contel' => 'required|string|between:8,13',
			'conname' => 'required|string|between:2,20'
        );

        $base->attributes = array(
            'title' => '名称',
            'activity_year' => '学年',
            'type_oneic' => '一级类型',
            'type_twoic' => '二级类型',
            //'mylevel' => '级别',
            /**/
            //'mytimelong' => '时长',
            'plantime_one' => '开始时间',
            'plantime_two' => '结束时间',
            'signuptime_one' => '开始时间',
            'signuptime_two' => '结束时间',
            /**/
            'sponsor' => '主办单位',
            'myplace' => '课程地点',
            'preimg' => '预览图',
            'readme' => '课程简介',
            'content' => '课程详情',
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

        return $base;
    }

    function basemdb(&$request) {
        $mdb = (object) [];
        /* 生成名称 */

        $the_activity = app('main')->getactivitytypebyic($request->type_oneic);
        $type_onename = $the_activity->title;

        $the_activity = app('main')->getactivitytypebyic($request->type_twoic);
        $type_twoname = $the_activity->title;





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


        $rs['mylevel'] = '';
        $rs['mytimelong'] = 16;
        $rs['mycredit'] = 1000;
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
        $rs['attachmentsurl'] = $request->attachmentsurl . '';
        $rs['originname'] = $request->originname . '';

		$rs['contel'] = $request->contel;
		$rs['conname'] = $request->conname;


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
        $rs['ic'] = app('main')->getfirstic();


        $rs['isopen'] = 0;
        //$rs['sucode'] = '';
        //$rs['suname'] = '';
        $rs['auditstatus'] = 'new';
        $rs['signcode'] = app('main')->makecode('stack');

        $rs['appraise'] = 0;
        $rs['isdel'] = 0;

        /* 添加人信息 */
        $rs['sucode'] = $_ENV['user']['ic'];
        $rs['suname'] = $_ENV['user']['dname'];
        $rs['sdic'] = $_ENV['user']['dic'];



        $rs['currentstatus'] = 'new';
        $rs['created_at'] = $mdb->date;

        if (DB::table($this->dbname)->insert($rs)) {
            $suctip[] = '请等待牵头部门审核通过';
            $suctip[] = '<a href = "' . $this->currentcontroller . '">点击这里返回课程管理</a>';
            return ( app('main')->jssuccess('保存成功', $suctip));
        } else {
            $validator->errors()->add('error', '保存失败');
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }
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

        $this->oj->id = $id;

        //$this->j['activity_type'] = app('main')->getactivitytypelist();

        $this->oj->courseid = $id;
        $this->oj->course = & $data;



        return view($this->viewfolder . '.detail', ['oj' => $this->oj]);
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

    function doisopen($id) {
        $arr['suc'] = 'n';

        $course = app('main')->getcoursebyid($id);

        if (1 == $course->isopen) {
            $arr['err'] = '已经是通过状态了，请不要重复审核';
            return $arr;
        }

        $rs['isopen'] = 1;
        DB::table($this->dbname)
                ->where('id', $id)
                ->update($rs);

        $arr['suc'] = 'y';
        $arr['reload'] = 'y';
        return $arr;
    }

    function dounopen($id) {
        $course = app('main')->getcoursebyid($id);

        if (0 == $course->isopen) {
            return redirect()->back()->withInput()->withErrors('已经是关闭状态了，请不要重复操作');
        }

        $rs['isopen'] = 0;

        DB::table($this->dbname)
                ->where('id', $id)
                ->update($rs);

        return redirect()->back()->withInput()->with('sucinfo', '操作成功！');
    }

    /* 查看审核未通过原因 */

    function reason($id) {
        $course = DB::table('courses')
                ->where('id', $id)
                ->first();

        $audit = DB::table('audit')
                ->where('itemic', $course->ic)
                ->orderby('id', 'desc')
                ->first();

        $this->j['audit'] = $audit;

        $this->j['id'] = $id;

        //$this->j['activity_type'] = app('main')->getactivitytypelist();

        $this->j['courseid'] = $id;
        $this->j['course'] = & $course;

        return view($this->viewfolder . '.reason', ['j' => $this->j]);
    }

    /* 开通课程 */

    public function doopen($id) {

        $data = DB::table('courses')->where('id', $id)->first();

        if ($data->isopen == 1) {
            return redirect()->back()->withInput()->withErrors('已经是开通状态了，不需要重复操作！');
        }

        $result = DB::table('courses')
                ->where('id', $id)
                ->update(['isopen' => 1]);

        return redirect()->back()->withInput()->withSuccess('开通成功！');



//        if ($data->auditstatus == 1) {
//            if ($data->isopen == 0) {
//                $result = DB::table('courses')->where('id', $id)->update(['isopen' => 1]);
//                if ($result) {
//                    return redirect()->back()->withInput()->withSuccess('开通成功！');
//                }
//            } else {
//                return redirect()->back()->withInput()->withErrors('已在开通状态下');
//            }
//        } else {
//            return redirect()->back()->withInput()->withErrors('审核通过后才能开通！');
//        }
    }

    public function guanbi($id) {
        $data = DB::table('courses')->where('id', $id)->first();
        if ($data->isopen == 1) {
            $result = DB::table('courses')->where('id', $id)->update(['isopen' => 0]);
            if ($result) {
                return redirect()->back()->withInput()->withSuccess('关闭成功！');
            }
        } else {
            return redirect()->back()->withInput()->withErrors('已在关闭状态下');
        }
    }

    public function daoru(Request $request) {
        dd($_FILES['file_stu']);
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
                ->where('sucode', $_ENV['user']['ic'])
                ->first();

        $this->oj->data = $data;

        $this->oj->activity_type = app('main')->getactivitytypelist();

        $this->oj->isedit = true;
        $this->oj->mynav = '编辑课程';
        $this->oj->action = $this->currentcontroller . '/' . $id;
        return view($this->viewfolder . '.create', ['oj' => $this->oj]);
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


        $mdb = $this->basemdb($request);
        $rs = $mdb->rs;
        $rs['auditstatus'] = 'new';

        DB::table($this->dbname)
                ->where('id', $id)
                ->update($rs);

        $suctip[] = '请等待牵头部门审核';
        $suctip[] = '<a href = "' . $this->currentcontroller . '">返回课程管理</a>';
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

    public function shenhe($id) {
        return view($this->viewfolder . '.shenhe', ['j' => $this->j, 'course_id' => $id]);
    }

    public function qiandao($id) {
        return view($this->viewfolder . '.qiandao', ['j' => $this->j, 'course_id' => $id]);
    }

    public function qiandao2($id) {
        return view($this->viewfolder . '.qiandao2', ['j' => $this->j, 'course_id' => $id]);
    }

    public function zuoye($id) {
        return view($this->viewfolder . '.zuoye', ['j' => $this->j, 'course_id' => $id]);
    }

    public function xuefen($id) {
        return view($this->viewfolder . '.xuefen', ['j' => $this->j, 'course_id' => $id]);
    }

    public function pingjia($id) {
        return view($this->viewfolder . '.pingjia', ['j' => $this->j, 'course_id' => $id]);
    }

}
