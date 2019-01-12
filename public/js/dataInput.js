import {myModule} from './mymodule.js';
let myModules = myModule();

let app = new Vue({
    el:'#app',
    data:{
        publicList:{
            explist:{},         //实验参数展示对象
            timeList:{},        //学期展示对象
            practiceList:{}     //实习任务展示对象
        },
        expFormObj:{},
        URL:'',
        time:[],
        newSelected:{}          //下拉列表的集合
    },
    methods:{
        practiceList(){
            let URL = './admin/LaboratorySystem/dataInput/inputDel/practiceList';

            let str = this;
            // console.log(expUrl);

            axios.get(URL).then(function (value) {
                let data = value.data;

                layui.use(['laypage','element'],function () {
                    let laypage = layui.laypage;
                    laypage.render({
                        elem:$('#practice_page2'),
                        count:data.length,
                        limit:8,
                        layout: ['count', 'prev', 'page', 'next', 'refresh', 'skip'],
                        jump:function (obj) {
                            str.publicList.practiceList = data.concat().splice((obj.curr - 1) * obj.limit,obj.limit);
                        }
                    })
                })

            });

        },
        //渲染表单下拉列表的数据
        formSelect(){
            let URL = './admin/LaboratorySystem/dataInput/inputDel/inputData';
            axios.get(URL).then((value)=>{
                // console.log(value.data);
                this.newSelected = value.data;
            })
        },
        //实习任务添加
        practiceAdd(){

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

            let URL = './admin/LaboratorySystem/dataInput/inputDel/practice';
            let data = $('#test3 form').serializeObject();
            axios.post(URL,{data}).then((value)=>{
                // console.log(value);
                if(value.data === 1){
                    myModules.newLayer(1,'添加成功');
                    this.practiceList();
                }
            });



            return false;
        },
        //该模板的公共弹窗
        add(v,k){
            if(v === 1){                   //1、实验参数弹窗
                myModules.newLayerOpen(1,$('#test5'),'300px')
            }

            if(v === 2){                    //2、实习任务弹窗
                myModules.newLayerOpen(1,$('#test3'),'540px');
            }


            // let  year = $('.layui-form:eq(3) .layui-form-item:eq(0) .layui-anim-upbit dd');
            // console.log(year);
            if(v === 3){


                let selected = `dd[lay-value=${this.newSelected.time[k]}]`;

                let year = $('#time').siblings('div.layui-form-selected').find('dl');
                console.log($('#time').siblings('div.layui-form-select').find('dl').find(selected).click());
                //3、实习任务修改弹窗
                myModules.newLayerOpen(0,$('#edit_1'),'540px');
                // console.log(k);
                // console.log($('#edit_1').parent());
                // console.log($('#edit1 .layui-anim-upbit'))
                // console.log($('.layui-form'));



            }

            // alert(v);    实验参数    公共列表
        },
        //展示实验室参数
        expList(){
            //实验室参数数据接口
            let expUrl = './admin/LaboratorySystem/dataInput/lbApi';
            // {{--myModules.newLayPage(expUrl,this,$('#page_init'))--}}
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
            let URL = this.URL = './admin/LaboratorySystem/dataInput';

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
            let URL = './admin/LaboratorySystem/dataInput/sTime';
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
            let timeURL = './admin/LaboratorySystem/dataInput/getTime';
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
        //将这个模板的删除功能整合到一起
        inputDel(order,id,){

            let URL = '';

            URL = './admin/LaboratorySystem/dataInput/inputDel' + '/'+ id + '/' + order;
            // console.log(URL+'/'+id+'/'+order);
            axios.get(URL).then((value)=>{
                if(value.data === 1){
                    myModules.newLayer(1,'删除成功');

                    if(order === 0){
                        this.expList();
                    }else if(order === 1){
                        this.timeList();
                    }
                }
            })
        }
    },
    mounted(){
        //展示实验室参数
        this.expList();
        // console.log(this.publicList.selectList);
        //展示学期数据
        this.timeList();

        //展示实习任务
        this.practiceList();

        //渲染表单下拉数据
        this.formSelect();

        //调用layui的laydate模块
        this.laydateFn('#test_date1');
        this.laydateFn('#test_date2');

    },
    created(){
        this.add();
    },
    component:{

    }
});

// layui.use(['element','laydate'],function () {
//
// });