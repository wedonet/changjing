<?php

/* 活动签到扫码页 */

namespace App\Http\Controllers\manage;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Validator;

class qiandaoController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->currentcontroller = '/manage/qiandao'; //控制器
        $this->viewfolder = 'manage.qiandao'; //视图路径
        $this->dbname = 'detail';

        $this->j['nav'] = 'qiandao';
        $this->j['currentcontroller'] = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function qiandao($ic) {
        $data = DB::table('activity')->where('ic', $ic)->first();
        $list = $ic . $data->signcode;
        $name = 'activity_'.$ic;

        /*二维码的网址*/
        $url = 'http';
        if ($_ENV['IsHttps']== 1) {
            $url .= "s";
        }
        $url .= '://';
        $url .= $_SERVER["HTTP_HOST"] . '/signin/' . $list;


        //QrCode::format('png')->size(500)->color(255, 0, 255)->generate($url);
    

        $oj = (object) [];
        $oj->url = $url;
        $oj->name = $name;
        $oj->title = '签到码';
        
        return view($this->viewfolder . '.index', ['oj'=>$oj]);
    }

    public function qiantui($ic) {
        $oj = (object)[];
        
        $data = DB::table('activity')->where('ic', $ic)->first();
        $list = $ic . $data->signcode;
        $name = $data->title . 'qiantui';
        
        /*二维码的网址*/
        $url = 'http';
        if ($_ENV['IsHttps']== 1) {
            $url .= "s";
        }
        $url .= '://';
        $url .= $_SERVER["HTTP_HOST"] . '/signout/' . $list;
        
        
        //QrCode::format('png')->size(500)->color(255, 0, 255)
        //        ->generate($url, public_path("qrcodes/" . $name . '.png'));
        
        $this->j = $name;
        $oj->title = '签退码';
        $oj->name = $name;
        $oj->url = $url;
        return view($this->viewfolder . '.index', ['oj'=>$oj]);
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

        return redirect($this->currentcontroller);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return view($this->viewfolder . '.detail', ['j' => $this->j]);
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

}
