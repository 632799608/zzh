<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Providers\AppServiceProvider;
use Session;
use App\models\Permissions;
use Cache;
use Illuminate\Support\Facades\Redis as Redis;
class BaseController extends Controller
{
    public function __construct(Permissions $permissions,Request $request)
	{
		// dd($request->session()->get('user'));
		// dd(in_array('启用管理员',Session::get('user.permission_display_name')));
	   $menu = $permissions->permissionslist();
	   return view()->share(['menu'=>$menu]);
	}
}
