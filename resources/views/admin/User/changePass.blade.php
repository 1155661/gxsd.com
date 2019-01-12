@extends('admin.statics')

@section('css')
    <style>
        [v-cloak]{
            display: none;
        }
    </style>
    @endsection

@section('content')
    <div class="layui-card" id="app">
        <div class="layui-card-header">
            <h2>修改密码</h2>
        </div>
        <div class="layui-card-body layui-col-md6">
            <form class="layui-form layui-form-pane" action="">
                <div class="layui-form-item">
                    <label class="layui-form-label">名称</label>
                    <div class="layui-input-block">
                        <input type="hidden" name="id" value="{{session('gxsdmznAdminUserInfo.id')}}">
                        <input type="text" name="name" value="{{session('gxsdmznAdminUserInfo.name')}}"  readonly="readonly" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">密码</label>
                    <div class="layui-input-block">
                        <input type="password" name="password" placeholder="请输入密码" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">确认密码</label>
                    <div class="layui-input-block">
                        <input type="password" name="password_confirmation" placeholder="请输入密码" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="formDemo">立即修改</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    @endsection
@section('js')
    <script type="module">
        import {myModule} from '{{asset('js/mymodule.js')}}';
        let myModules = myModule();

        layui.use('form', function(){
            let form = layui.form;

            //监听提交
            form.on('submit(formDemo)', function(data){
                // layer.msg(JSON.stringify(data.field));

                let URL = '{{asset('admin/UserName/changePassword')}}';
                let obj = data.field;
                // console.log(obj);
                axios.put(URL+'/'+obj.id,{obj}).then((value)=>{
                    // console.log(value);
                    if(value.data === 1){
                        myModules.newLayer(1,'修改成功');
                    }else{
                        myModules.newLayer(0,value.data.password[0]);
                    }

                });

                return false;
            });
        });
    </script>
    @endsection