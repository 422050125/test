<?php /* Smarty version Smarty-3.1.18, created on 2017-08-12 00:57:05
         compiled from "E:\www\github\admin.v218.com\static\tpl\sys\sys_Log.html" */ ?>
<?php /*%%SmartyHeaderCode:20955598de1e1525054-78733006%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '49970e32b3a723914519d684d3012190ad1aca49' => 
    array (
      0 => 'E:\\www\\github\\admin.v218.com\\static\\tpl\\sys\\sys_Log.html',
      1 => 1497169862,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20955598de1e1525054-78733006',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'users' => 0,
    'val' => 0,
    'whereData' => 0,
    'logs' => 0,
    'page_html' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_598de1e1678e20_23168964',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_598de1e1678e20_23168964')) {function content_598de1e1678e20_23168964($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
	<span class="c-gray en">&gt;</span>系统管理<span class="c-gray en">&gt;</span>日志查询
	<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">
	<div class="text-c">
		<form class="Huiform" method="post" action="">
            <span class="select-box" style="width:140px;">
                <select name="uid" class="select" id="search_brand">
					<option value="0" class="select option" name="uid">请选择用户</option>
					<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['users']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
 <?php if ($_smarty_tpl->tpl_vars['val']->value['id']==$_smarty_tpl->tpl_vars['whereData']->value['uid']) {?>selected<?php }?>" class="select option" <?php if ($_smarty_tpl->tpl_vars['whereData']->value['uid']==$_smarty_tpl->tpl_vars['val']->value['id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['uname'];?>
</option>
					<?php } ?>
				</select>
            </span>
			<input name="sdate" type="text" value="<?php echo $_smarty_tpl->tpl_vars['whereData']->value['sdate'];?>
" placeholder="开始日期" class="input-text" style="width:150px" onclick="laydate({istime: true, format: 'YYYY-MM-DD'})">
			<input name="edate" type="text" value="<?php echo $_smarty_tpl->tpl_vars['whereData']->value['edate'];?>
" placeholder="结束日期" class="input-text" style="width:150px" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})">
			<input name="module" type="text" placeholder="module" value="<?php echo $_smarty_tpl->tpl_vars['whereData']->value['module'];?>
" class="input-text" style="width:120px">
			<input name="controller" type="text" placeholder="controller" value="<?php echo $_smarty_tpl->tpl_vars['whereData']->value['controller'];?>
" class="input-text" style="width:120px">
			<input name="action" type="text" placeholder="action" value="<?php echo $_smarty_tpl->tpl_vars['whereData']->value['action'];?>
" class="input-text" style="width:120px">
			<button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont"></i> 搜索</button>
		</form>
	</div>

	<div class="mt-20">
		<table class="table table-border table-bordered table-hover table-bg table-sort">
			<thead>
				<tr class="text-c">
					<th width="25">ID</th>
					<th width="">用户名</th>
					<th width="">module</th>
					<th width="">controller</th>
					<th width="">action</th>
					<th width="">时间</th>
					<th width="">IP</th>
				</tr>
			</thead>
			<tbody>
				<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['logs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
				<tr class="text-c" id="this_tr">
					<td><?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['val']->value['uname'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['val']->value['module'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['val']->value['controller'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['val']->value['action'];?>
</td>
					<td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['addtime']);?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['val']->value['ip'];?>
</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php echo $_smarty_tpl->tpl_vars['page_html']->value;?>

	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("../common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
