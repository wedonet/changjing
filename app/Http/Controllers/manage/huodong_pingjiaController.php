<?php

namespace App\Http\Controllers\manage;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Validator;
/**/
use App\Repositories\activity as activityRepository;

class huodong_pingjiaController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;
    private $activityid; //活动id

    function __construct(Request $request, activityRepository $activityRepository) {
        /* 注入活动类 */
        $this->classactivity = $activityRepository;





        $this->currentcontroller = '/manage/huodong_pingjia'; //控制器
        $this->viewfolder = 'manage.huodong.pingjia'; //视图路径
        $this->dbname = 'activity_signup';

        $this->j['nav'] = 'huodong';
        $this->j['currentcontroller'] = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $this->j = array_merge($this->j, $request->j);
        $this->activity = $this->j['activity'];

        $rules = array(
            'title' => 'string|between:1,20',
            'appraise' => 'nullable|integer|in:1,2,3,4,5'
        );

        $attributes = array(
            "title" => '活动名称'
        );

        $message = array(
        );

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        $search['title'] = $request->title;
        $search['appraise'] = $request->appraise;

        $search['currentstatus'] = $request->currentstatus;

        $this->j['search'] = $search;




        $list = DB::table($this->dbname)
                ->where('activityic', $this->activity->ic)
                ->where('auditstatus', 'pass')
                ->where('appraise', '>', 0)
                //->where('isdel', 0)
                ->where(function($query) use($search) {
                    if ('' != $search['appraise']) {
                        $query->where('appraise', $search['appraise']);
                    }
//                    if ('' != $search['title']) {
//                        $query->where('title', 'like', '%' . $search['title'] . '%');
//                    }
//                    if ('' != $search['currentstatus']) {
//                        $query->where('currentstatus', '=', $search['currentstatus']);
//                    }
                })
                ->leftjoin('students', 'activity_signup.ucode', '=', 'students.mycode')
                ->select('activity_signup.*', 'students.realname', 'students.dname as dname', 'students.gender', 'students.mobile')
                // ->leftjoin('students', 'activity_signup.ucode', '=', 'students.mycode')
                // ->select('activity_signup.*', 'students.realname', 'students.dname as dname', 'students.gender', 'students.mobile')
                ->orderby('activity_signup.id', 'desc')
                ->paginate(18);

        $list->appends(['activityid' => $this->j['activity']->id]);
        $list->appends($search);
        $this->j['list'] = $list;


        /* 评价统计 */
        $l = DB::table($this->dbname)
                ->select(DB::raw('count(*) as count'), 'appraise')
                ->where('activityic', $this->activity->ic)
                ->where('auditstatus', 'pass')
                ->groupBy('appraise')
                ->get();
        $a = [];
        if (count($l) > 0) {
            foreach ($l as $v) {
                $a[$v->appraise] = $v->count;
            }
        }

        $this->j['statistics'] = $a;

        return view($this->viewfolder . '.index', ['j' => $this->j]);
    }

}
