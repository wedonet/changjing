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

//Route::group(['namespace' => '/', 'middleware' => ['homepage']], function(){
Route::get('/', 'HomePageController@index');  //网站首页，查看活动
Route::get('/activity/detail/{id}', 'HomePageConsole\activityController@show'); 

Route::get('/activity/{id}/order', 'HomePageConsole\activityController@formorder')->middleware(['student']); //报名form
Route::post('/activity/save', 'HomePageConsole\activityController@store')->middleware(['student']); //保存报名
;
Route::get('/course', 'courseController@index');  //查看课程
Route::get('/course/detail/{id}', 'courseController@show'); 
Route::get('/course/{id}/order', 'courseorderController@formorder')->middleware(['student']); //报名form
Route::post('/course/save', 'courseorderController@store')->middleware(['student']); //保存报名
//});

/* 学生登录 */
Route::get('/login', 'loginController@index');
Route::post('/login', 'loginController@dologin');
Route::get('/studentchangepass', 'login\studentchangepassController@index'); //首次登录修改密码页
Route::post('/studentchangepass', 'login\studentchangepassController@dochange'); //修改密码操作
Route::get('/login/studentfindpass', 'login\studentfindpassController@findpass'); //学生找回密码
Route::post('/login/studentfindpass', 'login\studentfindpassController@findpass_do'); //学生找回密码

Route::get('/login/studentfindpass_setpass', 'login\studentfindpassController@studentfindpass_setpass'); //学生重设密码
Route::post('/login/studentfindpass_setpass', 'login\studentfindpassController@studentfindpass_setpass_do'); //学生重设密码


Route::get('/loginout', 'loginoutController@index');


/* 教师登录 */
//Route::get('/managelogin', 'manageloginController@index');
//Route::get('/managelogin', 'manageloginController@index');
//Route::post('/managelogin', 'manageloginController@dologin');

/* 管理员登录 */
//Route::get('/adminlogin', 'adminloginController@index');
//Route::post('/adminlogin', 'adminloginController@dologin');
//Route::get('/activity/order/{id}', [
//   'middleware' => 'hastobelogin',
//   '/activity/order/{id}' => 'orderController@makeorderactivity'
//]);
//Route::get('/activity/order/{id}','order\orderController@createorderactivity')->middleware(['hastobelogin']);
//Route::post('/activity/order/{id}','order\orderController@saveorderactivity')->middleware(['hastobelogin']);

Route::get('/course/order/{id}', 'order\orderController@makeordercourse'); //课程报名

Route::get('/papi', 'papiController@index'); // public api

Route::post('/uploadfile', 'uploadController@index'); //上传
Route::post('/ckupload', 'ckuploadController@index'); //ckeditor上传
//Route::get('/getprogress', 'uploadController@getprogress');
//Route::any('/uploadexecel', 'uploadController@index');
//Route::any('/uploadimage', 'uploadController@index');
//Route::post('/uploadexecel', 'uploadController@index');


Route::get('/download', 'downloadController@index'); //下载作业
Route::get('/downattach', 'downattachController@index'); //下载活动附件
Route::get('/down', 'normaldownController@index'); //下载通用附件

Route::get('/test', 'testController@index');
Route::get('/password', 'test\hashtest@password');
Route::get('/testupload', 'testController@upload');
Route::post('/testupload', 'testController@doupload');
//Route::get('/getprogress', 'testController@getprogress');


Route::get('/showerr', 'showerrController@index');







Route::get('/managelogin', 'manageloginController@index');
Route::post('/managelogin', 'manageloginController@dologin');
Route::get('/managechangepass', 'managechangepassController@index'); //首次登录修改密码页
Route::post('/managechangepass', 'managechangepassController@dochange'); //修改密码操作

/* 学生活动签到 */

Route::get('/signin/{ic}', 'signController@signin'); //签到页面
Route::get('/signout/{ic}', 'signController@signout'); //签退页面
Route::post('/dosignin', 'signController@dosignin'); //执行签到页面
Route::post('/dosignout', 'signController@dosignout'); //执行签推页面

/* 学生课程签到签退 */
Route::get('/coursesignin/{code}', 'coursesignController@formsignin'); //签到页面
Route::get('/coursesignout/{code}', 'coursesignController@formsignout'); //签退页面
Route::post('/coursedosignin', 'coursesignController@dosignin'); //执行签到页面
Route::post('/coursedosignout', 'coursesignController@dosignout'); //执行签推页面



Route::get('/adminlogin', 'adminloginController@index');
Route::post('/adminlogin', 'adminloginController@dologin');


Route::get('/confirm', 'ajax\confirmController@index');

Route::get('/phpinfo_', 'phpinfoController@index');


Route::get('/testerrorpage', 'testerrorpageController@index');


Route::get('captcha', 'captchaController@index'); //验证码


Route::get('/update/fudaodepartment', 'update\updateController@index'); //更新课程中的辅导员


Route::get('mytest', 'mytestController@index'); //测试代码片断用