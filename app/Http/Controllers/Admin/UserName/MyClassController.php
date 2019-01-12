<?php

namespace App\Http\Controllers\Admin\UserName;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//我的班级控制器
class MyClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //我的班级模板
    public function index()
    {
        //
        return view('admin.User.myclass');
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

    //渲染与当前用户相关的班级数据
    public function myClassDate(){
        $myCLass = \DB::table('task')
                    ->where('teachername',$adminId)
                    ->select('task.*','class.*')
                    ->join('class','class.id','=','task.classname')
                    ->groupBy('class.classname')
                    ->get();

        return $myCLass;
//        dd($row);
    }
}
