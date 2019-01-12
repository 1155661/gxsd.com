<?php

namespace App\Http\Controllers\Admin\LaboratorySystem;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;

//课程名称控制器
class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //引入课程名称模板
    public function index()
    {
        //
        return view('admin.LaboratorySystem.course');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        //
//        dd($request->input('name'));
//        return $request->input('name');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //课程添加
    public function store(Request $request)
    {
        //Object of class
//        $array['aid'] = 0;
        $array['count'] = 0;
        $array['name'] = $request->input('name');
        $validator = \Validator::make($array,[
            'name'=>'unique:course|required'
        ],[
            'name.unique' => '与其他课程重名',
            'name.required'=> '课程名不能为空'
        ]);

        if($validator->passes()){
            $res = \DB::table('course')->insert($array);

            if($res){
                return 1;
            }else{
                return 0;
            }

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
    //修改课程接口
    public function update(Request $request, $id)
    {
        //
//        var_dump($request);
//        $array['name'] = $request->input('name');
//        $array['aid'] = 0;
//        return $array['name'];

        $validator = \Validator::make($request->all(),[
            'name'=>'unique:course|required',
        ],[
            'name.unique' => '与其他课程重名',
            'name.required' => '课程名不能为空'
        ]);

        if($validator->passes()){
            $res = \DB::table('course')->where('id',$id)->update($request->all());
            return $res ? 1: 0;
        }else{
            return $validator->getMessageBag();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //异步删除课程
    public function destroy($id)
    {
        //
//        var_dump($id);
        $res = \DB::table('course')->where('id',$id)->delete();


        return $res === 1 ? 1 : 0;
    }

    //课程数据接口
    public function courseJson(){

        //搜索
        isset($_GET['s']) ? session(['search' => $_GET['s']]) : session(['search' => '']);
        $search = session('search');

        //排序
        if($_GET['sort'] == 'true'){
            $data = \DB::table('course')->where('name','like','%'.$search.'%')->orderBy('id','desc')->get();
        }else{
            $data = \DB::table('course')->where('name','like','%'.$search.'%')->get();
        }

        return $data;
    }

    //批量删除实验室
    public function deletion(Request $request){
//        return $request->all();

        $addId = $request->input('allId');


        $str = implode(',',$addId);

        $str = "({$str})";

        $sql = \DB::select("delete from course where id in $str");
//        return $sql;
        return !$sql ? 1 : 0;
    }

    //导入Excel
    public function impExcel(Request $request){

        if($request->method() === 'POST'){
            $path = $request->file('file')->store('','excel');
            $data = date('Ymd');

            if($path){
                $filPath = 'Uploads/excel/'.$data.'/'.$path;
                $spreadsheet = IOFactory::load($filPath);

                //得到数组
                foreach ($spreadsheet->getWorksheetIterator() as $cell){
                    $cells = $cell->toArray();
                }

                unset($cells[0]);

                foreach ($cells as $value){
                    $row['name'] = $value[0];
                    $row['count'] = 0;

                    \DB::table('course')->insert($row);
                }
            }
            echo 1;
        }else{
            echo 0;
        }

    }
}
