@extends('admin.statics')

@section('css')
    @endsection

@section('content')
    <div class="layui-card" id="app">
        <div class="layui-card-header">
            <h2>我的班级</h2>
        </div>
        <div class="layui-card-body">
            {{--<button class="layui-btn layui-btn-sm" @click="appadd">申请</button>--}}
            <table class="layui-table" lay-size="sm">
                <colgroup>
                    <col width="100">
                    <col width="100">
                </colgroup>
                <thead>
                <tr>
                    <td>班级</td>
                    <td>人数</td>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="item in list">
                        <td>@{{ item.className }}</td>
                        <td>@{{ item.classNumber }}</td>
                    </tr>
                </tbody>
            </table>
            <div id="page"></div>
        </div>
    </div>
    @endsection

@section('js')
    <script type="module">
        import {myModule} from '{{asset('js/mymodule.js')}}';
        let myModules = myModule();

        let app = new Vue({
            el:'#app',
            data:{
                list:''
            },
            methods:{
                myClassList(){
                    let URL = '{{url('admin/UserName/myClass/getDate')}}';
                    axios.get(URL).then((value)=>{

                        this.list = value.data;
                    })
                }
            },
            mounted(){
                this.myClassList();
            }
        })
    </script>

    @endsection