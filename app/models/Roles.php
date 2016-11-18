<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Roles extends Model
{
    /**
     *  [rolelist 角色列表]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-22T15:33:40+0800
     *  @return   [type]                   [description]
     */
    public function rolelist(){
        return $this->all();
    }
    /**
     *  [rolelist 关联权限表]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-22T15:33:40+0800
     *  @return   [type]                   [description]
     */
    public function permission()
    {
        return $this->belongsToMany(Permissions::class,'permission_role','role_id','permission_id');
    }
    /**
     *  [rolelist 查询一个角色]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-22T15:33:40+0800
     *  @return   [type]                   [description]
     */
    public function role($id){
        return $this->find($id);
    }
    /**
     *  [rolelist 关联用户表]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-22T15:33:40+0800
     *  @return   [type]                   [description]
     */
    public function users(){
        return $this->belongsToMany(Users::class,'role_user','role_id','user_id');
    }
    /**
     *  [rolelist 角色添加]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-22T15:33:40+0800
     *  @return   [type]                   [description]
     */
    public function roleadd($request){
        $rs = ['status'=>-1,'message'=>'添加失败'];
        $exception = DB::transaction(function() use ($request) {
            $role_id = $this->insertGetId(['display_name'=>$request->input('display_name'),
                                           'description'=>$request->input('description')]);
            // for ($i=0; $i < count($request->input('permissionsid')); $i++) { 
            //     DB::table('permission_role')->insert(['role_id'=>$role_id,
            //                                           'permission_id'=>$request->input('permissionsid')[$i]]);
            // }
            $this->find($role_id)->permission()->sync($request->input('permissionsid'));
        });
        if($exception == null){
            $rs = ['status'=>1,'message'=>'添加成功'];
        }
        return $rs;
    }
    /**
     *  [rolelist 角色添加]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-22T15:33:40+0800
     *  @return   [type]                   [description]
     */
    public function roleedit($request){
        $rs = ['status'=>-1,'message'=>'添加失败'];
        $exception = DB::transaction(function() use ($request) {
            $this->where('id','=',$request->input('role_id'))->update(['display_name'=>$request->input('display_name'),'description'=>$request->input('description')]);
            // for ($i=0; $i < count($request->input('permissionsid')); $i++) { 
            //     DB::table('permission_role')->insert(['role_id'=>$role_id,
            //                                           'permission_id'=>$request->input('permissionsid')[$i]]);
            // }
            DB::table('permission_role')->where('role_id','=',$request->input('role_id'))->delete();
            $this->find($request->input('role_id'))->permission()->sync($request->input('permissionsid'));
        });
        if($exception == null){
            $rs = ['status'=>1,'message'=>'添加成功'];
        }
        return $rs;
    }
    /**
     *  [index description]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-30T14:46:04+0800
     *  @return   [type]                   [description]
     */
    public function roledel($request){
        $rs = ['status'=>-1,'message'=>'删除失败'];
        $user = $this->find($request->input('id'))->users;
        if(count($user) > 0){
           $rs = ['status'=>-1,'message'=>'请先删除该角色下的管理员'];
        }else{
            $exception = DB::transaction(function() use ($request) {
                $this->where('id','=',$request->input('id'))->delete();
                DB::table('permission_role')->where('role_id','=',$request->input('id'))->delete();
            });
            if($exception == null){
                $rs = ['status'=>1,'message'=>'删除成功'];
            }
        }
        return $rs;
    }
}
