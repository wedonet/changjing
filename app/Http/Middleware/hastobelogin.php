<?php

/* 报名时检测 必须登录后才能操作 */

namespace App\Http\Middleware;

use Closure;

class hastobelogin {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        $user = session('user');
        
        /*没有session,和session不是学生的跳到登录页*/
        if ('' == $user) {
            return view('ajax.hastobelogin');
        } else {
            if ('student' != $user['gic']) {
                return view('ajax.hastobelogin');
            }
        }

        return $next($request);
    }

}
