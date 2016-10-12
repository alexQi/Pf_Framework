<?php
if (!defined('Perfect')) exit('Blocking access to this script');
/**
 * 后台首页相关功能控制器类
 */
class baseController extends Controller {

	public function __construct(){
		parent::__construct();
		if (!isset($_SESSION[Perfect]) || $_SESSION[Perfect]['systemActive'] != true) {
			$this->Alert("您还未登陆系统",'index.php?r=back/index/index');
		}
		$controllerName = $this->Perfect->Router['controller'];
		$actionName = $this->Perfect->Router['action'];
		$this->Menu = $this->Perfect->menu;

		if(isset($_SESSION[Perfect])) $_SESSION[Perfect]['activeTime'] = time();
		if(!is_null(Perfect) && isset($_SESSION[Perfect]) && $_SESSION[Perfect]['systemActive']==true) {

			#--VIEW LOG--#
			foreach($this->Menu['ITEM'] as $value)
			{
				if($value['M']==$controllerName && $value['A']==$actionName && (substr($actionName,-4)!='Deal')){
					if(isset($_REQUEST['onPage']) && (intval($_REQUEST['onPage'])==0 || empty($_REQUEST['onPage'])) ){
						$pageInto = "点击进入";
					}else{
						$pageInto = "分页进入";
					}
					$searchInto = '';
					if(!empty($_REQUEST['searchTag'])){
						$searchInto = "，搜索关键词:".trim($_REQUEST['searchTag']);
					}
					if(!empty($_REQUEST['searchTagById'])){
						$searchInto = "，搜索ID:".trim($_REQUEST['searchTagById']);
					}
					$activeMessage = $pageInto.$this->Menu['MENU'][$value['F']].'->'.$value['T'].$searchInto;
					$this->LogRecord($activeMessage);
				}else{
					continue;
				}
			}

			//获取用户权限
			$touchSql = "SELECT user_touch FROM `pf_admins` WHERE admin_id='{$_SESSION[Perfect]['userId']}' ";
			$activeUserTouch = $this->Perfect->db->fetch($touchSql);

			if(empty($activeUserTouch['user_touch']))
			{
				$userTouch = $_SESSION[Perfect]['manageTouch'];
			}else{
				$userTouch = $activeUserTouch['user_touch'];
			}

			if($_SESSION[Perfect]['systemActive']===true && $_SESSION[Perfect]['root']===false)
			{
				$operationMark = false;
				$NoAuth = false;
				if(substr($actionName,-4)=='Deal') $operationMark = true;
				if(substr($actionName,-6)=='NoAuth') $NoAuth = true;

				$userTouchArr = explode('|',$userTouch);

				$viewPermis = array();
				foreach($userTouchArr as $value){
					$tmps = explode('-',$value);
					$dTypeCount = count(explode(',',$tmps[1]));
					$viewPermis[] = $tmps[0];
					if($dTypeCount>=1){
						$operatePermis[$tmps[0]] = explode(',',$tmps[1]);
					}
				}

				foreach($this->Menu['ITEM'] as $key => $value)
				{
					$sysItemIndex[$key]=$value['A'];
					if(isset($value['DTYPE']) && !is_null($value['DTYPE']))
					{
						foreach($this->Menu['DTYPE'][$value['DTYPE']] as $k => $v)
						{
							$dTypeItemIndex[$key][$k] = $v['D'];
						}
					}
					else
					{
						$dTypeItemIndex[$key] = 0;
					}
				}

				$fatherAction = Router::getFatherRouterInfo();
				$sysItemValue = array_flip($sysItemIndex);
				if (array_key_exists($actionName, $sysItemValue))
				{
					$activeIndex = $sysItemValue[$actionName];
				}else{
					$activeIndex = -1;
				}
				$activeFatherIndex = $fatherAction!='' && isset($sysItemValue[$fatherAction]) ? $sysItemValue[$fatherAction]:'';
				if(!in_array($activeIndex,$viewPermis) && $NoAuth!=true){
					if($operationMark!==true){
						$this->Alert("Sorry ".ucfirst($_SESSION[Perfect]['userAccount'])."，当前操作无权限!");
					}
				}
				if($operationMark===true) {
					$dType = isset($_REQUEST['dType']) ? trim($_REQUEST['dType']) : '';
					$dTypeTmp = $activeFatherIndex!='' ? array_flip($dTypeItemIndex[$activeFatherIndex]) : array();
					$dTypeIndex = $dType!='' && isset($dTypeTmp[$dType]) ? $dTypeTmp[$dType] : '';
					if(array_key_exists($activeFatherIndex,$operatePermis) && !in_array($dTypeIndex,$operatePermis[$activeFatherIndex])){
						foreach($this->Menu['ITEM'] as $value){
							if($value['M']==$controllerName && $value['A']==$actionName && (substr($actionName,-4)!='Deal'))
							{
								$activeMessage = '于'.$this->Menu['MENU'][$value['F']].'->'.$value['T'].'进行功能操作被拒绝';
								$this->LogRecord($activeMessage);
							}else{
								continue;
							}
						}
						$this->Alert("Sorry ".ucfirst($_SESSION[Perfect]['userAccount'])."，当前操作无权限!");
						exit();
					}
				}
			}
		}
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

}
