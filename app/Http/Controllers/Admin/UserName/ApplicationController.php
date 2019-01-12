<?php

namespace App\Http\Controllers\Admin\UserName;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//我的申请控制器
class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //加载我的申请模板
    public function index()
    {
        //
        return view('admin.User.application');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //添加申请信息
    public function store(Request $request)
    {
        //规则
        $data = $request->input('obj');
        $rule = [
            'name' => 'required',
            'classname' => 'required'
        ];
//
        $message = [
            'name.required'=> '课程名称不能为空',
            'classname.required'=> '班级名不能为空'
        ];

        $validator = \Validator::make($data,$rule,$message);

        if($validator->passes()){
            $data['status'] = 0;
            $data['apptime'] = time();
            $data['_token'] = $data['time'] . $data['week1'] . $data['week2'] . $data['session'];
            $rel = \DB::table('application')->insert($data);
            return $rel ? 1 : 0;

        }else{
            return $validator->getMessageBag();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //取消申请
    public function destroy($id)
    {
        //
//        return $id;
        $data = \DB::table('application')->where('id',$id)->delete();
        return $data;
    }

    //展示申请数据
    public function appyDate(){

        $adminId = session('gxsdmznAdminUserInfo.id');
        $data = \DB::table('application')
                ->where('teachername',$adminId)
                ->select('application.*','class.className')
                ->join('class','class.id','=','application.classname')
                ->get();

//        dd($data);
        foreach ($data as $key=>$val){
            $val->apptime = date('Y-m-d H:i:s',$val->apptime);
        }
        return $data;
    }

    //返回最新时间
    public function selectedDate(){
        $row['class'] = \DB::table('class')->get();
        $row['course'] = \DB::table('course')->get();
        $time = \DB::table('termtime')->orderBy('id','desc')->first();
        $row['theTime'] = date('Y/m/d',$time->start) .'-' . date('Y/m/d',$time->end);
        return $row;
    }

    //返回课程信息
    public function getCurse(){

//        $myCures = $_GET['cures'];
        $userId = (int)$_GET['id'];

//        dd($userId);

//        if($myCures == 'true'){
//            $course = \DB::table('task')
//                ->where('teachername',$userId)
//                ->select('task.*','course.*')
//                ->join('course','course.id','=','task.classname')
//                ->groupBy('course.name')
//                ->get();
//
//            return $course;
//        }else{
//            return $course = \DB::table('course')->get();
//        }
        $data['myCurse'] =  $course = \DB::table('task')
                            ->where('teachername',$userId)
                            ->select('task.*','course.*')
                            ->join('course','course.id','=','task.classname')
                            ->groupBy('course.name')
                            ->get();

        $data['publicCurse'] = \DB::table('course')->get();
//        dd($data);
        return $data;
    }
}
