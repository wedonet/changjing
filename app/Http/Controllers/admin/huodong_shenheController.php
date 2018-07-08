<?php

/* 活动审核 */

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use App\Repositories\activity as activityRepository;

class huodong_shenheController extends Controller {
    private $parent;
    private $viewfolder;
    private $dbname;
    private $activityid; //活动id
    public $aid;

    function __construct(activityRepository $cr) {
        $this->oj = (object) [];
        $this->cr = $cr;

        $this->currentcontroller = '/adminconsole/huodong_shenhe'; //控制器
        $this->viewfolder = 'admin.huodong.shenhe'; //视图路径
        $this->dbname = 'activity_signup';

        $this->oj->nav = 'huodong';
        $this->oj->currentcontroller = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {        
        $this->oj->activity = $request->j['activity'];

        $o = $this->cr->shenhelist($request, $this->oj->activity);

        if ($o->validator->fails()) {
            return redirect()->back()->withInput()->withErrors(($validator->errors()->toArray()));
        }

        $this->oj->search = $o->search;
        $this->oj->list = $o->list;     


        return view($this->viewfolder . '.index', ['oj' => $this->oj]);
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
    public function store(Request $request) {

        $rules = array(
            'title' => 'required|string|between:1,50',
            'activity_year' => 'required',
            'type_oneic' => 'required|string|between:1,20',
            'type_twoic' => 'required|string|between:1,20',
            'mylevel' => 'required|string|between:1,20',
            'mytimelong' => 'required|integer|between:1,64',
            'plantime_one' => 'required|date',
            'plantime_two' => 'required|date',
            'signuptime_one' => 'required|date',
            'signuptime_two' => 'required|date',
            'sponsor' => 'required|string|between:1,20',
            'myplace' => 'required|string|between:1,50',
            'readme' => 'required|string|between:1,255',
            'homework' => 'required|in:0,1',
            'homeworktime_one' => 'required_if:homework,1|date',
            'homeworktime_two' => 'required_if:homework,1|date',
            'mywayic' => 'required|in:direct,audit',
            'signlimit' => 'required_if:mywayic,accept',
            'other' => 'string|between:1,255',
            'attachmentsurl' => 'string|between:1,255'
        );

        $attributes = array(
            'title' => '名称',
            'activity_year' => '学年',
            'type_oneic' => '一级活动类型',
            'type_twoic' => '二级活动类型',
            'mylevel' => '活动级别',
            'mytimelong' => '活动时长',
            'plantime_one' => '活动开始时间',
            'plantime_two' => '活动结束时间',
            'signuptime_one' => '报名开始时间',
            'signuptime_two' => '报名结束时间',
            'sponsor' => '主办单位',
            'myplace' => '活动地点',
            'readme' => '活动介绍',
            'homework' => '是否需要提交作业',
            'homeworktime_one' => '提交作业开始时间',
            'homeworktime_two' => '提交作业结止时间',
            'mywayic' => '报名方式',
            'signlimit' => '报名人数限制',
            'other' => '备注',
            'attachmentsurl' => '附件路径'
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        /* 生成活动名称 */
        $the_activity = app('main')->getactivitytypebyic($request->type_oneic);
        $type_onename = $the_activity->title;

        $the_activity = app('main')->getactivitytypebyic($request->type_twoic);
        $type_twoname = $the_activity->title;

        /* 计算学分 * 1000 为了不要小数 */
        $mycredit = $request->mytimelong / 16 * 1000;


        /**/
        $time = time();
        $date = date("Y-m-d H:i:s", $time);

        $rs['ic'] = app('main')->getfirstic();

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


        $rs['readme'] = $request->readme;
        $rs['homework'] = $request->homework;
        $rs['homeworktime_one'] = strtotime($request->homeworktime_one);
        $rs['homeworktime_two'] = strtotime($request->homeworktime_two);

        $rs['mywayic'] = $request->mywayic;
        $rs['signlimit'] = $request->signlimit;
        $rs['other'] = $request->other;
        $rs['attachmentsurl'] = $request->attachmentsurl;



        $rs['isopen'] = 0;
        $rs['sucode'] = '';
        $rs['suname'] = '';
        $rs['auditstatus'] = 'new';
        $rs['signcode'] = app('main')->makecode('stack');

        $rs['currentstatus'] = 'new';
        $rs['created_at'] = $date;

        if (DB::table($this->dbname)->insert($rs)) {
            $suctip[] = '<a href = "' . $this->currentcontroller . '">返回活动管理</a>';
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

        //$this->j['activity_type'] = app('main')->getactivitytypelist();

        return view($this->viewfolder . '.detail', ['j' => $this->j]);
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function dopass($aid, $id) {
        $arr['suc'] = 'n';

        $signup = $this->getsignbyid($id);

        if ('pass' == $signup->auditstatus) {
            $arr['err'] = '已经是通过状态了，请不要重复审核';
            return $arr;
        }

        $rs['auditstatus'] = 'pass';
        DB::table($this->dbname)->where('id', $id)->update($rs);

        $arr['suc'] = 'y';
        $arr['reload'] = 'y';

        /* 更新通过数 */
        $this->updatepassnum($this->activity->ic);
        return $arr;
    }

    public function unpass($id) {
        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->first();

        $this->j['data'] = $data;

        $this->j['activity_type'] = app('main')->getactivitytypelist();

        return view($this->viewfolder . '.unpass', ['j' => $this->j]);
    }

    /* 审核学生是否能参加活动 */

    public function dounpass($aid, $id, Request $request) {
        $arr['suc'] = 'n';

        $rules = array(
            'myexplain' => 'required|string|between:1,255'
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


        $signup = $this->getsignbyid($id);

        if ('unpass' == $signup->auditstatus) {
            $arr['err'] = '已经是未通过状态了，请不要重复操作';

            echo json_encode($arr, 320);
            return;
        }

        $rs['auditstatus'] = 'unpass';
        DB::table($this->dbname)->where('id', $id)->update($rs);

        $arr['suc'] = 'y';
        $arr['reload'] = 'y';

        /* 更新通过数 */
        $this->updatepassnum($this->activity->ic);


        echo json_encode($arr, 320);
        return;
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
            'title' => 'required|string|between:1,50',
            'activity_year' => 'required',
            'type_oneic' => 'required|string|between:1,20',
            'type_twoic' => 'required|string|between:1,20',
            'mylevel' => 'required|string|between:1,20',
            'mytimelong' => 'required|integer|between:1,64',
            'plantime_one' => 'required|date',
            'plantime_two' => 'required|date',
            'signuptime_one' => 'required|date',
            'signuptime_two' => 'required|date',
            'sponsor' => 'required|string|between:1,20',
            'myplace' => 'required|string|between:1,50',
            'readme' => 'required|string|between:1,255',
            'homework' => 'accepted:0,1',
            'homeworktime_one' => 'required_with:homework|date',
            'homeworktime_two' => 'required_with:homework|date',
            'mywayic' => 'required|in:direct,audit',
            'signlimit' => 'required_if:mywayic,accept',
            'other' => 'string|between:1,255',
            'attachmentsurl' => 'string|between:1,255'
        );

        $attributes = array(
            'title' => '名称',
            'activity_year' => '学年',
            'type_oneic' => '一级活动类型',
            'type_twoic' => '二级活动类型',
            'mylevel' => '活动级别',
            'mytimelong' => '活动时长',
            'plantime_one' => '活动开始时间',
            'plantime_two' => '活动结束时间',
            'signuptime_one' => '报名开始时间',
            'signuptime_two' => '报名结束时间',
            'sponsor' => '主办单位',
            'myplace' => '活动地点',
            'readme' => '活动介绍',
            'homework' => '是否需要提交作业',
            'homeworktime_one' => '提交作业开始时间',
            'homeworktime_two' => '提交作业结止时间',
            'mywayic' => '报名方式',
            'signlimit' => '报名人数限制',
            'other' => '备注',
            'attachmentsurl' => '附件路径'
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        /* 生成活动名称 */
        $the_activity = app('main')->getactivitytypebyic($request->type_oneic);
        $type_onename = $the_activity->title;

        $the_activity = app('main')->getactivitytypebyic($request->type_twoic);
        $type_twoname = $the_activity->title;

        /* 计算学分 * 1000 为了不要小数 */
        $mycredit = $request->mytimelong / 16 * 1000;


        /**/
        $date = date("Y-m-d H:i:s", time());

        $rs['title'] = $request->title;
        $rs['activity_year'] = $request->avtivity_year;
        $rs['type_oneic'] = $request->type_oneic;
        $rs['type_twoic'] = $request->type_twoic;
        $rs['type_onename'] = $type_onename;
        $rs['type_twoname'] = $type_twoname;


        $rs['mylevel'] = $request->mylevel;
        $rs['mytimelong'] = $request->mytimelong;
        $rs['mycredit'] = $mycredit;
        $rs['plantime_one'] = $request->plantime_one;
        $rs['plantime_two'] = $request->plantime_two;


        $rs['signuptime_one'] = $request->signuptime_one;
        $rs['signuptime_two'] = $request->signuptime_two;
        $rs['sponsor'] = $request->sponsor;
        $rs['myplace'] = $request->myplace;


        $rs['readme'] = $request->readme;
        $rs['homework'] = $request->homework;
        $rs['homeworktime_one'] = $request->homeworktime_one;
        $rs['homeworktime_two'] = $request->homeworktime_two;

        $rs['mywayic'] = $request->mywayic;
        $rs['signlimit'] = $request->signlimit;
        $rs['other'] = $request->other;
        $rs['attachmentsurl'] = $request->attachmentsurl;



        $rs['isopen'] = 0;
        $rs['sucode'] = '';
        $rs['suname'] = '';
        $rs['auditstatus'] = 'new';
        $rs['signcode'] = app('main')->makecode('stack');

        $rs['created_at'] = $date;


        DB::table($this->dbname)->where('id', $id)->update($rs);



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

    /* 批量导出

     */

    public function export(Request $request) {
        require_once(base_path() . '/resources/views/init.blade.php');

        $this->oj->activity = $request->j['activity'];
        $this->activity = $this->oj->activity;

        $this->cr->shenheexport($this->oj->activity );
    }

    /* 提取活动报名信息 */

    public function getsignbyid($id) {
        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->first();

        return $data;
    }

    /* 更新通过数 */

    private function updatepassnum($aic) {
        /* 计算通过数 */
        $count = DB::table('activity_signup')
                ->where('activityic', $aic)
                ->where('auditstatus', 'pass')
                ->count();
        /* 更新 */
        $rs['checkcount'] = $count;


        DB::table('activity')->where('ic', $aic)->update($rs);
    }

    public function allpass(Request $request) {
        $arr['suc'] = 'n';


        $rules = array(
            'ids' => 'required|array'
        );

        $attributes = array(
            'ids' => '记录'
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }



        if (count($request->ids) < 1) {
            $validator->errors()->add('error', '请选择要操作的记录');
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }


        $rs['auditstatus'] = 'pass';
        DB::table($this->dbname)
                ->whereIn('id', $request->ids)
                ->update($rs);

        $arr['suc'] = 'y';
        $arr['reload'] = 'y';

        /* 更新通过数 */
        $this->updatepassnum($this->activity->ic);



        $suctip[] = '批量审核完成,页面将自动刷新';

        return ( app('main')->jssuccess('操作成功', $suctip, 'reload'));
    }

}
