<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('css')
    {{--<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">--}}
    <link rel="stylesheet" href="{{asset('layui/css/layui.css')}}">
    <script src="{{asset('layui/layui.js')}}"></script>
{{--    <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.css')}}">--}}
    <title>Document</title>
</head>
<body>
@yield('content')

{{--<script src="{{asset('js/less.js')}}"></script>--}}
<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
{{--<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>--}}
<script src="{{asset('js/axios.min.js')}}"></script>
<script src="{{asset('js/Vue.js')}}"></script>
{{--<script type="module" src="{{asset('js/mymodule.js')}}"></script>--}}
@yield('js')
</body>
</html>