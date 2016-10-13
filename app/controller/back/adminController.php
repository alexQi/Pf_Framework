<?php
if (!defined('Perfect')) exit('Blocking access to this script');
/**
 * 后台用户控制器类
 */
class adminController extends baseController
{
	public function adminDealAction(){
		$adminModel = new adminModel();
		$dType = trim($_REQUEST['dType']);
		if($dType=='createMember'){
			$this->createMember(microtime());
			exit;
		}elseif($dType=='memberModify'){
			$this->memberModify(microtime());
			exit;
		}elseif($dType=='lockMember'){
			$intoData['admin_id'] = intval($_REQUEST['accountId']);
			$intoData['is_closed'] = 1;
			if($adminModel->setAdminField($intoData)){
				$this->Alert('操作成功!');
			}else{
				$this->Alert('操作失败!');
			}
		}elseif($dType=='unlockMember'){
			$intoData['admin_id'] = intval($_REQUEST['accountId']);
			$intoData['is_closed'] = 0;
			if($adminModel->setAdminField($intoData)){
				$this->Alert('操作成功!');
			}else{
				$this->Alert('操作失败!');
			}
		}elseif($dType=='memberLog'){

			$this->memberLog(microtime());

		}else{
			$this->Alert('非法操作!');
			exit();
		}
	}

	public function indexAction() {
		$adminModel = new adminModel();
		$searchTag = isset($_REQUEST['searchTag']) ? trim($_REQUEST['searchTag']) : '';
		$onPage = isset($_REQUEST['onPage']) ? max(intval($_REQUEST['onPage']),1) : 1;
		$pageSize = 30;
		$filter = '';
		if(!empty($searchTag)) {
			$filter .= " AND user_account LIKE ('%$searchTag%')";
		}
		$filter .= " ORDER BY is_closed,admin_id ASC";
		$accountList = $adminModel->getMemberList($onPage,$pageSize,$filter);
		foreach($accountList['list'] as $key => $value){
			$accountList['list'][$key]['user_role'] = $value['user_role'];
			$accountList['list'][$key]['role_type'] = $value['role_type'];
			$accountList['list'][$key]['user_role_tag'] = $this->Perfect->config['systemGroup'][$value['user_role']];
			$accountList['list'][$key]['role_type_tag'] = $this->Perfect->config['systemUserRole'][$value['role_type']];
			$accountList['list'][$key]['is_closed_tag'] = $this->Perfect->config['systemAccountStatus'][$value['is_closed']];
		}
		$params = array(
		            'total_rows'=>$accountList['count'],
		            'goto' =>$this->Url,
		            'now_page'  =>$onPage,
		            'list_rows' =>$pageSize,
		);
		$page = new Page($params);

		$data['searchTag'] = $searchTag;
		$data['userRole'] = $_SESSION[Perfect]['userRole'];
		$data['userId'] = $_SESSION[Perfect]['userId'];
		$data['roleType'] = $_SESSION[Perfect]['roleType'];
		$data['list'] = $accountList['list'];
		$data['page'] = $page->showPage();

		$this->display('index',$data);
	}

