<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use App\Repositories\course as courseRepository;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class course_qiandaoController extends Controller {

    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct(courseRepository $cr) {
        $this->oj = (object) [];

        $this->cr = $cr;

        $this->currentcontroller = '/admin/course_qiandao'; //控制器
        $this->viewfolder = 'admin.course.qiandao'; //视图路径
        $this->dbname = 'courses_signup';

        $this->oj->nav = 'course';
        $this->oj->currentcontroller = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $this->init($request);

        $olist = $this->cr->getlistqiandao($request, $this->oj->course->ic);
        $this->oj->list = $olist->list;

        return view($this->viewfolder . '.index', ['oj' => $this->oj]);
    }

    /* 学生签到列表 */

    public function classqiandao(Request $request) {
        $this->init($request);

        $courses_hour = $this->cr->getclass_hour($request->classid);
        $olist = $this->cr->classqiandao($request, $this->oj->course->ic);

        if (isset($olist->validator)) {
            return redirect()->back()->withInput()->withErrors(($olist->validator->errors()->toArray()));
        }

        $countyingdao = $this->cr->countyingdao($this->oj->course->ic);
        $countshidao = $this->cr->countshidao($this->oj->course->ic, $courses_hour->coursenum);


        $this->oj->yingdao = $countyingdao;
        $this->oj->shidao = $countshidao; //    
        $this->oj->classid = $olist->classid;
        $this->oj->classorder = $request->classorder; //第几课 排序
        $this->oj->list = $olist->list; //按学生报名情况的列表
        $this->oj->studentsignin = $olist->studentsignin; //这节课的签到记录

        return view($this->viewfolder . '.qiandao2', ['oj' => $this->oj]);
    }

    public function doexport($classid, Request $request) {
        $this->init($request);

        require_once(base_path() . '/resources/views/init.blade.php');

        $request->classid = $classid;
        $olist = $this->cr->classqiandao($request, $this->oj->course->ic);

        if (isset($olist->validator)) {
            return redirect()->back()->withInput()->withErrors(($olist->validator->errors()->toArray()));
        }

        $n = count($olist->list);

//        $a = array(
//            'ucode' => array(
//                'title' => '学号'
//            ),
//            'realname' => array(
//                'title' => '姓名'
//            ),
//            'classname' => array(
//                'title' => '班级'
//            ),
//            'mystate' => array(                                                                                                                                                                                                                                                                                                                                    
//                'title' => '申请陈述'
//            ),
//        );

        $keshi[] = '学号';
        $keshi[] = '姓名';
        $keshi[] = '性别';
        $keshi[] = '班级';
        $keshi[] = '学院';
        /**/

        $keshi[] = '是否签到';
        $keshi[] = '入场时间';
        //$keshi[] = '是否签退';
        //$keshi[] = '退场时间';

        $cellData[] = $keshi;

        foreach ($olist->list as $v) {
            $rs = array();
            $rs[] = $v->ucode; //学号
            $rs[] = $v->realname; //姓名
            $rs[] = $v->gender; //性别
            $rs[] = $v->classname; //班级
            $rs[] = $v->dname; //学院

            $rs[] = $this->issignin($olist->studentsignin, $v->ucode);    //是否签到
            $rs[] = $this->signintime($olist->studentsignin, $v->ucode);  //入场时间
            $cellData[] = $rs;
        }

//        $cellData[1]=$data[0];
        //for ($i = 0; $i < $n; $i++) {
//            $j = $i + 1;
//            $re['code'] = $data[$i]->ucode;
//            $student = DB::table('students')->where('mycode', $data[$i]->ucode)->first();
//            $re['name'] = $student->realname;
//            $re['gender'] = $student->gender;
//            $re['classname'] = $student->classname;
//            $re['dname'] = $student->dname;
//
//            /**/
//            $re['mobile'] = $student->mobile;
//            if ($data[$i]->issignined == 1) {
//                $re['issignined'] = '是';
//            } elseif ($data[$i]->issignined == 0) {
//                $re['issignined'] = '否';
//            }
//            if ($data[$i]->issignined == 1) {
//                $re['issignined'] = '是';
//            } elseif ($data[$i]->issignined == 0) {
//                $re['issignined'] = '否';
//            }
//            $re['signintime'] = formattime2($data[$i]->signintime);
//            if ($data[$i]->issignoffed == 1) {
//                $re['issignoffed'] = '是';
//            } elseif ($data[$i]->issignoffed == 0) {
//                $re['issignoffed'] = '否';
//            }
//            $re['signoffedime'] = formattime2($data[$i]->signoffedime);
//            $cellData[$j] = $re;
//        }

        Excel::create($this->oj->course->title . '_第' . $request->classorder . '课_学生签到表', function($excel) use ($cellData) {
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
        $this->j['courses_type'] = app('main')->getactivitytypelist();

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

        //$this->j['courses_type'] = app('main')->getactivitytypelist();

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

        $this->j['courses_type'] = app('main')->getactivitytypelist();

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

    /* ucode:学号 */

    public function dosignin($ucode, Request $request) {
        $this->init($request);

        $classid = $request->classid;

        /* 提取这节课的信息(课时) */
        $course_hour = DB::table('courses_hour')
                ->where('id', $classid)
                ->first();


        /* 检测是否签到过，如果第一次签，则添加签到记录 */
        $signinfo = DB::table('courses_signin')
                ->where('courseic', $this->oj->course->ic) //是这个课程的
                ->where('coursenumic', $course_hour->coursenum) //是这节课的
                ->where('ucode', $ucode)  //是这个人的
                ->first();

        if ($signinfo) {
            return redirect()->back()->withInput()->withErrors('签到失败, 这名同学已经签到过了！');
        }

        $rs['ucode'] = $ucode;
        $rs['courseic'] = $course_hour->courseic;
        $rs['coursenumic'] = $course_hour->coursenum;
        $rs['signintime'] = time();
        $rs['issignined'] = 1;
        $rs['mytype'] = 'in';
        $rs['ip'] = $request->ip();


        DB::beginTransaction();
        try {
            DB::table('courses_signin')
                    ->insert($rs);

            /* 更新签到签退统计 */
            $this->updateactivitycount($course_hour->coursenum);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }


        return redirect()->back()->with('sucinfo', '操作成功！');
    }

    public function dosignout($aid, $id) {
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

    function doallsignin($classid, Request $request) {
        $this->init($request);

        $rules = array(
            'ids' => 'required|array'
        );

        $attributes = array(
            'ids' => '学号'
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors(($validator->errors()->toArray()));
        }

        if (count($request->ids) < 1) {
            return redirect()->back()->withInput()->withErrors('请选择要操作的记录');
        }



        /* 提取这节课的信息(课时) */
        $course_hour = DB::table('courses_hour')
                ->where('id', $classid)
                ->first();
        if (!$course_hour) {
            return redirect('/showerr')->with('errmessage', '1022');
        }

        /* 提取这节课的签到列表，接下来循环每个同学，不在列表里则insert */
        $signlist = DB::table('courses_signin')
                ->where('coursenumic', $course_hour->coursenum) //是这节课的           
                ->get();
        $osignlist = (object) [];


        foreach ($signlist as $v) {
            $key = $v->ucode;
            $osignlist->$key = $v;
        }

        $ars = [];

        foreach ($request->ids as $v) {
            if (!isset($osignlist->$v)) {
                $rs['ucode'] = $v;
                $rs['courseic'] = $this->oj->course->ic;
                $rs['coursenumic'] = $course_hour->coursenum;
                $rs['signintime'] = time();
                $rs['issignined'] = 1;
                $rs['mytype'] = 'in';
                $rs['ip'] = $request->ip();

                $ars[] = $rs;
            }
        }

        if (count($ars) > 0) {
            DB::beginTransaction();
            try {
                foreach ($ars as $v) {
                    DB::table('courses_signin')
                            ->insert($v);
                }

                /* 更新签到签退统计 */
                $this->updateactivitycount($course_hour->coursenum);

                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
                throw $e;
            }
        }





        return redirect()->back()->with('sucinfo', '操作成功！');
    }

    /* 签到码 */

    public function signincode($classid, Request $request) {
        $this->init($request);
        /*提取这节课的签到码*/
        $data = DB::table('courses_hour')
                ->where('id', $classid)
                ->first();
        $signcode = $data->signcode;


        $url = 'http';
        if ($_ENV['IsHttps']== 1) {
            $url .= "s";
        }
        $url .= '://';
        $url .= $_SERVER["HTTP_HOST"] . '/coursesignin/' . $signcode;

        //QrCode::format('png')
        //        ->size(500)
        //        ->color(255, 0, 255)
        //        ->generate($url, public_path("qrcodes/" . $signcode . '.png'));

        $this->oj->signcode = $signcode;
        $this->oj->url = $url;
        return view($this->viewfolder . '.signincode', ['oj' => $this->oj]);
    }

    private function init($request) {
        /* 接收课程名称 */
        $this->oj->course = $request->oj->course;
        $this->oj->courseid = $request->oj->course->id;
    }

    /* 更新课程签到签退统计 */

    private function updateactivitycount($course_hour_ic) {
        $countin = DB::table('courses_signin')
                ->where('coursenumic', $course_hour_ic)
                ->where('issignined', 1)
                ->count();
        $countoff = DB::table('courses_signin')
                ->where('coursenumic', $course_hour_ic)
                ->where('issignoffed', 1)
                ->count();

        $rs['signincount'] = $countin;
        $rs['signoffcount'] = $countoff;

        DB::table('courses_hour')
                ->where('coursenum', $course_hour_ic)
                ->update($rs);
    }

    function issignin(&$studentsignin, $ucode) {
        if (isset($studentsignin->$ucode)) {
            return '是';
        } else {
            return '';
        }
    }

// end func

    function signintime(&$studentsignin, $ucode) {
        if (isset($studentsignin->$ucode)) {
            return formattime2($studentsignin->$ucode->signintime);
        } else {
            return '';
        }
    }

}
