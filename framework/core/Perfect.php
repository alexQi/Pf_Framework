<?php
if (!defined('Perfect')) exit('Blocking access to this script');
include('Main.config.php');
/**
 * core class
 * author : alex
 * date : 2016-08-25
 */

class Perfect {

	public $module;
	public $controller;
	public $action;
	public $config;
	public $db;
	public $classFileDirs;
	public $PerfectException;

	public function __construct(){
		//载入文件
		include(CORE_PATH.'Router.php');
		include(CORE_PATH.'Pf_Exception.php');
		include(DRIVER_PATH.'Mysql.php');
		include(CONFIG_PATH.'config.php');

		$this->config = $CONFIG;
		if(!empty($this->config['database'])) {
			$this->db = Mysql::getInstance($this->config['database']);
		}
		$Router = new Router($this->config['router']);
		$this->module    =   $Router->uri_param['module'];
		$this->controller =   $Router->uri_param['controller'];
		$this->action      =   $Router->uri_param['action'];

		$this->baseSrc = 'http://'.$_SERVER['HTTP_HOST'].substr($_SERVER['PHP_SELF'],0,strrpos($_SERVER['PHP_SELF'],'/')+1);
		$this->baseUrl  = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

		$this->Pf_Exception = new Pf_Exception;
		$this->Pf_Exception->layout   = $this->config['viewConfig']['layout'];
		$this->Pf_Exception->viewDir = $this->config['viewConfig']['viewPath'];
		$this->Pf_Exception->viewExt = $this->config['viewConfig']['viewExt'];
		$this->Pf_Exception->email    = $this->config['systemConfig']['email'];

		$this->Pf_Exception->baseSrc = $this->baseSrc;
		$this->Pf_Exception->baseUrl  = $this->baseUrl;

		$tempClassFileDirs = self::getClassFileDirs();
		$this->classFileDirs = array_merge($tempClassFileDirs,$this->config['autoLoadDirs']);

		spl_autoload_register("self::loadClass");

		/******** 使用自定义错误 ********/
		if (ENVIRONMENT=='debug') {
        			set_error_handler(array(&$this, 'error_handler'));
        			register_shutdown_function(array(&$this, 'handleFatalError'));
		}
	}

	private static function getClassFileDirs(){
		return array(
			'core'=>CORE_PATH,
			'lib'=>LIB_PATH,
		);
	}

	private function loadClass($className) {
		try {
			$systemClassFile = false;
			foreach ($this->classFileDirs as $key => $dir) {
				$classFile = $dir.$className.'.php';
				if (file_exists($classFile)) {
					$systemClassFile = true;
					break;
				}
			}
			if ($systemClassFile===false) {
				if ('Model' == substr($className, -5)) {
					$classFile = MODEL_PATH . $className . '.php';
				}elseif ('Controller' == substr($className, -10)) {
					$classFile = CONTROLLER_PATH.$this->module.DS.$className . '.php';
				}else{
					throw new Pf_Exception("unknown class : <font color='#FE8D41'>$className</font>");
				}
			}
			if (!file_exists($classFile)) {
				throw new Pf_Exception("Not found this class file : <font color='#FE8D41'>$classFile</font>");
			}
			include $classFile;
			return true;
		} catch (Pf_Exception $e) {
			$this->Pf_Exception->init($e);
		}
	}

	public function error_handler($error_level,$error_message,$file,$line){
		switch($error_level){
			case E_NOTICE:
			case E_USER_NOTICE:
				$error_type = 'Notice';
				break;
			case E_WARNING:
			case E_USER_WARNING:
				$error_type='Warning';
				break;
			case E_ERROR:
			case E_USER_ERROR:
				$error_type='Fatal Error';
				break;
			default:
				$error_type='Unknown';
				break;
		}
		$line = $line-1;
		$errorMessage = "<p><strong>$error_type : </strong><font color='#F44336'>$error_message</font></p>";
		$errorMessage .= "<strong>File : <strong>$file  <font color='#00BCD4'>[{$line}]</font>";
		$content = file_get_contents($file);
		$con_array = explode("\n", $content);
		$errorMessage .= "<br /><pre>";
		for ($i=$line-5; $i <= $line+5; $i++) {
			$errorMessage .= "\n<font color='#00BCD4'>$i</font>";
			if ($i==$line) {
				$errorMessage .= "<font color='#F44336'>".$con_array[$i]."</font>";
			}else{
				$errorMessage .= $con_array[$i];
			}
		}
		$errorMessage .= "</pre>";
		$this->Pf_Exception->init($errorMessage);
	}

	public function handleFatalError()
	{
		unset($this->_memoryReserve);
		$error = error_get_last();
		if (!empty($error)) {
			$error_message = $error['message'];
			$file = $error['file'];
			$line = $error['line']-1;
			$error_type='Fatal Error';
			$errorMessage = "<p><strong>$error_type : </strong><font color='#F44336'>$error_message</font></p>";
			$errorMessage .= "<strong>File : <strong>$file  <font color='#00BCD4'>[{$line}]</font>";
			$content = file_get_contents($file);
			$con_array = explode("\n", $content);
			$errorMessage .= "<br /><pre>";
			for ($i=$line-5; $i <= $line+5; $i++) {
				$errorMessage .= "\n<font color='#00BCD4'>$i</font>";
				if ($i==$line) {
					$errorMessage .= "<font color='#F44336'>".$con_array[$i]."</font>";
				}else{
					$errorMessage .= $con_array[$i];
				}
			}
			$errorMessage .= "</pre>";
			$this->Pf_Exception->init($errorMessage);
		}
	}

	public function run(){
		try{
			$moduleName = CONTROLLER_PATH.$this->module.DS;
			$controllerName = $this->controller.'Controller';
			$actionName = $this->action.'Action';

			if (!is_dir($moduleName)) {
				throw new Pf_Exception("Not found module , module name : <font color='#FE8D41'>$this->module</font>");
			}
			if (!$this->controller || !class_exists($controllerName)) {
				throw new Pf_Exception("Not found controller , controller name : <font color='#FE8D41'>$controllerName</font>");
			}
			$Controller = new $controllerName;
			if (!method_exists($Controller, $actionName)){
				throw new Pf_Exception("Not found this action in $controllerName , action name : <font color='#FE8D41'>$actionName</font>");
			}
			$Controller->$actionName();
		}
		catch(Pf_Exception $e)
		{
			$this->Pf_Exception->init($e);
		}
	}
	
}
