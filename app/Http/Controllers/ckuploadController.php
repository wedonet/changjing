<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
class ckuploadController extends Controller {

    public function index(Request $request) {
        
      
        $callback = $_GET['CKEditorFuncNum'];
        




        $fileurl = '';



        /* 检测是否上传了文件 */
        if (!$request->hasFile('upload')) {
            $a['error'] = '请选择上传文件';
            echo json_encode($a, 320);
            return;
        }


        $file = $request->file('upload');

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
        if (false === stripos('jpeg,jpg,png,txt,zip,doc,docx,ppt,pptx,xls,xlsx,vsd,pot,pps,rtf,wps,et.dps,PDF,pdf,bin', $ext)) {
            $a['error'] = '上传类型错误，请选择jpeg,jpg,png,txt,zip,doc,docx,ppt,pptx,xls,xlsx,vsd,pot,pps,rtf,wps,et.dps,PDF,pdf文件上传!';

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


        if (!file_exists($destPath)) {
            mkdir($destPath, 0755, true);
        }

        if (!file_exists($destPath . '/pre')) {
            mkdir($destPath . '/pre', 0755, true);
        }

        // 上传文件
        $filename = date('dHis') . '-' . uniqid(str_random(4)) . '.' . $old_ext;
        $result = $file->move($destPath, $filename);
        if ($result != false) {
            $fileurl = '/' . $uprootdir . '/' . $ym . '/' . $filename;
            //$fileurl =          $updir;

            $date = date("Y-m-d H:i:s", time());

            $a['fileurl'] = $fileurl;
            $a['originname'] = $originalName;

            $rs['filename'] = $filename;
            $rs['url'] = $fileurl;
            $rs['originname'] = $originalName;
            //$rs['uname'] = $_ENV['uic'];
            $rs['mytype'] = '';

            $rs['ext'] = $ext;

            $rs['created_at'] = $date;

            $id = DB::table('uplists')->insert($rs);
        }

        $str = 'window.parent.CKEDITOR.tools.callFunction("'.$callback.'","'.$a['fileurl'].'","")';
        

        echo('<script type="text/javascript">');    
        //echo('window.parent.CKEDITOR.tools.callFunction('.$callback.','.'/images,"")');    
        echo($str);    
        echo("</script>");  
        
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
