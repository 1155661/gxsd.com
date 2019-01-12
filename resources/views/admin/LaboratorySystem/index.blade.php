@extends('admin.statics')

@section('css')
    {{--<link rel="stylesheet/less" href="{{asset('css/index_2.less')}}"> 上课次数 学期 周数 筛选 --}}
    <style>
        [v-cloak]{
            display: none;
        }
    </style>
        @endsection

@section('content')
    <div class="layui-row layui-col-space10 box_1"  id="app" v-cloak>
        <div class="layui-col-md12">
            <h1 style="text-align: center;margin: 1rem">本学期课程安排情况</h1>
            <hr>
            <form action="#" class="layui-form">
                <div class="layui-form-item layui-input-inline">
                    <select name="city" lay-verify="required" disabled>
                        {{--<option value=""></option>--}}
                        <option value="0">默认学期：@{{ time }}</option>
                    </select>
                </div>
                <div class="layui-form-item layui-input-inline">
                    <select name="city" lay-verify="required" lay-filter="number">
                        <option value="">周数</option>
                        <option v-for="(item,index) in theWeek" :value="index + 1">@{{ index + 1 }}</option>
                    </select>
                </div>
                <div class="layui-form-item layui-input-inline">
                    <select name="city" lay-verify="required" lay-filter="week">
                        <option value="">星期</option>
                        <option value="星期一">星期一</option>
                        <option value="星期二">星期二</option>
                        <option value="星期三">星期三</option>
                        <option value="星期四">星期四</option>
                        <option value="星期五">星期五</option>
                    </select>
                </div>
                <div class="layui-form-item layui-input-inline">
                    <select name="city" lay-verify="required" lay-filter="session">
                        <option value="">节次</option>
                        <option value="1-2">1-2</option>
                        <option value="3-4">3-4</option>
                        <option value="5-6">5-6</option>
                        <option value="7-8">7-8</option>
                    </select>
                </div>
                <div class="layui-form-item layui-input-inline">
                    当前周数： <span class="layui-badge">@{{ theWeek }}</span>
                </div>
            </form>
            <div class="layui-row layui-col-space10">
                <div class="layui-col-md12">
                    <table class="layui-table" lay-size="sm">
                        <colgroup>
                            <col width="100">
                            <col width="70">
                            <col width="200">
                            <col width="170">
                            <col width="50">
                            <col width="300">
                            <col width="100">
                            <col width="100">
                            <col width="100">
                            <col width="100">
                        </colgroup>
                        <thead>
                        <tr>
                            <td>周数</td>
                            <td>星期</td>
                            <td>节次</td>
                            <td>课程名称</td>
                            <td>班别</td>
                            <td>人数</td>
                            <td>实验室</td>
                            <td>任课教师</td>
                        </tr>
                        </thead>
                        <tbody v-if="task.length !== 0">
                        <tr v-for="item in task" v-cloak>
                            <td>@{{ item.week1 }}</td>
                            <td>@{{ item.week2 }}</td>
                            <td>@{{ item.session }}</td>
                            <td>@{{ item.name }}</td>
                            <td>@{{ item.className }}</td>
                            <td>@{{ item.classNumber }}</td>
                            <td>@{{ item.lbname }}</td>
                            <td>@{{ item.tname }}</td>
                        </tr>
                        </tbody>
                        <tbody v-else>
                        <tr>
                            <td colspan="8" style="text-align: center;"> <span class="layui-badge">暂无数据</span> </td>
                        </tr>
                        </tbody>
                    </table>
                    <div id="pageinit"></div>
                </div>
                {{--<div class="layui-col-md3">--}}
                    {{--<div class="layui-collapse" lay-accordion>--}}
                        {{--<div class="layui-colla-item">--}}
                            {{--<h2 class="layui-colla-title">当前学期和周数</h2>--}}
                            {{--<div class="layui-colla-content layui-show">@{{ time }} - 第 <span class="layui-badge">@{{ theWeek }}</span> 周</div>--}}
                        {{--</div>--}}
                        {{--<div class="layui-colla-item">--}}
                            {{--<h2 class="layui-colla-title">节次</h2>--}}
                            {{--<div class="layui-colla-content" style="cursor:pointer;" @click="filter($event)">1-2</div>--}}
                            {{--<div class="layui-colla-content" style="cursor:pointer;" @click="filter($event)">3-4</div>--}}
                            {{--<div class="layui-colla-content" style="cursor:pointer;" @click="filter($event)">5-6</div>--}}
                            {{--<div class="layui-colla-content" style="cursor:pointer;" @click="filter($event)">7-8</div>--}}
                        {{--</div>--}}
                        {{--<div class="layui-colla-item">--}}
                            {{--<h2 class="layui-colla-title">星期</h2>--}}
                            {{--<div class="layui-colla-content" style="cursor:pointer;" @click="filter_1($event)">星期一</div>--}}
                            {{--<div class="layui-colla-content" style="cursor:pointer;" @click="filter_1($event)">星期二</div>--}}
                            {{--<div class="layui-colla-content" style="cursor:pointer;" @click="filter_1($event)">星期三</div>--}}
                            {{--<div class="layui-colla-content" style="cursor:pointer;" @click="filter_1($event)">星期四</div>--}}
                            {{--<div class="layui-colla-content" style="cursor:pointer;" @click="filter_1($event)">星期五</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
    @endsection

@section('js')

    <script src="{{asset('js/echarts.min.js')}}"></script>
    <script src="{{asset('js/axios.min.js')}}"></script>
    <script src="{{asset('js/Vue.js')}}"></script>
    @endsection

<script type="module">

    import {myModule} from '{{asset('js/mymodule.js')}}';
    let myModules = myModule();

    let app = new Vue({
        el:'#app',
        data:{
            msg:'首页数据',
            task:[],
            time:'',
            theWeek:'',
            data:'',
            number:'',
            week:'',
            session:''
        },
        methods:{
            //读取课程任务表和学期表
            taskList(){
                let _this = this;
                let URL = "{{url('admin/LaboratorySystem/getJson')}}" + "?" + "number=" + _this.number + "&week=" + _this.week + "&session=" + _this.session;

                console.log(URL);

                axios.get(URL).then(function (value) {
                    _this.data = value.data.task;
                    _this.time = value.data.time;
                    _this.theWeek = value.data.theWeek;
                    _this.task = value.data.task;


                    layui.use(['laypage','element','form'],function () {
                        let laypage = layui.laypage,
                            form = layui.form;
                        //监听下拉列表
                        form.on('select(number)',function (data) {
                            _this.number = data.value;
                            _this.taskList();
                        });
                        form.on('select(week)',function (data) {
                            _this.week = data.value;
                            _this.taskList();
                        });

                        form.on('select(session)',function (data) {
                            _this.session = data.value;
                            _this.taskList();
                        });

                        laypage.render({
                            elem:$('#pageinit'),
                            count:_this.data.length,
                            limit:8,
                            layout: ['count', 'prev', 'page', 'next', 'refresh', 'skip'],
                            jump:function (obj) {
                                // console.log(value.data.task);
                                _this.task = value.data.task.concat().splice((obj.curr - 1) * obj.limit,obj.limit);
                            }
                        });
                    });
                })

            },
            //获取筛选条件
            // filter(e){
            //     this.order = e.srcElement.innerHTML;
            // },
            // filter_1(e){
            //     this.types = e.srcElement.innerHTML;
            // }
        },
        mounted(){
            this.taskList();

        },
        computed:{
            filterTask(){
                const {task,order,types,data} = this;

                let taskArr = '';
                let search = "";
                let _this = this;
                let newArr = [];
                search = types + order;

                taskArr = task.filter(p=>p.search.indexOf(search) !== -1);

                // console.log(task.task);
                // layui.use(['laypage','element'],()=> {
                //     let laypage = layui.laypage;
                //
                //     laypage.render({
                //         elem:$('#pageinit'),
                //         count:taskArr.length,
                //         limit:8,
                //         layout: ['count', 'prev', 'page', 'next', 'refresh', 'skip'],
                //         jump:function (obj) {
                //             // console.log(task.concat().splice((obj.curr - 1) * obj.limit));
                //             console.log( (obj.curr - 1) * obj.limit);
                //             taskArr = task.concat().splice((obj.curr - 1) * obj.limit,obj.limit);
                //         }
                //     });
                // });

                return taskArr;
            }
        }
    })

</script>
