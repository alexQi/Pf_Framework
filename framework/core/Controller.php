<?php
if (!defined('Perfect')) exit('Blocking access to this script');
/**
 * 基础控制器类
 */
abstract class Controller {

	protected $Perfect;
	protected $layout;
	protected $viewExt;
	protected $baseUrl;
	protected $baseSrc;
	protected $Url;

	public function __construct(){
		global $Perfect;
		$this->Perfect = $Perfect;
		$this->viewPath = $this->Perfect->viewPath;
		$this->layout = $this->Perfect->config['viewConfig']['layout'];
		$this->viewExt = $this->Perfect->config['viewConfig']['viewExt'];
		$this->baseSrc = $this->Perfect->baseSrc;
		$this->baseUrl = $this->Perfect->baseUrl;
		$this->IP = new IpStore;
		if ($this->Perfect->Router['moduleStatus']) {
			$uri = $this->Perfect->Router['module'].'/'.$this->Perfect->Router['controller'].'/'.$this->Perfect->Router['action'];
		}else{
			$uri = $this->Perfect->Router['controller'].'/'.$this->Perfect->Router['action'];
		}
		$this->Url = $this->baseUrl.'?r='.$uri;

		
	}

	/**
	 * 显示视图模板
	 *
	 * @param viewName 视图名称 string
	 * @param data 数据 array
	 * @param layout 公共布局文件 string
	 *
	 */
	protected function display($viewName,$data=array(),$layout=''){
		if ($layout!='') {
			$thisLayout = $layout;
		}else{
			$thisLayout = $this->layout;
		}
		extract($data);
		try {
			if (!$viewName) {
				throw new Pf_Exception("viewName is not defined");
			}
			$viewFile = $this->viewPath.$this->Perfect->Router['controller'].DS.$viewName.'.'.$this->viewExt;
			if (!file_exists($viewFile)) {
				throw new Pf_Exception("view file not found , view file name : <font color='#FE8D41'>$viewFile</font>");
			}
			$fileName = $this->viewPath.'layout/'.$thisLayout.'.'.$this->viewExt;
			if (!file_exists($viewFile)) {
				throw new Pf_Exception("layout file not found , layout name : <font color='#FE8D41'>$fileName</font>");
			}
		} catch (Pf_Exception $e) {
			$this->Perfect->Pf_Exception->init($e);
			exit();
		}
		require_once $fileName;
	}

	function LogRecord($msg) {
		$userAccount = $_SESSION[Perfect]['userAccount'];
		$userName = $_SESSION[Perfect]['userName'];
		$logDir = LOG_PATH.$userAccount.DS;

		if(!is_dir($logDir)){
			mkdir($logDir,0777,true);
			chmod($logDir,0777);
		}
		$logFile = $logDir.date('Y-m').'.log';

		if(file_exists($logFile)) chmod($logFile,0777);
		
		$nowTime = date('Y-m-d H:i:s');
		$ip = $_SERVER["REMOTE_ADDR"]?$_SERVER["REMOTE_ADDR"]:$GLOBALS["HTTP_SERVER_VARS"]["REMOTE_ADDR"];
		$this->IP->qqwry($ip);
		$address = str_replace('CZ88.NET','',(iconv("utf-8","GBK//IGNORE",$this->IP->Country).iconv("utf-8","GBK//IGNORE",$this->IP->Local)));

		$logLine = "$userName|$ip|$address|$nowTime|$msg\n";
		file_put_contents($logFile,$logLine, FILE_APPEND|LOCK_EX);
	}

	public function Alert($msg=null, $goto = null){
		$msg = str_replace('|','<br>',$msg);
		$jsCode = '<html xmlns="http://www.w3.org/1999/xhtml"><head>';
		$jsCode .= '<link rel="stylesheet" href="'.$this->baseSrc.'web/js/themes/pepper-grinder/easyui.css">';
		$jsCode .= '<script src="'.$this->baseSrc.'web/js/themes/icon.css"></script>';
		$jsCode .= '<script src="'.$this->baseSrc.'web/js/jquery-1.4.2.min.js"></script>';
		$jsCode .= '<script src="'.$this->baseSrc.'web/js/jquery.easyui.js"></script>';
		$jsCode .= '<script language="javascript">';
		$jsCode .= is_null($goto)?"$.messager.alert('提示','$msg','warning',function(){window.history.back();});":"$.messager.alert('提示','$msg','warning',function(){ window.location='{$goto}'; });";
		$jsCode .= "</script></head><body>";
		$jsCode .= "</body></html>";
		exit($jsCode);
	}

	/**
	 * 系统跳转方法
	 *
	 */
	protected function redirect($url,$param=array()) {
		$uri = "";
		foreach ($param as $key => $value) {
			$uri .= '&'.$key.'='.$value;
		}
		$url = $url.$uri;
		header('Location: ' . $url);
	}

	public function JsCode($code=null){
		if(is_null($code)) exit('参数错误!');
		$jsCode  = '<script language="javascript">';
		$jsCode .= $code;
		$jsCode .= "</script>";
		exit($jsCode);
	}

	/**
	 * 任意跳转方法
	 */
	public function Go($goto){
		$jsCode  = "<script language='javascript'>";
		$jsCode .= "window.location='{$goto}';</script>";
		exit($jsCode);
	}

	public function SubString($title,$length){
		if(strlen($title)>=$length){
			for ($i=0; $i< $length; $i++) {
				$ch = substr($title, $i, 1);
				if(ord($ch)>0x80) $i++;
			}
			$str = substr($title, 0, $i);
			$str .="..";
		}else{
			$str = $title;
		}
		return $str;
	}

	public function Reload($msg=null){
		$jsCode  = '<script language="javascript">';
		$jsCode .= is_null($msg)?'alert("系统重新加载!");':"alert(\"$msg\");";
		$jsCode .= 'window.parent.location.reload();</script>';
		exit($jsCode);
	}

	protected function Log($data){
		
	}

	

}