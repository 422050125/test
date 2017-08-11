<?php
/**
 * User: fangjinwei
 * Date: 2017/06/03 16:56
 * Desc: 用户模型
 */
namespace application\module;
use db\module;

class UserModule extends Module {
	protected $table = 'sys_user';

	public function __construct()
	{
		parent::__construct();
	}

	//获取用户及用户组的数据
	public function getUser(){
		return $this->table('sys_user as a,sys_user_group as b')->field('a.*,b.gname')->where('a.groupid=b.id')->fetchAll();
	}
	
	//获取单条用户
	public function getUserById($id){
		$sql = "select * from sys_user where id='{$id}'";
		return $this->fetch($sql);
	}
	
	//添加用户
	public function addUser($data){
		return $this->table('sys_user')->insert($data);
	}
	
	//修改用户
	public function editUser($data,$id){
		$where['id'] = $id;
		return $this->table('sys_user')->where($where)->update($data);
	}
	
	//删除用户
	public function delUser($data){
		$where['id'] = $data;
		return $this->table('sys_user')->where($where)->delete();
	}

	//获取用户权限
	public function getUserGrants($id){
		$sql = "select auth from sys_user where id='{$id}'";
		$res = $this->fetch($sql);
		$authArr = !empty($res) ? explode(',',$res['auth']) : [];
		return $authArr;
	}

	//更新用户权限
	public function updateUserAuth($data,$id){
		$where['id'] = $id;
		return $this->table('sys_user')->where($where)->update($data);
	}
	
	//验证用户登录
	public function checkUser($uname,$password){
		$sql = "select * from sys_user where `uname`='{$uname}' and `password`='{$password}'";
		return $this->fetch($sql);
	}
}
