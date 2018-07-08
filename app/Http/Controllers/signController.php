<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Validator;
use Illuminate\Support\Facades\Cache;

class signController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->currentcontroller = '/signin'; //控制器
        $this->viewfolder = 'manage.qiandao'; //视图路径
        $this->j['nav'] = 'qiandao';
        $this->j['currentcontroller'] = $this->currentcontroller;
    }

    public function signin($ic) {
        $newic = substr($ic, 0, -15);
        $code = substr($ic, -15);
        $result = DB::table('activity')->where('ic', $newic)->first();

        $myurl = $this->currentcontroller . '/' . $ic;

        $oj = (object) [];
        $oj->title = '活动签到';

        if (!$result) {
            dd('您的二维码不对，还是规矩去签到吧！给您个提示后面的参数位数不对哦');
        }

        if ($result->signcode != $code) {
            dd('您的二维码不对，还是规矩去签到吧！位数对了组合哦');
        }

        $this->j = $ic;

        $oj->ic = $ic;
        $oj->title = '签到码';

        return view($this->viewfolder . '.sign', ['j' => $this->j, 'oj' => $oj]);
    }

    public function dosignin(Request $request) {
        $oj = (object) [];
        $oj->title = '签到成功';

        $ic = $request->ic;
        $newic = substr($ic, 0, -15); //活动ic
        $code = $request->code;
        $pass = $request->upass;

        $myurl = $this->currentcontroller . '/' . $ic . '?' . time();


        /* 按学号提取这个学生 */
        $thestuendt = $this->getthestudent($code, $newic);
        if (!$thestuendt) {
            return redirect($myurl)->withInput()->withErrors('未报名或没有审核通过,签到失败');
        }

        $b = Hash::check($pass, $thestuendt->upass);

        if ($b != true) {
            return redirect($myurl)->withInput()->withErrors('密码不正确请修改后重新提交');
        }

        $data['ucode'] = $code;
        $data['signintime'] = time();
        $data['issignined'] = 1;

        $result = DB::table('activity_signup')
                ->where('activityic', $newic)
                ->where('ucode', $code)
                ->where('issignined', '<>', 1)
                ->update($data);

        if ($result < 1) {
            return redirect($myurl)->withInput()->withErrors('请不要重复签到');
        }

        /* 更新签到签退统计
         * 改成手动更新统计了
         *  */
        //$this->updateactivitycount($newic);

        return view($this->viewfolder . '.sign_success', ['j' => $this->j, 'oj' => $oj]);
    }

    public function signout($ic) {
        $oj = (object) [];

        $newic = substr($ic, 0, -15);
        $code = substr($ic, -15);
        $result = DB::table('activity')->where('ic', $newic)->first();


        if (!$result) {
            dd('您的二维码不对，还是规矩去签退吧！给您个提示后面的参数位数不对哦');
        }


        if ($result->signcode != $code) {
            dd('您的二维码不对，还是规矩去签退吧！位数对了组合哦');
        }

        $this->j = $ic;
        $oj->title = '签退';
        return view($this->viewfolder . '.signout', ['j' => $this->j, 'oj' => $oj]);
    }

    public function dosignout(Request $request) {
        $oj = (object) [];
        $oj->title = '签退成功';

        $ic = $request->ic;
        $newic = substr($ic, 0, -15);
        $code = $request->code;
        $pass = $request->upass;

        $myurl = '/signout/' . $ic . '?' . time();

        /* 按学号提取这个学生 */
        $thestuendt = $this->getthestudent($code, $newic);
        if (!$thestuendt) {
            return redirect($myurl)->withInput()->withErrors('未报名或没有审核通过,签退失败');
        }

        $b = Hash::check($pass, $thestuendt->upass);

        if ($b != true) {
            return redirect($myurl)->withInput()->withErrors('密码不正确请重新修改');
        }

        $data['ucode'] = $code;
        $data['signoffedime'] = time();
        $data['issignoffed'] = 1;

        $mycount = DB::table('activity_signup')
                ->where('ucode', $code)
                ->where('activityic', $newic)
                ->where('issignoffed', '<>', 1)
                ->update($data);

        if ($mycount < 1) {
            return redirect($myurl)->withInput()->withErrors('请不要重复签退');
        }

        return view($this->viewfolder . '.signout_success', ['j' => $this->j, 'oj' => $oj]);
    }

    /* 更新活动签到签退统计 */

    private function updateactivitycount($aic) {

        $countin = DB::table('activity_signup')
                ->where('activityic', $aic)
                ->where('issignined', 1)
                ->count();
        $countoff = DB::table('activity_signup')
                ->where('activityic', $aic)
                ->where('issignoffed', 1)
                ->count();

        $rs['herecount'] = $countin;

        DB::table('activity')
                ->where('ic', $aic)
                ->update($rs);
    }

    private function getthestudent($mycode, $activityic) {
        $key = 'myactivitystudents_' . $activityic;
        //从缓存提取
        if (!Cache::has($key)) {
            $result = $this->getsignupstudents($activityic);  /* 变成以学号为索引 */
            $a = array();
            for ($i = 0; $i < count($result); $i++) {
                $a[$result[$i]->ucode] = $result[$i];
            }
            cache([$key => $a], 10); //缓存10分钟
        }

        $mystudents = Cache::get($key);

        if (array_key_exists($mycode, $mystudents)) {
            return $mystudents[$mycode];
        } else {
            /* 缓存里没有可能重报名的 */
            $count = DB::table('activity_signup')
                    ->where('activityic', $activityic) //是这个活动的               
                    ->where('auditstatus', 'pass')
                    ->where('ucode', $mycode)
                    ->count();

            if ($count > 0) {
                Cache::forget($key);
                return $this->getthestudent($mycode, $activityic);
            }
        }
    }

    /* 提取报名的学生列表 */

    private function getsignupstudents($activityic) {
        $result = DB::table('activity_signup')
                ->where('activityic', $activityic) //是这个活动的               
                ->where('auditstatus', 'pass')
                ->leftjoin('students', 'activity_signup.ucode', '=', 'students.mycode')
                ->select('activity_signup.*', 'students.realname', 'students.dname as dname', 'students.gender', 'students.upass')
                ->get();
        return $result;
    }

    /* 这个活动所有报名的学生 */

    private function getmyactivitystudents($activityic) {
        DB::table('courses_hour')
                ->where('signcode', $signcode)
                ->first();
    }

}
