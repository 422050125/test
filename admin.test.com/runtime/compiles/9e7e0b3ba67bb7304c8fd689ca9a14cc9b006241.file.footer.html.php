<?php /* Smarty version Smarty-3.1.18, created on 2017-08-12 00:54:34
         compiled from "E:\www\github\admin.v218.com\static\tpl\Common\footer.html" */ ?>
<?php /*%%SmartyHeaderCode:27895598de14a2d88f5-26296510%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9e7e0b3ba67bb7304c8fd689ca9a14cc9b006241' => 
    array (
      0 => 'E:\\www\\github\\admin.v218.com\\static\\tpl\\Common\\footer.html',
      1 => 1497088944,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '27895598de14a2d88f5-26296510',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_598de14a359797_37441211',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_598de14a359797_37441211')) {function content_598de14a359797_37441211($_smarty_tpl) {?><script type="text/javascript">
//弹出iframe层
function open(obj,url,title,w,h){
	var openParam = {type: 2, title: title, content: url, area: ['100%','100%']};
	if( w>0 && h>0 ){
		openParam['area'] = [w+'px', h +'px'];
	}
	layer.open(openParam);
}

//关闭ifram层
$("#cancel_open").click(function(){
	close_iframe();
});

function close_iframe(){
	var  frameindex= parent.layer.getFrameIndex(window.name);
	parent.layer.close(frameindex);
}

//删除
function del(obj,url){
	//var url = $(obj).parents("tr").attr("url-del");
	layer.confirm('确认要删除吗？',function(index){
		ajaxRequest('get',url,'',function(res){
			if( res.status==1 ){
				layer.msg(res.msg,{icon:1,time:1000},function(){
					$(obj).parents("tr").remove();
				});
			}else {
				layer.msg(res.msg,{icon:2,time:1000});
			}
		});
	});
}

//批量删除
function datadel(){

}

//form提交
$("#ajaxForm").submit(function (){
	formSubmit($(this));
	return false;
})

//ajax提交
function formSubmit(formObj){
	var data = formObj.serialize();
	url = formObj.attr("action");
	if( url=="" ){
		url = window.location.href;
	}
	ajaxRequest("post",url,data);
}

//ajax请求
function ajaxRequest(type,url,data,func){
	$.ajax({ type: type, url: url, data: data, dataType: "json",
		success: function (res) {
			if( func ){//回调
				func(res);
			}else{
				if (res.status == 1) {
					layer.msg(res.msg, {icon: 6,time:1000}, function(){
						window.parent.location.reload();
					});
				} else {
					layer.msg(res.msg, {icon: 5,time:1000});
				}
			}
		},
		error: function () {
			layer.msg("请求失败",{time:1000});
		}
	});
}

</script>
</body>
</html><?php }} ?>
