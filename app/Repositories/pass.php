<?php

/*
 * 修改密码类
 */

namespace App\Repositories;

use Validator;
use DB;
use Illuminate\Support\Facades\Hash;

/**
 * Description of pass
 *
 * @author Administrator
 */
class pass {

    public function getbase(&$request) {
        $base = (object) [];

        $base->rules = array(
            'upass' => 'required|string|between:6,20',
            'newpass' => 'required|string|between:6,20|confirmed'
        );

        $base->attributes = array(
            'upass' => '密码',
            'newpass' => '新密码'
        );
        $base->message = array(
        );
        return $base;
    }

    function basemdb(&$request) {
        $mdb = (object) [];


   
        /* rs */
        /**/
        $time = time();
        $date = date("Y-m-d H:i:s", $time);





        $mdb->time = $time;
        $mdb->date = $date;


        return $mdb;
    }

    /* gic 身份ic */

    function store($request, $gic) {
        $o = (object) [];

        $base = $this->getbase($request);

        $rules = array(
        );

        $attributes = array(
        );

        $message = array(
        );

        $rules = array_merge($base->rules, $rules);
        $attributes = array_merge($base->attributes, $attributes);
        $message = array_merge($base->message, $message);

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );            

        $o->errs = $validator->errors();
        
   
        if ($validator->fails()) { 
            return $o;
        }

        $mdb = $this->basemdb($request);

        if (isset($mdb->err)) {
            $o->errs->add('null', $mdb->err);
            return $o;
        }

        /**/
        switch ($gic) {
            case 'admin':
                /* 检测原密码正确性 */
                $result = DB::table('adminusers')
                        ->where('uname', 'admin')
                        ->first();
                if (!$result) {
                    return redirect('/showerr')->with('errmessage', '掉线了,请重新登录');
                }
                
                /*原密码错误*/
                if(!Hash::check($request->upass, $result->upass)){
                    
                    $o->errs->add('n', '原密码错误！');
                    return $o;
                }

                $rs['upass'] = bcrypt($request->newpass);
                $rs['updated_at'] = $mdb->date;

                DB::table('adminusers')
                        ->where('uname', 'admin')
                        ->update($rs);
                break;
        case 'student':
                $mycode = $_ENV['user']['mycode'];
                /* 检测原密码正确性 */
                $result = DB::table('students')
                        ->where('mycode', $mycode)
                        ->first();
                if (!$result) {
                    return redirect('/showerr')->with('errmessage', '掉线了,请重新登录');
                }
                
                /*原密码错误*/
                if(!Hash::check($request->upass, $result->upass)){
                    
                    $o->errs->add('n', '原密码错误！');
                    return $o;
                }

                $rs['upass'] = bcrypt($request->newpass);
                $rs['updated_at'] = $mdb->date;

                DB::table('students')
                        ->where('mycode', $mycode)
                        ->update($rs);
                break;                
            default:
                return redirect('/showerr')->with('errmessage', '出错了');
                break;
        }


        $request->session()->flush();
        
        $suctip[] = '保存成功.';




        $o->suctip = $suctip;

        return $o;
    }

}
