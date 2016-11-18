<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// 验证码地址
Route::get('captcha/{tmp}', ['uses'=>'admin\LoginController@captcha','as'=>'captchaSrc']);
//登录页面
Route::get('admin/login','admin\LoginController@toLogin');
//登录ajax请求
Route::any('login', 'admin\LoginController@index');
//退出登录
Route::any('loginOut', 'admin\LoginController@loginOut');
//验证是否登录后台路由组
Route::group(['middleware' => ['auth.login'],'namespace' => 'admin','prefix'=> 'admin'], function () {
	//后台首页
	Route::get('index', 'LoginController@login');
	Route::group(['middleware'=>['admin.handle']],function(){
		//后台管理员路由
		Route::any('/list', 'UserController@index');
		Route::any('/add', 'UserController@add');
		Route::any('/edit/{id}', 'UserController@edit');
		Route::any('/stop', 'UserController@userStop');
		Route::any('/start', 'UserController@userStart');
		Route::any('/del', 'UserController@del');
		//后台角色路由
		Route::get('/role', 'RoleController@index');
		Route::any('/role/add', 'RoleController@roleadd');
		Route::any('/role/edit/{id}', 'RoleController@roleedit');
		Route::any('/role/del', 'RoleController@roledel');
		//后台权限节点路由
		Route::get('/permission', 'PermissionController@index');
		Route::any('/permission/add', 'PermissionController@permissionadd');
		Route::any('/permission/edit/{id}', 'PermissionController@permissionedit');
		Route::any('/permission/del', 'PermissionController@permissiondel');
	});
});
//验证码测试
// Route::group(['middleware' => ['web']], function () {
//     Route::get('/login', function () {
//         return view('login');
//     });

//     Route::post('/verify', function () {
//         $captcha = new \Laravist\GeeCaptcha\GeeCaptcha(env('CAPTCHA_ID'), env('PRIVATE_KEY'));
//         if ($captcha->isFromGTServer()) {
//             if($captcha->success()){
//                 return 'success';
//             }
//             return 'no';
//         }
//         if ($captcha->hasAnswer()) {
//                 return "answer";
//         }
//         return "no answer";
//     });

//     Route::get('/captcha', function () {
//         $captcha = new \Laravist\GeeCaptcha\GeeCaptcha(env('CAPTCHA_ID'), env('PRIVATE_KEY'));

//         echo $captcha->GTServerIsNormal();
//     });

// });


