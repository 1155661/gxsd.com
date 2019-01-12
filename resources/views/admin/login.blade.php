@extends('admin.statics')

@section('css')
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    @endsection

@section('content')
    <div class="layui-row" id="login">
        {{--<div class="font-init">--}}
            {{--<span>Information Engineering Laboratory Management System</span>--}}
        {{--</div>--}}
        <div class="layui-col-md3 layui-col-md-offset8 login_left">
            <div class="bg">
                <h2>信息工程系管理系统登录</h2>
                <form class="layui-form layui-col-md10 layui-col-lg10 layui-col-xs10 layui-col-md-offset1 layui-col-xs-offset1" action="{{asset('admin/login/check')}}" method="post" @submit.prevent="loginDate">
                    {{--{{csrf_field()}}--}}
                    <div class="layui-form-item">
                        <input type="text" name="email" required lay-verType="alert"  lay-verify="required|email" placeholder="邮箱" class="layui-input">
                        {{--<select name="city" lay-verify="required">--}}
                            {{--<option value=""></option>--}}
                            {{--<option value="0">北京</option>--}}
                            {{--<option value="1">上海</option>--}}
                            {{--<option value="2">广州</option>--}}
                            {{--<option value="3">深圳</option>--}}
                            {{--<option value="4">杭州</option>--}}
                        {{--</select>--}}
                    </div>
                    <div class="layui-form-item">
                        <input type="password" name="password" lay-verType="alert"  lay-verify="required" placeholder="密码" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-inline pc_code">
                            <input type="text" class="layui-input" lay-verType="alert" name="code" placeholder="验证码">
                        </div>
                        {{--<input type="text" class="layui-input phone_code" lay-verType="alert" name="code" placeholder="验证码">--}}
                        <div class="layui-form-mid layui-word-aux">
                            <img src="{{asset('admin/login/yzm')}}" onclick="this.src='{{asset('admin/login/yzm')}}?m'+Math.random()" style="cursor: pointer;" alt="验证码">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <button class="layui-btn" lay-submit lay-filter="go" type="submit">登录</button>
                        <a href="{{asset('/')}}" class="layui-btn layui-btn-primary" >返回首页</a>
                        <a href="{{asset('admin/retrieve')}}" style="float: right;line-height: 38px;color: #ffffff;">找回密码</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection
@section('js')
    <script type="module">
        import {myModule} from '{{asset('js/mymodule.js')}}';
        let myModules = myModule();

        layui.use(['element','form'],function () {
            let form = layui.form;

            layer.config({
                icon:2,
                skin: 'layui-layer-molv', //默认皮肤
            });

            form.on('submit(go)',function (data) {
                let postObj = data.field;
                let URL = '{{asset('admin/login/check')}}';
                axios.post(URL,{postObj}).then((value)=>{
                    if(value.data === 1){

                        window.location.href = "{{asset('admin')}}";
                    }else {
                        // console.log(value.data);
                        myModules.newLayer(0,value.data)
                    }
                });
                return false;
            })
        });
    </script>
    @endsection