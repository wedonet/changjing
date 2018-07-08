<?php

//我的活动

namespace App\Http\Controllers\student;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class lishiController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->currentcontroller = '/student/huodonglishi'; //控制器
        $this->viewfolder = 'student.huodonglishi.'; //视图路径
        $this->dbname = 'activity_signup';

        $this->j['nav'] = 'huodonglishi';
        $this->j['currentcontroller'] = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $rules = array(
            'title' => 'alpha_num|between:1,20',
            'mycode' => 'alpha_num|between:1,20'
        );

        $attributes = array(
            "title" => '班级名称',
            'mycode' => '班级号'
        );

        $message = array(
        );

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        $search['title'] = $request->title;
        $search['mycode'] = $request->mycode;

        $this->j['search'] = $search;



        $list = DB::table($this->dbname)
                //->where('isdel', 0)
                ->where('ucode', $_ENV['user']['mycode'])
                ->where('activity_signup.auditstatus', 'pass')
                ->where(function($query) use($search) {
                    if ('' != $search['title']) {
                        $query->where('title', 'like', '%' . $search['title'] . '%');
                    }
                    if ('' != $search['mycode']) {
                        $query->where('mycode', 'like', '%' . $search['mycode'] . '%');
                    }
                })
                ->orderby('activity_signup.id', 'desc')
                ->leftjoin('activity', 'activity_signup.activityic', '=', 'activity.ic')
                ->select('activity.*', 'activity_signup.created_at as signat', 'activity_signup.actualcreidt as actualcreidt', 'activity_signup.mylevel as xuefenlevel', 'activity_signup.id as signupid', 'activity_signup.homeworkisdone', 'activity_signup.appraise', 'activity_signup.appraisetime'
                )
                ->paginate(12);

        $this->j['list'] = $list;

        return view($this->viewfolder . 'index', ['j' => $this->j]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
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

//        dd(123);
        return view('student.huodong.detail', ['j' => $this->j]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        return view('student.index', ['j' => $this->j]);
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

    public function homework($id) {
        $data = DB::table($this->dbname)
                ->where('activity_signup.id', $id)
                ->leftjoin('activity', 'activity_signup.activityic', '=', 'activity.ic')
                ->select('activity.*', 'activity_signup.homeworkisdone', 'activity_signup.homeworkurl', 'activity_signup.homeworkisok', 'activity_signup.homeworkexplain')
                ->first();

        $this->j['activity'] = $data;

        return view($this->viewfolder . 'homework', ['j' => $this->j]);
    }

    public function dohomework($id, Request $request) {
        $rules = array(
            'attachmentsurl' => 'required|string|between:1,255'
        );

        $attributes = array(
            'attachmentsurl' => '作业'
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        /* 检测班级负责人是否存在 */




        $date = date("Y-m-d H:i:s", time());

        $rs['homeworkurl'] = $request->attachmentsurl;
        $rs['homeworkisdone'] = 1;





        if (DB::table($this->dbname)->where('id', $id)->update($rs)) {
            $suctip[] = '请等待老师审核';
            $suctip[] = '<a href="' . $this->currentcontroller . '">返回我的活动</a>';
            return ( app('main')->jssuccess('保存成功', $suctip));
        } else {
            $validator->errors()->add('error', '保存失败');
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }
    }

    public function appraise($id) {


        return view($this->viewfolder . '.formappraise', ['j' => $this->j]);
    }

    public function doappraise($id, Request $request) {
        $arr['suc'] = 'n';

        $rules = array(
            'mylevel' => 'required|integer|between:1,5'
        );

        $attributes = array(
            'mylevel' => '评价'
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
        $activity = app('main')->getactivitybyic($signup->activityic);

   
 
        /* 检测是否评价过，是否是我参加的 */


        $rs['appraise'] = $request->mylevel;
        $rs['appraisetime'] = time();
        DB::table($this->dbname)->where('id', $id)->update($rs);


        /* 更新总评价 */
        $appraise = DB::table($this->dbname)
                ->where('appraise', '>', 0)
                ->where('activityic', $activity->ic)
                ->avg('appraise');

        unset($rs);


        $rs['appraise'] =$appraise*1000;
        DB::table('activity')->where('id', $activity->id)->update($rs);
        
        

        $arr['suc'] = 'y';
        $arr['reload'] = 'y';


        echo json_encode($arr, 320);
        return;
    }

}
