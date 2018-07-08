<?php
/*课程报名*/
namespace App\Http\Controllers\order;

use App\Models\Adminuser;
use App\Models\User;
use App\Models\Usergroup;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use DB;

class orderController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->currentcontroller = '/order'; //控制器
        $this->viewfolder = 'order'; //视图路径
        $this->dbname = 'activity_signup';

        //$this->j['nav'] = 'huodong';
        $this->j['currentcontroller'] = $this->currentcontroller;
        

        /*检测权限*/
        //$this->checkpower();
    }
    
    //public function checkpower(){
    //    $this->j['title'] = '活动报名';
    //    return view('ajax.hastobelogin', ['j' => $this->j]);
    //}

     public function createorderactivity($id) {
        //$this->j['title'] = '报名成功';

        //$this->j['info'] = '请通过学生入口进行个人中心，查看活动进行情况';
        
        


        
        return view($this->viewfolder . '.makeactivityorder', ['j' => $this->j]);
    }
    
    
    /*活动报名*/
    public function makeorderactivity($id) {
        $this->j['title'] = '报名成功';

        $this->j['info'] = '请通过学生入口进行个人中心，查看活动进行情况';
        
        /*入库*/
//        $rules = array(
//            'title' => 'required|string|between:1,50',
//            'avtivity_year' => 'required|integer|between:2000,2090',
//            'type_oneic' => 'required|string|between:1,20',
//            'type_twoic' => 'required|string|between:1,20',
//            'mylevel' => 'required|string|between:1,20',
//            'mytimelong' => 'required|integer|between:1,64',
//            'plantime_one' => 'required|date',
//            'plantime_two' => 'required|date',
//            'signuptime_one' => 'required|date',
//            'signuptime_two' => 'required|date',
//            'sponsor' => 'required|string|between:1,20',
//            'myplace' => 'required|string|between:1,50',
//            'readme' => 'required|string|between:1,255',
//            'homework' => 'accepted:0,1',
//            'homeworktime_one' => 'required_with:homework|date',
//            'homeworktime_two' => 'required_with:homework|date',
//            'mywayic' => 'required|in:direct,audit',
//            'signlimit' => 'required_if:mywayic,accept',
//            'other' => 'string|between:1,255',
//            'attachmentsurl' => 'string|between:1,255'
//        );
//
//        $attributes = array(
//            'title' => '名称',
//            'avtivity_year' => '学年',
//            'type_oneic' => '一级活动类型',
//            'type_twoic' => '二级活动类型',
//            'mylevel' => '活动级别',
//            'mytimelong' => '活动时长',
//            'plantime_one' => '活动开始时间',
//            'plantime_two' => '活动结束时间',
//            'signuptime_one' => '报名开始时间',
//            'signuptime_two' => '报名结束时间',
//            'sponsor' => '主办单位',
//            'myplace' => '活动地点',
//            'readme' => '活动介绍',
//            'homework' => '是否需要提交作业',
//            'homeworktime_one' => '提交作业开始时间',
//            'homeworktime_two' => '提交作业结止时间',
//            'mywayic' => '报名方式',
//            'signlimit' => '报名人数限制',
//            'other' => '备注',
//            'attachmentsurl' => '附件路径'
//        );
//
//        $validator = Validator::make(
//                        $request->all(), $rules, array(), $attributes
//        );
//
//        if ($validator->fails()) {
//            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
//        }
//
//        /* 生成活动名称 */
//        $the_activity = app('main')->getactivitytypebyic($request->type_oneic);
//        $type_onename = $the_activity->title;
//
//        $the_activity = app('main')->getactivitytypebyic($request->type_twoic);
//        $type_twoname = $the_activity->title;
//
//        /* 计算学分 * 1000 为了不要小数 */
//        $mycredit = $request->mytimelong / 16 * 1000;
//
//
//        /**/
//        $date = date("Y-m-d H:i:s", time());
//
//        $rs['title'] = $request->title;
//        $rs['avtivity_year'] = $request->avtivity_year;
//        $rs['type_oneic'] = $request->type_oneic;
//        $rs['type_twoic'] = $request->type_twoic;
//        $rs['type_onename'] = $type_onename;
//        $rs['type_twoname'] = $type_twoname;
//
//
//        $rs['mylevel'] = $request->mylevel;
//        $rs['mytimelong'] = $request->mytimelong;
//        $rs['mycredit'] = $mycredit;
//        $rs['plantime_one'] = $request->plantime_one;
//        $rs['plantime_two'] = $request->plantime_two;
//
//
//        $rs['signuptime_one'] = $request->signuptime_one;
//        $rs['signuptime_two'] = $request->signuptime_two;
//        $rs['sponsor'] = $request->sponsor;
//        $rs['myplace'] = $request->myplace;
//
//
//        $rs['readme'] = $request->readme;
//        $rs['homework'] = $request->homework;
//        $rs['homeworktime_one'] = $request->homeworktime_one;
//        $rs['homeworktime_two'] = $request->homeworktime_two;
//
//        $rs['mywayic'] = $request->mywayic;
//        $rs['signlimit'] = $request->signlimit;
//        $rs['other'] = $request->other;
//        $rs['attachmentsurl'] = $request->attachmentsurl;
//
//
//
//        $rs['isopen'] = 0;
//        $rs['sucode'] = '';
//        $rs['suname'] = '';
//        $rs['auditstatus'] = 'new';
//        $rs['signcode'] = app('main')->makecode('stack');
//
//        $rs['currentstatus'] = 'new';
//        $rs['created_at'] = $date;
//
//        if (DB::table($this->dbname)->insert($rs)) {
//            $suctip[] = '<a href = "' . $this->currentcontroller . '">返回活动管理</a>';
//            return ( app('main')->jssuccess('保存成功', $suctip));
//        } else {
//            $validator->errors()->add('error', '保存失败');
//            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
//        }

        //return redirect($this->currentcontroller);


        
        return view($this->viewfolder . '.order', ['j' => $this->j]);
    }
    
    /*课程报名*/
    public function makeordercourse($id) {


        return view($this->viewfolder . '.order', ['j' => $this->j]);
    }


}
