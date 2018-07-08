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

class huodong_qiandaoController extends Controller {

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


        $this->currentcontroller = '/manage/huodong_qiandao'; //控制器
        $this->viewfolder = 'manage.huodong.qiandao'; //视图路径
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
//        $rules = array(
//            'title' => 'string|between:1,20'
//        );
//
//        $attributes = array(
//            "title" => '活动名称'
//        );
//
//        $message = array(
//        );
//
//        $validator = Validator::make(
//                        $request->all(), $rules, $message, $attributes
//        );
//
//        if ($validator->fails()) {
//            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
//        }
//
        $search['title'] = $request->title;
//
//        $search['currentstatus'] = $request->currentstatus;
//
//        $this->j['search'] = $search;




        $list = DB::table($this->dbname)
                ->where('activityic', $this->j['activity']->ic) //是这个活动的
                ->where('auditstatus', 'pass')
                //->where('isdel', 0)
                ->where(function($query) use($search) {
//                    if ('' != $search['title']) {
//                        $query->where('title', 'like', '%' . $search['title'] . '%');
//                    }
//                    if ('' != $search['currentstatus']) {
//                        $query->where('currentstatus', '=', $search['currentstatus']);
//                    }
                })
                ->leftjoin('students', 'activity_signup.ucode', '=', 'students.mycode')
                ->select('activity_signup.*', 'students.realname', 'students.dname as dname', 'students.gender', 'students.mobile')
                ->orderby('id', 'asc')
                ->paginate(18);

        $list->appends(['activityid' => $this->j['activity']->id]);
        $this->j['list'] = $list;


        /* 提取签到统计 */
        $l = DB::table($this->dbname)
                ->where('activityic', $this->j['activity']->ic) //是这个活动的
                ->where('auditstatus', 'pass')
                ->count();


        $this->j['statistics']['yingdao'] = $l; //     


        $l = DB::table($this->dbname)
                ->where('activityic', $this->activity->ic) //是这个活动的
                ->where('issignined', 1)
                ->count();


        $this->j['statistics']['shidao'] = $l; //    

