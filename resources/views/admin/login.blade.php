<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<script type="text/javascript" src="lib/PIE_IE678.js"></script>
<![endif]-->
<link href="/admin/static/h-ui/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="/admin/static/h-ui.admin/css/H-ui.login.css" rel="stylesheet" type="text/css" />
<link href="/admin/static/h-ui.admin/css/style.css" rel="stylesheet" type="text/css" />
<link href="/admin/lib/Hui-iconfont/1.0.7/iconfont.css" rel="stylesheet" type="text/css" />
<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>后台登录 - H-ui.admin v2.3</title>
<meta name="keywords" content="H-ui.admin v2.3,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
<meta name="description" content="H-ui.admin v2.3，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>
<input type="hidden" id="TenantId" name="TenantId" value="" />
<div class="header"></div>
<div class="loginWraper">
  <div id="loginform" class="loginBox">
      <validator name="loginValidation">
        <form class="form form-horizontal" method="POST" role="form" novalidate>
        <div class="row cl">
            <input  type="hidden" value="{{ csrf_token() }}" v-model="user._token">
        </div>
        <div class="row cl">
          <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
          <div class="formControls col-xs-8">
            <input name="userName" type="text" placeholder="账户" class="input-text size-L" 
            v-model="user.userName">
          </div>
        </div>
        <div class="row cl">
          <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
          <div class="formControls col-xs-8">
            <input name="password" type="password" placeholder="密码" class="input-text size-L"
            v-model="user.password">
          </div>
        </div>
        <div class="row cl">
          <div class="formControls col-xs-8 col-xs-offset-3">
            <input class="input-text size-L" type="text" placeholder="验证码" style="width:150px;" name="captcha" v-model="user.captcha">
            <img id="captcha" src="{{ URL('captcha/1') }}"> <a id="kanbuq" @click="re_captcha">看不清，换一张</a> </div>
        </div>

        <div class="row cl">
          <div class="formControls col-xs-8 col-xs-offset-3">
            <button type="button" @click="login()" :disabled="$loginValidation.invalid" class="btn btn-success radius size-L">&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;</button>
          </div>
        </div>
       </form>
      </validator>
  </div>
</div>
<div class="footer">Copyright 臭虫科技 by H-ui.admin.v2.3</div>
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/admin/js/vue/vue.js"></script>
<script type="text/javascript" src="/admin/js/vue/vue-validator.js"></script>
<script type="text/javascript" src="/admin/lib/layer/2.1/layer.js"></script>
<script src="http://cdn.bootcss.com/vue-resource/1.0.0/vue-resource.js"></script>
<script>
var vn = new Vue({
  el:"#loginform",
  data:{
    user:{},
  },
  methods:{
    re_captcha:function(){
      var url = "{{ URL('captcha') }}";
        url = url + "/" + Math.random();
        $("#captcha").prop('src',url);
    },
    login:function(){
      if($("input[name='userName']").val() == ''){
          return layer.msg('账户名不能为空');
      }
      var email = /^(\w)+(\.\w+)*@(\w)+((\.\w{2,3}){1,3})$/;
      if(vn.user.userName == ''){
          return layer.msg('账户不能为空');
      }
      else if(!email.test(vn.user.userName)){
          return layer.msg('账户必须为邮箱');
      }  
      else if(vn.user.password.length > 20 || vn.user.password.length < 6 ){
          return layer.msg('密码为6-20位');
      }
      else if(vn.user.captcha == null){
          return layer.msg('请输入验证码');
      }
      else if(vn.user.captcha.length != 5){
          return layer.msg('验证码为5位数');
      }
      this.$http.post('/login',this.user)
      .then(function (response) {
        console.log(66);
        console.log(response.data);
                  if(response.data.status == -1){
                    layer.msg(response.data.message);
                  }else if(response.data.status == 1){
                    console.log(5);
                    window.location.href = '{{url("admin/index")}}';
                  }
      }, function (response) {
          if(response.status == 422){
            layer.msg(response.data[0]);
          }
      });
    }
  }
})
</script>
</body>
</html>