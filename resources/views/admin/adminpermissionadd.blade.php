@extends('admin.base')

@section('title', 'Page Title')

@section('sidebar')
    @parent   
@endsection

@section('content')
<body style="margin-left: -150px;" id="addpermission">
<article class="page-container" >
	<form action="" method="post" class="form form-horizontal" id="form-admin-permission-add">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>权限名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
			    <input  type="hidden" value="{{ csrf_token() }}" name="_token" v-model="permission._token">
				<input type="text" class="input-text" value="" placeholder=""  name="permissiondisplay_name" v-model="permission.display_name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>字段名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder=""  name="permissionname" v-model="permission.name" required>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>上级权限：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
				<select class="select" name="userRole" size="1" v-model="permission.parent_id">
				    <option value="0" selected="true">请选择上级权限</option>
					    @foreach($permissionslist['parent'] as $p)
							<option value="{{$p['id']}}">{{ $p->display_name }}</option>
							@foreach($permissionslist['children'] as $c)
								@if($c['parent_id'] == $p['id'])
								<option value="{{$c['id']}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $c->display_name }}</option>
								@endif
							@endforeach
					    @endforeach
				</select>
				</span> </div>
	    </div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">备注：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder="" id="" name=""  v-model="permission.description">
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<button  class="btn btn-success radius" id="admin-role-save" name="admin-role-save"><i class="icon-ok"></i> 确定</button>
			</div>
		</div>
	</form>
</article>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript">
var vn = new Vue({
	el:"#addpermission",
	data:{
		permission:{},
	},
	methods:{
	    permissionadd:function(){
		  	this.$http.post('/admin/permission/add',this.permission)
			   .then(function (response) {
			        console.log(response.data);
	                if(response.data.status == -1){
	                   layer.msg(response.data.message);
	                }else if(response.data.status == 1){
	                   layer.msg(response.data.message, {
						  icon: 1,
						  time: 2000 //2秒关闭（如果不配置，默认是3秒）
						}, function(){
							layer_close();
					    });  
	                }
			    }, function (response) {
				    if(response.status == 422){
				       layer.msg(response.data[0]);
				    }
		    });
		}
	}
});
	$("#form-admin-permission-add").validate({
		rules:{
			permissiondisplay_name:{
				required:true,
				minlength:2,
				maxlength:16
			},
			permissionname:{
				required:true,
			},
		},
		onkeyup:true,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			vn.permissionadd();
		}
	});
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
@endsection