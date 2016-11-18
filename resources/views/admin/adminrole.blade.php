@extends('admin.base')

@section('title', 'Page Title')

@section('sidebar')
    @parent   
@endsection

@section('content')
<body style="margin-left: -460px" >
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 角色管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="cl pd-5 bg-1 bk-gray"> <span class="l"> <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
	@if(in_array(11,$user['permission_id']))
	   <a class="btn btn-primary radius" href="javascript:;" onclick="admin_role_add('添加角色','/admin/role/add','800')"><i class="Hui-iconfont">&#xe600;</i> 添加角色</a> 
	@endif
	</span> <span class="r">共有数据：<strong>54</strong> 条</span> </div>
	<input  type="hidden" name="token" value="{{ csrf_token() }}">
	<table class="table table-border table-bordered table-hover table-bg">
		<thead>
			<tr>
				<th scope="col" colspan="6">角色管理</th>
			</tr>
			<tr class="text-c">
				<th width="25"><input type="checkbox" value="" name=""></th>
				<th width="40">ID</th>
				<th width="200">角色名</th>
				<th>用户列表</th>
				<th width="300">描述</th>
				<th width="70">操作</th>
			</tr>
		</thead>
		<tbody>
		  @foreach($roleList as $role)
			<tr class="text-c">
				<td><input type="checkbox" value="" name=""></td>
				<td>{{$role['id']}}</td>
				<td>{{$role['display_name']}}</td>
				<td>
					@foreach($role->users as $u)
                       {{$u['name']}},
					@endforeach
				</td>
				<td>{{$role['description']}}</td>
				<td class="f-14">
					@if(in_array(12,$user['permission_id']))
						<a title="编辑" href="javascript:;" onclick="admin_role_edit('角色编辑','/admin/role/edit/{{$role->id}}',1)" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
					@endif
					@if(in_array(24,$user['permission_id']))
						<a title="删除" href="javascript:;" onclick="admin_role_del(this,{{$role['id']}})" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
					@endif
				</td>
			</tr>
		  @endforeach
		</tbody>
	</table>
</div>
<script type="text/javascript">
/*管理员-角色-添加*/
function admin_role_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-角色-编辑*/
function admin_role_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*管理员-角色-删除*/
function admin_role_del(obj,id){
	layer.confirm('角色删除须谨慎，确认要删除吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……
		$.ajax({
            type: "POST",
            url: '/admin/role/del',
            dataType: 'json',
            cache: false,
            data:{id:id,_token:$("input[name = token]").val()},
            success: function(data) {
            	  console.log(data);
                if(data['status'] == 1){
                	$(obj).parents("tr").remove();
	                layer.msg('已删除!',{icon:1,time:1000});
                }else{
                	layer.msg(data['message'],{icon:2,time:1000});
                }
            },
            error: function(xhr, status, error) {
                console.log('系统错误');
            }
        });
	});
}
</script>
</body>
@endsection

