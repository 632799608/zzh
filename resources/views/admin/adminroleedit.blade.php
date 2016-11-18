@extends('admin.base')

@section('title', 'Page Title')

@section('sidebar')
    @parent   
@endsection

@section('content')
<body style="margin-left: -150px;" id="editrole">
<article class="page-container" >
	<form action="" method="post" class="form form-horizontal" id="form-admin-role-edit">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
			    <input  type="hidden" value="{{ csrf_token() }}" name="_token" v-model="role._token">
			    <input  type="hidden" value="{{ $role['id'] }}" name="" v-model="role.role_id">
				<input type="text" class="input-text" value="{{ $role['display_name'] }}" placeholder=""  name="roleName" minlength="2" maxlength="16" v-model="role.display_name" required>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">备注：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{ $role['description'] }}" placeholder="" id="" name=""  v-model="role.description">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">网站角色：</label>
			<div class="formControls col-xs-8 col-sm-9">
				@foreach($permissionsList['parent'] as $m)
					<dl class="permission-list">
						<dt>
							<label>
								<input type="checkbox" value="{{$m['id']}}"
								@if(in_array($m['id'],$permissions))
								checked="checked" 
								@endif name="user-Character-0" id="user-Character-0">
								{{ $m['display_name'] }}
							</label>
						</dt>
						<dd class="permission-list3">
							@foreach($permissionsList['children'] as $p)
								  @if($p['parent_id'] == $m['id'])
									<dl class="cl permission-list2">
										<dt>
											<label class="">
												<input type="checkbox"
												@if(in_array($p['id'],$permissions))
												checked="checked" 
												@endif
												value="{{$p['id']}}"  name="">
												{{$p['display_name']}}
											</label>
										</dt>
										<dd>
											@foreach($permissionsList['children'] as $c)
												@if($c['parent_id'] == $p['id'])
														<label class="">
															<input type="checkbox" 
															@if(in_array($c['id'],$permissions))
															checked="checked" 
															@endif
															value="{{$c['id']}}"  name="">
															{{$c['display_name']}}
														</label>
												@endif
											@endforeach
										</dd>
									</dl>	
								  @endif
							@endforeach
						</dd>
					</dl>
				@endforeach
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
	el:"#editrole",
	data:{
		role:{},
	},
	methods:{
	    roleedit:function(){
	    	console.log(this.role);
	    	var a = $(":checked");
	    	var b = [];
	    	for (var i = a.length - 1; i >= 0; i--) {
	    		if(a[i].value > 0){
	    			b.push(a[i].value);
	    		}
	    	}
	    	this.role.permissionsid = b;
		  	this.$http.post('/admin/role/edit/1',this.role)
			   .then(function (response) {
	                if(response.data.status == -1){
	                   layer.msg(response.data.message);
	                }else if(response.data.status == 1){
	                   // layer.msg(response.data.message,{icon: 6,time:6000});
	                   layer.msg(response.data.message, {
						  icon: 1,
						  time: 2000 //2秒关闭（如果不配置，默认是3秒）
						}, function(){
							layer_close();
						  // window.location.href = history.go(-1);
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
$(function(){
	$(".permission-list dt input:checkbox").click(function(){
		$(this).closest("dl").find("dd input:checkbox").prop("checked",$(this).prop("checked"));
	});
	$(".permission-list2 dt input:checkbox").click(function(){
		if($(this).prop("checked")){
		    $(this).parents(".permission-list").find("dt input:checkbox").first().prop("checked",true);
		}else{
			var n = $(this).parents(".permission-list3").find("dl dt input:checked").length;
			
			if(n > 0){
				$(this).parents(".permission-list").find("dt input:checkbox").first().prop("checked",true);
			}else{
				$(this).parents(".permission-list").find("dt input:checkbox").first().prop("checked",false);
			}
	    }
	});
	$(".permission-list2 dd input:checkbox").click(function(){
		
		if($(this).prop("checked")){
			$(this).closest("dl").find("dt input:checkbox").prop("checked",true);
			$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",true);
		}
		else{
			var l =$(this).parent().parent().find("input:checked").length;
			if(l==0){
				$(this).parent().parent().parent().find("dt input:checkbox").prop("checked",false);
			}
			var l2=$(this).parents(".permission-list3").find("dl dt").find("input:checked").length;
			if(l2<1){
				$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",false);
			}
		}
	});

	$("#form-admin-role-edit").validate({
		// rules:{
		// 	// roleName:{
		// 	// 	required:true,
		// 	// 	minlength:4,
		// 	// 	maxlength:16
		// 	// },
		// },
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			vn.roleedit();
		}
	});
});
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
@endsection