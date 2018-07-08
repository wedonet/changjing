<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\UserGroup;

class student {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if( 'student' !== $_ENV['user']['gic']){
            return redirect('/login');            
        } else{
            return $next($request);
        }

    }

}
