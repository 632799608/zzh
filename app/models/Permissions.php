<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = true;
    /**
     *  [index 获取权限列表分页]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-30T12:58:18+0800
     *  @return   [type]                   [description]
     */
    public function index(){
      $list = [];
      $list['parent'] = $this->where('parent_id','=',0)->paginate(3);
      $list['children'] = $this->where('parent_id','>',0)->get();
      return $list;
    }
    /**
     *  [index 获取权限列表]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-30T12:58:18+0800
     *  @return   [type]                   [description]
     */
    public function permissionslist(){
      $list = [];
      // $list['menu'] = $this->where('parent_id','=',0)->get();
      $list['parent'] = $this->where('parent_id','=',0)->get();
      $list['children'] = $this->where('parent_id','>',0)->get();
      return $list;
    }
    /**
     *  [permission 获取一条权限记录]
     *  臭虫科技
     *  @author qingfeng
     *  @DateTime 2016-10-18T10:23:26+0800
     *  @return   [type]                   [description]
     */
    public function permission($id){
      return $this->find($id);
    }
    /**
   *  [index description]
   *  臭虫科技
   *  @author chouchong
   *  @DateTime 2016-09-30T14:46:04+0800
   *  @return   [type]                   [description]
   */
    public function permissionadd($request){
      $rs = ['status'=>-1,'message'=>'添加失败'];
      $exception = $this->insert($request->except('_token'));
      if($exception){
        $rs = ['status'=>1,'message'=>'添加成功'];
      }
      return $rs;
    }
    /**
     *  [permissionedit description]
     *  臭虫科技
     *  @author qingfeng
     *  @DateTime 2016-10-18T10:11:45+0800
     *  @param    [type]                   $request [description]
     *  @return   [type]                            [description]
     */
    public function permissionedit($request){
      $rs = ['status'=>-1,'message'=>'编辑失败'];
      $exception = $this->where('id','=',$request->input('id'))->update($request->except('_token'));
      if($exception){
        $rs = ['status'=>1,'message'=>'编辑成功'];
      }
      return $rs;
    }
    /**
     *  [permissiondel description]
     *  臭虫科技
     *  @author qingfeng
     *  @DateTime 2016-10-18T11:31:28+0800
     *  @param    [type]                   $id [description]
     *  @return   [type]                       [description]
     */
    public function permissiondel($request){
      $rs = ['status'=>-1,'message'=>'删除失败'];
      $children = $this->where('parent_id','=',$request->input('id'))->get();
      if(count($children)>0){
        $rs = ['status'=>-1,'message'=>'请先删除该权限下的子权限'];
      }else{
        $id = $this->where('id','=',$request->input('id'))->delete();
        if($id){
          $rs = ['status'=>1,'message'=>'删除成功'];
        }
      }
      return $rs;
    }
}
