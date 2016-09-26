<?php
if (!defined('Perfect')) exit('Blocking access to this script');
/**
 * 异常处理类 继承系统Exception
 * 重写__toString() 格式化错误信息
 * 定义错误输出模板
 */
class Pf_Exception extends Exception{

	public $tittle = '404 Page';
	public $url = "";
	public $time = 10;
	public $layout;
	public $viewDir;
	public $viewExt;
	public $baseUrl;

	public function __construct($message='', $code = 0, Exception $previous = null)
	{
        		parent::__construct($message, $code, $previous);
    	}

    	public function init($error){
		$this->message = $error;
		if ($this->message!='') {
			$this->showException();
		}
	}

	public function __toString() {
		$line = $this->line-1;
		$errorMessage = '<strong>Message : <strong>'.$this->message;
		$errorMessage .= '<br /><strong>File : <strong>'.$this->file.'  <font color="#00BCD4">['.$line.']</font>';
		$content = file_get_contents($this->file);
		$con_array = explode("\n", $content);
		$errorMessage .= "<br /><pre>";
		for ($i=$this->line-5; $i <= $this->line+5; $i++) {
			$errorMessage .= "\n<font color='#00BCD4'>$i</font>";
			if ($i==$line) {
				$errorMessage .= "<font color='#F44336'>".$con_array[$i]."</font>";
			}else{
				$errorMessage .= $con_array[$i];
			}
		}
		$errorMessage .= "</pre>";
		return $errorMessage;
	}

	private function showException($viewName='error'){
		$data['tittle'] = $this->tittle;
		$data['url']   = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER'] : $this->baseUrl;
		$data['time'] = $this->time;
		$data['email'] = $this->email;
		if (!$data['url']) {
			$data['time'] = '';
		}
		if (ENVIRONMENT=='debug') {
			$data['time'] = '';
			$data['info']  = $this->message;
		}else{
			$viewName = '404';
		}
		extract($data);
		$publicDir = $this->viewDir.'public/';
		$viewFile = $publicDir.$viewName.'.'.$this->viewExt;
		$fileName = $publicDir.$this->layout.'.'.$this->viewExt;
		require_once $fileName;
	}
}


?>