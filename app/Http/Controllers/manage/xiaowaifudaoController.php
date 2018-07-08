<?php

namespace App\Http\Controllers\manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use App\Repositories\outerhonor as outerhonorRepository;

class xiaowaifudaoController extends Controller {

    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct(outerhonorRepository $cr) {
        $this->oj = (object) [];

        $this->cr = $cr;

        $this->currentcontroller = '/manage/xiaowaifudao'; //控制器
        $this->viewfolder = 'manage.xiaowaifudao'; //视图路径
        $this->dbname = 'outerhonor';

        $this->oj->nav = 'xiaowaifudao';
        $this->oj->currentcontroller = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $o = $this->cr->index($request);

        if ($o->validator->fails()) {
            return redirect()->back()->withInput()->withErrors(($validator->errors()->toArray()));
        }

        $this->oj->search = $o->search;
        $this->oj->list = $o->list;

        return view($this->viewfolder . '.index', ['oj' => $this->oj]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return false;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $this->oj->data = $this->cr->show($id);
        return view($this->viewfolder . '.detail', ['oj' => $this->oj]);
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
        $rules = array(
            'title' => 'alpha_num|between:1,20',
            'readme' => 'alpha_num|between:1,255',
            'cls' => 'integer'
        );

        $attributes = array(
            "title" => '名称',
            'readme' => '简介',
            'cls' => '排序'
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        /**/

        $rs['title'] = $request->title;
        $rs['readme'] = $request->readme;
        $rs['cls'] = $request->cls;



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

    public function dopass($id) {
        /* 检测当前状态 */
        $data = $this->getdata($id);



        $time = time();

        /* 更新状态 */
        $rs['isok1'] = 1;
        $rs['isok1ucode'] = $_ENV['user']['mycode'];
        $rs['isok1time'] = $time;


        DB::beginTransaction();
        try {
            DB::table($this->dbname)->where('id', $id)->update($rs);

            /* 添加审核记录 */

            $rs = null;
            $rs['mytype'] = 'outerhonor';
            $rs['itemic'] = $id;
            $rs['myeventv'] = 'pass';
            $rs['aucode'] = $_ENV['user']['mycode'];
            $rs['auname'] = $_ENV['user']['realname'];
            $rs['ctime'] = $time;
            $rs['dic'] = $_ENV['user']['dic'];


            DB::table('audit')->insert($rs);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }



        return redirect()->back()->withInput()->with('sucinfo', '操作成功！');
    }

    public function formunpass($id) {
        return view($this->viewfolder . '.formunpass', ['oj' => $this->oj]);
    }

    public function dounpass($id, Request $request) {
        $rules = array(
            'myexplain' => 'required|string|between:1,255',
        );

        $attributes = array(
            'myexplain' => '原因'
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors(($validator->errors()->toArray()));
        }



        /* 检测当前状态 */
        $data = $this->getdata($id);

        if (2 == $data->isok1) {
            return redirect()->back()->withInput()->withErrors('已经是未通过状态了，请不要重复操作！');
        }

        $time = time();

        /* 更新状态 */
        $rs['isok1'] = 2;
        $rs['isok1ucode'] = $_ENV['user']['mycode'];
        $rs['isok1time'] = $time;
        $rs['notok1reason'] = $request->myexplain;



        DB::beginTransaction();
        try {
            DB::table($this->dbname)->where('id', $id)->update($rs);

            /* 添加审核记录 */

            $rs = null;
            $rs['mytype'] = 'outerhonor';
            $rs['itemic'] = $id;
            $rs['myeventv'] = 'unpass';
            $rs['myexplain'] = $request->myexplain;
            $rs['aucode'] = $_ENV['user']['mycode'];
            $rs['auname'] = $_ENV['user']['realname'];
            $rs['ctime'] = $time;
            $rs['dic'] = $_ENV['user']['dic'];


            DB::table('audit')->insert($rs);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }





        return redirect()->back()->withInput()->with('sucinfo', '操作成功！');
    }

    public function dopass2($id) {
        /* 检测当前状态 */
        $data = $this->getdata($id);

        /* 检查初审核状态，初审通过了才能复审核 */
        if (1 != $data->isok1) {
            return redirect()->back()->withErrors('初审还没有通过，不能进行复审！');
        }

        //if (0 != $data->isok2) {
        //    return redirect()->back()->withErrors('已经复审过了，请不要重复操作！');
        //}

        $time = time();

        /* 更新状态 */
        $rs['isok2'] = 1;
        $rs['isok2ucode'] = $_ENV['user']['mycode'];
        $rs['isok2time'] = $time;
        $rs['actualcredit'] = $data->mycredit;



        DB::beginTransaction();
        try {
            DB::table($this->dbname)->where('id', $id)->update($rs);

            /* 添加审核记录 */

            $rs = null;
            $rs['mytype'] = 'outerhonor';
            $rs['itemic'] = $id;
            $rs['myeventv'] = 'pass2';
            $rs['aucode'] = $_ENV['user']['mycode'];
            $rs['auname'] = $_ENV['user']['realname'];
            $rs['ctime'] = $time;
            $rs['dic'] = $_ENV['user']['dic'];


            DB::table('audit')->insert($rs);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }



        return redirect()->back()->withInput()->with('sucinfo', '操作成功！');
    }

    public function formunpass2($id) {
        return view($this->viewfolder . '.formunpass', ['oj' => $this->oj]);
    }

    public function dounpass2($id, Request $request) {
        $rules = array(
            'myexplain' => 'required|string|between:1,255',
        );

        $attributes = array(
            'myexplain' => '原因'
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors(($validator->errors()->toArray()));
        }



        /* 检测当前状态 */
        $data = $this->getdata($id);

        if (1 != $data->isok1) {
            return redirect()->back()->withErrors('初审还没有通过，不能进行复审！');
        }
        //if (2 == $data->isok2) {
        //    return redirect()->back()->withInput()->withErrors('已经是未通过状态了，请不要重复操作！');
        //}

        $time = time();

        /* 更新状态 */
        $rs['isok2'] = 2;
        $rs['isok2ucode'] = $_ENV['user']['mycode'];
        $rs['isok2time'] = $time;
        $rs['notok2reason'] = $request->myexplain;



        DB::beginTransaction();
        try {
            DB::table($this->dbname)->where('id', $id)->update($rs);

            /* 添加审核记录 */

            $rs = null;
            $rs['mytype'] = 'outerhonor';
            $rs['itemic'] = $id;
            $rs['myeventv'] = 'unpass2';
            $rs['myexplain'] = $request->myexplain;
            $rs['aucode'] = $_ENV['user']['mycode'];
            $rs['auname'] = $_ENV['user']['realname'];
            $rs['ctime'] = $time;
            $rs['dic'] = $_ENV['user']['dic'];


            DB::table('audit')->insert($rs);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }





        return redirect()->back()->withInput()->with('sucinfo', '操作成功！');
    }

    function getdata($id) {
        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->first();
        if (!$data) {
            return redirect('/showerr')->with('errmessage', '1022');
        } else {
            return $data;
        }
    }

}
