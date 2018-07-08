<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\DB;
use Closure;

class getuser {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $user = session('user');

        if (!$user) {
            $_ENV['user']['gic'] = 'guest';
            $_ENV['user']['gname'] = '游客';
        } else {
            $u['realname'] = $user['realname'];
            $u['mycode'] = $user['mycode'];
            $u['gic'] = $user['gic'];
            $u['dname'] = $user['dname'];
            $u['rolename'] = $user['rolename'];
            $u['role'] = $user['role'];
            $u['ic'] = $user['ic'];
            $u['dic'] = $user['dic']; //部门编号

            $u['isqiantou'] = $this->isqiantou($u['dic']);

            if ($user['dic'] == 'tw') {
                $u['istuanwei'] = true;
            } else {
                $u['istuanwei'] = false;
            }

            $_ENV['user'] = $u;
        }

        return $next($request);
    }

    function isqiantou($dic) {
        if('' == $dic){
            return false;
        }
        $count = DB::table('activity_type')
                ->where('qiantouic', $dic)
                ->count();

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    function istuanwei($dic) {
        if ($dic == 'tw') {
            return true;
        } else {
            return false;
        }
    }

}
