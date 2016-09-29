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
	'enable_module'=>true,
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
$CONFIG['province'] = array(
	'1'  => '北京',
	'2'  => '天津',
	'3'  => '上海',
	'4'  => '重庆',
	'5'  => '河北',
	'6'  => '山西',
	'7'  => '内蒙古',
	'8'  => '辽宁',
	'9'  => '吉林',
	'10' => '黑龙江',
	'11' => '江苏',
	'12' => '浙江',
	'13' => '安徽',
	'14' => '福建',
	'15' => '江西',
	'16' => '山东',
	'17' => '河南',
	'18' => '湖北',
	'19' => '湖南',
	'20' => '广东',
	'21' => '广西',
	'22' => '海南',
	'23' => '四川',
	'24' => '贵州',
	'25' => '云南',
	'26' => '西藏',
	'27' => '陕西',
	'28' => '甘肃',
	'29' => '青海',
	'30' => '宁夏',
	'31' => '新疆',
	'32' => '香港',
	'33' => '澳门',
	'34' => '台湾',
	'35' => '中国',
	'36' => '美国',
);
