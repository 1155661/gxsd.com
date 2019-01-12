<?php

namespace App\Http\Middleware;

use Closure;

class adminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //判断后台是否登录

        if(session('gxsdmznAdminUserInfo')){
            //如果session有记录，则进入后台
            return $next($request);
        }else{

            //没有则加载登录页面
            return redirect('admin/login');
        }

    }
}
