<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Crypt;
use App\Http\Requests;
use App\Http\Controllers\admin\BaseController;
use App\models\Users;
use App\models\Roles;
use App\Http\Requests\AdminaddRequest;
use App\Http\Requests\UserRequest;
class UserController extends BaseController
{
	protected $users;
    protected $roles;
    /**
     *  [__construct description]
     *  izxin.com
     *  @author qingfeng
     *  @DateTime 2016-09-18T23:52:05+0800
     *  @param    AuthValidator            $validator [description]
     */
    public function __construct(Users $users,Roles $roles)
    {
        
        $this->users  = $users;
        $this->roles  = $roles;
    }
    /**
	 *  [index 管理员列表]
	 *  臭虫科技
	 *  @author chouchong
	 *  @DateTime 2016-09-22T15:33:40+0800
	 *  @return   [type]                   [description]
	 */
    public function index(Request $request){
        if($request->ajax()){
          return $this->users->index($request);
        }
    	$userList = $this->users->index($request);
    	return view('admin.adminlist',compact('userList'));
    }
    /**
     *  [edit 停用账户]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-22T15:33:52+0800
     *  @return   [type]                   [description]
     */
    public function userStop(Request $request){
    	return $this->users->userStop($request);
    }
    /**
     *  [edit 启用账户]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-22T15:33:52+0800
     *  @return   [type]                   [description]
     */
    public function userStart(Request $request){
    	return $this->users->userStart($request);
    }
    /**
     *  [add 添加管理员]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-22T15:33:47+0800
     */
    public function add(AdminaddRequest $request){
        $rolelist = $this->roles->rolelist();
        if($request->ajax()){
          return $this->users->add($request);
        }
    	return view('admin.adminadd',compact('rolelist'));
    }
    /**
     *  [edit 编辑管理员]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-22T15:33:52+0800
     *  @return   [type]                   [description]
     */
    public function edit(UserRequest $request,$id){
        if($request->ajax()){
          return $this->users->edit($request);
        }
        $user = $this->users->find($id);
        $rolelist = $this->roles->rolelist();
    	return view('admin.adminedit',['user'=>$user,'rolelist'=>$rolelist]);
    }
    /**
     *  [edit 刪除管理员]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-22T15:33:52+0800
     *  @return   [type]                   [description]
     */
    public function del(Request $request){
         return $this->users->del($request);
    }

}
