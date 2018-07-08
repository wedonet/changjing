<?php

namespace App\Repositories;

/* 履职修业类 */

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of activity
 *
 * @author Administrator
 */
class perform {

    public $dbname;

    function __construct() {
        $this->dbname = 'perform';
    }

    /* 荣誉列表 
      showtype : fq=发起人，这是只显示自已发的;sh=审核机构，这时显示自已有权限审核的; my=我的
     * 
     *      */

    public function index($request, $showtype = 'fq') {
        $a = (object) [];

        $search = (object) [];

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


        $search->title = $request->title;
        $search->mycode = $request->mycode;
        $search->showtype = $showtype;

        $a->validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($a->validator->fails()) {
            return ( $a );
        }

        $list = DB::table($this->dbname)
                ->where(function($query) use($search) {
                    if ('' != $search->title) {
                        $query->where('title', 'like', '%' . $search->title . '%');
                    }
                    if ('' != $search->mycode) {
                        $query->where('mycode', 'like', '%' . $search->mycode . '%');
                    }

                    switch ($search->showtype) {
                        case 'fq':
                            $query->where('sucode', $_ENV['user']['mycode']); //我发的
                            break;
                        case 'sh':
                            $arr_MyactivityTypeList = app('main')->getMyactivityTypeList($_ENV['user']['dic']);
                            $query->whereIn('type_twoic', $arr_MyactivityTypeList); //我有权审核的       
                            break;
                        case 'my': //我的
                            $query->where('ucode', $_ENV['user']['mycode']); //我发的 
                            $query->where('isok', 1);
                            break;
                        default:
                            break;
                    }
                })
                ->where('isdel', 0)
                ->orderby('id', 'desc')
                ->paginate(18);





        $a->search = $search;
        $a->list = $list;




        return $a;
    }

    public function show($id) {
        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->first();
        if (!$data) {
            return redirect('/showerr')->with('errmessage', '1022');
        }

        /* 提取牵头部门 */
        $data->tiantouname = app('main')->getdnamebytype($data->type_twoic);

        return $data;
    }

    public function getbase(&$request) {
        $base = (object) [];

        $base->rules = array(
            'ucode' => 'required|string|between:8,12',
            'realname' => 'required|string|between:2,12',
            'title' => 'required|string|between:1,50',
            'myyear' => 'required|string|between:1,50',
            'type_oneic' => 'required|string|between:1,20',
            'type_twoic' => 'required|string|between:1,20',
            'mydic' => 'required|string|between:1,20',
            'mycredit' => 'required|integer|max:10000',
            /**/
            'contel' => 'required|string|between:8,13',
			'conname' => 'required|string|between:2,20'
        );

        $base->attributes = array(
            'ucode' => '学号',
            'title' => '名称',
            'myyear' => '学年',
            'type_oneic' => '一级类型',
            'type_twoic' => '二级类型',
            'mydic' => '聘任部门',
            'mycredit' => '学分',
        );
        $base->message = array(
            'mycredit.max' => '最多10学分'
        );
        return $base;
    }

    function basemdb(&$request) {
        $mdb = (object) [];

        $the_activity = app('main')->getactivitytypebyic($request->type_oneic);
        $type_onename = $the_activity->title;

        $the_activity = app('main')->getactivitytypebyic($request->type_twoic);
        $type_twoname = $the_activity->title;

        /* 取部门名称 */
        $result = app('main')->getdepartmentdatabyic($request->mydic);

        if (!$result) {
            $mdb->err = '没找到任职部门';
            return $mdb;
        }
        $mydname = $result->title;
        /* rs */
        /**/
        $time = time();
        $date = date("Y-m-d H:i:s", $time);



        $rs['ucode'] = $request->ucode;
        $rs['realname'] = $request->realname;
        $rs['title'] = $request->title;
        $rs['myyear'] = $request->myyear;
        $rs['type_oneic'] = $request->type_oneic;
        /**/
        $rs['type_onename'] = $type_onename;
        $rs['type_twoic'] = $request->type_twoic;
        $rs['type_twoname'] = $type_twoname;
        $rs['mydic'] = $request->mydic;
        $rs['mydname'] = $mydname;
        /**/
        $rs['mycredit'] = $request->mycredit;
        
		$rs['contel'] = $request->contel;
		$rs['conname'] = $request->conname;

        $mdb->time = $time;
        $mdb->date = $date;
        $mdb->rs = $rs;

        return $mdb;
    }

    function store($request) {
        $o = (object) [];

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

        $o->validator = $validator;
        if ($validator->fails()) {
            return $o;
        }

        $mdb = $this->basemdb($request);

        if (isset($mdb->err)) {
            $this->mdberr = $mdb->err;
            $validator->after(function($validator) {
                $validator->errors()->add('error2', $this->mdberr);
            });
            $o->validator = $validator;
            return $o;
        }


        /**/
        $rs = $mdb->rs;

        $rs['sucode'] = $_ENV['user']['mycode'];
        $rs['created_at'] = $mdb->date;

        $suctip[] = '保存成功.';


        /* 牵头部门和团委发的不需要审核，直接过 */
//        if ($_ENV['user']['isqiantou'] or $_ENV['user']['istuanwei']) {
//            $rs['isok'] = 1;
//            $rs['isokucode'] = $_ENV['user']['mycode'];
//            $rs['isoktime'] = $mdb->time;
//
//
//            $rs['actualcredit'] = $request->mycredit;
//
//            $rs['okway'] = '自动通过';
//        } else {
        $suctip[] = '请等待牵头部门审核通过';

        $rs['isok'] = 0;
        $rs['isokucode'] = '';
        $rs['isoktime'] = 0;
        //}



        DB::table($this->dbname)->insert($rs);

        $o->suctip = $suctip;

        return $o;
    }

    function update($request, $id) {
        $o = (object) [];

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

        $o->validator = $validator;
        if ($validator->fails()) {
            return $o;
        }

        $mdb = $this->basemdb($request);

        if (isset($mdb->err)) {
            $validator->errors()->add('error2', $mdb->err);
            $o->validator = $validator;
            return $o;
        }


        /**/
        $rs = $mdb->rs;

        //$rs['sucode'] = $_ENV['user']['mycode'];
        $rs['updated_at'] = $mdb->date;

        $suctip[] = '保存成功.';


        /* 牵头部门和团委发的不需要审核，直接过 */
        if ($_ENV['user']['isqiantou'] or $_ENV['user']['istuanwei']) {
            
        } else {
            //$suctip[] = '请等待牵头部门审核通过';
        }
        $rs['isok'] = 0;
        $rs['isokucode'] = '';
        $rs['isoktime'] = 0;

        DB::table($this->dbname)->where('id', $id)->update($rs);


        $o->suctip = $suctip;

        return $o;
    }

    /* 取履职修业 */

    function getperformbyid($id) {
        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->where('isdel', 0)
                ->first();
        if (!$data) {
            return redirect('/showerr')->with('errmessage', '1022');
        }


        return $data;
    }

}
