<?php
/**
 * User: fangjinwei
 * Date: 2017/06/04 0:02
 * Desc: 用户组操作
 */
use application\ext\Response;
use application\module\UserGroupModule;
use application\module\MenuModule;

class UserGroupController extends Controller {

    public function __construct(){
        parent::__construct();
        $this->module = new UserGroupModule();
    }

    //用户组管理
    public function index(){
        $userGroups = $this->module->getUserGroups();
        $this->assign('userGroups',$userGroups);
    }

    //添加用户组
    public function groupAdd(){
        if($this->post){
            $data['gname'] = $this->post['gname'];
            $data['remark'] = $this->post['remark'];
            $data['status'] = $this->post['status'];
            $data['addtime'] = date('Y-m-d H:i:s');

            if($this->module->addGroup($data)){
                Response::response( Response::SUCCESS );
            }
            Response::response( Response::FAIL );
        }
    }

    //编辑用户组
    public function groupEdit(){
        if($this->post){
            $data['gname'] = $this->post['gname'];
            $data['status'] = $this->post['status'];
            $data['remark'] = $this->post['remark'];
            $data['addtime'] = date('Y-m-d H:i:s');

            if($this->module->editGroup($data,$this->post['id'])){
                Response::response( Response::SUCCESS );
            }
            Response::response( Response::FAIL );
        }
        if($this->get['id']) {
            if ($userGroup = $this->module->getGroupById($this->get['id'])) {
                $this->assign('userGroup', $userGroup);
            } else {
                Response::response( 10300 );
            }
        }
    }

    //删除用户组
    public function groupDel(){
        if($this->post['id']){
            foreach ($this->post['id'] as $val){
                if($val == 1){
                    Response::response( 10301 );
                }
            }
            if($this->module->delGroup($this->post['id'])){
                Response::response( Response::SUCCESS );
            }
        }
        if($this->get['id']){
            if($this->get['id'] == 1){
                Response::response( 10301 );
            }
            if($this->module->delGroup($this->get['id'])){
                Response::response( Response::SUCCESS );
            }
        }
        Response::response( Response::ERROR );
    }

    /**
     * 用户组权限列表
     */
    public function authList(){
        if( empty($this->get['id']) ){
            Response::response( Response::ERROR );
        }
        $MenuModule = new MenuModule();
        $groupArr = $this->module->getGroupAuth($this->get['id']);
        $authMenu = $MenuModule->getAuthMenu($groupArr);

        $this->assign('id',$this->get['id']);
        $this->assign('authMenu',$authMenu);
    }

    /**
     * 用户组授权
     */
    public function groupAuth(){
        if( empty($this->post['menuid']) || empty($this->post['id']) ){
            Response::response( Response::ERROR );
        }

        $data['gauth'] = $this->post['menuid'];
        if( !$this->module->updateGroupAuth($data,$this->post['id']) ){
            Response::response( Response::FAIL );
        }

        Response::response( Response::SUCCESS );
    }
}