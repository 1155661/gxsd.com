<?php

namespace App\Http\Controllers\Admin\UserName;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//密码修改控制器
class ChangePassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //加载密码修改模板
    public function index()
    {
        //
        return view('admin.User.changePass');
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
    //修改密码
    public function update(Request $request, $id)
    {
        //
//        return $request->all();          规则
        $rule = [
          'password'=>'required|confirmed|alpha_dash'
        ];

        $message = [
            'password.required' => '密码不能为空',
            'password.confirmed' => '两次密码不一致',
            'password.alpha_dash' => '密码格式不合法'
        ];

        $data = $request->input('obj');

        $validator = \Validator::make($data,$rule,$message);

        if($validator->passes()){
//          return '1';
            $data = $request->input('obj');
//            return $data['password'];
            $arr['password'] = encrypt($data['password']);
            $res = \DB::table('admin')->where('id',$data['id'])->update($arr);
            return $res ? 1 : 0;

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
    public function destroy($id)
    {
        //
    }
}
