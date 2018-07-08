<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use App\Repositories\activity as activityRepository;

class huodong_xuefenController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;
    private $activityid; //活动id

    function __construct(activityRepository $cr) {
        $this->oj = (object) [];
        $this->cr = $cr;

        $this->currentcontroller = '/admin/huodong_xuefen'; //控制器
        $this->viewfolder = 'admin.huodong.xuefen'; //视图路径
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

        $o = $this->cr->creditlist($this->oj->activity, $request);

        if ($o->validator->fails()) {
            return redirect()->back()->withInput()->withErrors(($validator->errors()->toArray()));
        }

        $this->oj->search = $o->search;
        $this->oj->list = $o->list;
        $this->oj->statistics = $o->statistics;


        return view($this->viewfolder . '.index', ['oj' => $this->oj]);
    }

    public function export($aid, Request $request) {
        $this->oj->activity = $request->j['activity'];
        $this->activity = $this->oj->activity;

        $this->cr->creditexport($this->oj->activity);
    }

    public function formpass($aid, $id, Request $request) {
        $signup = app('main')->getactivitysignupbyid($id);

        $this->j['signup'] = $signup;

        return view($this->viewfolder . '.formpass', ['j' => $this->j]);
    }

    public function dopass($aid, $id, Request $request) {
        $arr['suc'] = 'n';

        $rules = array(
            'mylevel' => 'required|integer|in:1,2,3,4'
        );

        $attributes = array(
            'mylevel' => '等级'
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            $arr['err'] = $validator->errors()->toArray();

            echo json_encode($arr, 320);
            return;
        }


        $signup = app('main')->getactivitysignupbyid($id);




        $rs['activityisok'] = 1;
        $rs['mylevel'] = $request->mylevel;
        $rs['actualcreidt'] = $this->activity->mycredit;
        DB::table($this->dbname)->where('id', $id)->update($rs);

        $arr['suc'] = 'y';
        $arr['reload'] = 'y';


        echo json_encode($arr, 320);
        return;
    }

    public function formunpass($aid, $id, Request $request) {
        $signup = app('main')->getactivitysignupbyid($id);

        $this->j['signup'] = $signup;

        return view($this->viewfolder . '.formunpass', ['j' => $this->j]);
    }

    public function dounpass($aid, $id, Request $request) {
        $arr['suc'] = 'n';

        $rules = array(
            'creditexplain' => 'required|string|between:1,255'
        );

        $attributes = array(
            'creditexplain' => '原因'
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            $arr['err'] = $validator->errors()->toArray();

            echo json_encode($arr, 320);
            return;
        }


        $signup = app('main')->getactivitysignupbyid($id);

        if (2 == $signup->activityisok) {
            $arr['err'] = '已经是未通过状态了，请不要重复操作';

            echo json_encode($arr, 320);
            return;
        }


        $rs['mylevel'] = '4';
        $rs['activityisok'] = 2;
        $rs['creditexplain'] = $request->creditexplain;
        $rs['actualcreidt'] = 0;
        DB::table($this->dbname)->where('id', $id)->update($rs);

        $arr['suc'] = 'y';
        $arr['reload'] = 'y';


        echo json_encode($arr, 320);
        return;
    }

    private function init_activity($aid) {

        /* 接收活动名称 */
        $this->aid = $aid;
        $this->j['aid'] = $aid;

        /* 提取活动 */
        $this->activity = app('main')->getactivitybyid($aid);
        $this->j['activity'] = & $this->activity;
    }

}
