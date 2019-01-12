<?php

namespace App\Http\Controllers\Admin\LaboratorySystem;

use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
    use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpParser\Node\Expr\Cast\Object_;

//数据展示控制器
class DataListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    //加载数据展示模板
    public function index()
    {
        //
        return view('admin.LaboratorySystem.datalist');
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

    //返回测试数据
    public function getJson()
    {
        $row = [];

        /*-----只输出最新的设置的时间--------*/
        $time_s = \DB::table('termtime')->orderBy('id','desc')->get();

        for ($i=0;$i<count($time_s);$i++){
            $sumTime[] = date('Y/m',$time_s[$i]->start) .'-'.date('Y/m',$time_s[$i]->end);
        }

        //二级联动需要的数据结构
        foreach ($sumTime as $key=>$val){
            $data[] = array(
                'time' => $val,
                'tClassName' => \DB::table('class')->where('classTime',$val)->get()
            );
        }

        $row['time'] = $data;

        /*------------计算当前周数并查询所有学期--------------*/
        $time = \DB::table('termtime')->orderBy('id','desc')->first();

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

        /*----------------查询实验室数据--------------*/
        $laboratory = \DB::table('laboratory')->get();
        $row['laboratory'] = $laboratory;

        /*----------------查询班级数据----------------------------*/
        $two = isset($_GET['two']) ? $_GET['two'] : '';
        $one = isset($_GET['one']) ? $_GET['one'] : '';

        $class = \DB::table('class')
                        ->where([
                            ['classTime','like','%'.$one.'%'],
                            ['className','like','%'.$two.'%']
                        ])
                        ->get();
//        dd($class);


        $row['class'] = $class;


        /*----------------查询教师数据-------------------------------------*/
        $admin = \DB::table('admin')->get();

        foreach ($admin as $val){
            if($val->lasttime != Null){
                $val->lasttime = date('Y-m-d H:i:s',$val->lasttime);
            }
        }

        $row['admin'] = $admin;


        return $row;

    }

    //导入功能
    public function import(Request $request){

        //将excel文件存储到服务器
        if($request->method() === "POST"){

            $path = $request->file('file')->store('','excel');

            $data = date('Ymd');

            if($path){
                //得到文件的存储位置
                $filPath = "Uploads/excel/".$data.'/'.$path;

                //将excel文件转换成二位数组
                $spreadsheet = IOFactory::load($filPath);

                foreach ($spreadsheet->getWorksheetIterator() as $cell){
                    $cells = $cell->toArray();
                }



                unset($cells[0]);

                //将数据导入数据库
                foreach ($cells as $cell){

//                    //班级存储
                    $class['className'] = $cell[0];
                    $class['classNumber'] = $cell[2];
                    $class['count'] = 0;
                    $time = \DB::table('termtime')->orderBy('id','desc')->get();
                    $sumTime = date('Y/m',$time[0]->start).'-'.date('Y/m',$time[0]->end);
                    $class['time'] = $sumTime;
                    \DB::table('class')->insert($class);

                    //教师存储  Unexpected token. (near "admin" at position 14)
                    $admin['name'] = $cell[5];
                    $admin['password'] = encrypt($cell[7]);
                    $admin['email'] = $cell[6];
                    $admin['isAdmin'] = $cell[8];
                    $admin['count'] = 0;
                    $admin['classes'] = 0;
                    \DB::table('admin')->insert($admin);

                    //课程存储
                    $course['count'] = 0;
                    $course['name'] = $cell[1];
                    \DB::table('course')->insert($course);

//                    return $cell;
                    //实验室存储
                    $laboratory['lbname'] = $cell[9];
                    $laboratory['isCampus'] = 0;
                    $laboratory['count'] = 0;
                    \DB::table('laboratory')->insert($laboratory);

                    //实验室类型和编号 默认值是0 0是编号，1是类型 分割字段
                    $ltSplitField = explode('-',$cell[3]);
                    $labtypes['name'] = $ltSplitField[0];
                    $labtypes['types'] = $ltSplitField[1];
                    \DB::table('labtypes')->insert($labtypes);
                }
                return 1;
            }else{
                return '上传失败';
            }
        }
    }

    //导出功能
    public function expExcel(){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1','ID');
        $sheet->setCellValue('B1','学期');
        $sheet->setCellValue('C1','周数');
        $sheet->setCellValue('D1','星期');
        $sheet->setCellValue('E1','节次');
        $sheet->setCellValue('F1','教师');
        $sheet->setCellValue('G1','课程');
        $sheet->setCellValue('H1','班级');
        $sheet->setCellValue('I1','实训室');

        $i = 1;
        $data = \DB::table('task')
//                    ->select('task.*','admin.name','course as course.name as cname','class.className as cn','laboratory.lbname')
                    ->select('task.*','admin.name','course.name as cname','class.className as cn','laboratory.lbname')
                    ->join('admin','admin.id','=','task.teachername')
                    ->join('course','course.id','=','task.coursename')
                    ->join('class','class.id','=','task.classname')
                    ->join('laboratory','laboratory.id','=','task.laboratory')
                    ->orderBy('task.id','desc')
                    ->chunk(100,function ($datas) use ($i,$sheet){

                        foreach ($datas as $data){
                            $i++;
                            $sheet->setCellValue('A'.$i,$data->id);
                            $sheet->setCellValue('B'.$i,$data->time);
                            $sheet->setCellValue('C'.$i,$data->week1);
                            $sheet->setCellValue('D'.$i,$data->week2);
                            $sheet->setCellValue('E'.$i,$data->session);
                            $sheet->setCellValue('F'.$i,$data->name);
                            $sheet->setCellValue('G'.$i,$data->cname);
                            $sheet->setCellValue('H'.$i,$data->cn);
                            $sheet->setCellValue('I'.$i,$data->lbname);
                        }
                    });

        $filename = '任务数据.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}
