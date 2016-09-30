<?php
if (!defined('Perfect')) exit('Blocking access to this script');
/**
 * 后台首页相关功能控制器类
 */
class baseController extends Controller {

	public function __construct(){
		parent::__construct();
		$controllerName = $this->Perfect->Router['controller'];
		$actionName = $this->Perfect->Router['action'];
		$this->Menu = $this->Perfect->menu;

		if(isset($_SESSION[Perfect])) $_SESSION[Perfect]['activeTime'] = time();
		if(!is_null(Perfect) && isset($_SESSION[Perfect]) && $_SESSION[Perfect]['systemActive']==true) {
			foreach($this->Menu['ITEM'] as $value){
				if($value['M']==$controllerName && $value['A']==$actionName && (substr($actionName,-4)!='Deal')){
					if(isset($_REQUEST['onPage']) && (intval($_REQUEST['onPage'])==0 || empty($_REQUEST['onPage']))){
						$pageIntro = "点击进入";
					}else{
						$pageIntro = "分页进入";
					}
					$searchIntro = '';
					if(!empty($_REQUEST['searchTag'])){
						$searchIntro = "，搜索关键词:".trim($_REQUEST['searchTag']);
					}
					if(!empty($_REQUEST['searchTagById'])){
						$searchIntro = "，搜索ID:".trim($_REQUEST['searchTagById']);
					}
					$activeMessage = $pageIntro.$this->Menu['MENU'][$value['F']].'->'.$value['T'].$searchIntro;
					$this->LogRecord($activeMessage);
				}else{
					continue;
				}
			}
			$touchSql = "SELECT user_touch FROM `pf_admins` WHERE admin_id='{$_SESSION[Perfect]['userId']}' ";
			$activeUserTouch = $this->Perfect->db->fetch($touchSql);

			if(empty($activeUserTouch['user_touch'])){
				$userTouch = $_SESSION[Perfect]['manageTouch'];
			}else{
				$userTouch = $activeUserTouch['user_touch'];
			}
			if($_SESSION[Perfect]['systemActive']===true && $_SESSION[Perfect]['root']===false) 
			{
				$operationMark = true;
				$NoAuth = true;
				if(substr($actionName,-4)=='Deal') $operationMark = true;
				if(substr($actionName,-6)=='NoAuth') $NoAuth = true;

				if(is_null($userTouch)) exit("Sorry,your account doesn't have permission.\\n\\nFor Inquiries: Please contact technical!");
				$userTouchArr = explode('|',$userTouch);

				$viewPermis = array();
				foreach($userTouchArr as $value){
					$tmps = explode('-',$value);
					$dTypeCount = count(explode(',',$tmps[1]));
					$viewPermis[] = $tmps[0];
					if($dTypeCount>=1)
					{
						$operatePermis[$tmps[0]] = explode(',',$tmps[1]);
					}
				}

				foreach($this->Menu['ITEM'] as $key => $value){
					$sysItemIndex[$key]=$value['A'];
					if(isset($value['DTYPE']) && !is_null($value['DTYPE'])){
						foreach($this->Menu['DTYPE'][$value['DTYPE']] as $k => $v){
							$dTypeItemIndex[$key][$k]= $v['D'];
						}
					}else{
						$dTypeItemIndex[$key] = 0;
					}
				}
				$fatherAction = Router::getFatherRouterInfo();

				// var_dump($this);
				$sysItemValue = array_flip($sysItemIndex);
				if (array_key_exists($actionName, $sysItemValue)) {
					$activeIndex = $sysItemValue[$actionName];
				}else{
					$this->Alert("{$_SESSION[Perfect]['userAccount']}：无权限!");
				}
				
				$activeFatherIndex = $fatherAction='' ? $sysItemValue[$fatherAction]:'';

				if(!in_array($activeIndex,$viewPermis) && $NoAuth!=true){
					if($operationMark!==true){
						$this->Alert("{$_SESSION[Perfect]['userAccount']}：无权限!");
						exit();
					}
				}
				
				if($operationMark===true) {
					$dType = isset($_REQUEST['dType']) ? trim($_REQUEST['dType']) : '';
					$dTypeTmp = $activeFatherIndex!='' ? array_flip($dTypeItemIndex[$activeFatherIndex]) : array();
					$dTypeIndex = $dType!='' ? $dTypeTmp[$dType] : '';
					if(@array_key_exists($activeFatherIndex,$operatePermis) && !in_array($dTypeIndex,$operatePermis[$activeFatherIndex])){
						foreach($this->Menu['ITEM'] as $value){
							if($value['M']==$controllerName && $value['A']==$actionName && (substr($actionName,-4)!='Deal'))
							{
								$activeMessage = '于'.$this->Menu['MENU'][$value['F']].'->'.$value['T'].'进行功能操作被拒绝';
								$this->LogRecord($activeMessage);
							}else{
								continue;
							}
						}
						$this->Alert("{$_SESSION[Perfect]['userAccount']}：无权限!");
						exit();
					}
				}
			}
		}
	}

}
