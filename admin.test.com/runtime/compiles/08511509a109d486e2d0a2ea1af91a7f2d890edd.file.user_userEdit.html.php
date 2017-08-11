<?php /* Smarty version Smarty-3.1.18, created on 2017-08-12 00:59:59
         compiled from "E:\www\github\admin.v218.com\static\tpl\sys\user_userEdit.html" */ ?>
<?php /*%%SmartyHeaderCode:20480598de28fd62ff6-76210613%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '08511509a109d486e2d0a2ea1af91a7f2d890edd' => 
    array (
      0 => 'E:\\www\\github\\admin.v218.com\\static\\tpl\\sys\\user_userEdit.html',
      1 => 1496583222,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20480598de28fd62ff6-76210613',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user' => 0,
    'groups' => 0,
    'val' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_598de28fe55333_39483844',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_598de28fe55333_39483844')) {function content_598de28fe55333_39483844($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<article class="page-container">
	<form action="" method="post" class="form form-horizontal" id="ajaxForm">
		<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
" name="id" />
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>用户名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo $_smarty_tpl->tpl_vars['user']->value['uname'];?>
" placeholder="" id="uname" name="uname">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>密码：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="password" class="input-text" value="" placeholder="" id="password" name="password">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>确认密码：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="password" class="input-text" value="" placeholder="" id="repassword" name="repassword">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">所属用户组：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<span class="select-box">
				<select class="select" size="1" name="groupid">
					<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['groups']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['val']->value['id']==$_smarty_tpl->tpl_vars['user']->value['groupid']) {?>selected<?php }?> ><?php echo $_smarty_tpl->tpl_vars['val']->value['gname'];?>
</option>
					<?php } ?>
				</select>
				</span>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">状态：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<span class="select-box">
				<select class="select" size="1" name="status">
					<option value="1" <?php if (1==$_smarty_tpl->tpl_vars['user']->value['status']) {?>selected<?php }?> >启用</option>
					<option value="0" <?php if (0==$_smarty_tpl->tpl_vars['user']->value['status']) {?>selected<?php }?> >停用</option>
				</select>
				</span>
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<button class="btn btn-primary radius" type="submit">提交</button>
				<button class="btn btn-primary radius" type="button" id="cancel_open">取消</button>
			</div>
		</div>
	</form>
</article>

<?php echo $_smarty_tpl->getSubTemplate ("../common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
