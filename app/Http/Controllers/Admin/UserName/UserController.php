<?php

namespace App\Http\Controllers\admin\username;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//我的安排控制器
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //加载用户模板
    public function index()
    {
        //
//        $time = \DB::table('termtime')->first();


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

        //然后计算当前周数
//        $weekNumber = $week_2 - $week;
        //

        //当前星期
        $weekArray = array("日","一","二","三","四","五","六");
        $time = $weekArray[date('w')];
        return view('admin.User.index',[
            'week' => $weekNumber,
            'time' => $time
        ]);
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
    //删除
    public function destroy($id)
    {
        //
        $data = \DB::table('task')->where('id',$id)->delete();
        return $data ? 1 : 0;
    }

    //渲染表格数据
    public function tableData(){
//        return '123';
//
        $userId = session('gxsdmznAdminUserInfo')['id'];

        $time = \DB::table('termtime')->orderBy('id','desc')->first();

        $row['theTime'] = date('Y/m/d',$time->start) .'-' . date('Y/m/d',$time->end);

        //当前周数
        $week = $this->theWeek();

        $getWeek1 = isset($_GET['week1']) ? $_GET['week1'] : '';
        $getWeek2 = isset($_GET['week2']) ? $_GET['week2'] : '';
        $getSession = isset($_GET['session']) ? $_GET['session'] : '';
//        dd($getWeek1);

        $data = \DB::table('task')
                    ->where([
                        ['teachername',$userId],
                        ['time',$row['theTime']],
                        ['week1','like','%'.$getWeek1.'%'],
                        ['week2','like','%'.$getWeek2.'%'],
                        ['session','like','%'.$getSession.'%'],
                    ])
                    ->select('task.*','course.name','class.className','laboratory.lbname','admin.name as tname','class.classNumber','class.id as classid')
                    ->join('course','course.id','=','task.coursename')
                    ->join('class','class.id','=','task.classname')
                    ->join('laboratory','laboratory.id','=','task.laboratory')
                    ->join('admin','admin.id','=','task.teachername')
                    ->orderBy('id','desc')->get();

        return $data;
//        return session('gxsdmznAdminUserInfo');
    }

    public function theWeek(){
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

        return $weekNumber;
    }
}
