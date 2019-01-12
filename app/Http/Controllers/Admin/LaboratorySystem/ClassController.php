<?php

namespace App\Http\Controllers\Admin\LaboratorySystem;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;

//班级资料控制器
class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //引入班级资料模板
    public function index()
    {
        //

        $data = \DB::table('termtime')->orderBy('id','desc')->get();

        $row = [];
        foreach ($data as $key => $value){

            $row[] = date('Y/m',$value->start).' - '.date('Y/m',$value->end);
        }

//        dd($row);
//        return $row;

        return view('admin.LaboratorySystem.class',[
            'row' => $row
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
    //班级添加
    public function store(Request $request)
    {

//        dd($request->all());
        $data = $request->input('data');

        $validator = \Validator::make($data,[
            'className' => 'bail|unique:class|required',
            'classNumber' => 'bail|required|numeric'
        ],[
            'className.unique' => '班级名称冲突',
            'className.required' => '班级名称不能为空',
            'classNumber.required' => '班级人数不能为空',
            'classNumber.numeric' => '人数必须为数字'
        ]);

        if($validator->passes()){

            $time = \DB::table('termtime')->orderBy('id','desc')->get();
            $sumTime = date('Y/m',$time[0]->start).'-'.date('Y/m',$time[0]->end);

//            dd($data);
            $data['count'] = 0;
            $data['classTime'] = $sumTime;
            $data['search'] = $data['classTime'].$data['className'];

            $res = \DB::table('class')->insert($data);
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
    //班级修改
    public function update(Request $request, $id)
    {
        //
//        return $request->all();   结果      过度
        $data = $request->input('obj');   //规则
//        $newArr = array_splice($data,1,2);
        $rule = [
            'className' => 'bail|unique:class|required',
            'classNumber' => 'bail|required|numeric',
        ];

        $message = [
            'className.unique' => '班级名称冲突',
            'className.required' => '班级名称不能为空',
            'classNumber.required' => '班级人数不能为空',
            'classNumber.numeric' => '人数必须为数字'
        ];

        $validator = \Validator::make($data,$rule,$message);



        if($validator->passes()){
            $res = \DB::table('class')->where('id',$id)->update($data);
            return $res;
        }else{
            return $validator->getMessageBag();
        }




//        if($request->has('className')){
//
//            $validator = \Validator::make($request->all(),$rule,$message);
//            return $validator->passes() ? $over = $request->all() : $validator->getMessageBag();
//        }
//
//        $result = \DB::table('class')->where('id',$id)->update($over);
//        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //删除班级
    public function destroy($id)
    {
        //
//        return $id;
        $data = \DB::table('class')->where('id',$id)->delete();
        return $data ? 1 : 0;
    }

    //批量删除实验室
    public function deletion(Request $request){
//        return $request->all();

        $addId = $request->input('allId');


        $str = implode(',',$addId);

        $str = "({$str})";

        $sql = \DB::select("delete from class where id in $str");
//        $sql = "DELETE FROM laboratory WHERE id IN $str";

        return 1;
    }

    //返回学期数据
    public function getTime(){
        $data = \DB::table('termtime')->orderBy('id','desc')->get();

        $row = [];
        foreach ($data as $key => $value){

            $row[] = date('Y/m',$value->start).' - '.date('Y/m',$value->end);
        }

//        dd($row);
        return $row;
    }

    //导入班级Excel表
    public function impExcel(Request $request){


        //查询最新添加的时间
        $time = \DB::table('termtime')->orderBy('id','desc')->get();

        $sumTime = date('Y/m',$time[0]->start).'-'.date('Y/m',$time[0]->end);

        //将Excel存储到项目中
        if($request->method() === "POST"){
            $paht = $request->file('file')->store('','excel');
            $data = date('Ymd');

            if($paht){

                //拼接Excel表格的存储路径
                $filPath = 'Uploads/excel/'.$data.'/'.$paht;

                //再用PhpSpreadsheet读写Excel表格
                $spreadsheet = IOFactory::load($filPath);

                //得到数组
                foreach ($spreadsheet->getWorksheetIterator() as $cell){
                    $cells = $cell->toArray();
                }

                //移除Excel的表头
                unset($cells[0]);

                //将读取到的数据存储到数据中

//                dd($cells);

                foreach ($cells as $value){
                    $row['className'] = $value[0];
                    $row['classNumber'] = $value[1];
                    $row['count'] = 0;
                    $row['classTime'] = $sumTime;
                    $row['search'] = $row['classTime'] . $row['className'];

//                    dd($row);
                    \DB::table('class')->insert($row);
                }
            }

            echo 1;
        }else{
            echo 0;
        }

    }

    //班级数据源
    public function classDate(){

        //搜索
        isset($_GET['s']) ? session(['search' => $_GET['s']]) : session(['search' => '']);
        $search = session('search');


        //排序
        if($_GET['sort'] == "true"){
            return $data = \DB::table('class')->where('className','like','%'.$search.'%')->get();
//            return 1;
        }
        return $data = \DB::table('class')->where('className','like','%'.$search.'%')->orderBy('id','ase')->get();

    }
}
