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
            <div>

            </div>
            <h2>我的安排</h2>
        </div>
        <div class="layui-card-body">
            <form action="#" class="layui-form">
                <div class="layui-input-inline">
                    <select lay-filter="week1">
                        <option value="">周</option>
                        @for($i=1;$i<=21;$i++)
                            <option value="{{$i}}">{{$i++}}</option>
                        @endfor
                    </select>
                </div>
                <div class="layui-input-inline">
                    <select lay-filter="week2">
                        <option value="">星期</option>
                        <option value="星期一">星期一</option>
                        <option value="星期二">星期二</option>
                        <option value="星期三">星期三</option>
                        <option value="星期四">星期四</option>
                        <option value="星期五">星期五</option>
                    </select>
                </div>
                <div class="layui-input-inline">
                    <select lay-filter="session">
                        <option value="">节次</option>
                        <option value="1-2">1-2</option>
                        <option value="3-4">3-4</option>
                        <option value="5-6">5-6</option>
                        <option value="7-8">7-8</option>
                    </select>
                </div>
            </form>
            <table class="layui-table" lay-size="sm">
                <colgroup>
                    <col width="20">
                    <col width="20">
                    <col width="20">
                    <col width="100">
                    <col width="100">
                    <col width="100">
                    <col width="100">
                    <col width="20">
                </colgroup>
                <thead>
                <tr>
                    <td>周</td>
                    <td>星期</td>
                    <td>节</td>
                    <td>实验名称</td>
                    <td>实验类型</td>
                    <td>班级</td>
                    <td>实验室</td>
                    <td>操作</td>
                </tr>
                </thead>
                <tbody>

                {{--需要渲染的位置--}}
                <template v-if="list.length != 0">
                    <tr v-for="item in list" v-cloak>
                        <td>@{{ item.week1 }}</td>
                        <td>@{{ item.week2 }}</td>
                        <td>@{{ item.session }}</td>
                        <td>@{{ item.name }}</td>
                        <td>@{{ item.types ? '实习' : '课程' }}</td>
                        <td>@{{ item.className }}</td>
                        <td>@{{ item.lbname }}</td>
                        <td>
                            <button class="layui-btn layui-btn-sm layui-btn-danger" @click="del(item.id)">删除</button>
                        </td>
                    </tr>
                </template>
                <template v-else>
                    <tr>
                        <td colspan="8" style="text-align: center;"><span class="layui-badge">暂无安排</span></td>
                    </tr>
                </template>

                </tbody>
            </table>
            <div id="page"></div>
            <div>今天是 <span class="layui-badge">星期{{$time}}</span> ，第 <span class="layui-badge">{{$week}}</span> 周</div>
        </div>
    </div>


    @endsection
@section('js')
    <script type="module">

        //引入模块
        import {myModule} from '{{asset('js/mymodule.js')}}';
        let myModules = myModule();

        let app = new Vue({
            el:'#app',
            data:{
                list:'',
                week1:'',
                week2:'',
                session:''
            },
            methods:{
                //渲染列表数据
                listData(){
                    let _this = this;

                    layui.use(['form'],function () {
                        let form = layui.form;

                        form.on("select(week1)",function (data) {
                            // console.log(data.value);
                            _this.week1 = data.value;
                            _this.listData();
                        });

                        form.on("select(week2)",function (data) {
                            _this.week2 = data.value;
                            _this.listData();
                            // console.log(data.value);
                        });

                        form.on("select(session)",function (data) {
                            _this.session = data.value;
                            _this.listData();
                            // console.log(data.value);
                        });
                    });
                    let URL = '{{url('admin/UserName/index/getDate')}}';
                    let newUrl =  URL + '?' + 'week1=' + _this.week1 + '&week2='+_this.week2+'&session='+_this.session;

                    myModules.newLayPage(newUrl,this,$('#page'));
                },
                //删除
                del(id){
                    // alert();
                    let URL = '{{asset('admin/UserName/index')}}';
                    axios.delete(URL+'/'+id).then((value)=>{
                        if(value.data === 1){
                            myModules.newLayer(1,'删除成功');
                            this.listData();
                        }
                    })
                }
            },
            mounted(){
                this.listData();
            }
        })
    </script>
    @endsection