        return view($this->viewfolder . '.index', ['j' => $this->j]);
    }

    public function daochu(Request $request) {
        require_once(base_path() . '/resources/views/init.blade.php');

        $this->j = array_merge($this->j, $request->j);
        $this->activity = & $this->j['activity'];

        $data = DB::table($this->dbname)
                ->where('auditstatus', 'pass')
                ->where('activityic', $this->activity->ic)
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
        $keshi[] = '是否签到';
        $keshi[] = '入场时间';
        $keshi[] = '是否签退';
        $keshi[] = '退场时间';

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
            if ($data[$i]->issignined == 1) {
                $re['issignined'] = '是';
            } elseif ($data[$i]->issignined == 0) {
                $re['issignined'] = '否';
            }
            if ($data[$i]->issignined == 1) {
                $re['issignined'] = '是';
            } elseif ($data[$i]->issignined == 0) {
                $re['issignined'] = '否';
            }
            $re['signintime'] = formattime2($data[$i]->signintime);
            if ($data[$i]->issignoffed == 1) {
                $re['issignoffed'] = '是';
            } elseif ($data[$i]->issignoffed == 0) {
                $re['issignoffed'] = '否';
            }
            $re['signoffedime'] = formattime2($data[$i]->signoffedime);
            $cellData[$j] = $re;
        }

        Excel::create($this->activity->title . '学生签到表', function($excel) use ($cellData) {
            $excel->sheet('score', function($sheet) use ($cellData) {
                $sheet->setAutoSize(false);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

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

        $this->j['activityid'] = $id;
        $this->j['activity'] = & $data;

        return view($this->viewfolder . '.detail', ['j' => $this->j]);
        //
    }

    public function qiandao($ic) {

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

        return view($this->viewfolder . '.edit', ['j' => $this->j]);
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

//    public function shenhe($id) {
//        $this->j['id'] = $id;
//
//        $search = [];
//
//        $list = DB::table('activity_signup')
//                //->where('isdel', 0)
//                ->where(function($query) use($search) {
////                    if ('' != $search['title']) {
////                        $query->where('title', 'like', '%' . $search['title'] . '%');
////                    }
////                    if ('' != $search['currentstatus']) {
////                        $query->where('currentstatus', '=', $search['currentstatus']);
////                    }
//                })
//                ->leftjoin('students', 'activity_signup.ucode', '=', 'students.mycode')
//                ->select('activity_signup.*', 'students.realname', 'students.dname as dname', 'students.gender', 'students.mobile')
//                ->orderby('activity_signup.id', 'desc')
//                ->get();
//
//        $this->j['list'] = $list;
//
//
//        return view($this->viewfolder . '.shenhe', ['j' => $this->j]);
//    }

    public function dosignin($id) {

        $rs['issignined'] = 1;
        $rs['signintime'] = time();


        $updatedcount = DB::table($this->dbname)
                ->where('id', $id)
                ->where('issignined', '<>', 1)
                ->update($rs);

        /* 更新签到签退统计 */
        $this->updateactivitycount($this->activity->ic);

        if ($updatedcount > 0) {

            return redirect()->back()->with('sucinfo', '操作成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('签到失败, 请不要重复签到！');
        }
    }

    public function dosignout($id) {
        /* 检测是不是签到过 */
        $mycount = DB::table($this->dbname)
                ->where('id', $id)
                ->where('issignined', 1)
                ->count();
        if ($mycount == 0) {
            return redirect()->back()->withInput()->withErrors('您还没有签到，不能签退');
        }

        $rs['issignoffed'] = 1;
        $rs['signoffedime'] = time();

        $updatedcount = DB::table($this->dbname)
                ->where('id', $id)
                ->where('issignoffed', '<>', 1)
                ->update($rs);

        /* 更新签到签退统计 */
        $this->updateactivitycount($this->activity->ic);

        if ($updatedcount > 0) {
            return redirect()->back()->with('sucinfo', '操作成功！');
        } else {
            return redirect()->back()->withInput()->withErrors('签退失败, 请不要重复签退！');
        }
    }

    /* 批量签到 */

    public function batchsignin(Request $request) {
        $this->j = array_merge($this->j, $request->j);

        $this->activity = & $this->j['activity'];

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
        }



        if (count($request->ids) < 1) {
            return redirect()->back()->withErrors('请选择要操作的记录');
        }

        $rs['issignined'] = 1;
        $rs['signintime'] = time();


        $updatedcount = DB::table($this->dbname)
                ->whereIn('id', $request->ids)
                ->where('issignined', '<>', 1)
                ->update($rs);

        /* 更新签到签退统计 */
        $this->updateactivitycount($this->activity->ic);

        return redirect()->back()->withInput()->with('sucinfo', '批量签到完成！');
    }

    private function init_activity($aid) {

        /* 接收活动名称 */
        $this->aid = $aid;
        $this->j['aid'] = $aid;

        /* 提取活动 */
        $this->activity = app('main')->getactivitybyid($aid);
        $this->j['activity'] = & $this->activity;
    }

    /* 更新活动签到签退统计 */

    private function updateactivitycount($aic) {
        $countin = DB::table($this->dbname)
                ->where('activityic', $aic)
                ->where('issignined', 1)
                ->count();
        $countoff = DB::table($this->dbname)
                ->where('activityic', $aic)
                ->where('issignoffed', 1)
                ->count();

        $rs['herecount'] = $countin;
        
        DB::table('activity')
                ->where('ic', $aic)
                ->update($rs);
    }

    
        /*更新统计*/
    public function recount_do(){
        $this->updateactivitycount($this->activity->ic);
        return redirect()->back()->withInput()->with('sucinfo', '操作成功！');
    }
}
