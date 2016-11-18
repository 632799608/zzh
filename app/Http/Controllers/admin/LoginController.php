<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use App\Http\Requests;
use App\Http\Controllers\admin\BaseController;
use Session;
use Validator;
use App\Http\Requests\LoginRequest;
use App\models\Users;
use Crypt;
use DB;
use App\models\Roles;
class LoginController extends BaseController
{
	
	/**
	 *  [index 登录]
	 *  臭虫科技
	 *  @author chouchong
	 *  @DateTime 2016-09-19T16:11:21+0800
	 *  @return   [type]                   [description]
	 */
	// public function index(LoginRequest $request){
	// 	if($request->ajax()){
	// 	   $rs = ['status'=>'1'];
	// 	   $pattern = '/^(\w)+(\.\w+)*@(\w)+((\.\w{2,3}){1,3})$/'; 
	// 	   if(!preg_match( $pattern, $request->input('userName') )){
 //              $rs =  ['status'=>'-1','message'=>"邮箱格式不正确"];
	// 	   }
	// 	   else if(strlen($request->input('password')) > 20 || strlen($request->input('password')) < 6 ){
 //              $rs =  ['status'=>'-1','message'=>'密码为6-20位'];
	// 	   }
	// 	   else if($request->input('captcha') != $request->session()->get('captcha')){
 //              $rs =  ['status'=>'-1','message'=>'验证码不正确'];
	// 	   }else{
	// 	   	   $request->session()->put('user', $request->all());
	// 	   }
	// 	   return  $rs;   
	// 	}else{
 //           return view('admin.login');	
	// 	}
	// }
	public function index(LoginRequest $request,Users $Users,Roles $Roles){
		if($request->ajax()){
			if($request->input('captcha') == $request->session()->get('captcha')){
				$user = $Users->where('email','=',$request->input('userName'))->first();
                $user['role'] = $user->roles;
                $permission = $Roles->find($user['role'][0]['id'])->permission->toArray();
                $id =[];$name =[];$display_name =[];
                foreach ($permission as $key => $value) {
                	 array_push($id,$value['id']);
                	 array_push($name,$value['name']);
                	 array_push($display_name,$value['display_name']);
                }
                $user['permission_id'] = $id;
                $user['permission_name'] = $name;
                $user['permission_display_name'] = $display_name;

				if($user){
					if(Crypt::decrypt($user['password']) == $request->input('password')){
						$request->session()->put('user', $user);
						// return Session::get('user');
                        return ['status'=>'1'];
					}else{
						return ['status'=>'-1','message'=>'账号或密码错误'];
					}
				}else{
				    return ['status'=>'-1','message'=>'账号或密码错误'];
				}
			}else{
			    return ['status'=>'-1','message'=>'验证码错误'];
			}
		}     
	}
	/**
	 *  [验证码]
	 *  臭虫科技
	 *  @author chouchong
	 *  @DateTime 2016-09-19T14:47:38+0800
	 *  @return   [type]                   [description]
	 */
    public function captcha(Request $request,$tmp){
        //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder;
        //可以设置图片宽高及字体
        $builder->build($width = 100, $height = 40, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();
        //把验证码内容存入session
        $request->session()->put('captcha', $phrase);
        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $builder->output();
    }
    /**
     *  [login 跳后台首页]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-21T15:39:14+0800
     *  @return   [type]                   [description]
     */
    public function login(Request $request){
        return view('admin.index');
    }
    /**
     *  [login 跳登录页面]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-21T15:39:14+0800
     *  @return   [type]                   [description]
     */
    public function toLogin(){
        return view('admin.login');
    }
    /**
     *  [login 退出登录]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-21T15:39:14+0800
     *  @return   [type]                   [description]
     */
    public function loginOut(Request $request){
    	$request->session()->forget('user');
        return view('admin.login');
    }

}