	function createMember($token){
		if(empty($token)) exit('非法操作！');
		$aType = isset($_REQUEST['aType']) ? trim($_REQUEST['aType']) : false;
		if($aType=='createMember'){
			$adminModel = new adminModel();
			$intoData['user_account'] = trim($_POST['userName']);
			$intoData['password'] = MD5($_POST['passWord']);
			$intoData['true_name'] = trim($_POST['trueName']);
			$intoData['qq'] = intval($_POST['qqAccount']);
			$intoData['mobile'] = trim($_POST['privatePhone']);
			$intoData['user_role'] = intval($_POST['userRole']);
			$intoData['role_type'] = intval($_POST['userRoleType']);
			$intoData['nick_name'] = trim($_POST['nickName']);

			$areaLimits = isset($_POST['areaLimits']) ? $_POST['areaLimits'] : array();

			if(is_array($_POST['areaLimits']) && !empty($_POST['areaLimits'])){
				$intoData['area_limits'] = join("|",$_POST['areaLimits']);
			}else{
				$intoData['area_limits'] = 0;
			}

			$viewPermissions = isset($_POST['viewPermissions']) ? $_POST['viewPermissions'] : array();
			$operatingAuthority = isset($_POST['operatingAuthority']) ? $_POST['operatingAuthority'] : array();
			if(empty($viewPermissions)){
				$this->Alert('必须设置权限!');
				exit;
			}

			$allowMenu = array();
			foreach($viewPermissions as $value){
				$temp = explode('_',$value);
				$allowMenu[$temp[0]] = array();
				if(array_key_exists($temp[0],$operatingAuthority)){
					array_push($allowMenu[$temp[0]],0);
					foreach($operatingAuthority[$temp[0]] as $v){
						array_push($allowMenu[$temp[0]],$v);
					}
				}else{
					array_push($allowMenu[$temp[0]],0);
				}
			}

			$intoUusertouchTemp = array();
			foreach($allowMenu as $key => $value){
				if(empty($allowMenu[$key])){
					array_push($intoUusertouchTemp,$key);
				}else{
					array_push($intoUusertouchTemp,$key.'-'.join(',',$value));
				}
			}

			$userTouch = join('|',$intoUusertouchTemp);
			if($_SESSION[Perfect]['userRole']!=-1){
				if($_SESSION[Perfect]['userRole']==1 && $_SESSION[Perfect]['roleType']==1000) {
					$intoData['user_touch'] = $userTouch;
				}else{
					$this->Alert('非法操作!');
					exit;
				}
			}else{
				$intoData['user_touch'] = $userTouch;
			}
			if($adminModel->createMember($intoData)){
				$this->Alert('帐号创建成功!','index.php?r=back/admin/index');
			}else{
				$this->Alert('帐号创建失败!');
			}
			exit;
		}
		$userGroup = array();
		$areaLimits = array();
		$exportMenu = array();
		$roleTypeSelect = array();
		foreach($this->Perfect->config['systemGroup'] as $key => $value){
			array_push($userGroup,array('groupValue'=>$key,'groupName'=>$value));
		}

		foreach($this->Perfect->config['province'] as $key => $value){
			array_push($areaLimits,array('value' =>$key,'title'=>$value));
		}

		foreach($this->Perfect->config['systemUserRole'] as $key => $value){
			array_push($roleTypeSelect,array('value' =>$key,'title'=>$value));
		}
		foreach($this->Menu['MENU'] as $key => $value){
			$exportMenu[$key] = array('MENUK'=>$key,'MENU'=>$value,'MENUITEM'=>array());
			$exportMenu[$key]['MENUITEM'] = array();
			foreach($this->Menu['ITEM'] as $k => $v){
				if($key==$v['F']){
					$temp = array('DK'=>$k,'DV'=>$v['T']);
					if(isset($v['DTYPE'])){
						$temp['DA'] = array();
						foreach($this->Menu['DTYPE'][$v['DTYPE']] as $ad => $at){
							array_push($temp['DA'],array('DAK'=>$ad,'DAT'=>$at['T']));
						}
					}
					array_push($exportMenu[$key]['MENUITEM'],$temp);
					unset($temp);
				}
			}
		}
		$data['exportMenu'] = $exportMenu;
		$data['userGroup'] = $userGroup;
		$data['roleTypeSelect'] = $roleTypeSelect;
		$data['areaLimits'] = $areaLimits;
		$this->display('createMember',$data);
	}

