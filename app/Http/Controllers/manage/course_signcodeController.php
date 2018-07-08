<?php

namespace App\Http\Controllers\manage;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Validator;

class course_signcodeController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->currentcontroller = '/manage/qiandao'; //控制器
        $this->viewfolder = 'manage.kecheng.signcode'; //视图路径
        $this->dbname = 'courses_hour';

        $this->j['nav'] = 'qiandao';
        $this->j['currentcontroller'] = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function signin($id) {
        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->first();
        $signcode = $data->signcode;    


        $url = 'http';
        //if ($_SERVER["HTTPS"] == "on" And $_ENV['IsHttps']== 1) { //在非https下，没有$_SERVER["HTTPS"]
		if ($_ENV['IsHttps']== 1) {
            $url .= "s";
        }
        $url .=  '://';
        $url .=  $_SERVER["HTTP_HOST"] . '/coursesignin/'.$signcode;
        
        QrCode::format('png')
                ->size(500)
                ->color(255, 0, 255)
                ->generate($url, public_path("qrcodes/" . $signcode . '.png'));

        $this->j['signcode'] = $signcode;
        $this->j['url'] = $url;
        return view($this->viewfolder . '.index', ['j' => $this->j]);
    }

    public function signoff($ic) {

        $data = DB::table('activity')->where('ic', $ic)->first();
        $list = $ic . $data->signcode;
        $name = $data->title . 'qiantui';
        QrCode::format('png')->size(500)->color(255, 0, 255)->generate("http://" . $_SERVER["HTTP_HOST"] . "/signout/{$list}", public_path("qrcodes/" . $name . '.png'));
        $this->j = $name;
        return view($this->viewfolder . '.index', ['j' => $this->j]);
    }

}
