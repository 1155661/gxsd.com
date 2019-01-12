<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//后台根组件控制器
class RootController extends Controller
{
    //根组件模板
    public function index(){

        $count = \DB::table('application')->where('status',0)->count();

        return view('admin.base',[
            'count' => $count
        ]);
    }

    //申请的数据
    public function appList(){
        $count = \DB::table('application')->where('status',0)->get();
        return $count;
    }
}
