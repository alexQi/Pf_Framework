<?php
if (!defined('Perfect')) exit('Blocking access to this script');

$CONFIG['database'] = array(
	'host'=>'localhost',//主机
	'port'=>'3306',//端口
	'username'=>'root',//用户
	'password'=>'woshishei',//密码
	'charset'=>'utf8',//连接字符集
	'db'=>'ffwap',//数据库
);

$CONFIG['router'] = array(
	'default_module'=>'back',
	'default_controller'=>'Index',
	'default_action'=>'Index',
);

$CONFIG['autoLoadDirs'] = array(
	// 'alias'=>PATH,
);

$CONFIG['viewConfig'] = array(
	'viewExt'=>'php',
	'viewPath'=>VIEW_PATH,
	'layout'=>'main',
);

$CONFIG['systemConfig'] = array(
	'email'=>'alex.qiubo@qq.com',
);
