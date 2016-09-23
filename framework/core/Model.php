<?php
if (!defined('Perfect')) exit('Blocking access to this script');
/**
 * 基础模型类
 */
class Model {

	protected $Db;
	protected $config;
	public $Perfect;

	public function __construct() {
		global $Perfect;
		$this->Perfect = $Perfect;
		$this->config = $this->Perfect->config['database'];
		$this->Db = $this->Perfect->db;
	}

	public function __destruct(){
		if ($this->Db->errorMessage!='') {
			$this->Perfect->Pf_Exception->init($this->Db->errorMessage);
		}
	}
}