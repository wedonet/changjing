<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class banjiController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->currentcontroller = '/adminconsole/banji'; //控制器
        $this->viewfolder = 'admin.banji'; //视图路径
        $this->dbname = 'classes';

        $this->j['nav'] = 'banji';
        $this->j['currentcontroller'] = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $rules = array(
            'title' => 'nullable|alpha_num|between:1,20',
            'mycode' => 'nullable|alpha_num|between:1,20'
        );

        $attributes = array(
            "title" => '班级名称',
            'mycode' => '班级号'
        );

        $message = array(
        );

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors(($validator->errors()->toArray()));
        }

        $search['title'] = $request->title.'';
        $search['mycode'] = $request->mycode.'';

        $this->j['search'] = $search;



        $list = DB::table($this->dbname)
                ->where('isdel', 0)
                ->where(function($query) use($search) {
                    if ('' != $search['title']) {
                        $query->where('title', 'like', '%' . $search['title'] . '%');
                    }
                    if ('' != $search['mycode']) {
                        $query->where('mycode', 'like', '%' . $search['mycode'] . '%');
                    }
                })
                ->orderby('cls', 'asc')
                ->orderby('id', 'asc')
                ->paginate(20);

        $this->j['list'] = $list;

        return view($this->viewfolder . '.index', ['j' => $this->j]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        /* 获取部门列表传给后台 */
        $this->j['departmentlist'] = app('main')->getdepartmentlist();

        return view($this->viewfolder . '.create', ['j' => $this->j]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $base = $this->getbase($request);

        $myrules = array(
            'mycode' => 'required|unique:students,mycode|string|between:1,20'
        );
        $myattributes = array(
            'mycode' => '学号'
        );

        $rules = array_merge($base->rules, $rules);
        $attributes = array_merge($base->attributes, $attributes);



        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        /* 检测班级负责人是否存在 */

        /**/
        $rs = $base->rs;
        $rs['mycode'] = $request->mycode;
        $rs['created_at'] = $base->date;


        if (DB::table($this->dbname)->insert($rs)) {
            $suctip[] = '<a href="' . $this->currentcontroller . '">返回班级管理</a>';
            return ( app('main')->jssuccess('保存成功', $suctip));
        } else {
            $validator->errors()->add('error', '保存失败');
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }
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

        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->first();

        $this->j['data'] = $data;

        $this->j['departmentlist'] = app('main')->getdepartmentlist();

        return view($this->viewfolder . '.edit', ['j' => $this->j]);
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

        $myrules = array();
        $myattributes = array();
        
        $rules = array_merge($base->rules, $rules);
        $attributes = array_merge($base->attributes, $attributes);


        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }


        /* 检测班级负责人是否存在 */

        /**/
        $rs = $base->rs; 


        DB::table($this->dbname)->where('id', $id)->update($rs);

        $suctip[] = '<a href="' . $this->currentcontroller . '">返回班级管理</a>';
        return ( app('main')->jssuccess('保存成功', $suctip));
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

    
        
        /*rs*/
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

}
