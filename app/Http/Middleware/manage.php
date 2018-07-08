<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\UserGroup;

class manage {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if( 'manager' !== $_ENV['user']['gic']){
            return redirect('/managelogin');            
        } else{
            return $next($request);
        }
    }

}
