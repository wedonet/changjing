<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class huodongleixing_2Controller extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;
    private $pic;

    function __construct() {
        $this->currentcontroller = '/adminconsole/huodongleixing_2'; //控制器
        $this->viewfolder = 'admin.huodongleixing_2'; //视图路径
        $this->dbname = 'activity_type';

        $this->j['nav'] = 'huodongleixing';
        $this->j['currentcontroller'] = $this->currentcontroller;



        /* 提取父类型 */
        $this->pic = app('main')->rstr('pic');
        $data = DB::table($this->dbname)
                ->where('ic', $this->pic)
                ->first();

        $this->j['ptype'] = $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $list = DB::table($this->dbname)
                ->where('isdel', 0)
                ->where('pic', $this->pic)
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
        $this->j['deparmentlist'] = app('main')->getdepartmentlist();
        $this->j['isedit'] = false;

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

        $rules = array(
        );
        $attributes = array(
        );

        $rules = array_merge($base->rules, $rules);
        $attributes = array_merge($base->attributes, $attributes);

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }



        /**/
        $mdb = $this->basemdb($request);
        $rs = $mdb->rs;

        $rs['ic'] = app('main')->getfirstic();
        $rs['mydepth'] = 1;
        $rs['created_at'] = $mdb->date;


        DB::table($this->dbname)
                ->insert($rs);

        $suctip[] = '<a href="' . $this->currentcontroller . '?pic=' . $this->pic . '">返回二级活动类型管理</a>';
        return ( app('main')->jssuccess('操作成功', $suctip));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        if ($id == 1) {
            $data[] = '思想道德';
            $data[] = '责任担当';
        }
        if ($id == 2) {
            $data[] = '学习能力';
            $data[] = '职业能力';
        }
        if ($id == 3) {
            $data[] = '传承中国';
            $data[] = '中国情怀';
        }
        if ($id == 4) {
            $data[] = '国际视野';
            $data[] = '天外气质';
        }
        if ($id == 5) {
            $data[] = '创新创业';
            $data[] = '科学素养';
        }
        if ($id == 6) {
            $data[] = '艺术修养';
            $data[] = '身心素质';
        }
        $this->j = $data;
        return view($this->viewfolder . '.index', ['j' => $this->j]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $this->j['isedit'] = true;
        $this->j['deparmentlist'] = app('main')->getdepartmentlist();

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
        $base = $this->getbase($request);

        $rules = array(
        );
        $attributes = array(
        );

        $rules = array_merge($base->rules, $rules);
        $attributes = array_merge($base->attributes, $attributes);

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        /**/
        $mdb = $this->basemdb($request);
        $rs = $mdb->rs;

        DB::table($this->dbname)->where('id', $id)->update($rs);

        /* 同步活动中的牵头部门 */
        $this->updateactivitydepartment($id);


        $suctip[] = '<a href="' . $this->currentcontroller . '?pic=' . $this->pic . '">返回二级活动类型管理</a>';
        return ( app('main')->jssuccess('操作成功', $suctip));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        DB::table($this->dbname)
                ->where('id', $id)
                ->update(['isdel' => 1]);



        return redirect()->back()->withInput()->withSuccess('删除成功！');
    }

    public function getbase(&$request) {
        $base = (object) [];

        $base->rules = array(
            'title' => 'required|string|between:1,20',
            'qiantouic' => 'required|between:1,20',
            'readme' => 'string|between:1,255',
            'target' => 'required|integer',
            'ismust' => 'required|integer',
            'cls' => 'required|integer'
        );

        $base->attributes = array(
            'title' => '名称',
            'qiantouic' => '牵头部门',
            'readme' => '说明',
            'target' => '目标学分',
            'ismust' => '是否必修',
            'cls' => '排序'
        );

        return $base;
    }

    function basemdb(&$request) {
        $mdb = (object) [];

        /* rs */
        /**/
        $time = time();
        $date = date("Y-m-d H:i:s", $time);


        /* 提取牵头部门名称 */
        $qiantou = app('main')->getdepartmentdatabyic($request->qiantouic);


        $rs['title'] = $request->title;
        $rs['readme'] = $request->readme;
        $rs['mydepth'] = 1;
        $rs['pic'] = $this->pic;
        $rs['target'] = $request->target;
        $rs['ismust'] = $request->ismust;
        $rs['cls'] = $request->cls;

        $rs['qiantouic'] = $request->qiantouic;
        $rs['qiantouname'] = $qiantou->title;



        $date = date("Y-m-d H:i:s", time());

        $mdb->date = $date;
        $mdb->rs = $rs;

        return $mdb;
    }

    private function updateactivitydepartment($activityid) {
        $data = DB::table($this->dbname)
                ->where('id', $activityid)
                ->first();

        if (!$data) {
            return false;
        }

        $rs['suname'] = $data->title;

        DB::table('activity')
                ->where('ic', $data->ic)
                ->update($rs);
    }

}
