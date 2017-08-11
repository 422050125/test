<?php
/**
 * 系统入口
 * 	1 ) 读取配置
 * 	2 ) 调用App
 */
define('APP_ROOT',dirname(__FILE__).'/');//定义项目路径
define('APP_CORE_ROOT',dirname(APP_ROOT).'/core/');//定义core目录路径

require APP_CORE_ROOT.'App.php';//加载core目录启动文件
require APP_ROOT.'application/config/config.php';//加载项目配置文件

APP::run();//运行