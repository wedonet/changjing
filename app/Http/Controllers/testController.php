<?php

/* 测试 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use DB;

class testController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->currentcontroller = '/loginController'; //控制器
        $this->viewfolder = ''; //视图路径
        $this->dbname = 'students';

        //$this->j['nav'] = 'banji';
        $this->j['currentcontroller'] = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        echo strtotime('2017/12/10');
    }

    function formattime2($s) {
        return date('Y-m-d H:i', $s);
    }

    function upload() {
        return view('test.formupload');
    }

    function doupload() {
        
    }

    /* 获取上传进度 */

    function getprogress() {
       
        $i = ini_get('session.upload_progress.name');  

        @$key = ini_get('session.upload_progress.prefix') . 'test';

        if (!empty($_SESSION[$key])) {
            $current = $_SESSION[$key]['bytes_processed'];
            $total = $_SESSION[$key]['content_length'];
            echo $current < $total ? ceil($current / $total * 100) : 100;
        } else {
            echo 100;
        }
    }

}
