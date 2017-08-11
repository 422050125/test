<?php
/**
 * 系统入口
 * 	1 ) 读取配置
 * 	2 ) 调用App
 */
define('APP_ROOT',dirname(__FILE__));
define('APP_CORE_ROOT',dirname(APP_ROOT));

require APP_ROOT.'/application/config/config.php';
require APP_CORE_ROOT.'/core/App.php';

APP::run();