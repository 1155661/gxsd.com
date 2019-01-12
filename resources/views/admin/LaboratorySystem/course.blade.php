@extends('admin.statics')

@section('css')
    <style>
        [v-cloak]{
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="layui-row" id="app">
        <div class="layui-col-md10" >
            <div class="layui-btn-group layui-col-lg3" style="margin: 1rem 0;">
                <button class="layui-btn" @click="newSort(types = !types)">@{{ types ? '升序' : '降序' }}</button>
                <button class="layui-btn" id="impExcel">导入Excel</button>
                <button class="layui-btn layui-btn-danger" @click="delAll()">删除选中</button>
            </div>
            <div class="layui-col-md2" style="margin-top: 1rem;">
                <input type="text" class="layui-input" v-model="message" placeholder="添加课程" @keyup.enter="axiosEnter" >
            </div>
            <div class="layui-col-md2 layui-col-md-offset5">
                <input type="text" class="layui-input" v-model="search" placeholder="搜索课程" @keyup.enter="newSearch()" style="margin-top: 1rem;">
            </div>
        </div>
        <hr>
        <table class="layui-table" lay-size="sm">
            <colgroup>
                <col width="20">
                <col width="100">
                <col width="500">
                <col width="50">
            </colgroup>
            <thead>
            <tr>
                <th><input type="checkbox" id="all" @click="selectAll">全选</th>
                <th>id</th>
                <th>课程</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody v-if="list.length !== 0">
            <tr v-for="(item,key) in list" @dblclick="edit(item.name,key,item.id)" v-cloak>
                <td><input type="checkbox"  :value="key" v-model="selectArr" @click="selectItem(key)"></td>
                <td>@{{ item.id }}</td>
                <td class="curseName_1" v-html="item.name" v-if="item.name!==false">
                    @{{ item.name }}
                </td>
                {{--<td class="curseName_1"  v-if="item.name===false">--}}
                    {{--<input type="text"--}}
                           {{--v-model="message"--}}
                           {{--@keyup.enter="axiosEnter"--}}
                           {{--@click.right="mRight()">--}}
                {{--</td>--}}
                <td>
                    <div class="layui-btn-group">
                        <button class="layui-btn layui-btn-danger layui-btn layui-btn-sm" @click="deleteRem(item.id)">
                            <i class="layui-icon">&#xe640;</i>删除
                        </button>
                    </div>
                </td>
            </tr>
            </tbody>
            <tbody v-else>
            <tr>
                <td colspan="4" style="text-align: center;"><span class="layui-badge">暂无数据</span></td>
            </tr>
            </tbody>
        </table>
        <div id="page1"></div>
        <div id="test2" style="display: none;">
            <form action="#" method="post" class="layui-form layui-col-md8 layui-col-md-offset1" lay-filter="test1" @submit.prevent="submit2">
                <input type="hidden" name="id">
                <div class="layui-form-item">
                    <label class="layui-form-label">班级名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="lbname" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">班级人数</label>
                    <div class="layui-input-block">
                        <input type="text" name="lbname" class="layui-input">
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
        //关闭鼠标右击默认事件
        // window.oncontextmenu = function (e) {
        //     e.preventDefault();
        // };


        //引入模块文件
        import {myModule} from '{{asset('js/mymodule.js')}}';
        let myModules = myModule();

        let app = new Vue({
            el:'#app',
            data:{
                list:[],
                message:'',
                URL:'{{asset('admin/LaboratorySystem/course')}}',
                search:'',
                types:true,
                isInput:false,
                selected:'',
                selectArr:[],
                selectId:[],
            },
            methods:{
                //导入Excel
                impExcel(){
                    let URL = "{{url('admin/LaboratorySystem/course/impExcel')}}";
                    let  _this = this;
                    layui.use(['upload'],function () {
                        let upload = layui.upload;

                        //创建一个上传组件
                        upload.render({
                            elem:'#impExcel',
                            accept:'file',
                            method:'POST',
                            type:'file',
                            url:URL,
                            data:{'_token':'{{csrf_token()}}'},
                            before:function (obj) {
                                layer.load();
                                // console.log(obj)
                            },
                            done:function (res,index,upload) {
                                // console.log(res);
                                if(res === 1){
                                    myModules.newLayer(1,'导入成功');
                                    _this.courseList();
                                }
                            }
                        });

                    });

                },
                //搜索功能
                newSearch(){
                    this.courseList();
                },
                //异步添加
                axiosEnter(){
                    // this.list[0].name = this.message;

                    axios.post(this.URL,{name:this.message}).then((value)=>{
                        // console.log(value.data.name[0]);
                        if(value.data === 1){
                            myModules.newLayer(1,'课程添加成功');
                            this.courseList();
                            this.message = '';
                        }else {
                            myModules.newLayer(0,value.data.name[0]);
                            // this.list[0].name = false;
                        }
                    });
                },
                //渲染数据
                courseList(){
                    //加载数据渲染模块
                    let URL = '{{asset('admin/LaboratorySystem/course/courseJson')}}' + '?' + 's=' + this.search + '&sort=' + this.types;
                    myModules.newLayPage(URL,this,document.querySelector('#page1'));
                },
                //获得焦点时，弹出tips
                monLeft(){
                    // alert();
                    layui.use(['element','layer'],function () {
                        layer.tips('右击关闭输入框',$('table tbody tr td input[type=text]'),{
                            tips:[2,'#0FA6D8'],
                        })
                    })
                },
                //异步删除
                deleteRem(id){
                    let URL = '{{asset('admin/LaboratorySystem/course')}}';
                    axios.delete(URL+'/'+id).then((value) => {
                        if(value.data === 1){
                            myModules.newLayer(1,'删除成功');
                            this.courseList();
                            this.search = '';
                        }
                    });
                    // console.log(id);
                },
                //触发排序相关的操作
                newSort(orders){
                    // this.types = orders;
                    // console.log(orders);
                    this.courseList();
                },
                //修改功能
                edit(name,key,id){

                    //生成input标签
                    this.list[key].name = `<input type="text" class="inputTex" v-model="${this.message}" value="${name}"/>`;

                    let str = this;
                    let URL = '{{asset('admin/LaboratorySystem/course/')}}';
                    //在新生成的input标签绑定事件
                    this.$nextTick().then(()=>{
                        $('.inputTex').on('blur',function () {
                            let newVal = $(this).val();

                            //当用户没有修改文本框的内容时，刷新一次数据，否则发起一次修改请求
                            if(name === newVal){
                                str.courseList();
                            }else {
                                axios.put(URL+'/'+id,{name:newVal}).then(function (value) {

                                    if(value.data === 1 ){
                                        myModules.newLayer(1,'修改成功');
                                        str.courseList();
                                    }else {
                                        myModules.newLayer(5,value.data.name[0])
                                    }
                                })
                            }
                        })
                    })
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
                    let URL = "{{asset('admin/LaboratorySystem/course/deletion')}}";

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
                                        _this.courseList();
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
                this.courseList();
                this.impExcel();
            },
            computed:{
                sortAndSearch(){

                    const {search,list,types} = this;
                    let listArr = [];

                    //搜索功能
                    // listArr = list.filter((p)=>p.name.indexOf(search) !== -1);

                    //课程排序操作
                    if(types){
                        list.sort((a, b) => {
                            return types === 1 ? a.id - b.id : b.id - a.id;
                        })
                    }
                    return list;
                }
            },
            watch:{

            }
        });
    </script>

@endsection