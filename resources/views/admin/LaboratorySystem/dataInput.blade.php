@extends('admin.statics')
@section('css')
    <link rel="stylesheet" href="{{asset('css/dataInput.css')}}">
@endsection

@section('content')
    <div class="layui-tab layui-tab-card" id="app">
        <ul class="layui-tab-title">
            <li  class="layui-this">任务</li>
            {{--<li>实习任务</li>--}}
            <li>学期和实验室参数</li>
        </ul>
        <div class="layui-tab-content">
            {{--任务--}}
            <div class="layui-tab-item  layui-show">
                <div class="layui-col-md10">
                    <div class="layui-btn-group layui-col-md3" style="margin-bottom: 0.5rem">
                        <button class="layui-btn" @click="add(4)">安排</button>
                        <button class="layui-btn" @click="pSort(sortIndex = !sortIndex)">@{{ sortIndex ? '升序' : '降序' }}</button>
                    </div>
                    <div class="layui-col-md2 layui-col-md-offset7">
                        <input type="text" class="layui-input" v-model="search" @keyup.enter="newSearch()" placeholder="搜索">
                    </div>
                </div>
                <hr>
                <table class="layui-table" lay-size="sm">
                    <colgroup>
                        <col width="70">
                        <col width="200">
                        <col width="170">
                        <col width="300">
                        <col width="100">
                        <col width="100">
                        <col width="100">
                        <col width="100">
                    </colgroup>
                    <thead>
                    <tr>
                        <td>ID</td>
                        <td>节次</td>
                        <td>课程名称</td>
                        <td>班别</td>
                        <td>实验室</td>
                        <td>任课教师</td>
                        <td>任务类型</td>
                        <td>操作</td>
                    </tr>
                    </thead>
                    <tbody v-if="publicList.courseList.length !== 0">
                    <tr v-for="(item,key) in publicList.courseList" @dblclick="add(5,key)" v-cloak>
                        <td>@{{ item.id }}</td>
                        <td>@{{ item.session }}</td>
                        <td>@{{ item.name}}</td>
                        <td>@{{ item.className }}</td>
                        <td>@{{ item.lbname }}</td>
                        <td>@{{ item.tname }}</td>
                        <td>@{{ item.types ? '实习' : '课程' }}</td>
                        <td>
                            <div class="layui-btn-group">
                                <button class="layui-btn layui-btn-danger layui-btn-sm" @click="inputDel(3,item.id)">删除</button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                    <tbody v-else>
                    <tr>
                        <td colspan="8" style="text-align: center;"><span class="layui-badge">暂无数据</span></td>
                    </tr>
                    </tbody>
                </table>
                <div id="course_page1"></div>
            </div>


            {{--实验室参数，学期管理--}}
            <div class="layui-tab-item" style="height: 700px;">
                <div class="layui-col-md7" >
                    <div class="layui-card">
                        <div class="layui-card-header">
                            实验室参数
                            <button class="layui-btn layui-btn-sm add" @click="add(1)">添加</button>
                        </div>
                        <div class="layui-card-body">
                            <div class="layui-collapse">
                                <div class="layui-colla-item">
                                    <h2 class="layui-colla-title">编号和类型</h2>
                                    <div class="layui-colla-content layui-show">
                                        <table class="layui-table" v-if="publicList.explist!==undefined" lay-size="sm">
                                            <colgroup>
                                                <col width="50">
                                                <col width="1000">
                                                <col width="100">
                                                <col width="50">
                                            </colgroup>
                                            <tbody>
                                            <tr v-for="item in publicList.explist"  class="item">
                                                <td>@{{ item.id }}</td>
                                                <td>@{{ item.name }}</td>
                                                <td>@{{ item.types ? '类型' : '编号' }}</td>
                                                <td>
                                                    <button class="layui-btn layui-btn-sm layui-btn-danger" @click="inputDel(0,item.id)">删除</button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <div id="page_init"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md5">
                    <form action="{{asset('admin/LaboratorySystem/dataInput/commencementTime')}}" method="POST" @submit.prevent="timeAdd" style="margin-bottom: 15px;" autocomplete="off">
                        <div class="layui-inline">
                            <input type="text" class="layui-input" readonly="value"  placeholder="开始时间" id="test_date1">
                        </div>
                        <span>———</span>
                        <div class="layui-inline">
                            <input type="text" class="layui-input" readonly="value" name="session" placeholder="结束时间" id="test_date2">
                        </div>
                        <div class="layui-inline">
                            <input type="submit" class="layui-btn" value="添加">
                        </div>
                    </form>
                    <table class="layui-table" lay-even lay-size="sm">
                        <colgroup>
                            <col width="400">
                            <col width="200">
                            <col width="200">
                        </colgroup>
                        <thead>
                        <tr>
                            <td>学期</td>
                            <td>周数</td>
                            <td>操作</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item,index) in publicList.timeList">
                            <td>@{{ item.start}} 至 @{{ item.end }}@{{ index===0 ? '(默认学期)' : '' }}</td>
                            <td>@{{ item.week }}</td>
                            <td>
                                <button class="layui-btn layui-btn-sm layui-btn-danger" @click="inputDel(1,item.id)">删除</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div id="page_init_2"></div>
                </div>
            </div>
            </div>

            {{--实验参数的弹窗--}}
        <div id="test5" style="display: none;">
            <form action="#" method="POST" class="layui-form layui-col-md8 layui-col-md-offset1 form_3" @submit.prevent="submitExpAdd" style="margin-top: 50px;">
                <div class="layui-form-item">
                    <label class="layui-form-label"></label>
                    <div class="layui-input-block">
                        <input type="text" class="layui-input" name="name" v-model="expFormObj.name" placeholder="请输入">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"></label>
                    <div class="layui-input-block" >
                        <input type="radio" name="types" value="0" title="编号">
                        <input type="radio" name="types"  value="1" title="类型" checked>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <input
                                type="submit"
                                lay-filter="formDemo3"
                                lay-submit
                                class="layui-btn layui-btn-sm layui-btn-fluid submit_3"
                                value="确认">
                    </div>
                </div>
            </form>
        </div>

            {{--任务的弹窗--}}
        <div id="test4" style="display: none;">
            {{--@{{ newSelected.time[0] }}--}}
            <form action="#" method="post" class="layui-form layui-col-md8 layui-col-md-offset1" @submit.prevent="practiceAdd()">
                <input type="hidden" name="time" class="layui-input" :value="time2">
                <div class="layui-form-item">
                    <label class="layui-form-label">周</label>
                    <div class="layui-input-block">
                        <select name="week1" lay-verify="required">
                            @for($i=1;$i<23;$i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">星期</label>
                    <div class="layui-input-block">
                        <select name="week2">
                            <option value="星期一">星期一</option>
                            <option value="星期二">星期二</option>
                            <option value="星期三">星期三</option>
                            <option value="星期四">星期四</option>
                            <option value="星期五">星期五</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">节次</label>
                    <div class="layui-input-block">
                        <select name="session">
                            <option value="1-2">1-2</option>
                            <option value="3-4">3-4</option>
                            <option value="5-6">5-6</option>
                            <option value="7-8">7-8</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">任务类型</label>
                    <div class="layui-input-block">
                        <input type="radio" name="types" value="0" title="课程" checked>
                        <input type="radio" name="types" value="1" title="实习">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">任课教师</label>
                    <div class="layui-input-block">
                        <select name="teachername">
                            <option v-for="item in newSelected.teacher" :value="item.id">@{{ item.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">课程名称</label>
                    <div class="layui-input-block">
                        <select name="coursename">
                            {{--@foreach($course as $value)--}}
                            {{--<option value="{{$value->id}}">{{$value->name}}</option>--}}
                            {{--@endforeach--}}
                            <option v-for="item in newSelected.course" :value="item.id">@{{ item.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">班级</label>
                    <div class="layui-input-block">
                        <select name="classname">
                            {{--@foreach($class as $value)--}}
                            {{--<option value="{{$value->id}}">{{$value->className}}</option>--}}
                            {{--@endforeach--}}
                            <option v-for="item in newSelected.class" :value="item.id">@{{ item.className }}</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">实验室</label>
                    <div class="layui-input-block">
                        <select name="laboratory">
                            <option v-for="item in newSelected.laboratory" :value="item.id">@{{ item.lbname }}</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">内容</label>
                    <div class="layui-input-block">
                        <textarea class="layui-textarea" name="content"></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <input type="submit" class="layui-btn layui-btn-sm layui-btn-fluid" value="确认">
                    </div>
                </div>
            </form>
        </div>
        <div id="edit_2" style="display: none;">
            <form action="#" method="post" class="layui-form layui-col-md8 layui-col-md-offset1" lay-filter="formEdit" @submit.prevent="practiceAdd(1)">
                <input type="hidden" name="time" class="layui-input" :value="time2">
                <div class="layui-form-item" id="week1">
                    <label class="layui-form-label">周</label>
                    <div class="layui-input-block">
                        <select name="week1" lay-verify="required">
                            @for($i=1;$i<23;$i++)
                                <option value="{{$i}}"  >{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="layui-form-item" id="week2">
                    <label class="layui-form-label">星期</label>
                    <div class="layui-input-block">
                        <select name="week2">
                            <option value="星期一">星期一</option>
                            <option value="星期二">星期二</option>
                            <option value="星期三">星期三</option>
                            <option value="星期四">星期四</option>
                            <option value="星期五">星期五</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item" id="sesstion">
                    <label class="layui-form-label">节次</label>
                    <div class="layui-input-block">
                        <select name="session">
                            <option value="1-2">1-2</option>
                            <option value="3-4">3-4</option>
                            <option value="5-6">5-6</option>
                            <option value="7-8">7-8</option>
                            <option value="9-10">9-10</option>
                        </select>
                        {{--<input type="radio" name="session" title="1-2">--}}
                        {{--<input type="radio" name="session" title="3-4">--}}
                        {{--<input type="radio" name="session" title="5-6">--}}
                        {{--<input type="radio" name="session" title="7-8">--}}
                        {{--<input type="radio" name="session" title="9-10">--}}
                    </div>
                </div>
                <div class="layui-form-item" id="types">
                    <label class="layui-form-label">任务类型</label>
                    <div class="layui-input-block">
                        <input type="radio" name="types" value="0" title="课程" checked>
                        <input type="radio" name="types" value="1" title="实习">
                    </div>
                </div>
                <div class="layui-form-item" id="teachername">
                    <label class="layui-form-label">任课教师</label>
                    <div class="layui-input-block">
                        <select name="teachername">
                            <option v-for="item in newSelected.teacher" :value="item.id">@{{ item.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item" id="coursename">
                    <label class="layui-form-label">课程名称</label>
                    <div class="layui-input-block">
                        <select name="coursename">
                            {{--@foreach($course as $value)--}}
                            {{--<option value="{{$value->id}}">{{$value->name}}</option>--}}
                            {{--@endforeach--}}
                            <option v-for="item in newSelected.course" :value="item.id">@{{ item.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item" id="classname">
                    <label class="layui-form-label">班级</label>
                    <div class="layui-input-block">
                        <select name="classname">
                            {{--@foreach($class as $value)--}}
                            {{--<option value="{{$value->id}}">{{$value->className}}</option>--}}
                            {{--@endforeach--}}
                            <option v-for="item in newSelected.class" :value="item.id">@{{ item.className }}</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item" id="lbname">
                    <label class="layui-form-label">实验室</label>
                    <div class="layui-input-block">
                        <select name="laboratory">
                            <option v-for="item in newSelected.laboratory" :value="item.id">@{{ item.lbname }}</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item" id="content">
                    <label class="layui-form-label">内容</label>
                    <div class="layui-input-block">
                        <textarea class="layui-textarea" name="content"></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <input type="submit" class="layui-btn layui-btn-sm layui-btn-fluid" value="确认">
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

        let app = new Vue({
            el:'#app',
            data:{
                publicList:{
                    explist:{},         //实验参数展示对象
                    timeList:{},        //学期展示对象
                    courseList:{}       //课程展示
                },
                expFormObj:{},
                URL:'',
                time:[],
                newSelected:{},           //下拉列表的集合
                index:0,                 //数据集合的索引(存储需要修改id)
                sortIndex:true,
                search:'',
                time2:'',
            },
            methods:{
                //搜索功能
                newSearch(){
                    this.ctList();
                },
                //任务排序    Error in render: "TypeError: listArr[i].filter is not a function"
                pSort(order){
                    // console.log(order);
                    this.ctList();
                },
                //渲染表单下拉列表的数据
                formSelect(){
                    let URL = '{{asset('admin/LaboratorySystem/dataInput/inputDel/inputData')}}';
                    axios.get(URL).then((value)=>{

                        this.newSelected = value.data;

                        //最近添加的学期为默认
                        this.time2 = this.newSelected.time[0];
                    })
                },
                //课程任务的添加和修改
                practiceAdd(i){
                    // console.log(i);
                    let _this = this;
                    $.fn.serializeObject = function()
                    {
                        var o = {};
                        var a = this.serializeArray();
                        $.each(a, function() {
                            if (o[this.name] !== undefined) {
                                if (!o[this.name].push) {
                                    o[this.name] = [o[this.name]];
                                }
                                o[this.name].push(this.value || '');
                            } else {
                                o[this.name] = this.value || '';
                            }
                        });
                        return o;
                    };

                    {{--//如果i有值，则执行修改功能--}}
                    if(i){
                        // alert('修改');
                        let URL = '{{asset('admin/LaboratorySystem/dataInput')}}';
                        let id = this.index;
                        let obj = $('#edit_2 form').serializeObject();

                        // console.log(id);

                        axios.put(URL+'/'+id,{obj}).then(function (value) {
                            // console.log(value);
                            if(value.data === 1){
                                myModules.newLayer(1,'修改成功');
                                _this.ctList();

                            }else if (value.data === 0) {
                                layer.closeAll();
                            }else {
                                myModules.newLayer(0,value.data)
                            }
                        });


                        return false;
                    }

                    let URL = '{{asset('admin/LaboratorySystem/dataInput/inputDel/course')}}';

                    let data = $('#test4 form').serializeObject();
                    // console.log(data);
                    axios.post(URL,{data}).then((value) => {
                        // console.log(value);
                        if(value.data === 1){
                            myModules.newLayer(1,'添加成功');
                            this.ctList();
                        }else {
                            myModules.newLayer(0,value.data)
                        }
                    });

                    return false;

                },
                //该模板的公共弹窗
                add(v,k){
                    if(v === 1){                   //1、实验参数弹窗
                        myModules.newLayerOpen(1,$('#test5'),'300px')
                    }


                    if(v === 4){                   //任务添加
                        myModules.newLayerOpen(1,$('#test4'),'500px');
                    }


                    if(v === 5){                   //任务修改
                        //处理原始数据
                        //周
                        let week1 = this.publicList.courseList[k].week1;
                        $('#week1 dl dd[lay-value='+week1+']').click();

                        //星期
                        let week2 = this.publicList.courseList[k].week2;
                        $('#week2 dl dd[lay-value='+week2+']').click();

                        //节次
                        let sesstion = this.publicList.courseList[k].session;
                        $('#sesstion dl dd[lay-value='+sesstion+']').click();

                        //类型
                        let types = this.publicList.courseList[k].types;
                        $('#types input[value='+types+']').next().click();

                        //任课老师
                        let teachername = this.publicList.courseList[k].teachername;
                        $('#teachername dl dd[lay-value='+teachername+']').click();

                        //课程名称
                        let coursename = this.publicList.courseList[k].coursename;
                        $('#coursename dl dd[lay-value='+coursename+']').click();

                        //班级
                        let classname = this.publicList.courseList[k].classname;
                        $('#classname dl dd[lay-value='+classname+']').click();

                        //实验室
                        let laboratory = this.publicList.courseList[k].laboratory;
                        $('#lbname dl dd[lay-value='+laboratory+']').click();

                        //内容
                        $('#content textarea').html(this.publicList.courseList[k].content);

                        //存储id
                        this.index = this.publicList.courseList[k].id;



                        myModules.newLayerOpen(0,$('#edit_2'),'500px');
                    }
                },
                //展示课程任务
                ctList(){
                    let URL = '{{asset('admin/LaboratorySystem/dataInput/inputDel/courseList')}}' + '?' + 's=' + this.search + '&sort=' + this.sortIndex;

                    let str = this;
                    axios.get(URL).then(function (value) {
                        let data = value.data;

                        layui.use(['laypage','element'],function () {
                            let laypage = layui.laypage;
                            laypage.render({
                                elem:$('#course_page1'),
                                count:data.length,
                                limit:8,
                                layout: ['count', 'prev', 'page', 'next', 'refresh', 'skip'],
                                jump:function (obj) {
                                    str.publicList.courseList = data.concat().splice((obj.curr - 1) * obj.limit,obj.limit);
                                }
                            })
                        })
                    })

                },
                //展示实验室参数
                expList(){
                    //实验室参数数据接口
                    let expUrl = '{{asset('admin/LaboratorySystem/dataInput/lbApi')}}';
                            {{--myModules.newLayPage(expUrl,this,$('#page_init'))--}}
                    let str = this;
                    // console.log(expUrl);

                    axios.get(expUrl).then(function (value) {
                        let data = value.data;

                        layui.use(['laypage','element'],function () {
                            let laypage = layui.laypage;
                            laypage.render({
                                elem:$('#page_init'),
                                count:data.length,
                                limit:8,
                                layout: ['count', 'prev', 'page', 'next', 'refresh', 'skip'],
                                jump:function (obj) {
                                    str.publicList.explist = data.concat().splice((obj.curr - 1) * obj.limit,obj.limit);
                                }
                            })
                        })

                    });
                },
                //添加实验室参数
                submitExpAdd(){
                    //处理实验室参数的单选按钮
                    let expRadioVal = $('#test5 input[name=types]:checked').val();
                    let expFormObj = this.expFormObj;

                    this.$set(expFormObj,'types',expRadioVal);


                    let expObj = this.expFormObj;
                    let URL = this.URL = '{{asset('admin/LaboratorySystem/dataInput')}}';

                    axios.post(URL,{expObj}).then((value) => {
                            if(value.data === 1){
                                myModules.newLayer(1,'参数添加成功');
                                this.expList();
                            }else {
                                // myModules.newLayer(0,value.data.name[0]);
                                // console.log(value.data.name[0]);
                            }
                    });
                    return false;
                },
                //调用layui的laydate   month
                laydateFn(elm){
                    let str = this;
                    let layTime = [];
                    layui.use(['laydate'],function () {
                        let laydate = layui.laydate;

                        laydate.render({
                            elem:elm,
                            theme: 'molv',
                            done:function (value, date, endDate) {
                                //将生成的值存储到time属性中，方便异步处理
                                str.time.push(value);
                            }
                        })
                    });
                    // this.time = layTime; 开始
                },
                //添加学期
                timeAdd(){
                    let item = this.time;
                    let URL = '{{asset('admin/LaboratorySystem/dataInput/sTime')}}';
                    axios.post(URL,{item}).then((value) => {
                        // console.log(value);
                        if(value.data === 1){
                            myModules.newLayer(1,'添加成功');
                            this.timeList();
                        }else {
                            myModules.newLayer(0,value.data);
                        }
                });

                    //添加结束后清空数组
                    this.time = [];
                },
                //展示学期数据
                timeList(){
                    let timeURL = '{{asset('admin/LaboratorySystem/dataInput/getTime')}}';
                    let str = this;

                    axios.get(timeURL).then(function (value) {
                        let data = value.data;
                        // console.log(value);
                        layui.use(['laypage','element'],function () {
                            let laypage = layui.laypage;
                            laypage.render({
                                elem:$('#page_init_2'),
                                count:data.length,
                                limit:5,
                                layout: ['count', 'prev', 'page', 'next', 'refresh', 'skip'],
                                jump:function (obj) {
                                    str.publicList.timeList = data.concat().splice((obj.curr - 1) * obj.limit,obj.limit);
                                }
                            })
                        })
                    });
                },
                //实验室渲染
                laboratoryList(){

                },
                //将这个模板的删除功能整合到一起
                inputDel(order,id,){

                    let URL = '';

                    URL = '{{asset('admin/LaboratorySystem/dataInput/inputDel')}}' + '/'+ id + '/' + order;
                    // console.log(URL+'/'+id+'/'+order);
                    axios.get(URL).then((value)=>{
                        if(value.data === 1){
                            myModules.newLayer(1,'删除成功');

                            if(order === 0){
                                this.expList();
                            }else if(order === 1){
                                this.timeList();
                            }else if (order === 2){
                                this.practiceList();
                            }else if(order === 3){
                                this.ctList();
                            }
                        }
                    })
                },
            },
            mounted(){
                //展示课程任务
                this.ctList();

                //展示实验室参数
                this.expList();
                // console.log(this.publicList.selectList);

                //展示学期数据
                this.timeList();

                //渲染表单下拉数据
                this.formSelect();

                //调用layui的laydate模块
                this.laydateFn('#test_date1');
                this.laydateFn('#test_date2');

            },
            computed:{
                sortAdnSearch(){
                    const {search,publicList,index} = this;
                    let listArr = [];
                    let oldArr = [];

                    $.each(publicList.courseList,function (index,item) {
                        oldArr.push(item);
                    });
                    // console.log(oldArr);

                    // listArr = oldArr.filter((blog) =>{
                    //     return blog.lbname.match(search)
                    //     // console.log(blog.className)
                    // });

                    return oldArr;
                }
            }
        });
    </script>
    @endsection


