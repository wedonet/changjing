<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use App\Models\Departments as Departments;
use App\Models\Teachers as Teachers;

class departmentController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->currentcontroller = '/adminconsole/department'; //控制器
        $this->viewfolder = 'admin.department'; //视图路径
        $this->dbname = 'departments';

        $this->j['nav'] = 'department';
        $this->j['currentcontroller'] = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $search = (object) [];

        $rules = array(
            'title' => 'nullable|string|between:1,20',
            'mytype' => 'nullable|string|between:1,10'
        );

        $attributes = array(
            "title" => '名称'
        );

        $message = array(
        );

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors(($validator->errors()->toArray()));
        }

        $search->title = $request->title;
        $search->mytype = $request->mytype;

        $search->currentstatus = $request->currentstatus;

        $this->j['search'] = $search;
        $p = $search;

        $list = DB::table($this->dbname)
                ->where('isdel', 0)
                ->where(function($query) use($p) {
                    if ('' != $p->title) {
                        $query->where('title', 'like', '%' . $p->title . '%');
                    }
                    if ('' != $p->mytype) {
                        $query->where('mytype', $p->mytype);
                    }
                })
                ->orderby('cls', 'asc')
                ->orderby('id', 'asc')
                ->get();

        $this->j['list'] = $list;


        return view($this->viewfolder . '.index', ['j' => $this->j]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->j['isedit'] = false;

        $this->j['mynav'] = '添加部门';
        $this->j['action'] = $this->currentcontroller;
        return view($this->viewfolder . '.create', ['j' => $this->j]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $rules = array(
            'title' => 'required|string|between:1,20|unique:' . $this->dbname . ',title',
            'ic' => 'required|string|between:1,20|unique:' . $this->dbname . ',ic',
            'mytype' => 'required|in:zhineng,yewu',
            'userfq' => 'required|string|between:1,20|unique:' . $this->dbname . ',userfq',
            'passfq' => 'required|string|between:1,20',
            'usersh' => 'required|string|between:1,20|unique:' . $this->dbname . ',usersh',
            'passsh' => 'required|string|between:1,20',
            'cls' => 'required|integer',
            'isxueyuan' => 'required|in:0,1'
        );

        $attributes = array(
            "title" => '名称',
            'ic' => '部门编号',
            'mytype' => '类型',
            'userfq' => '发起人用户名',
            'passfq' => '发起人密码',
            'usersh' => '审核人用户名',
            'passsh' => '审核人密码',
            'cls' => '排序',
            'isxueyuan' => '是否学院'
        );

        $message = array(
            'mytype.in' => '请选择部门类型',
            'isxueyuan.in' => '请选择是否学院！'
        );

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        if ('yewu' == $request->mytype) {
            $request->userfq = '';
            $request->usersh = '';
        }


        /**/
        $date = date("Y-m-d H:i:s", time());
        //$ic = app('main')->getfirstic();

        $rs['title'] = $request->title;
        $rs['ic'] = $request->ic;

        $rs['mytype'] = $request->mytype;

        $rs['icfq'] = app('main')->getfirstic();
        $rs['userfq'] = $request->userfq;
        $rs['passfq'] = bcrypt($request->passfq);

        $rs['icsh'] = app('main')->getfirstic();
        $rs['usersh'] = $request->usersh;
        $rs['passsh'] = bcrypt($request->passsh);



        $rs['cls'] = cls($request->cls);
        $rs['isxueyuan'] = $request->isxueyuan;


        $rs['created_at'] = $date;
        $rs['isdel'] = 0;


        $teacher_fq = [];
        $teacher_fq['mycode'] = $rs['userfq'];
        $teacher_fq['mytype'] = 'fq';
        $teacher_fq['dic'] = $rs['ic'];
        $teacher_fq['dname'] = $rs['title'];
        $teacher_fq['realname'] = '发起账号';
        $teacher_fq['upass'] = $rs['passfq'];
        $teacher_fq['isdel'] = 0;
        $teacher_fq['created_at'] = date('Y-m-d H:i:s');

        $teacher_sh = [];
        $teacher_sh['mycode'] = $rs['usersh'];
        $teacher_sh['mytype'] = 'sh';
        $teacher_sh['dic'] = $rs['ic'];
        $teacher_sh['dname'] = $rs['title'];
        $teacher_sh['realname'] = '审核账号';
        $teacher_sh['upass'] = $rs['passsh'];
        $teacher_sh['isdel'] = 0;
        $teacher_sh['created_at'] = date('Y-m-d H:i:s');


        DB::beginTransaction();
        try {
            DB::table($this->dbname)
                    ->insert($rs);

            /* 添加进老师表 */
            DB::table('teachers')
                    ->insert($teacher_fq);

            DB::table('teachers')
                    ->insert($teacher_sh);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
        $suctip[] = '<a href="' . $this->currentcontroller . '">返回部门管理</a>';
        return ( app('main')->jssuccess('添加成功', $suctip));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {


        return view($this->viewfolder . '.edit', ['j' => $this->j]);
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $this->j['isedit'] = true;

        $this->j['mynav'] = '编辑部门';
        $this->j['action'] = $this->currentcontroller . '/' . $id;



        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->first();

        $this->j['data'] = $data;

        return view($this->viewfolder . '.create', ['j' => $this->j]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {


        $rules = array(
            'title' => 'required|string|between:1,20|unique:' . $this->dbname . ',title,' . $id,
            'readme' => 'alpha_num|between:1,255',
            'cls' => 'required|integer',
            'isxueyuan' => 'in:0,1'
        );

        $attributes = array(
            'readme' => '说明',
            'cls' => '排序'
        );

        $message = array(
            'isxueyuan.in' => '请选择是否学院！'
        );

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        /**/

        $rs['title'] = $request->title;
        $rs['readme'] = $request->readme;
        $rs['cls'] = $request->cls;
        $rs['isxueyuan'] = $request->isxueyuan;


        DB::table($this->dbname)->where('id', $id)->update($rs);

        $suctip[] = '<a href="' . $this->currentcontroller . '">返回部门管理</a>';
        return ( app('main')->jssuccess('操作成功', $suctip));
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

    /* 修改部门负责人 */

    public function formmaster($id) {
        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->first();

        $this->j['data'] = $data;

        $this->j['title'] = 'aa';

        return view($this->viewfolder . '.master', ['j' => $this->j]);
    }

    public function formfq($id) {
        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->first();

        $this->j['data'] = $data;


        return view($this->viewfolder . '.form_fq', ['j' => $this->j]);
    }

    public function savefq(Request $request, $id) {
        $rules = array(
            'userfq' => 'required|string|between:1,20|unique:' . $this->dbname . ',userfq,' . $id,
            'passfq' => 'required|string|between:1,20'
        );

        $attributes = array(
            'userfq' => '发起人用户名',
            'passfq' => '发起人密码'
        );

        $message = array(
        );

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            $arr['err'] = $validator->errors()->toArray();
            echo json_encode($arr, 320);
            return;
        }


        /**/
        $rs['userfq'] = $request->userfq;
        $rs['passfq'] = bcrypt($request->passfq);


        DB::table('departments')->where('id', $id)->update($rs);

        /* 更新教师表 */
        $teacher = [];
        $teacher['upass'] = $rs['passfq'];
        DB::table('teachers')
                ->where('mycode', $rs['userfq'])
                ->update($teacher);

        $json['suc'] = 'y';
        $json['reload'] = 'y';
        echo json_encode($json, 320);
        return;
    }

    public function formsh($id) {
        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->first();

        $this->j['data'] = $data;

        return view($this->viewfolder . '.form_sh', ['j' => $this->j]);
    }

    public function savesh(Request $request, $id) {
        $json['suc'] = 'n';

        $rules = array(
            'usersh' => 'required|string|between:1,20|unique:' . $this->dbname . ',usersh,' . $id,
            'passsh' => 'required|string|between:1,20',
        );

        $attributes = array(
            'usersh' => '审核人用户名',
            'passsh' => '审核人密码',
        );

        $message = array(
        );

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            $arr['err'] = $validator->errors()->toArray();
            echo json_encode($arr, 320);
            return;
        }


        /**/

        $rs['usersh'] = $request->usersh;
        $rs['passsh'] = bcrypt($request->passsh);


        DB::table('departments')->where('id', $id)->update($rs);


        /* 更新教师表 */
        $teacher = [];
        $teacher['upass'] = $rs['passsh'];
        DB::table('teachers')
                ->where('mycode', $rs['usersh'])
                ->update($teacher);


        $json['suc'] = 'y';
        $json['reload'] = 'y';
        echo json_encode($json, 320);
        return;
    }

    /* 保存部门负责人 */

    public function savemaster(Request $request) {
        $rules = array(
            'dic' => 'string|between:1,20',
            'mastercode' => 'required|string',
            'mastername' => 'required|string'
        );

        $attributes = array(
            "dic" => '部门',
            'mastercode' => '编号',
            'mastercode' => '姓名',
        );

        $message = array(
        );

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            echo 'n';
            return;
        }

        /* 检测负责人是否这个部门的 */
        $count = DB::table('teachers')
                ->where('mycode', $request->mastercode)
                ->where('realname', $request->mastername)
                ->where('dic', $request->dic)
                ->count();

        if (0 == $count) {
            echo '没找到这名教师或教师不在这个部门';
            return;
        }
        /**/

        $rs['masteric'] = $request->mastercode;
        $rs['mastername'] = $request->mastername;


        DB::table('departments')->where('ic', $request->dic)->update($rs);

        echo 'y';
    }

    /* 取得一些基础规则 */

    public function getbase(&$request) {
        $base = (object) [];

        $base->rules = array(
            'title' => 'required|alpha_num|between:1,20',
            'mycode' => 'required|string|between:1,20',
            'dic' => 'required|string|between:1,20',
            'masteric' => 'string|between:1,20',
            'mastername' => 'string|between:1,20',
            'readme' => 'string|between:1,255',
            'cls' => 'integer'
        );

        $base->attributes = array(
            'title' => '名称',
            'mycode' => '班级号',
            'dic' => '所属学院',
            'masteric' => '负责教师工号',
            'mastername' => '负责教师姓名',
            'readme' => '说明',
            'cls' => 'integer'
        );


        /* 获取部门名称 */
        $dic = $request->dic;
        $department = app('main')->getdepartmentdatabyic($dic);

        $dname = $department->title;



        /* rs */
        $rs['title'] = $request->title;
        $rs['dic'] = $request->dic;
        $rs['dname'] = $dname;
        $rs['masteric'] = $request->masteric;
        $rs['mastername'] = $request->mastername;
        $rs['readme'] = $request->readme;
        $rs['cls'] = cls($request->cls);

        $date = date("Y-m-d H:i:s", time());

        $base->date = $date;
        $base->rs = $rs;

        return $base;
    }

    /* 给没有发起账户的部门添加默认发起账户 */

    function createfq() {
        $departments = DB::table('departments')
                ->whereNull('icfq')
                ->orWhere('icfq', '')
                ->get();

        foreach ($departments as $v) {
            $ic = $v->ic;
            $data = Departments::where('ic', $ic)
                    ->first();

            $data->icfq = app('main')->getfirstic();
            $data->userfq = $this->getCharter($v->title) . '_fq';
            $data->namefq = '';
            $data->passfq = bcrypt('123456');
            $data->save();

            /* 添加进老师表 */         
            $rs['mycode'] = $data->userfq;
            $rs['mytype'] = 'fq';
            $rs['dic'] = $v->ic;
            $rs['dname'] = $v->title;
            $rs['realname'] = '发起账号';
            $rs['upass'] = $data->passfq;
            $rs['isdel'] = 0;
            $rs['created_at'] = date('Y-m-d H:i:s');
            
            DB::table('teachers')->insert($rs);
            
            
        }

        return redirect()->back()->withInput()->with('sucinfo', '添加成功！');
    }

    function getCharter($string) {
        $a = '';
        $code = 'UTF-8';

        if ($code == 'UTF-8') {
            $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
        } else {
            $pa = "/[\x01-\x7f]|[\xa1-\xff][\xa1-\xff]/";
        }
        preg_match_all($pa, $string, $t_string);
        $math = "";
        foreach ($t_string[0] as $k => $s) {
            $a .= $this->getFirstCharter($s);
        }

        return strtolower($a);
    }

    //php获取中文字符拼音首字母 
    function getFirstCharter($str) {
        if (empty($str)) {
            return '';
        }
        $fchar = ord($str{0});
        if ($fchar >= ord('A') && $fchar <= ord('z'))
            return strtoupper($str{0});
        $s1 = iconv('UTF-8', 'gb2312', $str);
        $s2 = iconv('gb2312', 'UTF-8', $s1);
        $s = $s2 == $str ? $s1 : $str;
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if ($asc >= -20319 && $asc <= -20284)
            return 'A';
        if ($asc >= -20283 && $asc <= -19776)
            return 'B';
        if ($asc >= -19775 && $asc <= -19219)
            return 'C';
        if ($asc >= -19218 && $asc <= -18711)
            return 'D';
        if ($asc >= -18710 && $asc <= -18527)
            return 'E';
        if ($asc >= -18526 && $asc <= -18240)
            return 'F';
        if ($asc >= -18239 && $asc <= -17923)
            return 'G';
        if ($asc >= -17922 && $asc <= -17418)
            return 'H';
        if ($asc >= -17417 && $asc <= -16475)
            return 'J';
        if ($asc >= -16474 && $asc <= -16213)
            return 'K';
        if ($asc >= -16212 && $asc <= -15641)
            return 'L';
        if ($asc >= -15640 && $asc <= -15166)
            return 'M';
        if ($asc >= -15165 && $asc <= -14923)
            return 'N';
        if ($asc >= -14922 && $asc <= -14915)
            return 'O';
        if ($asc >= -14914 && $asc <= -14631)
            return 'P';
        if ($asc >= -14630 && $asc <= -14150)
            return 'Q';
        if ($asc >= -14149 && $asc <= -14091)
            return 'R';
        if ($asc >= -14090 && $asc <= -13319)
            return 'S';
        if ($asc >= -13318 && $asc <= -12839)
            return 'T';
        if ($asc >= -12838 && $asc <= -12557)
            return 'W';
        if ($asc >= -12556 && $asc <= -11848)
            return 'X';
        if ($asc >= -11847 && $asc <= -11056)
            return 'Y';
        if ($asc >= -11055 && $asc <= -10247)
            return 'Z';
        return null;
    }

}
