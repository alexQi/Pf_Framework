<?php
if (!defined('Perfect')) exit('Blocking access to this script');
/**
 * 后台首页相关功能控制器类
 */
class mainController extends baseController {

	public function indexAction(){
		if (isset($_SESSION[Perfect]) && $_SESSION[Perfect]['root']==false && is_null($_SESSION[Perfect]['root'])) {
			
		}else{

		}

		$this->display('index');
	}

	public function testAction(){
		echo 111;
	}
}
