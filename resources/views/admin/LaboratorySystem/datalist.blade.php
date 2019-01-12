@extends('admin.statics')

@section('css')
    <link rel="stylesheet" href="{{asset('css/datalist.css')}}">
    <style>
        [v-cloak]{
            display: none;
        }
    </style>
    @endsection
@section('content')
    <div id="app" v-cloak>
        <div class="layui-tab">
            <ul class="layui-tab-title">
                {{--<li  class="layui-this">每个部分的统计图</li>--}}
                <li class="layui-this">实训室使用次数统计表</li>
                <li>班级上课次数统计表</li>
                <li>教师上课次数统计表</li>
                {{--<li>学期课程实验实习节数统计表</li>--}}
                {{--<li>实验安排周表</li>--}}
            </ul>
            <div class="layui-tab-content">
                {{--实训室使用次数统计--}}
                <div class="layui-tab-item layui-show">
                    <div class="layui-col-md12">
                        <div class="toolbar">
                            <button class="layui-btn" @click="getExcel2()">导出任务数据</button>
                        </div>
                        <table class="layui-table" lay-size="sm" id="test_table" lay-filter="test">
                            <colgroup>
                                <col width="20">
                                <col width="100">
                                <col width="50">
                                <col width="50">
                                <col width="50">
                                <col width="50">
                            </colgroup>
                            <thead>
                            <tr>
                                <td>ID</td>
                                <td>实验室名称</td>
                                <td>所属校区</td>
                                <td>编号</td>
                                <td>类型</td>
                                <td>使用次数</td>
                            </tr>
                            </thead>
                            <tbody v-if="laboratoryList.length !== 0">
                            <tr v-for="item in laboratoryList">
                                <td>@{{ item.id }}</td>
                                <td>@{{ item.lbname }}</td>
                                <td>@{{ item.isCampus ? '长堽' : '里建' }}</td>
                                <td>@{{ item.number }}</td>
                                <td>@{{ item.types }}</td>
                                <td>@{{ item.count }}</td>
                            </tr>
                            </tbody>
                            <tbody v-else>
                            <tr>
                                <td colspan="6" style="text-align: center;"><span class="layui-badge">暂无数据</span></td>
                            </tr>
                            </tbody>
                        </table>
                        <div id="pageinit"></div>
                    </div>
                </div>

                {{--班级上课次数统计--}}
                <div class="layui-tab-item">
                    <div class="layui-col-md12">
                        <div class="toolbar">
                            <button class="layui-btn" @click="getExcel3()">导出任务数据</button>
                            {{--<button class="layui-btn layui-btn-normal" name="picture" id="setExcel2">导入excel</button>--}}
                            <form action="#" method="post" class="layui-form" lay-filter="timeForm">
                                <div class="layui-input-inline">
                                    <select name="semester" lay-filter="test">
                                        {{--<option value="">学期</option>--}}
                                        <option v-for="(item,index) in timeList" :value="index">@{{item.time}}</option>
                                    </select>
                                </div>
                                <div class="layui-input-inline">
                                    <select name="semester" lay-filter="test2">
                                        {{--<option value="">学期</option>--}}
                                        <template v-if="twoClass.length != 0">
                                            <option v-for="(item,index) in twoClass" :value="index">@{{item.className}}</option>
                                        </template>
                                        <template v-else>
                                            <option value="">没有相关的数据</option>
                                        </template>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <table class="layui-table" lay-size="sm" id="test_table" lay-filter="test">
                            <colgroup>
                                <col width="20">
                                <col width="100">
                                <col width="50">
                                <col width="50">
                                <col width="50">
                                <col width="50">
                            </colgroup>
                            <thead>
                            <tr>
                                <td>ID</td>
                                <td>班级</td>
                                <td>人数</td>
                                <td>上课次数</td>
                            </tr>
                            </thead>
                            <tbody v-if="classList.length">
                            <tr v-for="item in classList">
                                <td>@{{ item.id }}</td>
                                <td>@{{ item.className }}</td>
                                <td>@{{ item.classNumber }}</td>
                                <td>@{{ item.count }}</td>
                            </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="4" style="text-align: center;"><span class="layui-badge">暂无数据</span></td>
                                </tr>
                            </tbody>
                        </table>
                        <div id="pageinit2"></div>
                    </div>
                </div>

                {{--教师上课次数--}}
                <div class="layui-tab-item">
                    <div class="layui-col-md12">
                        <div class="toolbar">
                            <button class="layui-btn" @click="getExcel3()">导出任务数据</button>
                        </div>
                        <table class="layui-table" lay-size="sm" id="test_table" lay-filter="test">
                            <colgroup>
                                <col width="20">
                                <col width="100">
                                <col width="50">
                                <col width="50">
                                <col width="50">
                                <col width="50">
                            </colgroup>
                            <thead>
                            <tr>
                                <td>ID</td>
                                <td>姓名</td>
                                <td>邮箱</td>
                                <td>是否管理员</td>
                                <td>最后登录时间</td>
                                <td>上课次数</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in teacherList">
                                <td>@{{ item.id }}</td>
                                <td>@{{ item.name }}</td>
                                <td>@{{ item.email }}</td>
                                <td>@{{ item.isAdmin ? '是' : '否' }}</td>
                                <td>@{{ item.lasttime }}</td>
                                <td>@{{ item.count }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <div id="pageinit3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
@section('js')
    <script src="{{asset('js/echarts.js')}}"></script>
    <script type="module">
        //加载模块
        import {myModule} from '{{asset('js/mymodule.js')}}';
        let myModules = myModule();

        let app = new Vue({
            el:'#app',
            data:{
                filerClass:"",              //班级筛选
                laboratoryList:"",          //实训室数据
                classList:"",               //班级数据
                teacherList:"",             //教师数据源
                // idTmr:'',
                // data:[]                     //所有数据
                timeList:'',
                a:0,                        //二级联动学期
                b:0,                        //二级联动班级
                selectDate:{
                    one:'',
                    two:''
                }
            },
            methods:{
                //每个部分的使用次数统计图
                myCharts(){
                    // 基于准备好的dom，初始化echarts实例
                    // var myChart = echarts.init(document.getElementById('main'));
                    // console.log(this.$refs);
                    // 指定图表的配置项和数据
                    // var option = {
                    //     title: {
                    //         text: 'ECharts 入门示例'
                    //     },
                    //     tooltip: {},
                    //     legend: {
                    //         data:['销量']
                    //     },
                    //     xAxis: {
                    //         data: ["衬衫","羊毛衫","雪纺衫","裤子","高跟鞋","袜子"]
                    //     },
                    //     yAxis: {},
                    //     series: [{
                    //         name: '销量',
                    //         type: 'bar',
                    //         data: [5, 20, 36, 10, 10, 20]
                    //     }]
                    // };
                    //
                    // // 使用刚指定的配置项和数据显示图表。
                    // myChart.setOption(option);
                },
                //导出班级的Excel
                getExcel3(){
                    // myModules.JSONToExcelConvertor(this.data.class,'班级上课统计表');
                    let URL = "{{url('admin/LaboratorySystem/datalist/expExcel')}}";
                    window.location.href = URL;
                },
                //导出实训室的excel
                getExcel2(){
{{--                    let URL = "{{url('admin/LaboratorySystem/datalist/expExcel')}}";--}}
                    // window.location = URL;

                },
                //渲染实验室数据
                axioslist(){
                    let URL = '{{asset('admin/LaboratorySystem/getJson2')}}';
                    let _this = this;

                    // myModules.newLayPage(URL,this,$('#pageinit'))

                    //发起异步请求
                    axios.get(URL).then(function (value) {
                        let data = value.data;
                        //加载layui模块
                        layui.use(['laypage','element','table','form'],function () {
                            let laypage = layui.laypage,
                                table = layui.table;

                            //将数据进行分页处理
                            laypage.render({
                                elem:$('#pageinit'),
                                count:data.laboratory.length,
                                limit:8,
                                layout: ['count', 'prev', 'page', 'next', 'refresh', 'skip'],
                                jump:function (obj) {
                                    _this.laboratoryList = data.laboratory.concat().splice((obj.curr - 1) * obj.limit,obj.limit);
                                }
                            });
                        })
                    });
                },
                //班级数据源 && 二级联动
                classAxios(){
                    let _this = this;
                    let URL = '{{asset('admin/LaboratorySystem/getJson2')}}';

                    //发起异步请求
                    layui.use(['laypage','element','table','form'],function () {
                        let laypage = layui.laypage,
                            table = layui.table,
                            form = layui.form;


                            //班级二级联动    Cannot convert undefined or null to object
                            //监听学期
                            form.on('select(test)',function (data) {
                                _this.a = Number(data.value);
                                _this.selectDate.one = _this.timeList[_this.a].time;

                                _this.selectDate.two = '';
                                //需要再请求一次，select才会联动
                                _this.classAxios();

                            });

                            //监听班级
                            form.on('select(test2)',function (data) {
                                _this.b = Number(data.value);
                                // console.log(_this.twoClass[_this.b].className);

                                _this.selectDate.two = _this.twoClass[_this.b].className;
                                _this.classAxios();
                            });

                            //拼接监听到的值并传送到后台
                            // console.log(_this.selectDate.two);
                            axios.get(URL + '?' + 'one='+_this.selectDate.one + '&' + 'two=' +_this.selectDate.two).then(function (value) {
                                let data = value.data;
                                //更新渲染select
                                form.render('select','timeForm');

                                //将数据进行分页处理
                                laypage.render({
                                    elem:$('#pageinit2'),
                                    count:data.class.length,
                                    limit:8,
                                    layout: ['count', 'prev', 'page', 'next', 'refresh', 'skip'],
                                    jump:function (obj) {
                                        _this.classList = data.class.concat().splice((obj.curr - 1) * obj.limit,obj.limit);
                                    }
                                });
                            })
                    });
                },
                //渲染学期
                timeAxuis(){
                    let URL = '{{asset('admin/LaboratorySystem/getJson2')}}';
                    axios.get(URL).then((value)=>{
                        // console.log(value);
                        let data = value.data;
                        this.timeList = data.time;
                        // return this.timeList;
                    });
                },
                //教师上课次数数据源
                teacherAxios(){
                    let _this = this;
                    let URL = "{{url('admin/LaboratorySystem/getJson2')}}";

                    layui.use(['laypage','element','table','form'],function () {
                        let laypage = layui.laypage,
                            table = layui.table,
                            form = layui.form;


                        axios.get(URL).then(function (data) {
                            // console.log(data.data.admin);
                            let Data = data.data.admin;

                            laypage.render({
                                elem:$('#pageinit3'),
                                count:Data.length,
                                layout: ['count', 'prev', 'page', 'next', 'refresh', 'skip'],
                                jump:function (obj) {
                                    _this.teacherList = Data.concat().splice((obj.curr - 1) * obj.limit,obj.limit);
                                }
                            })
                        })

                    })
                }
            },
            mounted(){
                // this.myCharts();

                //渲染教师数据
                this.teacherAxios();

                //渲染学期
                this.timeAxuis();

                //渲染班级数据
                this.classAxios();

                //渲染实验室统计数据
                this.axioslist();

                layui.use('upload',function () {
                    let upload = layui.upload;
                    upload.render({
                        elem:'#setExcel2',
                        accept:'file',
                        method:'POST',
                        type:'file',
                        url:'{{asset('admin/LaboratorySystem/datalist/import')}}',
                        data:{'_token':'{{csrf_token()}}'},
                        before:function(obj){
                            layer.load();
                        },
                        done:function (res,index,upload) {
                            if(res === 1){
                                myModules.newLayer(1,'导入成功')
                            }
                        }
                    })
                });
            },
            computed:{
                twoClass(){
                    const {timeList,a}=this;
                    return timeList[a]['tClassName'];
                }
            },
            filters:{
                //格式化时间戳
                formatDate(time){
                    // console.log(time)
                    if(time){
                        return new Date(parseInt(time) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ')
                    }
                }
            },

        });
        // console.log(document.querySelector('#main').outerHTML);
    </script>
    @endsection