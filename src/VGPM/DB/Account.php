<?php
namespace VGPM\DB;

use VGPM\Lib\DB;

class Account extends DB {
	protected $_name    = 'accounts';
	protected $_primary = 'id';


	public function totalByReg($date, $sid) {
		$sql  = sprintf('SELECT COUNT(*) FROM %s where FROM_UNIXTIME(created_at,\'%s\')=\'%s\' AND `server_id`=%s', $this->_name,'%Y%m%d', $date, $sid);
		return $this->fetchCloum($sql, 0);
	}

	public function totalByLogin($date, $sid) {
		$sql  = sprintf('SELECT COUNT(*) FROM %s where  FROM_UNIXTIME(created_at,\'%s\')=\'%s\' AND `server_id`=%s', $this->_name, '%Y%m%d', $date, $sid);
		return $this->fetchCloum($sql, 0);
	}

	public function newUser($date,$sid) {
		$sql  = sprintf('SELECT `player_id` FROM %s where FROM_UNIXTIME(created_at,\'%s\')=\'%s\' AND `server_id`=%s GROUP BY player_id', $this->_name,'%Y%m%d', $date, $sid);
		$list = $this->fetchAll($sql);
		$ret = [];
		foreach($list as $val) {
			$ret[] = $val['player_id'];
		}
		return $ret;
	}
}

?>