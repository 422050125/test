<?php /* Smarty version Smarty-3.1.18, created on 2017-08-10 19:41:30
         compiled from "E:\www\github\admin.v218.com\static\tpl\sys\user_login.html" */ ?>
<?php /*%%SmartyHeaderCode:6874598c466a1ae5d8-90230755%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2615dac6ec709e76201da1b749cd5ebec50fd277' => 
    array (
      0 => 'E:\\www\\github\\admin.v218.com\\static\\tpl\\sys\\user_login.html',
      1 => 1496428496,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6874598c466a1ae5d8-90230755',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_598c466a38af43_38429472',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_598c466a38af43_38429472')) {function content_598c466a38af43_38429472($_smarty_tpl) {?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5shiv.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<![endif]-->
<link href="/static/lib/H-ui.admin_v3.0/static/h-ui/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="/static/lib/H-ui.admin_v3.0/static/h-ui.admin/css/H-ui.login.css" rel="stylesheet" type="text/css" />
<link href="/static/lib/H-ui.admin_v3.0/static/h-ui.admin/css/style.css" rel="stylesheet" type="text/css" />
<link href="/static/lib/H-ui.admin_v3.0/lib/Hui-iconfont/1.0.8/iconfont.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/static/lib/H-ui.admin_v3.0/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/static/lib/H-ui.admin_v3.0/lib/layer/layer.js"></script>
<!--[if IE 6]>
<script type="text/javascript" src="/static/lib/H-ui.admin_v3.0/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>后台登录</title>
</head>
<body>

<input type="hidden" id="TenantId" name="TenantId" value="" />
<!--<div class="header"></div>-->
<div class="loginWraper">
  <div id="loginform" class="loginBox">
    <form class="form form-horizontal" action="" method="post" id="ajaxForm">
      <div class="row cl">
        <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
        <div class="formControls col-xs-8">
          <input id="uname" name="uname" type="text" placeholder="账户" class="input-text size-L">
        </div>
      </div>
      <div class="row cl">
        <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
        <div class="formControls col-xs-8">
          <input id="password" name="password" type="password" placeholder="密码" class="input-text size-L">
        </div>
      </div>
      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <input class="input-text size-L" name="checkCode" type="text" placeholder="验证码"  value="" style="width:150px;">
          <img src="?m=sys&c=Sys&a=vcode" width="88" height="41" onclick="this.src='?m=sys&c=Sys&a=vcode&'+Math.random()" style="cursor:pointer;">
		</div>
      </div>
      <!--<div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <label for="online">
            <input type="checkbox" name="online" id="online" value="">
            使我保持登录状态</label>
        </div>
      </div>-->
      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <input name="" type="submit" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
          <input name="" type="reset" class="btn btn-default radius size-L" value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
        </div>
      </div>
    </form>
  </div>
</div>
<div class="footer">Copyright fangjinwei</div>

<?php echo $_smarty_tpl->getSubTemplate ("../common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
