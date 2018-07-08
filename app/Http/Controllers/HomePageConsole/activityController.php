<?php

//前台活动

namespace App\Http\Controllers\HomePageConsole;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class activityController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->currentcontroller = '/activity/detail'; //控制器
        $this->viewfolder = 'activity'; //视图路径
        $this->dbname = 'activity';

        //$this->j['nav'] = 'huodong';
        $this->j['currentcontroller'] = $this->currentcontroller;
        $this->j['basedir'] = '/';
    }

    public function index() {
        return view('homePage.layout');
    }

    public function show($id) {
        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->where('isdel', 0)
                ->first();
        if(!$data){
            return redirect('/showerr')->with('errmessage','没找到这条记录！');      
        }
        
        $this->j['data'] = $data;



        $this->j['listgood'] = app('main')->listgood();

        return view($this->viewfolder . '.detail', ['j' => $this->j]);
    }

    public function store(Request $request) {

        $validator = [];

        /* 不是学生提示重新登录 */
        if ('student' != $_ENV['user']['gic']) {
            if('magange' == $_ENV['user']['gic'] ){
                $a[][] = '教师不能报名参加';                
            }elseif('admin' == $_ENV['user']['gic'] ){
                $a[][] = '管理员不能报名参加';      
            }else{
                $a[][] = '请用学号登录报名';
            }
            return ( app('main')->ajaxvali($a) );
        }

        $rules = array(
            'pid' => 'required|alpha_num|between:1,20',
            'myexplain' => 'required|string|between:1,255'
        );

        $attributes = array(
            'pid' => '活动ID',
            'myexplain' => '申请陈述'
        );

        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }


        /* 提取活动详情 */
        $activity = app('main')->getactivitybyid($request->pid);

        /* 检测重复报名 */
        $sign = DB::table('activity_signup')
                ->where('ucode', $_ENV['user']['mycode'])
                ->where('activityic', $activity->ic)
                ->where('auditstatus', '=', 'pass')
                ->first();

        if ($sign) {
            $suctip[] = '您已经报过名了，请不要重复报名';
            return ( app('main')->jssuccess('操作提示', $suctip));
        }

        $sign = DB::table('activity_signup')
                ->where('ucode', $_ENV['user']['mycode'])
                ->where('activityic', $activity->ic)
                ->where('auditstatus', '=', '')
                ->first();

        if ($sign) {
            $suctip[] = '您已经报过名了，请不要重复报名';
            return ( app('main')->jssuccess('操作提示', $suctip));
        }












        /* 检测是否达到上限,在直接报名时才检测 */
        if ($activity->mywayic == 'direct') {
            if ($activity->signcount >= $activity->signlimit) {
                $suctip[] = '报名已达到上限， 请关注其它活动';
                return ( app('main')->jssuccess('操作提示', $suctip));
            }
        }




        /**/
        $time = time();
        $date = date("Y-m-d H:i:s", $time);

        $rs['mytype'] = 'activity';
        $rs['itemic'] =  $activity->ic;
        $rs['activityic'] = $activity->ic;
        $rs['ucode'] = $_ENV['user']['mycode'];
        $rs['created_at'] = $date;
        $rs['mystate'] = $request->myexplain;

        /* 初始化审核情况 */
        if ('direct' == $activity->mywayic) {
            $rs['auditstatus'] = 'pass';
        } else {
            $rs['auditstatus'] = '';
        }


        $rs['issignined'] = 0;
        $rs['issignined'] = 0;


        /* 更新活动统计数 */
        DB::table('activity')
                ->where('id', $activity->id)
                ->increment('signcount');

        /* 如果不需要审核，也给审核通过的人加1 */
        if ('direct' == $activity->mywayic) {
            DB::table('activity')
                    ->where('id', $activity->id)
                    ->increment('checkcount');
        }
        if (DB::table('activity_signup')->insert($rs)) {
            if ('direct' == $activity->mywayic) {
                $suctip[] = '请从“学生入口”进入个人中心，关注活动情况';
            } else {
                $suctip[] = '您的活动正在等待管理员审核通过，请从“学生入口”进入个人中心，关注活动情况';
            }




            $suctip[] = '<a href="/">返回首页</a>';
            
            $suctip[] = '<a href="/student">进入个人中心</a>';

            return ( app('main')->jssuccess('报名成功', $suctip));
        } else {
            $validator->errors()->add('error', '保存失败');
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }
    }

    public function formorder($id) {
        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->where('isdel', 0)
                ->first();

        $this->j['data'] = $data;


        /* 推荐活动 */
        $this->j['listgood'] = app('main')->listgood();
        


        return view($this->viewfolder . '.formorder', ['j' => $this->j]);
    }

}
