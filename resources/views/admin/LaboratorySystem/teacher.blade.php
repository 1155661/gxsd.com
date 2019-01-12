@extends('admin.statics')

@section('css')
    <link rel="stylesheet" href="{{asset('css/teacher.css')}}">
    <style>
        [v-cloak]{
            display: none;
        }
    </style>
    @endsection

@section('content')
    <div class="layui-row" id="app">
        <div class="layui-col-md11">
            <div class="layui-btn-group layui-col-md4" style="margin: 1rem 0;">
                <button class="layui-btn" @click="sotrBtn(types = !types)">@{{ types ? ' 升序' : '降序' }}</button>
                <button class="layui-btn" @click="teacherAdd">添加</button>
                <button class="layui-btn" id="impExcel">导入Excel</button>
                <button class="layui-btn layui-btn-danger" @click="delAll()">删除选中</button>
            </div>
            <div class="layui-col-md2 layui-col-md-offset5" style="margin-top: 1rem;">
                <input type="text" class="layui-input" v-model="search" @keyup.enter="newSearch()" placeholder="搜索教师">
            </div>
        </div>
        <hr>
        <table class="layui-table" lay-size="sm">
            <colgroup>
                <col width="100">
                <col width="100">
                <col width="200">
                <col width="400">
                <col width="50">
                <col width="100">
                <col width="50">
                <col width="50">
            </colgroup>
            <thead>
            <tr>
                <th><input type="checkbox" id="all" @click="selectAll">全选</th>
                <th>id</th>
                <th>任课教师</th>
                <th>职称</th>
                <th>管理员</th>
                <th>最后登录时间</th>
                <th>登录次数</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item,key) in list" @dblclick="teacherEdit(key)" v-cloak>
                <td><input type="checkbox"  :value="key" v-model="selectArr" @click="selectItem(key)"></td>
                <td>@{{ item.id }}</td>
                <td>@{{ item.name }}</td>
                <td></td>
                <td>@{{ item.isAdmin ? '是' : '否' }}</td>
                <td>@{{ item.lasttime}}</td>
                <td>@{{ item.count}}</td>
                <td>
                    <div class="layui-btn-group">
                        <button class="layui-btn layui-btn-danger layui-btn layui-btn-sm" @click="thDel(item.id)">
                            删除
                        </button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <div id="page1"></div>
        <div id="test2">
            <form action="#" method="post" class="layui-form layui-col-md8 layui-col-md-offset1" @submit.prevent="submitAdd">
                <div class="layui-form-item">
                    <label class="layui-form-label">名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="name" v-model="formObj.name" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">密码</label>
                    <div class="layui-input-block">
                        <input type="password" name="password" v-model="formObj.password" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">邮箱</label>
                    <div class="layui-input-block">
                        <input type="text" name="email" v-model="formObj.email" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">职称</label>
                    <div class="layui-input-block">
                        <input type="text" name="jobtitle" v-model="formObj.jobtitle" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">管理员</label>
                    <div class="layui-input-block" lay-filter="test">
                        <input type="radio"  name="isAdmin" value="0" title="是" checked>
                        <input type="radio"  name="isAdmin" value="1" title="否">
                        {{--<input type="hidden"  v-model="formObj.isAdmin">--}}
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="submit" class="layui-btn layui-btn-sm layui-btn-fluid" value="确认">确认</button>
                    </div>
                </div>
            </form>
        </div>
        <div id="test3">
            <form action="#" method="post" class="layui-form layui-col-md8 layui-col-md-offset1" @submit.prevent="submitEdit">
                <div class="layui-form-item">
                    <label class="layui-form-label">名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="name" v-model="editObj.name" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">邮箱</label>
                    <div class="layui-input-block">
                        <input type="text" name="email" v-model="editObj.email" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">职称</label>
                    <div class="layui-input-block">
                        <input type="text" name="jobtitle" v-model="editObj.jobtitle" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">管理员</label>
                    <div class="layui-input-block" lay-filter="test">
                        <input type="radio"  name="isAdmin" value="0"  title="是" checked>
                        <input type="radio"  name="isAdmin" value="1"  title="否">
                        {{--<input type="hidden"  v-model="formObj.isAdmin">--}}
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="submit" class="layui-btn layui-btn-sm layui-btn-fluid" value="确认">确认</button>
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
                URL:'',
                formObj:{},
                editObj:{},
                search:'',
                types:true,
                selectArr:[],
                selectId:[],
            },
            methods:{
                //排序
                newSort(){
                    this.teacherList();
                },
                //导入Excel
                impExcel(){
                    let _this = this;
                    layui.use('upload',function () {
                        let upload = layui.upload;
                        let URL = '{{url('admin/LaboratorySystem/teacher/impExcel')}}';
                        upload.render({
                            elem:'#impExcel',
                            accept:'file',
                            method:'POST',
                            type:'file',
                            url:URL,
                            data:{'_token':'{{csrf_token()}}'},
                            before:function (obj) {
                                layer.load();
                            },
                            done:function (res,index,upload) {
                                // console.log(res);
                                if(res === 1){
                                    myModules.newLayer(1,'导入成功');
                                    _this.teacherList();
                                }
                            }
                        })

                    })
                },
                //搜索
                newSearch(){
                    this.teacherList();

                },
                teacherAdd(){
                    myModules.newLayerOpen(1,$('#test2'),'400px');
                },
                //添加教师
                submitAdd(){

                    let URL = this.URL = '{{asset('admin/LaboratorySystem/teacher')}}';
                    let isAdmin = $('#test2 input[name=isAdmin]:checked').val();

                    this.$set(this.formObj,'isAdmin',isAdmin);

                    let formObj = this.formObj;


                    axios.post(URL,{formObj}).then((value) => {

                        if(value.data === 1){
                            myModules.newLayer(1,'添加成功');
                            this.teacherList();
                        }else {
                            //遍历验证信息
                            this.loopMsg(value.data);
                        }
                    });
                    return false
                },
                //修改教师信息的弹窗
                teacherEdit(k){

                    this.editObj = this.list[k];
                    this.listIndex = k;


                    //获取需要修改的单选框 有个BUG：第一次获取时，对应的单选按钮没有被选中
                    $('#test3 .layui-unselect').eq(this.editObj.isAdmin).click();

                    myModules.newLayerOpen(0,$('#test3'),'400px');

                },
                submitEdit(){
                    let URL = this.URL = '{{asset('admin/LaboratorySystem/teacher/')}}';
                    let editObj = this.editObj;
                    editObj.isAdmin = $('#test3 input:radio[name=isAdmin]:checked').val();

                    axios.put(URL+'/'+editObj.id,{editObj}).then((value)=>{
                        // console.log(value);
                       if(value.data === 0){
                            layer.closeAll();
                            return false;
                       }

                        if(value.data === 1){
                            myModules.newLayer(1,'修改成功');
                            this.teacherList();
                        }else{

                            //遍历验证错误的信息
                            this.loopMsg(value.data);
                        }
                    })

                    // console.log(this.editObj);
                },
                //删除教师
                thDel(id){

                    let URL = this.URL = '{{asset('admin/LaboratorySystem/teacher/')}}';

                    axios.delete(URL+'/'+id).then((value)=>{
                        if(value.data === 1){
                            myModules.newLayer(1,'删除成功');
                            this.teacherList();
                        }
                    })
                },
                //遍历错误信息
                loopMsg(obj){
                    let  arr = [];
                    $.each(obj,function (i,e) {
                        arr.push(e[0]);
                    });

                    myModules.newLayer(5,arr[0]);
                },
                teacherList(){
                    let URL = '{{asset('admin/LaboratorySystem/teacher/getJson')}}' + '?' + 's=' + this.search + '&sort=' + this.types;
                    myModules.newLayPage(URL,this,$('#page1'));
                },
                sotrBtn(i){
                    // this.types = i;
                    // console.log(i);
                    this.teacherList();
                },
                //全选
                selectAll(event){
                    let _this = this;
                    let selectIdArr = _this.selectId;

                    if(!event.currentTarget.checked){
                        _this.selectArr = [];
                        _this.selectId = [];
                    }else {
                        _this.selectArr = [];

                        _this.list.forEach(function (item,i) {

                            _this.selectArr.push(i);

                            //设置限制，避免id重复加入
                            if(selectIdArr.indexOf(_this.list[i].id) === -1){
                                selectIdArr.push(_this.list[i].id);
                            }
                        })

                    }

                },
                //反选
                selectItem(key){
                    // console.log(event.currentTarget.checked);
                    let _this = this;

                    //被选中的id存储到内存中，
                    if(event.currentTarget.checked){
                        // arr.push(_this.list[key].id);
                        _this.selectId.push(_this.list[key].id);
                    }else {
                        let index = _this.selectId.indexOf(_this.list[key].id);
                        _this.selectId.splice(index,1);
                    }

                    //如果内存的长度等于结果集的长度，全选按钮被选中
                    if(_this.list.length === _this.selectId.length){
                        $('#all').click()
                    }
                },
                //删除选中
                delAll(){
                    // alert();
                    let _this = this;
                    let allId = this.selectId;
                    let URL = "{{asset('admin/LaboratorySystem/teacher/deletion')}}";

                    if(allId.length == 0){
                        myModules.newLayer(0,'未选中数据');
                        return false;
                    }

                    // console.log(allId.length);

                    layui.use(['layer'],function () {


                        layer.alert('一共选中'+allId.length+'条数据，您确定要删除吗?',{
                            icon:3,
                            skin:'layui-layer-molv',     //弹窗皮肤
                            btn1(){
                                // alert();
                                axios.post(URL,{allId}).then((value)=>{
                                    // console.log(value.data);
                                    if(value.data === 1){
                                        myModules.newLayer(1,'删除成功');
                                        _this.teacherList();
                                        _this.selectId = [];
                                        _this.selectArr = [];
                                    }
                                })
                            }
                        })

                    });
                }
            },
            mounted(){
                this.teacherList();
                this.impExcel();
            },
            computed:{
                sortAdnSearch(){
                    const {search,list,types} = this;
                    let listArr = [];




                    if(types){
                        list.sort(function (a, b) {
                            return a.id - b.id;
                        })
                    }

                    return list;

                }
            }
        });

    </script>
    @endsection