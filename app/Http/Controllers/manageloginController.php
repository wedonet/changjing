<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use DB;

class manageloginController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->currentcontroller = 'manageloginController'; //控制器
        $this->viewfolder = ''; //视图路径
        $this->dbname = 'teachers';

        //$this->j['nav'] = 'department';
        $this->j['currentcontroller'] = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('managelogin');
    }

    public function dologin(Request $request) {
        $history = []; //登录日志

        $rules = array(
            'uname' => 'required|string|between:1,20',
            'upass' => 'required|string|between:1,20'
        );

        $attributes = array(
            'uname' => '登录名',
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

        $data = DB::table($this->dbname)
                ->where('mycode', $request->uname)
                ->first();

        //验证用户是否存在
        if (!$data) {
            $validator->errors()->add('error', '登录名或密码错误！');
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        /* 检测错误次数 */
        $loginerr = app('main')->getloginerr($request->uname, 'manage');

        if ($loginerr['errcount'] > 2) {
            $validator->errors()->add('error', '错误次数过多，请' . $loginerr['hastime'] . '分钟后再试！');
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }


        /* 检测密码是否正确 */
        if (!Hash::check($request->upass, $data->upass)) {
            /* 加入错误日志，一小时只能错3次 */
            $history['gic'] = 'manager';
            $history['dic'] = '';
            $history['roleic'] = '';
            $history['ip'] = $request->ip();
            $history['ctime'] = time();
            $history['uname'] = $request->uname;

            DB::table('loginhistory')
                    ->insert($history);


            $validator->errors()->add('error', '登录名或密码错误！');
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }


        /* 首次登录需要修改密码 */
        if (app('main')->isfirstlogin($request->uname, 'manager', $data->mytype)) {
            /* 加入一次性session */
            $request->session()->flash('uname', $request->uname);
            $request->session()->flash('upass', $request->upass);

            $suctip[] = '首次登录请修改密码';
            $suctip[] = '<a href="/managechangepass">点击进入修改密码页</a>';

            return ( app('main')->jssuccess('登录成功', $suctip));
        }


        $u['gic'] = 'manager';
        $u['dic'] = $data->dic; //部门编号
        $u['dname'] = $data->dname; //部门名称
        $u['uname'] = $request->uname;
        $u['ic'] = $data->mycode;
        $u['role'] = $data->mytype;
        $u['rolename'] = $data->realname;
        $u['realname'] = $data->realname;
        $u['mycode'] = $data->mycode;
     





        session(['user' => $u]);





        $suctip[] = '<a href="/">返回首页</a>';
        $suctip[] = '<a href="/manage">进入教师管理平台</a>';

        return ( app('main')->jssuccess('登录成功', $suctip));
    }



}
