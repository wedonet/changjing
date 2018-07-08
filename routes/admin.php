<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */



Route::group(['namespace' => 'admin', 'prefix' => 'adminconsole', 'middleware' => ['admin']], function () {
    Route::get('/', 'indexController@index');

    /* 部门 */
    Route::resource('department', 'departmentController'); //部门管理
    Route::get('department_fq/{id}', 'departmentController@formfq'); //修改发起人
    Route::post('department_fq/{id}', 'departmentController@savefq'); //保存发起人
    Route::get('department_sh/{id}', 'departmentController@formsh'); //修改审核人
    Route::post('department_sh/{id}', 'departmentController@savesh'); //保存审核人
    Route::get('department_createfq',  'departmentController@createfq'); //添加默认发起账户


    Route::resource('teacher', 'teacherController'); //教师管理
    Route::post('teacher_savepass', 'teacherController@savepass'); //
    Route::get('teacher_import', 'teacherController@import'); //导入教师
    Route::post('teacher_import', 'teacherController@doimport'); //导入教师
    
    Route::post('fudao_import', 'teacherController@doimportfudao'); //导入辅导员


    Route::resource('student', 'studentController'); //学生管理
    Route::get('student_import', 'studentController@import'); //导入学生
    Route::post('student_import', 'studentController@doimport'); //执行导入学生
    Route::post('student_savepass', 'studentController@savepass');
    Route::any('student/daoru', 'studentController@daoru');

//Route::resource('yuanxi', 'yuanxiController'); //院系管理
//Route::resource('student', 'studentController'); //学生管理
//Route::resource('qiantou', 'qiantouController'); //牵头
//Route::resource('guanli', 'guanliController'); //

    Route::resource('huodongleixing', 'huodongleixingController'); //
    Route::resource('huodongleixing_2', 'huodongleixing_2Controller'); //


    Route::resource('banji', 'banjiController'); //班级管理
    Route::resource('yujing', 'yujingController'); //预警管理


    /* 活动管理 */
    Route::resource('huodong', 'huodongController'); //
    Route::get('huodong_export', 'huodongController@export'); //

    /* 活动审核 aid : activityid */
    Route::group(['prefix' => 'huodong_shenhe', 'middleware' => ['getactivity']], function () {
        Route::get('/', 'huodong_shenheController@index');
        Route::get('/export', 'huodong_shenheController@export'); //导出
    });
    /* 签到 */
    Route::group(['prefix' => 'huodong_qiandao', 'middleware' => ['getactivity']], function () {
        Route::get('{aid}', 'huodong_qiandaoController@index');
        Route::get('{aid}/export', 'huodong_qiandaoController@export');
    });
    /* 作业 */
    Route::group(['prefix' => 'huodong_zuoye', 'middleware' => ['getactivity']], function () {
        Route::get('{aid}', 'huodong_zuoyeController@index');
        Route::get('{aid}/export', 'huodong_zuoyeController@export');
    });

    /* 学分 */
    Route::group(['prefix' => 'huodong_xuefen', 'middleware' => ['getactivity']], function () {
        Route::get('{aid}', 'huodong_xuefenController@index');
        Route::get('{aid}/export', 'huodong_xuefenController@export');
    });
    /* 活动 */
    //Route::get('huodong_shenhe/{aid}', 'huodong_shenheController@index')->middleware(['getactivity']);
    //Route::get('huodong_shenhe/{aid}/show/{id}', 'huodong_shenheController@show'); //查看活动报名
    //Route::post('huodong_shenhe/{aid}/dopass/{id}', 'huodong_shenheController@dopass'); //审核通过
    //Route::get('huodong_shenhe/{aid}/unpass/{id}', 'huodong_shenheController@unpass'); //审核未通过表单
    //Route::post('huodong_shenhe/{aid}/unpass/{id}', 'huodong_shenheController@dounpass'); //执行审核未通过
    //Route::post('huodong_shenhe/{aid}/allpass', 'huodong_shenheController@allpass'); //批量审核
    //Route::get('shenhe_daochu/{ic}', 'huodong_shenheController@daochu'); //批量导出
    //Route::get('huodong_qiandao/{aid}', 'huodong_qiandaoController@index')->middleware(['getactivity']);
    //Route::get('qiandao/{ic}', 'qiandaoController@qiandao'); //签到列表生码
    //Route::get('qiantui/{ic}', 'qiandaoController@qiantui'); //签退列表生码
    //Route::get('huodong_qiandao/{aid}/signin/{id}', 'huodong_qiandaoController@dosignin'); //执行签到
    //Route::get('huodong_qiandao/{aid}/signout/{id}', 'huodong_qiandaoController@dosignout'); //执行签退
    //Route::get('qiandao_daochu/{ic}', 'huodong_qiandaoController@daochu'); //签到人员批量导出
    //Route::get('huodong_zuoye/{aid}', 'huodong_zuoyeController@index');
    //Route::get('huodong_zuoye/{aid}/dopass/{id}', 'huodong_zuoyeController@dopass'); //作业通过
    //Route::get('huodong_zuoye/{aid}/unpass/{id}', 'huodong_zuoyeController@unpass'); //作业未通过表单
    //Route::post('huodong_zuoye/{aid}/unpass/{id}', 'huodong_zuoyeController@dounpass'); //作业未通过
    //Route::get('zuoye_daochu/{ic}', 'huodong_zuoyeController@daochu'); //上交作业记录批量导出
    //    
    //Route::('huodong_zuoye/{id}', 'huodong_zuoyeController@show');

    /* 学分 */
    //Route::get('huodong_xuefen/{aid}', 'huodong_xuefenController@index');
    //Route::get('huodong_xuefen/{aid}/pass/{id}', 'huodong_xuefenController@formpass'); //学分通过表单
    //Route::post('huodong_xuefen/{aid}/pass/{id}', 'huodong_xuefenController@dopass'); //学分通过
    //Route::get('huodong_xuefen/{aid}/unpass/{id}', 'huodong_xuefenController@formunpass'); //学分未通过表单
    //Route::post('huodong_xuefen/{aid}/unpass/{id}', 'huodong_xuefenController@dounpass'); //学分未通过
    //Route::get('xuefen_daochu/{ic}', 'huodong_xuefenController@daochu'); //学分记录批量导出
    //
    //Route::get('huodong_xuefen/{id}', 'huodong_xuefenController@show');
    
        /* 课程管理 */
    Route::resource('course', 'courseController'); //
    Route::get('course_export', 'courseController@export'); //
    /* 教师对学生上课的管理 */
    Route::group(['middleware' => ['getcourse']], function () {
        Route::resource('kaikeshijian', 'kaikeshijianController');

        /* 审核 */
        Route::get('course_shenhe', 'course_shenheController@index'); //查看报名



        Route::get('course_qiandao', 'course_qiandaoController@index'); //签到列表
        Route::get('course_qiandao2', 'course_qiandaoController@classqiandao'); //签到列表     

        /* 作业 */
        Route::get('course_zuoye', 'course_zuoyeController@index');

        /* 学分 */
        Route::get('course_xuefen', 'course_xuefenController@index');     
        Route::get('course_pingjia', 'course_pingjiaController@index'); //课程评价
    });
    
     /* 校外荣誉管理 */
    Route::resource('outerhonor', 'outerhonorController');

    /* 校内荣誉管理 */
    Route::resource('innerhonor', 'innerhonorController');
    Route::get('innerhonor/{id}/student', 'innerhonorController@student');

    /* 履职修业管理 */
    Route::resource('perform', 'performController');

    

    Route::get('huodong_pingjia/{aid}', 'huodong_pingjiaController@index')->middleware(['getactivity']);
    
    
    /*=============================*/
    /*个人信息*/
    Route::get('pass', 'passController@index');
    Route::post('pass', 'passController@store');
    
    
    
    
//Route::get('huodong_pingjia/{id}', 'huodong_pingjiaController@show');    
});
