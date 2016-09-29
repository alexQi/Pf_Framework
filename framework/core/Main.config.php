<?php
if (!defined('Perfect')) exit('Blocking access to this script');
//定义路径常量
define('DS', DIRECTORY_SEPARATOR);//定义当前目录分隔符
define('ROOT_PATH', getcwd() . DS);//站点根路径

define('APP_PATH', ROOT_PATH . 'app' . DS);//应用程序路径
define('FRAMEWORK_PATH', ROOT_PATH . 'framework' . DS);//框架路径
define('CORE_PATH', FRAMEWORK_PATH . 'core' . DS);//核心路径
define('DRIVER_PATH', FRAMEWORK_PATH . 'drivers' . DS);//驱动路径
define('LIB_PATH', FRAMEWORK_PATH . 'libraries' . DS);//系统类路径
define('FRAMEWORK_VIEW_PATH', FRAMEWORK_PATH . 'view' . DS);//系统视图路径
define('WEB_PATH', ROOT_PATH . 'web' . DS);//web路径
define('CONTROLLER_PATH', APP_PATH . 'controller' . DS);//控制器路径
define('MODEL_PATH', APP_PATH . 'model' . DS);//模型路径
define('VIEW_PATH', APP_PATH . 'view' . DS);//视图路径
define('LOG_PATH', APP_PATH . 'log' . DS);//日志路径
define('PUBLIC_VIEW_PATH', VIEW_PATH . 'public' . DS);//公共视图路径
define('CONFIG_PATH', APP_PATH . 'config' . DS);//配置路径

?>