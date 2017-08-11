<?php
/**
 * User: fangjinwei
 * Date: 2017/06/03 16:56
 * Desc: 菜单模型
 */
namespace application\module;
use db\Module;
use application\ext\Common;

class MenuModule extends Module {
	protected $table = 'sys_menu';

	public function __construct()
	{
		parent::__construct();
	}

	//获取菜单数据
	public function getMenuList($where=1){
		$sql = "select * from sys_menu where {$where} order by `sort` desc,`id` asc";
		$res = $this->fetchAll($sql);
		$sysMenu = [];
		if( !empty($res) ){
			foreach ($res as $val){
				$sysMenu[$val['id']] = $val;
			}
		}
		return $sysMenu;
	}
	
	//获取单条菜单
	public function getMenuById($id){
		$sql = "select * from sys_menu where id='{$id}'";
		return $this->fetch($sql);
	}
	
	//添加菜单
	public function addMenu($data){
		return $this->table('sys_menu')->insert($data);
	}
	
	//修改菜单
	public function editMenu($data,$id){
		$where['id'] = $id;
		
		return $this->table('sys_menu')->where($where)->update($data);
	}
	
	//删除菜单
	public function delMenu($data){
		$where['id'] = $data;
		
		return $this->table('sys_menu')->where($where)->delete();
	}

	//根据操作名获取菜单id
	public function getMenuIdByAction($module,$controller,$action){
		$where = "module=? and controller=? and action=?";
		$data = [$module,$controller,$action];

		$res = $this->table('sys_menu')->field('id')->where($where)->fetch($data);
		if( !empty($res) ){
			return $res['id'];
		}
		return false;
	}

	/**
	 * 获取权限菜单列表
	 * @param array $authArr 用户拥有的权限
	 * @return string
	 */
	public function getAuthMenu($authArr=[]){
		$menuList = $this->getMenuList();
		$menuList = Common::list_to_tree($menuList);

		return $this->_getAuthMenu($menuList,$authArr);
	}

	private function _getAuthMenu($menuList,$authArr,$menuListHtml='',$child=0){
		foreach ( $menuList as $key=>$val ){
			if( in_array($val['id'],$authArr) ){
				$checked = 'checked';
			}else{
				$checked = '';
			}

			if( $val['pid']==0 ){//根目录
				$menuListHtml .= "<dt><label><input type=\"checkbox\" value=\"{$val['id']}\" name=\"menuid[]\" {$checked}>{$val['name']}</label></dt><dd>";
				if( !empty($val['_child']) ){//二级
					$menuListHtml = $this->_getAuthMenu($val['_child'],$authArr,$menuListHtml,1);
				}
				$menuListHtml .= "</dd>";
			}else{
				if( $child==1 ){//二级
					$menuListHtml .= "<dl class=\"cl permission-list2\"><dt><label class=\"\"><input type=\"checkbox\" value=\"{$val['id']}\" name=\"menuid[]\" {$checked}>{$val['name']}</label></dt><dd>";
					if( !empty($val['_child']) ){//其他级
						$menuListHtml = $this->_getAuthMenu($val['_child'],$authArr,$menuListHtml);
						$menuListHtml .= "</dd></dl>";
					}else{
						$menuListHtml .= "</dd></dl>";
					}
				}else{
					//其他级
					$menuListHtml .= "<label class=\"\"><input type=\"checkbox\" value=\"{$val['id']}\" name=\"menuid[]\" {$checked}>{$val['name']}</label>";
				}
			}
		}
		return $menuListHtml;
	}
}