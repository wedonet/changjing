<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\UserGroup;

/* 获取活动信息的中间件 */

class checkmyinnerhonor {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $oj = (object) [];

        $id = $request->route('id'); //校内荣誉id
        
        //提取校内荣誉
        $innerhonor = app('main')->getinnerhonorbyid($id);
        
        if(!$innerhonor){
            return redirect('/showerr')->with('errmessage','1022');  
        }
        
        //检测是不是我发的
        if($innerhonor->ucode != $_ENV['user']['mycode']){
            return redirect('/showerr')->with('errmessage','1024');  
        }
        

        $oj->innerhonor = $innerhonor;
        $request->oj = $oj;
        return $next($request);
    }

}
