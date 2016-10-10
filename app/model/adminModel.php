<?php
if (!defined('Perfect')) exit('Blocking access to this script');

class adminModel extends Model {

	public function getUserInfoByName($username){
		$sql = "SELECT * FROM pf_admins WHERE user_account='$username'";
		return $this->Db->fetch($sql);
	}

	public function setLoginRecord($intoData) {
		try {
			$this->Db->beginTransaction();

			$sql = "UPDATE pf_admins
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

	function getMemberList($onPage=1,$pageSize=20,$filter) {
		$offSet = $pageSize*($onPage-1);
		$sql = "SELECT *
			FROM pf_admins
			WHERE user_role>=0 $filter 
			LIMIT $offSet,$pageSize ";

		$sqls = "SELECT count(*) as count
			 FROM pf_admins
			 WHERE user_role>=0 $filter";

		$countLine = $this->Db->fetch($sqls);
		$allLine = $this->Db->fetchAll($sql);
		return array('list'=>$allLine,'count'=>$countLine['count']);
	}


}




?>