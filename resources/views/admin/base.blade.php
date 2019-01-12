@extends('admin.statics')
@section('css')
    <link rel="stylesheet" href="{{asset('layer_mobile/need/layer.css')}}">
    <link rel="stylesheet" href="{{asset('css/base.css')}}">
    @endsection
@section('content')
    <div class="layui-layout layui-layout-admin" id="base">
        <div class="layui-header layui-bg-cyan">
            <div class="layui-logo" style="border-right: 1px solid #009688; border-bottom: 1px solid #009688;">后台管理系统</div>
            <div class="layui-nav layui-layout-left slideBtn">
                {{--<form action="#" method="post" class="layui-form">--}}
                    {{--<i class="layui-icon">&#xe668;</i>--}}
                    {{--<input type="text" class="layui-input" placeholder="搜索全站">--}}
                {{--</form>--}}
            </div>
            <div style="float: left;" class="sliderBtn"><a href="#" class="layui-icon">&#xe68e;</a></div>
            <ul class="layui-nav layui-layout-right">
                <li class="layui-nav-item">
                    <a href="javascript:;" id="user-t">
                        {{session('gxsdmznAdminUserInfo.name')}}
                    </a>

                    <dl class="layui-nav-child">
                        <dd><a data-id="13" data-url="{{url('admin/UserName/changePassword')}}" data-title="密码修改" class="site-demo-username" href="javascript:;">密码修改</a></dd>
                        @if(session('gxsdmznAdminUserInfo.isAdmin'))
                            <dd><a data-id="14" data-title="申请" data-url="{{url('admin/LaboratorySystem/application')}}" class="site-demo-username" href="javascript:;">申请 <span class="layui-badge" v-if="count > 0">@{{ count }}</span></a></dd>
                            <dd><a data-id="14" data-title="其他" data-url="#" class="site-demo-username" href="javascript:;">其他</a></dd>
                            @endif
                    </dl>
                </li>
                <li class="layui-nav-item"><a href="{{asset('admin/login/logout')}}">退了</a></li>
            </ul>
        </div>

        <div class="layui-side layui-bg-cyan">
            <div class="layui-side-scroll">
                <!-- 左侧导航区域（可配合layui已有的垂直导航）  The Response content must be a string or object implementing __toString(), 插件 扩展 组件 "object" given. -->
                <ul class="layui-nav layui-nav-tree layui-bg-cyan"  lay-filter="test">
                    @if(session('gxsdmznAdminUserInfo.isAdmin'))
                        <li class="layui-nav-item layui-nav-itemed">
                            <a class="" href="javascript:;"><i class="layui-icon layui-icon-home" style="margin-right: 10px;"></i>实验室系统</a>
                            <dl class="layui-nav-child">
                                <dd><a data-url="{{url('admin/LaboratorySystem/index')}}" data-id="1" data-title="后台首页" class="site-demo-active" href="javascript:;">后台首页</a></dd>
                                <dd><a data-url="{{url('admin/LaboratorySystem/lb')}}" data-id="2" data-title="实验室管理" class="site-demo-active" href="javascript:;">实验室管理</a></dd>
                                <dd><a data-url="{{url('admin/LaboratorySystem/course')}}" data-id="3" data-title="课程管理" class="site-demo-active" href="javascript:;">课程管理</a></dd>
                                <dd><a data-url="{{url('admin/LaboratorySystem/class')}}" data-id="4" data-title="班级管理" class="site-demo-active" href="javascript:;">班级管理</a></dd>
                                <dd><a data-url="{{url('admin/LaboratorySystem/teacher')}}" data-id="5" data-title="教师资料" class="site-demo-active" href="javascript:;">教师资料</a></dd>
                                <dd><a data-url="{{url('admin/LaboratorySystem/dataInput')}}" data-id="6" data-title="数据录入" class="site-demo-active" href="javascript:;">数据录入</a></dd>
                                <dd><a data-url="{{url('admin/LaboratorySystem/datalist')}}" data-id="7" data-title="数据展示" class="site-demo-active" href="javascript:;">数据展示</a></dd>
                            </dl>
                        </li>
                        @else
                        <li class="layui-nav-item layui-nav-itemed">
                            <a data-url="{{url('admin/LaboratorySystem/index')}}" data-id="1" data-title="后台首页" class="site-demo-active" href="javascript:;">
                                <i class="layui-icon layui-icon-home" style="margin-right: 10px;"></i>后台首页
                            </a>
                        </li>
                        @endif
                    <li class="layui-nav-item">
                        <a data-url="{{url('admin/UserName/index')}}" data-id="8" data-title="我的安排" class="site-demo-active" href="javascript:;">
                            <i class="layui-icon layui-icon-form" style="margin-right: 10px;"></i>我的安排
                        </a>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;" data-url="{{url('admin/UserName/application')}}" data-id="10" data-title="我的申请" class="site-demo-active">
                            <i class="layui-icon layui-icon-release" style="margin-right: 10px;"></i>我的申请
                        </a>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;" data-url="{{url('admin/UserName/myClass')}}" data-id="11" data-title="我的班级" class="site-demo-active">
                            <i class="layui-icon layui-icon-group" style="margin-right: 6px;"></i>我的班级
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="layui-body" style="overflow:hidden;">
            <div class="layui-tab layui-tab-brief" lay-filter="demo" lay-allowclose="true">
                <ul class="layui-tab-title">
                </ul>
                <ul class="rightmenu" style="display: none;position: absolute;height: 100%;">
                    <li data-type="closethis">关闭当前</li>
                    <li data-type="closeall">关闭所有</li>
                </ul>
                <div class="layui-tab-content" style="height: 100%;">
                </div>
            </div>
        </div>

        <div class="layui-footer" style="background-color: #c2c2c2;">
            实验室管理系统 版本：青云1.0
        </div>
    </div>
    @endsection

@section('js')
    <script src="{{asset('js/base.js')}}"></script>
    <script src="{{asset('layer_mobile/layer.js')}}"></script>
    <script src="{{asset('js/Vue.js')}}"></script>
    <script>
        // Select all images with
        //     bicycles
        //     Click verify once there are none left
        let app = new Vue({
            el:'#base',
            data:{
                URL:'{{url('admin/appList')}}',
                isAdmin:'{{session('gxsdmznAdminUserInfo.isAdmin')}}',
                count:''
            },
            methods:{
                app(){
                    axios.get(this.URL).then(value => {
                        this.count = value.data.length;
                        if(value.data.length > 0){
                            layer.tips('有消息','#user-t',{
                                tips:[3,'#FF5722']
                            })
                        }
                    })
                },
                app2(){
                    if(Number(this.isAdmin)  === 1 ){
                        this.app();
                    }
                },
                message(){
                    setInterval(()=>{
                        this.app2();
                        // console.log(1);
                    },5000)
                }
            },
            mounted(){
                this.message();
            }
        });
        // let windowWidth = $(window).width();
    </script>
    @endsection

