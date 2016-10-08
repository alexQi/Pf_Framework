<?php 
if (!defined('Perfect')) exit('Blocking access to this script');

/**
 * +++++++++++++++++++++
 * 系统菜单
 * +++++++++++++++++++++
 */
$system_menu['MENU'] = array(
	'01'=>'用户中心',
	'100'=>'系统管理',
);


/**
 * ******************************
 * 子菜单
 * ******************************
 */
$system_menu['ITEM'] = array(
	'11'=>array('F'=>'01','T'=>'用户中心','M'=>'main','A'=>'index'),
	'12'=>array('F'=>'01','T'=>'欢迎登录','M'=>'main','A'=>'test'),

	'101'=>array('F'=>'100','T'=>'用户列表','M'=>'system','A'=>'systemMemberManage','DTYPE'=>1010),
	'102'=>array('F'=>'100','T'=>'操作日志','M'=>'system','A'=>'operationLogList'),
);

/**
 * ******************************
 * 操作权限
 * ******************************
 */
$system_menu['DTYPE'] = array(
	'1010'=>array(
		'1'=>array('T'=>'新建用户','D'=>'systemCreateManager'),
		'2'=>array('T'=>'修改用户','D'=>'systemManagerModify'),
		'3'=>array('T'=>'锁定用户','D'=>'systemLockManager'),
		'4'=>array('T'=>'解锁用户','D'=>'systemUnLockManager'),
		'5'=>array('T'=>'会员日志','D'=>'systemSickManageLog'),
	),
);


?>