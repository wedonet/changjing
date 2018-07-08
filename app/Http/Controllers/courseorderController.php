<?php

/* 课程报名*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class courseorderController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->oj = (object)[];
        
        $this->currentcontroller = '/courseic/detail'; //控制器
        $this->viewfolder = 'course'; //视图路径
        $this->dbname = 'courses';

        //$this->j['nav'] = 'huodong';
        $this->oj->currentcontroller = $this->currentcontroller;
        //$this->j['basedir'] = '/';
    }

    public function index() {
        return view('homePage.layout');
    }

    public function show($id) {
        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->where('isdel', 0)
                ->first();

        $this->oj->data = $data;
        $this->oj->listgood = app('main')->listgood();

        return view($this->viewfolder . '.detail', ['oj' => $this->oj]);
    }

    public function store(Request $request) {
        /* 不是学生提示重新登录 */
        if ('student' != $_ENV['user']['gic']) {
            if ('magange' == $_ENV['user']['gic']) {
                $a[][] = '教师不能报名参加';
            } elseif ('admin' == $_ENV['user']['gic']) {
                $a[][] = '管理员不能报名参加';
            } else {
                $a[][] = '请用学号登录报名';
            }
            return ( app('main')->ajaxvali($a) );
        }

        $rules = array(
            'pid' => 'required|alpha_num|between:1,20',
            'myexplain' => 'required|string|between:1,20'
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


        /* 提取课程详情 */
        $course = app('main')->getcoursebyid($request->pid);

        /* 检测重复报名 */
        $sign = DB::table('courses_signup')
                ->where('ucode', $_ENV['user']['mycode'])
                ->where('itemic', $course->ic)
                ->where('auditstatus', '=', 'pass')
                ->first();

        if ($sign) {
            $suctip[] = '您已经报过名了，请不要重复报名';
            return ( app('main')->jssuccess('操作提示', $suctip));
        }

        $sign = DB::table('courses_signup')
                ->where('ucode', $_ENV['user']['mycode'])
                ->where('itemic', $course->ic)
                ->where('auditstatus', '=', '')
                ->first();

        if ($sign) {
            $suctip[] = '您已经报过名了，请不要重复报名';
            return ( app('main')->jssuccess('操作提示', $suctip));
        }


        /* 检测是否达到上限,在直接报名时才检测 */
        if ($course->mywayic == 'direct') {
            if ($course->signcount >= $course->signlimit) {
                $suctip[] = '报名已达到上限， 请关注其它活动';
                return ( app('main')->jssuccess('操作提示', $suctip));
            }
        }


        /**/
        $time = time();
        $date = date("Y-m-d H:i:s", $time);

        $rs['itemic'] = $course->ic;
        $rs['ucode'] = $_ENV['user']['mycode'];
        $rs['created_at'] = $date;
        $rs['mystate'] = $request->myexplain;

        /* 初始化审核情况 */
        if ('direct' == $course->mywayic) {
            $rs['auditstatus'] = 'pass';
        } else {
            $rs['auditstatus'] = '';
        }


        $rs['issignined'] = 0;
        $rs['issignined'] = 0;



        DB::beginTransaction();
        try {
            /* 更新活动统计数 */
            DB::table('courses')
                    ->where('id', $course->id)
                    ->increment('signcount');

            /* 如果不需要审核，也给审核通过的人加1 */
            if ('direct' == $course->mywayic) {
                DB::table('courses')
                        ->where('id', $course->id)
                        ->increment('checkcount');
            }


            DB::table('courses_signup')->insert($rs);




            DB::commit();

            if ('direct' == $course->mywayic) {
                $suctip[] = '请从“学生入口”进入个人中心，关注课程情况';
            } else {
                $suctip[] = '提交成功，等待管理员审核，请从“学生入口”进入个人中心，关注！';
            }

            $suctip[] = '<a href="/">返回首页</a>';

            $suctip[] = '<a href="/student">进入个人中心</a>';

            return ( app('main')->jssuccess('报名成功', $suctip));
        } catch (Exception $e) {
            DB::rollback();

            $validator->errors()->add('error', '保存失败');
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );

            throw $e;
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
