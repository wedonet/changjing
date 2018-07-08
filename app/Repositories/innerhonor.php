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
class innerhonor {

    public $dbname;

    function __construct() {
        $this->dbname = 'innerhonor';
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

        
        /*把身份传给搜索条件*/
        $p->user = $_ENV['user'];
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
                    /*跟据身份显示不同范围
                    * 辅导员显示自已院系的    
                     *                      */
                    
                    if('counsellor' == $p->user['role']){
                        $query->where('plantime_two', '<', time());
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

        return $data;
    }

}
