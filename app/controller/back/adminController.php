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
			if($adminModel->setManagerField($intoData)){
				$this->Alert('操作成功!');
			}else{
				$this->Alert('操作失败!');
			}
		}elseif($dType=='unlockMember'){
			$intoData['admin_id'] = intval($_REQUEST['accountId']);
			$intoData['is_closed'] = 0;
			if($adminModel->setManagerField($intoData)){
				$this->Alert('操作成功!');
			}else{
				$this->Alert('操作失败!');
			}
		}elseif($dType=='memberLog'){

			$this->memberLog(microtime());

		}else{
			exit('非法操作！');
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
		if($aType=='createSystemManager'){
			$adminModel = new adminModel();
			$intoData['user_account'] = trim($_POST['userName']);
			$intoData['password'] = MD5($_POST['passWord']);
			$intoData['true_name'] = trim($_POST['trueName']);
			$intoData['qq'] = intval($_POST['qqAccount']);
			$intoData['mobile'] = trim($_POST['privatePhone']);
			$intoData['tel'] = trim($_POST['officePhone']);
			$intoData['user_role'] = intval($_POST['userRole']);
			$intoData['role_type'] = intval($_POST['userRoleType']);
			$intoData['nick_name'] = trim($_POST['nickName']);
			$intoData['customer_limit'] = intval($_POST['customerLimit']);

			if(is_array($_POST['areaLimits']) && !empty($_POST['areaLimits'])){
				$intoData['area_limits'] = join("|",$_POST['areaLimits']);
			}else{
				$intoData['area_limits'] = 0;
			}

			$viewPermissions = (array)$_POST['viewPermissions'];
			$operatingAuthority = (array)$_POST['operatingAuthority'];
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
			if($_SESSION[FEELINGS]['userRole']!=-1){
				if(in_array($_SESSION[FEELINGS]['userRole'],array('0','3')) && in_array($_SESSION[FEELINGS]['roleType'],array('0','1'))) {
					$intoData['user_touch'] = $userTouch;
				}else{
					$this->Alert('非法操作!');
					exit;
				}
			}else{
				$intoData['user_touch'] = $userTouch;
			}
			if($adminModel->createManagerMamber($intoData)){
				$this->Alert('帐号创建成功!');
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
		if($aType=='systemModifyManager'){
			$adminModel = new adminModel();
			$intoData['admin_id'] = intval($_POST['accountId']);
			if(!empty($_POST['passWord'])){
				$intoData['password'] = MD5($_POST['passWord']);
			}
			$intoData['true_name'] = trim($_POST['trueName']);
			$intoData['qq'] = intval($_POST['qqAccount']);
			$intoData['mobile'] = trim($_POST['privatePhone']);
			$intoData['tel'] = trim($_POST['officePhone']);
			$intoData['nick_name'] = trim($_POST['nickName']);
			$intoData['user_role'] = intval($_POST['userRole']);
			$intoData['role_type'] = intval($_POST['roleType']);
			$intoData['customer_limit'] = intval($_POST['customerLimit']);

			if(is_array($_POST['areaLimits']) && !empty($_POST['areaLimits'])){
				$intoData['area_limits'] = join("|",$_POST['areaLimits']);
			}else{
				$intoData['area_limits'] = 0;
			}

			$viewPermissions = $_POST['viewPermissions'];
			$operatingAuthority = $_POST['operatingAuthority'];
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
			if($_SESSION[FEELINGS]['userRole']!=-1){
				if(in_array($_SESSION[FEELINGS]['userRole'],array('0','3')) && in_array($_SESSION[FEELINGS]['roleType'],array('0','1'))) {
					if($intoData['user_role']==0 || $intoData['role_type']==0){
						$this->Alert('非法操作!');
						exit;
					}
					$intoData['user_touch'] = $userTouch;
				}else{
					$this->Alert('非法操作!');
					exit;
				}
			}else{
				$intoData['user_touch'] = $userTouch;
			}
			if($adminModel->setManagerField($intoData)){
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

	function systemAccountManageLogSick($token){
		if(empty($token)) exit('非法操作！');
		$masterModel = new adminModel();
		$onPage = max(intval($_REQUEST['onPage']),1);
		$pageSize = 18;
		$sortType = intval($_REQUEST['sortType']);
		$offSet = $pageSize*($onPage-1);
		$userName = trim($_REQUEST['userAccount']);
		if(!$_SESSION[FEELINGS]['systemDaddy']){
			if($userName!=$_SESSION[FEELINGS]['userAccount']){
				exit('非法操作！');
			}
		}
		$logDir = LOG_FOLDER.DS.$userName.DS;
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
		$masterLog = $masterModel->getMamagerSystemLog($logFile,$sortType);
		if(is_array($masterLog)) $masterExpLog = array_slice($masterLog,$offSet,$pageSize);
		$goToUrl = 'index.php?controller=system&action=systemDeal&dType=systemSickManageLog&sortType='.$sortType.'&sickDate='.$sickDate.'&userAccount='.$userName;
		$this->Views->assign('masterLog', $masterExpLog);
		$this->Views->assign('userAccount', $userName);
		$this->Views->assign('sortSelect',$sortSelect);
		$this->Views->assign('pageList',$this->pagelist(count($masterLog),$pageSize,$goToUrl));
		$this->Views->assign('logDateBox', $logDateBox);
		$this->Views->display('manager_admin_log.html');
	}

	function systemManagerLoginManageAction(){
		$masterModel = new adminModel();
		$searchTag = trim($_REQUEST['searchTag']);
		$searchIp = trim($_REQUEST['searchIp']);
		$onPage = max(intval($_REQUEST['onPage']),1);
		$startDate = empty($_REQUEST['startDate'])?date('Y-m-d'):trim($_REQUEST['startDate']);
		$overDate = empty($_REQUEST['overDate'])?date('Y-m-d'):trim($_REQUEST['overDate']);
		$pageSize = 50;
		$filter = '';

		if(!empty($searchTag)) {
			$filter .= " AND (M.user_account LIKE '%$searchTag%' OR M.true_name LIKE ('%$searchTag%'))";
		}

		if($startDate>$overDate || $startDate==$overDate){
			$overDate = $startDate;
			$filter.= " AND LL.date>='{$startDate}' AND LL.date<='{$overDate}'";
		}else{
			$filter.= " AND LL.date>='{$startDate}' AND LL.date<='{$overDate}'";
		}

		if(!empty($searchIp)){
			$filter.= " AND LL.ip='{$searchIp}'";
		}
		$filter.= " ORDER BY LL.time DESC";

		$recordList = $masterModel->getMamagerSystemLoginLog($onPage,$pageSize,$filter);
		foreach($recordList['list'] as $key => $value){
			$recordList['list'][$key]['user_role_tag'] = ($value['user_role']==-1)?'初始帐号':$this->Perfect->config['systemGroup'][$value['user_role']];
		}

		$goToUrl = "index.php?controller=system&action=systemManagerLoginManage&searchTag=$searchTag&searchIp=$searchIp&startDate=$startDate&overDate=$overDate";
		$this->Views->assign('searchTag',$searchTag);
		$this->Views->assign('startDate',$startDate);
		$this->Views->assign('overDate',$overDate);
		$this->Views->assign('searchIp',$searchIp);
		$this->Views->assign('recordList',$recordList['list']);
		$this->Views->assign('pageList',$this->pagelist($recordList['count'],$pageSize,$goToUrl));
		$this->Views->display('manager_login_log.html');
	}

	function siteMemberSystemLogManageAction(){
		$masterModel = new adminModel();
		$searchTag = trim($_REQUEST['searchTag']);
		$searchIp = trim($_REQUEST['searchIp']);
		$onPage = max(intval($_REQUEST['onPage']),1);
		$startDate = empty($_REQUEST['startDate'])?date('Y-m-d 00:00:01'):trim($_REQUEST['startDate']);
		$overDate = empty($_REQUEST['overDate'])?date('Y-m-d 23:59:59'):trim($_REQUEST['overDate']);
		$pageSize = 50;
		$filter = '';
		if(!empty($searchTag)) {
			$filter .= " AND (M.user_name LIKE '%$searchTag%' OR S.site_id LIKE ('%$searchTag%'))";
		}

		if($startDate>$overDate || $startDate==$overDate){
			$overDate = $startDate;
			$filter.= " AND LL.time>='{$startDate}' AND LL.time<='{$overDate}'";
		}else{
			$filter.= " AND LL.time>='{$startDate}' AND LL.time<='{$overDate}'";
		}
		if(!empty($searchIp)){
			$filter.= " AND LL.ip='{$searchIp}'";
		}
		$filter.= " ORDER BY LL.time DESC";
		$recordList = $masterModel->getSiteMemberSystemLog($onPage,$pageSize,$filter);
		$goToUrl = "index.php?controller=system&action=siteMemberSystemLogManage&searchTag=$searchTag&searchIp=$searchIp&startDate=$startDate&overDate=$overDate";
		$this->Views->assign('searchTag',$searchTag);
		$this->Views->assign('startDate',$startDate);
		$this->Views->assign('overDate',$overDate);
		$this->Views->assign('searchIp',$searchIp);
		$this->Views->assign('recordList',$recordList['list']);
		$this->Views->assign('pageList',$this->pagelist($recordList['count'],$pageSize,$goToUrl));
		$this->Views->display('member_system_log.html');
	}

	function advertiserMemberSystemLogManageAction(){
		$masterModel = new adminModel();
		$searchTag = trim($_REQUEST['searchTag']);
		$searchIp = trim($_REQUEST['searchIp']);
		$onPage = max(intval($_REQUEST['onPage']),1);
		$startDate = empty($_REQUEST['startDate'])?date('Y-m-d 00:00:01'):trim($_REQUEST['startDate']);
		$overDate = empty($_REQUEST['overDate'])?date('Y-m-d 23:59:59'):trim($_REQUEST['overDate']);
		$pageSize = 50;
		$filter = '';
		if(!empty($searchTag)) {
			$filter .= " AND (A.user_name LIKE '%$searchTag%')";
		}

		if($startDate>$overDate || $startDate==$overDate){
			$overDate = $startDate;
			$filter.= " AND AL.time>='{$startDate}' AND AL.time<='{$overDate}'";
		}else{
			$filter.= " AND AL.time>='{$startDate}' AND AL.time<='{$overDate}'";
		}
		if(!empty($searchIp)){
			$filter.= " AND AL.ip='{$searchIp}'";
		}
		$filter.= " ORDER BY AL.time DESC";

		$recordList = $masterModel->getAdvertiserMemberSystemLog($onPage,$pageSize,$filter);
		$goToUrl = "index.php?controller=system&action=advertiserMemberSystemLogManage&searchTag=$searchTag&searchIp=$searchIp&startDate=$startDate&overDate=$overDate";
		$this->Views->assign('searchTag',$searchTag);
		$this->Views->assign('startDate',$startDate);
		$this->Views->assign('overDate',$overDate);
		$this->Views->assign('searchIp',$searchIp);
		$this->Views->assign('recordList',$recordList['list']);
		$this->Views->assign('pageList',$this->pagelist($recordList['count'],$pageSize,$goToUrl));
		$this->Views->display('advertiser_system_log.html');
	}

	function systemManagerManageLogAction(){
		$masterModel = new adminModel();
		$onPage = max(intval($_REQUEST['onPage']),1);
		$pageSize = 18;
		$sortType = intval($_REQUEST['sortType']);
		$offSet = $pageSize*($onPage-1);
		$userName = $_SESSION[FEELINGS]['userAccount'];
		$logDir = LOG_FOLDER.DS.$userName.DS;
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
		$masterLog = $masterModel->getMamagerSystemLog($logFile,$sortType);
		if(is_array($masterLog)) $masterExpLog = array_slice($masterLog,$offSet,$pageSize);
		$goToUrl = 'index.php?controller=system&action=systemManagerManageLog&sortType='.$sortType.'&sickDate='.$sickDate;
		$this->Views->assign('masterLog', $masterExpLog);
		$this->Views->assign('userAccount', $userName);
		$this->Views->assign('sortSelect',$sortSelect);
		$this->Views->assign('pageList',$this->pagelist(count($masterLog),$pageSize,$goToUrl));
		$this->Views->assign('logDateBox', $logDateBox);
		$this->Views->display('manager_admin_log.html');
	}

	public function systemNoticeAction()
	{
		$adminModel = new adminModel();
		$searchTag = trim($_REQUEST['searchTag']);
		$onPage = max(intval($_REQUEST['onPage']),1);
		$pageSize = 30;
		$filter = ' 1=1 ';
		if(!empty($searchTag)) {
			$filter .= " AND title LIKE ('%$searchTag%')";
		}
		$noticeList = $adminModel->getSystemNoticeList($onPage,$pageSize,$filter);

		$goToUrl = "index.php?controller=system&action=systemNotice&searchTag=$searchTag";
		$this->Views->assign('searchTag',$searchTag);
		$this->Views->assign('noticeList',$noticeList['list']);
		$this->Views->assign('pageList',$this->pagelist($noticeList['count'],$pageSize,$goToUrl));
		$this->Views->display('noticeList.html');
	}

	public function createNotice()
	{
		$adminModel = new adminModel();
		$aType = trim($_REQUEST['aType']);
		$notice = $_POST['notice'];

		if ($aType=='createNotice') {
			if ( $adminModel->createNotice($notice) ) {
				$this->Alert('添加公告成功','index.php?controller=system&action=systemNotice');
			}else{
				$this->Alert('添加广告失败');
			}
		}
		$this->Views->assign('time',date('Y-m-d H:i:s',time()));
		$this->Views->display('createNotice.html');
	}

	public function noticeModify()
	{
		$adminModel = new adminModel();
		$id = intval($_REQUEST['id']);
		$aType = trim($_REQUEST['aType']);
		$notice = $_POST['notice'];

		if ($aType=='noticeModify')
		{
			if ( $adminModel->setNoticeField($notice) ) {
				$this->Alert('修改公告成功','index.php?controller=system&action=systemNotice');
			}else{
				$this->Alert('修改广告失败');
			}
		}else{
			$noticeInfo = $adminModel->getNoticeDetailById($id);
			$this->Views->assign('noticeInfo',$noticeInfo);
		}
		$this->Views->display('noticeModify.html');
	}

	public function operationLogListAction(){
		$adminModel = new adminModel();
		$searchTag = trim($_REQUEST['searchTag']);
		$module = trim($_REQUEST['module']);
		$table = trim($_REQUEST['table']);
		$type = trim($_REQUEST['type']);
		$onPage = max(intval($_REQUEST['onPage']),1);
		$pageSize = 30;
		$filter = ' 1=1 ';
		if(!empty($searchTag)) 
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

		$logList = $adminModel->getLogList($onPage,$pageSize,$filter);

		$modules = $adminModel->getLogModule();
		$goToUrl = "index.php?controller=system&action=operationLogList&searchTag=$searchTag&module=$module&table=$table&type=$type";

		$this->Views->assign('modules',$modules);
		$this->Views->assign('module',$module);
		$this->Views->assign('table',$table);
		$this->Views->assign('type',$type);
		$this->Views->assign('searchTag',$searchTag);
		$this->Views->assign('logList',$logList['list']);
		$this->Views->assign('pageList',$this->pagelist($logList['count'],$pageSize,$goToUrl));
		$this->Views->display('logList.html');
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