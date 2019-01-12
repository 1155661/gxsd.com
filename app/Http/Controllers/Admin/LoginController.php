<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    //后台登录首页
    public function index(){
        return view('admin.login');
//        return '登录';
    }

    //验证码
    public function code(){
        //引入类文件
        require_once('../resources/code/Code.class.php');

        //实例化验证码
        $code = new \Code();

        //调用验证码
        $code->make();
    }

    //登录验证码
    public function check(Request $request){

//        $data = $request->except('_token');

        //引入类文件
        require_once('../resources/code/Code.class.php');

        //实例化验证码
        $code = new \Code();

        //获取自动生成的验证码
        $old = $code->get();

//        var_dump($request->all());
        $postData = $request->input('postObj');


        //验证验证码，strtoupper()将表单提交过来的值转为大写
        if(strtoupper($postData['code']) === $old){

            //根据Eamil查询，没有记录则表示账号不存在
            $verAdmin = \DB::table('admin')->where('email',$postData['email'])->get();
            if(count($verAdmin)){

                //对查询到的密码进行解密，在进行比较
                $verAdmin[0]->password = decrypt($verAdmin[0]->password);

                if($postData['password'] == $verAdmin[0]->password){

                    //记录最后一次登录时间和次数
                    $arr['lasttime'] = time();
                    $arr['count'] = ++$verAdmin[0]->count;
                    \DB::table('admin')->where('id',$verAdmin[0]->id)->update($arr);

                    //把用户信息存储到session中
                    $newArr['name'] = $verAdmin[0]->name;
                    $newArr['isAdmin'] = $verAdmin[0]->isAdmin;
                    $newArr['id'] = $verAdmin[0]->id;
                    session(['gxsdmznAdminUserInfo'=>$newArr]);

                    return 1;
                }else{
                    return '密码错误';
                }

            }else{
                return '账号不存在';
            }
//            return $verAdmin;
        }else{
            return '验证码错误';
        }
    }

    //退出登录
    public function logout(Request $request){
        //清空session
        $request->session()->flush();

        return redirect('admin/login');
    }

    //找回密码模板
    public function retrieve(){
        return view('admin.retrieve');
    }

    //发送邮件
    public function send(Request $request){

        //需要生成字符的字符集
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';

        //获取$pattern的长度
        $strlen = mb_strlen($pattern);

        $str = '';

        //然后截取字符串
        for ($i=0;$i<4;$i++){
            $str .= $pattern[mt_rand(0,$strlen)];
        }

        if($request->has('emailObj')){

            //接收邮箱
            $email = $request->input('emailObj');

            $to = $email['email'];

            //邮箱主题
            $subject = '账号找回';

            \Mail::send('admin.Mail.index',['code'=>$str],function ($message) use($to,$subject){
                $message->to($to)->subject($subject);
            });
            return 1;
        }

//        if(){
//
//        }

    }
}
