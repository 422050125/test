<?php /* Smarty version Smarty-3.1.18, created on 2017-08-12 00:55:22
         compiled from "E:\www\github\admin.v218.com\static\tpl\sys\user_index.html" */ ?>
<?php /*%%SmartyHeaderCode:28074598de17ada1719-45153659%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bec99d36195779d0ad80429b0e5bce69cfa16f19' => 
    array (
      0 => 'E:\\www\\github\\admin.v218.com\\static\\tpl\\sys\\user_index.html',
      1 => 1497089104,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '28074598de17ada1719-45153659',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user' => 0,
    'val' => 0,
    'groups' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_598de17ae3db35_19049655',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_598de17ae3db35_19049655')) {function content_598de17ae3db35_19049655($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
	<span class="c-gray en">&gt;</span>系统管理<span class="c-gray en">&gt;</span>用户管理
	<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">
	<div class="text-c">
		<div class="cl pd-5 bg-1 bk-gray mt-20">
			<span class="l">
				<a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
				<a class="btn btn-primary radius" onclick="open(this,'?m=sys&c=User&a=userAdd','添加用户',600,380)" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加用户</a>
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
					<th width="">用户名</th>
					<th width="">用户组</th>
					<th width="">添加时间</th>
					<th width="">状态</th>
					<th width="">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['user']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
				<tr class="text-c" id="this_tr">
					<td><input type="checkbox" name="" value=""></td>
					<td><?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
</td>
					<td class="text-l"><?php echo $_smarty_tpl->tpl_vars['val']->value['uname'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['groups']->value[$_smarty_tpl->tpl_vars['val']->value['groupid']]['gname'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['val']->value['addtime'];?>
</td>
					<td><?php if ($_smarty_tpl->tpl_vars['val']->value['status']==1) {?>己启用<?php } else { ?>己停用<?php }?></td>
					<td class="f-14">
						<a title="授权" href="javascript:;" onclick="open(this,'?m=sys&c=User&a=authList&id=<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
','用户授权')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6a7;</i></a>
						<a title="编辑" href="javascript:;" onclick="open(this,'?m=sys&c=User&a=userEdit&id=<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
','编辑用户')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
						<a title="删除用户" href="javascript:;" onclick="del(this,'?m=sys&c=User&a=userDel&id=<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
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