	function memberModify($token){
		if(empty($token)) exit('非法操作！');
		$aType = isset($_REQUEST['aType']) ? trim($_REQUEST['aType']) : false;
		if($aType=='memberModify'){
			$adminModel = new adminModel();
			$intoData['admin_id'] = intval($_POST['accountId']);
			if(!empty($_POST['passWord'])){
				$intoData['password'] = MD5($_POST['passWord']);
			}
			$intoData['true_name'] = trim($_POST['trueName']);
			$intoData['qq'] = intval($_POST['qqAccount']);
			$intoData['mobile'] = trim($_POST['privatePhone']);
			$intoData['nick_name'] = trim($_POST['nickName']);
			$intoData['user_role'] = intval($_POST['userRole']);
			$intoData['role_type'] = intval($_POST['roleType']);

			$areaLimits = isset($_POST['areaLimits']) ? $_POST['areaLimits'] : array();

			if(is_array($areaLimits) && !empty($areaLimits)){
				$intoData['area_limits'] = join("|",$_POST['areaLimits']);
			}else{
				$intoData['area_limits'] = 0;
			}

			$viewPermissions = isset($_POST['viewPermissions']) ? $_POST['viewPermissions'] : array();
			$operatingAuthority = isset($_POST['operatingAuthority']) ? $_POST['operatingAuthority'] : array();
			if(empty($viewPermissions)){
				$this->Alert('必须设置权限!');
				exit;
			}

			$allowMenu = array();
			foreach($viewPermissions as $value){
				$temp = explode('_',$value);
				$allowMenu[$temp[0]] = array();
				if(array_key_exists($temp[0],$operatingAuthority)){
					array_push($allowMenu[$temp[0]],0);
					foreach($operatingAuthority[$temp[0]] as $v){
						array_push($allowMenu[$temp[0]],$v);
					}
				}else{
					array_push($allowMenu[$temp[0]],0);
				}
			}

			$intoUusertouchTemp = array();
			foreach($allowMenu as $key => $value){
				if(empty($allowMenu[$key])){
					array_push($intoUusertouchTemp,$key);
				}else{
					array_push($intoUusertouchTemp,$key.'-'.join(',',$value));
				}
			}

			$userTouch = join('|',$intoUusertouchTemp);
			if($_SESSION[Perfect]['userRole']!=-1){
				if($_SESSION[Perfect]['userRole']==1 && $_SESSION[Perfect]['roleType']==1000) {
					// if($intoData['user_role']==0 || $intoData['role_type']==0){
					// 	$this->Alert('1非法操作!');
					// 	exit;
					// }
					$intoData['user_touch'] = $userTouch;
				}else{
					$this->Alert('非法操作!');
					exit;
				}
			}else{
				$intoData['user_touch'] = $userTouch;
			}
			if($adminModel->setAdminField($intoData)){
				$this->Alert('修改成功!');
			}else{
				$this->Alert('修改失败!');
			}
			exit;
		}
		$masterId = intval($_REQUEST['accountId']);
		$adminModel = new adminModel();
		$accountInfo = $adminModel->getMemberDetailById($masterId);
		$userGroup = $areaLimits = $exportMenu = $allowArea = $roleTypeSelect = array();
		foreach($this->Perfect->config['systemGroup'] as $key => $value){
			$selected = ($key==$accountInfo['user_role'])?'selected="selected"':'';
			array_push($userGroup,array('groupValue'=>$key,'tag'=>$selected,'groupName'=>$value));
		}

		foreach($this->Perfect->config['province'] as $key => $value){
			$selected = in_array($key,explode('|',$accountInfo['area_limits']))?'checked="checked"':'';
			array_push($areaLimits,array('value' =>$key,'title'=>$value,'tag'=>$selected));
		}

		foreach($this->Perfect->config['systemUserRole'] as $key => $value){
			$selected = ($key==$accountInfo['role_type'])?'selected="selected"':'';
			array_push($roleTypeSelect,array('value' =>$key,'title'=>$value,'tag'=>$selected));
		}

		foreach($this->Menu['MENU'] as $key => $value){
			$tempData = array('MENUK'=>$key,'MENU'=>$value,'MENUITEM'=>array());
			$tempData['MENUITEM'] = array();
			foreach($this->Menu['ITEM'] as $k => $v){
				if($key==$v['F']){
					$temp = array('DK'=>$k,'DV'=>$v['T']);
					if(isset($v['DTYPE'])){
						$temp['DA'] = array();
						foreach($this->Menu['DTYPE'][$v['DTYPE']] as $ad => $at){
							array_push($temp['DA'],array('DAK'=>$ad,'DAT'=>$at['T']));
						}
					}
					array_push($tempData['MENUITEM'],$temp);
					unset($temp);
				}
			}
			array_push($exportMenu,$tempData);
		}

		$data['accountInfo'] = $accountInfo;
		$data['exportMenu'] = $exportMenu;
		$data['userGroup'] = $userGroup;
		$data['roleTypeSelect'] = $roleTypeSelect;
		$data['areaLimits'] = $areaLimits;

		$this->display('memberModify',$data);
	}

