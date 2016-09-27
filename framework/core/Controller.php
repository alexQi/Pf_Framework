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
		extract($data);
		try {
			if (!$viewName) {
				throw new Pf_Exception("viewName is not defined");
			}
			$viewFile = $this->viewPath.$this->Perfect->Router['controller'].DS.$viewName.'.'.$this->viewExt;
			if (!file_exists($viewFile)) {
				throw new Pf_Exception("view file not found , view file name : <font color='#FE8D41'>$viewFile</font>");
			}
			$fileName = $this->viewPath.'layout/'.$this->layout.'.'.$this->viewExt;
			if (!file_exists($viewFile)) {
				throw new Pf_Exception("layout file not found , layout name : <font color='#FE8D41'>$fileName</font>");
			}
		} catch (Pf_Exception $e) {
			$this->Perfect->Pf_Exception->init($e);
			exit();
		}
		require_once $fileName;
	}

	/**
	 * 跳转方法
	 */
	protected function Jump($url, $info = '', $time = 3) {

		if ($info == '') {
			header('Location: ' . $url);
		} else {
			if (file_exists(PUBLIC_VIEW_PATH . 'jump.html')) {
				require PUBLIC_VIEW_PATH . 'jump.html';
			} else {
				//不存在，建立一个默认的模板
				$html = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" >';
				$html .= "<meta http-equiv='Refresh' content='$time; URL=$url' >";
				$html .= "</head><body>$info</body></html>";
				echo $html;
			}
		}
	}

	public function JsCode($code=null){
		if(is_null($code)) exit('参数错误!');
		$jsCode  = '<script language="javascript">';
		$jsCode .= $code;
		$jsCode .= "</script>";
		exit($jsCode);
	}

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