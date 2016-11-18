<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\models\Roles;
use App\models\Permissions;
use App\Http\Controllers\admin\BaseController;

class RoleController extends BaseController
{
    public function __construct(Roles $Roles,Permissions $permissions)
    {
        $this->roles = $Roles;
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
    	$roleList = $this->roles->rolelist();
    	// return $roleList->users[1];
    	return view('admin.adminrole',compact('roleList'));
    }
    /**
	 *  [index description]
	 *  臭虫科技
	 *  @author chouchong
	 *  @DateTime 2016-09-30T14:46:04+0800
	 *  @return   [type]                   [description]
	 */
    public function roleadd(Request $request){
    	if($request->ajax()){
           return $this->roles->roleadd($request);
    	}
    	$permissionsList = $this->permissions->permissionslist();
    	return view('admin.adminroleadd',compact('permissionsList'));
    }
    /**
     *  [index description]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-30T14:46:04+0800
     *  @return   [type]                   [description]
     */
    public function roleedit(Request $request,$id){
        if($request->ajax()){
           return $this->roles->roleedit($request);
        }
        $role = $this->roles->role($id);
        $permissions = $role['permission']->lists('id')->toArray();
        $permissionsList = $this->permissions->permissionslist();
        return view('admin.adminroleedit',compact('permissionsList','role','permissions'));
    }
    /**
     *  [index description]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-30T14:46:04+0800
     *  @return   [type]                   [description]
     */
    public function roledel(Request $request){
        if($request->ajax()){
           return $this->roles->roledel($request);
        }
    }
}