	function memberLog($token){
		if(empty($token)) exit('非法操作！');
		$adminModel = new adminModel();
		$onPage = isset($_REQUEST['onPage'])?max(intval($_REQUEST['onPage']),1):1;
		$sortType = isset($_REQUEST['sortType'])?intval($_REQUEST['sortType']):0;
		$userName = trim($_REQUEST['userAccount']);
		$pageSize = 23;
		
		$offSet = $pageSize*($onPage-1);
		
		if(!$_SESSION[Perfect]['root']!=-1){
			if($userName!=$_SESSION[Perfect]['userAccount']){
				exit('非法操作！');
			}
		}
		$logDir = LOG_PATH.DS.$userName.DS;
		$sickDate = empty($_REQUEST['sickDate'])?date("Y-m"):$_REQUEST['sickDate'];
		foreach (glob($logDir."*.log") as $logFile) {
			$date = substr(substr($logFile,-11),0,7);
			$selected = ($sickDate==$date)?"selected":'';
			$logDateBox[] = array('date'=>$date,'tag'=>$selected);
		}
		$sortBox = array('1'=>'按操作时间由远及近','2'=>'按操作时间由近及远');
		$sortSelect = array();
		foreach($sortBox as $key => $value){
			$selected = ($key==$sortType)?'selected="selected"':'';
			array_push($sortSelect,array('title'=>$value,'value'=>$key,'tag'=>$selected));
		}
		$logFile = $logDir.$sickDate.'.log';
		$sickLog = $adminModel->getAdminSickLog($logFile,$sortType);
		if(is_array($sickLog)){
			$adminExpLog = array_slice($sickLog,$offSet,$pageSize);
		}else{
			$adminExpLog = array();
		}

		$params = array(
		            'total_rows'=>count($sickLog),
		            'goto' =>$this->Url.'&dType=memberLog&sortType='.$sortType.'&sickDate='.$sickDate.'&userAccount='.$userName,
		            'now_page'  =>$onPage,
		            'list_rows' =>$pageSize,
		);
		$page = new Page($params);

		$data['sickLog'] = $adminExpLog;
		$data['userName'] = $userName;
		$data['sortSelect'] = $sortSelect;
		$data['page'] = $page->showPage();
		$data['logDateBox'] = $logDateBox;

		$this->display('adminSickLog',$data);
	}

	public function operationLogListAction(){
		$adminModel = new adminModel();
		$searchTag = isset($_REQUEST['searchTag']) ? trim($_REQUEST['searchTag']):'';
		$module = isset($_REQUEST['module']) ? trim($_REQUEST['module']):'';
		$table = isset($_REQUEST['table']) ? trim($_REQUEST['table']):'';
		$type = isset($_REQUEST['type']) ? trim($_REQUEST['type']):'';
		$onPage = isset($_REQUEST['onPage']) ? max(intval($_REQUEST['onPage']),1):1;
		$pageSize = 30;
		$filter = ' 1=1 ';
		if($searchTag) 
		{
			$filter .= " AND ( content LIKE ('%$searchTag%') OR true_name LIKE ('%$searchTag%') )";
		}
		if (!empty($module) && $module!='') 
		{
			$filter .= " AND module='$module' ";
			if(!empty($table) && $table!='') 
			{
				$filter .= " AND `table`='$table'";
				if(!empty($type) && $type!='') 
				{
					$filter .= " AND type='$type'";
				}
			}
		}

		$filter .= " ORDER BY update_time DESC";

		$logList = $adminModel->getOperationLogs($onPage,$pageSize,$filter);
		$modules = $adminModel->getLogModule();
		$params = array(
		            'total_rows'=>$logList['count'],
		            'goto' =>$this->Url."&searchTag=$searchTag&module=$module&table=$table&type=$type",
		            'now_page'  =>$onPage,
		            'list_rows' =>$pageSize,
		);
		$page = new Page($params);

		$data['modules'] = $modules;
		$data['module'] = $module;
		$data['table'] = $table;
		$data['type'] = $type;
		$data['logList'] = $logList['list'];
		$data['searchTag'] = $searchTag;
		$data['page'] = $page->showPage();
		$this->display('memberOperationLog',$data);
	}

	public function getLogTableNoAuthAction()
	{
		$adminModel = new adminModel();
		$module = trim($_REQUEST['module']);
		$html = "<option value=''>全部数据表</option>";
		if ($module) 
		{
			$tables = $adminModel->getLogTables($module);
			if (!empty($tables)) 
			{	
				foreach ($tables as $key => $value) 
				{
					$html .= "<option value='".$value['table']."'>".$value['table']."</option>";
				}
			}
		}
		echo $html;
	}

	public function getLogTypeNoAuthAction()
	{
		$adminModel = new adminModel();
		$table = trim($_REQUEST['table']);
		$html = "<option value=''>全部操作</option>";
		if ($table) 
		{
			$types = $adminModel->getLogTableType($table);
			if (!empty($types)) 
			{	
				foreach ($types as $key => $value) 
				{
					$html .= "<option value='".$value['type']."'>".$value['type']."</option>";
				}
			}
		}
		echo $html;
	}
}

?>