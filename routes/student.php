<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Route::group(['namespace' => 'student', 'prefix' => 'student', 'middleware' => ['student']], function () {

//}
//Route::group(['namespace' => 'student', 'prefix' => 'student', 'middleware' => ['student']], function () {

    Route::get('/', 'signupController@index'); //我的活动报名
    Route::resource('coursesignup', 'coursesignupController'); //我的课程报名

    Route::resource('signup', 'signupController'); //我的报名
    //Route::any('/student/details/{id}','indexController@show');

    Route::resource('huodonglishi', 'lishiController'); //我的活动
    Route::resource('kechenglishi', 'courselishiController'); //我的课程

    /* 交作业 */
    Route::get('huodonglishi/{id}/homework', 'lishiController@homework');
    Route::post('huodonglishi/{id}/homework', 'lishiController@dohomework');

    /* 课程交作业 */
    Route::get('kechenglishi/{id}/homework', 'courselishiController@homework');
    Route::post('kechenglishi/{id}/homework', 'courselishiController@dohomework');


    /* 活动评价 */
    Route::get('huodonglishi/{id}/appraise', 'lishiController@appraise');
    Route::post('huodonglishi/{id}/appraise', 'lishiController@doappraise');

    /* 课程评价 */
    Route::get('kechenglishi/{id}/appraise', 'courselishiController@appraise');
    Route::post('kechenglishi/{id}/appraise', 'courselishiController@doappraise');

    //Route::resource('kecheng', 'kechengController');
    //Route::resource('kechenglishi', 'kechenglishiController');
    Route::resource('xwrongyu', 'xwrongyuController'); //校外荣誉

    /* 校内荣誉 */
    Route::resource('myinnerhonor', 'myinnerhonorController'); //校外荣誉


    /* 履职修业 */
    Route::resource('myperform', 'myperformController');



    Route::get('xinxi', 'xinxiController@index'); //查看个人信息
    Route::get('xuefen', 'xuefenController@index'); //查看我的学分

    Route::get('xuefen/xuefen_print', 'xuefenController@printxuefen'); //打印我的学分


    /* ============================= */
    /* 个人信息 */
    Route::get('pass', 'passController@index');
    Route::post('pass', 'passController@store');
});
