<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\models\Permissions;
use App\Http\Controllers\admin\BaseController;

class PermissionController extends BaseController
{
	/**
	 *  [__contrust description]
	 *  臭虫科技
	 *  @author chouchong
	 *  @DateTime 2016-09-30T14:47:30+0800
	 *  @return   [type]                   [description]
	 */
    public function __construct(Permissions $permissions)
    {
        $this->permissions = $permissions;
    }
	/**
	 *  [index description]
	 *  臭虫科技
	 *  @author chouchong
	 *  @DateTime 2016-09-30T14:46:04+0800
	 *  @return   [type]                   [description]
	 */
    public function index(){
    	$permissionList = $this->permissions->index();
    	// return $permissionList;
    	return view('admin.adminpermission',compact('permissionList'));
    }
    /**
	 *  [index description]
	 *  臭虫科技
	 *  @author chouchong
	 *  @DateTime 2016-09-30T14:46:04+0800
	 *  @return   [type]                   [description]
	 */
    public function permissionedit(Request $request,$id){
    	if($request->ajax()){
            return $this->permissions->permissionedit($request);
    	}
    	$permissionslist = $this->permissions->permissionslist();
    	$permission = $this->permissions->permission($id);
    	// dd($permission);
    	return view('admin.adminpermissionedit',compact('permissionslist','permission'));
    }
	/**
	 *  [permissionadd description]
	 *  izxin.com
	 *  @author qingfeng
	 *  @DateTime 2016-10-18T10:08:00+0800
	 *  @param    Request                  $request [description]
	 *  @return   [type]                            [description]
	 */
    public function permissionadd(Request $request){
    	if($request->ajax()){
            return $this->permissions->permissionadd($request);
    	}
    	$permissionslist = $this->permissions->permissionslist();
    	return view('admin.adminpermissionadd',compact('permissionslist'));
    }
    /**
     *  [permissiondel description]
     *  臭虫科技
     *  @author qingfeng
     *  @DateTime 2016-10-18T11:31:28+0800
     *  @param    [type]                   $id [description]
     *  @return   [type]                       [description]
     */
    public function permissiondel(Request $request){
    	// dd($this->permissions->permissiondel($request));
        return $this->permissions->permissiondel($request);
    }
}
