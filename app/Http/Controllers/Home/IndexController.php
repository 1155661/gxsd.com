<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//前端首页控制器
class IndexController extends Controller
{
    //首页模板
    public function index(){

        $data = $this->teacherDate();

        return view('home.index',[
            'data' => $data
        ]);
    }

    //渲染前端数据
    public function frontEndDate(){

        $row = [];

        /*-----只输出最新的设置的时间--------*/
        $time_s = \DB::table('termtime')->orderBy('id','desc')->get();
        $time_s[0]->start = date('Y/m/d',$time_s[0]->start);
        $time_s[0]->end = date('Y/m/d',$time_s[0]->end);
        $row['time'] = $time_s[0]->start.'-'.$time_s[0]->end;


        /*------------计算当前周数--------------*/
        $time = \DB::table('termtime')->orderBy('id','desc')->first();
//        dd($time);
        //一天有多少秒
        $day = (60 * 60 * 24);

        //当前时间与学期结束相差的周数
        $num = ceil(($time->end - time())/$day);
        $week = ceil($num / 7);

        //学期开始到结束的周数
        $num_2 = ceil(($time->end - $time->start)/$day);
        $week_2 = ceil($num_2 / 7);

        //然后计算当前周数
        $weekNumber = $week_2 - $week;


        $row['theWeek'] = $weekNumber;

        //当前星期
        $weekArray = array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
        $row['xingqi'] = $weekArray[date('w')];


        //按星期筛选数据
        $getWeek = isset($_GET['week']) ? $_GET['week'] : '';
        $getTeacher = isset($_GET['teacher']) ? $_GET['teacher'] : '';
//        dd($getTeacher); Column not found: 1054 Unknown column 'task.tname' in 'where clause'
//        dd($getTeacher);
        $data_1_2 = \DB::table('task')
            ->select('task.*','course.name','class.className','laboratory.lbname','admin.name as tname')
            ->where([
                'time'=>$row['time'],
                ['session','1-2'],
                ['week1',$row['theWeek']],
                ['week2','like','%'.$getWeek.'%'],
                ['admin.name','like','%'.$getTeacher.'%']
            ])
//            ->orWhere('admin.name','like','%'.$getTeacher.'%')
            ->join('course','course.id','=','task.coursename')
            ->join('class','class.id','=','task.classname')
            ->join('laboratory','laboratory.id','=','task.laboratory')
            ->join('admin','admin.id','=','task.teachername')
            ->orderBy('id','desc')
            ->get();


        $data_3_4 = \DB::table('task')
            ->where([
                'time'=>$row['time'],
                ['session','3-4'],
                ['week1',$row['theWeek']],
                ['week2','like','%'.$getWeek.'%'],
                ['admin.name','like','%'.$getTeacher.'%']
            ])
            ->select('task.*','course.name','class.className','laboratory.lbname','admin.name as tname')
            ->join('course','course.id','=','task.coursename')
            ->join('class','class.id','=','task.classname')
            ->join('laboratory','laboratory.id','=','task.laboratory')
            ->join('admin','admin.id','=','task.teachername')
            ->orderBy('id','desc')->get();


        $data_5_6 = \DB::table('task')
            ->where([
                'time'=>$row['time'],
                ['session','5-6'],
                ['week1',$row['theWeek']],
                ['week2','like','%'.$getWeek.'%'],
                ['admin.name','like','%'.$getTeacher.'%']
            ])
            ->select('task.*','course.name','class.className','laboratory.lbname','admin.name as tname')
            ->join('course','course.id','=','task.coursename')
            ->join('class','class.id','=','task.classname')
            ->join('laboratory','laboratory.id','=','task.laboratory')
            ->join('admin','admin.id','=','task.teachername')
            ->orderBy('id','desc')->get();


        $data_7_8 = \DB::table('task')
            ->where([
                'time'=>$row['time'],
                ['session','7-8'],
                ['week1',$row['theWeek']],
                ['week2','like','%'.$getWeek.'%'],
                ['admin.name','like','%'.$getTeacher.'%']
            ])
            ->select('task.*','course.name','class.className','laboratory.lbname','admin.name as tname')
            ->join('course','course.id','=','task.coursename')
            ->join('class','class.id','=','task.classname')
            ->join('laboratory','laboratory.id','=','task.laboratory')
            ->join('admin','admin.id','=','task.teachername')
            ->orderBy('id','desc')->get();

        //教师数据源
        $teacher = \DB::table('admin')->get();
        $row['teacher'] = $teacher;

        $row['data_1_2'] = $data_1_2;
        $row['data_3_4'] = $data_3_4;
        $row['data_5_6'] = $data_5_6;
        $row['data_7_8'] = $data_7_8;
//        dd($row);

        return $row;
    }

    //返回对应数据 查看
    public function look($id){

        $data = \DB::table('task')
            ->where('task.id',$id)
            ->select('task.*','course.name','class.className','laboratory.lbname','admin.name as tname')
            ->join('course','course.id','=','task.coursename')
            ->join('class','class.id','=','task.classname')
            ->join('laboratory','laboratory.id','=','task.laboratory')
            ->join('admin','admin.id','=','task.teachername')
            ->get();


        return $data;
    }

    //教师数据源
    public function teacherDate(){
        $data = \DB::table('admin')->get();
//        dd($data);

        return $data;
    }
}
