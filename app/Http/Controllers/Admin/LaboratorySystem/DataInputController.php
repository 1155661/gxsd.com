<?php

namespace App\Http\Controllers\Admin\LaboratorySystem;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Object_;

//数据录入控制器
class DataInputController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //加载数据输入模板
    public function index()
    {
        return view('admin.LaboratorySystem.dataInput');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //返回课程数据 Integrity constraint violation: 1052 Column 'className' in where clause is ambiguous
    public function courseTaskList(){

//        isset($_GET['s']) ? session(['search' => $_GET['s']]) : session(['search' => '']);


        $search = isset($_GET['s']) ? $_GET['s'] : '';

        if($_GET['sort'] == 'true'){
            $data = \DB::table('task')
                ->select('task.*','course.name','class.className','laboratory.lbname','admin.name as tname')
                ->join('course','course.id','=','task.coursename')
                ->join('class','class.id','=','task.classname')
                ->join('laboratory','laboratory.id','=','task.laboratory')
                ->join('admin','admin.id','=','task.teachername')
                ->where('class.className','like','%'.$search.'%')
                ->orwhere('laboratory.lbname','like','%'.$search.'%')
                ->orwhere('admin.name','like','%'.$search.'%')
                ->orwhere('course.name','like','%'.$search.'%')
                ->orderBy('task.id','desc')
                ->get();
        }else{
            $data = \DB::table('task')
                ->select('task.*','course.name','class.className','laboratory.lbname','admin.name as tname')
                ->join('course','course.id','=','task.coursename')
                ->join('class','class.id','=','task.classname')
                ->join('laboratory','laboratory.id','=','task.laboratory')
                ->join('admin','admin.id','=','task.teachername')
                ->where('class.className','like','%'.$search.'%')
                ->orwhere('laboratory.lbname','like','%'.$search.'%')
                ->orwhere('admin.name','like','%'.$search.'%')
                ->orwhere('course.name','like','%'.$search.'%')
                ->orderBy('task.id','asc')
                ->get();
        }

        return $data;
    }

    //课程任务添加
    public function courseAdd(Request $request){

        $data = $request->input('data');
//        dd($data);
        //增加教师的上课次数
        $adminClasses = \DB::table('admin')->where('id',$data['teachername'])->get();
        $adminClasses[0]->classes = ++$adminClasses[0]->classes;
        \DB::table('admin')->where('id',$data['teachername'])->update(['classes'=>$adminClasses[0]->classes]);


        //增加实验室的使用次数
        $laboratory = \DB::table('laboratory')->where('id',$data['laboratory'])->get();
        $laboratory[0]->count = ++$laboratory[0]->count;
        \DB::table('laboratory')->where('id',$data['laboratory'])->update(['count'=>$laboratory[0]->count]);

        //增加课程实验次数
        $course = \DB::table('course')->where('id',$data['coursename'])->get();
        $course[0]->count = ++$course[0]->count;
        \DB::table('course')->where('id',$data['coursename'])->update(['count'=>$course[0]->count]);

        //增加班级上课次数
        $class = \DB::table('class')->where('id',$data['classname'])->get();
        $class[0]->count = ++$course[0]->count;
        \DB::table('class')->where('id',$data['classname'])->update(['count'=>$class[0]->count]);


        //拼接令牌
        $data['_token'] = $data['time'] . $data['week1'] . $data['week2'] .$data['session'].$laboratory[0]->id.$laboratory[0]->lbname;
//        dd($data);

        $newToken = \DB::table('task')->where('_token',$data['_token'])->get();
        if($newToken->count() != 0){
            return "与该实验室的时间段冲突";
        }

        $res = \DB::table('task')->insert($data);


//        $res = \DB::table('task')->insert($data);
//
        return $res ? 1 : 0;

    }

    public function create(Request $request)
    {



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //实验室参数添加
    public function store(Request $request)
    {

//        return $request;

        $data = $request->input('expObj');

        $validator = \Validator::make($data,[
            'name' => 'unique:labtypes|required'
        ],[
            'name.unique' => '不能有重复的编号或类型',
            'name.required' => '编号或类型不能为空'
        ]);

        if($validator->passes()){
            $res = \DB::table('labtypes')->insert($data);
            return $res ? 1 : 0;
        }else{
            return $validator->getMessageBag();
        }
    }
    //封装验证
    public function vali($unique,$array){
        $validator = \Validator::make($array,[
            'name'=>'unique:'.$unique.'|required'
        ],[
            'name.unique'=>'编号或类型已存在',
            'name.required'=>'名称不能为空'
        ]);

        if($validator->passes()){
            return 1;
        }else{
            return $validator->getMessageBag()->getMessages();
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
    //任务修改 Trying to get property 'id' of non-object
    public function update(Request $request, $id)
    {

//        return $id;
            $data = $request->input('obj');
//            dd($data);
            $lb = \DB::table('laboratory')->where('id',$data['laboratory'])->first();
//            dd($lb);
            $data['_token'] = $data['time'] . $data['week1'] . $data['week2'] . $data['session'] . $lb->id .$lb->lbname;



//            dd($data['_token']);  2018/09/01-2019/01/121星期一1-230计算机实训室30
            $rel = \DB::table('task')->where('_token',$data['_token'])->get();

//            dd($rel->count() < 1);

//            if($rel->count() == 1){
////                return "与该实验室的时间段冲突";
//
//                $task = \DB::table('task')->get();
//
//                foreach ($task as $key=>$val){
//                    if($val->_token == $data['_token']){
//                        dd(123);
//                    }
//                }
//            }
//            dd($data);
            $res = \DB::table('task')->where('id',$id)->update($data);
            return $res;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        //

    }

    //实验参数数据接口
    public function lbApi(){
        $data = \DB::table('labtypes')->orderBy('id','desc')->get();


        return $data;
    }

    //开学时间 semester
    public function sTime(Request $request){

        $data =  $request->input('item');

        //日期时间转时间戳
        $start = strtotime($data[0]);
        $end = strtotime($data[1]);

        if($start >= $end){
            return '开始时间不能大于结束时间';
        }
        $res =  \DB::table('termtime')->insert(['start'=>$start,'end'=>$end]);
        return $res ? 1 : 0;
    }

    //获取学期数据    A non-numeric value encountered
    public function getTime(){
        $data = \DB::table('termtime')->orderBy('id','desc')->get();

//        //计算周数    "1535241600"
        for ($i=0;$i<count($data);$i++){

            $num = ceil(($data[$i]->end - $data[$i]->start)/86400); //60s * 60min * 24h

            $data[$i]->week = ceil($num/7);

            $data[$i]->start = date('Y-m',$data[$i]->start);
            $data[$i]->end = date('Y-m',$data[$i]->end);
        }

        return $data;
//        dd($data);
    }

    //数据输入删除功能
    public function inputDel($id,$order){

        if($order == 0){       //0，删除实验室参数
            $data = \DB::table('labtypes')->where('id',$id)->delete();
            return $data;
        }

        if($order == 1){       //1，删除学期
            $data = \DB::table('termtime')->where('id',$id)->delete();
            return $data;
        }

        if($order == 2){       //2. 删除实习任务
            $data = \DB::table('practice')->where('id',$id)->delete();
            return $data;
        }

        if($order == 3){
            $data = \DB::table('task')->where('id',$id)->delete();
            return $data;
        }
    }

    //查询相关数据(下拉列表数据)
    public function inputData(){
        $termtimeDate = \DB::table('termtime')->orderBy('id','desc')->get();
        $teacherDate = \DB::table('admin')->orderBy('id','desc')->get();
        $courseDate = \DB::table('course')->orderBy('id','desc')->get();
        $classDate = \DB::table('class')->orderBy('id','desc')->get();
        $laboratory = \DB::table('laboratory')->orderBy('id','desc')->get();

        $this->geWeek($termtimeDate);

        $start= $this->loop($termtimeDate,'start');
        $end = $this->loop($termtimeDate,'end');


        $data['teacher'] = $teacherDate;


        $data['course'] = $courseDate;

        $data['class'] = $classDate;

        $data['laboratory'] = $laboratory;

        foreach ($start as $key=>$value){
            $start[$key] = date('Y/m/d',$start[$key]);
            $end[$key] = date('Y/m/d',$end[$key]);

            $data['time'][$key] =  $start[$key].'-'.$end[$key];
        }



//        return json_encode($data);
        return $data;
    }

    //week
    public function geWeek($data){
        //计算周数
        for ($i=0;$i<count($data);$i++){

            $zero_1 = strtotime($data[$i]->start);
            $zero_2 = strtotime($data[$i]->end);
            $num = ceil(($zero_2 - $zero_1)/86400); //60s * 60min * 24h

            $data[$i]->week = ceil($num/7);
        }
    }

    //loop
    public function loop($data,$key){
        $row = [];
        for ($i=0;$i<count($data);$i++){
            $row[] = $data[$i]->$key;
        }

        return $row;
    }
}
