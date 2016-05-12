<?php
namespace VGPM\DB;

use VGPM\Lib\DB;

class LogOnline extends DB {

	protected $_name    = 'log_online';
	protected $_primary = 'id';


	public function listByHour($params) {
		$where = $this->sqlWhere($params);
		$sql   = sprintf('SELECT `date`,`hour`, SUM(num) as num FROM  %s where %s group by `hour` order by `hour` asc', $this->_name, $where);
		$list  = $this->fetchAll($sql);
		return $list;
	}

	public function totalByHour($params) {
		$where = $this->sqlWhere($params);
		$sql   = sprintf('SELECT COUNT(DISTINCT `hour`) FROM %s where %s', $this->_name, $where);
		return $this->fetchCloum($sql, 0);
	}

	public function listByDate($start, $limit, $params) {
		$where = $this->sqlWhere($params);
		$sql   = sprintf('SELECT `date`, avg(num) as `avg`, max(num) as `max` FROM %s where %s group by `date` order by `date` desc LIMIT %s,%s', $this->_name, $where, $start, $limit);
		$list  = $this->fetchAll($sql);
		return $list;
	}

	public function totalByDate($params) {
		$where = $this->sqlWhere($params);
		$sql   = sprintf('SELECT COUNT(DISTINCT `date`) FROM %s where %s', $this->_name,$where);
		return $this->fetchCloum($sql, 0);
	}


	public function topByDate($date,$sid) {
		$sql   = sprintf('SELECT MAX(`num`) FROM %s WHERE `date`=%s AND `server_id`=%s', $this->_name,$date,$sid);
		return $this->fetchCloum($sql, 0);
	}

	public function avgByDate($date,$sid) {
		$sql   = sprintf('SELECT AVG(`num`) FROM %s WHERE `date`=%s AND `server_id`=%s', $this->_name,$date,$sid);
		return $this->fetchCloum($sql, 0);
	}
}

?>