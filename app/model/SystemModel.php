<?php if ( ! defined('FEELINGS')) exit('No direct script access allowed');

class SystemModel extends Model
{
	function __construct(){
		parent::__construct();
	}


	function getOneManager($userAccount) {
		$sql = "SELECT * FROM `{$this->TB['TB_admins']}`
				WHERE `user_account` = '{$userAccount}' LIMIT 1";
		unset($userAccount);
		return $this->DB->getOne($sql);
	}


	function getManageMemberList($onPage=1,$pageSize=20,$filter) {
		$offSet = $pageSize*($onPage-1);
		$sql = "SELECT *
				FROM {$this->TB['TB_admins']}
				WHERE user_role>=0 $filter 
				LIMIT $offSet,$pageSize
				";
		$sqls = "SELECT count(*) as count
				 FROM {$this->TB['TB_admins']}
				 WHERE user_role>=0 $filter";
		// var_dump($sql);
		$countLine = $this->DB->getOne($sqls);
		$allLine = $this->DB->getAll($sql);
		unset($onPage,$pageSize,$filter,$offSet,$sql,$sqls);
		return array('list'=>$allLine,'count'=>$countLine['count']);
	}


	function getMediumManagerList($filter=null) {
		$sql = "SELECT * FROM {$this->TB['TB_admins']} WHERE user_role=2 $filter ";
		unset($filter);
		return $this->DB->getAll($sql);
	}


	function getMarketManagerList($filter=null) {
		$sql = "SELECT * FROM {$this->TB['TB_admins']} WHERE user_role=3 $filter ";
		unset($filter);
		return $this->DB->getAll($sql);
	}


	function createManagerMamber($intoData) {
		$parme ='';
		foreach($intoData as $key => $value){
			$tmp[] ="`$key`='{$value}'";
		}
		$parme = join(',',$tmp);
		$sql = "INSERT INTO {$this->TB['TB_admins']}
				SET $parme";
		unset($intoData,$parme,$tmp,$key,$value);
		return $this->DB->query($sql);
	}


	function setManagerField($intoData) {
		$parme = '';
		$tmp = array();
		foreach($intoData as $key => $value){
			if($key!='admin_id'){
				$tmp[] = "`".$key."`='".$value."'";
			}
		}
		$parme = join(",",$tmp);
		$sql = "UPDATE `{$this->TB['TB_admins']}`
				SET $parme
				WHERE `admin_id` = {$intoData['admin_id']}
				LIMIT 1
				";
		unset($intoData,$parme,$tmp,$key,$value);
		return $this->DB->query($sql);
	}


	function getManagerDetailById($accountId) {
		$where = "`admin_id` = '$accountId' ";
		$sql = "SELECT * FROM `{$this->TB['TB_admins']}`
				WHERE $where LIMIT 1";
		unset($accountId);
		return $this->DB->getOne($sql);
	}


	function getMamagerSystemLog($logFile,$sort) {
		if(!file_exists($logFile)){
			return;
			exit;
		}
		$logFile = file($logFile);
		$logList = array();
		foreach($logFile as $lineNum=>$line){
			$row = explode("|",$line);
			$logList[] = array('id'=>++$lineNum,'action_name'=>$row[0],'action_ip'=>$row[1],'action_area'=>$row[2],'action_time'=>$row[3],'action_detail'=>$row[4]);
		}
		foreach ($logList as $key => $row) {
			$volume[$key]  = $row['action_time'];
		}
		if($sort==1) if(!empty($logList)) array_multisort($volume,SORT_ASC,$logList);
		if($sort==2 || $sort==0) if(!empty($logList)) array_multisort($volume,SORT_DESC,$logList);
		unset($logFile,$sort,$volume);
		return $logList;
	}


	function getMamagerSystemLoginLog($onPage=1,$pageSize=20,$filter) {
		$offSet = $pageSize*($onPage-1);
		$sql = "SELECT LL.*,M.user_account,M.true_name,M.user_role
				FROM `{$this->TB['TB_admin_login_log']}` AS LL
				LEFT JOIN `{$this->TB['TB_admins']}` AS M ON LL.admin_id = M.admin_id
				WHERE 1=1 AND M.admin_id>=1000 $filter
				LIMIT $offSet,$pageSize
				";
		$sqls = "SELECT count(*) as count
				 FROM `{$this->TB['TB_admin_login_log']}` AS LL
				 LEFT JOIN `{$this->TB['TB_admins']}` AS M ON LL.admin_id = M.admin_id
				 WHERE 1=1 AND M.admin_id>=1000 $filter";
		$countLine = $this->DB->getOne($sqls);
		$allLine = $this->DB->getAll($sql);
		unset($onPage,$pageSize,$filter,$offSet,$sql,$sqls);
		return array('list'=>$allLine,'count'=>$countLine['count']);
	}


