<?php /* Smarty version Smarty-3.1.18, created on 2017-08-12 00:57:54
         compiled from "E:\www\github\admin.v218.com\static\tpl\sys\userGroup_groupEdit.html" */ ?>
<?php /*%%SmartyHeaderCode:31517598de212649e79-37234334%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e5f7236ffb2a6c9d284b644190723f130a825fd3' => 
    array (
      0 => 'E:\\www\\github\\admin.v218.com\\static\\tpl\\sys\\userGroup_groupEdit.html',
      1 => 1496583268,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '31517598de212649e79-37234334',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'userGroup' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_598de2126ab913_98872064',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_598de2126ab913_98872064')) {function content_598de2126ab913_98872064($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<article class="page-container">
	<form action="" method="post" class="form form-horizontal" id="ajaxForm">
		<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['userGroup']->value['id'];?>
" name="id" />
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>组名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo $_smarty_tpl->tpl_vars['userGroup']->value['gname'];?>
" placeholder="" id="gname" name="gname">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">状态：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<span class="select-box">
				<select class="select" size="1" name="status">
					<option value="1" <?php if ($_smarty_tpl->tpl_vars['userGroup']->value['status']==1) {?>selected<?php }?> >启用</option>
					<option value="0" <?php if ($_smarty_tpl->tpl_vars['userGroup']->value['status']==0) {?>selected<?php }?> >停用</option>
				</select>
				</span>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">备注：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<textarea name="remark" cols="" rows="" class="textarea"  placeholder="说点什么..." onKeyUp="$.Huitextarealength(this,100)"><?php echo $_smarty_tpl->tpl_vars['userGroup']->value['remark'];?>
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
