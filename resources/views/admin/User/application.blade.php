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
            <h2>我的申请</h2>
        </div>
        <div class="layui-card-body" v-cloak>
            <button class="layui-btn layui-btn-sm" @click="appadd">申请</button>
            <div class="layui-badge" style="float: right;">注意：如果处理过的记录超过50条，系统将会自动删除</div>
            <table class="layui-table" lay-size="sm">
                <colgroup>
                    <col width="100">
                    <col width="100">
                    <col width="100">
                    <col width="100">
                    <col width="100">
                    <col width="100">
                    <col width="50">
                    <col width="50">
                    <col width="50">
                </colgroup>
                <thead>
                <tr>
                    <td>周</td>
                    <td>星期</td>
                    <td>节数</td>
                    <td>课程</td>
                    <td>申请时间</td>
                    <td>状态</td>
                    <td>操作</td>
                </tr>
                </thead>
                <tbody>
                <template v-if="list.length !== 0">
                    <tr v-for="item in list" v-if="item.status !== 1 && item.status !== -1">
                        <td>@{{ item.week1 }}</td>
                        <td>@{{ item.week2 }}</td>
                        <td>@{{ item.session }}</td>
                        <td>@{{ item.name }}</td>
                        <td>@{{ item.apptime }}</td>
                        <td>@{{ item.status ? '申请成功' : '申请中' }}</td>
                        <td>
                            {{--<button class="layui-btn layui-btn-sm layui-btn-danger layui-btn-disabled">取消申请</button>--}}
                            <button v-if="!item.status" class="layui-btn layui-btn-sm layui-btn-danger" @click="del(item.id)">撤销申请</button>
                            <button v-if="item.status" class="layui-btn layui-btn-sm layui-btn-danger layui-btn-disabled">撤销申请</button>
                        </td>
                    </tr>
                    <tr v-for="item in list" v-if="item.status === 1 || item.status === -1">
                        <td>@{{ item.week1 }}</td>
                        <td>@{{ item.week2 }}</td>
                        <td>@{{ item.session }}</td>
                        <td>@{{ item.name }}</td>
                        <td>@{{ item.apptime }}</td>
                        <td v-if="item.status !== -1">@{{ item.status ? '申请成功' : '申请中' }}</td>
                        <td v-else><span class="layui-badge">申请失败</span></td>
                        <td>
                            {{--<button class="layui-btn layui-btn-sm layui-btn-danger layui-btn-disabled">撤销申请</button>--}}
                            <button v-if="!item.status" class="layui-btn layui-btn-sm layui-btn-danger" @click="del(item.id)">撤销申请</button>
                            <button v-if="item.status" class="layui-btn layui-btn-sm layui-btn-danger layui-btn-disabled">撤销申请</button>
                        </td>
                    </tr>
                </template>
                <template v-else>
                    <tr>
                        <td colspan="7" style="text-align: center;"><span class="layui-badge">暂无申请</span></td>
                    </tr>
                </template>
                </tbody>
            </table>
            <div id="page"></div>
        </div>


        <div id="add" style="display: none;">
            <form action="#" method="post" class="layui-form layui-col-md8 layui-col-md-offset1" @submit.prevent="apply()">
                <input type="hidden" name="time" class="layui-input" :value="selectObj.theTime">
                <input type="hidden" name="teachername" value="{{session('gxsdmznAdminUserInfo.id')}}">
                <div class="layui-form-item" id="week1" style="margin-top: 2rem;">
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
                        <select name="name" lay-filter="course">
                            <option value="">选择课程</option>
                            <option v-for="(item,key) in curesSelect" :value="item.name">@{{ item.name }}</option>
                        </select>
                    </div>
                    <div class="layui-input-block">
                        <input type="checkbox" name="isMy"  v-model="curesBtn" @click="test()" style="margin-top: 20px;" lay-ignore>只看我的课程
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
                <div class="layui-form-item" id="content">
                    <label class="layui-form-label">备注</label>
                    <div class="layui-input-block">
                        <textarea class="layui-textarea" name="content"></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <input type="submit" class="layui-btn layui-btn-sm layui-btn-fluid" lay-filter="apply" value="确认">
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
                selectObj:'',           //我的班级
                lbList:'',               //实验室       申请时间
                time:'',
                list:'',
                curesSelect:'',
                curesBtn:false
            },
            methods:{
                //课程下拉列表
                selectCurse(){
                    let _this = this;

                    let userId = '{{session('gxsdmznAdminUserInfo.id')}}';
                    let URL = "{{url('admin/UserName/application/getCurse')}}" + "?id="+userId + "&cures=" + _this.curesBtn;

                    axios.get(URL).then(value => {
                        _this.curesSelect = value.data;
                    })
                },
                //申请弹窗
                appadd(){
                    // this.test();
                    myModules.newLayerOpen(1,$('#add'),'640px');
                },
                //渲染下拉列表
                selectList(){
                    let _this = this;

                    let URL = '{{url('admin/UserName/application/getSelectedDate')}}';

                    let form = layui.form;
                    axios.get(URL).then((value)=>{
                        _this.selectObj = value.data;
                    });
                },
                //渲染申请信息
                appList(){
                    let URL = '{{url('admin/UserName/application/appyGet')}}';
                    myModules.newLayPage(URL,this,$('#page'));
                },
                //取消申请
                del(id){
                    // alert();
                    // alert(id);
                    let URL = '{{asset('admin/UserName/application')}}';

                    axios.delete(URL+'/'+id).then((value)=>{
                        // console.log(value.data);
                        if(value.data === 1){
                            myModules.newLayer(1,'撤回成功');
                            this.appList();
                        }
                    })
                },
                //提交申请
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

                    let obj = $('#add form').serializeObject();
                    let URL = '{{asset('admin/UserName/application')}}';


                    axios.post(URL,{obj}).then((value)=>{
                        if(value.data === 1){
                            myModules.newLayer(1,'提交成功');
                            this.appList();
                        }else {

                            let row = [];
                            $.each(value.data,function (val,index) {
                                // console.log(index);
                                row.push(index);
                            });
                            myModules.newLayer(0,row[0][0]);
                        }
                    });
                },
                test(){
                    let _this = this;
                    _this.selectCurse();
                },
            },
            mounted(){

                // layui.use(['form'],function () {
                //     let form = layui.form;
                //     form.render('select');
                // });

                this.selectCurse();
                this.selectList();
                this.appList();
                // this.test();
                // this.apply();
                //并发请求
                // this.axiosAll();

                //渲染申请信息
                // this.appList();

                // this.time = this.lbList.time;
            },
            computed:{
                cList(){
                    // let {curesSelect,curesBtn} = this;
                    // let list = '';
                    //
                    // layui.use(['form'],function () {
                    //     let form = layui.form;
                    //     // return curesSelect;
                    //     list = curesSelect;
                    //     layui.form.render('select');
                    // });
                    // return list;
                }
            }
        });
        // app.$data;
    </script>

    @endsection