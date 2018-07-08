<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class huodongleixingController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->currentcontroller = '/adminconsole/huodongleixing'; //控制器
        $this->viewfolder = 'admin.huodongleixing'; //视图路径
        $this->dbname = 'activity_type';

        $this->j['nav'] = 'huodongleixing';
        $this->j['currentcontroller'] = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $list = DB::table($this->dbname)
                ->where('isdel', 0)
                ->where('mydepth', 0)
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
            'title' => 'required|string|between:1,20',
            'readme' => 'string|between:1,255',
            'cls' => 'required|integer'
        );

        $attributes = array(
            'title' => '名称',
            'readme' => '说明',
            'cls' => '排序'
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }



        /**/
        $ic = app('main')->getfirstic();
        $date = date("Y-m-d H:i:s", time());

        $rs['ic'] = $ic;
        $rs['title'] = $request->title;
        $rs['readme'] = $request->readme;
        $rs['mydepth'] = 0;
        $rs['pic'] = '0';
        $rs['cls'] = $request->cls;

        $rs['created_at'] = $date;


        if (DB::table($this->dbname)->insert($rs)) {
            $suctip[] = '<a href="' . $this->currentcontroller . '">返回类型管理</a>';
            return ( app('main')->jssuccess('保存成功', $suctip));
        } else {
            $validator->errors()->add('error', '保存失败');
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }


        //return redirect($this->currentcontroller);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        echo 'show';
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
            'title' => 'string|between:1,20',
            'readme' => 'string|between:1,255',
            'cls' => 'integer'
        );

        $attributes = array(
            "title" => '名称',
            'readme' => '说明',
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

        $suctip[] = '<a href="' . $this->currentcontroller . '">返回活动类型管理</a>';
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

//        DB::beginTransaction();
//        try {
//            $deleteic = DB::table($this->dbname)
//                    ->where('id', $id)
//                    ->delete();
//            DB::commit();
//        } catch (Exception $e) {
//            DB::rollback();
//            throw $e;
//        }

        return redirect()->back()->withInput()->withSuccess('删除成功！');
    }

}
