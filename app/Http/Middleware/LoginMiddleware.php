<?php

namespace App\Http\Middleware;

use Closure;

class LoginMiddleware
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
        if($request->session()->get('user', '') == ''){
           return redirect()->guest('admin/login');
        }
        view()->share('user',$request->session()->get('user')); // 变量共享 （用户信息session）
        return $next($request);
    }
}
