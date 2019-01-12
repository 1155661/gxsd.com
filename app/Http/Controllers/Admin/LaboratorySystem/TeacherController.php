<?php

namespace App\Http\Controllers\Admin\LaboratorySystem;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use phpDocumentor\Reflection\Types\Null_;
use PhpOffice\PhpSpreadsheet\IOFactory;

//教师资料控制器
class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *a
     * @return \Illuminate\Http\Response
     */
    //引入教师资料模板
    public function index()
    {
        //
        return view('admin.LaboratorySystem.teacher');
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
    //添加教师
    public function store(Request $request)
    {
        //
        $data = $request->input('formObj');

        $rule = [
            'name' => 'bail|required|unique:admin',
            'password' => 'bail|required|alpha_num',
            'email' => 'bail|required|email|unique:admin'
        ];

        $message = [
            'name.required' => '名称不能为空',
            'name.unique'   => '该名称已存在',
            'password.required'  =>  '密码不能为空',
            'password.alpha_num' => '密码必须是字母和数字',
            'email.required' => '邮箱不能为空',
            'email.email'   => '邮箱格式不正确',
            'email.unique' => '该邮箱已存在'
        ];

        $validator = \Validator::make($data,$rule,$message);

        if($validator->passes()){

            $data['password'] = encrypt($data['password']);
            $data['count'] = 0;
            $res = \DB::table('admin')->insert($data);
            return $res ? 1 : 0;
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
    //修改教师资料
    public function update(Request $request, $id)
    {
        //
//        return $request;

        $data = $request->input('editObj');
//        return $request->all();
        $rule = [
            'name' => 'bail|required',
            'email' => 'bail|required|email'
        ];

        $message = [
            'name.required' => '名称不能为空',
            'email.required' => '邮箱不能为空',
            'email.email'   => '邮箱格式不正确',
        ];

        $validator = \Validator::make($data,$rule,$message);

        if($validator->passes()){
            $res = \DB::table('admin')->where('id',$id)->update($data);
            return $res;
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
    //删除教师资料
    public function destroy($id)
    {
        //
        $data = \DB::table('admin')->where('id',$id)->delete();
        return $data;
    }


    //批量删除实验室
    public function deletion(Request $request){
//        return $request->all();

        $addId = $request->input('allId');


        $str = implode(',',$addId);

        $str = "({$str})";

        $sql = \DB::select("delete from admin where id in $str");
//        $sql = "DELETE FROM laboratory WHERE id IN $str";


        return 1;

    }

    //教师数据源
    public function teacherData(){

//        return $_GET['sort'] == 'true' ? '1' : '0';
        if($_GET['sort'] == 'true'){
            $data = \DB::table('admin')->orderBy('id','ase')->get();
        }else{
            $data = \DB::table('admin')->get();
        }


        foreach ($data as $val){
            if($val->lasttime != Null){
                $val->lasttime = date('Y-m-d H:i:s',$val->lasttime);
            }
        }

        return $data;
    }

    //导入Excel
    public function impExcel(Request $request){
//        dd($request->method());

        if($request->method() === "POST"){
            $path = $request->file('file')->store('','excel');
            $data = date('Ymd');

            if($path){
                $filPath = 'Uploads/excel/'.$data.'/'.$path;
                $spreadsheet = IOFactory::load($filPath);

                //得到数组 The payload is invalid
                foreach ($spreadsheet->getWorksheetIterator() as $cell){
                    $cells = $cell->toArray();
                }

                unset($cells[0]);

//                dd($cells);

                foreach ($cells as $value){
                    $row['name'] = $value[0];
                    $row['email'] = $value[1];
                    $row['password'] = encrypt($value[2]);
                    $row['classes'] = 0;
                    $row['isAdmin'] = $value[3];
                    $row['lasttime'] = NUll;
                    $row['count'] = 0;
//                    dd($row);
                    \DB::table('admin')->insert($row);
                }
            }
            echo 1;
        }else{
            echo 0;
        }
    }

}
