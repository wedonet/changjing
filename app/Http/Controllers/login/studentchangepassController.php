<?php

/* 首次登录修改密码 */

namespace App\Http\Controllers\login;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use DB;

class studentchangepassController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->currentcontroller = 'studentchangepassController'; //控制器
        $this->viewfolder = 'login.'; //视图路径
        $this->dbname = 'students';

        //$this->j['nav'] = 'department';
        $this->j['currentcontroller'] = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $user = (object) [];

        $user->uname = session('uname');
        $user->oldpass = session('upass');

        if ('' == $user->uname) {
            return redirect('/login');
        }

        $this->j['user'] = $user;


        return view($this->viewfolder . 'studentchangepass', ['j' => $this->j]);
    }

    public function dochange(Request $request) {
        $rules = array(
            'uname' => 'required|string|between:1,20',
            'oldpass' => 'required|string|between:1,20',
            'upass' => 'required|confirmed|string|regex:/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9a-zA-Z]+$/|between:6,20',
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



        $uname = $request->uname;
        $oldupass = $request->oldpass;

        /**/
        $date = date("Y-m-d H:i:s", time());

        $data = DB::table($this->dbname)
                ->where('mycode', $uname)
                ->first();

        //验证用户是否存在
        if (!$data) {
            $validator->errors()->add('error', '非法操作');
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }



        if (Hash::check($request->oldpass, $data->upass)) {
            $u['ic'] = 'student';
            $u['role'] = '';
            $u['rolename'] = '学生';
        } else {
            $validator->errors()->add('error', '非法操作1 ！');
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }


        /* 存入新密码 */

        $rs['upass'] = bcrypt($request->upass);


        DB::table($this->dbname)->where('id', $data->id)->update($rs);

        /* 添加首次修改密码记录 */
        unset($rs);
        $rs['gic'] = 'student';
        $rs['roleic'] = '';
        $rs['uname'] = $uname;
        $rs['created_at'] = $date;

        DB::table('loginchangepass')->insert($rs);

        $suctip[] = '修改成功，请重新登录';
        $suctip[] = '<a href="/login">点击这里重新登录</a>';



        return ( app('main')->jssuccess('修改成功', $suctip));
    }

}
