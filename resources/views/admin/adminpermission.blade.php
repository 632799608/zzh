 @extends('admin.base')

@section('title', 'Page Title')

@section('sidebar')
    @parent   
@endsection

@section('content')
<body style="margin-left: -460px">
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 权限管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="text-c">
		<form class="Huiform" method="post" action="" target="_self">
			<input type="text" class="input-text" style="width:250px" placeholder="权限名称" id="" name="">
			<button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜权限节点</button>
		</form>
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> 
    @if(in_array(25,$user['permission_id']))
	<a href="javascript:;" onclick="admin_permission_add('添加权限节点','/admin/permission/add','','310')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加权限节点</a>
	@endif
	</span> <span class="r">共有数据：<strong>54</strong> 条</span> </div>
	<table class="table table-border table-bordered table-bg">
		<thead>
			<tr>
				<th scope="col" colspan="7">权限节点</th>
			</tr>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="" value=""></th>
				<th width="40">ID</th>
				<th width="200">权限名称</th>
				<th>字段名</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
		  @foreach($permissionList['parent'] as $parent)
			<tr class="text-c success">
				<td><input type="checkbox" value="1" name=""></td>
				<td>{{ $parent['id'] }}</td>
				<td>{{ $parent->display_name }}</td>
				<td>{{ $parent->name }}</td>
				<td>
				@if(in_array(27,$user['permission_id']))
				<a title="编辑" href="javascript:;" onclick="admin_permission_edit('权限编辑','/admin/permission/edit/{{$parent['id']}}',{{ $parent['id'] }},'','310')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
				@endif
                @if(in_array(26,$user['permission_id']))
				<a title="删除" href="javascript:;" onclick="admin_permission_del(this,{{ $parent['id'] }})" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
                @endif
				</td>
			</tr>
			@foreach($permissionList['children'] as $children)
			  @if($children['parent_id'] == $parent['id'])
				<tr class="text-c warning">
					<td><input type="checkbox" value="1" name="">
					<input  type="hidden" name="token" value="{{ csrf_token() }}"></td>
					<td>{{ $children['id'] }}</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;┗━━{{ $children->display_name }}</td>
					<td>{{ $children->name }}</td>
					<td>
					@if(in_array(27,$user['permission_id']))
					<a title="编辑" href="javascript:;" onclick="admin_permission_edit('权限编辑','/admin/permission/edit/{{ $children['id'] }}',{{ $children['id'] }},'','310')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
					@endif
					@if(in_array(26,$user['permission_id']))
					<a title="删除" href="javascript:;" onclick="admin_permission_del(this,{{ $children['id'] }})" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
					@endif
					</td>
				</tr>
					@foreach($permissionList['children'] as $sun)
						@if($sun['parent_id'] == $children['id'])
							<tr class="text-c">
								<td><input type="checkbox" value="1" name=""></td>
								<td>{{ $sun['id'] }}</td>
								<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;━━{{ $sun->display_name }}</td>
								<td>{{ $sun->name }}</td>
								<td>
								@if(in_array(27,$user['permission_id']))
								<a title="编辑" href="javascript:;" onclick="admin_permission_edit('权限编辑','/admin/permission/edit/{{ $sun['id'] }}',{{ $sun['id'] }},'','310')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
								@endif
								@if(in_array(26,$user['permission_id'])) 
								<a title="删除" href="javascript:;" onclick="admin_permission_del(this,{{ $sun['id'] }})" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
								@endif
								</td>
							</tr>
						@endif
					@endforeach
			  @endif
			@endforeach
		  @endforeach
		</tbody>
	</table>
	{{ $permissionList['parent']->links() }}
	
</div>
<script type="text/javascript">
/*
	参数解释：
	title	标题
	url		请求的url
	id		需要操作的数据id
	w		弹出层宽度（缺省调默认值）
	h		弹出层高度（缺省调默认值）
*/
/*管理员-权限-添加*/
function admin_permission_add(title,url,w,h){
	layer_show(title,url,w,h);

}
/*管理员-权限-编辑*/
function admin_permission_edit(title,url,id,w,h){
	layer_show(title,url,w,h);

}

/*管理员-权限-删除*/
function admin_permission_del(obj,id){
	layer.confirm('权限删除须谨慎，确认要删除吗？',function(index){
		$.ajax({
            type: "POST",
            url: '/admin/permission/del',
            dataType: 'json',
            cache: false,
            data:{id:id,_token:$("input[name = token]").val()},
            success: function(data) {
                if(data['status'] == 1){
                	$(obj).parents("tr").remove();
		            layer.msg(data['message'],{icon:1,time:1000});
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