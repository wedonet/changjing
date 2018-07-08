<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use App\Repositories\pass as passRepository;

class passController extends Controller {

    private $viewfolder;
    private $dbname;

    function __construct(passRepository $cr) {
        $this->oj = (object) [];

        $this->cr = $cr;

        $this->currentcontroller = '/adminconsole/pass'; //控制器
        $this->viewfolder = 'pub'; //视图路径
        $this->dbname = 'adminusers';

        $this->oj->nav = 'pass';
        $this->oj->currentcontroller = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $this->oj->gic = 'admin';
        return view($this->viewfolder . '.pass', ['oj' => $this->oj]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * errs is a messagebag
     */
    public function store(Request $request) {
        $o = $this->cr->store($request, 'admin');

        if (!$o->errs->isempty()) {
            return redirect()->back()->withInput()->withErrors($o->errs->toarray());
        }

        $suctip = $o->suctip;

        return redirect()->back()->withInput()->with('sucinfo', '操作成功,请重新登录！')->with('location', '/');
    }

}
