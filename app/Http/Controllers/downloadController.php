<?php

/* 系统首页 */

namespace App\Http\Controllers;

use App\Models\Adminuser;
use App\Models\User;
use App\Models\Usergroup;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use DB;
use Storage;

class downloadController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        
    }

    public function index(Request $request) {
        $id = $request->id;
        $url = $request->p;

        $mytype = app('main')->rstr('mytype');

        $s = base64_decode($url);

        $url = $s;

        $ext = $this->getoldext($s);

        switch ($mytype) {
            case 'course':
                $signup = DB::table('courses_signup')
                        ->where('id', $id)
                        ->first();
                if (!$signup) {
                    return redirect('/showerr')->with('errmessage', '没找到');
                }

                $item = DB::table('courses')
                        ->where('ic', $signup->itemic)
                        ->first();


                break;
            default:
                $signup = DB::table('activity_signup')
                        ->where('id', $id)
                        ->first();
                if (!$signup) {
                    return redirect('/showerr')->with('errmessage', '没找到');
                }

                $item = DB::table('activity')
                        ->where('ic', $signup->activityic)
                        ->first();

                break;
        }

        $student = DB::table('students')
                ->where('mycode', $signup->ucode)
                ->first();

        $filename = $item->title;

        $filename .= '_' . $student->realname;

        $filename .= '.' . $ext;



        $s = public_path() . ($url);
        $s = (str_replace('/upload/', '', $url));



        $exists = Storage::disk('local')->exists($s);

        if (!$exists) {
            return redirect('/showerr')->with('errmessage', '没找到下载文件' . $s);
        }

        /* 几个需要用到的路径 */
        //$para['phypath'] = public_path() . ($url); //物理路径
        $para['rootpath'] = $url; //跟路径
        $para['publicpath'] = $s; //public下的路径
        $para['filename'] = $filename; //文件名称
        //$para['filesize'] = filesize($para['phypath']);
        //$para['ext'] = $ext; //文件后缀







        if (strtolower(substr(PHP_OS, 0, 3)) == 'win') {
            return response()->download($s, $para['filename']);
            //echo 'windows';
        } else {

            $s = public_path() . ($url);

            $filesize = filesize($s);

            header('Content-Disposition:attachment;filename=' . $para['filename']);
            header("Content-Length: " . $filesize);
            header('X-Accel-Redirect: ' . $para['rootpath']); //适用于nginx服务器
        }
    }

    public function getoldext($filename) {
        $a = explode('.', $filename);

        return $a[count($a) - 1];
    }

}