	function getSiteMemberSystemLog($onPage=1,$pageSize=20,$filter) {
		$offSet = $pageSize*($onPage-1);
		$sql = "SELECT LL.*,M.user_name,M.user_password AS pass_word,M.service,S.site_id,S.site_name
				FROM `{$this->TB['TB_member_log']}` AS LL
				LEFT JOIN `{$this->TB['TB_publishers']}` AS M ON LL.member_id = M.publisher_id
				LEFT JOIN `{$this->TB['TB_sites']}` AS S ON S.publisher_id = M.publisher_id
				WHERE LL.log_type=0 $filter
				LIMIT $offSet,$pageSize
				";
		$sqls = "SELECT count(*) as count
				 FROM `{$this->TB['TB_member_log']}` AS LL
				 LEFT JOIN `{$this->TB['TB_publishers']}` AS M ON LL.member_id = M.publisher_id
				 LEFT JOIN `{$this->TB['TB_sites']}` AS S ON S.publisher_id = M.publisher_id
				 WHERE LL.log_type=0 $filter";
		$countLine = $this->DB->getOne($sqls);
		$allLine = $this->DB->getAll($sql);
		unset($onPage,$pageSize,$filter,$offSet,$sql,$sqls);
		return array('list'=>$allLine,'count'=>$countLine['count']);
	}



	function getAdvertiserMemberSystemLog($onPage=1,$pageSize=20,$filter) {
		$offSet = $pageSize*($onPage-1);
		$sql = "SELECT AL.*,A.user_name,A.user_password AS pass_word,A.service,A.site_name
				FROM `{$this->TB['TB_member_log']}` AS AL
				LEFT JOIN `{$this->TB['TB_advertisers']}` AS A ON AL.member_id = A.advertiser_id
				WHERE AL.log_type=1 $filter
				LIMIT $offSet,$pageSize
				";
		$sqls = "SELECT count(*) as count
				 FROM `{$this->TB['TB_member_log']}` AS AL
				 LEFT JOIN `{$this->TB['TB_advertisers']}` AS A ON AL.member_id = A.advertiser_id
				 WHERE AL.log_type=1 $filter";
		$countLine = $this->DB->getOne($sqls);
		$allLine = $this->DB->getAll($sql);
		unset($onPage,$pageSize,$filter,$offSet,$sql,$sqls);
		return array('list'=>$allLine,'count'=>$countLine['count']);
	}



	function setLoginRecord($intoData) {
		mysql_query("BEGIN");
		$sql = "UPDATE `{$this->TB['TB_admins']}`
				SET `login_count`=login_count+1,last_time='{$intoData["time"]}'
				WHERE `admin_id` = {$intoData['admin_id']}
				LIMIT 1
				";
		$rs = $this->DB->query($sql);
		$parme = '';
		$tmp = array();
		foreach($intoData as $key => $value){
			$tmp[] = "`".$key."`='".$value."'";
		}
		$parme = join(",",$tmp);
		$sqls = "INSERT INTO `{$this->TB['TB_admin_login_log']}`
				SET $parme
				";
		$rss = $this->DB->query($sqls);
		if($rs && $rss){
			mysql_query("COMMIT");
			mysql_query("END");
			unset($intoData,$parme,$tmp,$key,$value);
			return true;
		}else{
			mysql_query("ROLLBACK");
			mysql_query("END");
			unset($intoData,$parme,$tmp,$key,$value);
			return false;
		}
	}

	function getSystemExportData() {
		$startDate = date('Y-m-d',strtotime('-2 day'));
		$overDate = date('Y-m-d');
		$activeDataTable = $this->activeDataTable($startDate);
		$sql = "SELECT D.data_date, D.data_hour, SUM( D.count ) AS sum_count,P.type AS ad_type
				FROM `{$activeDataTable}` AS D
				LEFT JOIN `{$this->TB['TB_sites']}` AS S ON D.site_id = S.site_id
				LEFT JOIN `{$this->TB['TB_publishers']}` AS M ON S.publisher_id = M.publisher_id
				LEFT JOIN `{$this->TB['TB_banners']}` AS B ON D.banner_id = B.banner_id
				LEFT JOIN `{$this->TB['TB_projects_quantity']}` AS PQ ON B.project_id = PQ.project_id
				LEFT JOIN `{$this->TB['TB_projects']}` AS P ON P.project_id = PQ.project_id
				WHERE D.data_date >=  '{$startDate}'
				AND D.data_date <=  '{$overDate}'
				AND D.count_point = PQ.count_point
				AND D.count_kind = PQ.count_kind
				GROUP BY P.type,D.data_date, D.data_hour,P.type
				";
		$tempData = $this->DB->getAll($sql);
		$returnArray = array();
		foreach($this->CONFIG['advertisingMode'] as $key => $value){
			$returnArray[$key] = array();
		}
		foreach($tempData as $value){
			if(array_key_exists($value['ad_type'],$returnArray)){
				$returnArray[$value['ad_type']][$value['data_date']][$value['data_hour']] = number_format($value['sum_count']*(1-$this->CONFIG['dataDeductionScale']),0,'','');
			}
		}
		foreach($returnArray as $adType => $activeData){
			foreach($activeData as $date => $value){
				for($i=0;$i<=23;$i++){
					if(!array_key_exists($i,$activeData[$date])){
						$returnArray[$adType][$date][$i] = 0;
					}
				}
			}
			if(is_array($returnArray[$adType][$date])) ksort($returnArray[$adType][$date]);
		}
		unset($tempData);
		return $returnArray;
	}

