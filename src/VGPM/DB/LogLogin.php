<?php
namespace VGPM\DB;

use VGPM\Lib\DB;

class LogLogin extends DB {
	protected $_name    = 'log_login';
	protected $_primary = 'id';


	public function totalByDate($date, $sid) {
		$sql = sprintf('SELECT COUNT(DISTINCT `player_id`) FROM %s WHERE `date`=%s AND 	`server_id`=%s', $this->_name, $date, $sid);
		return $this->fetchCloum($sql, 0);
	}


	public function totalKeepUser($date, $sid) {
		$sql  = sprintf('SELECT `player_id` FROM %s WHERE `date`=%s AND `server_id`=%s GROUP BY `player_id`', $this->_name, $date, $sid);
		$list = $this->fetchAll($sql);
		$ret  = [];
		foreach ($list as $val) {
			$ret[] = $val['player_id'];
		}
		return $ret;
	}

}

?>