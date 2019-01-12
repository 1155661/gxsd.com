<?php

namespace App\Http\Controllers\Admin\LaboratorySystem;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Psy\Util\Json;

//实验室管理控制器
class LdController extends Controller
{
    /**
     * Display a listing of the resource.
     *)
        * @return \Illuminate\Http\Response
        */
    //引入实验室资料模板
    public function index()
    {


        return view('admin.LaboratorySystem.lb');
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
    //添加实验室
    public function store(Request $request)
    {
        //
//        $array = explode(',',$request->input('inputDate'));   The MAC is invalid

        $data = $request->input('inputDate');

        $validator = \Validator::make($data,[
            'lbname'=>'unique:laboratory|required',
        ],[
            'lbname.unique'=>'与其他实验室重名',
            'lbname.required'=>'名称不能为空'
        ]);

        if($validator->passes()){
            $data['count'] = 0;
            $res = \DB::table('laboratory')->insert($data);

            if($res){
                return 1;
            }else{
                return 0;
            }
        }else{
            return $validator->getMessageBag();
        }



//        echo implode("&",$array); Array to string conversion

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $idget
     * @return \Illuminate\Http\Response
     */
    //返回需要修改的数据
    public function show($id)
    {
        //
//        $aid = $id;
        $data = \DB::table('laboratory')->where('id',$id)->get();
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
//        var_dump($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //接收前台传过来的数据，并进行修改
    public function update(Request $request, $id)
    {
            $data = $request->except('id');
//            dd($request->all());
//
            $res = \DB::table('laboratory')->where('id',$id)->update($data['inputDate']);
            return $res ? 1 : 0;


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //实验室管理删除功能
    public function destroy($id)
    {

        $data = \DB::table('laboratory')->where('id',$id)->delete();
        return $data;
    }

    //返回实验室参数
    public function labtypesApi(){

        isset($_GET['s']) ? session(['search' => $_GET['s']]) : session(['search' => '']);
//
        $searchDate = session('search');

        if($_GET['sort'] == 'true'){
            $data = \DB::table('laboratory')->where('lbname','like','%'.$searchDate.'%')->orderBy('id','desc')->get();
        }else{
            $data = \DB::table('laboratory')->where('lbname','like','%'.$searchDate.'%')->get();
        }


//        return $searchDate;

        $row = [];
        foreach ($data as $val){
            $val->common = $val->number.$val->lbname.$val->types;
            $row[] = $val;
        }
        return $row;
    }

    //批量删除实验室
    public function deletion(Request $request){

        $addId = $request->input('allId');


        $str = implode(',',$addId);

        $str = "({$str})";

        $sql = \DB::select("delete from laboratory where id in $str");

        return 1;
    }

    //导入实验室Excel
    public function impExcel(Request $request){

        if($request->method() === 'POST'){
            $path = $request->file('file')->store('','excel');
            $data = date('Ymd');

            if($path){
                $filPath = 'Uploads/excel/'.$data.'/'.$path;

                //再用PhpSpreadsheet读写Excel表格
                $spreadsheet = IOFactory::load($filPath);

                //得到数组
                foreach ($spreadsheet->getWorksheetIterator() as $cell){
                    $cells = $cell->toArray();
                }

                //移除Excel的表头
                unset($cells[0]);


                //将读取到的数据存储到数据中
                foreach ($cells as $value){
                    $row['count'] = 0;
                    $row['lbname'] = $value[0];
                    $row['isCampus'] = 0;
                    \DB::table('laboratory')->insert($row);
                }
            }
            echo 1;
        }else{
            echo 0;
        }
    }



}
