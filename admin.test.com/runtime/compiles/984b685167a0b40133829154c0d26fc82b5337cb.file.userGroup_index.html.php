<?php /* Smarty version Smarty-3.1.18, created on 2017-08-12 00:55:26
         compiled from "E:\www\github\admin.v218.com\static\tpl\sys\userGroup_index.html" */ ?>
<?php /*%%SmartyHeaderCode:23794598de17e8b8740-69581450%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '984b685167a0b40133829154c0d26fc82b5337cb' => 
    array (
      0 => 'E:\\www\\github\\admin.v218.com\\static\\tpl\\sys\\userGroup_index.html',
      1 => 1496589652,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '23794598de17e8b8740-69581450',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'userGroups' => 0,
    'val' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_598de17e90a7d9_23430246',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_598de17e90a7d9_23430246')) {function content_598de17e90a7d9_23430246($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
	<span class="c-gray en">&gt;</span>系统管理<span class="c-gray en">&gt;</span>用户组管理
	<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">
	<div class="text-c">
		<div class="cl pd-5 bg-1 bk-gray mt-20">
			<span class="l">
				<a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
				<a class="btn btn-primary radius" onclick="open(this,'?m=sys&c=UserGroup&a=groupAdd','添加用户组',600,380)" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加用户组</a>
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
					<th width="">组名称</th>
					<th width="">状态</th>
					<th width="">添加时间</th>
					<th width="">备注</th>
					<th width="">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['userGroups']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
				<tr class="text-c" id="this_tr">
					<td><input type="checkbox" name="" value=""></td>
					<td><?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
</td>
					<td class="text-l"><?php echo $_smarty_tpl->tpl_vars['val']->value['gname'];?>
</td>
					<td><?php if ($_smarty_tpl->tpl_vars['val']->value['status']==1) {?>己启用<?php } else { ?>己停用<?php }?></td>
					<td><?php echo $_smarty_tpl->tpl_vars['val']->value['addtime'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['val']->value['remark'];?>
</td>
					<td class="f-14">
						<a title="授权" href="javascript:;" onclick="open(this,'?m=sys&c=UserGroup&a=authList&id=<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
','用户组授权',700,480)" style="text-decoration:none"><i class="Hui-iconfont">&#xe6a7;</i></a>
						<a title="编辑" href="javascript:;" onclick="open(this,'?m=sys&c=UserGroup&a=groupEdit&id=<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
','编辑用户组',600,380)" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
						<a title="删除用户组" href="javascript:;" onclick="del(this,'?m=sys&c=UserGroup&a=groupDel&id=<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("../common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
