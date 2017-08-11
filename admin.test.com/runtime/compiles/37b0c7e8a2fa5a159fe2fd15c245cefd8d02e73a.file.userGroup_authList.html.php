<?php /* Smarty version Smarty-3.1.18, created on 2017-08-12 00:57:19
         compiled from "E:\www\github\admin.v218.com\static\tpl\sys\userGroup_authList.html" */ ?>
<?php /*%%SmartyHeaderCode:5338598de1ef8e8763-69220310%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '37b0c7e8a2fa5a159fe2fd15c245cefd8d02e73a' => 
    array (
      0 => 'E:\\www\\github\\admin.v218.com\\static\\tpl\\sys\\userGroup_authList.html',
      1 => 1496823866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5338598de1ef8e8763-69220310',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'id' => 0,
    'authMenu' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_598de1ef96d480_78073621',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_598de1ef96d480_78073621')) {function content_598de1ef96d480_78073621($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<article class="page-container">
	<form action="?m=sys&c=UserGroup&a=groupAuth" method="post" class="form form-horizontal" id="ajaxForm">
		<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
">
		<dl class="permission-list">
			<?php echo $_smarty_tpl->tpl_vars['authMenu']->value;?>

		</dl>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<button class="btn btn-primary radius" type="submit">提交</button>
				<button class="btn btn-primary radius" type="button" id="cancel_open">取消</button>
			</div>
		</div>
	</form>
</article>
<script type="text/javascript">
	$(function(){
		$(".permission-list dt input:checkbox").click(function(){
			$(this).closest("dl").find("dd input:checkbox").prop("checked",$(this).prop("checked"));
		});
		$(".permission-list2 dt input:checkbox").click(function(){
			if($(this).prop("checked")){
				$(this).parents(".permission-list").find('dt').first().find("input:checkbox").prop("checked",true);
			}
		});
		$(".permission-list2 dd input:checkbox").click(function(){
			var l =$(this).parent().parent().find("input:checked").length;
			var l2=$(this).parents(".permission-list").find(".permission-list2 dd").find("input:checked").length;
			if($(this).prop("checked")){
				$(this).closest("dl").find("dt input:checkbox").prop("checked",true);
				$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",true);
			}
			else{
				if(l==0){
					$(this).closest("dl").find("dt input:checkbox").prop("checked",false);
				}
				if(l2==0){
					$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",false);
				}
			}
		});
	});
</script>
<?php echo $_smarty_tpl->getSubTemplate ("../common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
