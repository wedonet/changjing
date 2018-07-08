<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\libraries\UploadsManager;
use Illuminate\Support\Facades\File;
use DB;

/**
 * Description of uploadController
 *
 * @author Administrator
 */
class uploadController extends Controller {

    public function index(Request $request) {
        $a['suc'] = 'n';

        /* 检测权限 */
        if ('guest' == $_ENV['user']['gic']) {
            $a['error'] = '操作超时，请重新登录';
            echo json_encode($a, 320);
            return;
        }

        $fileurl = '';

        $inputname = $request->inputname;

        /* 检测是否上传了文件 */
        if (!$request->hasFile($inputname)) {
            $a['error'] = '请选择上传文件';
            echo json_encode($a, 320);
            return;
        }


        $file = $request->file($inputname);

        /**/
        if (!$file->isValid()) {
            $a['error'] = '上传错误';
            echo json_encode($a);
            return;
        }

        // 获取文件相关信息
        $originalName = $file->getClientOriginalName(); // 文件原名
        $filetype = $file->getMimeType();

        /* laravel 没有这个类型 */
        switch ($filetype) {
            case 'application/vnd.ms-office':
                $ext = 'xls';
                break;
            default :
                $ext = $file->guessExtension();
                break;
        }



        $old_ext = $this->getoldext($originalName);
        //
        //
        //
        //dd($ext);
        /* 检测文件类型和大小 */
        $allowext = '';
        $allowext .= 'jpeg,jpg,png';
        $allowext .= ',txt';
        $allowext .= ',zip,rar';
        $allowext .= ',doc,docx,ppt,pptx,xls,xlsx';
        $allowext .= ',vsd,pps,pot,rtf,wps,et,dps,PDF,pdf';
        $allowext .= ',bin';


        if (false === stripos($allowext, $ext)) {
            $a['error'] = '上传类型错误，请选择' . $allowext . '文件上传!';

            echo json_encode($a, 320);
            return;
        }

        $size = $file->getClientSize() / 1024 / 1024; //换成m

        if ($size > 500) {
            $a['error'] = '单个文件最大允许上传500M';
            echo json_encode($a, 320);
            return;
        }

        /* 上传图片的地址 */
        $ym = date('Ym');
        $uprootdir = 'upload';
        //$updir = $uprootdir . $ym;


        $destPath = realpath(public_path($uprootdir)) . DIRECTORY_SEPARATOR . $ym;


        if (!is_dir($destPath)) {
            mkdir($destPath, 0777, true);
        }

        if (!is_dir($destPath . '/pre')) {
            mkdir($destPath . '/pre', 0777, true);
        }

        // 上传文件
        $filename = date('dHis') . '-' . uniqid(str_random(4)) . '.' . $old_ext;


        $result = $file->move($destPath, $filename);



        if ($result != false) {
            $user = session('user');
            if (!$user) {
                $mycode = '';
            } else {
                $mycode = $_ENV['user']['mycode'];
            }
            $fileurl = '/' . $uprootdir . '/' . $ym . '/' . $filename;
            //$fileurl =          $updir;

            $date = date("Y-m-d H:i:s", time());

            $a['fileurl'] = $fileurl;
            $a['originname'] = $originalName;

            $rs['filename'] = $filename;
            $rs['url'] = $fileurl;
            $rs['originname'] = $originalName;
            $rs['uname'] = $mycode;
            $rs['mytype'] = '';
            $rs['mysize'] = $size;
            $rs['mysize'] = $size;

            $rs['ext'] = $ext;

            $rs['created_at'] = $date;

            $id = DB::table('uplists')->insert($rs);

//        $origin_width = Image::make($destPath . DIRECTORY_SEPARATOR . $filename)->width();
//        $origin_height = Image::make($destPath . DIRECTORY_SEPARATOR . $filename)->height();
//
//        if ($origin_width >= 600) {//如果图片尺寸大于600
//            $image = Image::make($destPath . DIRECTORY_SEPARATOR . $filename)->save($destPath . $filename); //先存到大图文件夹下
//            /* 生成缩略图 */
//            $image = Image::make($destPath . DIRECTORY_SEPARATOR . $filename)->resize(600, null, function ($constraint) { //然后压缩到600
//                $constraint->aspectRatio();
//            });
//            $image->save($destPath . '/pre/' . $filename); //再存到小图文件夹下
//        } else {//否则不压缩各存一份
//            $image = Image::make($destPath . DIRECTORY_SEPARATOR . $filename)->save($destPath . $filename);
//            $image = Image::make($destPath . DIRECTORY_SEPARATOR . $filename)->save($destPath . '/pre/' . $filename);
//        }


            /* 入库 */
//            dd($_ENV);
//            $rs['filetype'] = 'image';
//            $rs['uid'] = $_ENV['user']['id'];
//            $rs['unick'] = $_ENV['user']['nick'];
//            $rs['myclassid'] = 0; //默认分类 
//            $rs['title'] = '';
//            $rs['urlfile'] = '/' . $upimagedir . '/pre/' . $filename;
//
//            if ($origin_width >= 600) {
//                $rs['preimg'] = '/' . $upimagedir . $filename;
//            } else {
//                $rs['preimg'] = '/' . $upimagedir . '/pre/' . $filename;
//            }
            //$rs['filesize'] = $file->getClientSize() / 1024;
            // $rs['imgwidth'] = $origin_width;
            //$rs['imgheight'] = $origin_height;
            // $id = DB::table('aduploads')->insert($rs);
            // return redirect()
            //                ->back()
            //                 ->withSuccess("File '$filename' uploaded.");
        }

        //$error = $result ? : "An error occurred uploading file.";
        //return redirect()
        //                 ->back()
        //                ->withErrors([$error]);

        $a['suc'] = 'y';
        echo json_encode($a, 320);
        return;
    }

    /* 取原始扩展名 */

    public function getoldext($filename) {
        $a = explode('.', $filename);

        return $a[count($a) - 1];
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
