<?php

/* 下载付件，加入响应头 */

namespace App\Http\Controllers;

use App\Models\Adminuser;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use DB;
use Storage;

class downattachController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        
    }

    public function index(Request $request) {
        $str = $request->p;
        $filename_url = str_replace('-', '+', $str);

        $filename_url_ = explode('@@@', base64_decode($filename_url));

        if (count($filename_url_) < 2) {

            dd('1024');
        }

        $filename = $filename_url_[0];

        $url = $filename_url_[1];
        $s = public_path() . ($url);
        $s = (str_replace('/upload/', '', $url));


        $filepath = realpath(base_path('public')) . $url;


        $para['rootpath'] = $url;
        $para['publicpath'] = $s; //public下的路径
        $para['filename'] = $filename;

        $exists = Storage::disk('local')->exists($s);

        if ($exists) {
            //ob_clean();
            //flush();
            $s = public_path() . ($url);

            $filesize = filesize($s);


            if (strtolower(substr(PHP_OS, 0, 3)) == 'win') {
                return response()->download($s, $para['filename']);
                //echo 'windows';
            } else {
                header('Content-Disposition:attachment;filename=' . $para['filename']);
                header("Content-Length: " . $filesize);
                header('X-Accel-Redirect: ' . $para['rootpath']); //适用于nginx服务器
            }

        } else {

            return redirect('/showerr')->with('errmessage', '没找到下载文件' . $filepath);
        }



        //header('Content-Disposition:attachment;filename=' . $filename);
        //$file = file_get_contents($s, true);
        //print($file);
        // print_r($s);
        // print file_get_contents($s);
    }

    public function getoldext($filename) {
        $a = explode('.', $filename);

        return $a[count($a) - 1];
    }

}
