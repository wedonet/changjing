<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use App\Repositories\activity as activityRepository;

class huodong_pingjiaController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;
    private $activityid; //活动id

    function __construct(activityRepository $cr) {
        $this->oj = (object) [];
        $this->cr = $cr;

        $this->currentcontroller = '/admin/huodong_appraise'; //控制器
        $this->viewfolder = 'admin.huodong.pingjia'; //视图路径
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

        $o = $this->cr->appraiselist($this->oj->activity, $request);

        if ($o->validator->fails()) {
            return redirect()->back()->withInput()->withErrors(($validator->errors()->toArray()));
        }

        $this->oj->search = $o->search;
        $this->oj->list = $o->list;
        $this->oj->statistics = $o->statistics;

        return view($this->viewfolder . '.index', ['oj' => $this->oj]);
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
