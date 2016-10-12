<?php
if (!defined('Perfect')) exit('Blocking access to this script');

class adminModel extends Model {

	const table = 'pf_admins';

	public function getUserInfoByName($username){
		$sql = "SELECT * FROM ".self::table." WHERE user_account='$username' LIMIT 1";
		return $this->Db->fetch($sql);
	}

	public function getMemberDetailById($admin_id){
		$sql = "SELECT * FROM ".self::table." WHERE admin_id=$admin_id LIMIT 1";
		return $this->Db->fetch($sql);
	}

	public function setLoginRecord($intoData) {
		try {
			$this->Db->beginTransaction();

			$sql = "UPDATE ".self::table."
				SET `login_count`=login_count+1,last_time='{$intoData["time"]}'
				WHERE `admin_id` = {$intoData['admin_id']}
				LIMIT 1 ";
			$rs = $this->Db->exec($sql);
			$parme = '';
			$tmp = array();
			foreach($intoData as $key => $value){
				$tmp[] = "`".$key."`='".$value."'";
			}
			$parme = join(",",$tmp);
			$sqls = "INSERT INTO pf_admin_login_log SET $parme ";
			$rss = $this->Db->query($sqls);
			if(!$rs && $rss){
				throw new Pf_Exception("数据库日志记录失败");
			}
			$this->Db->commit();
			return true;
		} catch (Pf_Exception $e) {
			$this->Db->rollBack();
			return false;
		}
	}

	public function getMemberList($onPage=1,$pageSize=20,$filter) {
		$offSet = $pageSize*($onPage-1);
		$sql = "SELECT *
			FROM ".self::table."
			WHERE user_role>=0 $filter 
			LIMIT $offSet,$pageSize ";

		$sqls = "SELECT count(*) as count
			 FROM ".self::table."
			 WHERE user_role>=0 $filter";

		$countLine = $this->Db->fetch($sqls);
		$allLine = $this->Db->fetchAll($sql);
		return array('list'=>$allLine,'count'=>$countLine['count']);
	}

	public function createMember($intoData){
		$parme ='';
		foreach($intoData as $key => $value){
			$tmp[] ="`$key`='{$value}'";
		}
		$parme = join(',',$tmp);
		$sql = "INSERT INTO ".self::table." SET $parme";
		unset($intoData,$parme,$tmp,$key,$value);
		return $this->Db->query($sql);
	}

	public function setAdminField($intoData){
		$parme = '';
		$tmp = array();
		foreach($intoData as $key => $value){
			if($key!='admin_id'){
				$tmp[] = "`".$key."`='".$value."'";
			}
		}
		$parme = join(",",$tmp);
		$sql = "UPDATE ".self::table."
			SET $parme
			WHERE `admin_id` = {$intoData['admin_id']}
			LIMIT 1 ";
		unset($intoData,$parme,$tmp,$key,$value);
		return $this->Db->query($sql);
	}

	public function getAdminSickLog($logFile,$sort) {
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

	public function getOperationLogs($onPage=1,$pageSize=20,$filter) {
		$offSet = $pageSize*($onPage-1);
		$sql = "SELECT *
			FROM pf_operation_log OL
			LEFT JOIN ".self::table." AM ON OL.`admin_id`=AM.`admin_id`
			WHERE $filter
			LIMIT $offSet,$pageSize";
		$sqls = "SELECT count(*) as count
			 FROM pf_operation_log OL
			 LEFT JOIN ".self::table." AM ON OL.`admin_id`=AM.`admin_id`
			 WHERE $filter";
		$countLine = $this->Db->fetch($sqls);
		$allLine = $this->Db->fetchAll($sql);
		unset($onPage,$pageSize,$filter,$offSet,$sql,$sqls);
		return array('list'=>$allLine,'count'=>$countLine['count']);
	}

	public function getLogModule(){
		$sql = "SELECT `module` FROM pf_operation_log GROUP BY `module`";
		return $this->Db->fetchAll($sql);
	}

	public function getLogTables($module){
		$sql = "SELECT `table` FROM pf_operation_log WHERE `module`='$module' GROUP BY `table`";
		return $this->Db->fetchAll($sql);
	}
	
	public function getLogTableType($table){
		$sql = "SELECT type FROM pf_operation_log WHERE `table`='$table' GROUP BY type";
		return $this->Db->fetchAll($sql);
	}

}




?>