@extends('admin.base')

@section('title', 'Page Title')

@section('sidebar')
    @parent   
@endsection
@section('content')
<input  type="hidden" value="{{ csrf_token() }}" id="token">
<div style="margin-left: -230px" id="user">
	<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 管理员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
	<div class="page-container">
		<div class="text-c"> 日期范围：
			<input type="text" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}'})" id="datemin" class="input-text Wdate" style="width:120px;">
			-
			<input type="text" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d'})" id="datemax" class="input-text Wdate" style="width:120px;">
			<input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="seekname" name="">
			<button type="submit" class="btn btn-success" id="" name="" @click="seek()"><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
		</div>
		<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
        @if(in_array(4,$user['permission_id']))
		<a href="javascript:;" onclick="admin_add('添加管理员','/admin/add','800','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a>
        @endif
		</span> <span class="r">共有数据：<strong>@{{total}}</strong> 条</span> </div>
		<table class="table table-border table-bordered table-bg">
			<thead>
				<tr>
					<th scope="col" colspan="9">员工列表</th>
				</tr>
				<tr class="text-c">
					<th width="25"><input type="checkbox" name="" value=""></th>
					<th width="40">ID</th>
					<th width="150">用户名</th>
					<th width="150">邮箱</th>
					<th>角色</th>
					<th width="130">加入时间</th>
					<th width="130">编辑时间</th>
					<th width="100">是否已启用</th>
					<th width="100">操作</th>
				</tr>
			</thead>
			<tbody>
                    <tr class="text-c" v-for="u in userlist">
						<td>
							<input type="checkbox" value="1" name="">
							<input  type="hidden" name="token" value="{{ csrf_token() }}">
						</td>
						<td>@{{ u.id}}</td>
						<td>@{{ u.name}}</td>
						<td>@{{ u.email}}</td>
						<td>@{{ u.display_name}}</td>
						<td>@{{ u.created_at}}</td>
						<td>@{{ u.updated_at}}</td>
						<td class="td-status">
							<span class="label label-success radius" v-if="u.is_use == 1">已启用</span>
							<span class="label label-success radius" v-if="u.is_use == 0">已禁用</span>
						</td>
						<td class="td-manage">
						  @if(in_array(8,$user['permission_id']))
							<span v-if="u.is_use == 1"><a style="text-decoration:none" onClick="admin_stop(this,@{{ u.id}})" href="javascript:;" title="停用" ><i class="Hui-iconfont">&#xe631;</i></a></span>
							<span v-if="u.is_use == 0"><a style="text-decoration:none" onClick="admin_start(this,@{{ u.id}})" href="javascript:;" title="启用" ><i class="Hui-iconfont">&#xe631;</i></a></span>
						  @endif
						  @if(in_array(6,$user['permission_id']))
							<a title="编辑" href="javascript:;" onclick="admin_edit('管理员编辑','/admin/edit/@{{ u.id}}',@{{ u.id}},'800','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
						  @endif
						  @if(in_array(5,$user['permission_id']))
							 <a title="删除" href="javascript:;" onclick="admin_del(this,@{{ u.id}})" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
						  @endif
						</td>
					</tr>	
			</tbody>
		</table>
		<div>
		<button @click="pre()"  type="button" class="btn btn-warning">上一页</button>
		<span class="btn btn-success">第@{{ user.pagination.current_page }}/@{{ page }}页</span>
		<button @click="next()"  type="button" class="btn btn-warning">下一页</button></div>
	</div>
</div>
<script type="text/javascript">
var vn = new Vue({
	el:"#user",
	data:{
		user:{
			  pagination: {
                current_page: 1,
                name:'',
            },
		},
		total:'',
		page:'',
		userlist:[],
	},
	created:function(){
		this.list();
	},
	methods:{
	    list:function(){
	    	this.user._token = $("#token").val();
		  	this.$http.post('/admin/list',this.user)
			   .then(function (response) {
				   	this.$set('userlist',response.data.list);
				   	this.$set('page',response.data.page);
				   	this.$set('total',response.data.total);
				   	if(response.data.total == 0){
	                  this.user.pagination.current_page = 0;
				   	}
			    }, function (response) {
				    if(response.status == 422){
				       layer.msg(response.data[0]);
				    }
		    });
		},
        next:function(){
        	if(this.user.pagination.current_page < this.page){
        	    this.user.pagination.current_page++;
        	}else{
        		return false;
        	}
        	this.list();
        },
        pre:function(){
        	if(this.user.pagination.current_page > 1){
        	    this.user.pagination.current_page--;
        	}else{
        		return false;
        	}
        	this.list();
        },
        seek:function(){
        	this.$set('userlist',[]);
        	this.user.pagination.name = $("#seekname").val();
        	this.user.pagination.current_page = 1,
        	this.list();
        }
	}
});
/*
	参数解释：
	title	标题
	url		请求的url
	id		需要操作的数据id
	w		弹出层宽度（缺省调默认值）
	h		弹出层高度（缺省调默认值）
*/
/*管理员-增加*/
function admin_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-删除*/
function admin_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……
		$.ajax({
            type: "POST",
            url: '/admin/del',
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
/*管理员-编辑*/
function admin_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*管理员-停用*/
function admin_stop(obj,id){
	layer.confirm('确认要停用吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……
		$.ajax({
            type: "POST",
            url: '/admin/stop',
            dataType: 'json',
            cache: false,
            data:{id:id,_token:$("input[name = token]").val()},
            success: function(data) {
                if(data['status'] == 1){
					$(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_start(this,{{ $user->id}})" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
					$(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">已禁用</span>');
					$(obj).remove();
					layer.msg('已停用!',{icon: 5,time:1000});
                }
            },
            error: function(xhr, status, error) {
                console.log('系统错误');
            }
        });
	});
}

/*管理员-启用*/
function admin_start(obj,id){
	layer.confirm('确认要启用吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……
		$.ajax({
            type: "POST",
            url: '/admin/start',
            dataType: 'json',
            cache: false,
            data:{id:id,_token:$("input[name = token]").val()},
            success: function(data) {
                if(data['status'] == 1){
					$(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_stop(this,{{ $user->id}})" href="javascript:;" title="停用" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
					$(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
					$(obj).remove();
					layer.msg('已启用!', {icon: 6,time:1000});
                }
            },
            error: function(xhr, status, error) {
                console.log('系统错误');
            }
        });
	});
}
</script>
@endsection






