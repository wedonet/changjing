<?php
/*注销*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use DB;

class loginoutController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $request->session()->flush();





    






        return redirect('/');
    }


}
