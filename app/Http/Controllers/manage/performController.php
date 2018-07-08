<?php

namespace App\Http\Controllers\manage;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use App\Repositories\perform as performRepository;

class performController extends Controller {

    private $viewfolder;
    private $dbname;

    function __construct(performRepository $cr) {
        $this->oj = (object) [];

        $this->cr = $cr;

        $this->currentcontroller = '/manage/perform'; //控制器
        $this->viewfolder = 'manage.perform'; //视图路径
        $this->dbname = 'perform';

        $this->oj->nav = 'perform';
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
            return ( app('main')->ajaxvali($o->validator->errors()->toArray()) );
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
        $suctip[] = '<a href = "' . $this->currentcontroller . '">返回履职修业管理</a>';

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $rs['isdel'] = 1;

        DB::beginTransaction();

        try {
            $result = DB::table($this->dbname)
                    ->where('id', $id)
                    ->update($rs);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

        return redirect()->back()->withInput()->withSuccess('删除成功！');
    }

    public function select(Request $request) {
        $search = (object) [];

        $rules = array(
            'ucode' => 'nullable|string|between:3,20',
        );

        $attributes = array(
            "ucode" => '学号',
        );

        $message = array(
        );

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors(($validator->errors()->toArray()));
        }

        /* 搜索学生 */
        $search->roleic = $_ENV['user']['role'];
        $search->dic = $_ENV['user']['dic'];
        $search->ucode = $request->ucode;
        $search->user = $_ENV['user'];

        if ('' != $request->ucode) {

            $list = DB::table('students')
                    ->where('mycode', 'like', '%' . $request->ucode . '%')
                    
                    
                    ->where(function($query) use($search) {
                        /*牵头部门和团委可以管所有的，其它只能看自已院系的*/              
                        if ( !$search->user['istuanwei'] And !$search->user['isqiantou'] ) {
                            $query->where('dic', $search->dic);
                        }
                    })
                    ->paginate(20);

            if ('' != $request->ucode And $list->isempty()) {
                return redirect()->back()->withInput()->withErrors('没找到对应学生，请重新输入！');
            }
            $page['ucode'] = $request->ucode;
            $list->appends($page)->links();
            $this->oj->list = $list;
        }


        $this->oj->search = $search;
        return view($this->viewfolder . '.select', ['oj' => $this->oj]);
    }

}
