<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use DB;

class adminloginController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->currentcontroller = 'adminloginController'; //控制器
        $this->viewfolder = ''; //视图路径
        $this->dbname = 'adminusers';

        //$this->j['nav'] = 'department';
        $this->j['currentcontroller'] = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('adminlogin');
    }

    public function dologin(Request $request) {
        $rules = array(
            'uname' => 'required|string|between:1,20',
            'upass' => 'required|string|between:5,20'
        );

        $attributes = array(
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }



        $result = DB::table($this->dbname)
                ->where('uname', $request->uname)
                ->first();


        if (!$result) {
            $validator->errors()->add('error', '登录名或密码错误！');
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        /* 检测错误次数 */
        $loginerr = app('main')->getloginerr($request->uname, 'admin');

        if ($loginerr['errcount'] > 2) {
            $validator->errors()->add('error', '错误次数过多，请' . $loginerr['hastime'] . '分钟后再试！');
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        /* 检测密码是否正确 */
        if (!Hash::check($request->upass, $result->upass)) {
            $history['gic'] = 'admin';
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

        $u['uname'] = $request->uname;
        $u['gic'] = 'admin';
        $u['nickname'] = '系统管理员';
        $u['realname'] = '管理员';
        $u['mycode'] = 'admin';
        $u['dname'] = '管理';
        $u['rolename'] = '系统管理员';
        $u['role'] = '';
        $u['dic'] = '';
        $u['ic'] = 'admin';

        //$u['gic'] = 'student';






        session(['user' => $u]);


        $suctip[] = '<a href="/adminconsole">三秒后自动进入管理中心</a>';

        return ( app('main')->jssuccess('登录成功', $suctip, 'adminconsole'));
    }

}
