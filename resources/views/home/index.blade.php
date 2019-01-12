@extends('admin.statics')
@section('css')
    <link rel="stylesheet" href="{{asset('css/homeIndex.css')}}">
    <link rel="stylesheet" href="{{url("layer_mobile/need/layer.css")}}">
    <style>
        [v-cloak]{
            display: none;
        }
        #content2{
            font-size: 16px;
            margin-top: 20px;
        }

        #content2 div{
            /*text-align: left;*/
            margin-left: 50px;
            line-height: 40px;
        }

    </style>
        @endsection
@section('content')
    <div id="app">
        <header class="layui-header layui-bg-cyan">
            <div class="title">信息工程系实验室安排情况</div>
            <ul class="layui-nav layui-bg-green layui-layout-right pc_login">
                <li class="layui-nav-item ">
                    <a href="{{asset('admin/login')}}">登录</a>
                </li>
            </ul>

            <ul class="layui-layout-right phone_login">
                <li class="layui-nav-item ">
                    <a href="{{asset('admin/login')}}" class="layui-icon layui-icon-username" style="color: #009688"></a>
                </li>
            </ul>
        </header>
        <main class="layui-container">
            <div>
                <div class="layui-col-md4 layui-col-md-offset5" style="height: 70px;line-height: 70px;" v-cloak id="title_pc">
                    @{{ list.time }} |这周是 第 <span class="layui-badge" v-cloak>@{{ list.theWeek }}</span> 周 , <span class="layui-badge">@{{ list.xingqi }}</span>
                </div>
                <div class="layui-col-md4 layui-col-md-offset5" v-cloak id="title_phone" style="margin: 10px 0;">
                    这周是 第 <span class="layui-badge" v-cloak>@{{ list.theWeek }}</span>周 , <span class="layui-badge">@{{ list.xingqi }}</span>
                </div>
                <hr class="layui-bg-green">
            </div>
            <div style="margin:  10px 0;" class="layui-col-lg12">
                <form action="#" class="layui-form">
                    <div style="margin-bottom: 10px;" class="layui-input-inline">
                        <select lay-verify="required" lay-filter="week">
                            <option value="">选择星期</option>
                            <option value="星期一">星期一</option>
                            <option value="星期二">星期二</option>
                            <option value="星期三">星期三</option>
                            <option value="星期四">星期四</option>
                            <option value="星期五">星期五</option>
                        </select>
                    </div>
                    <div style="margin-bottom: 10px;" class="layui-input-inline">
                        <select lay-verify="required"  lay-filter="teacher">
                            <option value="">选择教师</option>
                            {{--<option v-for="item in list.teacher">@{{ item.name }}</option>--}}
                            @foreach($data as $value)
                                <option value="{{$value->name}}"> {{$value->name}} </option>
                                @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div>
                <table class="layui-table" lay-size="sm">
                    <colgroup>
                        <col width="70">
                        <col width="200">
                        <col width="170">
                        <col width="300">
                        <col width="100">
                    </colgroup>
                    <thead>
                    <tr>
                        <td>节次</td>
                        <td>课程名称</td>
                        <td>班别</td>
                        <td>实验室</td>
                        <td>任课教师</td>
                    </tr>
                    </thead>
                    <tbody>
                    {{--<tr v-for="item in list.teacher">--}}
                        {{--<td>@{{ item.name}}</td>--}}
                    {{--</tr>--}}

                    <tr v-for="item in list.data_1_2" v-cloak @click="textLayui(item.id)">
                        <td>@{{ item.session }}</td>
                        <td>@{{ item.name }}</td>
                        <td>@{{ item.className }}</td>
                        <td>@{{ item.lbname }}</td>
                        <td>@{{ item.tname }}</td>
                    </tr>
                    <tr v-for="item in list.data_3_4" v-cloak @click="textLayui(item.id)">
                        <td>@{{ item.session }}</td>
                        <td>@{{ item.name }}</td>
                        <td>@{{ item.className }}</td>
                        <td>@{{ item.lbname }}</td>
                        <td>@{{ item.tname }}</td>
                    </tr>
                    <tr v-for="item in list.data_5_6" v-cloak @click="textLayui(item.id)">
                        <td>@{{ item.session }}</td>
                        <td>@{{ item.name }}</td>
                        <td>@{{ item.className }}</td>
                        <td>@{{ item.lbname }}</td>
                        <td>@{{ item.tname }}</td>
                    </tr>
                    <tr v-for="item in list.data_7_8" v-cloak @click="textLayui(item.id)">
                        <td>@{{ item.session }}</td>
                        <td>@{{ item.name }}</td>
                        <td>@{{ item.className }}</td>
                        <td>@{{ item.lbname }}</td>
                        <td>@{{ item.tname }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    @endsection

@section('js')
    <script src="{{url('layer_mobile/layer.js')}}"></script>
    <script>
        app = new Vue({
            el:'#app',
            data:{
                URL:'{{url('home')}}',
                list:'',
                week:'',
                teacher:''
            },
            methods:{
                axiosDate(){
                    let URL = this.URL;
                    let _this = this;
                    layui.use(['form'],() => {
                        let form = layui.form;

                        //监听下拉星期
                        form.on('select(week)', (data) => {
                            _this.week = data.value;
                            _this.axiosDate();
                        });

                        //监听教师下拉列表
                        form.on('select(teacher)',(data) => {
                            _this.teacher = data.value;
                            _this.axiosDate();
                        });

                        //课程表数据源
                        axios.get(URL+'?'+'week='+_this.week + '&teacher=' + _this.teacher).then((value) => {
                            this.list = value.data;
                        });

                        //监听窗口的宽度
                        let windowWidth = $(window).width();

                        //做响应式处理
                        if(windowWidth <= 415){
                            // console.log($('.layui-input-inline').hide());
                            $('.layui-input-inline').removeClass('layui-input-inline');
                        }

                        $(window).resize(function () {
                           window.location.reload();
                        })
                        
                    });
                },
                //教师数据源
                teacherDate(){
                    let URL = "{{url('home/teacher')}}";
                    axios.get(URL).then((value) => {
                        // console.log(value);
                        this.teacher = value.data;
                    });
                },
                textLayui(id){
                    layui.use(['element','form'], function(){
                        let element = layui.element;
                        let $ = layui.$;
                        let windowWidth = $(window).width();
                        let URL = "{{url('home/look/')}}" + '/' + id;

                        if(windowWidth <= 411){
                            axios.get(URL).then((value)=>{
                                // console.log(value.data[0].id);
                                let show = value.data[0];
                                let types = show.types ? '实习' : '课程';

                                layer.open({
                                    type:1,
                                    title: '详情',
                                    skin:'layui-layer-molv',
                                    shadeClose:true,
                                    content:"<div id='content2'><div>节次："+ show.session +"</div><div>课程名称："+ show.name +"</div><div>班别："+ show.className +"</div><div>实验室：" + show.lbname+"</div><div>任课教师："+ show.tname+"</div><div>任务类型：" + types +"</div></div>",
                                    area:['300px','320px'],

                                });
                            });
                        }
                    });
                }
            },
            mounted(){

                //任务数据源
                this.axiosDate();
            },
            computed:{}
        });

        layui.use(['form'],function () {});

        //浏览器变化时
        // $(window).resize(function () {
        //     window.location.reload();
        // 具体的实践方式由多方面组成，包括弹性网格和布局、图片、CSS media query的使用等
        // });

    </script>
    @endsection