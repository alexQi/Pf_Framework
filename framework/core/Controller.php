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

	public function LogRecord($msg) {
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

	public 	function connectHandledRedis(){
		$config=$this->Perfect->config['handledRedis'];
		$handleRedis = new Redis();
		if(!$handleRedis->connect($config['host'], $config['port'])){
			echo "redis not connect!";
			exit;
		}
		if(!$handleRedis->auth($config['passwd'])){
			echo "redis auth error!";
			exit;
		}
		return $handleRedis;
	}

	public function Alert($msg=null, $goto = null){
		$msg = str_replace('|','<br>',$msg);
		$path = $this->Perfect->config['viewConfig']['viewPath'].'/public/';
		$fileName = $path.'alert.php';
		require_once $fileName;
		exit();
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

	public function Log($logData){
		$parme ='';
		$logData['update_time'] = date('Y-m-d H:i:s',time());
		$logData['admin_id'] = $_SESSION[FEELINGS]['userId'];
		foreach($logData as $key => $value){
			$tmp[] ="`$key`='{$value}'";
		}
		$parme = join(',',$tmp);
		$sql = "INSERT INTO `{$this->Perfect->CTable('operation_log')}` SET $parme";
		return $this->DB->query($sql);
	}

	

}