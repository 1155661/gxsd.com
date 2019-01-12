@extends('admin.statics')

@section('css')
    <link rel="stylesheet" href="{{asset('css/lb.css')}}">
    <style>
        [v-cloak]{
            display: none;
        }
    </style>
    @endsection

@section('content')
    <div class="layui-row" id="app">
        <div class="layui-col-md10" style="margin: 1rem 0;">
            <div class="layui-col-md4 layui-btn-group" v-cloak>
                <button class="layui-btn" @click="orderBy(types = !types)">@{{ types ? '升序' : '降序' }}</button>
                <button class="layui-btn" @click="add(1)">添加</button>
                <button class="layui-btn" id="impExcel">导入Excel</button>
                <button class="layui-btn layui-btn-danger" @click="delAll()">删除选中</button>
            </div>
            <div class="layui-col-md2 layui-col-md-offset6">
                <input type="text" v-model="selected" class="layui-input" @keyup.enter="search()" placeholder="搜索名称">
            </div>
        </div>
        <hr>
        <table class="layui-table" lay-size="sm">
            <colgroup>
                <col width="200">
                <col width="200">
                <col width="200">
                <col width="260">
                <col width="200">
                <col width="200">
            </colgroup>
            <thead>
            <tr>
                <th><input type="checkbox" id="all" @click="selectAll">全选</th>
                <th>ID</th>
                <th>编号</th>
                <th>名称</th>
                <th>类型</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody v-if="list.length !== 0">
                {{--@{{ list.length }} Axule 滕王阁序 React--}}
                <tr
                        v-for="(item,key) in list"
                        :class="{active:item.isCampus}"
                        v-cloak @dblclick="add(0,item.id,key)"
                >
                    <td><input type="checkbox"  :value="key" v-model="selectArr" @click="selectItem(key)"></td>
                    <td>@{{item.id}}</td>
                    <td>@{{ item.number }}</td>
                    <td>@{{ item.lbname }}</td>
                    <td>@{{ item.types }}</td>
                    <td>
                        <div class="layui-btn-group">
                            <button  class="layui-btn layui-btn-danger layui-btn layui-btn-sm" @click="del(item.id)">
                                <i class="layui-icon">&#xe640;</i>删除
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="7" style="text-align: center;"><span class="layui-badge">暂无数据</span></td>
                </tr>
            </tbody>
        </table>
        <div id="page1">
        </div>

        <div id="test1">
            <form action="#" method="post" class="layui-form layui-col-md8 layui-col-md-offset1" lay-filter="test1" @submit.prevent="submit">
                <div class="layui-form-item">
                    <label class="layui-form-label">名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="lbname" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="username" class="layui-form-label">编号</label>
                    <div class="layui-input-block">
                        <select class="form-control" name="number">
                            <option name="number" v-for="item in dataInputList"  v-if="item.types==0" :value="item.name">@{{ item.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">类型</label>
                    <div class="layui-input-block">
                        <select name="types">
                            <option name="types" v-for="item in dataInputList"  v-if="item.types==1"  :value="item.name">@{{ item.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">校区</label>
                    <div class="layui-input-block">
                        <input type="radio" name="isCampus" value="0" title="里建" checked>
                        <input type="radio" name="isCampus" value="1" title="长堽">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <input type="submit" class="layui-btn layui-btn-sm layui-btn-fluid" value="确认">
                    </div>
                </div>
            </form>
        </div>
        <div id="test2">
            <form action="#" method="post" class="layui-form layui-col-md8 layui-col-md-offset1" lay-filter="test1" @submit.prevent="submit2">
                <input type="hidden" name="id">
                <div class="layui-form-item">
                    <label class="layui-form-label">名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="lbname" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="username" class="layui-form-label">编号</label>
                    <div class="layui-input-block">
                        <select class="form-control" name="number" lay-filter="select_1">
                            <option name="number" v-for="item in dataInputList"  v-if="item.types==0" :value="item.name">@{{ item.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">类型</label>
                    <div class="layui-input-block">
                        <select name="types">
                            <option name="types" v-for="item in dataInputList"  v-if="item.types==1"  :value="item.name">@{{ item.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">校区</label>
                    <div class="layui-input-block">
                        <input type="radio" name="isCampus" value="0" title="里建" checked>
                        <input type="radio" name="isCampus" value="1" title="长堽">
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
    @endsection

<script type="module">
    import {myModule} from '{{asset('js/mymodule.js')}}';
    let myModules = myModule();

    var app = new Vue({
        el:'#app',
        data:{
            list:[],
            dataInputList:{},
            formDate:{},
            selected:'',
            types:true,
            selectArr:[],
            selectId:[],
        },
        methods:{
            //搜索功能
            search(){
                this.axiosList();
            },
            //导入Excel
            impExcel(){

                let URL = "{{url('admin/LaboratorySystem/lb/labtypesApi/impExcel')}}";
                let _this = this;
                // console.log(URL);
                //创建一个上传组件
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
                        },
                        done:function (res,index,upload) {
                            // console.log(res);
                            if(res === 1){
                                myModules.newLayer(1,'导入成功');
                                _this.axiosList();
                            }
                        }
                    });
                });

            },
            //添加和修改的弹窗 以及查询需要修改的数据都在这个方法
            add(i,id,k){
                let vue = this;

                vue.formDate.index = k;

                layui.use(['element','layer','form'],function () {
                    let element = layui.element,
                        laypage = layui.laypage,
                        $ = layui.$,
                        form = layui.form;

                    //添加按钮的弹窗
                    layer.open({
                        type:1,
                        title: i==1 ? '添加' : '修改',
                        skin:'layui-layer-molv',     //弹窗皮肤
                        shadeClose: true,            //点击遮罩关闭弹窗
                        content: i===1 ? $('#test1'): $('#test2') ,        //关联DOM
                        area:['500px','400px'],      //弹窗大小
                        // move: false,                 //禁止拖拽 TypeError: Cannot set property 'lbname' of undefined
                        offset: ['50px', '420px'],   //弹窗坐标
                    });

                    //当id有值时，则进行条件查询,方便修改
                    if(id != undefined){
                        vue.formDate.URL = '{{asset('admin/LaboratorySystem/lb/')}}';
                        axios.get(vue.formDate.URL+'/'+id).then((value)=>{
                            // console.log(value.data[0].lbname);
                            // vue.formDate.lbname = value.data[0].lbname;
                            $('#test2 input[name=lbname]').val(value.data[0].lbname);
                            $('#test2 .layui-icon').eq(value.data[0].isCampus).click();
                            $('#test2 [type=hidden]').val(value.data[0].id);

                            let test_2_dd = $('#test2 .layui-anim-upbit:eq(0) dd');
                            let test_2_dd_2 = $('#test2 .layui-anim-upbit:eq(1) dd');




                            $.each(test_2_dd,function (i,e) {
                                // console.log(e.innerText);
                                if(value.data[0].number == e.innerText){
                                    $(this).click();
                                }

                            });

                            $.each(test_2_dd_2,function (i,e) {
                                if(value.data[0].types == e.innerText){
                                    $(this).click();
                                }
                            })

                        })
                    }

                })
            },
            //处理后台返回的实验室数据，并渲染到视图
            axiosList(){
                var URL = '{{asset('admin/LaboratorySystem/lb/labtypesApi')}}' + '?' + 's=' +  this.selected + '&sort=' + this.types;
                var str = this;
                // console.log(111);
                axios.get(URL).then(function (value) {
                    let data = value.data;


                    layui.use(['laypage','element'],function () {
                        let laypage = layui.laypage,
                            $ = layui.$;

                        laypage.render({
                            elem:document.querySelector('#page1'),
                            count:data.length,
                            limit:8,
                            layout: ['count', 'prev', 'page', 'next', 'refresh', 'skip'],
                            jump:function (obj) {
                                str.list = data.concat().splice((obj.curr - 1) * obj.limit,obj.limit);
                            }
                        });
                    });
                })
            },
            //处理后台返回的实验室参数数据，并渲染到select
            axiosDataInput(){
                let URL = '{{asset('admin/LaboratorySystem/dataInput/lbApi')}}';
                axios.get(URL).then((value)=>{
                    this.dataInputList = value.data;
                });
            },
            //实验室删除功能
            del(id){
                // this.list.splice(i,1);
                let URL = '{{asset('admin/LaboratorySystem/lb/')}}';
                let str = this;
                //delete方式提交
                axios.delete(URL+'/'+id).then((value) => {

                    layui.use(['element','layer'],function () {
                        if(value.data ==1){
                            layer.alert('删除成功',{
                                icon:1,
                                skin:'layui-layer-molv',     //弹窗皮肤
                                btn1(){
                                    layer.closeAll();
                                }
                            });
                            str.axiosList();
                        }
                    })

                })
            },
            //实验室添加功能
            submit(){
                        {{--                    let URL = '{{asset('admin/LaboratorySystem/lb')}}';--}}
                let URL = this.formDate.URL = '{{asset('admin/LaboratorySystem/lb')}}';
                layui.use(['element','form'],()=> {
                    let $ = layui.$,
                        form = layui.form;
                    //将表单序列化的字符串转换成对象
                    $.fn.serializeObject = function () {
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

                    this.formDate = $('#test1 form').serializeObject();

                    let inputDate = this.formDate;
                    axios.post(URL,{inputDate}).then((value)=>{
                        if(value.data == 1){
                            layer.alert('添加成功',{
                                icon:1,
                                skin:'layui-layer-molv',     //弹窗皮肤
                                btn1(){
                                    layer.closeAll();
                                }
                            });
                            this.axiosList();
                        }else{
                            layer.alert(value.data.lbname[0],{icon:5,skin:'layui-layer-molv'});
                        }
                        // console.log(value.data);
                    });
                });
            },
            submit2(){
                let URL = this.formDate.URL = '{{asset('admin/LaboratorySystem/lb/')}}';
                layui.use(['element','form'],()=>{
                    let $ = layui.$,
                        form = layui.form,
                        layer = layui.layer;

                    $.fn.serializeObject = function () {
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

                    this.formDate = $('#test2 form').serializeObject();

                    let inputDate = this.formDate;
                    // console.log(inputDate);
                    // console.log(inputDate.id);
                    axios.put(URL+ '/' + inputDate.id,{inputDate}).then((value)=>{
                        if(value.data){
                            layer.alert('修改成功',{
                                icon:1,
                                skin:'layui-layer-molv',     //弹窗皮肤
                                btn1(){
                                    layer.closeAll();
                                }
                            });
                            this.axiosList();
                        }else {
                            // layer.alert('修改失败',{icon:5,skin:'layui-layer-molv'});
                            layer.closeAll();
                        }
                    })

                })
            },
            orderBy(i){
                this.axiosList();
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
                let URL = "{{asset('admin/LaboratorySystem/lb/labtypesApi/deletion')}}";

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
                                    _this.axiosList();
                                    _this.selectId = [];
                                    _this.selectArr = [];
                                }
                            })
                        }
                    })

                });
            }
        },
        created(){
            this.impExcel();
        },
        mounted(){
            //实验室数据遍历
            this.axiosList();

            //实验室参数
            this.axiosDataInput();

            // this.impExcel();
        },
        computed:{
            filterBook(){
                const {selected,list,types} = this;

                let listArr = [];

                listArr = list.filter(p => p.lbname.indexOf(selected) !== -1);

                if(types){
                    listArr.sort(function (a,b) {
                        if(types === 1){
                            return a.id - b.id;
                        }else {
                            return b.id - a.id;
                        }
                    });

                    listArr.filter((p) =>{
                        if(types === 3){

                        }
                    })
                }

                return listArr;
            }
        },
    });

</script>
