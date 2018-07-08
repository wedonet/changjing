<?php

/* 公用接口文件 */
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Validator;

/**
 * Description of papi
 *
 * @author Administrator
 */
class papiController extends Controller {

    public $j = array();

    //put your code here
    function index(Request $request) {
        $this->j['suc'] = 'n';


        $act = $request->act;

        switch ($act) {
            case 'getteachername':
                $this->getteachername($request);
                break;
        }
    }

    function getteachername($request) {
        $mycode = $request->mycode;

        $data = DB::table('teachers')
                ->where('mycode', $mycode)
                ->first();

        if (false != $data) {
            $this->j['suc'] = 'y';
            $this->j['data']['realname'] = $data->realname;
        }
        echo json_encode($this->j);
    }

}
