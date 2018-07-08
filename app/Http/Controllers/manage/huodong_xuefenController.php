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

class huodong_xuefenController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;
    private $activityid; //活动id

    function __construct(activityRepository $activityRepository) {
        /* 注入活动类 */
        $this->classactivity = $activityRepository;


        $this->currentcontroller = '/manage/huodong_xuefen'; //控制器
        $this->viewfolder = 'manage.huodong.xuefen'; //视图路径
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
        $this->j = array_merge($this->j, $request->j);
        $this->activity = & $this->j['activity'];
        $rules = array(
            'title' => 'string|between:1,20',
            'activityisok' => 'nullable|integer|in:0,1,2'
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
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        $search['title'] = $request->title;
        $search['activityisok'] = $request->activityisok;

        $search['currentstatus'] = $request->currentstatus;

        $this->j['search'] = $search;




        $list = DB::table($this->dbname)
                ->where('activityic', $this->activity->ic) //是这个活动的
                ->where('auditstatus', 'pass')
                //->where('isdel', 0)
                ->where(function($query) use($search) {
                    if ('' != $search['title']) {
                        $query->where('title', 'like', '%' . $search['title'] . '%');
                    }
                    if ('' != $search['activityisok']) {
                        $query->where('activityisok', '=', $search['activityisok']);
                    }
                })
                ->leftjoin('students', 'activity_signup.ucode', '=', 'students.mycode')
                ->select('activity_signup.*', 'students.realname', 'students.dname as dname', 'students.gender', 'students.mobile')
                ->orderby('id', 'desc')
                ->paginate(18);

        $list->appends(['activityid' => $this->j['activity']->id]);
        $list->appends($search);

        $this->j['list'] = $list;


        /* 提取签到统计 */
        /* 总数 */
        $l = DB::table($this->dbname)
                ->where('activityic', $this->activity->ic) //是这个活动的
                ->where('auditstatus', 'pass')
                ->count();
        $this->j['statistics']['all'] = $l; //     

        /* 已评价数 */
        $l = DB::table($this->dbname)
                ->where('activityic', $this->activity->ic) //是这个活动的
                ->where('auditstatus', 'pass')
                ->where('activityisok', '>', 0)
                ->count();
        $this->j['statistics']['yiping'] = $l; //    

        /* 通过 */
        $l = DB::table($this->dbname)
                ->where('activityic', $this->activity->ic) //是这个活动的
                ->where('auditstatus', 'pass')
                ->where('activityisok', 1)
                ->count();
        $this->j['statistics']['pass'] = $l; //   

        /* 未通过 */
        $l = DB::table($this->dbname)
                ->where('activityic', $this->activity->ic) //是这个活动的
                ->where('auditstatus', 'pass')
                ->where('activityisok', 2)
                ->count();
        $this->j['statistics']['unpass'] = $l; //   


        return view($this->viewfolder . '.index', ['j' => $this->j]);
    }

    public function export($id, Request $request) {
        require_once(base_path() . '/resources/views/init.blade.php');

        $this->j = array_merge($this->j, $request->j);
        $this->activity = & $this->j['activity'];

        $data = DB::table($this->dbname)
                ->where('activityic', $this->activity->ic)
                ->where('auditstatus', 'pass') //审核通过的
                ->orderby('id', 'desc')
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
        $keshi[] = '作业是否通过';
        $keshi[] = '活动是否通过';
        $keshi[] = '学分';
        $keshi[] = '等级';
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
            $re['homeworkisok'] = homeworkokyorn($data[$i]->homeworkisok, $this->activity->homework);
            $re['activityisok'] = yorn($data[$i]->activityisok);


            /* 学分 */
            $re['actualcreidt'] = $data[$i]->actualcreidt / 1000;

            if ($data[$i]->mylevel == 1) {
                $re['mylevel'] = 'A';
            } elseif ($data[$i]->mylevel == 2) {
                $re['mylevel'] = 'B';
            } elseif ($data[$i]->mylevel == 3) {
                $re['mylevel'] = 'C';
            } elseif ($data[$i]->mylevel == 4) {
                $re['mylevel'] = 'D';
            } elseif ($data[$i]->mylevel == 0) {
                $re['mylevel'] = '未评分';
            }
            $cellData[$j] = $re;
        }

        Excel::create('学生学分记录表', function($excel) use ($cellData) {
            $excel->sheet('score', function($sheet) use ($cellData) {
                $sheet->rows($cellData)->setWidth(array(
                    'A' => 15,
                    'B' => 10,
                    'C' => 10,
                    'D' => 15,
                    'E' => 15,
                    'F' => 10,
                    'G' => 10,
                    'H' => 10,
                    'I' => 10,
                    'G' => 10
                ));
            });
        })->export('xls');
    }

    public function formpass($id, Request $request) {
        $signup = app('main')->getactivitysignupbyid($id);

        $this->j['signup'] = $signup;

        return view($this->viewfolder . '.formpass', ['j' => $this->j]);
    }

    public function dopass($id, Request $request) {
        $this->j = array_merge($this->j, $request->j);

        $this->activity = & $this->j['activity']; //临时这么用，方便下面调用

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

    public function formallpass($id, Request $request) {
        $this->j = array_merge($this->j, $request->j);

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
            return view('common.jopen')->withErrors(($validator->errors()->toArray()));
            //return redirect()->back()->withErrors(($validator->errors()->toArray()));           
        }

        $signup = app('main')->getactivitysignupbyid($id);

        $this->j['signup'] = $signup;
        $this->j['ids'] = $request->ids;

        return view($this->viewfolder . '.formallpass', ['j' => $this->j]);
    }

    public function doallpass($id, Request $request) {
        $this->j = array_merge($this->j, $request->j);

        $this->activity = & $this->j['activity']; //临时这么用，方便下面调用

        $rules = array(
            'mylevel' => 'required|integer|in:1,2,3,4',
            'ids' => 'required|array'
        );

        $attributes = array(
            'mylevel' => '等级'
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors(($validator->errors()->toArray()));
        }


        $signup = app('main')->getactivitysignupbyid($id);




        $rs['activityisok'] = 1;
        $rs['mylevel'] = $request->mylevel;
        $rs['actualcreidt'] = $this->activity->mycredit;

        DB::table($this->dbname)
                ->whereIn('id', $request->ids)
                ->where('activityic', $this->activity->ic)
                ->update($rs);

        return redirect()->back()->withInput()->with('sucinfo', '操作成功！');
    }

    public function formunpass($id, Request $request) {
        $signup = app('main')->getactivitysignupbyid($id);

        $this->j['signup'] = $signup;

        return view($this->viewfolder . '.formunpass', ['j' => $this->j]);
    }

    public function dounpass($id, Request $request) {
        $this->j = array_merge($this->j, $request->j);
        $this->activity = & $this->j['activity']; //临时这么用，方便下面调用

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

    public function formallunpass($id, Request $request) {
        $this->j = array_merge($this->j, $request->j);

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
            return view('common.jopen')->withErrors(($validator->errors()->toArray()));
            //return redirect()->back()->withErrors(($validator->errors()->toArray()));           
        }


        $signup = app('main')->getactivitysignupbyid($id);

        $this->j['signup'] = $signup;

        $this->j['ids'] = $request->ids;

        return view($this->viewfolder . '.formallunpass', ['j' => $this->j]);
    }

    public function doallunpass($id, Request $request) {
        $this->j = array_merge($this->j, $request->j);
        $this->activity = & $this->j['activity']; //临时这么用，方便下面调用

        $rules = array(
            'creditexplain' => 'required|string|between:1,255',
            'ids' => 'required|array'
        );

        $attributes = array(
            'creditexplain' => '原因'
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors(($validator->errors()->toArray()));
        }


        $signup = app('main')->getactivitysignupbyid($id);


        $rs['mylevel'] = '4';
        $rs['activityisok'] = 2;
        $rs['creditexplain'] = $request->creditexplain;
        $rs['actualcreidt'] = 0;

        DB::table($this->dbname)
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
