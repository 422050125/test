<?php /* Smarty version Smarty-3.1.18, created on 2017-08-12 00:59:43
         compiled from "E:\www\github\admin.v218.com\static\tpl\sys\sys_menuEdit.html" */ ?>
<?php /*%%SmartyHeaderCode:15680598de27f90de42-10868418%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3d1987c9e43c8eccbd30672b6fdd65050914f8e8' => 
    array (
      0 => 'E:\\www\\github\\admin.v218.com\\static\\tpl\\sys\\sys_menuEdit.html',
      1 => 1496588864,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15680598de27f90de42-10868418',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'menu' => 0,
    'menuList' => 0,
    'val' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_598de27fa07e81_77284568',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_598de27fa07e81_77284568')) {function content_598de27fa07e81_77284568($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<article class="page-container">
	<form action="" method="post" class="form form-horizontal" id="ajaxForm">
		<input type="hidden" class="input-text" value="<?php echo $_smarty_tpl->tpl_vars['menu']->value['id'];?>
" placeholder="" name="id">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>菜单名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo $_smarty_tpl->tpl_vars['menu']->value['name'];?>
" placeholder="" id="name" name="name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">所属分类：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<span class="select-box">
				<select class="select" size="1" name="pid">
					<option value="0">请选择分类</option>
					<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menuList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
						<?php if ($_smarty_tpl->tpl_vars['val']->value['_child']) {?>
						<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['val']->value['_child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['v']->value['id']==$_smarty_tpl->tpl_vars['menu']->value['pid']) {?>selected<?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
						<?php } ?>
						<?php }?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['val']->value['id']==$_smarty_tpl->tpl_vars['menu']->value['pid']) {?>selected<?php }?> ><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</option>
					<?php } ?>
				</select>
				</span>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>module：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo $_smarty_tpl->tpl_vars['menu']->value['module'];?>
" placeholder="" id="module" name="module">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>controller：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo $_smarty_tpl->tpl_vars['menu']->value['controller'];?>
" placeholder="" id="controller" name="controller">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>action：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo $_smarty_tpl->tpl_vars['menu']->value['action'];?>
" placeholder="" name="action" id="action">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>排序：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo $_smarty_tpl->tpl_vars['menu']->value['sort'];?>
" placeholder="" name="sort" id="sort">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>图标：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo $_smarty_tpl->tpl_vars['menu']->value['icon'];?>
" placeholder="" name="icon" id="icon">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">状态：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<span class="select-box">
				<select class="select" size="1" name="status">
					<option value="0" <?php if ($_smarty_tpl->tpl_vars['menu']->value['status']==0) {?>selected<?php }?> >不显示</option>
					<option value="1" <?php if ($_smarty_tpl->tpl_vars['menu']->value['status']==1) {?>selected<?php }?> >显示</option>
				</select>
				</span>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">备注：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<textarea name="remark" cols="" rows="" class="textarea"  placeholder="说点什么..." onKeyUp="$.Huitextarealength(this,100)"><?php echo $_smarty_tpl->tpl_vars['menu']->value['remark'];?>
</textarea>
				<p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
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
