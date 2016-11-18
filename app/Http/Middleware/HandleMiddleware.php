<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Session;
class HandleMiddleware
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
        $path = explode('/',$request->path());
        if(preg_match('/^\d+$/i',$path[count($path)-1])){
            array_pop($path);
            if(in_array(implode('/', $path),Session::get('user.permission_name'))){
                return $next($request);
            }
        }else if(in_array($request->path(),Session::get('user.permission_name'))){
            return $next($request);
        }    
        dd('没有权限');
    }
}