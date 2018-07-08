<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\UserGroup;

/* 获取活动信息的中间件 */

class getcourse {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $oj = (object) [];


        /* 取课程信息 */
        $courseid = $request->courseid;

        /* 提取 */
        $data = app('main')->getcoursebyid($courseid);
        
        if(!$data){
            return redirect('/showerr')->with('errmessage', '1022');
        }
        
        $oj->course = & $data;
        $oj->courseid = $courseid;
        
        

        /* 检测这个课程是不是我发的 */
        if ('admin' != $_ENV['user']['gic']) {
            if ($oj->course->sucode != $_ENV['user']['mycode']) {
                return redirect('/showerr')->with('errmessage', '非法操作1024');
            }
        }


        $request->oj = $oj;
        return $next($request);
    }

}
