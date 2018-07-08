<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use DB;

class HomePageController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->currentcontroller = '/'; //控制器
        $this->viewfolder = 'homepage'; //视图路径
        $this->dbname = 'activity';

        //$this->j['nav'] = 'huodong';
        $this->j['currentcontroller'] = $this->currentcontroller;
        $this->j['basedir'] = '/';
    }

    public function index(Request $request) {
        /* 当前模块 */
        $currentmodule = $request->path();
        $this->j['currentmodule'] = $currentmodule;

        $search = [];

        $rules = array(
            'type1' => 'string|between:1,20',
            'type2' => 'string|between:1,20',
            'act' => 'string|between:1,20'
        );

        $attributes = array(
            "type1" => '一级类型',
            'type2' => '二级类型'
        );

        $message = array(
        );

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        $search['type1'] = $request->type1;
        $search['type2'] = $request->type2;

        $this->j['search'] = $search;

        /* 面包 */
        $this->scrumb = [];
        if ('' != $request->type1) {
            $this->gettypename($request->type1);
        }
        if ('' != $request->type2) {
            $this->gettypename2($request->type2);
        }
        $this->j['scrumb'] = $this->scrumb;






        $list = DB::table('activity')
                ->where('isdel', 0)
                //->where('isopen', 1) //开通的
                ->where('auditstatus', 'pass') //通过审核的
                ->where(function($query) use($search) {
                    if ('' != $search['type1']) {
                        $query->where('type_oneic', $search['type1']);
                    }
                    if ('' != $search['type2']) {
                        $query->where('type_twoic', $search['type2']);
                    }
                })
                ->orderby('id', 'desc')
                ->paginate(18);





        $this->j['list'] = $list;
        $this->j['listgood'] = app('main')->listgood();

        return view($this->viewfolder . '.index', ['j' => $this->j]);
    }

    private function gettypename($ic) {
        $data = DB::table('activity_type')
                ->where('ic', $ic)
                ->select('title')
                ->first();
        if ($data) {
            $this->scrumb[] = $data->title;
        } else {
            return '';
        }
    }

    private function gettypename2($ic) {
        $type1name = '';
        $type2name = '';

        $data = DB::table('activity_type')
                ->where('ic', $ic)
                ->select('title', 'pic')
                ->first();

        if ($data) {
            $type2name = $data->title;

            $data = DB::table('activity_type')
                    ->where('ic', $data->pic)
                    ->select('title')
                    ->first();

            if ($data) {
                $type1name = $data->title;
            } else {
                $type1name = '';
            }
        } else {
            $type2name = '';
        }

        if ('' != $type1name) {
            $this->scrumb[] = $type1name;
        }
        if ('' != $type2name) {
            $this->scrumb[] = $type2name;
        }
    }

}
