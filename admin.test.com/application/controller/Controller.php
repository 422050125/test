<?php
/*---------------
 * 控制器基类
 *---------------*/
use application\ext\Common;
use application\module\MenuModule;
use application\module\LogModule;
use application\ext\Response;

class Controller extends Smarty{
	protected	$module		=	null;	//模型实例
	protected	$noCheck	=	[];		//无需权限验证的操作
	public		$post		=	null;	//post数据过滤
	public		$get 		=	null;	//get数据过滤
	public 		$page_no	=	1;		//分页页码
	public 		$page_size	=	20;		//每页显示多少条

	public function __construct(){
		parent::__construct();
		
		//配置smarty参数
		$this->template_dir		=	TEMPLATES_DIR;		//模板目录
		$this->compile_dir  	=	COMPILES_DIR;		//编译目录
		$this->cache_dir		=	CACHE_TEMP_DIR;		//设置缓存的目录
		$this->caching      	=	0;					//设置缓存开启
		$this->cache_lifetime  	=	3600;  				//设置缓存的时间
		$this->left_delimiter  	=	"<{";   			//模板文件中使用的“左”分隔符号
		$this->right_delimiter 	=	"}>";   			//模板文件中使用的“右”分隔符号

		//无需权限验证的操作
		$this->noCheck = [
			'sys' => [
				'User'	=>	['login' => true, 'logout' => true],
				'Sys'	=>	['vcode' => true],
			],
			'test' => [
				'Test'	=>	['index' => true,],
			],
		];
		
		//过滤post,get数据
		$this->checkData();

		//分页页码
		$this->page_no = $this->get['page_no'] ? $this->get['page_no'] : 1;

		//session消失跳转到登陆页
		if( !$this->checkLogin() ){
			if( !$this->noCheck[$this->get['m']][$this->get['c']][$this->get['a']] ){
				Common::toUrl('login');
			}
		}

		//菜单模型实例
		$this->module = new MenuModule();

		//权限验证
		if( !$this->checkGrant() ){
			//$this->response( ResPonseExt::getMsg( 10004 ) );
			Common::alert( Response::response( 10004 ) );
		}

		//记录操作
		if( $this->noCheck[$this->get['m']][$this->get['c']][$this->get['a']] != true ){
			$this->addActLog();
		}
	}

	/**
	 * 权限验证
	 * @return bool|mixed
	 */
	public function checkGrant(){
		//无需权限验证的操作
		if( $this->noCheck[$this->get['m']][$this->get['c']][$this->get['a']]===true ){
			return true;
		}

		$grantsArr = json_decode( $this->getSession('ugrant'),true );//用户拥有的权限

		//系统首页,返回用户的左侧菜单权限
		if( (!$this->get['m'] && !$this->get['c'] && !$this->get['a']) || ($this->get['m']=='sys' && $this->get['c']=='Sys' && $this->get['a']=='index') ){
			return $grantsArr;
		}

		//根用户,无需验证
		if( $this->getSession('uid') == 1 ){
			return true;
		}

		//验证操作权限
		if( $this->get['m'] && $this->get['c'] && $this->get['a'] ){
			$menuId = $this->module->getMenuIdByAction($this->get['m'],$this->get['c'],$this->get['a']);
			if( in_array($menuId,$grantsArr) ){
				return true;
			}
		}

		return false;
	}

	/**
	 * 添加操作日志
	 */
	public function addActLog(){
		$data['module'] = !empty($this->get['m']) ? $this->get['m'] : 'sys';
		$data['controller'] = !empty($this->get['c']) ?  $this->get['c'] : 'Sys';
		$data['action'] = !empty($this->get['a']) ? $this->get['a'] : 'index';
		$data['uid'] = $this->getSession('uid');
		$data['uname'] = $this->getSession('uname');
		$data['addtime'] = time();
		$data['ip'] = Common::getUserIP();
		( new LogModule() )->addLog($data);
	}

	/**
	 * 验证登录
	 * @return bool
	 */
	public function checkLogin(){
		if( $this->getSession('uid')>0 && $this->getSession('uname') ){
			return true;
		}
		return false;
	}

	/**
	 * 设置cookie
	 */
	public function setCookie($name,$value,$expire,$path,$domain,$secure){
		return setcookie( $name,$value,$expire,$path,$domain,$secure );
	}

	/**
	 * 获取cookie
	 */
	public function getCookie($key=null){
		if( $key !== null ){
			return !empty($_COOKIE[$key]) ? $_COOKIE[$key] : false;
		}
		return $_COOKIE;
	}

	//设置session信息
	public function setSession($data=null){
		if( empty($data) || !is_array($data) ){
			return false;
		}
		foreach( $data as $key=>$val ){
			$_SESSION[$key] = $val;
		}
		return true;
	}

	//获取session信息
	public function getSession($key=null){
		if( $key !== null ){
			return !empty( $_SESSION[$key] ) ? $_SESSION[$key] : false;
		}
		return $_SESSION;
	}

	//销毁session
	public function desSession($key=null){
		if( $key !== null ){
			unset( $_SESSION[$key] );
		}else{
			session_destroy();
			unset($_SESSION);
		}
	}
	
	private function getPidAct($id,$menuArr,$conArr=null){
		if($menuArr[$id]['pid'] != 0){
			$conArr[] = $menuArr[$id]['name'];
			$conArr = $this->getPidAct($menuArr[$id]['pid'],$menuArr,$conArr);
		}else{
			$conArr[] = $menuArr[$id]['name'];
		}
		return $conArr;
	}
	
	//数据过虑
	private function checkData($data=null){
		if($data){
			return $this->filterData($data);
		}
		if($_POST){
			$this->post = $this->filterData($_POST);
		}
		if($_GET){
			$this->get = $this->filterData($_GET);
		}
		return true;
	}

	private function filterData($data){
		if(is_array($data)){
			foreach ($data as $key => $val){
				$data[$key] = $this->filterData($val);
			}
		}else{
			$data = $this->safeData($data);
		}
		return $data;
	}

	private function safeData($str){
		$str = trim($str);
		$str = htmlspecialchars($str,ENT_QUOTES);
		$str = addslashes($str);
		return $str;
	}
}
