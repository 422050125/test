<?php
/**
 * user: fangjinwei
 * date: 2017/6/5 20:08
 * desc: 项目路径、数据库配置及启动项目
 */

//定义项目路径
const APP_APPLICATION = APP_ROOT .'application/';
const APP_CONFIG = APP_ROOT .'application/config/';
const APP_CONTROLLER = APP_ROOT .'application/controller/';
const APP_MOUDLE = APP_ROOT .'application/module/';

//定义模板
const APP_TEMPLATES = APP_CORE_ROOT .'lib/smarty/Smarty.class.php';//模板文件
const TEMPLATES_DIR = APP_ROOT .'static/tpl/';
const RUNTIME_DIR = APP_ROOT .'runtime/';
const COMPILES_DIR = APP_ROOT .'runtime/compiles/';
const CACHE_TEMP_DIR = APP_ROOT .'runtime/cache/';
const CACHE_DATA_DIR = APP_ROOT .'runtime/data/';

//controller基类
const BASE_CONTROLLER = APP_ROOT .'application/controller/Controller.php';

//定义composer目录
const COMPOSER_DIR = APP_CORE_ROOT.'lib/vendor/';


/*mysql配置*/
$dbConfig['default'] = [
	'DB_TYPE' => 'mysql',
	'DB_CHARSET' => 'utf8',
	'DB_PERSISTENT' => false,
	'DB_HOST'=>'127.0.0.1',
	'DB_PORT'=>'3306',
	'DB_USER'=>'root',
	'DB_PASSWD'=>'123456',
	'DB_NAME'=>'sys'
];

/*redis配置*/
$redisConfig = [
	'default' => [
		'server'	=>	'10.13.0.12',
		'port'		=>	6379,
	],
	'slave' => [
		'server'	=>	'10.13.0.12',
		'port'		=>	6380,
	],
];


//启动app
class App{
	static $config;

	//初始化项目配置
	static function setConfig(){
		global $appConfig;
		self::$config = $appConfig;
		session_start();
		!empty( self::$config['errorReportLevel'] ) ? error_reporting( self::$config['errorReportLevel'] ) : error_reporting( 0 );
		!empty( self::$config['date_default_timezone_set'] ) ? date_default_timezone_set( self::$config['date_default_timezone_set'] ) : date_default_timezone_set( 'PRC' );
		!empty( self::$config['cookie_domain'] ) ? ini_set( 'session.cookie_domain', self::$config['cookie_domain'] ) : ini_set( 'session.cookie_domain', '/' );
		$charset = !empty( self::$config['app_charset'] ) ? self::$config['app_charset'] : 'utf-8';
		header( 'content-type:text/html;charset='. $charset );
	}

	//项目运行
	static function run(){
		self::setConfig();
		try{
			//创建模板相关目录
			if( isset(self::$config['template']) && self::$config['template']===1 ){
				if( !file_exists(APP_TEMPLATES) ){
					exit('模板文件不存在');
				}
				require_once APP_TEMPLATES;//该目录下的文件不在自动加载的范围内，需手动加载

				if(!file_exists(RUNTIME_DIR)){
					mkdir(RUNTIME_DIR,0777);
				}
				if(!file_exists(COMPILES_DIR)){
					mkdir(COMPILES_DIR,0777);
				}
				if(!file_exists(CACHE_TEMP_DIR)){
					mkdir(CACHE_TEMP_DIR,0777);
				}
				if(!file_exists(CACHE_DATA_DIR)){
					mkdir(CACHE_DATA_DIR,0777);
				}
			}

			//调用控制器类及方法
			$m = $_GET['m'] ? $_GET['m'] : self::$config['run']['m'];
			$c = $_GET['c'] ? ucfirst($_GET['c']) : self::$config['run']['c'];
			$a = $_GET['a'] ? $_GET['a'] : self::$config['run']['a'];
			$controllerName = $c.'Controller';//类名

			//加载controller类
			$controllerFile = APP_CONTROLLER . $m .'/'. $controllerName .'.php';
			if( !file_exists($controllerFile) ){
				exit($controllerFile .'文件不存在');
			}
			if( !file_exists(BASE_CONTROLLER) ){
				exit('controller基类不存在');
			}

			include BASE_CONTROLLER;
			include $controllerFile;

			//自动加载类文件
			spl_autoload_register('APP::__autoload');//注册__autoload方法

			$controller = new $controllerName();

			if( !method_exists($controller,$a) ){
				exit($controllerFile.' 类 '.$a.' 方法不存在');
			}

			//开始运行
			$controller->$a();

			//输出面页
			if( isset(self::$config['template']) && self::$config['template']===1 ){
				$controller->display($m.'/'.lcfirst($c).'_'.$a.'.html');
			}

		}catch( Exception $e ){
			exit ( $e->getMessage() );
			//exit('run运行错误');
		}
	}

	//自动加载
	static function __autoload($className){
		$filename = str_replace('\\','/',$className).'.php';
		if( file_exists(APP_ROOT.$filename) ){
			//项目文件
			require_once ( APP_ROOT.$filename );
		}
		elseif( file_exists(APP_CORE_ROOT.$filename) ){
			//core目录文件
			require_once ( APP_CORE_ROOT.$filename );
		}
		elseif( file_exists(COMPOSER_DIR.$filename) ){
			//composer目录文件
			require_once ( COMPOSER_DIR.$filename );
		}
		else{
			exit( "文件{$filename}加载失败" );
		}
	}
}