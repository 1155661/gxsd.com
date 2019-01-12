@extends('admin.statics')
<style>
    body{
        background-color: #F0F0F0;
    }
    #retrieve{
        margin-top: 220px;
    }
</style>
@section('content')
    <div id="retrieve" class="layui-container">
        <h2 style="text-align: center;height: 60px;line-height: 60px;">找回密码</h2>
        <form class="layui-form" action="#" method="post" style="width: 460px;margin: 0 auto;">
            <div class="layui-form-item">
                <label class="layui-form-label">邮箱</label>
                <div class="layui-input-inline">
                    <input type="email" name="email" required  lay-verify="required|email" placeholder="你的邮箱" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <button class="layui-btn layui-btn-sm" lay-submit lay-filter="goEmail">发送邮件</button>
                </div>
            </div>
        </form>
        <form class="layui-form" action="#" method="post" style="width: 460px;margin: 0 auto;">
            <div class="layui-form-item">
                <label class="layui-form-label">验证码</label>
                <div class="layui-input-block">
                    <input type="text" name="code" required lay-verify="required" placeholder="请输入邮箱中的验证码" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-fluid" lay-filter="goCode">确认</button>
            </div>
        </form>
    </div>
    @endsection

@section('js')
    <script type="module">

        import {myModule} from '{{asset('js/mymodule.js')}}';
        let myModules = myModule();

        layui.use('form', function(){
            var form = layui.form;

            //监听邮箱
            form.on('submit(goEmail)', function(data){
                // layer.msg(JSON.stringify(data.field));
                let URL = '{{asset('admin/send')}}';
                let emailObj = data.field;

                axios.post(URL,{emailObj}).then(function (value) {
                    // console.log(value.data);
                    if(value.data === 1){
                        myModules.newLayer(1,'邮件已发送');
                    }
                });
                return false;
            });

            //监听验证码
            form.on('submit(goCode)',function (data) {

            })
            document.getElementById('d');
        });
    </script>
    @endsection