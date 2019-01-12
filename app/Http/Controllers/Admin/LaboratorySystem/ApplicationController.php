<?php

namespace App\Http\Controllers\Admin\LaboratorySystem;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//后台申请控制器
class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.LaboratorySystem.application');
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

    public function store(Request $request)
    {

            //获取申请的结果集
            $data = $request->input('obj');

            //检测数据表中有没有该课程，没有的话则执行插入操作 Cannot use object of type stdClass as array
            $coure = \DB::table('course')->where('name',$data['name'])->get();
            if(!$coure->count()){
                \DB::table('course')->insert(['name'=>$data['name'],'count'=>1]);
            }

//            dd($data);
            //检测实验室使用的时间段是否冲突
            $oldDate = \DB::table('task')->where('_token',$data['_token'])->get();
//            dd($oldDate->count());
//            dd($oldDate);
            if($oldDate->count() == 0){
                //查询课程ID
                $newCoure = \DB::table('course')->where('name',$data['name'])->first();

                $arr = array(
                    'time' => $data['time'],
                    'week1' => $data['week1'],
                    'week2' => $data['week2'],
                    'session' => $data['session'],
                    'types' => 1,
                    'teachername' => $data['teachername'],
                    'coursename' => $newCoure->id,
                    'classname' => $data['classname'],
                    'content' => $data['content'],
                    '_token' => $data['_token'],
                    'laboratory'=> 10
                );

                $taskDate = \DB::table('task')->insert($arr);

                //修改申请信息状态
                \DB::table('application')->where('id',$data['id'])->update(['status'=>1]);

                //修改课程次数
                \DB::table('course')->where('id',$newCoure->id)->update(['count'=>++$newCoure->count]);

                //修改老师的上课次数
                $adminClasses = \DB::table('admin')->where('id',$data['teachername'])->first();
                \DB::table('admin')->where('id',$data['teachername'])->update(['classes'=>++$adminClasses->classes]);

                //修改班级的上课次数
                $classCount = \DB::table('class')->where('id',$data['classname'])->first();
                \DB::table('class')->where('id',$data['classname'])->update(['count'=>++$classCount->count]);

                //修改实验室的使用次数
//                $lbCount = \DB::table('laboratory')->where('id',$data['laboratory'])->first();
//                \DB::table('laboratory')->where('id',$data['laboratory'])->update(['count'=>++$lbCount->count]);

                return $arr ? 1 : 0;

            }else{
                return "实训室的使用时间有冲突";
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //返回修改申请信息
    public function show($id)
    {
        //
        $data = \DB::table('application')->where("id",$id)->get();

//        $_token = $data['time'] . $data['week1'];

        return $data;

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
//        dd($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //接收需要修改的数据
    public function update(Request $request, $id)
    {
        //

//      表单数据 2018/09/01-2019/01/125星期五7-814计算机实训室14
        $data = $request->input('data');
        $data['laboratory'] = 1;
        //判断实验室是否为空
        if(!is_null($data['laboratory'])){

            //拼接session
            $token = $data['time'] . $data['week1'] . $data['week2'] .$data['session'] . $data['laboratory'];

            //查询对应的课程
            $coure = \DB::table('course')->where('name',$data['name'])->first();

            //组装需要添加的数据
            $arr = array(
                'time' => $data['time'],
                'week1' => $data['week1'],
                'week2' => $data['week2'],
                'session' => $data['session'],
                'types' => $data['types'],
                'teachername' => $data['teachername'],
                'coursename' => $coure->id,
                'classname' => $data['classname'],
                'content' => $data['content'],
                '_token' => $token,
                'laboratory'=> $data['laboratory']
            );

            $newArr = \DB::table('task')->insert($arr);

            //修改申请信息状态
            \DB::table('application')->where('id',$data['id'])->update(['status'=>1]);

            //修改课程次数
            \DB::table('course')->where('id',$coure->id)->update(['count'=>++$coure->count]);

            //修改老师的上课次数
            $adminClasses = \DB::table('admin')->where('id',$data['teachername'])->first();
            \DB::table('admin')->where('id',$data['teachername'])->update(['classes'=>++$adminClasses->classes]);

            //修改班级的上课次数
            $classCount = \DB::table('class')->where('id',$data['classname'])->first();
            \DB::table('class')->where('id',$data['classname'])->update(['count'=>++$classCount->count]);

            //修改实验室使用次数
            $laboratory = \DB::table('laboratory')->where('id',$data['laboratory'])->first();
            \DB::table('laboratory')->where('id',$data['laboratory'])->update(['count'=>++$laboratory->count]);
//            dd($laboratory);
            return $newArr ? 1 : 0;

        }else{
            return '实验室不能为空';
        }


        //实验室数据
//        $lb = \DB::table('laboratory')->where('id',$data['laboratory'])->first();
        //令牌
//        $_token = $data['time'] . $data['week1'] . $data['week2'] .$data['session'];
//        //任务
//        $task = \DB::table('task')->where('_token',$_token)->get();
//
//        if(!$task->count()){
//
//            //存储新的令牌
//            $data['_token'] = $_token;
//            $data['laboratory'] = 1;
//            $res = \DB::table('application')->where('id',$id)->update($data);
//
//            return $res;
//        }else{
//            echo "与该实验室的使用时间冲突";
//        }
//        return $_token;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //申请不通过
    public function destroy($id)
    {
        //
//        return $id;
        $data = \DB::table('application')->where('id',$id)->update(['status' => -1]);
        return $data;
    }

    //返回申请信息
    public function appyDate(){

        $adminId = session('gxsdmznAdminUserInfo.id');
        $data = \DB::table('application')
            ->select('application.*','class.className','admin.name as tname')
            ->join('class','class.id','=','application.classname')
            ->join('admin','admin.id','=','application.teachername')
            ->orderBy('apptime','asc')->get();
        foreach ($data as $val){
            $val->apptime = date('Y-m-d H:i:s',$val->apptime);
        }
        return $data;
    }

    //返回实验室信息
    public function getLaboratory(){

//        $lb = \DB::table('laboratory')->get();
        $token =$_GET['time'] . $_GET['week1'] . $_GET['week2'] . $_GET['session'];

        $task = \DB::table('task')->where('_token','like','%'.$token.'%')->get();



//        dd($token);
        return $token;

    }

}
