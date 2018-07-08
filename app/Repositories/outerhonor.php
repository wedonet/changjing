<?php

namespace App\Repositories;

/* 校外荣誉类 */

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
class outerhonor {

    public $dbname;

    function __construct() {
        $this->dbname = 'outerhonor';
    }

    /* 荣誉列表 */

    public function index($request) {
        $a = (object) [];
        $search = (object) [];
        $p = (object) [];


        $rules = array(
            'title' => 'string|between:1,20',
            'currentstatus' => 'string|between:1,20',
            'auditstatus' => 'string|between:1,20'
        );

        $attributes = array(
            "title" => '名称',
            'currentstatus' => '当前状态',
            'auditstatus' => '审核状态'
        );

        $message = array(
        );


        $search->title = $request->title;
        $search->currentstatus = $request->currentstatus;
        $search->auditstatus = $request->auditstatus;

        $p = $search;


        $a->validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($a->validator->fails()) {
            return ( $a );
        }


        /* 把身份传给搜索条件 */
        $p->user = $_ENV['user'];

DB::enableQueryLog(); 
        $list = DB::table($this->dbname)
                ->where(function($query) use($p) {
                    if ('' != $p->title) {
                        $query->where('title', 'like', '%' . $p->title . '%');
                    }
                    if ('' != $p->currentstatus) {
                        switch ($p->currentstatus) {
                            case 'new':
                                $query->where('plantime_one', '>', time());
                                break;
                            case 'doing':
                                $query->where('plantime_one', '<', time());
                                $query->where('plantime_two', '>', time());
                                break;
                            case 'done':
                                $query->where('plantime_two', '<', time());
                                break;
                            default:
                                break;
                        }
                    }
                    /* 跟据身份显示不同范围 */
                    /* 学生显示自己发的 */
                    if ('student' == $p->user['gic']) {
                        $query->where('ucode', $_ENV['user']['mycode']);
                    }

                    /* 辅导员显示自已院系的   */
                    if ('counsellor' == $p->user['role']) {
                        $query->where('dic', $_ENV['user']['dic']);
                    }

                    /* 签头部门显示二级分类是自已的 */
                    if ($p->user['isqiantou']) {
                        $arr_MyactivityTypeList = app('main')->getMyactivityTypeList($_ENV['user']['dic']);
                        $query->whereIn('type_twoic', $arr_MyactivityTypeList);
                    }
                })
                ->leftjoin('activity_type', 'outerhonor.type_twoic', '=', 'activity_type.ic')
                ->select('outerhonor.*', 'activity_type.qiantouname as dname')
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

        /* 审核人信息 */
        $result = DB::table('students')
                ->where('mycode', $data->ucode)
                ->first();

        $data->student = $result;

        return $data;
    }

    public function getbase(&$request) {
        $base = (object) [];

        $base->rules = array(
            'title' => 'required|string|between:1,50',
            'sponsor' => 'required|string|between:1,50',
            'mydate' => 'required|date|between:1,50',
            'myvalue' => 'required|integer|max:1000000',
            'readme' => 'required|string|between:1,500',
            'attachmentsurl' => 'nullable|string|between:1,255',
            'mycredit' => 'required|regex:/^0?+(.[0-9]{1})?$/',
            'type_oneic' => 'required|string|between:1,50',
            'type_twoic' => 'required|string|between:1,50',
            /**/
            'contel' => 'required|string|between:8,13',
			'conname' => 'required|string|between:2,20'
        );

        $base->attributes = array(
            'title' => '名称',
            'sponsor' => '奖励单位',
            'mydate' => '奖励日期',
            'myvalue' => '奖励金额',
            'readme' => '奖励说明',
            'attachmentsurl' => '支撑材料',
            'mycredit' => '申请学分',
            'type_oneic' => '一级活动类型',
            'type_twoic' => '二级活动类型',
        );
        $base->message = array(
            'mycredit.regex' => '学分请输入0.1至1之间的小数'
        );

        return $base;
    }

    function basemdb(&$request) {
        $mdb = (object) [];

        /* rs */
        /**/
        $time = time();
        $date = date("Y-m-d H:i:s", $time);

        /* 生成活动名称 */
        $the_activity = app('main')->getactivitytypebyic($request->type_oneic);
        $type_onename = $the_activity->title;

        $the_activity = app('main')->getactivitytypebyic($request->type_twoic);
        $type_twoname = $the_activity->title;


        $rs['title'] = $request->title;
        $rs['sponsor'] = $request->sponsor;
        $rs['mydate'] = strtotime($request->mydate);
        $rs['myvalue'] = $request->myvalue;
        $rs['readme'] = $request->readme;

        $rs['attachmentsurl'] = $request->attachmentsurl;
        $rs['mycredit'] = $request->mycredit * 1000;
        $rs['type_oneic'] = $request->type_oneic;
        $rs['type_onename'] = $type_onename;
        $rs['type_twoic'] = $request->type_twoic;

        $rs['type_twoname'] = $type_twoname;

		$rs['contel'] = $request->contel;
		$rs['conname'] = $request->conname;

        $mdb->date = $date;
        $mdb->rs = $rs;

        return $mdb;
    }

    public function store($request) {
        $o = (object) [];
        
        $o->suctip = [];

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



        $o->validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($o->validator->fails()) {
            return ( $o );
        }

        $mdb = $this->basemdb($request);
        if (isset($mdb->err)) {            
            $o->err = $mdb->err;
            return ( $o );
        }


        /**/
        $rs = $mdb->rs;

        $rs['ucode'] = $_ENV['user']['mycode'];
        $rs['dic'] = $_ENV['user']['dic'];
        $rs['created_at'] = $mdb->date;
        $rs['isok1'] = 0;
        $rs['isok2'] = 0;
        $rs['notok1reason'] = '';
        $rs['notok2reason'] = '';



        DB::table($this->dbname)->insert($rs);

        $o->suctip[] = '请等待辅导员和牵头部门审核通过';

        return $o;
    }

    public function update(Request $request, $id) {
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

        $o->validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($o->validator->fails()) {
            return ( $o );
        }

        $mdb = $this->basemdb($request);
        $rs = $mdb->rs;
        $rs['isok1'] = 0;

        $rs['isok2'] = 0;
        $rs['updated_at'] = $mdb->date;

        DB::table($this->dbname)
                ->where('id', $id)
                ->update($rs);

        $o->suctip[] = '请等待辅导员和牵头部门审核';

        return $o;
    }

}
