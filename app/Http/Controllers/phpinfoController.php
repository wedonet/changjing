<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;


class phpinfoController extends Controller {
    private $viewfolder;
    private $dbname;

    function __construct() {
       
    }

    public function index(Request $request) {
        print_r(phpinfo());
    }

   

}
