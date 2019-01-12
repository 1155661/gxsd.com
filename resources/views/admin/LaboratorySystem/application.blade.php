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
            <h2>待批申请</h2>
        </div>
        <div class="layui-card-body">
            <div class="layui-badge">双击信息安排实验室</div>
            <table class="layui-table" lay-size="sm">
                <colgroup>
                    <col width="100">
                    <col width="100">
                    <col width="100">
                    <col width="100">
                    <col width="100">
                    <col width="100">
                    <col width="100">
                    <col width="100">
                    <col width="100">
                    <col width="300">
                </colgroup>
                <thead>
                <tr>
                    <td>周</td>
                    <td>星期</td>
                    <td>节数</td>
                    <td>课程</td>
                    <td>申请时间</td>
                    <td>申请人</td>
                    <td>状态</td>
                    <td>操作</td>
                </tr>
                </thead>
                <tbody>
                <template v-if="list.length !== 0">
                    <tr v-for="(item,key) in list" v-cloak v-if="item.status !== 1 && item.status !== -1" @dblclick="edit(item.id)">
                        <td>@{{ item.week1 }}</td>
                        <td>@{{ item.week2 }}</td>
                        <td>@{{ item.session }}</td>
                        <td>@{{ item.name }}</td>
                        <td>@{{ item.apptime }}</td>
                        <td>@{{ item.tname }}</td>
                        <td>@{{ item.status ? '处理成功' : '申请中' }}</td>
                        <td v-if="item.status === 0">
                            {{--<button class="layui-btn layui-btn-sm layui-btn-danger layui-btn-disabled">取消申请</button>--}}
                            <div class="layui-btn-group">
                                {{--<button class="layui-btn layui-btn-sm" @click="add(key)">同意</button>--}}
                                <button class="layui-btn layui-btn-sm layui-btn-danger" @click="del(key)">不同意</button>
                            </div>
                        </td>
                        <td v-else>
                            <button class="layui-btn layui-btn-sm layui-btn-disabled">禁止操作</button>
                        </td>
                    </tr>
                    <tr v-for="(item,key) in list" v-cloak v-if="item.status === 1 || item.status === -1">
                        <td>@{{ item.week1 }}</td>
                        <td>@{{ item.week2 }}</td>
                        <td>@{{ item.session }}</td>
                        <td>@{{ item.name }}</td>
                        <td>@{{ item.apptime }}</td>
                        <td>@{{ item.tname }}</td>
                        <td>@{{ item.status ? '处理成功' : '申请中' }}</td>
                        <td v-if="item.status === 0">
                            {{--<button class="layui-btn layui-btn-sm layui-btn-danger layui-btn-disabled">取消申请</button>--}}
                            {{--<button class="layui-btn layui-btn-sm" @click="add(key)">同意</button>--}}
                            <button class="layui-btn layui-btn-sm layui-btn-danger" @click="del(key)">不同意</button>
                        </td>
                        <td v-else>
                            <button class="layui-btn layui-btn-sm layui-btn-disabled">禁止操作</button>
                        </td>
                    </tr>
                </template>
                <template v-else>
                    <tr>
                        <td colspan="9"  style="text-align: center;"><span class="layui-badge">暂无申请</span></td>
                    </tr>
                </template>
                </tbody>
            </table>
            <div id="page"></div>
        </div>

        {{--修改弹窗--}}
        <div id="edit" style="display: none;">
            <form action="#" method="post" class="layui-form layui-col-md8 layui-col-md-offset1" @submit.prevent="apply()" lay-filter="edit">
                <input type="hidden" name="time" class="layui-input" :value="selectObj.theTime">
                <input type="hidden" name="teachername" value="">
                <input type="hidden" name="id" value="">
                <div class="layui-form-item" id="week1" style="margin-top: 2rem;">
                    <label class="layui-form-label">周</label>
                    <div class="layui-input-block">
                        <select name="week1" lay-verify="required" lay-filter="week1">
                            @for($i=1;$i<23;$i++)
                                <option value="{{$i}}"  >{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="layui-form-item" id="week2">
                    <label class="layui-form-label">星期</label>
                    <div class="layui-input-block">
                        <select name="week2" lay-filter="week2">
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
                        <select name="session" lay-filter="session">
                            <option value="1-2">1-2</option>
                            <option value="3-4">3-4</option>
                            <option value="5-6">5-6</option>
                            <option value="7-8">7-8</option>
                            <option value="9-10">9-10</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item" id="types">
                    <label class="layui-form-label">任务类型</label>
                    <div class="layui-input-block">
                        <input type="radio" name="types" value="0" title="课程" checked>
                        <input type="radio" name="types" value="1" title="实习">
                    </div>
                </div>
                <div class="layui-form-item" id="coursename">
                    <label class="layui-form-label">课程名称</label>
                    <div class="layui-input-block">
                        {{--<input type="text" name="name" class="layui-input">--}}
                        <select name="name" lay-search>
                            <option value="">选择课程</option>
                            <option v-for="(item,key) in selectObj.course" :value="item.name">@{{ item.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item" id="classname">
                    <label class="layui-form-label">班级</label>
                    <div class="layui-input-block">
                        <select name="classname" lay-search>
                            <option value="">选择班级</option>
                            <option v-for="item in selectObj.class" :value="item.id">@{{ item.className }}</option>
                            {{--<option v-for="item in selectObj.class" :value="item.id">@{{ item.className }}</option>--}}
                        </select>
                    </div>
                </div>
                <div class="layui-form-item" id="lbname">
                    <label class="layui-form-label">空置实验室</label>
                    <div class="layui-input-block">
                        <select name="laboratory" lay-search>
                            <option value="">选择实验室</option>
                            <option v-for="item in lbDate" :value="item.id">@{{ item.lbname }}</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item" id="content">
                    <label class="layui-form-label">备注</label>
                    <div class="layui-input-block">
                        <textarea class="layui-textarea" name="content"></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <input type="submit" class="layui-btn layui-btn-sm layui-btn-fluid" lay-filter="apply" value="安排">
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
                list:[],
                selectObj:'',
                lbDate:'',
                week1:'',
                week2:'',
                session:'',
                id:''
            },
            methods:{
                //返回实验室数据
                getLaboratory(id){
                    let URL = "{{url('admin/LaboratorySystem/application/getLaboratory')}}";
                    let _this = this;

                    layui.use(['form'],function () {
                        let form = layui.form;

                        form.on('select(week1)',function (data) {
                            _this.week1 = data.value;
                            _this.getLaboratory();
                        });

                        form.on('select(week2)',function (data) {
                            _this.week2 = data.value;
                            _this.getLaboratory();
                        });

                        form.on('select(session)',function (data) {
                            _this.session = data.value;
                            _this.getLaboratory();
                        })

                    });

                    let str = '?time='
                        +_this.selectObj.theTime
                        +'&week1=' +_this.week1
                        +'&week2=' +_this.week2
                        +'&session=' +_this.session
                        +'&lb=' + _this.lbDate;

                    axios.get(URL+str).then((value) => {
                        // console.log(value.data);
                        this.lbDate = value.data;
                    })
                },
                //提交安排课程的信息
                apply(){
                    //解析序列化后的字符串
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



                    let data = $('#edit form').serializeObject();
                    let URL = "{{url('admin/LaboratorySystem/application')}}"+"/"+data.id;

                    axios.put(URL,{data}).then((value => {
                        // console.log(value)
                        if(value.data === 1){
                            myModules.newLayer(1,'安排成功');
                            this.appList();
                        }else {
                            myModules.newLayer(0,value.data);
                        }
                    }))

                },
                //修改申请信息
                edit(id){
                    let URL = "{{url('admin/LaboratorySystem/application/')}}" + "/"+ id;
                    let _this = this;


                    //异步获取对应的申请信息
                    axios.get(URL).then((value)=>{
                        // console.log(value.data[0]);
                        layui.use(['form'],function () {
                            let form = layui.form;
                            // console.log(value.data);
                            form.val("edit",{
                                "week1":value.data[0].week1,
                                "week2":value.data[0].week2,
                                "session":value.data[0].session,
                                "types":value.data[0].types,
                                "name":value.data[0].name,
                                "classname":value.data[0].classname,
                                "content":value.data[0].content,
                                "teachername":value.data[0].teachername,
                                "id":value.data[0].id
                            });
                        });

                        _this.week1 = value.data[0].week1;
                        _this.week2 = value.data[0].week2;
                        _this.session = value.data[0].session;
                        _this.getLaboratory();
                    });
                    myModules.newLayerOpen(0,$('#edit'))
                },
                //渲染申请信息
                appList(){
                    let URL = '{{asset('admin/LaboratorySystem/application/getDate')}}';
                    // return axios.get(URL);
                    myModules.newLayPage(URL,this,$('#page'));

                },
                //同意
                add(k){
                    {{--let obj = this.list[k];--}}
                    {{--let URL = '{{asset('admin/LaboratorySystem/application')}}';--}}

                    {{--axios.post(URL,{obj}).then((value)=>{--}}
                        {{--// console.log(value);--}}
                        {{--if(value.data === 1){--}}
                            {{--myModules.newLayer(1,'申请成功通过');--}}
                            {{--this.appList();--}}
                        {{--}else {--}}
                            {{--// console.log(value.data);--}}
                            {{--myModules.newLayer(0,value.data)--}}
                        {{--}--}}
                    {{--})--}}

                },
                //不同意
                del(k){
                    let id = this.list[k].id;
                    // console.log(id);
                    let URL = '{{asset('admin/LaboratorySystem/application')}}';
                    axios.delete(URL+'/'+id).then((value)=>{
                        if(value.data === 1){
                            myModules.newLayer(1,'审批成功');
                            this.appList();
                        }
                    });
                    // console.log(id);
                }
            },
            mounted(){

                //渲染申请信息
                this.appList();

                //通过用户的申请接口，取得当前学期，班级
                axios.get('{{url('admin/UserName/application/getSelectedDate')}}').then((value)=>{
                    this.selectObj = value.data;
                })

                //返回实验室数据
                this.getLaboratory();
                // this.time = this.lbList.time;

            }
        })
    </script>

    @endsection