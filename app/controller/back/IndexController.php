<?php
if (!defined('Perfect')) exit('Blocking access to this script');
/**
 * 后台首页相关功能控制器类
 */
class IndexController extends Controller {

	public function indexAction(){
		$data = array();
		if (isset($_REQUEST['username']) && $_REQUEST['username']!='' && isset($_REQUEST['password']) && $_REQUEST['password']!='' ) {
			$username = $_REQUEST['username'];
			$password  = $_REQUEST['password'];
			$adminModel = new adminModel;
			$userInfo = $adminModel->getUserInfoByName($username);
			try {
				if (!$userInfo) {
					throw new Pf_Exception("当前用户不存在");
				}
				if (!$userInfo['password']==$password) {
					throw new Pf_Exception("密码不正确");
				}

				if(getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")){
					$ip = getenv("HTTP_CLIENT_IP");
				}else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")){
					$ip = getenv("HTTP_X_FORWARDED_FOR");
				}else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")){
					$ip = getenv("REMOTE_ADDR");
				}else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")){
					$ip = $_SERVER['REMOTE_ADDR'];
				}else{
					$ip = "unknown";
				}

				if($this->IP->_isPrivate($ip)===false) {
					if($userInfo['area_limits']!=0){
						$extAreaTmp = explode('|',$userInfo['area_limits']);
						foreach($this->Perfect->config['province'] as $key => $value){
							if(array_key_exists($key,array_flip($extAreaTmp))) $existProvinceTmp[] = $value;
						}

						$this->IP->qqwry($ip);
						$address = str_replace('CZ88.NET','',($this->IP->Country.$this->IP->Local));
						$tags =0;
						foreach($existProvinceTmp as $value){
							if(!preg_match('/'.$value.'/', $address)) $tags++;
						}
						
						if($tags==count($existProvinceTmp)){
							$this->Alert($managerInfo['true_name'].'的帐号禁止在'.$address.'登录！');
							exit;
						}
					}
				}

				$_SESSION[Perfect]['systemActive'] = true;
				$_SESSION[Perfect]['userName'] = $userInfo['true_name'];
				$_SESSION[Perfect]['userAccount'] = $userInfo['user_account'];
				$_SESSION[Perfect]['manageTouch'] = $userInfo['user_touch'];
				$_SESSION[Perfect]['groupRole'] = $userInfo['group_role'];
				$_SESSION[Perfect]['userRole'] = $userInfo['user_role'];
				$_SESSION[Perfect]['roleType'] = $userInfo['role_type'];
				$_SESSION[Perfect]['userId'] = $userInfo['admin_id'];
				$_SESSION[Perfect]['activeTime'] = time();

				if($userInfo['user_role']==-1){
					$_SESSION[Perfect]['root'] = true;
				}else{
					$_SESSION[Perfect]['root'] = false;
				}

				$this->IP->qqwry($ip);
            			$address = str_replace('CZ88.NET','',$this->IP->Country.$this->IP->Local);
            			$address = iconv("GBK","UTF-8",$address);

				$loginInfo['admin_id'] = $userInfo['admin_id'];
				$loginInfo['ip'] = $ip;
				$loginInfo['address'] = $address;
				$loginInfo['time'] = date('Y-m-d H:i:s',time());
				$loginInfo['date'] = date('Y-m-d',time());
				
				$adminModel->setLoginRecord($loginInfo);
				
				$this->LogRecord("登录管理后台。");

				$this->redirect('index.php?r=back/main/index');
				exit();
			} catch (Pf_Exception $e) {
				$data['error_message'] = $e->getMessage();
			}
		}

		$this->display('index',$data,'main_login');
	}

	/**
	 * demo
	 */
	public function logoutAction() {
		unset($_SESSION[Perfect]);
		session_destroy();
		$this->redirect('index.php?r=back/index/index');
	}

}
