<?php

namespace App\Http\Controllers\update;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use DB;


class updateController extends Controller {



    function __construct() {
       
        
        
    }

    public function index(Request $request) {
        /*提取出所有辅导老师*/
        $fudaoteachers = DB::table('teachers')
                ->where('mytype', 'counsellor')
                ->get();
        
        foreach($fudaoteachers as $v){
            $rs = null;
            $rs['suname'] = $v->dname;
            
            DB::table('courses')
                    ->where('sucode', $v->mycode)
                    ->update($rs);
            
        }
        
        echo 'ok';
    }

   
}
