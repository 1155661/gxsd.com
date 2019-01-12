@extends('admin.statics')

@section('css')
    <style>
        [v-cloak]{
            display: none;
        }
        .form-post{
            float: right;
        }
    </style>
    @endsection

@section('content')
    <div class="layui-row" id="app">
        <div class="layui-col-md12">
            <div class="layui-col-md8 layui-btn-group" style="margin: 1rem 0;" >
                <button class="layui-btn" @click="sort(types = !types)">@{{ types ? '升序' : '降序' }}</button>
                <button class="layui-btn" @click="add()">添加</button>
                <button class="layui-btn" id="impExcel">导入excel</button>
                <button class="layui-btn layui-btn-danger" @click="delAll()">删除选中</button>
            </div>
            <div class="layui-col-md2" style="margin-top: 1rem;">
                <input type="text" class="layui-input" v-model="search" @keyup.enter="newSearch()" placeholder="搜索班级">
            </div>
        </div>
        <hr>
        <table class="layui-table" lay-size="sm">
            <colgroup>
                <col width="50">
                <col width="100">
                <col width="300">
                <col width="200">
                <col width="100">
            </colgroup>
            <thead>
            <tr>
                <th><input type="checkbox" id="all" @click="selectAll">全选</th>
                <th>id</th>
                <th>班级名称</th>
                <th>班级人数</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody v-if="list.length !== 0">
            <tr v-for="(item,key) in list" @dblclick="editName(item.id,key)" v-cloak>
                <td><input type="checkbox"  :value="key" v-model="selectArr" @click="selectItem(key)"></td>
                <td>@{{ item.id }}</td>
                <td class="curseName_1" v-html="item.className">@{{ item.className }}</td>
                <td class="curseName_1" v-html="item.classNumber" >@{{ item.classNumber }}</td>
                <td>
                    <div class="layui-btn-group">
                        <button class="layui-btn layui-btn-danger layui-btn layui-btn-sm" @click="ajaxDel(item.id)">
                            <i class="layui-icon">&#xe640;</i>删除
                        </button>
                    </div>
                </td>
            </tr>
            </tbody>
            <tbody v-else>
            <tr>
                <td colspan="5" style="text-align: center;"><span class="layui-badge">暂无数据</span></td>
            </tr>
            </tbody>
        </table>
        <div id="page1"></div>

        {{--修改弹窗--}}
        <div id="test1" style="display: none;">
            <form action="#" style="margin-top: 1rem;" method="post" class="layui-form layui-col-md8 layui-col-md-offset1" lay-filter="test1" @submit.prevent="ajaxEdit">
                <input type="hidden" name="id">
                <div class="layui-form-item">
                    <label class="layui-form-label">班级名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="className"  class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">班级人数</label>
                    <div class="layui-input-block">
                        <input type="text" name="classNumber"   class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <input type="submit" class="layui-btn layui-btn-sm layui-btn-fluid" value="确认">
                    </div>
                </div>
            </form>
        </div>

        {{--添加弹窗--}}
        <div id="test2" style="display: none;">
            <form action="#" style="margin-top: 1rem;" method="post" class="layui-form layui-col-md8 layui-col-md-offset1" lay-filter="test1" @submit.prevent="ajaxAdd">
                <input type="hidden" name="id">
                <div class="layui-form-item">
                    <label class="layui-form-label">班级名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="className" v-model="addDate.className"  class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">班级人数</label>
                    <div class="layui-input-block">
                        <input type="text" name="classNumber" v-model="addDate.classNumber"   class="layui-input">
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
        //加载模块
        import {myModule} from '{{asset('js/mymodule.js')}}';
        let myModules = myModule();

        let app = new Vue({
            el:'#app',
            data:{
                list:[],
                URL:'',
                time2:[],
                addDate:{},
                editArray:{},
                selectArr:[],
                selectId:[],
                search:'',
                types:true,
                allDate:'',
                allDateLen:0
            },
            methods:{
                newSearch(){
                   this.classLists();

                },
                impExcel(){
                    //
                    let _this = this;
                    layui.use('upload',function () {
                        let upload = layui.upload;
                        let URL = '{{asset('admin/LaboratorySystem/class/impExcel')}}';
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
                                    _this.classLists();
                                }
                            }
                        })

                    })
                },
                //渲染学期
                ajaxTime(){
                    let URL = '{{asset('admin/LaboratorySystem/class/getTime')}}';
                    axios.get(URL).then((value)=>{

                        this.time2 = value.data;

                    });
                },
                //班级添加(弹窗)
                add(){
                    myModules.newLayerOpen(1,$('#test2'),'260px');
                },
                //班级添加(功能)
                ajaxAdd(){
                    let URL = '{{asset('admin/LaboratorySystem/class')}}';
                    let data = this.addDate;
                    axios.post(URL,{data}).then((value)=>{
                        // console.log(value)
                        if (value.data === 1){
                            myModules.newLayer(1,'添加成功');
                            this.classLists();
                        }else {
                            // console.log(value.data);
                            let arr = [];
                            $.each(value.data,function (index,item) {
                                // console.log(item[0])
                                arr.push(item[0])
                            });
                            // console.log(arr[0]);
                            myModules.newLayer(0,arr[0]);

                        }
                    });

                    return false;
                },
                //班级数据源
                classLists(){
                    let _this = this;
                    let URL = '{{asset('admin/LaboratorySystem/class/getJson')}}' + '?' + 's=' + this.search + '&' + 'sort=' + _this.types;
                    axios.get(URL).then(function (value) {
                        if(value.status === 200){

                            _this.allDate = value.data;

                            _this.allDateLen = _this.allDate.length;

                            layui.use(['laypage','element'],function () {
                                let laypage = layui.laypage,
                                    $ = layui.$;

                                laypage.render({
                                    elem:$('#page1'),
                                    count:_this.allDateLen,
                                    limit:8,
                                    layout:['count', 'prev', 'page', 'next', 'refresh', 'skip'],
                                    jump:function (obj) {
                                        _this.list = _this.allDate.concat().splice((obj.curr - 1) * obj.limit,obj.limit);
                                    }
                                })

                            })
                        }
                    })

                    //调用neLayPage方法读取资源
                    // myModules.newLayPage(URL,this,$('#page1'))
                },
                editName(id,key){
                    //加载表单弹窗
                    myModules.newLayerOpen(0,$('#test1'),'260px');

                    //利用双向数据绑定，将原来的数据绑定到表单
                    this.editArray = this.list[key];

                    let obj = this.editArray;

                    // this.editArray.classNumber = this.list[key].classNumber;
                    $('#test1 input[name=className]').val(obj.className);
                    $('#test1 input[name=classNumber]').val(obj.classNumber);

                },
                ajaxEdit(){
                    // alert();

                    let URL = this.URL = '{{asset('admin/LaboratorySystem/class/')}}';
                    let obj = this.editArray;

                    this.editArray.className = $('#test1 input[name=className]').val();
                    this.editArray.classNumber = $('#test1 input[name=classNumber]').val();
                    // console.log(oldName === obj.className ? 1:0);


                        axios.put(URL+'/'+obj.id,{obj}).then(function (value) {

                            if(value.data === 1){
                                myModules.newLayer(1,'添加成功')
                            }else {
                                let result = value.data.className === undefined ? value.data.classNumber[0] : value.data.className[0];
                                myModules.newLayer(5,result);
                                // console.log(value.data);
                            }
                            console.log(value.data);
                        });
                    return false;
                },
                ajaxDel(id){
                    // alert();
                    let URL = '{{asset('admin/LaboratorySystem/class')}}';
                    axios.delete(URL+'/'+id).then((value) => {
                        if(value.data === 1){
                            myModules.newLayer(1,'删除成功');
                            this.classLists();
                        }
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
                    let URL = "{{asset('admin/LaboratorySystem/class/deletion')}}";

                    if(allId.length === 0){
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
                                        _this.classLists();
                                        _this.selectId = [];
                                        _this.selectArr = [];
                                    }
                                })
                            }
                        })

                    });
                },
                //排序
                sort(){
                    let types = this.types;

                    this.classLists();
                },
            },
            created(){
                this.classLists();
                this.impExcel();
            },
            computed:{
                sortAndSearch(){
                    const {list,search} = this;
                    let listArr = [];
                    let _this = this;
                    // listArr = allDate;
                    //搜索功能
                    // listArr = list.filter(p => p.className.indexOf(search) !== -1);
                    //
                    // let newLen = _this.allDateLen ? '' : _this.allDateLen;




                    return list;

                }
            },
            mounted(){

                this.ajaxTime();
            }

        });
        layui.use(['form'],function () {

        })
    </script>
    @endsection