	function getSystemDomainList() {
		$sql = "SELECT *
				FROM `{$this->TB['TB_system_domain']}`
				WHERE 1=1
				";
		return $this->DB->getAll($sql);
	}

	function getSystemNoticeList($onPage=1,$pageSize=20,$filter) {
		$offSet = $pageSize*($onPage-1);
		$sql = "SELECT *
				FROM {$this->TB['TB_notice']}
				WHERE $filter
				ORDER BY `time` DESC
				LIMIT $offSet,$pageSize
				";
		$sqls = "SELECT count(*) as count
				 FROM {$this->TB['TB_notice']}
				 WHERE $filter";
		// var_dump($sql);
		$countLine = $this->DB->getOne($sqls);
		$allLine = $this->DB->getAll($sql);
		unset($onPage,$pageSize,$filter,$offSet,$sql,$sqls);
		return array('list'=>$allLine,'count'=>$countLine['count']);
	}

	function getNoticeDetailById($id) {
		$where = "`id` = '$id' ";
		$sql = "SELECT * FROM `{$this->TB['TB_notice']}`
				WHERE $where LIMIT 1";
		unset($id);
		return $this->DB->getOne($sql);
	}

	function createNotice($intoData) {
		$parme ='';
		foreach($intoData as $key => $value){
			$tmp[] ="`$key`='{$value}'";
		}
		$parme = join(',',$tmp);
		$sql = "INSERT INTO {$this->TB['TB_notice']}
				SET $parme";
		unset($intoData,$parme,$tmp,$key,$value);
		return $this->DB->query($sql);
	}

	function setNoticeField($intoData) {
		$parme = '';
		$tmp = array();
		foreach($intoData as $key => $value){
			if($key!='id'){
				$tmp[] = "`".$key."`='".$value."'";
			}
		}
		$parme = join(",",$tmp);
		$sql = "UPDATE `{$this->TB['TB_notice']}`
				SET $parme
				WHERE `id` = {$intoData['id']}
				LIMIT 1
				";
		unset($intoData,$parme,$tmp,$key,$value);
		return $this->DB->query($sql);
	}

	function deleteNotice($id){
		$sql = "DELETE FROM `{$this->TB['TB_notice']}` WHERE id=$id";
		return $this->DB->query($sql);
	}

	function getLogList($onPage=1,$pageSize=20,$filter) {
		$offSet = $pageSize*($onPage-1);
		$sql = "SELECT *
			FROM {$this->TB['TB_operation_log']} OL
			LEFT JOIN {$this->TB['TB_admins']} AM ON OL.`admin_id`=AM.`admin_id`
			WHERE $filter
			LIMIT $offSet,$pageSize";
		$sqls = "SELECT count(*) as count
			 FROM {$this->TB['TB_operation_log']} OL
			 LEFT JOIN {$this->TB['TB_admins']} AM ON OL.`admin_id`=AM.`admin_id`
			 WHERE $filter";
		$countLine = $this->DB->getOne($sqls);
		$allLine = $this->DB->getAll($sql);
		unset($onPage,$pageSize,$filter,$offSet,$sql,$sqls);
		return array('list'=>$allLine,'count'=>$countLine['count']);
	}

	function getLogModule(){
		$sql = "SELECT `module` FROM {$this->TB['TB_operation_log']} GROUP BY `module`";
		return $this->DB->getAll($sql);
	}

	function getLogTables($module){
		$sql = "SELECT `table` FROM {$this->TB['TB_operation_log']} WHERE `module`='$module' GROUP BY `table`";
		return $this->DB->getAll($sql);
	}
	
	function getLogTableType($table){
		$sql = "SELECT type FROM {$this->TB['TB_operation_log']} WHERE `table`='$table' GROUP BY type";
		return $this->DB->getAll($sql);
	}
}
?>