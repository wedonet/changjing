<?php

namespace App\Http\Middleware;

use Closure;


/*获取活动信息的中间件*/
class getactivity {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        /*取活动信息*/        
        $aid = $request->aid;
        
        //有可能用aid或activityid传过来的
        if('' == $aid){            
            $aid = $request->activityid;
        }


        /* 提取活动 */  
        $j['activity'] = app('main')->getactivitybyid($aid);
        $j['aid'] = $aid;
        
        if(!$j['activity']){
            return redirect('/showerr')->with('errmessage','没找到这个活动');   
        }
        
        $request->j = $j; 
        

         
        /*检测这个活动是不是我发的*/
        if( 'fq' == $_ENV['user']['role']){            
            if ($j['activity']->sucode != $_ENV['user']['mycode']){
                return redirect('/showerr')->with('errmessage','这个活动不是您发的');
            }
        }

        return $next($request);
    }

}
