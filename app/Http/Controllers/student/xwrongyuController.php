<?php

namespace App\Http\Controllers\student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use App\Repositories\outerhonor as outerhonorRepository;

class xwrongyuController extends Controller {

    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct(outerhonorRepository $cr) {
        $this->oj = (object) [];
        $this->cr = $cr;

        $this->currentcontroller = '/student/xwrongyu'; //控制器
        $this->viewfolder = 'student.xwrongyu.'; //视图路径
        $this->dbname = 'outerhonor';

        $this->oj->nav = 'xiaowairongyu';
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
        $this->oj->activity_type = app('main')->getactivitytypelist();
        $this->oj->isedit = false;

        $this->oj->mynav = '申请校外荣誉';
        $this->oj->action = $this->currentcontroller;

        $this->oj->departlistindexic = app('main')->getdepartlistindexic();
        return view($this->viewfolder . 'create', ['oj' => $this->oj]);
    }

    public function store(Request $request) {
        $o = $this->cr->store($request);

        if ($o->validator->fails()) {
            return ( app('main')->ajaxvali($o->validator->errors()->toArray()) );
        }
        if(isset($o->err)){
            return ( app('main')->ajaxvali($o->err));
        }

        $suctip = $o->suctip;

        $href = $this->currentcontroller;
        $suctip[] = '<a href = "' . $href . '">点击这里返回校外荣誉管理</a>';
        return ( app('main')->jssuccess('保存成功,2秒后自动返回', $suctip, $href));
    }

    public function update(Request $request, $id) {
        $o = $this->cr->update($request, $id);

        if ($o->validator->fails()) {
            return ( app('main')->ajaxvali($o->validator->errors()->toArray()) );
        }

        $suctip = $o->suctip;
        $suctip[] = '<a href = "' . $this->currentcontroller . '">返回</a>';

        return ( app('main')->jssuccess('操作成功', $suctip));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->first();
        if (!$data) {
            return redirect('/showerr')->with('errmessage', '1022');
        }

        /* 提取牵头部门 */
        $data->tiantouname = app('main')->getdnamebytype($data->type_twoic);

        $this->oj->data = $data;

        return view($this->viewfolder . 'detail', ['oj' => $this->oj]);
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

        $this->oj->mynav = '编辑校外荣誉';
        $this->oj->action = $this->currentcontroller . '/' . $id;

        $this->oj->departlistindexic = app('main')->getdepartlistindexic();

        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->first();
        if (!$data) {
            return redirect('/showerr')->with('errmessage', '1022');
        }
        $this->oj->data = $data;


        return view($this->viewfolder . 'create', ['oj' => $this->oj]);
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
                    ->where('isok1', 0)
                    ->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

        return redirect()->back()->withInput()->withSuccess('删除成功！');
    }

}
