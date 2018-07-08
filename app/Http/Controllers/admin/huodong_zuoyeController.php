<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use App\Repositories\activity as activityRepository;

class huodong_zuoyeController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;
    private $activityid; //活动id

    function __construct(activityRepository $cr) {
        $this->oj = (object) [];
        $this->cr = $cr;

        $this->currentcontroller = '/admin/huodong_zuoye'; //控制器
        $this->viewfolder = 'admin.huodong.zuoye'; //视图路径
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

        $o = $this->cr->homeworklist($this->oj->activity, $request);

        if ($o->validator->fails()) {
            return redirect()->back()->withInput()->withErrors(($validator->errors()->toArray()));
        }

        $this->oj->search = $o->search;
        $this->oj->list = $o->list;
        $this->oj->statistics = $o->statistics;


        return view($this->viewfolder . '.index', ['oj' => $this->oj]);
    }

    public function export($aid,Request $request) {
        $this->oj->activity = $request->j['activity'];
        $this->activity = $this->oj->activity;

        $this->cr->homeworkexport($this->oj->activity);
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

    /* Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function dopass($aid, $id, Request $request) {
        $arr['suc'] = 'n';

        $signup = app('main')->getactivitysignupbyid($id);

        if (1 == $signup->auditstatus) {
            return redirect()->back()->withInput()->withErrors('已经是通过状态了， 请不要重复执行通过操作！');
        }

        $rs['homeworkisok'] = 1;

        DB::table($this->dbname)->where('id', $id)->update($rs);

        return redirect()->back()->withInput()->with('sucinfo', '操作成功！');
    }

    public function unpass($id) {
        $signup = app('main')->getactivitysignupbyid($id);

        $this->j['signup'] = $signup;

        return view($this->viewfolder . '.unpass', ['j' => $this->j]);
    }

    /* 审核学生是否能参加活动 */

    public function dounpass($aid, $id, Request $request) {
        $arr['suc'] = 'n';

        $rules = array(
            'homeworkexplain' => 'required|string|between:1,255'
        );

        $attributes = array(
            'homeworkexplain' => '原因'
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

        if (2 == $signup->homeworkisok) {
            $arr['err'] = '已经是未通过状态了，请不要重复操作';

            echo json_encode($arr, 320);
            return;
        }

        /* 生成未通过原因 */
        $text['text'] = $request->homeworkexplain;
        $text['time'] = time();
        $text['tcode'] = ''; //教师号

        $rs['homeworkisok'] = 2;
        $rs['homeworkexplain'] = json_encode($text, 320);
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
