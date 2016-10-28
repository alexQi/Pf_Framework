<?php
if (!defined('Perfect')) exit('Blocking access to this script');

class AdvertModel extends Model {

	public function getUserInfoByName($username){
		$sql = "SELECT * FROM `{$this->CTable('admins')}` WHERE user_account='$username' LIMIT 1";
		return $this->Db->fetch($sql);
	}

	public function getMemberDetailById($admin_id){
		$sql = "SELECT * FROM `{$this->CTable('admins')}` WHERE admin_id=$admin_id LIMIT 1";
		return $this->Db->fetch($sql);
	}

	public function getAdvertList($onPage=1,$pageSize=20,$filter) {
		$offSet = $pageSize*($onPage-1);
		$sql = "SELECT AD.`advert_id`,AD.`advert_master_id`,ADT.`user_name`,AD.`shift_id`,AD.`advert_name`,ADT.`admin_id`,AD.`advert_type`,AD.`platform`,AD.`charge_point`,AD.`advert_price`,AD.`intraday_amount`,AD.`total_amount`,AD.`is_arrived`,AD.`status`,ADM.`true_name`,`ADDR`.`hours`,ADMTL.*
			FROM `{$this->CTable('advert')}` AS AD
			LEFT JOIN `{$this->CTable('advert_master')}` AS ADT ON `AD`.`advert_master_id`=`ADT`.`advert_master_id`
			LEFT JOIN `{$this->CTable('admins')}` AS ADM ON `ADT`.`admin_id`=`ADM`.`admin_id`
			LEFT JOIN `{$this->CTable('advert_direct')}` AS ADDR ON `ADDR`.`advert_id`=`AD`.`advert_id`
			LEFT JOIN `{$this->CTable('advert_material')}` AS ADMTL ON `ADMTL`.`advert_id`=`AD`.`advert_id`
			WHERE $filter 
			LIMIT $offSet,$pageSize";
		$sqls = "SELECT count(*) as count
			FROM `{$this->CTable('advert')}` AS AD
			LEFT JOIN `{$this->CTable('advert_master')}` AS ADT ON `AD`.`advert_master_id`=`ADT`.`advert_master_id`
			LEFT JOIN `{$this->CTable('admins')}` AS ADM ON `ADT`.`admin_id`=`ADM`.`admin_id`
			LEFT JOIN `{$this->CTable('advert_direct')}` AS ADDR ON `ADDR`.`advert_id`=`AD`.`advert_id`
			LEFT JOIN `{$this->CTable('advert_material')}` AS ADMTL ON `ADMTL`.`advert_id`=`AD`.`advert_id`
			WHERE $filter";

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
		$sql = "INSERT INTO `{$this->CTable('admins')}` SET $parme";
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
		$sql = "UPDATE `{$this->CTable('admins')}`
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
			FROM `{$this->CTable('operation_log')}` OL
			LEFT JOIN `{$this->CTable('admins')}` AM ON OL.`admin_id`=AM.`admin_id`
			WHERE $filter
			LIMIT $offSet,$pageSize";
		$sqls = "SELECT count(*) as count
			 FROM `{$this->CTable('operation_log')}` OL
			 LEFT JOIN `{$this->CTable('admins')}` AM ON OL.`admin_id`=AM.`admin_id`
			 WHERE $filter";
		$countLine = $this->Db->fetch($sqls);
		$allLine = $this->Db->fetchAll($sql);
		unset($onPage,$pageSize,$filter,$offSet,$sql,$sqls);
		return array('list'=>$allLine,'count'=>$countLine['count']);
	}

	public function getLogModule(){
		$sql = "SELECT `module` FROM `{$this->CTable('operation_log')}` GROUP BY `module`";
		return $this->Db->fetchAll($sql);
	}

	public function getLogTables($module){
		$sql = "SELECT `table` FROM `{$this->CTable('operation_log')}` WHERE `module`='$module' GROUP BY `table`";
		return $this->Db->fetchAll($sql);
	}
	
	public function getLogTableType($table){
		$sql = "SELECT type FROM `{$this->CTable('operation_log')}` WHERE `table`='$table' GROUP BY type";
		return $this->Db->fetchAll($sql);
	}

}




?>