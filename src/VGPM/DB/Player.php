<?php
namespace VGPM\DB;

use VGPM\Lib\DB;

class Player extends DB {
	protected $_name    = 'player';
	protected $_primary = 'id';


	public function totalByReg($date, $sid) {
		$sql  = sprintf('SELECT COUNT(*) FROM %s where `date`=\'%s\' AND `server_id`=%s', $this->_name, $date, $sid);
		return $this->fetchCloum($sql, 0);
	}

	public function totalByLogin($date, $sid) {
		$sql  = sprintf('SELECT COUNT(*) FROM %s where `date`=\'%s\' AND `server_id`=%s', $this->_name, $date, $sid);
		return $this->fetchCloum($sql, 0);
	}

	public function newUser($date,$sid) {
		$sql  = sprintf('SELECT `id` FROM %s where `date`=\'%s\' AND `server_id`=%s GROUP BY id', $this->_name,$date, $sid);
		$list = $this->fetchAll($sql);
		$ret = [];
		foreach($list as $val) {
			$ret[] = $val['id'];
		}
		return $ret;
	}
}

?>