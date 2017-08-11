<?php
$appConfig = [
	'template' => 1,//是否需要模板文件
	'errorReportLevel' => E_ALL & ~E_NOTICE,
	'cookie_domain' => '.test.com',
	'app_charset' => 'utf-8',
	'date_default_timezone_set' => 'PRC',
	'run' => [//默认调用的控制器
		'm'=>'sys',
		'c'=>'Sys',
		'a'=>'index',
	],
];
