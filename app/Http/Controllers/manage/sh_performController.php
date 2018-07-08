<?php

/* 履职修业审核 */

namespace App\Http\Controllers\manage;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use App\Repositories\perform as performRepository;

class sh_performController extends Controller {

    private $viewfolder;
    private $dbname;

    function __construct(performRepository $cr) {
        $this->oj = (object) [];

        $this->cr = $cr;

        $this->currentcontroller = '/manage/sh_perform'; //控制器
        $this->viewfolder = 'manage.sh_perform'; //视图路径
        $this->dbname = 'perform';

        $this->oj->nav = 'sh_perform';
        $this->oj->currentcontroller = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $o = $this->cr->index($request, 'sh');

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
    public function create(Request $request) {
        $data = (object) [];

        $data->ucode = $request->ucode;
        $data->realname = $request->realname;

        $this->oj->activity_type = app('main')->getactivitytypelist();
        $this->oj->isedit = false;

        $this->oj->mynav = '添加';
        $this->oj->action = $this->currentcontroller;

        $this->oj->departlistindexic = app('main')->getdepartlistindexic();

        $this->oj->data = $data;

        return view($this->viewfolder . '.create', ['oj' => $this->oj]);
    }

    public function store(Request $request) {
        $o = $this->cr->store($request);

        if ($o->validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        $suctip = $o->suctip;

        return ( app('main')->jssuccess('保存成功', $suctip, $this->currentcontroller));
    }

    public function update(Request $request, $id) {
        $o = $this->cr->update($request, $id);

        if ($o->validator->fails()) {
            return ( app('main')->ajaxvali($o->validator->errors()->toArray()) );
        }

        $suctip = $o->suctip;
        $suctip[] = '<a href = "' . $this->currentcontroller . '">返回履职修业审核</a>';

        return ( app('main')->jssuccess('操作成功', $suctip));
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $this->oj->activity_type = app('main')->getactivitytypelist();
        $this->oj->isedit = true;

        $this->oj->mynav = '修改';
        $this->oj->action = $this->currentcontroller . '/' . $id;

        $this->oj->departlistindexic = app('main')->getdepartlistindexic();


        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->first();

        $this->oj->data = $data;

        return view($this->viewfolder . '.create', ['oj' => $this->oj]);
    }

    function dopass($id) {
        /* 检测当前状态 */
        $data = $this->cr->getperformbyid($id);

        if (1 == $data->isok) {
            return redirect()->back()->withInput()->withErrors('已经是审核通过状态了，请不要重复操作！');
        }

        $time = time();

        DB::beginTransaction();
        try {
            /* 更新状态 */
            $rs['isok'] = 1;
            $rs['isokucode'] = $_ENV['user']['mycode'];
            $rs['isoktime'] = $time;
            $rs['actualcredit'] = $data->mycredit;

            DB::table($this->dbname)->where('id', $id)->update($rs);

            /* 添加审核记录 */
            unset($rs);
            $rs['itemic'] = $id;
            $rs['mytype'] = 'perform';
            $rs['myeventv'] = 'pass';
            $rs['myexplain'] = '';
            $rs['aucode'] = $_ENV['user']['ic'];
            $rs['auname'] = '';
            $rs['dic'] = $_ENV['user']['dic'];
            $rs['ctime'] = $time;

            DB::table('audit')->insert($rs);

//            /* 更新学生的学分情况 */
//            unset($rs);
//            $rs['audited'] = $time;
//            $rs['isok'] = 1;
//            $rs['plancredit'] = $data->mycredit;
//            $rs['actualcredit'] = $data->mycredit;
//            DB::table('innerhonor_signup')
//                    ->where('mytype', 'innerhonor')
//                    ->where('itemic', $id)
//                    ->update($rs);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }




        return redirect()->back()->withInput()->with('sucinfo', '操作成功！');
    }

    function formunpass($id) {
        $perform = $this->cr->getperformbyid($id);

        return view($this->viewfolder . '.formunpass', ['oj' => $this->oj]);
    }

    function dounpass($id, Request $request) {
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
        $perform = $this->cr->getperformbyid($id);

        if (2 == $perform->isok) {
            return redirect()->back()->withInput()->withErrors('已经是未通过状态了，请不要重复操作！');
        }

        $time = time();


        DB::beginTransaction();
        try {
            /* 更新状态 */
            $rs['isok'] = 2;
            $rs['isokucode'] = $_ENV['user']['mycode'];
            $rs['isoktime'] = $time;
            $rs['notokreason'] = $request->myexplain;
            $rs['actualcredit'] = 0;

            DB::table($this->dbname)->where('id', $id)->update($rs);

            /* 添加审核记录 */

            $rs = null;

            $rs['itemic'] = $id;
            $rs['mytype'] = 'innerhonor';
            $rs['myeventv'] = 'unpass';
            $rs['myexplain'] = $request->myexplain;
            $rs['aucode'] = $_ENV['user']['ic'];
            $rs['auname'] = '';
            $rs['dic'] = $_ENV['user']['dic'];
            $rs['ctime'] = $time;

            DB::table('audit')->insert($rs);


//            /* 更新学生的学分情况 */
//            unset($rs);
//            $rs['audited'] = $time;
//            $rs['isok'] = 2;
//            $rs['plancredit'] = $innerhonor->mycredit;
//            $rs['actualcredit'] = $innerhonor->mycredit;
//            DB::table('innerhonor_signup')
//                    ->where('mytype', 'innerhonor')
//                    ->where('itemic', $id)
//                    ->update($rs);


            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }


        return redirect()->back()->withInput()->with('sucinfo', '操作成功！');
    }

}
