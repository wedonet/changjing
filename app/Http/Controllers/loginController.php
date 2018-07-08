<?php

/* 学生登录 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use DB;

class loginController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->currentcontroller = '/loginController'; //控制器
        $this->viewfolder = ''; //视图路径
        $this->dbname = 'students';

        //$this->j['nav'] = 'banji';
        $this->j['currentcontroller'] = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('studentlogin');
    }

    public function dologin(Request $request) {


        $rules = array(
            'mycode' => 'required|string|between:1,20',
            'upass' => 'required|string|between:1,20'
        );

        $attributes = array(
            'mycode' => '学号',
            'upass' => '密码'
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        /**/
        $date = date("Y-m-d H:i:s", time());

        $student = DB::table($this->dbname)
                ->where('mycode', $request->mycode)
                ->first();


        if (!$student) {
            $validator->errors()->add('error', '学号名或密码错误！');
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }



        /* 检测错误次数 */
        $loginerr = app('main')->getloginerr($request->mycode, 'student');

        if ($loginerr['errcount'] > 2) {
            $validator->errors()->add('error', '错误次数过多，请' . $loginerr['hastime'] . '分钟后再试！');
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        //判定次数是否为5
        //验证密码
        $b = Hash::check($request->upass, $student->upass);


        if ($b == true) {
            //User::where('u_name', $input['username'])->update(['u_err' => '0']); //成功次数清零

            $u['gic'] = 'student';
            $u['dic'] = $student->dic; //部门编号
            $u['dname'] = $student->dname; //部门名称
            $u['uname'] = $student->mycode;
            $u['ic'] = $student->mycode;
            $u['role'] = '';
            $u['rolename'] = '';
            $u['realname'] = $student->realname;
            $u['mycode'] = $student->mycode;


            session(['user' => $u]);

            //print_r(session('user'));
            //return view('command');
        } else {
            $history['gic'] = 'student';
            $history['dic'] = '';
            $history['roleic'] = '';
            $history['ip'] = $request->ip();
            $history['ctime'] = time();
            $history['uname'] = $request->mycode;

            DB::table('loginhistory')
                    ->insert($history);

            $validator->errors()->add('error', '学号或密码错误 ！');

            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }


        /* 首次登录需要修改密码 */
        if (app('main')->isfirstlogin($request->mycode, 'student', '')) {
            /* 加入一次性session */
            $request->session()->flash('uname', $request->mycode);
            $request->session()->flash('upass', $request->upass);

            $suctip[] = '首次登录请修改密码';
            $suctip[] = '<a href="/studentchangepass">点击进入修改密码页</a>';

            return ( app('main')->jssuccess('登录成功', $suctip));
        }


        $suctip[] = '<a href="/">返回首页</a>';
        $suctip[] = '<a href="/student">进入个人中心</a>';

        return ( app('main')->jssuccess('登录成功', $suctip));


        //if (DB::table($this->dbname)->insert($rs)) {
        //    $suctip[] = '<a href="' . $this->currentcontroller . '">返回班级管理</a>';
        //    return ( app('main')->jssuccess('保存成功', $suctip));
        //} else {
        //    $validator->errors()->add('error', '保存失败');
        //    return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        //}
        //return redirect('student');
    }

}
