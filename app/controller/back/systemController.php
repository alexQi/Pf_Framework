<?php
if (!defined('Perfect')) exit('Blocking access to this script');

/**
 * 系统用户控制器
 */
class SystemController extends baseController
{
	function systemMemberManageAction() {
		$systemModel = new SystemModel();
		$searchTag = trim($_REQUEST['searchTag']);
		$onPage = max(intval($_REQUEST['onPage']),1);
		$pageSize = 30;
		$filter = '';
		if(!empty($searchTag)) {
			$filter .= " AND user_account LIKE ('%$searchTag%')";
		}
		$filter .= " ORDER BY is_closed,admin_id ASC";
		$accountList = $systemModel->getManageMemberList($onPage,$pageSize,$filter);
		foreach($accountList['list'] as $key => $value){
			$accountList['list'][$key]['user_role'] = $value['user_role'];
			$accountList['list'][$key]['role_type'] = $value['role_type'];
			$accountList['list'][$key]['user_role_tag'] = $this->CONFIG['systemGroup'][$value['user_role']];
			$accountList['list'][$key]['role_type_tag'] = $this->CONFIG['systemUserRole'][$value['role_type']];
			$accountList['list'][$key]['is_closed_tag'] = $this->CONFIG['systemAccountStatus'][$value['is_closed']];
		}
		$goToUrl = "index.php?controller=system&action=systemMemberManage&searchTag=$searchTag";
		$this->Views->assign('searchTag',$searchTag);
		$this->Views->assign('activeRole',$_SESSION[FEELINGS]['userRole']);
		$this->Views->assign('activeManager',$_SESSION[FEELINGS]['userId']);
		$this->Views->assign('activeRoleType',$_SESSION[FEELINGS]['roleType']);
		$this->Views->assign('accountList',$accountList['list']);
		$this->Views->assign('pageList',$this->pagelist($accountList['count'],$pageSize,$goToUrl));
		$this->Views->display('manager_list.html');
	}

	function systemDealAction(){
		$systemModel = new SystemModel();
		$dType = trim($_REQUEST['dType']);
		if($dType=='systemCreateManager'){
			$this->systemCreateManager(microtime());
			exit;
		}elseif($dType=='systemModifyManager'){
			$this->systemManagerModify(microtime());
			exit;
		}elseif($dType=='systemLockManager'){
			$intoData['admin_id'] = intval($_REQUEST['accountId']);
			$intoData['is_closed'] = 1;
			if($systemModel->setManagerField($intoData)){
				$this->Alert('²Ù×÷³É¹¦!');
			}else{
				$this->Alert('²Ù×÷Ê§°Ü!');
			}
		}elseif($dType=='systemUnLockManager'){
			$intoData['admin_id'] = intval($_REQUEST['accountId']);
			$intoData['is_closed'] = 0;
			if($systemModel->setManagerField($intoData)){
				$this->Alert('²Ù×÷³É¹¦!');
			}else{
				$this->Alert('²Ù×÷Ê§°Ü!');
			}
		}elseif($dType=='systemSickManageLog'){

			$this->systemAccountManageLogSick(microtime());

		}elseif($dType=='createNotice'){

			$this->createNotice(microtime());

		}elseif($dType=='noticeModify'){

			$this->noticeModify(microtime());

		}elseif($dType=='deleteNotice'){

			$id = intval($_REQUEST['id']);
			if($systemModel->deleteNotice($id)){
				$this->Alert('É¾³ý³É¹¦!');
			}else{
				$this->Alert('É¾³ýÊ§°Ü!');
			}
		}else{
			exit('·Ç·¨²Ù×÷£¡');
		}
	}

