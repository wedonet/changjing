<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use Maatwebsite\Excel\Facades\Excel;

class teacherController extends Controller {

    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->oj = (object) [];

        $this->currentcontroller = '/adminconsole/teacher'; //控制器
        $this->viewfolder = 'admin.teacher'; //视图路径
        $this->dbname = 'teachers';

        $this->oj->nav = 'teacher';
        $this->oj->currentcontroller = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $search = (object) [];

        $rules = array(
            'keywords' => 'nullable|alpha_num|between:1,20',
            'department' => 'nullable|alpha_num|between:1,20',
        );

        $attributes = array(
            "keywords" => '教师姓名',
            'department' => '部门',
        );

        $message = array(
        );

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors(($validator->errors()->toArray()));
        }


        $search->keywords = $request->keywords;
        $search->department = $request->department;

        $list = DB::table($this->dbname)
                ->where('isdel', 0)
                ->where(function($query) use($search) {
                    if (isset($search->keywords)) {
                        $query->where('realname', 'like', '%' . $search->keywords . '%');
                    }
                    if (isset($search->department)) {
                        $query->where('dic', $search->department);
                    }
                })
                ->orderby('id', 'desc')
                ->paginate(18);



        $this->oj->list = $list;
        $this->oj->search = $search;
        $this->oj->departments = app('main')->getdepartmentlist();
        return view($this->viewfolder . '.index', ['oj' => $this->oj]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->oj->mynav = '添加教师';
        $this->oj->department = app('main')->getdepartmentlist();

        return view($this->viewfolder . '.create', ['oj' => $this->oj]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $base = $this->getbase($request);


        $rules = array(
            'upass' => 'required|string|confirmed',
            'mycode' => 'alpha_num|between:1,20|unique:' . $this->dbname . ',mycode'
        );

        $attributes = array(
            'upass' => '密码',
            'mycode' => '编号'
        );
        $message = array(
        );

        $rules = array_merge($base->rules, $rules);
        $attributes = array_merge($base->attributes, $attributes);
        $message = array_merge($base->message, $message);


        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );


        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        $mdb = $this->basemdb($request);
        if (isset($mdb->err)) {
            $validator->errors()->add('error2', $mdb->err);
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        $rs = $mdb->rs;
        $rs['upass'] = bcrypt($request->upass);
        $rs['created_at'] = $mdb->date;
        $rs['isdel'] = 0;


        if (DB::table($this->dbname)->insert($rs)) {
            $suctip[] = '<a href="' . $this->currentcontroller . '">返回教师管理</a>';
            return ( app('main')->jssuccess('保存成功', $suctip));
        } else {
            $validator->errors()->add('error', '保存失败');
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        return redirect($this->currentcontroller);
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

    public function getbase(&$request) {
        $base = (object) [];

        $base->rules = array(
            'realname' => 'alpha_num|between:1,20',
            'dic' => 'required|string|between:1,20'
        );

        $base->message = array();

        $base->attributes = array(
            "realname" => '姓名',
            'mycode' => '编号',
            'dic' => '部门'
        );

        return $base;
    }

    function basemdb(&$request) {
        $mdb = (object) [];

        if (1 == $request->mytype) {
            $mytype = 'counsellor';
        } else {
            $mytype = '';
        }

        /* 验证部门 */
        $data = DB::table('departments')
                ->where('ic', $request->dic)
                ->first();

        if (false == $data) {
            $mdb->err = '部门错误';
            return $mdb;
        } else {
            $dname = $data->title;
        }


        /* rs */
        /**/
        $time = time();
        $date = date("Y-m-d H:i:s", time());

        $rs['mycode'] = $request->mycode;
        $rs['dic'] = $request->dic;
        $rs['dname'] = $dname;
        $rs['realname'] = $request->realname;
        $rs['mytype'] = $mytype;

        $mdb->time = $time;
        $mdb->date = $date;
        $mdb->rs = $rs;

        return $mdb;
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

        $this->oj->data = $data;

        $this->oj->department = app('main')->getdepartmentlist();

        return view($this->viewfolder . '.edit', ['oj' => $this->oj]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $base = $this->getbase($request);

        $rules = array(
        );

        $attributes = array(
        );

        $message = array(
        );


        $rules = array_merge($base->rules, $rules);
        $attributes = array_merge($base->attributes, $attributes);
        $message = array_merge($base->message, $message);




        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );


        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        $mdb = $this->basemdb($request);
        if (isset($mdb->err)) {
            $validator->errors()->add('error2', $mdb->err);
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        $rs = $mdb->rs;

        DB::table($this->dbname)
                ->where('id', $id)
                ->update($rs);

        $suctip[] = '<a href="' . $this->currentcontroller . '">返回教师管理</a>';
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

    public function savepass(Request $request) {
        $dname = '';

        $id = app('main')->rid('id');

        $rules = array(
            'upass' => 'required|string',
            'upass2' => 'required|string'
        );

        $attributes = array(
            'upass' => '密码',
            'upass2' => '确认密码'
        );

        $message = array(
        );

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );


        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }


        /* 验证密码 */
        if ($request->upass !== $request->upass2) {
            $validator->errors()->add('error2', '验证密码错误！');
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }







        /**/
        $rs['upass'] = bcrypt($request->upass);


        DB::table($this->dbname)->where('id', $id)->update($rs);

        $suctip[] = '<a href="' . $this->currentcontroller . '">返回教师管理</a>';
        return ( app('main')->jssuccess('保存成功', $suctip));
    }

    function import() {
        return view($this->viewfolder . '.formimport', ['oj' => $this->oj]);
    }

    /* 导入教师 */

    public function doimport(Request $request) {
        ini_set('max_execution_time', '0');
        ini_set('memory_limit', '1024M');

        $rules = array(
            'attachmentsurl' => 'required|string|between:1,255',
        );

        $attributes = array(
        );

        $message = array(
        );

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors()->toArray());
        }

        $filepath = $request->attachmentsurl;

        if (!file_exists(public_path($filepath))) {
            return redirect()->back()->withInput()->withErrors('没找到导入文件，请重新上传！');
        }

        try {
            $results = Excel::load(public_path($filepath))->getSheet(0)->toArray();
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors('文件格式有问题，请去除单元格格式后重新上传');
        }

        //删除已上传的文件

        $a = array(
            'mycode' => array(
                'title' => '人员编号'
            ),
            'dname' => array(
                'title' => '单位名称'
            ),
            'realname' => array(
                'title' => '姓名'
            )
        );

        foreach ($a as $key => $v) {
            $a[$key]['num'] = app('main')->getmyorder($results[0], $a[$key]['title']);
        }

        /* 检测有没有需要的字段 */
        foreach ($a as $key => $v) {
            if ($v['num'] < 0) {
                return redirect()->back()->withInput()->withErrors('导入失败，没找到' . $v['title'] . '列!');
            }
        }

        //可以删除掉了
        unlink(public_path($filepath));
        /* 检测学生是不是存在 */
        //$notinlist = $this->getnotinstudent($a);
        //if('' != $notinlist ){
        //    return redirect()->back()->withInput()->withErrors('导入失败，没找到' . $notinlist );
        //}




        /* 准备导入 */
        $arrayrs = [];
        $arrayrsupdate = []; //执行更新
        $data = $results;
        for ($i = 1; $i < count($data); $i++) {
            $mycode = $data[$i][$a['mycode']['num']] . '';
            $realname = $data[$i][$a['realname']['num']] . '';
            $dname = $data[$i][$a['dname']['num']] . '';

            if ('学生处' == $dname) {
                $dname = '学生工作部';
            }

            /* 教师初始密码 */
            $upass = '123456';

            /* 检测空值 */
            if ('' == $mycode Or '' == $realname Or '' == $dname Or '' == $upass) {
                $str = '导入失败，存在没有值的情况，工号：' . $mycode . ', 姓名:' . $realname . ', 部门:' . $dname;
                return redirect()->back()->withInput()->withErrors($str);
            }

            /* 检测excel中的重复编码 */
            for ($j = 1; $j < count($results); $j++) {
                if ($mycode == $results[$j][$a['mycode']['num']] . '' And $i != $j) {
                    return redirect()->back()->withInput()->withErrors('导入失败，有重复工号， 工号：' . $mycode . ', 姓名:' . $realname . ', 部门:' . $dname);
                }
            }


            /* 提取这名教师的部门信息 */
            $department = DB::table('departments')
                    ->where('title', $dname)
                    ->first();

            if (!$department) {

                /* 插入这个部门 */
                $this->insertdepartment($mycode, $realname, $dname);

                $department = DB::table('departments')
                        ->where('title', $dname)
                        ->first();
                //return redirect()->back()->withInput()->withErrors('导入失败，没找到所在部门，工号：' . $mycode . ', 姓名:' . $realname . ', 部门:' . $dname);
            }

            /* 检查这名教师是不是在库里了 */
            $theteacher = DB::table('teachers')->where('mycode', $mycode)->first();
            //有就检查部门是不是一样，不一样再更新，一样就跳出循环
            if ($theteacher) {
                if ($theteacher->dname != $dname) {
                    $rsupdate = null;
                    $rsupdate['dic'] = $department->ic;
                    $rsupdate['dname'] = $department->title;

                    DB::table('teachers')
                            ->where('mycode', $mycode)
                            ->update($rsupdate);
                }
                //这里有可能跳出循环
                continue;
            }



            $rs['mycode'] = $mycode;
            $rs['mytype'] = '';
            $rs['dic'] = $department->ic;
            $rs['dname'] = $department->title;
            $rs['realname'] = $realname;
            /**/
            $rs['upass'] = bcrypt($upass);
            $rs['isdel'] = 0;
            $rs['created_at'] = date("Y-m-d H:i:s", time());

            $arrayrs[] = $rs;
        }

        if (count($arrayrs) > 0) {
            DB::transaction(function () use ($arrayrs) {
                foreach ($arrayrs as $v) {
                    DB::table('teachers')
                            ->insert($v);
                }
            });
        }

        return redirect()->back()->with('sucinfo', '导入成功！');
    }

    /* 添加新的部门 */

    function insertdepartment($mycode, $realname, $dname) {
        /**/
        $date = date("Y-m-d H:i:s", time());
        //$ic = app('main')->getfirstic();

        $rs['title'] = $dname;
        $rs['ic'] = app('main')->getfirstic();

        /* 职能或业务, 有学院是业务，其它是职能 */
        if (strpos($dname, '学院') > -1) {
            $rs['mytype'] = 'yewu';
            $rs['isxueyuan'] = 1;
        } else {
            $rs['mytype'] = 'zhineng';
            $rs['isxueyuan'] = 0;
        }

        /* 研究生院没有学字，但也是学院，所以单独处理 */
        if ('研究生院' == $dname) {
            $rs['mytype'] = 'yewu';
            $rs['isxueyuan'] = 1;
        }


        $rs['icfq'] = '';
        $rs['userfq'] = '';
        $rs['passfq'] = '';

        $rs['icsh'] = '';
        $rs['usersh'] = '';
        $rs['passsh'] = '';



        $rs['cls'] = 100;


        $rs['created_at'] = $date;
        $rs['isdel'] = 0;

        DB::table('departments')
                ->insert($rs);
    }

    /* 导入辅导员 */

    function doimportfudao(Request $request) {
        ini_set('max_execution_time', '0');
        ini_set('memory_limit', '1024M');

        $rules = array(
            'attachmentsurl2' => 'required|string|between:1,255',
        );

        $attributes = array(
        );

        $message = array(
        );

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors()->toArray());
        }

        $filepath = $request->attachmentsurl2;

        if (!file_exists(public_path($filepath))) {
            return redirect()->back()->withInput()->withErrors('没找到导入文件，请重新上传！');
        }

        try {
            $results = Excel::load(public_path($filepath))->getSheet(0)->toArray();
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors('文件格式有问题，请去除单元格格式后重新上传');
        }

        //删除已上传的文件

        $a = array(
            'mycode' => array(
                'title' => '职工号'
            ),
            'dname' => array(
                'title' => '工作单位'
            ),
            'realname' => array(
                'title' => '姓名'
            )
        );

        foreach ($a as $key => $v) {
            $a[$key]['num'] = app('main')->getmyorder($results[0], $a[$key]['title']);
        }

        /* 检测有没有需要的字段 */
        foreach ($a as $key => $v) {
            if ($v['num'] < 0) {
                return redirect()->back()->withInput()->withErrors('导入失败，没找到' . $v['title'] . '列!');
            }
        }

        //可以删除掉了
        unlink(public_path($filepath));
        /* 检测学生是不是存在 */
        //$notinlist = $this->getnotinstudent($a);
        //if('' != $notinlist ){
        //    return redirect()->back()->withInput()->withErrors('导入失败，没找到' . $notinlist );
        //}




        /* 准备导入 */
        $arrayrs = [];
        $data = $results;
        for ($i = 1; $i < count($data); $i++) {
            $mycode = $data[$i][$a['mycode']['num']] . '';
            $realname = $data[$i][$a['realname']['num']] . '';
            $dname = $data[$i][$a['dname']['num']] . '';
            $upass = '123456';

            if ('学生处' == $dname) {
                $dname = '学生工作部';
            }

            /* 检测空值 */
            if ('' == $mycode Or '' == $realname Or '' == $dname Or '' == $upass) {
                $str = '导入失败，存在没有值的情况，工号：' . $mycode . ', 姓名:' . $realname . ', 部门:' . $dname;
                return redirect()->back()->withInput()->withErrors($str);
            }

            /* 检测重复编 */
            for ($j = 1; $j < count($results); $j++) {
                if ($mycode == $results[$j][$a['mycode']['num']] . '' And $i != $j) {
                    return redirect()->back()->withInput()->withErrors('导入失败，有重复工号， 工号：' . $mycode . ', 姓名:' . $realname . ', 部门:' . $dname);
                }
            }



            /* 提取这名教师的部门信息 */
            $department = DB::table('departments')
                    ->where('title', $dname)
                    ->first();

            if (!$department) {

                /* 插入这个部门 */
                $this->insertdepartment($mycode, $realname, $dname);

                $department = DB::table('departments')
                        ->where('title', $dname)
                        ->first();
                //return redirect()->back()->withInput()->withErrors('导入失败，没找到所在部门，工号：' . $mycode . ', 姓名:' . $realname . ', 部门:' . $dname);
            }


            /* 检查这名教师是不是在库里了，不在就添加进去 */
            if (0 == DB::table('teachers')->where('mycode', $mycode)->count()) {
                $this->insertteacher($mycode, $realname, $department, 'counsellor');
            } else {
                $this->updateteacher($mycode, $realname, $department, 'counsellor');
            }

            /* 准备更新数据 */
            //$rs['mytype'] = 'counsellor';
            //$rs['updated_at'] = date("Y-m-d H:i:s", time());

            $arrayrs[] = $mycode;
        }

        if (count($arrayrs) > 0) {
            $rs = null;
            $rs['mytype'] = 'counsellor';
            //$rs['dic'] = $department->ic;
            //$rs['dname'] = $department->title;

            DB::table('teachers')
                    ->whereIn('mycode', $arrayrs)
                    ->update($rs);
        }

        return redirect()->back()->with('sucinfo', '导入成功！');
    }

    function insertteacher($mycode, $realname, $department, $mytype = '') {
        $upass = '123456';

        $rs['mycode'] = $mycode;
        $rs['mytype'] = $mytype;
        $rs['dic'] = $department->ic;
        $rs['dname'] = $department->title;
        $rs['realname'] = $realname;
        /**/
        $rs['upass'] = bcrypt($upass);
        $rs['isdel'] = 0;
        $rs['created_at'] = date("Y-m-d H:i:s", time());

        DB::table('teachers')
                ->insert($rs);
    }

    function updateteacher($mycode, $realname, $department, $mytype = '') {
        $rs['mytype'] = $mytype;
        $rs['dic'] = $department->ic;
        $rs['dname'] = $department->title;
        $rs['realname'] = $realname;
        /**/


        $rs['updated_at'] = date("Y-m-d H:i:s", time());

        DB::table('teachers')
                ->where('mycode', $mycode)
                ->update($rs);
    }

}
