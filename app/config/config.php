<?php
if (!defined('Perfect')) exit('Blocking access to this script');

$CONFIG['database'] = array(
	'host'=>'122.225.96.74',
	'port'=>'3306',
	'username'=>'ffwapkkobA',
	'password'=>'ffwapokokookb....',
	'charset'=>'utf8',
	'db'=>'test',
	'prefix'=>'pf_',
);

$CONFIG['handledRedis'] = array(
        'host'=>'122.225.96.81',
        'port'=>6379,
        'passwd' =>'FFWAP_ANALYSIS_SERVER_SET_BY_YITE',
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

$CONFIG['systemGroup'] = array(
	'1' => '技术部',
	'2' => '人事部',
	'3' => '财务部',
	'4' => '市场部',
	'5' => '媒介部',
	
	
);

$CONFIG['systemUserRole'] = array(
	'0' => '[总经理]',
	'1' => '[经理]',
	'2' => '[主管]',
	'3' => '[职员]',
	'1000'=>'[系统管理员]'
);

$CONFIG['systemAccountStatus'] = array(
	'0' => '正常',
	'1' => '锁定'
);

$CONFIG['advertStatus'] = array(
	'1' => '待审',
	'2' => '正常',
	'3' => '暂停',
	'4' => '拒绝',
);

$CONFIG['countPoint'] = array(
	'1' => '横幅',
	'2' => '内嵌',
	'3' => '跳转',
	'4' => '插屏',
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

$CONFIG['systemInfo'] = array(
	'system_name'=>'ZCG',
	'author'=>'Alex.Qiu',
	'email'=>'alex.qiubo@qq.com',
);
