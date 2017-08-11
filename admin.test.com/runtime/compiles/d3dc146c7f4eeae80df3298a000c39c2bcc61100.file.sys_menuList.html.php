<?php /* Smarty version Smarty-3.1.18, created on 2017-08-12 00:55:25
         compiled from "E:\www\github\admin.v218.com\static\tpl\sys\sys_menuList.html" */ ?>
<?php /*%%SmartyHeaderCode:18539598de17dd05da3-82139162%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd3dc146c7f4eeae80df3298a000c39c2bcc61100' => 
    array (
      0 => 'E:\\www\\github\\admin.v218.com\\static\\tpl\\sys\\sys_menuList.html',
      1 => 1496581816,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18539598de17dd05da3-82139162',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'menuSearchList' => 0,
    'val' => 0,
    'whereData' => 0,
    'menuList' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_598de17ddf80e9_83388754',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_598de17ddf80e9_83388754')) {function content_598de17ddf80e9_83388754($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
	<span class="c-gray en">&gt;</span>系统管理<span class="c-gray en">&gt;</span>菜单管理
	<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">
	<div class="text-c">
		<form class="Huiform" method="post" action="">
            <span class="select-box" style="width:140px;">
                <select name="id" class="select" id="search_brand">
					<option value="0" class="select option" id="search_menu_0">请选择分类</option>
					<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menuSearchList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
					<?php if ($_smarty_tpl->tpl_vars['val']->value['pid']==0) {?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" class="select option" <?php if ($_smarty_tpl->tpl_vars['whereData']->value['id']==$_smarty_tpl->tpl_vars['val']->value['id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</option>
					<?php }?>
					<?php } ?>
				</select>
            </span>
			<input name="module" type="text" placeholder="module" value="<?php echo $_smarty_tpl->tpl_vars['whereData']->value['module'];?>
" class="input-text" style="width:120px">
			<input name="controller" type="text" placeholder="controller" value="<?php echo $_smarty_tpl->tpl_vars['whereData']->value['controller'];?>
" class="input-text" style="width:120px">
			<input name="action" type="text" placeholder="action" value="<?php echo $_smarty_tpl->tpl_vars['whereData']->value['action'];?>
" class="input-text" style="width:120px">
			<button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont"></i> 搜索</button>
		</form>
		<div class="cl pd-5 bg-1 bk-gray mt-20">
			<span class="l">
				<a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
				<a class="btn btn-primary radius" onclick="open(this,'?m=sys&c=Sys&a=menuAdd','添加菜单',700,480)" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加菜单</a>
			</span>
			<span class="r"></span>
		</div>
	</div>

	<div class="mt-20">
		<table class="table table-border table-bordered table-hover table-bg table-sort">
			<thead>
				<tr class="text-c">
					<th width="25"><input type="checkbox" name="" value=""></th>
					<th width="25">ID</th>
					<th width="">排序</th>
					<th width="">菜单名称</th>
					<th width="">module</th>
					<th width="">controller</th>
					<th width="">action</th>
					<th width="">状态</th>
					<th width="">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menuList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
				<tr class="text-c" id="this_tr">
					<td><input type="checkbox" name="" value=""></td>
					<td><?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['val']->value['sort'];?>
</td>
					<td class="text-l" style="padding-left:<?php echo $_smarty_tpl->tpl_vars['val']->value['_space'];?>
;"><?php if ($_smarty_tpl->tpl_vars['val']->value['_space']!="0px") {?>|-<?php }?><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['val']->value['module'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['val']->value['controller'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['val']->value['action'];?>
</td>
					<td><?php if ($_smarty_tpl->tpl_vars['val']->value['status']==1) {?>显示<?php } else { ?>不显示<?php }?></td>
					<td class="f-14"><a title="编辑" href="javascript:;" onclick="open(this,'?m=sys&c=Sys&a=menuEdit&id=<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
','菜单编辑','700','480')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
						<a title="删除" href="javascript:;" onclick="del(this,'?m=sys&c=Sys&a=menuDel&id=<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("../common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
