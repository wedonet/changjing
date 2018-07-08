<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use DB;

class mytestController extends Controller {

    
    function __construct() {

    }

    function index(Request $request){
        $request->setTrustedProxies(['192.168.198.128','192.168.198.1']);
        $ip = $request->getClientIp();
  
        dd($ip);
   
    }
   

}
