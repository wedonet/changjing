<?php

namespace App\Http\Controllers\manage;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
/**/
use App\Repositories\activity as activityRepository;

class huodong_zuoyeController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;
    private $activityid; //活动id

    function __construct(Request $request, activityRepository $activityRepository) {
        /* 注入活动类 */
        $this->classactivity = $activityRepository;
        /* 获取当前活动 */
        $this->j = $this->classactivity->init_activity($request);

        $this->activity = $this->j['activity'];


        $this->currentcontroller = '/manage/huodong_zuoye'; //控制器
        $this->viewfolder = 'manage.huodong.zuoye'; //视图路径
        $this->dbname = 'activity_signup';

        $this->j['nav'] = 'huodong';
        $this->j['currentcontroller'] = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $search = (object) [];

        $rules = array(
            'title' => 'string|between:1,20',
            'homeworkisdone' => 'nullable|integer|in:0,1,2',
            'homeworkisok' => 'nullable|integer|in:0,1,2'
        );

        $attributes = array(
            "title" => '活动名称'
        );

        $message = array(
        );

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors(($validator->errors()->toArray()));
        }

        $search->title = $request->title;
        $search->homeworkisok = $request->homeworkisok;
        $search->homeworkisdone = $request->homeworkisdone;
        $search->ucode = '';
        $this->j['search'] = $search;


        $list = DB::table($this->dbname)
                ->where('activityic', $this->activity->ic) //是这个活动的
                ->where('auditstatus', 'pass') //审核通过的报名
                ->where(function($query) use($search) {
                    if ('' != $search->title) {
                        $query->where('title', 'like', '%' . $search->title . '%');
                    }
                    if ('' != $search->homeworkisok) {
                        $query->where('homeworkisok', '=', $search->homeworkisok);
                    }
                    if ('' != $search->homeworkisdone) {
                        $query->where('homeworkisdone', '=', $search->homeworkisdone);
                    }
                })
                ->leftjoin('students', 'activity_signup.ucode', '=', 'students.mycode')
                ->select('activity_signup.*', 'students.realname', 'students.dname as dname', 'students.gender', 'students.mobile')
                ->orderby('id', 'desc')
                ->paginate(1);

        $list->appends(['activityid' => $this->j['activity']->id]);
        $this->j['list'] = $list;


        /* 提取作业统计 */
        $l = DB::table($this->dbname)
                ->where('activityic', $this->activity->ic) //是这个活动的
                ->where('auditstatus', 'pass')
                ->count();


        $this->j['statistics']['yingjiao'] = $l; //     


        $l = DB::table($this->dbname)
                ->where('activityic', $this->activity->ic) //是这个活动的
                ->where('homeworkisdone', 1)
                ->count();


        $this->j['statistics']['shijiao'] = $l; //    



        return view($this->viewfolder . '.index', ['j' => $this->j]);
    }

    public function export($id, Request $request) {
        require_once(base_path() . '/resources/views/init.blade.php');

        $this->j = array_merge($this->j, $request->j);

        $data = DB::table($this->dbname)
                ->where('auditstatus', 'pass')
                ->where('activityic', $this->j['activity']->ic)
                ->get();
//        dd($data);
        $n = count($data);
        $keshi[] = '学号';
        $keshi[] = '姓名';
        $keshi[] = '性别';
        $keshi[] = '班级';
        $keshi[] = '学院';
        /**/
        $keshi[] = '手机号';
        $keshi[] = '是否完成作业';
        $keshi[] = '是否通过';
        $cellData[0] = $keshi;
//        $cellData[1]=$data[0];

        for ($i = 0; $i < $n; $i++) {
            $j = $i + 1;
            $re['code'] = $data[$i]->ucode;
            $student = DB::table('students')->where('mycode', $data[$i]->ucode)->first();
            $re['name'] = $student->realname;
            $re['gender'] = $student->gender;
            $re['classname'] = $student->classname;
            $re['dname'] = $student->dname;

            /**/
            $re['mobile'] = $student->mobile;
            $re['homeworkisdone'] = showyes($data[$i]->homeworkisdone);
            $re['homeworkisok'] = yorn($data[$i]->homeworkisok);

            $cellData[$j] = $re;
        }

        Excel::create('学生作业记录表', function($excel) use ($cellData) {
            $excel->sheet('score', function($sheet) use ($cellData) {
                $sheet->setAutoSize(true);
                $sheet->rows($cellData);
            });
        })->export('xls');
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

    public function dopass($id, Request $request) {

        $signup = app('main')->getactivitysignupbyid($id);

        if (1 == $signup->auditstatus) {
            return redirect()->back()->withInput()->withErrors('已经是通过状态了， 请不要重复执行通过操作！');
        }

        $rs['homeworkisok'] = 1;

        DB::table($this->dbname)->where('id', $id)->update($rs);

        return redirect()->back()->withInput()->with('sucinfo', '操作成功！');
    }

    /* 作业批量能通过 */

    public function doallpass($id, Request $request) {
        $this->j = array_merge($this->j, $request->j);
        $this->activity = & $this->j['activity']; //临时这么用，方便下面调用

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
            return redirect()->back()->withErrors(($validator->errors()->toArray()));
            //return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }


        $rs['homeworkisok'] = 1;

        DB::table($this->dbname)
                ->where('activityic', $this->activity->ic)
                ->whereIn('id', $request->ids)
                ->update($rs);

        return redirect()->back()->withInput()->with('sucinfo', '操作成功！');
    }

    public function unpass($id) {
        $signup = app('main')->getactivitysignupbyid($id);
        $student = app('main')->getstudentbycode($signup->ucode);

        $this->j['signup'] = $signup;
        $this->j['student'] = $student;

        return view($this->viewfolder . '.unpass', ['j' => $this->j]);
    }

    /* 审核学生是否能参加活动 */

    public function dounpass($id, Request $request) {
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

    public function allunpass($id) {
        $signup = app('main')->getactivitysignupbyid($id);


        $this->j['signup'] = $signup;


        return view($this->viewfolder . '.allunpass', ['j' => $this->j]);
    }

    /* 审核学生是否能参加活动 */

    public function doallunpass($id, Request $request) {
        $this->j = array_merge($this->j, $request->j);
        $this->activity = & $this->j['activity']; //临时这么用，方便下面调用

        $rules = array(
            'ids' => 'required|array',
            'homeworkexplain' => 'required|string|between:1,255'
        );

        $attributes = array(
            'ids' => '记录',
            'homeworkexplain' => '原因'
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors(($validator->errors()->toArray()));
        }

        $signup = app('main')->getactivitysignupbyid($id);



        /* 生成未通过原因 */
        $text['text'] = $request->homeworkexplain;
        $text['time'] = time();
        $text['tcode'] = ''; //教师号

        $rs['homeworkisok'] = 2;
        $rs['homeworkexplain'] = json_encode($text, 320);
        DB::table($this->dbname)
                ->where('activityic', $this->activity->ic)
                ->whereIn('id', $request->ids)
                ->update($rs);

        return redirect()->back()->withInput()->with('sucinfo', '操作成功！');
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
