<?php

/* 学生找回密码 */

namespace App\Http\Controllers\login;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use DB;

class studentfindpassController extends Controller {

    private $oj;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->oj = (object) [];

        $this->currentcontroller = 'studentfindpassController'; //控制器
        $this->viewfolder = 'login.'; //视图路径
        $this->dbname = 'students';

        //$this->j['nav'] = 'department';
        $this->oj->currentcontroller = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function findpass(Request $request) {



        return view($this->viewfolder . 'studentfindpass', ['oj' => $this->oj]);
    }

    
    /*同一个IP每天十次，同一个学号每天五次*/
    public function findpass_do(Request $request) {
        $rules = array(
            'mycode' => 'required|string|between:4,20',
            'mynumber' => 'required|string|between:18,18',
            'realname' => 'required|string|between:2,18',
            'captcha' => 'required|captcha',
        );

        $attributes = array(
            'mycode' => '学号',
            'mynumber' => '身份证号',
            'realname' => '真实姓名',
            'captcha' => '验证码',
        );
        $message = array(
            'mynumber.between' => '身份证格式错误',
        );


        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors(($validator->errors()->toArray()));
        }



        $mycode = $request->mycode;
        $mynumber = $request->mynumber;
        $realname = $request->realname;
        $ip = $request->ip();

        /* 今天的起止时间 */
        $mydate = date('Y-m-d', time());

        $mytime = strtotime($mydate);


        /* 按IP找，一个IP,每天最多找10次 */
        $count = DB::table('findpasshistory')
                ->where('ip', $ip)
                ->whereBetween('ctime', [$mytime, ($mytime + 86400)])
                ->count();

        if ($count > 9) {
            //return redirect()->back()->withInput()->withErrors('您今天试的太多了，请明天再试');
        }


        /* 按学号找，一个学号每天最多找5次 */
        $count = DB::table('findpasshistory')
                ->where('mycode', $mycode)
                ->whereBetween('ctime', [$mytime, $mytime + 86400])
                ->count();
        if ($count > 4) {
            return redirect()->back()->withInput()->withErrors('您今天试的太多了，请明天再试');
        }

        /* 插入查找记录 */
        $rs = null;
        $rs['mycode'] = $mycode;
        $rs['mynumber'] = $mynumber;
        $rs['realname'] = $realname;
        $rs['ip'] = $ip;
        $rs['ctime'] = time();
        $rs['created_at'] = date("Y-m-d H:i:s", time());

        DB::table('findpasshistory')
                ->insert($rs);

        /* 按学号找用户 */
        $student = DB::table($this->dbname)
                ->where('mycode', $mycode)
                ->first();

        //验证用户是否存在
        if (!$student) {
            return redirect()->back()->withInput()->withErrors('姓名，学号或身份证号错误！');
        }


        /* 验证姓名和身份证号是否正确 */
        if ($student->mynumber != $mynumber Or $student->realname != $realname) {
            return redirect()->back()->withInput()->withErrors('姓名，学号或身份证号错误！');
        }



        /* 生成一个session,用于重设密码 */
        session(['setpassusercode' => $mycode]);

        $href = '/login/studentfindpass_setpass';


        $suctip[] = '下一步，请重新设置密码';
        $suctip[] = '二秒后跳转到设置密码页，或 <a href="' . $href . '">点击这里重设密码</a>';

        
        return redirect($href);
        //return redirect()->back()->withInput()->with('suctip', $suctip)->with('location', $href);
    }

    public function studentfindpass_setpass() {
        if (!session('setpassusercode')) {
            return redirect('/showerr')->with('errmessage', '出错了,非法操作!');
        }

        $mycode = session('setpassusercode');

        $data = DB::table('students')
                ->where('mycode', $mycode)
                ->first();

        if (!$data) {
            return redirect('/showerr')->with('errmessage', '出错了,非法操作!');
        }

        $this->oj->realname = $data->realname;

        return view('login.studentsetpass', ['oj' => $this->oj]);
    }

    /* 保存新密码 */

    public function studentfindpass_setpass_do(Request $request) {
        $rules = array(
            'upass' => 'required|confirmed|string|regex:/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9a-zA-Z]+$/|between:6,20',
            'captcha' => 'required|captcha',
        );

        $attributes = array(
            'upass' => '密码'
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }


        if (!session('setpassusercode')) {
            return redirect('/showerr')->with('errmessage', '出错了,非法操作!');
        }

        $mycode = session('setpassusercode');



        /**/
        $date = date("Y-m-d H:i:s", time());

        $data = DB::table($this->dbname)
                ->where('mycode', $mycode)
                ->first();

        //验证用户是否存在
        if (!$data) {
            $validator->errors()->add('error2', '出错了,非法操作!');
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );           
        }


        /* 存入新密码 */
        $rs['upass'] = bcrypt($request->upass);


        DB::table($this->dbname)
                ->where('id', $data->id)
                ->update($rs);


        $href = '/login';

        $suctip[] = '修改成功，请重新登录';
        $suctip[] = '<a href="' . $href . '">点击这里重新登录</a>';

        /* 释放掉 */
        session(['setpassusercode' => null]);

        return ( app('main')->jssuccess('修改成功', $suctip, $href));
    }

}