	function systemCreateManager($token){
		if(empty($token)) exit('·Ç·¨²Ù×÷£¡');
		$aType = trim($_REQUEST['aType']);
		if($aType=='createSystemManager'){
			$systemModel = new SystemModel();
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
				$this->Alert('±ØÐëÉèÖÃÈ¨ÏÞ!');
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
					$this->Alert('·Ç·¨²Ù×÷!');
					exit;
				}
			}else{
				$intoData['user_touch'] = $userTouch;
			}
			if($systemModel->createManagerMamber($intoData)){
				$this->Alert('ÕÊºÅ´´½¨³É¹¦!');
			}else{
				$this->Alert('ÕÊºÅ´´½¨Ê§°Ü!');
			}
			exit;
		}
		$userGroup = array();
		$areaLimits = array();
		$exportMenu = array();
		$roleTypeSelect = array();
		foreach($this->CONFIG['systemGroup'] as $key => $value){
			array_push($userGroup,array('groupValue'=>$key,'groupName'=>$value));
		}

		foreach($this->CONFIG['province'] as $key => $value){
			array_push($areaLimits,array('value' =>$key,'title'=>$value));
		}

		foreach($this->CONFIG['systemUserRole'] as $key => $value){
			array_push($roleTypeSelect,array('value' =>$key,'title'=>$value));
		}
		foreach($this->Menu['MENU'] as $key => $value){
			$exportMenu[$key] = array('MENUK'=>$key,'MENU'=>$value,'MENUITEM'=>array());
			$exportMenu[$key]['MENUITEM'] = array();
			foreach($this->Menu['ITEM'] as $k => $v){
				if($key==$v['F']){
					$temp = array('DK'=>$k,'DV'=>$v['T']);
					if(!is_null($v['DTYPE'])){
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

		$this->Views->assign('exportMenu',$exportMenu);
		$this->Views->assign('userGroup',$userGroup);
		$this->Views->assign('roleTypeSelect',$roleTypeSelect);
		$this->Views->assign('areaLimits',$areaLimits);
		$this->Views->display('manager_create.html');
	}

	function systemManagerModify($token){
		if(empty($token)) exit('·Ç·¨²Ù×÷£¡');
		$aType = trim($_REQUEST['aType']);
		if($aType=='systemModifyManager'){
			$systemModel = new SystemModel();
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

			$viewPermissions = (array)$_POST['viewPermissions'];
			$operatingAuthority = (array)$_POST['operatingAuthority'];
			if(empty($viewPermissions)){
				$this->Alert('±ØÐëÉèÖÃÈ¨ÏÞ!');
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
						$this->Alert('·Ç·¨²Ù×÷!');
						exit;
					}
					$intoData['user_touch'] = $userTouch;
				}else{
					$this->Alert('·Ç·¨²Ù×÷!');
					exit;
				}
			}else{
				$intoData['user_touch'] = $userTouch;
			}
			if($systemModel->setManagerField($intoData)){
				$this->Alert('ÐÞ¸Ä³É¹¦!');
			}else{
				$this->Alert('ÐÞ¸ÄÊ§°Ü!');
			}
			exit;
		}
		$masterId = intval($_REQUEST['accountId']);
		$systemModel = new SystemModel();
		$accountInfo = $systemModel->getManagerDetailById($masterId);
		$userGroup = $areaLimits = $exportMenu = $allowArea = $roleTypeSelect = array();
		foreach($this->CONFIG['systemGroup'] as $key => $value){
			$selected = ($key==$accountInfo['user_role'])?'selected="selected"':'';
			array_push($userGroup,array('groupValue'=>$key,'tag'=>$selected,'groupName'=>$value));
		}

		foreach($this->CONFIG['province'] as $key => $value){
			$selected = in_array($key,explode('|',$accountInfo['area_limits']))?'checked="checked"':'';
			array_push($areaLimits,array('value' =>$key,'title'=>$value,'tag'=>$selected));
		}

		foreach($this->CONFIG['systemUserRole'] as $key => $value){
			$selected = ($key==$accountInfo['role_type'])?'selected="selected"':'';
			array_push($roleTypeSelect,array('value' =>$key,'title'=>$value,'tag'=>$selected));
		}

		foreach($this->Menu['MENU'] as $key => $value){
			$tempData = array('MENUK'=>$key,'MENU'=>$value,'MENUITEM'=>array());
			$tempData['MENUITEM'] = array();
			foreach($this->Menu['ITEM'] as $k => $v){
				if($key==$v['F']){
					$temp = array('DK'=>$k,'DV'=>$v['T']);
					if(!is_null($v['DTYPE'])){
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

		$this->Views->assign('accountInfo',$accountInfo);
		$this->Views->assign('exportMenu',$exportMenu);
		$this->Views->assign('userGroup',$userGroup);
		$this->Views->assign('roleTypeSelect',$roleTypeSelect);
		$this->Views->assign('areaLimits',$areaLimits);
		$this->Views->display('manager_modify.html');
	}

	function systemAccountManageLogSick($token){
		if(empty($token)) exit('·Ç·¨²Ù×÷£¡');
		$masterModel = new SystemModel();
		$onPage = max(intval($_REQUEST['onPage']),1);
		$pageSize = 18;
		$sortType = intval($_REQUEST['sortType']);
		$offSet = $pageSize*($onPage-1);
		$userName = trim($_REQUEST['userAccount']);
		if(!$_SESSION[FEELINGS]['systemDaddy']){
			if($userName!=$_SESSION[FEELINGS]['userAccount']){
				exit('·Ç·¨²Ù×÷£¡');
			}
		}
		$logDir = LOG_FOLDER.DS.$userName.DS;
		$sickDate = empty($_REQUEST['sickDate'])?date("Y-m"):$_REQUEST['sickDate'];
		foreach (glob($logDir."*.log") as $logFile) {
			$date = substr(substr($logFile,-11),0,7);
			$selected = ($sickDate==$date)?"selected":'';
			$logDateBox[] = array('date'=>$date,'tag'=>$selected);
		}
		$sortBox = array('1'=>'°´²Ù×÷Ê±¼äÓÉÔ¶¼°½ü','2'=>'°´²Ù×÷Ê±¼äÓÉ½ü¼°Ô¶');
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
		$masterModel = new SystemModel();
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
			$recordList['list'][$key]['user_role_tag'] = ($value['user_role']==-1)?'³õÊ¼ÕÊºÅ':$this->CONFIG['systemGroup'][$value['user_role']];
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
		$masterModel = new SystemModel();
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
		$masterModel = new SystemModel();
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
		$masterModel = new SystemModel();
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
		$sortBox = array('1'=>'°´²Ù×÷Ê±¼äÓÉÔ¶¼°½ü','2'=>'°´²Ù×÷Ê±¼äÓÉ½ü¼°Ô¶');
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
		$systemModel = new SystemModel();
		$searchTag = trim($_REQUEST['searchTag']);
		$onPage = max(intval($_REQUEST['onPage']),1);
		$pageSize = 30;
		$filter = ' 1=1 ';
		if(!empty($searchTag)) {
			$filter .= " AND title LIKE ('%$searchTag%')";
		}
		$noticeList = $systemModel->getSystemNoticeList($onPage,$pageSize,$filter);

		$goToUrl = "index.php?controller=system&action=systemNotice&searchTag=$searchTag";
		$this->Views->assign('searchTag',$searchTag);
		$this->Views->assign('noticeList',$noticeList['list']);
		$this->Views->assign('pageList',$this->pagelist($noticeList['count'],$pageSize,$goToUrl));
		$this->Views->display('noticeList.html');
	}

	public function createNotice()
	{
		$systemModel = new SystemModel();
		$aType = trim($_REQUEST['aType']);
		$notice = $_POST['notice'];

		if ($aType=='createNotice') {
			if ( $systemModel->createNotice($notice) ) {
				$this->Alert('Ìí¼Ó¹«¸æ³É¹¦','index.php?controller=system&action=systemNotice');
			}else{
				$this->Alert('Ìí¼Ó¹ã¸æÊ§°Ü');
			}
		}
		$this->Views->assign('time',date('Y-m-d H:i:s',time()));
		$this->Views->display('createNotice.html');
	}

	public function noticeModify()
	{
		$systemModel = new SystemModel();
		$id = intval($_REQUEST['id']);
		$aType = trim($_REQUEST['aType']);
		$notice = $_POST['notice'];

		if ($aType=='noticeModify')
		{
			if ( $systemModel->setNoticeField($notice) ) {
				$this->Alert('ÐÞ¸Ä¹«¸æ³É¹¦','index.php?controller=system&action=systemNotice');
			}else{
				$this->Alert('ÐÞ¸Ä¹ã¸æÊ§°Ü');
			}
		}else{
			$noticeInfo = $systemModel->getNoticeDetailById($id);
			$this->Views->assign('noticeInfo',$noticeInfo);
		}
		$this->Views->display('noticeModify.html');
	}

	public function operationLogListAction(){
		$systemModel = new SystemModel();
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

		$logList = $systemModel->getLogList($onPage,$pageSize,$filter);

		$modules = $systemModel->getLogModule();
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
		$systemModel = new SystemModel();
		$module = trim($_REQUEST['module']);
		$html = "<option value=''>È«²¿Êý¾Ý±í</option>";
		if ($module) 
		{
			$tables = $systemModel->getLogTables($module);
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
		$systemModel = new SystemModel();
		$table = trim($_REQUEST['table']);
		$html = "<option value=''>È«²¿²Ù×÷</option>";
		if ($table) 
		{
			$types = $systemModel->getLogTableType($table);
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