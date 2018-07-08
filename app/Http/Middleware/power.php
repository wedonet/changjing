<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use App\Models\UserGroup;

class power {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        $zdhd = session('zahd');
        if ($zdhd == '') {
            return redirect('AdminConsole/login');
        } else {
            $null = User::where('u_name', session('zahd')->u_name)->first();
            if ($null == null) {
                return redirect('AdminConsole/login');
            }
            $user['u_name'] = $zdhd['u_name'];
            $user['nick'] = $zdhd['u_nick'];
            $user['id'] = $zdhd['id'];
            $_ENV['user'] = $user;
            return $next($request);
        }
    }

}
