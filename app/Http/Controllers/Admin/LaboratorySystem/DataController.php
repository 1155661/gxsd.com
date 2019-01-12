<?php

namespace App\Http\Controllers\Admin\LaboratorySystem;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//后台首页控制器
class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //引入后台首页模板
    public function index()
    {
        //
        return view('admin.LaboratorySystem.index');
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
        //
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
    public function destroy($id)
    {
        //
    }


    //数据接口
    public function getJson(){


        $row = [];

        /*-----只输出最新的设置的时间--------*/
        $time_s = \DB::table('termtime')->orderBy('id','desc')->get();
        $time_s[0]->start = date('Y/m',$time_s[0]->start);
        $time_s[0]->end = date('Y/m',$time_s[0]->end);
        $row['time'] = $time_s[0]->start.'-'.$time_s[0]->end;

//        return $row;
//        exit();
        /*------------计算当前周数--------------*/
        $time = \DB::table('termtime')->orderBy('id','desc')->first();
//        dd($time);
        //一天有多少秒
        $day = (60 * 60 * 24);

        //当前时间与学期结束相差的周数 Integrity constraint violation: 1052 Column 'time' in where clause is ambiguous
        $num = ceil(($time->end - time())/$day);
        $week = ceil($num / 7);

        //学期开始到结束的周数
        $num_2 = ceil(($time->end - $time->start)/$day);
        $week_2 = ceil($num_2 / 7);

        //然后计算当前周数
        $weekNumber = $week_2 - $week;

        $row['theWeek'] = $weekNumber;

        //下拉列表传递过滤的数据
        $selectNumber = empty($_GET['number']) ? $weekNumber : $_GET['number'];
        $selectWeek = empty($_GET['week']) ? '' : $_GET['week'];
        $selectSession =  empty($_GET['session']) ? '' : $_GET['session'];
        /*------只显示与默认时间相关的数据------*/
        $task = \DB::table('task')
//                ->where('time',$row['time'])
                ->where([
                    ['week1',$selectNumber],
                    ['week2','like','%'.$selectWeek.'%'],
                    ['session','like','%'.$selectSession.'%']
                ])
                ->select('task.*','course.name','class.className','laboratory.lbname','admin.name as tname','class.classNumber')
                ->join('course','course.id','=','task.coursename')
                ->join('class','class.id','=','task.classname')
                ->join('laboratory','laboratory.id','=','task.laboratory')
                ->join('admin','admin.id','=','task.teachername')
                ->get();


        $row['task'] = $task;
        foreach ($row['task'] as $value){
            $value->search = $value->week2.$value->session;
        }
        
        $row['newWeek'] = $selectSession;
        return $row;
    }


}
