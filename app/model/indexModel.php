<?php
class IndexModel extends Model {

	public function queryAll($onPage=1,$pageSize=20,$filter) {
		$offSet = $pageSize*($onPage-1);
		$sql = "select * from wap_admin_login_log where $filter limit $offSet,$pageSize";
		$cql = "select count(*) as num from wap_admin_login_log where $filter";

		$list = $this->Db->fetchAll($sql);
		$count = $this->Db->fetch($cql);
		return array('list'=>$list,'count'=>$count['num']);
	}

	public function addRow(){
		$sql = "insert into xxx (t) values(w)";
		$result = $this->Db->exec($sql);
		return $result;
	}

}




?>