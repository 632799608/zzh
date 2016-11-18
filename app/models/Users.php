<?php

namespace App\models;
use Crypt;
use Illuminate\Database\Eloquent\Model;
use DB;
use Exception;
use Session;
class Users extends Model
{
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = true;

    /**
	 *  [index 查询管理员列表]
	 *  臭虫科技
	 *  @author chouchong
	 *  @DateTime 2016-09-22T15:33:40+0800
	 *  @return   [type]                   [description]
	 */
    public function index($request){
        $pagesize = 2;
        $list = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('users.*', 'roles.display_name')
            ->where('users.name','like','%'.$request->input('pagination.name').'%')
            // ->offset(1)
            // ->limit(1)
            ->skip(($request->input('pagination.current_page')-1)*$pagesize)//从第几条数据开始
            ->take($pagesize)//每页几条数据
            ->get();
        $leng = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('users.*', 'roles.display_name')
            ->where('users.name','like','%'.$request->input('pagination.name').'%')
            ->get();
        $users['pagesize'] =  $pagesize;
        $users['total'] =  count($leng);
        $users['list'] = $list;
        $users['page'] = ceil($users['total']/$pagesize);
    	return $users;
    }
    /**
     *  [role 关联role表]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-22T16:54:04+0800
     *  @return   [type]                   [description]
     */
    public function roles(){
       return $this->belongsToMany(Roles::class,'role_user','user_id','role_id');
    }
    /**
     *  [edit 停用账户]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-22T15:33:52+0800
     *  @return   [type]                   [description]
     */
    public function userStop($request){
    	$rs = ['status'=>-1];
    	$is = $this->where('id','=',$request->input('id'))->update(['is_use'=>0]);
    	if($is){
           $rs['status'] = 1;
    	}
    	return $rs;
    }
    /**
     *  [edit 启用账户]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-22T15:33:52+0800
     *  @return   [type]                   [description]
     */
    public function userStart($request){
    	$rs = ['status'=>-1];
    	$is = $this->where('id','=',$request->input('id'))->update(['is_use'=>1]);
    	if($is){
           $rs['status'] = 1;
    	}
    	return $rs;
    }
    /**
     *  [add 添加管理员]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-22T15:33:47+0800
     */
    public function add($request){
        $rs = ['status'=>-1,'message'=>'添加失败'];
        $exception = DB::transaction(function() use ($request) {
            $user_id = $this->insertGetId(['name'=>$request->input('userName'),
                               'email'=>$request->input('email'),
                               'detail'=>$request->input('detail'),
                               'password'=>Crypt::encrypt($request->input('password'))]);
            DB::table('role_user')->insert(['user_id'=>$user_id,
                                            'role_id'=>$request->input('userRole')]);
        });
        if($exception == null){
            $rs = ['status'=>1,'message'=>'添加成功'];
        }
        return $rs;
    }
    /**
     *  [edit 编辑管理员]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-22T15:33:52+0800
     *  @return   [type]                   [description]
     */
    public function edit($request){
        $rs = ['status'=>-1,'message'=>'编辑失败'];
        $exception = DB::transaction(function() use ($request) {
            $this->where('id','=',$request->input('id'))->
                 update(['name'=>$request->input('userName'),
                    // 'email'=>$request->input('email'),
                        'detail'=>$request->input('detail'),
                        'password'=>Crypt::encrypt($request->input('password'))]);
            DB::table('role_user')->where('user_id','=',$request->input('id'))->
                    update(['role_id'=>$request->input('userRole')]);
        });
        if($exception == null){
            $rs = ['status'=>1,'message'=>'编辑成功'];
        }
        return $rs;   
    }
    /**
     *  [edit 刪除管理员]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-22T15:33:52+0800
     *  @return   [type]                   [description]
     */
    public function del($request){  
        $rs = ['status'=>-1,'message'=>'刪除失败'];
        $exception = DB::transaction(function() use ($request) {
            $this->where('id','=',$request->input('id'))->delete();
            DB::table('role_user')->where('user_id','=',$request->input('id'))->delete();
        });
        if($exception == null){
            $rs = ['status'=>1,'message'=>'刪除成功'];
        }
        return $rs;     
    }
    /**
     *  [edit 刪除管理员]
     *  臭虫科技
     *  @author chouchong
     *  @DateTime 2016-09-22T15:33:52+0800
     *  @return   [type]                   [description]
     */
    public function userSession(){
        return Session::get('user');
    }

}
