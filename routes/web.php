<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//前台路由路由
//渲染前端数据
Route::get('home','Home\IndexController@frontEndDate');
Route::get('home/look/{id}','Home\IndexController@look');
Route::get('home/teacher','Home\IndexController@teacherDate');
Route::get('/', 'Home\IndexController@index');




//登陆路由
Route::get('admin/login','Admin\LoginController@index');

//验证码
Route::get('admin/login/yzm','Admin\LoginController@code');

//登录验证
Route::post('admin/login/check','Admin\LoginController@check');

//退出登录
Route::get('admin/login/logout','Admin\LoginController@logout');

//找回密码
Route::get('admin/retrieve','Admin\LoginController@retrieve');

//发送邮件
Route::post('admin/send','Admin\LoginController@send');



//后台路由组 提取公共的前缀，并引入中间件，限制权限
Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>'adminLogin'],function (){

    //后台侧边栏导航
    Route::get('appList','RootController@appList');
    Route::get('/', 'RootController@index');

    //课程管理
    Route::get('LaboratorySystem/course/courseJson','LaboratorySystem\CourseController@courseJson');
    Route::any('LaboratorySystem/course/impExcel','LaboratorySystem\CourseController@impExcel');
    Route::post('LaboratorySystem/course/deletion','LaboratorySystem\CourseController@deletion');       //批量删除
    Route::resource('LaboratorySystem/course','LaboratorySystem\CourseController');

    //实验室管理
    Route::get('LaboratorySystem/lb/labtypesApi','LaboratorySystem\LdController@labtypesApi');          //返回实验室数据
    Route::post('LaboratorySystem/lb/labtypesApi/deletion','LaboratorySystem\LdController@deletion');   //批量删除
    Route::any('LaboratorySystem/lb/labtypesApi/impExcel','LaboratorySystem\LdController@impExcel');    //导入Excel
    Route::post('LaboratorySystem/lb/search','LaboratorySystem\LdController@search');
    Route::resource('LaboratorySystem/lb','LaboratorySystem\LdController');



    //后台数据维护路由 Array to string conversion
    Route::get('LaboratorySystem/index','LaboratorySystem\DataController@index');
    Route::get('LaboratorySystem/getJson','LaboratorySystem\DataController@getJson');


    //班级资料
    Route::get('LaboratorySystem/class/getJson','LaboratorySystem\ClassController@classDate');
    Route::any('LaboratorySystem/class/impExcel','LaboratorySystem\ClassController@impExcel');         //导入班级Excel表
    Route::get('LaboratorySystem/class/getTime','LaboratorySystem\ClassController@getTime');          //返回学期数据
    Route::post('LaboratorySystem/class/deletion','LaboratorySystem\ClassController@deletion');       //批量删除
    Route::resource('LaboratorySystem/class','LaboratorySystem\ClassController');


    //教师资料
    Route::get('LaboratorySystem/teacher/getJson','LaboratorySystem\TeacherController@teacherData');
    Route::post('LaboratorySystem/teacher/deletion','LaboratorySystem\TeacherController@deletion');       //批量删除
    Route::any('LaboratorySystem/teacher/impExcel','LaboratorySystem\TeacherController@impExcel');
    Route::resource('LaboratorySystem/teacher','LaboratorySystem\TeacherController');


    //数据录入
    Route::get('LaboratorySystem/dataInput/lbApi','LaboratorySystem\DataInputController@lbApi');                            //实验室参数数据返回
    Route::post('LaboratorySystem/dataInput/sTime','LaboratorySystem\DataInputController@sTime');                           //添加开学时间
    Route::get('LaboratorySystem/dataInput/getTime','LaboratorySystem\DataInputController@getTime');                        //返回开学时间数据
    Route::get('LaboratorySystem/dataInput/inputDel/{id}/{order}','LaboratorySystem\DataInputController@inputDel');         //所有列表的删除功能
    Route::get('LaboratorySystem/dataInput/inputDel/inputData','LaboratorySystem\DataInputController@inputData');           //查询下拉列表的数据
    Route::post('LaboratorySystem/dataInput/inputDel/course','LaboratorySystem\DataInputController@courseAdd');             //添加任务
    Route::get('LaboratorySystem/dataInput/inputDel/courseList','LaboratorySystem\DataInputController@courseTaskList');     //任务数据
    Route::resource('LaboratorySystem/dataInput','LaboratorySystem\DataInputController');


    //数据展示
    Route::any('LaboratorySystem/datalist/import','LaboratorySystem\DataListController@import');    //导入功能
    Route::get('LaboratorySystem/datalist/expExcel','LaboratorySystem\DataListController@expExcel');   //导出功能
    Route::get('LaboratorySystem/datalist','LaboratorySystem\DataListController@index');
    Route::get('LaboratorySystem/getJson2','LaboratorySystem\DataListController@getJson');          //返回json数据

    //首页数据接口
    Route::get('LaboratorySystem/getJsonIndex','LaboratorySystem\DataController@getJson');


    //后台申请
    Route::get('LaboratorySystem/application/getDate','LaboratorySystem\ApplicationController@appyDate');
    Route::get('LaboratorySystem/application/getLaboratory','LaboratorySystem\ApplicationController@getLaboratory');
    Route::resource('LaboratorySystem/application','LaboratorySystem\ApplicationController');


    //后台用户
    Route::get('UserName/index/getDate','UserName\UserController@tableData');       //我的安排
    Route::resource('UserName/index','UserName\UserController');                    //用户路由

    //我的申请  Application
    Route::get('UserName/application/appyGet','UserName\ApplicationController@appyDate');               //用户的申请数据
    Route::get('UserName/application/getSelectedDate','UserName\ApplicationController@selectedDate');   //最新时间
    Route::get('UserName/application/getCurse','UserName\ApplicationController@getCurse');              //最新课程
    Route::resource('UserName/application','UserName\ApplicationController');

    //我的班级
    Route::get('UserName/myClass/getDate','UserName\MyClassController@myClassDate');
    Route::resource('UserName/myClass','UserName\MyClassController');


    //密码修改
    Route::resource('UserName/changePassword','UserName\ChangePassController');

});

















