@extends('admin.base')

@section('title', 'Page Title')

@section('sidebar')
    @parent   
@endsection

@section('content')
<body style="margin-left: -460px"> 
<article class="page-container" style="margin-left: 350px" id="adduser">
	<form class="form form-horizontal" id="form-admin-add">
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>管理员：</label>
		<div class="formControls col-xs-8 col-sm-9">
		    <input  type="hidden" value="{{ csrf_token() }}" v-model="user._token">
			<input type="text" class="input-text" value="" placeholder="" name="userName" v-model="user.userName">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>初始密码：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="password" class="input-text" autocomplete="off" value="" placeholder="密码"  name="password" v-model="user.password" id="password">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>确认密码：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="password" id="password2" class="input-text" autocomplete="off"  placeholder="确认新密码" name="password2" v-model="user.password2">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>邮箱：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" placeholder="@" name="email" v-model="user.email">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色：</label>
		<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
			<select class="select" name="userRole" size="1" v-model="user.userRole">
			  @foreach($rolelist as $role)
			    <!-- <option value="0" selected="true">请选择角色</option> -->
				<option value="{{$role['id']}}">{{ $role->name }}</option>
			   @endforeach
			</select>
			</span> </div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">备注：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<textarea name="" cols="" rows="" class="textarea"  placeholder="说点什么...100个字符以内" dragonfly="true" onKeyUp="textarealength(this,100)" v-model="user.detail"></textarea>
			<p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
		</div>
	</div>
	<div class="row cl">
		<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
			<button class="btn btn-primary radius" type="button" @click="useradd()">&nbsp;&nbsp;提交&nbsp;&nbsp;</button>
		</div>
	</div>
	</form>
</article>
<!--请在下方写此页面业务相关的脚本--> 
<script type="text/javascript">
var vn = new Vue({
	el:"#adduser",
	data:{
		user:{},
	},
	methods:{
	    useradd:function(){
		  	this.$http.post('/admin/add',this.user)
			   .then(function (response) {
			        console.log(response.data);
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
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});
	
	$("#form-admin-add").validate({
		rules:{
			userName:{
				required:true,
				minlength:4,
				maxlength:16
			},
			password:{
				required:true,
			},
			password2:{
				required:true,
				equalTo: "#password"
			},
			email:{
				required:true,
				email:true,
			},
			userRole:{
				required:true,
			},
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			$(form).ajaxSubmit();
			var index = parent.layer.getFrameIndex(window.name);
			parent.$('.btn-refresh').click();
			parent.layer.close(index);
		}
	});
});
</script> 
<!--/请在上方写此页面业务相关的脚本-->
</body>        
@endsection