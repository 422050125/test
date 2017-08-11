<?php
/**
 * User: fangjinwei
 * Date: 2017/06/03 16:58
 * Desc: 用户组模型
 */
namespace application\module;
use db\module;

class UserGroupModule extends Module {
    protected $table = 'user_group';

    public function __construct()
    {
        parent::__construct();
    }

    //用户组列表
    public function getUserGroups(){
        $sql = "select * from sys_user_group where 1";
        $res = $this->fetchAll($sql);
        $groups = [];
        if( !empty($res) ){
            foreach ( $res as $val ){
                $groups[$val['id']] = $val;
            }
        }
        return $groups;
    }

    //查询单个用户组
    public function getGroupById($id){
        $sql = "select * from sys_user_group where id='{$id}'";

        return $this->fetch($sql);
    }

    //添加用户组
    public function addGroup($data){
        return $this->table('sys_user_group')->insert($data);
    }

    //修改用户组
    public function editGroup($data, $id){
        $where['id'] = $id;
        return $this->table('sys_user_group')->where($where)->update($data);
    }

    //删除用户组
    public function delGroup($data){
        $where['id'] = $data;

        return $this->table('sys_user_group')->where($where)->delete();
    }

    //获取用户组权限
    public function getGroupAuth($id){
        $sql = "select gauth from sys_user_group where id='{$id}'";
        $res = $this->fetch($sql);
        $authArr = !empty($res) ? explode(',',$res['gauth']) : [];
        return $authArr;
    }

    //更新用户组权限
    public function updateGroupAuth($data,$id){
        $where['id'] = $id;
        return $this->table('sys_user_group')->where($where)->update($data);
    }

    //用户组菜单列表
    public function getMenu(){
        $sql = "select * from sys_menu where 1 order by sort,id asc";

        return $this->fetchAll($sql);
    }
}