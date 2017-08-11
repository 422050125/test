<?php
namespace application\module;
use db\Module;

class SysModule extends Module{

	public function __construct(){
		parent::__construct('default');
	}

	public static function getInstance()
	{
		if( !(self::$_instance instanceof self)  ){
			self::$_instance =  new self();
		}
		return self::$_instance;
	}

	//获取菜单数据
	public function getSysMenu($where=1){
		$sql = "select * from sys_menu where {$where} order by `sort` desc,`id` asc";
		
		return $this->fetchAll($sql);
	}
	
	//获取单条菜单
	public function getSysMenuById($id){
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
	
	//添加日志
	public function addLog($data){
		return $this->table('sys_log')->insert($data);
	}
	
	//查询日志
	public function getLog($where,$order,$limit){
		$sql = "select * from sys_log where {$where} order by addtime {$order} limit {$limit}";
		
		return $this->fetchAll($sql);
	}
	
	//查询日志总数
	public function getLogCount($where){
		$sql = "select count(*) from sys_log where {$where}";
		
		return $this->fetchTotal($sql);
	}
}