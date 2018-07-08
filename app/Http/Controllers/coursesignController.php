<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Validator;
use Illuminate\Support\Facades\Cache;

class coursesignController extends Controller {

    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->oj = (object) [];

        $this->currentcontroller = '/coursesign'; //控制器
        $this->viewfolder = 'manage.course.signcode'; //视图路径

        $this->oj->dbname = 'courses_hour';
        $this->oj->nav = 'qiandao';
        $this->oj->currentcontroller = $this->currentcontroller;
    }

    public function formsignin($code) {
        $this->oj->title = '课程签到';

        $course_hour = DB::table($this->oj->dbname)
                ->where('signcode', $code)
                ->first();

        if (!$course_hour) {
            dd('您的二维码不对，还是规矩去签到吧！');
        }

        $this->oj->signcode = $code;
        return view($this->viewfolder . '.sign', ['oj' => $this->oj]);
    }

    public function dosignin(Request $request) {
        $this->oj->title = '课程签到';

        $mycode = $request->code;
        $signcode = $request->signcode;
        $pass = $request->upass;

        $myurl = '/coursesignin/' . $signcode . '?' . time();

        /* 提取课程的第几课信息 */
        $course_hour = $this->gethour($signcode);

        if (!$course_hour) {
            return redirect($myurl)->withInput()->withErrors('签到码错误');
        }

        $thestuendt = $this->getthestudent($mycode, $course_hour->courseic);

        if (!$thestuendt) {
            return redirect($myurl)->withInput()->withErrors('未报名或没有审核通过,签到失败');
        }

        $b = Hash::check($pass, $thestuendt->upass);

        if ($b != true) {
            return redirect($myurl)->withInput()->withErrors('密码不正确请修改后重新提交');
        }



        /* 检测是否签到过，如果第一次签，则添加签到记录 */
        $signinfo = DB::table('courses_signin')
                ->where('courseic', $course_hour->courseic) //是这个课程的
                ->where('coursenumic', $course_hour->coursenum) //是这节课的
                ->where('ucode', $mycode)  //是这个人的
                ->first();

        if ($signinfo) {
            return redirect($myurl)->withInput()->withErrors('已经签到过了，请不要重复签到');
        }

        $rs['ucode'] = $mycode;
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

        return view($this->viewfolder . '.sign_success', ['oj' => $this->oj]);
    }

    public function formsignout($ic) {
        $newic = substr($ic, 0, -15);
        $code = substr($ic, -15);
        $result = DB::table('activity')->where('ic', $newic)->first();
        if (!$result) {
            dd('您的二维码不对，还是规矩去签退吧！给您个提示后面的参数位数不对哦');
        } else {
            if ($result->signcode == $code) {
                $this->j = $ic;
                return view($this->viewfolder . '.signout', ['j' => $this->j]);
            } else {
                dd('您的二维码不对，还是规矩去签退吧！位数对了组合哦');
            }
        }
    }

    public function dosignout(Request $request) {
        $ic = $request->ic;
        $newic = substr($ic, 0, -15);
        $code = $request->code;
        $pass = $request->upass;
        $result = DB::table('students')->where('mycode', $code)->first();
        if (!$result) {
            dd('学生账号不存在');
        }

        $b = Hash::check($pass, $result->upass);
        if ($b == true) {
            $data['ucode'] = $code;
            $data['signoffedime'] = time();
            $data['issignoffed'] = 1;
            $re1 = DB::table('courses_signup')->where('courseic', $newic)->where('ucode', $code)->first();
            if ($re1) {

                /* 检测是否签到过 */
                $mycount = DB::table('courses_signup')
                        ->where('ucode', $code)
                        ->where('courseic', $newic)
                        ->where('issignined', 1)
                        ->count();
                if (0 == $mycount) {
                    dd('您还没有签到，不能签退');
                }

                $mycount = DB::table('courses_signup')
                        ->where('ucode', $code)
                        ->where('courseic', $newic)
                        ->where('issignoffed', '<>', 1)
                        ->update($data);

                if ($mycount > 0) {
                    return view($this->viewfolder . '.signout_success', ['j' => $this->j]);
                } else {
                    dd('请不要重复签退');
                }
            } else {
                dd('未报名签退失败');
            }
        } else {
            dd('密码不正确请重新修改！');
        }
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

    private function getthestudent($mycode, $courseic) {
        $key = 'mycoursestudents_' . $courseic;
        //从缓存提取
        if (!Cache::has($key)) {
            $result = $this->getsignupstudents($courseic);  /* 变成以学号为索引 */
            $a = array();
            for ($i = 0; $i < count($result); $i++) {
                $a[$result[$i]->ucode] = $result[$i];
            }
            cache([$key => $a], 1); //缓存1分钟
        }

        $mystudents = Cache::get($key);

        if (array_key_exists($mycode, $mystudents)) {
            return $mystudents[$mycode];
        }
    }

    /* 提取报名的学生列表 */

    private function getsignupstudents($courseic) {
        $result = DB::table('courses_signup')
                ->where('itemic', $courseic) //是这个课程的               
                ->where('auditstatus', 'pass')
                ->leftjoin('students', 'courses_signup.ucode', '=', 'students.mycode')
                ->select('courses_signup.*', 'students.realname', 'students.dname as dname', 'students.gender', 'students.upass')
                ->get();
        return $result;
    }

    private function gethour($signcode) {
        $key = 'coursehour_' . $signcode;

        //从缓存提取
        if (!Cache::has($key)) {
            $result = DB::table('courses_hour')
                    ->where('signcode', $signcode)
                    ->first();
            cache([$key => $result], 1); //缓存1分钟
        }

        return( Cache::get($key) );
    }

}
