<?php
if (!defined('Perfect')) exit('Blocking access to this script');
/**
 * 操作MYSQL的工具类
 * 基于 mysql_pdo扩展
 */
class Mysql {

	public $DB;
	public $errorMessage;
	private static $instance;

	/**
	 * 构造方法
	 * @access private
	 *
	 * @param $DbConfig关联数组
	 *
	 */
	private function __construct($DbConfig) {
		$this->connectDB($DbConfig);
	}

	private function __clone() {
	}
	
	/**
	 * 单例模式实例化数据库驱动
	 */
	public static function getInstance($DbConfig=array()) {
		if (!(self::$instance instanceof self)) {
			self::$instance = new self($DbConfig);
		}
		return self::$instance;
	}

	private function connectDB($DbHost){
		$DB = new PDO("mysql:host=".$DbHost['host'].";port=".$DbHost['port'].";dbname=".$DbHost['db'],$DbHost['username'],$DbHost['password'],array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		$DB->exec("set names ".$DbHost['charset']);
		return $this->DB = $DB;
	}

	private static function fetchType(){
		return array(
			'ass' => PDO::FETCH_ASSOC,
			'num' => PDO::FETCH_NUM,
			'obj' => PDO::FETCH_OBJ,
			'both' => PDO::FETCH_BOTH,
			'column' => PDO::FETCH_COLUMN,
		);
	}

	public function exec($sql) {
		try {
			$result = $this->DB->exec($sql);
		}catch (PDOException $e){
			$this->errorMessage = '<strong>SQL执行失败<strong>';
			$this->errorMessage .= '<br /><strong>错误的信息是 : <strong>'.$e->getMessage();
			$this->errorMessage .= '<br /><strong>错误的语句是 : <strong>'.$sql;
			exit();
		}
		return $result;
	}

	public function query($sql) {
		try {
			$result = $this->DB->query($sql);
		}catch (PDOException $e){
			$this->errorMessage = '<strong>SQL执行失败<strong>';
			$this->errorMessage .= '<br /><strong>错误的信息是 : <strong>'.$e->getMessage();
			$this->errorMessage .= '<br /><strong>错误的语句是 : <strong>'.$sql;
			exit();
		}
		return $result;
	}

	public function fetchAll($sql, $fetch_type='ass') {
		$fetch_funcs = self::fetchType();

		if (!isset($fetch_funcs[$fetch_type])) 
		{
			$fetch_type = 'ass';
		}

		$fetch_func = $fetch_funcs[$fetch_type];
		$result = self::query($sql);
		$List = $result->fetchAll($fetch_func);
		return $List;
	}

	public function fetch($sql, $fetch_type='ass') {
		$fetch_funcs = self::fetchType();

		if (!isset($fetch_funcs[$fetch_type])) 
		{
			$fetch_type = 'ass';
		}

		$fetch_func = $fetch_funcs[$fetch_type];

		$result = self::query($sql);
		$row = $result->fetch($fetch_func);
		return $row;
	}
}