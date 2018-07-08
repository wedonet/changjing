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



Route::group(['namespace' => 'manage', 'prefix' => 'manage', 'middleware' => 'manage'], function () {
    Route::get('/', 'indexController@index');

    /* 发起和编辑活动 */
    Route::resource('huodong', 'huodongController');
    Route::get('huodong/{id}/reason', 'huodongController@reason'); //查看活动未通过原因 
    Route::post('huodong/{id}/isopen', 'huodongController@doopen'); //开通活动
    Route::post('huodong/{id}/unopen', 'huodongController@dounopen'); //关闭活动


    /* 发起和编辑课程 */
    Route::resource('course', 'courseController'); //我发起的课程
    Route::post('course/{id}/isopen', 'courseController@doopen'); //开通课程
    Route::post('course/{id}/unopen', 'courseController@dounopen'); //关闭课程
//        Route::get('kecheng/{id}/reason', 'kechengController@reason'); //查看活动未通过原因 
//
//        //
//        // Route::get('kecheng_guanbi/{id}', 'kechengController@guanbi');
//        Route::any('wenjiandaoru', 'kechengController@daoru');


    /* 签头部门活动审核 */
    Route::resource('qiantou', 'qiantouController');  //活动审核
    Route::post('qiantou/{id}/dopass', 'qiantouController@dopass'); //审核通过
    Route::get('qiantou/{id}/unpass', 'qiantouController@formunpass'); //审核未通过form
    Route::post('qiantou/{id}/unpass', 'qiantouController@dounpass'); //审核执行未通过


    /* 教师对学生活动的管理 */

    Route::group(['middleware' => 'getactivity'], function () {

        /* 审核，签到，作业，评价 */
        Route::get('huodong_shenhe', 'huodong_shenheController@index');

        Route::post('huodong_shenhe/{id}/dopass', 'huodong_shenheController@dopass'); //审核通过
        Route::get('huodong_shenhe/{id}/unpass', 'huodong_shenheController@unpass'); //审核未通过表单
        Route::post('huodong_shenhe/{id}/unpass', 'huodong_shenheController@dounpass'); //执行审核未通过

        Route::any('huodong_shenhe/allpass', 'huodong_shenheController@allpass'); //批量审核
        Route::get('huodong_shenhe/exporttemplate', 'huodong_shenheController@exporttemplate'); //下载报名模板  
        Route::get('huodong_shenhe/export', 'huodong_shenheController@export'); //批量导出   
        Route::get('huodong_shenhe/import', 'huodong_shenheController@import'); //导入报名页
        Route::post('huodong_shenhe/import', 'huodong_shenheController@doimport'); //执行导入 
        /**/
        Route::get('huodong_qiandao', 'huodong_qiandaoController@index'); //签到列表
        Route::get('qiandao/{id}', 'qiandaoController@qiandao'); //签到列表生码
        Route::get('qiantui/{id}', 'qiandaoController@qiantui'); //签退列表生码
        /**/
        Route::get('huodong_qiandao/{id}/signin', 'huodong_qiandaoController@dosignin'); //执行签到
        Route::get('huodong_qiandao/{id}/signout', 'huodong_qiandaoController@dosignout'); //执行签退
        Route::get('huodong_qiandao/export_', 'huodong_qiandaoController@daochu'); //签到人员批量导出
        Route::post('huodong_qiandao/batchsignin_', 'huodong_qiandaoController@batchsignin'); //批量签到 
        Route::get('huodong_qiandao/count', 'huodong_qiandaoController@recount_do'); //签到统计
//
//
//        /**/
        Route::get('huodong_zuoye', 'huodong_zuoyeController@index');
        Route::get('huodong_zuoye/{id}/dopass_', 'huodong_zuoyeController@dopass'); //作业通过
        Route::get('huodong_zuoye/{id}/unpass_', 'huodong_zuoyeController@unpass'); //作业未通过表单
        Route::post('huodong_zuoye/{id}/unpass_', 'huodong_zuoyeController@dounpass'); //作业未通过
        Route::get('huodong_zuoye/{id}/export', 'huodong_zuoyeController@export'); //上交作业记录批量导出
        Route::post('huodong_zuoye/{id}/allpass', 'huodong_zuoyeController@doallpass'); //作业批量通过
        Route::get('huodong_zuoye/{id}/allunpass', 'huodong_zuoyeController@allunpass'); //作业批量未通过表单
        Route::post('huodong_zuoye/{id}/allunpass', 'huodong_zuoyeController@doallunpass'); //作业批量未通过表单
//
//        /* 学分 */
        Route::get('huodong_xuefen', 'huodong_xuefenController@index');
        Route::get('huodong_xuefen/{id}/pass', 'huodong_xuefenController@formpass'); //学分通过表单
        Route::post('huodong_xuefen/{id}/pass', 'huodong_xuefenController@dopass'); //学分通过
        Route::get('huodong_xuefen/{id}/unpass', 'huodong_xuefenController@formunpass'); //学分未通过表单
        Route::post('huodong_xuefen/{id}/unpass', 'huodong_xuefenController@dounpass'); //学分未通过

        Route::get('huodong_xuefen/{id}/allpass', 'huodong_xuefenController@formallpass'); //学分批量通过表单
        Route::post('huodong_xuefen/{id}/allpass', 'huodong_xuefenController@doallpass'); //学分批量通过
        Route::get('huodong_xuefen/{id}/allunpass', 'huodong_xuefenController@formallunpass'); //学分批量未通过表单
        Route::post('huodong_xuefen/{id}/allunpass', 'huodong_xuefenController@doallunpass'); //学分批量未通过

        Route::get('huodong_xuefen/{id}/export', 'huodong_xuefenController@export'); //学分记录批量导出

        Route::get('huodong_pingjia', 'huodong_pingjiaController@index'); //活动评价
    });

    /* 审核，签到，作业，评价 */
    Route::resource('qiantou', 'qiantouController');

    /* 教师对学生上课的管理 */
    Route::group(['middleware' => ['getcourse']], function () {
        Route::resource('kaikeshijian', 'kaikeshijianController');

        /* 审核 */
        Route::get('course_shenhe', 'course_shenheController@index'); //查看报名
        Route::post('course_shenhe/dopass/{id}', 'course_shenheController@dopass'); //审核通过
        Route::get('course_shenhe/unpass/{id}', 'course_shenheController@unpass'); //审核未通过表单
        Route::post('course_shenhe/unpass/{id}', 'course_shenheController@dounpass'); //执行审核未通过
        Route::post('course_shenhe/allpass', 'course_shenheController@allpass'); //批量审核
        Route::get('course_shenhe/exporttemplate', 'course_shenheController@exporttemplate'); //下载报名模板  
        Route::get('course_shenhe/export', 'course_shenheController@export'); //批量导出   
        Route::get('course_shenhe/import', 'course_shenheController@import'); //导入报名页
        Route::post('course_shenhe/import', 'course_shenheController@doimport'); //执行导入 


        Route::get('course_qiandao', 'course_qiandaoController@index'); //签到列表
        Route::get('course_qiandao2', 'course_qiandaoController@classqiandao'); //签到列表
        Route::get('course_qiandao/{ucode}/signin', 'course_qiandaoController@dosignin'); //老师执行签到
        Route::post('course_qiandao/{classid}/allsignin', 'course_qiandaoController@doallsignin'); //批量签到
        Route::get('course_qiandao/{classid}/export', 'course_qiandaoController@doexport'); //导出签到信息
        //Route::get('course_qiandao/{classid}/signincode', 'course_signcodeController@signin'); //签到列表生码
        Route::get('course_qiandao/{classid}/signincode', 'course_qiandaoController@signincode'); //签到列表生码
        Route::get('coursesignoffcode/{id}', 'course_signcodeController@signoff'); //签退列表生码

        Route::get('course_qiandao/{aid}/signin/{id}', 'course_qiandaoController@dosignin'); //执行签到
        Route::get('course_qiandao/{aid}/signout/{id}', 'course_qiandaoController@dosignout'); //执行签退
        //Route::get('qiandao_daochu/{aid}', 'course_qiandaoController@daochu'); //签到人员批量导出


        /* 作业 */
        Route::get('course_zuoye', 'course_zuoyeController@index');
        Route::get('course_zuoye/{id}/dopass', 'course_zuoyeController@dopass'); //作业通过
        Route::get('course_zuoye/{id}/unpass', 'course_zuoyeController@unpass'); //作业未通过表单
        Route::post('course_zuoye/{id}/unpass', 'course_zuoyeController@dounpass'); //作业未通过
        //Route::get('kecheng_daochu/{ic}', 'huodong_zuoyeController@daochu'); //上交作业记录批量导出


        /* 学分 */
        Route::get('course_xuefen', 'course_xuefenController@index');
        Route::get('course_xuefen/{id}/pass', 'course_xuefenController@formpass'); //学分通过表单
        Route::post('course_xuefen/{id}/pass', 'course_xuefenController@dopass'); //学分通过
        Route::get('course_xuefen/{id}/unpass', 'course_xuefenController@formunpass'); //学分未通过表单
        Route::post('course_xuefen/{id}/unpass', 'course_xuefenController@dounpass'); //学分未通过
        Route::get('course_xuefen/{id}/export', 'course_xuefenController@export'); //学分记录批量导出

        Route::get('course_pingjia', 'course_pingjiaController@index'); //课程评价
    });
    //Route::resource('kaikeshijian', 'kaikeshijianController')->middleware(['getcourse']); //开课时间

    Route::resource('beishu', 'beishuController'); //备述
    Route::resource('detail', 'detailController');

    /* 牵头部门课程审核 */
    Route::resource('kaikeshenhe', 'kaikeshenheController');
    Route::post('kaikeshenhe/{id}/dopass', 'kaikeshenheController@dopass'); //审核通过
    Route::get('kaikeshenhe/{id}/unpass', 'kaikeshenheController@formunpass'); //审核未通过form
    Route::post('kaikeshenhe/{id}/unpass', 'kaikeshenheController@dounpass'); //审核执行未通过


    Route::resource('xuefen', 'xuefenController');


    /* 校外荣誉管理 */
    Route::resource('xiaowaifudao', 'xiaowaifudaoController');
    Route::post('xiaowaifudao/{id}/dopass', 'xiaowaifudaoController@dopass'); //初审通过
    Route::get('xiaowaifudao/{id}/unpass', 'xiaowaifudaoController@formunpass'); //初审未通过form
    Route::post('xiaowaifudao/{id}/unpass', 'xiaowaifudaoController@dounpass'); //初审核执行未通过
    Route::post('xiaowaifudao/{id}/dopass2', 'xiaowaifudaoController@dopass2'); //复审通过
    Route::get('xiaowaifudao/{id}/unpass2', 'xiaowaifudaoController@formunpass2'); //复审未通过form
    Route::post('xiaowaifudao/{id}/unpass2', 'xiaowaifudaoController@dounpass2'); //复审核执行未通过

    /* 校内荣誉管理 */
    Route::resource('xiaoneifudao', 'xiaoneifudaoController');
    Route::get('xiaoneifudao/{id}/student', 'xiaoneifudaoController@student')->middleware(['checkmyinnerhonor']);
    Route::post('xiaoneifudao/{id}/student', 'xiaoneifudaoController@savestudent')->middleware(['checkmyinnerhonor']);
    Route::delete('xiaoneifudao/{id}/studentdestory', 'xiaoneifudaoController@studentdestory')->middleware(['checkmyinnerhonor']);
    Route::post('xiaoneifudao/{id}/submit', 'xiaoneifudaoController@submit')->middleware(['checkmyinnerhonor']);

    /* 校内荣誉审核 */
    Route::get('xiaonei', 'xiaoneiController@index');
    Route::get('xiaonei/{id}', 'xiaoneiController@show');
    Route::post('xiaonei/{id}/dopass', 'xiaoneiController@dopass');
    Route::get('xiaonei/{id}/unpass', 'xiaoneiController@formunpass');
    Route::post('xiaonei/{id}/unpass', 'xiaoneiController@dounpass');

    /* 履职修业管理 */
    Route::get('perform', 'performController@index');
    Route::get('perform/select_', 'performController@select');
    Route::get('perform/create', 'performController@create');
    Route::get('perform/{id}', 'performController@show');
    Route::get('perform/{id}/edit', 'performController@edit');
    Route::put('perform/{id}', 'performController@update');
    Route::delete('perform/{id}', 'performController@destroy'); //删除履职
    Route::post('perform', 'performController@store');

    //
    /* 履职修业审核 */
    Route::get('sh_perform', 'sh_performController@index');
    Route::get('sh_perform/{id}/edit', 'sh_performController@edit');
    Route::put('sh_perform/{id}', 'sh_performController@update');
    Route::get('sh_perform/{id}', 'sh_performController@show');
    Route::post('sh_perform/{id}/dopass', 'sh_performController@dopass');
    Route::get('sh_perform/{id}/unpass', 'sh_performController@formunpass');
    Route::post('sh_perform/{id}/unpass', 'sh_performController@dounpass');
    
    //
    //打印学分
    Route::any('dayin/{id}', 'xuefenController@dayin');
    //学分详情
    Route::any('xuefen/xuefendetail/{id}', 'xuefenController@xuefendetail');
    //课程添加开课时间
    //Route::any('kaikeshijiancreate', 'kaikeshijianController@kaikeshijiancreate');
    
    
        /*=============================*/
    /*个人信息*/
    Route::get('pass', 'passController@index');
    Route::post('pass', 'passController@store');
});
