<?php

namespace App\Http\Controllers\ajax;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class confirmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $oj = (object) [];
        
        $action = $request->action;
        $title = $request->title;
        
        $oj->action = $action;
        $oj->title = $title;
        
        return view('ajax.confirm',  ['oj' => $oj]);
    }

    

}
